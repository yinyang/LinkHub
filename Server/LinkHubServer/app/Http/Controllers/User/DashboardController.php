<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,Input,Auth,Redirect;
use App\PrivateTopic;
use App\PrivateLink;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $count_all = PrivateLink::count();
        $count_in_queue = PrivateLink::where('tags','')
            ->count()
            ;

        return view('user.dashboard')
            ->with('count_all',$count_all)
            ->with('count_in_queue',$count_in_queue)
            ;
    }

    public function organiseLink()
    {
        $count_all = PrivateLink::count();
        $queue_links = PrivateLink::where('tags','')
        ;
        $count_in_queue = $queue_links->count();
        $links_in_queue = $queue_links->take(5)->orderBy('id','asc')->get();
        $topics = PrivateTopic::all();

        $link_item = null;
        if($count_in_queue > 0){
            $link_item = $links_in_queue[0];
        }

        return view('user.organiselink')
            ->with('count_all',$count_all)
            ->with('count_in_queue',$count_in_queue)
            ->with('links_in_queue',$links_in_queue)
            ->with('topics',$topics)
            ->with('link_item',$link_item)
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
    public function store()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
