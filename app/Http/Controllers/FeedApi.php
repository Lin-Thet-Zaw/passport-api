<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Feed;
use App\Models\Comment;
class FeedApi extends Controller
{


  public function feed(){
    $feed_validator =
    Validator::make(request()->all(),[
     'feed_id'=>'required',
 ]);

 if( $feed_validator->fails()){
  return response()->json([
      'message'=>'fail',
      'status'=>500,
      'data'=>$feed_validator->errors()
  ]);
 }
    $feeds = Feed::orderBy('id','DESC')->with('user')->paginate(10);

    return response()->json([
        'status'=>200,
        'message'=>'success',
        'data'=>$feeds
    ]);
  }

  public function create(){

    $feed_validator =
    Validator::make(request()->all(),[
        'description'=>'required',
        
    ]);

    if($feed_validator->fails()){
        return response()->json([
            'status'=>500,
            'message'=>'fail',
            'data'=>$feed_validator->errors()
        ]);
    }

   $feed = Feed::create([
       'description'=>request()->description,
       'user_id'=>Auth::id() 
    ]);
    return response()->json([
        'status'=>200,
        'message'=>'success',
        'data'=>$feed
    ]);
  }


  public function delete(){

  }

  /***************************************************
   *  Comment Method Start Here
   * *************************************************/

  public function createComment(){

    $com_validator =
       Validator::make(request()->all(),[
        'feed_id'=>'required',
        'comment'=>'required',
    ]);

    if( $com_validator->fails()){
     return response()->json([
         'message'=>'fail',
         'status'=>500,
         'data'=>$com_validator->errors()
     ]);
    }

    $user_id = Auth::id();
    $feed_id = request()->feed_id;
    $comment = request()->comment;


    $comment = Comment::create([
        'user_id'=>$user_id,
        'feed_id'=>$feed_id,
        'comment'=>$comment
    ]);

    return response()->json([
        'message'=>'success',
        'status'=>200,
        'data'=>$comment
    ]);
  }


  public function getComment(){
    $com_validator =
    Validator::make(request()->all(),[
     'feed_id'=>'required',
 ]);

 if( $com_validator->fails()){
  return response()->json([
      'message'=>'fail',
      'status'=>500,
      'data'=>$com_validator->errors()
  ]);
 }

        $feed_id = request()->feed_id;
        $comments = Feed::where('feed_id',$feed_id)->with('user')->paganate(10);
        return response()->json([
            'message' => 'succcess',
            'status' => 200,
            'data' => $comments
        ]);


}
  public function deleteComment(){

     $com_validator =
         Validator::make(request()->all(),[
        'comment_id'=>'required',
   ]);

    if( $com_validator->fails()){
       return response()->json([
       'message'=>'fail',
       'status'=>500,
       'data'=>$com_validator->errors()
   ]);
 }
    $comment_id = request()->comment_id;
    Comment::where('id', $comment_id)->delete();
    return response()->json([
        'message' => 'succcess',
        'status' => 200,
        'data' => null
    ]);
  }
}
