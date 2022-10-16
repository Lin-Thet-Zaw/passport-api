<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
class LikeApi extends Controller
{
    public function like(){
        $user_id = Auth::id();
        $feed_id = request()->feed_id;
        if(!$this->isLike($user_id,$feed_id)){
            $like = Like::create([
                'user_id'=>$user_id,
                'feed_id'=>$feed_id 
            ]);
    
            return response()->json([
                'status' => 200,
                'message' => 'succcess',
                'data' => $like
            ]);
        }

            return response()->json([
                'status'=>500,
                'message'=>'fail',
                'data'=>'already_like'
             ]);

    }

    public function isLike($user_id, $feed_id){
        $like = Like::where('user_id',$user_id)
                      ->where('feed_id',$feed_id)
                      ->count();

        if($like){
            return true;
        }
        return false;
    }

    public function dislike(){
        $like_id = request()->like_id;
        Like::where('id', $like_id)->delete();
        return response()->json([
            'status'=>200,
            'message'=>'success     ',
            'data'=>null
        ]);
    }
}
