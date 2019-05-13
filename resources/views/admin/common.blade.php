<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 数据表格</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/admin/favicon.ico') }}"> <link href="{{ asset('assets/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">

    <!-- Data Tables -->
    <link href="{{ asset('assets/admin/css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('assets/admin/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>公司总人数</h5>
                    <h1 class="no-margins">{{ $count['user_count'] }}</h1>
                    <div class="stat-percent font-bold text-navy"> <i class="fa fa-bolt"></i></div>
                    <small>&nbsp</small>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>本月迟到总次数</h5>
                    <h1 class="no-margins">{{ $count['late_user_count'] }}</h1>
                    <div class="stat-percent font-bold text-navy"> <i class="fa fa-bolt"></i></div>
                    <small>&nbsp</small>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>本月新增员工</h5>
                    <h1 class="no-margins">{{ $count['new_user_count'] }}</h1>
                    <div class="stat-percent font-bold text-navy"> <i class="fa fa-bolt"></i></div>
                    <small>&nbsp</small>
                </div>
            </div>
        </div>
        {{--<div class="col-sm-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>本日收入</h5>
                    <h1 class="no-margins">-200,100</h1>
                    <div class="stat-percent font-bold text-danger">12% <i class="fa fa-level-down"></i></div>
                    <small>总收入</small>
                </div>
            </div>
        </div>--}}
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>今日上班打卡百分比</h5>
                    <h2>{{ $record['start_record'] }}/{{ $count['user_count'] }}</h2>
                    <div class="text-center">
                        <div id="start_work"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>今日下班打卡百分比</h5>
                    <h2>{{ $record['end_record'] }}/{{ $count['user_count'] }}</h2>
                    <div class="text-center">
                        <div id="end_work"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>今日迟到百分比</h5>
                    <h2>{{ $record['late_user'] }}/{{ $count['user_count'] }}</h2>
                    <div class="text-center">
                        <div id="late"></div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="col-sm-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>今日上班打卡百分比</h5>
                    <h2>42/20</h2>
                    <div class="text-center">
                        <div id="test2"></div>
                    </div>
                </div>
            </div>
        </div>--}}
    </div>
</div>

<!-- 全局js -->
<script src="{{ asset('assets/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('assets/admin/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- Peity -->
<script src="{{ asset('assets/admin/js/plugins/peity/jquery.peity.min.js') }}"></script>

<script src="{{ asset('assets/admin/js/plugins/jeditable/jquery.jeditable.js') }}"></script>



<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>


<!-- Page-Level Scripts -->
<script>
    //$(document).read(function () {
        $("#start_work").sparkline([{{ $record['start_record'] }}, {{ $count['user_count'] - $record['start_record'] }}], {
            type: 'pie',
            height: '200',
            sliceColors: ['#1ab394', '#F5F5F5']
        });
        $("#end_work").sparkline([{{ $record['end_record'] }}, {{ $count['user_count'] - $record['end_record'] }}], {
            type: 'pie',
            height: '200',
            sliceColors: ['#1ab394', '#F5F5F5']
        });
    $("#late").sparkline([{{ $record['late_user'] }}, {{ $count['user_count'] - $record['late_user'] }}], {
        type: 'pie',
        height: '200',
        sliceColors: ['#1ab394', '#F5F5F5']
    });
    $("#test2").sparkline([1, 4], {
        type: 'pie',
        height: '200',
        sliceColors: ['#1ab394', '#F5F5F5']
    });
    //});

</script>

</body>

</html>
