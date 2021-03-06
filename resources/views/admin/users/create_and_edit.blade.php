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
    <link href="{{ asset('assets/admin/js/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
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
                        @if($user->id)
                        <form method="POST" action="{{ route('user.update',['user'=>$user->id]) }}" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        @else
                        <form method="POST" action="{{ route('user.store') }}" class="form-horizontal" enctype="multipart/form-data">
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
                                <input name="name" id="name" type="text" class="form-control" value="{{ old('name',$user->name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">工号：</label>

                            <div class="col-sm-6">
                                <input type="text" id="device_no" name="job_number" class="form-control" value="{{ old('job_number',$user->job_number) }}">
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="col-sm-2 control-label">手机号：</label>
                             <div class="col-sm-6">
                                 <input name="phone" id="phone" type="text" class="form-control" value="{{ old('phone',$user->phone) }}">
                             </div>
                        </div>
                        <div class="form-group">
                             <label class="col-sm-2 control-label">密码：</label>
                             <div class="col-sm-6">
                                <input name="password" id="password" type="password" class="form-control" value="{{ old('passwor',$user->password) }}">
                             </div>
                        </div>
                        {{--@role('administrator')
                        <div class="form-group">
                            <label class="col-sm-2 control-label">公司：</label>
                            <div class="col-sm-6">
                                <select class="chosen-select" name="company_id" style="width: 350px;" tabindex="2" >
                                    <option value="">请选择公司</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" hassubinfo="true" @if ( $user->company_id == $company->id) selected @endif>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endrole--}}
                        <div class="form-group">
                             <label class="col-sm-2 control-label">部门：</label>
                             <div class="col-sm-6">
                                 <select class="chosen-select" name="department_id" style="width: 350px;" tabindex="2" >
                                     <option value="">请选择部门</option>
                                     @foreach($departments as $department)
                                     <option value="{{ $department->id }}" hassubinfo="true" @if ( $user->department_id == $department->id) selected @endif>{{ $department->department_name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">设备：</label>
                            <div class="col-sm-6">
                                <select class="chosen-select" data-placement="请选择设备" name="device[]" multiple style="width: 350px;" tabindex="2" >
                                    @if($user->id)
                                        @foreach($devices as $device)
                                            <option value="{{ $device->id }}"  @if( array_search($device->id,array_column($user_device,'id','id'))) selected="selected" @endif>{{ $device->device_no }}==={{ $device->remark }}</option>
                                        @endforeach
                                    @else
                                        @foreach($devices as $device)
                                            <option value="{{ $device->id }}">{{ $device->device_no }}==={{ $device->remark }}</option>
                                        @endforeach
                                    @endif
                                </select>
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
                            <input type="file" name="image" value="上传头像">
                            {{--<button class="btn btn-info" type="button"><i class="fa fa-paste"></i> 上传图片</button>--}}
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
<!-- Fancy box -->
<script src="{{ asset('assets/admin/js/plugins/fancybox/jquery.fancybox.js') }}"></script>
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
        })*/
        $('.fancybox').fancybox({
            openEffect: 'none',
            closeEffect: 'none'
        });
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
    });
</script>

</body>

</html>