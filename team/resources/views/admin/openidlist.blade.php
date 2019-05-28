<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('js/jquery.js')}}"></script>
    <title>Document</title>
</head>
<body>
<input type="button" value="全选" id="quan">
&nbsp;&nbsp;
<input type="button" value="全不选" id="quanbu">
&nbsp;&nbsp;
<input type="button" value="反选" id="fan">
<table >
    <tr>
        <td></td>
        <td>openid</td>
        <td>昵称</td>
        <td>性别</td>
        <td>地址</td>
        <td>头像</td>
        <td>关注时间</td>
    </tr>
    @foreach($data as $k=>$v)
        <tr>
            <td><input type="checkbox" class="openid"></td>
            <td>{{$v['openid']}}</td>
            <td>{{$v['nickname']}}</td>
            <td>@if($v['sex'] == 1) 男 @elseif($v['sex'] == 2) 女 @else 不详@endif</td>
            <td>{{$v['address']}}</td>
            <td><img src="{{$v['headimgurl']}}" style="width: 50px;height: 50px;" alt=""></td>
            <td>{{date("Y-m-d H:i:s",$v['subscribe_time'])}}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td>
            <div id="send" style="float: left">
                <input type="button" value="群发">
            </div>
        </td>
    </tr>
</table>
</body>
</html>
<script>
    $(function () {
        //点击全选
        $('#quan').click(function () {
            $('.openid').prop('checked',true);

        });
        //点击全不选
        $('#quanbu').click(function () {
            $('.openid').prop('checked',false);
        });
        //点击反选
        $('#fan').click(function () {
            $('.openid').each(function (index) {
                if($(this).prop('checked') == true){
                    $(this).prop('checked',false);
                }else{
                    $(this).prop('checked',true);
                }
            })
        });
        //点击发送
        $('#send').click(function () {
            var checked = $('.openid');
            var openid = '';
            checked.each(function (index) {
                // console.log($(this).prop('checked'));
                if($(this).prop('checked') == true){
                    openid+=$(this).parents('td').next().text()+',';
                }
            })
            openid = openid.substr(0,openid.length-1);
            console.log(openid);
            location.href="/admin/openidsend/"+openid;
        })
    })
</script>