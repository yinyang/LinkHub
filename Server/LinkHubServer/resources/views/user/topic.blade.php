@extends('_layouts.user')


@section('subcontent')
    @if(count($errors) > 0)
        <div class="ui error message">
            <ul class="list">
                @foreach($errors->all() as $err)
                    <li>{{$err}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ url('home/topic') }}">
        <div class="ui fluid action input">
            {!! csrf_field() !!}
            <input type="text" name="name" placeholder="要添加的主题名称">
            <button type="submit" class="ui orange button">添加</button>
        </div>
    </form>

    <div class="ui modal">
        <div class="header">修改</div>
        <div class="content">
            <form id="modifyForm" method="post" style="display: inline;">
                {!! csrf_field() !!}
                <input name="_method" type="hidden" value="PUT">

                <div class="ui fluid action input">
                    <input id="modifyName" type="text" name="name" placeholder="名称">
                    <button type="submit" class="ui orange button">确认</button>
                </div>
            </form>
        </div>
    </div>

    <table class="ui orange table">
        <thead>
        <tr><th>名称</th>
            <th>排序</th>
            <th>首页显示</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody>
        @foreach($topics as $topic)
            <tr>
                <td>{{$topic->name}}</td>
                <td>{{$topic->order}}

                    <form method="post" action="{{ url('home/topic/'.$topic->id.'/order/inc') }}" style="display: inline;">
                        {!! csrf_field() !!}
                        <button typeo="submit" class="circular mini ui icon button"><i class="plus icon"></i>
                        </button>
                    </form>
                    @if($topic->order > 0)
                        <form method="post" action="{{ url('home/topic/'.$topic->id.'/order/dec') }}" style="display: inline;">
                            {!! csrf_field() !!}
                            <button class="circular mini ui icon button"><i class="minus icon"></i>
                            </button>
                        </form>
                    @endif
                </td>
                <td>
                    <form method="post" action="{{ url('home/topic/'.$topic->id.'/hide') }}" style="display: inline;">
                        {!! csrf_field() !!}
                        <button type="submit" class="mini ui blue button">{{$topic->hide ? '不显示在首页' : '显示在首页'}}</button>
                    </form>
                </td>
                <td>
                    <button class="mini ui orange button" onclick="showModify({{$topic->id}},'{{$topic->name}}');">修改</button>

                    <form method="post" action="{{ url('home/topic/'.$topic->id) }}" style="display: inline;">
                        {!! csrf_field() !!}
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="mini ui danger button" onclick="return confirmDelete();">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection

@section('endofbody')
    <script language="javascript">
        function confirmDelete(){
            if(!confirm('确认删除吗？')){
                return false;
            }
            return true;
        }
        function showModify(id,name){
            var url = '{{ url('home/topic') }}';
            $('#modifyForm').attr('action', url + '/' + id);
            $('#modifyName').val(name);
            $('.ui.modal')
                    .modal('show')
            ;
        }
    </script>

@endsection