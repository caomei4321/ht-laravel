<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 空白页</title>
    {{--<meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">--}}

    <link rel="shortcut icon" href="{{ asset('assets/admin/favicon.ico') }}"> <link href="{{ asset('assets/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">

    <link href="{{ asset('assets/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>温度</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="graph_flot.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="graph_flot.html#">选项1</a>
                            </li>
                            <li><a href="graph_flot.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div style="height:600px" id="ht-map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 全局js -->
<script src="{{ asset('assets/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>

<!-- 百度地图js -->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=F6subxg8j4A1f28mhgryfUs0dxO8PQ8o"></script>

<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>

{{--<script type="text/javascript">
    //百度地图
    var map = new BMap.Map('ht-map');
    var point = new BMap.Point(); //经纬度
    map.centeAndZoom(point,15);
    var marker = new BMap.Marker(new BMap.point());
    map.addOverlay(marker);
</script>--}}
<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("ht-map");
    var point = new BMap.Point(120.76938270267108, 31.279379881924105);
    map.centerAndZoom(point, 15);
    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

    console.log({{ $address[0]['lat'] }});
    var i = 0;
    @foreach($address as $k)
        var lng = "{{ $k['lng'] }}" ;
        var lat = "{{ $k['lat'] }}" ;
    var marker = new BMap.Marker(new BMap.Point(lng, lat)); // 创建点
    /*var marker2 = new BMap.Marker(new BMap.Point(116.399, 39.910)); // 创建点*/
    map.addOverlay(marker);            //增加点
    /*map.addOverlay(marker2);            //增加点*/
    @endforeach
    marker.addEventListener("click", function(){
        alert("您点击了标注");
    });
    //清除覆盖物 map.clearOverlays();

</script>
</body>

</html>
