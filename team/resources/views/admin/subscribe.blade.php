<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('js/jquery.js')}}"></script>
    <title>首次关注添加回复内容</title>
</head>
<body>
<form action="/admin/subscribe/add" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>请选择回复的类型</td>
            <td>
                <select name="type" id="type">
                    <option>请选择</option>
                    <option value="text">文字</option>
                    <option value="image">图片</option>
                    <option value="news">图文</option>
                    <option value="voice">语音</option>
                    <option value="video">视频</option>
                </select>
            </td>
        </tr>

        <tr>
            <td style="display: none;" class="text all">请输入文字：<br><textarea name="content" cols="30" rows="10"></textarea></td>
        </tr>

        <tr style="display: none;" class="video all">
            <td>选择文件</td>
            <td><input type="file" name="material" ></td>
        </tr>

        <tr style="display: none;" class="news video all">
            <td>标题</td>
            <td><input type="text" name="title"></td>
        </tr>
        <tr style="display: none;" class="news video all">
            <td>简介</td>
            <td><input type="text" name="desc"></td>
        </tr>
        <tr style="display: none;" class="news voice image all">
            <td><input type="file" name="material" ></td>
        </tr>
        <tr style="display: none;" class="news all">
            <td>跳转链接</td>
            <td><input type="text" name="url"></td>
        </tr>

        <tr>
            <td></td>
            <td><input type="submit" value="添加"></td>
        </tr>
    </table>
</form>
</body>
</html>
<script>
    $(function () {
        $('#type').change(function () {
            var type = $(this).val();
            if(type == 'text'){
                $('.all').css('display','none');
                $('.text').css('display','block');
            }else if(type == 'image'){
                $('.all').css('display','none');
                $('.image').css('display','block');
            }else if(type == 'voice'){
                $('.all').css('display','none');
                $('.voice').css('display','block');
            }else if(type == 'news'){
                $('.all').css('display','none');
                $('.news').css('display','block');
            }else if(type == 'video'){
                $('.all').css('display','none');
                $('.video').css('display','block');
            }
        })
    })

</script>