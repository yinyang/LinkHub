<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth,DB,Input,Redirect,Log;
use App\PrivateLink;
use App\PrivateDataClick;

class LinkController extends Controller
{
    public function saveLink()
    {
        $req = json_decode(Input::getContent());
        $ssdb = \LinkSSDB::ssdbConn();
        $setName = \LinkSSDB::linkPrivateSetName();
        if($ssdb->hexists($setName,md5($req->url))->data){
            Log::info('link existed:'.$req->url.' - '.$setName.' # ');
            return response()->json(['result'=>'ok','msg'=>'已存在']);
        }

        $link = new PrivateLink();
        $link->user_id = Auth::user()->id;
        $link->type = 0;
        $link->name = $req->name;
        $link->url = $req->url;
        $link->tags = $req->tags;
        $link->private_topic_id = $req->topic;

        if(! $link->save()){
            return response()->json(['result'=>'error','msg'=>'保存出错']);
        }

        $ssdb->hset($setName,md5($link->url),$link->id);

        return response()->json(['result'=>'ok']);
    }

    public function saveLinkBatch()
    {
        $req = json_decode(Input::getContent());
        Log::info('save link batch='.Input::getContent());

        $ssdb = \LinkSSDB::ssdbConn();
        $setName = \LinkSSDB::linkPrivateSetName();

        $totalCount = count($req);
        $errorCount = 0;
        foreach($req->links as $item){
            if($ssdb->hexists($setName,md5($item->url))->data) {
                continue;
            }

            $link = new PrivateLink();
            $link->user_id = Auth::user()->id;
            $link->type = 0;
            $link->name = $item->name;
            $link->url = $item->url;
            $link->tags = $item->tags;
            $link->last_click_time = Carbon::now(); // 添加时，也作为一次点击

            if(! $link->save()) {
                ++$errorCount;
                continue;
            }

            $ssdb->hset($setName,md5($link->url),$link->id);
        }
        if($totalCount == $errorCount){
            return response()->json(['result'=>'error','msg'=>'所有项目保存出错']);
        }

        return response()->json(['result'=>'ok']);
    }

    public function clickLink($id)
    {
        $ssdb = \LinkSSDB::ssdbConn();
        $setName = \LinkSSDB::linkClickSetName($id);

        if($ssdb->exists($setName)->data){
            return;
        }

        $link = PrivateLink::find($id);
        $link->click_count = $link->click_count + 1;
        $link->last_click_time = Carbon::now();
        if(!$link->save()){
            return response()->json(['result'=>'error','msg'=>'保存出错']);
        }

        // 60s内重复点击不计数
        $ssdb->setx($setName,60);

        $dataClick = new PrivateDataClick();
        $dataClick->user_id = Auth::user()->id;
        $dataClick->link_id = $id;
        $dataClick->save();

        return response()->json(['result'=>'ok']);
    }

    public function linkInfo($id)
    {
        $link = PrivateLink::find($id);
        if(!isset($link)){
            return response()->json(['result'=>'error','msg'=>'没有找到此链接']);
        }
        return response()->json(['result'=>'ok','data'=>$link]);
    }

    public function isExisted()
    {
        $req = json_decode(Input::getContent());
        $ssdb = \LinkSSDB::ssdbConn();
        $setName = \LinkSSDB::linkPrivateSetName();
        if($ssdb->hexists($setName,md5($req->url))->data){
            Log::info('link existed:'.$req->url.' - '.$setName.' # ');
            return response()->json(['result'=>'existed']);
        }
        return response()->json(['result'=>'error']);
    }
}
