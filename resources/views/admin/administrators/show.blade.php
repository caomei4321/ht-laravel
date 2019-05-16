@extends('admin.common.app')

@section('styles')
    {{--<link href="{{ asset('assets/admin/css/plugins/chosen/chosen.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                        <h5>管理员信息</h5>
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
                                                <input type="text" id="name" name="name" class="form-control" value="{{ $administrator->name }}">
                                        </div>
                                    </div>
                                    {{--<div class="form-group">
                                        <label class="col-sm-2 control-label">所属搅拌站：</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $administrator->name }}">
                                        </div>
                                    </div>--}}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">手机号(登录账号)：</label>

                                        <div class="col-sm-6">
                                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $administrator->phone }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">密码：</label>

                                        <div class="col-sm-6">
                                            <input type="password" id="password" name="password" class="form-control" value="{{ $administrator->password }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">角色：</label>

                                        <div class="col-sm-6">
                                            <p>
                                                @foreach($administrator->getRoleNames() as $roleName)
                                                {{--{{ $administrator->getRoleNames() }}--}}
                                                <button type="button" class="btn btn-outline btn-info">{{ $roleName }}</button>
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">搅拌站：</label>

                                        <div class="col-sm-6">
                                            @if($administrator->station['station_name'])
                                            <p><button type="button" class="btn btn-outline btn-info">{{ $administrator->station['station_name'] }}</button></p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chosen -->
    <script src="{{ asset('assets/admin/js/plugins/chosen/chosen.jquery.js') }}"></script>
@endsection
<!-- 自定义js -->
{{--<script src="{{ asset('assets/admin/js/content.js?v=1.0.0') }}"></script>--}}
@section('javascript')
    <script>
        /*$(document).ready(function () {
            $("#add_device").onclick(function () {
                var data = {
                    'truck_pass' : $('#truck_name').val(),
                };
                console.log(data);
            })
        });*/

    </script>
@endsection
