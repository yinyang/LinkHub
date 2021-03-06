@extends('_layouts.app')
@section('endofhead')

@endsection

@section('content')
    <div class="ui main text container">
        <div class="ui fluid icon input">
            <input type="text" name="keyword" placeholder="输入想知道的任何内容..." value="{{$keyword}}">
            <i class="search icon"></i>
        </div>
    </div>

    <div class="ui segments">
        <div class="ui segment">
            <p>
                最新主题：
                @foreach($latest_topics as $topic)
                    <i class="tasks icon"></i>
                    <a href="{{url('topic').'/'.$topic->id}}">{{$topic->name}}</a>
                @endforeach
            </p>
        </div>
    </div>
    <div class="ui segments">
        <div class="ui segment">
            <p>
                点赞最多：
                @foreach($links_top_greet as $link)
                    @include('_layouts.publiclink')
                    @endforeach
            </p>
        </div>

        <div class="ui green segment">
            <p>
                收藏最多：
                @foreach($links_top_favo as $link)
                    @include('_layouts.publiclink')
                @endforeach
            </p>
        </div>

        <div class="ui red segment">
            <p>
                最新分享：
                @foreach($links_new_create as $link)
                    @include('_layouts.publiclink')

                    @endforeach
            </p>
        </div>

        <div class="ui blue segment">
            <p>
                所有链接：
                @foreach($links as $link)
                    @include('_layouts.publiclink')

                    @endforeach
            </p>
            <p>
            <div class="ui right floated pagination menu">
                <a class="item">共计 {{$links_count}} 条链接</a>
                <a class="item">第 {{$page}} 页 / 共 {{intval($links_count / 40 + 1)}} 页</a>
                <a class="icon item" href="{{url('').'/?page='.($page - 1 < 1 ? 1 : ($page - 1)).($keyword == '' ? '' : ('&keyword='.$keyword)) }}">
                    <i class="left chevron icon"></i>
                </a>
                <a class="icon item" href="{{url('').'/?page='.($page + 1).($keyword == '' ? '' : ('&keyword='.$keyword))}}">
                    <i class="right chevron icon"></i>
                </a>
            </div>
            </p>
        </div>
    </div>


@endsection