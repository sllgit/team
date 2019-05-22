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
    <link rel="stylesheet" href="{{asset('css/page.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layui/css/layui.css')}}">
    <script src="{{asset('admin/lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
</head>

<body>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <form action="">
                    <input type="text" name="mname" value="{{$mname}}" placeholder="请输入音乐名称">
                    <input type="text" name="mtype" value="{{$mtype}}"  placeholder="请输入音乐类型">
                    <input type="submit" value="搜索">
                </form>
                <table class="layui-table layui-form">
                    <thead>
                    <tr>
                        <th>音乐名称</th>
                        <th>音乐类型</th>
                        <th>音乐主演</th>
                        <th>音乐时长</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k=>$v)
                        <tr class="id" pid="{{$v->mid}}">
                            <td>{{$v->mname}}</td>
                            <td>{{$v->mtype}}</td>
                            <td>{{$v->mpeople}}</td>
                            <td>{{$v->mlength}}</td>
                            <td class="td-manage">
                                <a title="修改" href="/admin/musicupd/{{$v->mid}}">
                                    <i class="layui-icon">&#xe63c;</i></a>
                                <a title="删除" onclick="" href="/admin/musicdel/{{$v->mid}}">
                                    <i class="layui-icon">&#xe640;</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$data->appends($request)->links()}}
            </div>
        </div>
    </div>
</div>
</div>
</body>
<script>
    layui.use(['laydate', 'form'],
        function() {
            var form = layui.form;
            /*用户-删除*/

        })
</script>

</html>