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


        <form class="layui-form" action="/admin/settype" method="post">
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>首次回复类型</label>
                <div class="layui-input-inline layui-show-xs-block">
                    text<input type="radio" name="type" value="text" @if($type == 'text')checked @endif><br />
                    image<input type="radio" name="type" value="image" @if($type == 'image')checked @endif><br />
                    voice<input type="radio" name="type" value="voice" @if($type == 'voice')checked @endif><br />
                    redio<input type="radio" name="type" value="redio" @if($type == 'redio')checked @endif><br />
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label"></label>
                <button class="layui-btn" lay-filter="add" lay-submit="submit">设置</button></div>
        </form>
    </div>
</div>
<script>
    $(function () {
        layui.use('form',function(){
            var form = layui.form;
            form.render();
        });
    })
</script>
</body>

</html>