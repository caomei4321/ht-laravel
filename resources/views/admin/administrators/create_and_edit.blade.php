<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/admin/favicon.ico') }}"> <link href="{{ asset('assets/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">
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
                @if($administrator->id)
                <h5>添加管理员信息</h5>
                @else
                <h5>修改管理员信息</h5>
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
                @if(empty($administrator->id))
                <form method="post" action="{{ route('admin.administrators.store') }}" class="form-horizontal">
                    @else
                    <form method="POST" action="{{ route('admin.administrators.update',$administrator->id) }}" class="form-horizontal">
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
                            <label class="col-sm-2 control-label">姓名：</label>

                            <div class="col-sm-6">
                                <input name="name" id="name" type="text" class="form-control" value="{{ old('name',$administrator->name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机号(登录账号)：</label>

                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control" value="{{ old('email',$administrator->email) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">密码：</label>

                            <div class="col-sm-6">
                                <input type="password" id="password" name="password" class="form-control" value="{{ old('password',$administrator->password) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色：</label>

                            <div class="col-sm-6">
                                <select class="chosen-select" data-placement="选择角色" name="administrator_roles[]" multiple style="width: 350px;" tabindex="2">
                                    @if($administrator->id)
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if (in_array($role->name,$administrator_roles)) selected="selected" @endif>{{ $role->name }}</option>
                                        @endforeach
                                    @else
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属公司：</label>

                            <div class="col-sm-6">
                            <select class="chosen-select" data-placement="选择搅拌站" name="company_id" style="width: 350px;" tabindex="2">
                                <option value="">选择公司</option>
                                @if($administrator->id)
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" @if ($company->id == $administrator->company_id) selected="selected" @endif>{{ $company->company_name }}</option>
                                    @endforeach
                                @else
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach
                                @endif
                            </select>
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
<script src="{{ asset('assets/admin/js/plugins/jeditable/jquery.jeditable.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery-ui-1.10.4.min.js') }}"></script>
<!-- Chosen -->
<script src="{{ asset('assets/admin/js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- 自定义js -->
{{--<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>--}}
<script>
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
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
</body>

</html>