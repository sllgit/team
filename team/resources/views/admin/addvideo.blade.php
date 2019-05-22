<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.2</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="{{asset('admin/css/font.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/xadmin.css')}}">
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <script type="text/javascript" src="{{asset('admin/lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form class="layui-form" action="/admin/addvideo" method="post">
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>电影名称</label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="vname" required="" autocomplete="off" class="layui-input"></div>
                <div class="layui-form-item">
                    <label for="L_username" class="layui-form-label">
                        <span class="x-red">*</span>电影类型</label>
                    <div class="layui-input-inline layui-show-xs-block">
                        <select name="vtype"  lay-filter="type_mid" >
                            <option value="0">请选择电影类型</option>
                            <option value="喜剧">喜剧</option>
                            <option value="动作">动作</option>
                            <option value="爱情">爱情</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item" id="key">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>电影主演</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_pass" name="vpeople"  required="" autocomplete="off" class="layui-input"></div>
                </div>
                <div class="layui-form-item" id="url">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>电影描述</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_pass" name="vdesc"  required="" autocomplete="off" class="layui-input"></div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
            </div>
        </form>
    </div>
</div>
<script>layui.use(['form', 'layer','jquery'],
        function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;


        });</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>