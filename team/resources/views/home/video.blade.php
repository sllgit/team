<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>电影</title>
    <link href="{{asset('home/jquery.mobile-1.4.2.min.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('home/base.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('css/page.css')}}" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="{{asset('home/jquery-1.10.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/jquery.mobile-1.4.2.min.js')}}"></script>
    <script type="text/javascript">
        <!--
        $(document).bind("mobileinit", function() {
            $.mobile.ajaxEnabled = false;
        });
        //-->
    </script>
</head>
<body>
<div data-role="page">
    <div data-role="header" data-position="fixed">
        <div class="top">
            <a href="index.html" data-ajax="false" class="logo"><img src="{{asset('home/images/logo.png')}}" alt="手机MP3下载" /></a>
            <a href="#search-popup" rel="nofollow" class="ui-nodisc-icon ui-btn ui-btn-b ui-corner-all ui-icon-search ui-btn-icon-notext search-btn" data-rel="popup" data-position-to="window" data-transition="pop">搜索</a>
        </div>
        <div data-role="navbar">
            <ul>
                <li><a href="/" data-ajax="false" class="ui-btn ui-icon-home ui-btn-icon-left">首页</a></li>
                <li><a href="/home/video/index" data-ajax="false" class="ui-btn ui-icon-star ui-btn-icon-left ui-btn-active">电影</a></li>
                <li><a href="/home/music/index" data-ajax="false" class="ui-btn ui-icon-music ui-btn-icon-left">音乐</a></li>
            </ul>
        </div>
        <div data-role="popup" id="search-popup" class="ui-corner-all" data-overlay-theme="b">
            <a href="#" data-rel="back" rel="nofollow" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">关闭</a>
           {{--<form style="padding: 0 10px;" data-ajax="false" method="get" action="/search.asp">--}}
                <h3>搜索：</h3>
                <label for="keyword" class="ui-hidden-accessible">关键字：</label>
                <input type="search" name="keyword" id="keyword" placeholder="请输入你要搜索的电影或音乐名称">
                <button type="submit" id="search" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check ui-mini">搜索</button>
            {{--</form>--}}
        </div>
    </div>
    <div role="main" id="searchs" class="ui-content">
        <div class="ui-grid-d sortlist">
            <div class="ui-block-a" style="width: 33%"><div class="ui-bar-a"><a href="/home/video/index/喜剧" data-ajax="false">喜剧</a></div></div>
            <div class="ui-block-b" style="width: 33%"><div class="ui-bar-a"><a href="/home/video/index/动作" data-ajax="false">动作</a></div></div>
            <div class="ui-block-b" style="width: 33%"><div class="ui-bar-a"><a href="/home/video/index/爱情" data-ajax="false">爱情</a></div></div>

        </div>

        <div class="m_title"><strong>全部电影</strong></div>
        <div class="ui-corner-all" id="searchs">

            <div class='ui-bar ui-bar-a music_list'><span><h3>主演</h3></span><h3><h3  data-ajax='false'>电影名称</h3></h3></div>
            @foreach($data as $k=>$v)
            <div class='ui-bar ui-bar-a music_list'><span>{{$v->vpeople}}</span><h3><a href='{{$v->vurl}}' data-ajax='false'>{{$v->vname}}</a></h3></div>
            @endforeach
            {{--<div class="ui-grid-c">--}}
                {{--@foreach($data as $k=>$v)--}}
                    {{--<div class="ui-block-a"><div class="singerpic"><a href="{{$v->vurl}}" data-ajax="false"><img src="{{$v->logourl}}" border="0" style="width: 200px;height: 150px;"/><span>{{$v->vname}}</span></a></div></div>--}}
                {{--@endforeach--}}
            </div>
            {{$data->links()}}
            <div class="side">
                <!--<a href="/" class="home" data-ajax='false'><img src="http://m.sjmp3.com/public/images/null.gif" alt="手机MP3下载" width="48" height="48" border="0" /></a>-->
                <a href="#" class="top" onClick="$.mobile.silentScroll(0)"><img src="../public/images/null.gif" alt="返回顶部" width="48" height="48" border="0" /></a>
            </div>
</body>
</html>
<script>
    $(function () {
        $(document).on('click','#search',function () {
            var keyword=$('#keyword').val();
            $.ajax({
                type:"get",
                url:"/home/video/search",
                data:{keyword:keyword},
            }).done(function (res) {
                $('#searchs').html(res);
            })
        })
    })
</script>