<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Inven</title>
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
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <form  action="{{ route('license.store') }}" method="POST" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">车牌号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="license" value="{{ old('license') }}" required="" aria-required="true" autocomplete="off">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">车牌颜色</label>
                            <div class="col-sm-10">
                                {{--<input type="text" class="form-control" name="colorType" value="{{ old('colorType') }}" required="" aria-required="true" autocomplete="off">--}}
                                <select name="colorType" id="" class="form-control">
                                    <option value="0">未知</option>
                                    <option value="1">蓝色</option>
                                    <option value="2">黄色</option>
                                    <option value="3">白色</option>
                                    <option value="4">黑色</option>
                                    <option value="5">绿色</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">车牌类型</label>
                            <div class="col-sm-10">
                                {{--<input type="text" class="form-control" name="type" value="{{ old('type') }}" required="" aria-required="true" autocomplete="off">--}}
                                <select name="type" id="" class="form-control">
                                    <option value="0">未知车牌</option>
                                    <option value="1">蓝牌小汽车</option>
                                    <option value="2">黑牌小汽车</option>
                                    <option value="3">单排黄牌</option>
                                    <option value="4">双排黄牌</option>
                                    <option value="5">警车车牌</option>
                                    <option value="6">武警车牌</option>
                                    <option value="7">个性化车牌</option>
                                    <option value="8">单排军车牌</option>
                                    <option value="9">双排军车牌</option>
                                    <option value="10">使馆车牌</option>
                                    <option value="11">香港进出中国大陆车牌</option>
                                    <option value="12">农用车牌</option>
                                    <option value="13">教练车牌</option>
                                    <option value="14">澳门进出中国大陆车牌</option>
                                    <option value="15">双层武警车牌</option>
                                    <option value="16">武警总队车牌</option>
                                    <option value="17">双层武警总队车牌</option>
                                    <option value="18">民航车牌</option>
                                    <option value="19">新能源车牌</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">颜色值</label>
                            <div class="col-sm-10 input-group colorpicker-demo2">
                                <input style="width: 50%;" type="text" name="colorValue" value="{{ old('colorValue') }}" class="form-control" required="" aria-required="true" autocomplete="off"/>
                                <span class="input-group-addon" style="float:left;"><i></i></span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">车身颜色</label>
                            <div class="col-sm-10 input-group colorpicker-demo2">
                                <input style="width: 50%;" type="text" class="form-control" name="carColor" value="{{ old('carColor') }}" required="" aria-required="true" autocomplete="off">
                                <span class="input-group-addon" style="float:left;"><i></i></span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">当前名单是否有效</label>
                            <div class="col-sm-10">
                                {{--<input type="text" class="form-control" name="enable" value="{{ old('enable') }}" required="" aria-required="true" autocomplete="off">--}}
                                <select name="enable" id="" class="form-control">
                                    <option value="1">有效</option>
                                    <option value="0">无效</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">当前名单是否黑名单</label>
                            <div class="col-sm-10">
                                {{--<input type="text" class="form-control" name="need_alarm" value="{{ old('need_alarm') }}" required="" aria-required="true" autocomplete="off">--}}
                                <select name="need_alarm" id="" class="form-control">
                                    <option value="0">非黑名单</option>
                                    <option value="1">是黑名单</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">当前名单生效时间</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="enable_time" value="{{ old('enable_time') }}" required="" aria-required="true" autocomplete="off">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">当前名单过期时间</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="overdue_time" value="{{ old('overdue_time') }}" required="" aria-required="true" autocomplete="off">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">保存</button>
                                <button class="btn btn-white" type="reset" onclick="javascript:history.back(-10);">取消</button>
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

</body>
</html>

