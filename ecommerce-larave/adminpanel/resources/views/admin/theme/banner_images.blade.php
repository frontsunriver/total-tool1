@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Theme Setting') }} <small>{{ trans('labels.Home Page Customization') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li >{{ trans('labels.link_site_settings') }}</li>
            <li >{{ trans('labels.Theme Setting') }}</li>
            <li class="active">{{ trans('labels.Home Page') }}</li>

        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                    <!-- /.box-header -->
                    <div id="app">
                      <?php  echo $banner; ?>
                    </div>
                    <script>
                    window.onload=function(){
                      document.getElementById("linkid").click();
                    };
                    </script>
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
<script src="{{asset('js/app.js')}}"></script>
@endsection
