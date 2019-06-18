<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>车辆管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico">
    <link href="{{ asset('assets/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/chosen/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/cropper/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/nouslider/jquery.nouislider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/ionRangeSlider/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/select2.min.css') }}">
    <link href="{{ asset('assets/admin/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row J_mainContent">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>基本 <small>分类，查找</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div>
                        <a href="{{ route('license.create') }}" class="btn btn-primary">添加车牌白名单</a>
                    </div>
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>车牌id</th>
                            <th>车牌号</th>
                            <th>车牌颜色</th>
                            <th>车牌类型</th>
                            <th>颜色值</th>
                            <th>车身颜色</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($license as $v )
                            <tr class="gradeX">
                                <td>{{$v->id}}</td>
                                <td>{{$v->plateid}}</td>
                                <td>{{$v->license}}</td>
                                <td>{{$v->colorType}}</td>
                                <td>{{$v->type}}</td>
                                <td>{{$v->colorValue}}</td>
                                <td>{{$v->carColor}}</td>
                                <td>{{$v->created_at}}</td>
                                <td>{{$v->updated_at}}</td>
                                <td>
                                    <a href="{{ route('license.edit',['id' => $v->id]) }}" class="btn btn-info">编辑</a>
                                    <button class="btn btn-warning  delete" data-id="{{ $v->id }}">删除</button>
                                    <a href="{{ url('/license/delete') }}?id={{$v->id}}" class="btn btn-info">sc</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- 全局js -->
<script src="{{ asset('assets/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>

<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>

<!-- Select2 -->
<script src="{{ asset('assets/admin/js/select2.min.js') }}"></script>

<!-- Chosen -->
<script src="{{ asset('assets/admin/js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- JSKnob -->
<script src="{{ asset('assets/admin/js/plugins/jsKnob/jquery.knob.js') }}"></script>

<!-- Input Mask-->
<script src="{{ asset('assets/admin/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

<!-- Data picker -->
<script src="{{ asset('assets/admin/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Prettyfile -->
<script src="{{ asset('assets/admin/js/plugins/prettyfile/bootstrap-prettyfile.js') }}"></script>

<!-- NouSlider -->
<script src="{{ asset('assets/admin/js/plugins/nouslider/jquery.nouislider.min.js') }}"></script>

<!-- Switchery -->
<script src="{{ asset('assets/admin/js/plugins/switchery/switchery.js') }}"></script>

<!-- IonRangeSlider -->
<script src="{{ asset('assets/admin/js/plugins/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('assets/admin/js/plugins/iCheck/icheck.min.js') }}"></script>

<!-- MENU -->
<script src="{{ asset('assets/admin/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>

<!-- Color picker -->
<script src="{{ asset('assets/admin/js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>

<!-- Clock picker -->
<script src="{{ asset('assets/admin/js/plugins/clockpicker/clockpicker.js') }}"></script>

<!-- Image cropper -->
<script src="{{ asset('assets/admin/js/plugins/cropper/cropper.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/demo/form-advanced-demo.js') }}"></script>

<script src="{{ asset('assets/admin/js/plugins/jeditable/jquery.jeditable.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate -->
<script src="{{ asset('assets/admin/js/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/validate/messages_zh.min.js') }}"></script>

<script src="{{ asset('assets/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
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
            cancelButtonText: "取消",
            closeOnConfirm: false
        }, function () {
            $.ajaxSetup({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"delete",
                url: '/admin/license/'+id,
                success:function (res) {
                    console.log(res);
                    if (res.status == 1) {
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

    $(document).ready(function () {
        $('.dataTables-example').dataTable();

        /* Init DataTables */
        var oTable = $('#editable').dataTable();

        /* Apply the jEditable handlers to the table */
        oTable.$('td').editable('../example_ajax.php', {
            "callback": function (sValue, y) {
                var aPos = oTable.fnGetPosition(this);
                oTable.fnUpdate(sValue, aPos[0], aPos[1]);
            },
            "submitdata": function (value, settings) {
                return {
                    "row_id": this.parentNode.getAttribute('id'),
                    "column": oTable.fnGetPosition(this)[2]
                };
            },

            "width": "90%",
            "height": "100%"
        });


    });

    function fnClickAddRow() {
        $('#editable').dataTable().fnAddData([
            "Custom row",
            "New row",
            "New row",
            "New row",
            "New row"]);

    }



</script>

</body>

</html>
