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
                    <h5>今日打卡人员</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="table_data_tables.html#">选项1</a>
                            </li>
                            <li><a href="table_data_tables.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {{--<div class="form-group" id="data-1">--}}

                    {{--</div>--}}
                    {{--<a href="{{ route('user.create') }}"><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> 添加人员</button>--}}
                        {{--</a>--}}
                    <form method="get" action="{{ route('userRecord.search') }}">
                    <div class="form-group form-inline row text-left" id="data_5">
                        {{--<label class="font-noraml">范围选择</label>--}}
                        {{--{{ csrf_field() }}--}}
                        <div class="input-daterange input-group" id="datepicker">

                            <input type="text" class="input-sm form-control" name="start_time" value="{{ isset($filter['start_time']) ? $filter['start_time'] : date("Y-m-d",time()) }}" />
                            <span class="input-group-addon">到</span>
                            <input type="text" class="input-sm form-control" name="end_time" value="{{ isset($filter['end_time']) ? $filter['end_time'] : date("Y-m-d",time()) }}" />
                            {{--<span class="input-group-addon">&nbsp&nbsp&nbsp&nbsp工号：</span>--}}
                            {{--<input type="text" name="" class="input-sm form-control" placeholder="工号">--}}

                        </div>
                        <div class="form-group">
                            {{--<label class="col-sm-3 control-label">文本框：</label>--}}
                            <input type="text" name="job_number" class="input-sm form-control" placeholder="请输入工号" value="{{ isset($filter['job_number']) ? $filter['job_number'] : '' }}">
                            <select class="chosen-select" name="department_id" style="width: 200px;" tabindex="2" >
                                <option value="">请选择部门</option>
                                {{--{{ dd($departments) }--}}}
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" hassubinfo="true" @if( $filter['department_id'] == $department->id) selected @endif>{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                            <select class="chosen-select" name="times" style="width: 200px;" tabindex="2" >
                                <option value="">请选择时间段</option>
                                {{--{{ dd($departments) }--}}}
                                <option value="1" @if( $filter['times'] == 1) selected @endif>上午</option>
                                <option value="2" @if( $filter['times'] == 2) selected @endif>下午</option>
                            </select>
                            <input type="submit" class="btn btn-primary" value="搜索">
                            {{--<button class="btn btn-primary" id="search">搜 索</button>--}}
                        </div>

                    </div>
                    </form>
                    {{--<a href="{{ route('device.map') }}"><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> 设备位置分布</button>--}}
                        {{--</a>--}}
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>工号</th>
                            <th>序列号</th>
                            <th>打卡时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userRecords as $userRecord)
                        <tr class="gradeC">
                            <td>{{ $userRecord->id }}</td>
                            <td>{{ $userRecord->user['name'] }}</td>
                            <td>{{ $userRecord->job_number }}</td>
                            <td>{{ $userRecord->license }}</td>
                            <td>{{ $userRecord->time }}</td>
                            <td class="center">
                                {{--<a href="{{ route('userRecord.edit',['userRecord' => $userRecord->id]) }}"><button type="button" class="btn btn-primary btn-xs">编辑</button></a>
                                <a href="{{ route('userRecord.show',['userRecord' => $userRecord->id]) }}"><button type="button" class="btn btn-danger btn-xs">查看</button></a>--}}
                                <button class="btn btn-warning btn-xs delete" data-id="{{ $userRecord->id }}">删除</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>工号</th>
                            <th>序列号</th>
                            <th>打卡时间</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
                    </table>
                    {{ $userRecords->appends($filter)->links() }}
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

<!-- Sweet alert -->
<script src="{{ asset('assets/admin/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Data picker -->
<script src="{{ asset('assets/admin/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<!-- Chosen -->
<script src="{{ asset('assets/admin/js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>


<!-- Page-Level Scripts -->
<script>
    $(document).ready(function () {
        $('.delete').click(function () {
            var id = $(this).data('id');
            console.log(id);
            swal({
                title: "您确定要删除这条信息吗",
                text: "删除后将无法恢复，请谨慎操作！",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "删除",
                closeOnConfirm: false
            }, function () {
                $.ajaxSetup({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"delete",
                    url: '/admin/userRecord/'+id,
                    success:function (res) {
                        console.log(res)
                        if (res.status = 1) {
                            swal("删除成功！", "您已经永久删除了这条信息。", "success");
                            location.reload();
                        } else {
                            swal("删除失败！", "请稍后重试。", "error");
                        }


                    },
                });
                $.ajax();
            });
        });
        $('#search').click(function () {
            var start_time = $('')
        });
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
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        $('.dataTables-example').dataTable({
            "lengthChange": false,
            "paging": false
        });
    })
</script>

</body>

</html>
