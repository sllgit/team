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
        <script src="{{asset('admin/lib/layui/layui.js')}}" charset="utf-8"></script>
        <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        {{--<div class="layui-card-header">--}}
                            {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
                            {{--<button class="layui-btn" onclick="xadmin.open('添加用户','./member-add.html',600,400)"><i class="layui-icon"></i>添加</button>--}}
                        {{--</div>--}}
                        <form class="layui-form layui-col-space5" action="" method="get">
                            <div class="layui-input-inline layui-show-xs-block">
                                <select name="type">
                                    @if($type == '')
                                        <option>素材类型</option>
                                    @else
                                        <option>{{$type}}</option>
                                    @endif
                                    <option>image</option>
                                    <option>voice</option>
                                    <option>news</option>
                                </select>
                            </div>
                            <div class="layui-input-inline layui-show-xs-block">
                                <button class="layui-btn" lay-submit="" lay-filter="sreach">
                                    <i class="layui-icon">&#xe615;</i></button>
                            </div>
                        </form>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    {{--<th>--}}
                                      {{--<input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">--}}
                                    {{--</th>--}}
                                    <th>ID</th>
                                    <th>类型</th>
                                    <th>media_id</th>
                                    <th>文件名称</th>
                                    <th>最后更新时间</th>
                                    <th>图片url</th>
                                    <th>操作</th></tr>
                                </thead>
                                <tbody>
                                @foreach($data as $k=>$v)
                                  <tr>
                                    {{--<td>--}}
                                      {{--<input type="checkbox" name="id" value="1"   lay-skin="primary"> --}}
                                    {{--</td>--}}
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->type}}</td>
                                    <td>{{$v->media_id}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->update_time}}</td>
                                    <td>{{$v->url}}</td>
                                    <td class="td-manage">
                                      @if($v->type == 'news')
                                      <a onclick="xadmin.open('修改','/admin/materialupd/{{$v->id}}',600,400)" title="修改" href="javascript:;">
                                        <i class="layui-icon">&#xe631;</i>
                                      </a>
                                      @endif
                                      <a title="删除" onclick="member_del(this,'')" href="/admin/materialdel/{{$v->id}}">
                                        <i class="layui-icon">&#xe640;</i>
                                      </a>
                                    </td>
                                  </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            {{$data->appends($request)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function(data){

          if(data.elem.checked){
            $('tbody input').prop('checked',true);
          }else{
            $('tbody input').prop('checked',false);
          }
          form.render('checkbox');
        }); 
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });


      });

       /*用户-停用*/
      // function member_stop(obj,id){
      //     layer.confirm('确认要停用吗？',function(index){
      //
      //         if($(obj).attr('title')=='启用'){
      //
      //           //发异步把用户状态进行更改
      //           $(obj).attr('title','停用')
      //           $(obj).find('i').html('&#xe62f;');
      //
      //           $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
      //           layer.msg('已停用!',{icon: 5,time:1000});
      //
      //         }else{
      //           $(obj).attr('title','启用')
      //           $(obj).find('i').html('&#xe601;');
      //
      //           $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
      //           layer.msg('已启用!',{icon: 5,time:1000});
      //         }
      //
      //     });
      // }

      /*用户-删除*/
      // function member_del(obj,id){
      //     layer.confirm('确认要删除吗？',function(index){
      //         alert(obj+id);
      //         // $.post(
      //         //     "obj.id"
      //         // )
      //         //发异步删除数据
      //         // $(obj).parents("tr").remove();
      //         // layer.msg('已删除!',{icon:1,time:1000});
      //     });
      // }



      // function delAll (argument) {
      //   var ids = [];
      //
      //   // 获取选中的id
      //   $('tbody input').each(function(index, el) {
      //       if($(this).prop('checked')){
      //          ids.push($(this).val())
      //       }
      //   });
      //
      //   layer.confirm('确认要删除吗？'+ids.toString(),function(index){
      //       //捉到所有被选中的，发异步进行删除
      //       layer.msg('删除成功', {icon: 1});
      //       $(".layui-form-checked").not('.header').parents('tr').remove();
      //   });
      // }
    </script>
</html>