<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="favicon.ico"> <link href="{{ asset('assets/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
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
                        <form method="post" action="{{ route('device.store') }}" class="form-horizontal">
                        <div class="form-group">
                            @if( count($errors) >0)
                                @foreach($errors->all() as $error)
                                    <p class="text-danger text-center">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                        {{ csrf_field() }}
                        {{--<div class="form-group">
                            <label class="col-sm-2 control-label">设备名称：</label>

                            <div class="col-sm-6">
                                <input name="name" id="name" type="text" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>--}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">设备编号：</label>

                            <div class="col-sm-10">
                                <input type="text" id="device_no" name="device_no" class="form-control" value="{{ old('device_no',$device->device_no) }}">
                            </div>
                        </div>
                        {{--<div class="form-group">
                            <label class="col-sm-2 control-label">设备位置：</label>

                            <div class="col-sm-10">
                                <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}">
                            </div>
                        </div>--}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注：</label>

                            <div class="col-sm-10">
                                <input type="text" id="remark" name="remark" class="form-control" value="{{ old('remark',$device->remark) }}">
                            </div>
                        </div>
                        @role('administrator')
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属公司：</label>

                            <div class="col-sm-6">
                                <select class="chosen-select" name="company_id" style="width: 350px;" tabindex="2" >
                                    <option value="">请选择公司</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" hassubinfo="true" @if ( $device->company_id == $company->id) selected @endif>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endrole
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" id="add_device">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 全局js -->
<script src="{{ asset('assets/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>
<!-- Chosen -->
<script src="{{ asset('assets/admin/js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- 自定义js -->
<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>

<script>
    $(document).ready(function () {
        /*$("#add_device").onclick(function () {
            var data = {
                'name': $("#name").value,
                'device_no': $("#device_no").value,
                'address': $("#address").value,
                'remark' :$("#remark").value
            };
            console.log(data);
        });*/
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
    });
</script>

</body>

</html>