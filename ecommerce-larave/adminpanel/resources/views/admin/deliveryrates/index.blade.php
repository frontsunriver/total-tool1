@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.shippingrates') }} <small>{{ trans('labels.shippingrates') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active"> {{ trans('labels.shippingrates') }}</li>
    </ol>
  </section>

  <!--  content -->
  <section class="content">
    <!-- Info boxes -->

    <!-- /.row -->

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <div class="col-lg-6 form-inline" id="contact-form">
                <form name='registration' id="registration" class="registration" method="get" action="{{url('admin/deliveryrates/filter')}}">
                  <input type="hidden" value="{{csrf_token()}}">
                  <div class="input-group-form search-panel ">
                    <select type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" name="FilterBy" id="FilterBy">
                      <option value="" selected disabled hidden>{{ trans('labels.Filter By') }}</option>
                      <option value="Zones" @if(isset($name)) @if ($name=="Zones" ) {{ 'selected' }} @endif @endif>{{ trans('labels.Zone') }}</option>
                    </select>
                    <input type="text" class="form-control input-group-form " name="parameter" placeholder="Search term..." id="parameter" @if(isset($parameter)) value="{{$parameter}}" @endif>
                    <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    @if(isset($parameter,$name)) <a class="btn btn-danger " href="{{url('admin/deliveryrates/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                  </div>
                </form>
                <div class="col-lg-4 form-inline" id="contact-form12"></div>
            </div>

            <div class="box-tools pull-right">
            	<a href="{{ URL::to('admin/deliveryrates/add')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.Addshippingrates') }}</a>
            </div>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.Zone') }}</th>
                      <th>{{ trans('labels.Time Duration') }}</th>
                      <th>{{ trans('labels.Rates') }}</th>
                      <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $key=>$taxRate)
                        <tr>
                            <td>{{ $taxRate->zone_name }}</td>
                            <td>{{ date('h:i A',$taxRate->time_from) }} - {{ date('h:i A',$taxRate->time_to) }}</td>
                            <td>{{ $taxRate->delivery_price }}</td>
                            <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="{{url('admin/deliveryrates/edit/'. $taxRate->delievery_time_slot_with_zone_id) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteCustomerFrom" users_id="{{ $taxRate->delievery_time_slot_with_zone_id }}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{$data->links()}}
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
        <!-- deletetaxRateModal -->
        <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="deleteCustomerModalLabel">{{ trans('labels.Delete') }}</h4>
                    </div>
                    {!! Form::open(array('url' =>'admin/deliveryrates/delete', 'name'=>'deleteCustomer', 'id'=>'deleteCustomer', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                    {!! Form::hidden('action', 'delete', array('class'=>'form-control')) !!}
                    {!! Form::hidden('id', '', array('class'=>'form-control', 'id'=>'users_id')) !!}
                    <div class="modal-body">
                        <p>{{ trans('labels.DeleteRecordText') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('labels.Delete') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    <!--  row -->

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection
