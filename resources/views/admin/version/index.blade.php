<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>版本管理</title>
    <meta name="keywords" content="三晖人脸识别后台管理">
    <meta name="description" content="三晖人脸识别后台管理">
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
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>基本 <small>分类，查找</small></h5>
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
                    <a href="{{ route('admin.version.create') }}"><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> 添加新版本</button>
                        </a>
                    {{--<a href="{{ route('device.map') }}"><button class="btn btn-info " type="button"><i class="fa fa-paste"></i> 设备位置分布</button>--}}
                        {{--</a>--}}
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>版本号</th>
                            <th>下载地址</th>
                            <th>版本描述</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($versions as $version)
                        <tr class="gradeC">
                            <td>{{ $version->id }}</td>
                            <td>{{ $version->name }}</td>
                            <td>{{ $version->version_number }}</td>
                            <td>{{ $version->version_url }}</td>
                            <td>{{ $version->description }}</td>
                            <td>{{ $version->created_at }}</td>
                            <td class="center">
                                <button class="btn btn-warning btn-xs delete" data-id="{{ $version->id }}">删除</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>版本号</th>
                            <th>下载地址</th>
                            <th>版本描述</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
                    </table>
                    {{ $versions->links() }}
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

<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>


<!-- Page-Level Scripts -->
<script>
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
                url: '/admin/version/'+id,
                success:function (res) {
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
    $('.dataTables-example').dataTable({
        "lengthChange": false,
        "paging": false
    });
</script>

</body>

</html>
