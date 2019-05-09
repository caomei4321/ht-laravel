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
    <!-- Data picker -->
    <link href="{{ asset('assets/admin/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">


    <link href="{{ asset('assets/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/chosen/chosen.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {{--<div class="form-group" id="data-1">--}}

                    {{--</div>--}}
                    <button class="btn btn-info " id="download" type="button"><i class="fa fa-paste"></i> 下载excel</button>

                    <form id="form" method="get" action="">
                        <div class="form-group form-inline row text-left" id="data_5">
                            <label class="font-noraml">选择日期</label>
                            {{ csrf_field() }}
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control" name="search_date" value="{{ isset($filter) ? $filter : date("Y-m-d",time()) }}" />
                            </div>
                            <div class="form-group">

                                <input type="submit" class="btn btn-primary" id="search" value="搜索">
                            </div>

                        </div>
                    </form>
                    {{--<a href="{{ route('device.map') }}"><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> 设备位置分布</button>--}}
                    {{--</a>--}}
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>早上打卡时间</th>
                            <th>晚上打卡时间</th>
                            <th>加班时长</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userRecords as $userRecord)
                            <tr class="gradeC">
                                <td>{{ $userRecord->name }}</td>
                                <td>{{ $userRecord->work_at }}</td>
                                <td>{{ $userRecord->endwork_at }}</td>
                                <td>{{ $userRecord->overTime }}</td>
                                {{--<td>{{ $userRecord->job_number }}</td>
                                <td>{{ $userRecord->license }}</td>
                                <td>{{ $userRecord->created_at }}</td>--}}
                                {{--<td class="center">
                                    --}}{{--<a href="{{ route('userRecord.edit',['userRecord' => $userRecord->id]) }}"><button type="button" class="btn btn-primary btn-xs">编辑</button></a>
                                    <a href="{{ route('userRecord.show',['userRecord' => $userRecord->id]) }}"><button type="button" class="btn btn-danger btn-xs">查看</button></a>--}}{{--
                                    --}}{{--<button class="btn btn-warning btn-xs delete" data-id="{{ $userRecord->id }}">删除</button>--}}{{--
                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--{{ $userRecords->appends($filter)->links() }}--}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 全局js -->
<script src="{{ asset('assets/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>

<script src="{{ asset('assets/admin/js/plugins/jeditable/jquery.jeditable.js') }}"></script>

<!-- Data Tables -->
<script src="{{ asset('assets/admin/js/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>

<!-- Data picker -->
<script src="{{ asset('assets/admin/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>


<!-- Page-Level Scripts -->
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
            "paging": false
        });
        $('#download').click(function () {
            $("#form").attr('action',"{{ route('report.detailReportDownload') }}");
            $("#form").submit();
        });
        $('#search').click(function () {
            $("#form").attr('action',"{{ route('report.detailReport') }}");
            $("#form").submit();
        })
    })
</script>

</body>

</html>
