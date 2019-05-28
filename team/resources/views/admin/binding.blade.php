<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
    <title>Document</title>
</head>
<body>
<form action="/admin/bindingdo">
    请填写要绑定的用户：<input type="text" name="name">
    <input type="hidden" name="user" value="{{$data}}">
    {{--<input type="hidden" name="state" value="{{$state}}">--}}
    <input type="button" id="button" value="绑定">
</form>
</body>
</html>
<script>

        $("#button").click(function () {
            var name = $('input[type=text]').val();
            var user = $('input[name=user]').val();
            $.post(
                "/admin/bindingdo",
                {name:name,user:user},
                function (res) {
                    if(res == 1){
                        alert('绑定成功');
                        location.href="/";
                    }else{
                        alert('绑定失败');
                        location.href="/admin/getcode";
                    }
                }
            )
        })
</script>