@extends('_layouts.user')

@section('subcontent')


    <h4 class="ui header">链接信息</h4>
    <div class="ui info message">
        <p>
           共计 {{$count_in_queue}} 条没有标签的链接等待您添加标签。
        </p>
    </div>

    @if(count($links_in_queue) > 0)
        <h5 class="ui header">请为以下链接添加标签、精简标题</h5>

        @if(count($errors) > 0)
            <div class="ui error message">
                <ul class="list">
                    @foreach($errors->all() as $err)
                        <li>{{$err}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="ui segment">
            <form class="ui form" method="post" action="{{ url('home/link/'.$link_item->id) }}">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">

                <div class="field">
                    <label>标题（精简）</label>
                    <input type="text" name="name" value="{{$link_item->name}}">
                </div>
                <div class="field">
                    <label>地址（建议不修改）</label>
                    <input type="text" name="url" value="{{$link_item->url}}">
                </div>
                <div class="field">
                    <label>标签（空格分隔）</label>
                    <input id="tags" type="text" name="tags" value="{{$link_item->tags}}">
                    <div class="ui segment">
                        <p id='commonTags'>
                            常用标签：<a>编程</a> <a>C++</a> <a>PHP</a> <a>微信开发</a> <a>Chrome</a>
                        </p>
                    </div>
                </div>
                <div class="field">
                    <label>类型</label>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="type" @if($link_item->type == 0)checked=""@endif tabindex="0" class="hidden" value="0">
                                <label>链接</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="type" @if($link_item->type == 1)checked=""@endif tabindex="0" class="hidden" value="1">
                                <label>公众号</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="type" @if($link_item->type == 2)checked=""@endif tabindex="0" class="hidden" value="2">
                                <label>书籍</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="type" @if($link_item->type == 3)checked=""@endif tabindex="0" class="hidden" value="3">
                                <label>生活</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label>主题</label>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="topic" @if($link_item->private_topic_id == 0)checked=""@endif tabindex="0" class="hidden" value="0">
                                <label>无主题</label>
                            </div>
                        </div>

                        @foreach($topics as $topic)
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="topic" @if($link_item->private_topic_id == $topic->id)checked=""@endif tabindex="0" class="hidden" value="{{$topic->id}}">
                                    <label>{{$topic->name}}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="ui fluid button green" type="submit">确认此条链接，进入下一条</button>
            </form>
        </div>

        <h5 class="ui header">队列中，还有 {{$count_in_queue}} 条链接</h5>
        <table class="ui pink table">
            <thead>
            <tr><th width="20px">#</th>
                <th width="60px">类型</th>
                <th>标题/地址/标签</th>
            </tr></thead><tbody>

            @foreach($links_in_queue as $link)
                <tr>
                    <td>{{$link->id}}</td>
                    <td>{{$link->type}}</td>
                    <td>
                        <a href="{{$link->url}}" target="_blank">{{$link->name}}</a>
                        <div class="ui fluid transparent input">
                            <input type="text" readonly value="{{$link->url}}">
                        </div>
                        <div class="ui fluid transparent input">
                            <input type="text" readonly value="{{$link->tags}}">
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif

@endsection

@section('endofbody')
    <script>
        $('.ui.radio.checkbox')
                .checkbox()
        ;

        $(function(){
            $('p#commonTags a').click(function () {
                $('#tags').val( $('#tags').val()+ ' ' + $(this).text());
            });
        });
    </script>

@endsection