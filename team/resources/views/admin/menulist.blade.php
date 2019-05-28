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
    <script src="{{asset('lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
</head>

<body>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <table class="layui-table layui-form">
                    <thead>
                    <tr>
                        <th>菜单名称</th>
                        <th>类型</th>
                        <th>key</th>
                        <th>url</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k=>$v)
                        <tr class="id" pid="{{$v->id}}">
                            <td>{{$v->name}}</td>
                            <td>{{$v->type}}</td>
                            <td>{{$v->key}}</td>
                            <td>{{$v->url}}</td>
                            <td class="td-manage">
                                <a title="修改" href="/menu/menuedit/{{$v->id}}">
                                    <i class="layui-icon">&#xe63c;</i></a>
                                <a title="删除" onclick="" href="/menu/menudel/{{$v->id}}">
                                    <i class="layui-icon">&#xe640;</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="layui-btn-group" style="margin-left: 40%;">
                <button class="layui-btn"><a href="/menu/cteatemenujog">启用</a></button>
                <button class="layui-btn"><a href="/menu/delmenujog">删除</a></button>
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
            $(document).ready(function () {
                $('.id').each(function () {
                    var id= $(this).attr('pid');
                    var _this = $(this);
                    // console.log(_this);
                    $.ajax({
                        url: "/menu/getmenu/" + id,
                        method: 'GET',
                        success: function (res) {
                            // console.log(res);
                            var nbsp = "&nbsp;&nbsp;&nbsp;&nbsp;";
                            var str = '';
                            for (var i in res){
                                str += '<tr>\n' +
                                    '<td>' + nbsp + res[i].name + '</td>\n' +
                                    '<td>' + nbsp + res[i].type + '</td>\n' +
                                    '<td>' + nbsp + res[i].key + '</td>\n' +
                                    '<td>' + nbsp + res[i].url + '</td>\n' +
                                    '<td class="td-manage">\n' + nbsp +
                                    '    <a title="修改" href="/menu/menuedit/'+res[i].id+'">\n' +
                                    '        <i class="layui-icon">&#xe63c;</i></a>\n' + nbsp +
                                    '    <a title="删除" href="/menu/menudel/'+res[i].id+'">\n' +
                                    '        <i class="layui-icon">&#xe640;</i></a>\n' +
                                    '</td>\n' +
                                    '</tr>';
                            };
                            // console.log(str);
                            _this.after(str);

                        }
                    });
                })
            });
            /*用户-删除*/

        })
</script>

</html>