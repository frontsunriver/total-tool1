@extends('admin.layout')
@section('content')
<link href="{!! asset('admin/css/menu.css') !!} " media="all" rel="stylesheet" type="text/css" />
<script>
    var _BASE_URL = "{{url('/admin')}}";
    var current_group_id = 1;
    </script>
    <div class="content-wrapper">
        <!-- Content Header (menu header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Menus') }} <small>{{ trans('labels.ListingAllMenus') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Menus') }} </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.Menus') }} </h3>
                        <div class="box-tools pull-right" style="top: 15px;">
                            <a href="{{ URL::to('admin/catalogmenu') }}" style="display: inline" type="button" class="btn btn-block btn-success">{{ trans('labels.GenerateCatalog') }}</a>
                            <a href="{{ URL::to('admin/addmenus') }}" style="display: inline" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewMenu') }}</a>
                        </div>
                        </br>
                        </br>
                    </div>
                    <div class="box-body">
                    @if (count($errors) > 0)
                        @if($errors->any())
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{$errors->first()}}
                            </div>
                        @endif
                    @endif

                     <form method="post" id="form-menu" action="{{url('/admin/menuposition')}}">
                        @if(!empty($result["menus"]))
                            {!! $result["menus"] !!}
                        @endif

                        <div class="box-header">
                            <div class="col-lg-6 form-inline" id="contact-form">
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="alert alert-success alert-dismissible" id="sorted" role="alert" style="display: none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                @lang('labels.Menussortedsuccessfully')
                            </div>
                            <div class=" pull-right">
                                <button type="submit" id="btn-save-menu" class="btn btn-block btn-primary">{{ trans('labels.SaveMenu') }}</button>
                            </div>
                        </div>
                     </form>
                    </div>
                </div>
                </div>
            </div>

            <div class="modal fade" id="deleteproductmodal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteProductModalLabel">{{ trans('labels.Delete') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deletemenu', 'name'=>'deleteProduct', 'id'=>'deleteProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'products_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteText') }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteProduct">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            

            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    <script src="{!! asset('admin/plugins/sort/jquery-1.9.1.min.js') !!}"></script>
    <script src="{!! asset('admin/plugins/sort/jquery-ui-1.10.3.custom.min.js') !!}"></script>
    <script src="{!! asset('admin/plugins/sort/jquery.ui.touch-punch.min.js') !!}"></script>
    <script src="{!! asset('admin/plugins/sort/jquery.mjs.nestedSortable.js') !!}"></script>
    <script src="{!! asset('admin/plugins/sort/menu.js') !!}"></script>
@endsection
