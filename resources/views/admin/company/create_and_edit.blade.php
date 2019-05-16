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
    <link href="{{ asset('assets/admin/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    @if($company->id))
                    <h5>添加公司信息</h5>
                    @else
                    <h5>修改公司信息</h5>
                    @endif
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
                    @if(empty($company->id))
                    <form method="post" action="{{ route('admin.company.store') }}" class="form-horizontal">
                        @else
                        <form method="POST" action="{{ route('admin.company.update',$company->id) }}" class="form-horizontal">
                            <input type="hidden" name="_method" value="PUT">
                            @endif
                            <div class="form-group">
                                @if( count($errors) >0)
                                @foreach($errors->all() as $error)
                                <p class="text-danger text-center">{{ $error }}</p>
                                @endforeach
                                @endif
                            </div>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">公司名称：</label>

                                <div class="col-sm-6">
                                    <input name="company_name" type="text" class="form-control" value="{{ old('company_name',$company->company_name) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上班时间：</label>

                                <div class="col-sm-6 clockpicker" data-autoclose="true">
                                    <input type="text" name="working_at" class="form-control" value="{{ old('working_at',$company->working_at) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">下班时间：</label>

                                <div class="col-sm-6 clockpicker" data-autoclose="true">
                                    <input type="text" name="end_at" class="form-control" value="{{ old('end_at',$company->end_at) }}">
                                </div>
                            </div>
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
    <!-- Clock picker -->
    <script src="{{ asset('assets/admin/js/plugins/clockpicker/clockpicker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.clockpicker').clockpicker();
        });
    </script>
</body>

</html>