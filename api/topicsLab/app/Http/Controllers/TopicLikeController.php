<?php

namespace App\Http\Controllers;

use App\Models\TopicLike;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user();


        $topic_like = new TopicLike;
        $topic_like->user()->associate($user);
        $topic_like->topic()->associate($request->id);
        $topic_like->save();

        return $topic_like;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function show(TopicLike $topicLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function edit(TopicLike $topicLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TopicLike $topicLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(TopicLike $topicLike)
    {
        //
    }
}
