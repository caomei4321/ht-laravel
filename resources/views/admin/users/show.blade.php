<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 百度ECHarts</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/admin/favicon.ico') }}"> <link href="{{ asset('assets/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">

    <link href="{{ asset('assets/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/js/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
    <!-- Data Tables -->
    <link href="{{ asset('assets/admin/css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- Data picker -->
    <link href="{{ asset('assets/admin/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>所有表单元素 <small>包括自定义样式的复选和单选按钮</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="form_basic.html#">选项1</a>
                            </li>
                            <li><a href="form_basic.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                        <form method="" action="" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">姓名：</label>

                                        <div class="col-sm-6">
                                            <input name="name" id="name" type="text" class="form-control" value="{{ old('name',$user->name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">工号：</label>

                                        <div class="col-sm-10">
                                            <input type="text" id="device_no" name="job_number" class="form-control" value="{{ old('job_number',$user->job_number) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">照片：</label>
                                        @if($user->image)
                                            <a class="fancybox" href="{{ $user->image }}" >
                                                <img alt="image" src="{{ $user->image }}" />
                                            </a>
                                            {{--<div class="col-sm-6">--}}
                                            {{--<img alt="image" src="{{ $user->image }}" width="200">--}}
                                            {{--</div>--}}
                                        @endif
                                        {{--<button class="btn btn-info" type="button"><i class="fa fa-paste"></i> 上传图片</button>--}}
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                </form>
                </div>
                <div class="ibox-content">
                    <h3>打卡记录</h3>
                    {{--<a href="{{ route('device.map') }}"><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> 设备位置分布</button>--}}
                    {{--</a>--}}
                    <button class="btn btn-info " id="download" type="button"><i class="fa fa-paste"></i> 下载excel</button>
                    <form id="form" method="get" action="">
                        <div class="form-group form-inline row text-left" id="data_5">
                            <label class="font-noraml">范围选择</label>
                            {{ csrf_field() }}
                            <div class="input-daterange input-group" id="datepicker">

                                <input type="text" class="input-sm form-control" name="start_time" value="{{ isset($filter['start_time']) ? $filter['start_time'] : date("Y-m-d",time()) }}" />
                                <span class="input-group-addon">到</span>
                                <input type="text" class="input-sm form-control" name="end_time" value="{{ isset($filter['end_time']) ? $filter['end_time'] : date("Y-m-d",time()) }}" />

                            </div>
                            <div class="form-group">

                                <input type="submit" class="btn btn-primary" id="search" value="搜索">
                            </div>

                        </div>
                    </form>
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>工号</th>
                            <th>序列号</th>
                            <th>打卡时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userRecords as $userRecord)
                            <tr class="gradeC">
                                <td>{{ $userRecord->id }}</td>
                                <td>{{ $userRecord->job_number }}</td>
                                <td>{{ $userRecord->license }}</td>
                                <td>{{ $userRecord->time }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>工号</th>
                            <th>序列号</th>
                            <th>打卡时间</th>
                        </tr>
                        </tfoot>
                    </table>
                    {{--{{ $users->links() }}--}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 全局js -->
<script src="{{ asset('assets/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>

<!-- Data Tables -->
<script src="{{ asset('assets/admin/js/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>

<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>
<!-- Fancy box -->
<script src="{{ asset('assets/admin/js/plugins/fancybox/jquery.fancybox.js') }}"></script>
<!-- Data picker -->
<script src="{{ asset('assets/admin/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- ECharts demo data -->
{{--<script src="{{ asset('assets/admin/js/demo/echarts-demo.js') }}"></script>--}}

<script>
    $(document).ready(function () {
        $('#datepicker').datepicker();
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {
                allow_single_deselect: true
            },
            '.chosen-select-no-single': {
                disable_search_threshold: 10
            },
            '.chosen-select-no-results': {
                no_results_text: 'Oops, nothing found!'
            },
            '.chosen-select-width': {
                width: "95%"
            }
        };
        $('.dataTables-example').dataTable({
            "lengthChange": false,
            "paging": false,
            "order": [[ 3, 'desc' ]],
        });
        $('.fancybox').fancybox({
            openEffect: 'none',
            closeEffect: 'none'
        });
        $('#download').click(function () {
            $("#form").attr('action',"{{ route('report.userRecordDownload',['id' => $user->id]) }}");
            $("#form").submit();
        });
        $('#search').click(function () {
            $("#form").attr('action',"{{ route('report.userRecordReport',['id'  => $user->id]) }}");
            $("#form").submit();
        })
    })
</script>


</body>

</html>
