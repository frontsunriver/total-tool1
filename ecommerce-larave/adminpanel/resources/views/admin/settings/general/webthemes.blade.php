@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.themeSetting') }}<small>{{ trans('labels.themeSetting') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.themeSetting') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.themeSetting') }}</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!--<div class="box-header with-border">
                                          <h3 class="box-title">Setting</h3>
                                        </div>-->
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            <div class="alert alert-success applied_message" hidden="hidden" role="alert">
                                                <span class="icon fa fa-check" aria-hidden="true"></span>
                                                {{ trans('labels.updateThemeMessage') }}
                                            </div>

                                            {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                            <h4>{{ trans('labels.chooseWebTheme') }}</h4>
                                            <hr>

                                            <div class="row">
                                                <div class="col-md-3 col-xs-6">
                                                    <label class="thumbnail checkbox text-center">
                                                        <img alt="100%x180" data-src="holder.js/100%x180" style="height: 180px; width: 100%; display: block;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTcxIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE3MSAxODAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MTgwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTYzNzMwZDgwOGEgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNjM3MzBkODA4YSI+PHJlY3Qgd2lkdGg9IjE3MSIgaGVpZ2h0PSIxODAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI1OS41NTQ2ODc1IiB5PSI5NC41Ij4xNzF4MTgwPC90ZXh0PjwvZz48L2c+PC9zdmc+" data-holder-rendered="true">
                                                        <input type="radio" name="website_theme" class="website_themes"
                                                               @if($result['commonContent']['setting']['order_email'] == '1')
                                                               checked
                                                               @endif
                                                               value="1"> {{ trans('labels.Style1') }}
                                                    </label>
                                                </div>
                                                <div class="col-md-3 col-xs-6">
                                                    <label class="thumbnail checkbox text-center">
                                                        <div class="comming-soon">
                                                            <p>{{ trans('labels.coming_soon') }}</p>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="col-md-3 col-xs-6">
                                                    <label class="thumbnail checkbox text-center">
                                                        <div class="comming-soon">
                                                            <p>{{ trans('labels.coming_soon') }}</p>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="col-md-3 col-xs-6">
                                                    <label class="thumbnail checkbox text-center">
                                                        <div class="comming-soon">
                                                            <p>{{ trans('labels.coming_soon') }}</p>
                                                        </div>

                                                    </label>
                                                </div>

                                            </div>



                                            <!-- /.box-footer -->
                                            {!! Form::close() !!}</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection