<div id="search"   role="main" class="ui-content">
    @if($con1!=''&&$con!='')
    <div class="pic_list">
        <div><h3 style="color: red;">电影</h3></div>
        <div class="ui-grid-c">
            @foreach($con1 as $k=>$v)
                <div class="ui-block-b"><div class="singerpic"><a href="{{$v['vurl']}}" data-ajax="false"><img src="{{$v['logourl']}}" border="0" style="width: 100px;height: 150px;"/><span>{{$v['vname']}}</span></a></div></div>
            @endforeach
        </div>
        <a href="/home/video/index" data-role="button" data-ajax="false">查看更多</a>
    </div>
    <div data-role="tabs" id="tabs">
        <div><h3 style="color: red;">音乐</h3></div>
        <div id="tab1">
            @foreach($con as $k=>$v)
                <div class="ui-corner-all">
                    <div class="ui-bar ui-bar-a music_list"><span>{{$v['mpeople']}}</span><h3><a href="{{$v['murl']}}" data-ajax="false">{{$v['mname']}}</a></h3></div>
                </div>
            @endforeach
            <a href="/home/music/index/中文" data-role="button" data-ajax="false">查看更多</a>
        </div>
    </div>
    @elseif($con1==''&&$con=='')
        <div data-role="tabs" id="tabs">
            <div><h3 style="color: red;">暂无结果</h3></div>
            <div id="tab1">
                <a href="/" data-role="button" data-ajax="false">查看更多</a>
            </div>
        </div>
    @endif
</div>