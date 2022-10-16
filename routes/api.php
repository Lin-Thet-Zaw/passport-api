<?php
use App\Http\Controllers\AuthApi;
use App\Http\Controllers\FeedApi;
use App\Http\Controllers\LikeApi;

Route::post('/register', [AuthApi::class, 'register']);
Route::post('/login', [AuthApi::class, 'login']);

Route::group(['middleware'=>'auth:api'], function(){

/****************************************************
 * Feed Route Start Here
 ***************************************************/
    Route::get('/feed', [FeedApi::class, 'feed']);
    Route::post('/feed/create', [FeedApi::class, 'create']);
    Route::delete('/feed/delete', [FeedApi::class, 'delete']);


/****************************************************
 * Comment Route Start Here
 ***************************************************/
    Route::get('/comment', [FeedApi::class, 'getComment']);
    Route::post('/comment/create', [FeedApi::class, 'createComment']);
    Route::post('/comment/delete', [FeedApi::class, 'deleteComment']);


/****************************************************
 * Like Route Start Here
 ***************************************************/

Route::post('like', [LikeApi::class, 'like']);
Route::post('dislike', [LikeApi::class, 'dislike']);
});

