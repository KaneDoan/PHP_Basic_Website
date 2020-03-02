<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Message;
use DB;

class MessagesController extends Controller
{
           public function index()
           {
               $messages = message::orderBy('created_at','desc')->paginate(10);
               return view('messages.index')->with('messages', $messages);
           }

           /**
            * Show the form for creating a new resource.
            *
            * @return \Illuminate\Http\Response
            */
           public function create()
           {
               return view('messages.create');
           }

           /**
            * Store a newly created resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @return \Illuminate\Http\Response
            */
           public function store(Request $request)
           {
                $this->validate($request, [
                           'name' => 'required',
                           'email' => 'required',
                           'image' => 'image|nullable|max:1999'
                       ]);

                //Handle file upload
                if($request->hasFile('image')){
                    //Get filename with extension
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    //Get just extend
                    $extension = $request->file('image')->getClientOriginalExtension();
                    //File name to store
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    //Upload image
                    $path = $request->file('image')->storeAs('public/image',$fileNameToStore);
                }else{
                    $fileNameToStore = 'noimage.jpg';
                }

                       //Create new message
                       $message = new Message;
                       $message->name = $request->input('name');
                       $message->email = $request->input('email');
                       $message->message = $request->input('message');
                       //$message->user_id = auth()->user()->id();
                       $message->image = $fileNameToStore;
                       //Save message
                       $message->save();

                       //Redirect
                       return redirect('/messages')->with('success','Information Saved');
           }

           /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
           public function show($id)
           {
               $message = Message::find($id);
               return view('messages.show')->with('message', $message);
           }

           /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
           public function edit($id)
           {
               $message = Message::find($id);

               //Check if message exists before deleting
               if (!isset($message)){
                   return redirect('/messages')->with('error', 'No Message Found');
               }

               // Check for correct user
               if(auth()->user()->id !==$message->user_id){
                   return redirect('/messages')->with('error', 'Unauthorized Page');
               }

               return view('messages.edit')->with('message', $message);
           }

           /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
           public function update(Request $request, $id)
           {
               $this->validate($request, [
                   'name' => 'required',
                   'email' => 'required'
               ]);
               $message = message::find($id);
               // Handle File Upload
               if($request->hasFile('image')){
                   // Get filename with the extension
                   $filenameWithExt = $request->file('image')->getClientOriginalName();
                   // Get just filename
                   $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                   // Get just ext
                   $extension = $request->file('image')->getClientOriginalExtension();
                   // Filename to store
                   $fileNameToStore= $filename.'_'.time().'.'.$extension;
                   // Upload Image
                   $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
                   // Delete file if exists
                   Storage::delete('public/images/'.$message->image);
               }

               // Update message
               $message->title = $request->input('title');
               $message->body = $request->input('body');
               if($request->hasFile('image')){
                   $message->image = $fileNameToStore;
               }
               $message->save();

               return redirect('/messages')->with('success', 'message Updated');
           }

           /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
           public function destroy($id)
           {
               $message = Message::find($id);

               //Check if post exists before deleting
               if (!isset($message)){
                   return redirect('/posts')->with('error', 'No Post Found');
               }

               // Check for correct user
               if(auth()->user()->id !==$message->user_id){
                   return redirect('/posts')->with('error', 'Unauthorized Page');
               }

               if($message->image != 'noimage.jpg'){
                   // Delete Image
                   Storage::delete('public/image/'.$message->image);
               }

               $message->delete();
               return redirect('/messages')->with('success', 'Post Removed');
           }
}
