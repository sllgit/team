<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>音乐电影</title>
<link href="{{asset('home/jquery.mobile-1.4.2.min.css')}}" type="text/css" rel="stylesheet" />
<link href="{{asset('home/base.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('home/jquery-1.10.2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/jquery.mobile-1.4.2.min.js')}}"></script>
<script src="{{asset('http://res2.wx.qq.com/open/js/jweixin-1.4.0.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
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
<a href="index.html" data-ajax="false" class="logo"><img src="{{asset('home/images/logo.png')}}" alt="手机MP3下载" style="width: 100px;"/></a>
   <div style="margin-left: 130px;">@if($users == '') @else  <img src="{{$users['headimgurl']}}" style="width: 30px;width: 30px;margin-top: 5px;"/>欢迎{{$users['nickname']}}登录@endif</div>
<a href="#search-popup" rel="nofollow" class="ui-nodisc-icon ui-btn ui-btn-b ui-corner-all ui-icon-search ui-btn-icon-notext search-btn" data-rel="popup" data-position-to="window" data-transition="pop">搜索</a>
</div>
<div data-role="navbar" data-iconpos="left">
<ul>
<li><a href="/" data-ajax="false" class="ui-btn ui-icon-home ui-btn-icon-left ui-btn-active">首页</a></li>
<li><a href="/home/video/index" data-ajax="false" class="ui-btn ui-icon-star ui-btn-icon-left">电影</a></li>
<li><a href="/home/music/index" data-ajax="false" class="ui-btn ui-icon-music ui-btn-icon-left">音乐</a></li>
</ul>
</div>
<div data-role="popup" id="search-popup" class="ui-corner-all" data-overlay-theme="b">
<a href="#" data-rel="back" rel="nofollow" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">关闭</a>
{{--<form style="padding: 0 10px;" data-ajax="false" method="get" action="#">--}}
<h3>搜索：</h3>
<label for="keyword" class="ui-hidden-accessible">关键字：</label>
<input type="search" name="keyword" id="keyword" placeholder="请输入你要搜索的电影或音乐名称">
<button type="submit" id="search" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check ui-mini">搜索</button>
{{--</form>--}}
</div>
</div>
<div role="main" id="searchs" class="ui-content">
    <div class="pic_list">
        <div><h3 style="color: red;">电影推荐</h3></div>
<div class="ui-grid-c">
    @foreach($vdata as $k=>$v)
        <div class="ui-block-b"><div class="singerpic"><a href="{{$v->vurl}}" data-ajax="false"><img src="{{$v->logourl}}" border="0" style="width: 100px;height: 150px;"/><span>{{$v->vname}}</span></a></div></div>
    @endforeach
</div>
        <a href="/home/video/index" data-role="button" data-ajax="false">查看更多</a>
</div>


<div data-role="tabs" id="tabs">
    <div><h3 style="color: red;">音乐推荐</h3></div>
    <div data-role="navbar">
        <ul>
            <li><a href="#tab1" rel="nofollow" data-ajax="false" class="ui-btn-active">中文</a></li>
            <li><a href="#tab2" rel="nofollow" data-ajax="false">英文</a></li>
        </ul>
    </div>
    <div id="tab1">
        @foreach($chinaese as $k=>$v)
        <div class="ui-corner-all">
            <div class="ui-bar ui-bar-a music_list"><span>{{$v->mpeople}}</span><h3><a href="{{$v->murl}}" data-ajax="false">{{$v->mname}}</a></h3></div>
        </div>
        @endforeach
        <a href="/home/music/index/中文" data-role="button" data-ajax="false">查看更多</a>
    </div>
    <div id="tab2">
        @foreach($english as $k=>$v)
        <div class="ui-corner-all">
            <div class="ui-bar ui-bar-a music_list"><span>{{$v->mpeople}}</span><h3><a href="{{$v->murl}}" data-ajax="false">{{$v->mname}}</a></h3></div>
        </div>
        @endforeach
        <a href="/home/music/index/英文" data-role="button" data-ajax="false">查看更多</a>
    </div>
</div>

</div>
</div>

<!--
<div class="ui-grid-a">
<div class="ui-block-a"><div class="ui-bar"><a href="" target="_blank">链接</a></div></div>
<div class="ui-block-b"><div class="ui-bar"><a href="" target="_blank">链接</a></div></div>
<div class="ui-block-a"><div class="ui-bar"><a href="" target="_blank">链接</a></div></div>
<div class="ui-block-b"><div class="ui-bar"><a href="" target="_blank">链接</a></div></div>
</div>
-->

<div class="side">
<!--<a href="/" class="home" data-ajax='false'><img src="http://sc.chinaz.com/public/images/null.gif" alt="手机MP3下载" width="48" height="48" border="0" /></a>-->
<a href="#" class="top" onClick="$.mobile.silentScroll(0)"><img src="{{asset('home/images/null.gif')}}" alt="返回顶部" width="48" height="48" border="0" /></a>
</div>
</body>
</html>
<script>
	//搜索
	$(function () {
        $(document).on('click','#search',function () {
            var keyword=$('#keyword').val();
            $.ajax({
                type:"get",
                url:"/home/index/search",
                data:{keyword:keyword},
            }).done(function (res) {
               $('#searchs').html(res);
            })
        })
    })
	//分享朋友圈 qq
    wx.config({
        debug: true,
        appId: '{{$sign['appId']}}',
        timestamp: '{{$sign['timestamp']}}',
        nonceStr: '{{$sign['nonceStr']}}',
        signature: '{{$sign['signature']}}',
        jsApiList: [
            'onMenuShareTimeline',//朋友圈
            'onMenuShareQQ',//qq
        ]
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: document.title, // 分享标题
            link: document.domain, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'http://mmbiz.qpic.cn/mmbiz_jpg/eewunpfg1TOHEpJZQEGjyxAa40ACgK7ouBiaJ6bEPBneYaUeQ5ApLcenn71Bp3JHqVxgpW7MMUldG9gwhIHKRNw/0?wx_fmt=jpeg', // 分享图标
            success: function () {
                // 设置成功
            }
        });
        wx.onMenuShareQQ({
            title:document.title, // 分享标题
            desc: '一个分享测试', // 分享描述
            link: document.domain, // 分享链接
            imgUrl: 'http://mmbiz.qpic.cn/mmbiz_jpg/eewunpfg1TOHEpJZQEGjyxAa40ACgK7ouBiaJ6bEPBneYaUeQ5ApLcenn71Bp3JHqVxgpW7MMUldG9gwhIHKRNw/0?wx_fmt=jpeg', // 分享图标
            success: function () {
// 用户确认分享后执行的回调函数
            },
            cancel: function () {
// 用户取消分享后执行的回调函数
            }
        });
    });
</script>