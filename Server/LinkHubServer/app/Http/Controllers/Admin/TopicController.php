<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Topic;
use Input,Redirect,Log;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $topics = Topic::simplePaginate(20);
        $topic_count = Topic::count();

        $page = Input::get('page');
        if(!isset($page)) $page = 1;

        return view('admin.topic')
            ->with('topics',$topics)
            ->with('topic_count',$topic_count)
            ->with('page',$page)
            ->with('keyword','')
            ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
        ]);

        $topic = new Topic();
        $topic->name = Input::get('name');
        if(! $topic->save()){
            return Redirect::back()->withErrors('保存出错');
        }

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $topic = Topic::find($id);
        $topic->name = Input::get('name');
        $topic->save();
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $topic = Topic::find($id);
        $topic->delete();
        return Redirect::back();
    }
}
