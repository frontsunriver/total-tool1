@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.EditOrderStatus') }} <small>{{ trans('labels.EditOrderStatus') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/orders/orderstatus')}}"><i class="fa fa-dashboard"></i>{{ trans('labels.ListingOrderStatus') }}</a>
                <li class="active">{{ trans('labels.EditOrderStatus') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.EditOrderStatus') }}</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/orders/updateOrderStatus', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                              {!! Form::hidden('id', $result['orders_status']->orders_status_id) !!}
                                              <div class="form-group" hidden>
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status Type') }}</label>
                                                  <div class="col-sm-10 col-md-4">
                                                      <select name="role_id" class="form-control" >
                                                          <option value="2" @if($result['orders_status']->role_id==2) selected @endif>{{ trans('labels.General') }}</option>
                                                          {{-- <option value="2" @if($result['orders_status']->role_id==3) selected @endif>{{ trans('labels.Vendors') }}</option>
                                                          <option value="3" @if($result['orders_status']->role_id==4) selected @endif>{{ trans('labels.Delivery Boy') }}</option> --}}
                                                      </select>
                                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.StatusLanguageText') }}</span>
                                                  </div>
                                              </div>

                                              @foreach($result['description'] as $content)
                                                  <div class="form-group">
                                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.OrdersStatus') }} ({{ $content['language_name'] }})</label>
                                                      <div class="col-sm-10 col-md-4">
                                                          <input type="text" name="OrdersStatus_<?=$content['languages_id']?>" class="form-control field-validate" value="{{$content['orders_status_name']}}" >
                                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.textRequiredFieldMessage') }} ({{ $content['language_name'] }}).</span>
                                                          <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                      </div>
                                                  </div>
                                              @endforeach



                                            <div class="form-group" style="display:none;">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Set Default') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="public_flag" class="form-control">
                                                        <option value="0" @if($result['orders_status']->public_flag==0) selected @endif>{{ trans('labels.No') }}</option>
                                                        <option value="1" @if($result['orders_status']->public_flag==1) selected @endif>{{ trans('labels.Yes') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.StatusLanguageText') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="../orderstatus" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                                </div>
                                            </div>
                                            <!-- /.box-footer -->
                                            {!! Form::close() !!}
                                        </div>
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
