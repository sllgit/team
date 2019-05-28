<div id="search"   role="main" class="ui-content">
    @if($con1=='')
        <div data-role="tabs" id="tabs">
            <div><h3 style="color: red;">暂无结果</h3></div>
            <div id="tab1">
                <a href="/" data-role="button" data-ajax="false">查看更多</a>
            </div>
        </div>
    @else
        <div class="pic_list">
            <div><h3 style="color: red;">电影</h3></div>
            <div class="ui-grid-c">
                @foreach($con1 as $k=>$v)
                    <div class="ui-block-b"><div class="singerpic"><a href="{{$v->vurl}}" data-ajax="false"><img src="{{$v->logourl}}" border="0" style="width: 100px;height: 150px;"/><span>{{$v->vname}}</span></a></div></div>
                @endforeach
            </div>
            <a href="/home/video/index" data-role="button" data-ajax="false">查看更多</a>
        </div>
    @endif
</div>