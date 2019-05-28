<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>菜单添加</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{asset('admin/css/font.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/xadmin.css')}}">
    <script type="text/javascript" src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row">


        <form class="layui-form" action="{{url('menu/menueditdo')}}" method="post">
            <input type="hidden" value="{{$data2->id}}" name="id">
            @csrf
            @if($data2->pid == 0)
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red"></span>菜单名称</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" name="name" value="{{$data2->name}}" class="layui-input"></div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">确认修改                                           </button>
                </div>
            @else
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red"></span>菜单名称</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" name="name" value="{{$data2->name}}" class="layui-input"></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-block" id="cha">
                        @if($data2->type == 'view' )
                            <input type="radio" name="type" value="view" title="view"  checked>
                            <input type="radio" name="type" value="click" title="click">
                        @else
                            <input type="radio" name="type" value="view" title="view" >
                            <input type="radio" name="type" value="click" title="click" checked>
                        @endif
                    </div>
                </div>
                {{--style ="display: none"--}}
                <div class="layui-form-item" id="url" @if($data2->type == 'view')style="display:block "@elseif($data2->type == 'click')style="display:none "@endif >
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red"></span>url</label>
                    <div class="layui-input-inline">
                        <input type="type" id="L_pass" name="url" value="{{$data2->url}}" class="layui-input"></div>
                </div>
                <div class="layui-form-item"  id="key" @if($data2->type == 'view')style="display:none "@elseif($data2->type == 'click')style="display:block "@endif>
                    <label for="L_repass" class="layui-form-label">
                        <span class="x-red"></span>key</label>
                    <div class="layui-input-inline">
                        <input type="type" id="L_repass" name="key" value="{{$data2->key}}" class="layui-input"></div>
                </div>
                <div class="layui-form-item" >
                    <label class="layui-form-label">菜单等级</label>
                    <div class="layui-input-block" id="type" >
                        @if($data2->pid == 0)
                            <input type="radio" name="pid"  value="0" title="一级菜单" checked>
                            <input type="radio" name="pid"  value="two" title="二级菜单">
                        @else
                            <input type="radio" name="pid"  value="0" title="一级菜单">
                            <input type="radio" name="pid"  value="two" title="二级菜单" checked>
                        @endif
                    </div>
                </div>
                @if(empty($data1))
                    <div class="layui-form-item" id="twomenu" style ="display: none">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <span>未添加一级菜单</span>
                        </div>
                    </div>
                @else
                    <div class="layui-form-item" id="twomenu" style ="display: none">
                        <label class="layui-form-label">选择一级菜单</label>
                        <div class="layui-input-block">
                            @foreach($data1 as $v)
                                <input type="radio" name="pid" value="{{$v['id']}}" title="{{$v['name']}}">
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">增加</button>
                </div>
            @endif
        </form>
    </div>
</div>
<script>
    $(function () {
        layui.use('form',function(){
            var form = layui.form;
            form.render();
        });
        $("#cha").click(function () {
            var type = $("input[name='type']:checked").val();
            if(type=='view'){
                $("#url").css('display','block');
                $("#key").css('display','none');
            }else{
                $("#url").css('display','none');
                $("#key").css('display','block');
            }
        })
        $("#type").click(function () {
            var two = $("input[name='pid']:checked").val();
            if(two=='two'){
                $("#twomenu").css('display','block')
            }else if(two=="0"){
                $("#twomenu").css('display','none')
            }
        })
    })
</script>
</body>

</html>