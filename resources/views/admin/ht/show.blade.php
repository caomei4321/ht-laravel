<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 百度ECHarts</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

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
                    <div style="height:600px" id="echarts-temperature-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>湿度</h5>
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
                    <div style="height:600px" id="echarts-humidity-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 全局js -->
<script src="{{ asset('assets/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>



<!-- ECharts -->
<script src="{{ asset('assets/admin/js/plugins/echarts/echarts-all.js') }}"></script>

<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>


<!-- ECharts demo data -->
{{--<script src="{{ asset('assets/admin/js/demo/echarts-demo.js') }}"></script>--}}

<script>
    var date = new Array();
    var i = 0;
    @forEach($htDates as $htDate)
            date[i] = new Array();
            var j = 0;
        @forEach($htDate as $date)
            date[i][j] = "{{ $date }}";
            j++;
        @endforeach
                i++;
    @endforeach
        console.log(date);
    var temList = date.map(function (item) {
        return item[0];
    });
    var humList = date.map(function (item) {
        return item[1];
    });
    var valueList = date.map(function (item) {
        return item[2];
    });
    var temOption = {
        title: {
            text: '温度分布图',
            /*subtext: '纯属虚构'*/
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        toolbox: {
            show: true,
            feature: {
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: valueList,
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} °c'
            },
            axisPointer: {
                snap: true
            }
        },
        series: [
            {
                name:'温度',
                type:'line',
                smooth: true,
                data: temList,
            }
        ]
    };
    var humOption = {
        title: {
            text: '湿度分布图',
            /*subtext: '纯属虚构'*/
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        toolbox: {
            show: true,
            feature: {
                saveAsImage: {}
            }
        },
        xAxis:  {
            type: 'category',
            boundaryGap: false,
            data: valueList,
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} %'
            },
            axisPointer: {
                snap: true
            }
        },
        series: [
            {
                name:'湿度',
                type:'line',
                smooth: true,
                data: humList,
            }
        ]
    };
    var temperatureChart = echarts.init(document.getElementById("echarts-temperature-chart"));
    temperatureChart.setOption(temOption);
    var humidityChart = echarts.init(document.getElementById("echarts-humidity-chart"));
    humidityChart.setOption(humOption);
</script>


</body>

</html>
