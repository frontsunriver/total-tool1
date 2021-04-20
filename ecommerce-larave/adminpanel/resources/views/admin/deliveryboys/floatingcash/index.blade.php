@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Floating Cash') }} <small>{{ trans('labels.Floating Cash Amount') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/deliveryboys/display')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.Delivery Boys') }}</a></li>
            <li class="active">{{ trans('labels.Floating Cash') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
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
                                            <th>@sortablelink('id', trans('labels.ID') )</th>
                                            <th>{{ trans('labels.Name') }}</th>
                                            <th>{{ trans('labels.OrderID') }}</th>
                                            <th>@sortablelink('amount', trans('labels.Amount') )</th>
                                            <th>@sortablelink('created_at', trans('labels.Delivered Date') )</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customers-table">
                                        @if (isset($data['floatingcash']))
                                        @foreach ($data['floatingcash'] as $key=>$users)
                                        <tr>
                                            <td>{{ $users->floating_cash_id }}</td>
                                            <td>
                                                {{ $users->first_name }} {{ $users->last_name }}
                                            </td>
                                            <td>
                                                {{ $users->orders_id }} 
                                            </td>
                                            <td>
                                                {{$data['setting'][19]->value}}{{ $users->amount }}
                                            </td>
                                            <td>                                               
                                                {{ $users->created_at }}
                                            </td>
                                            <td width="20%">
                                            @if($users->status==0)
                                                <a class="btn btn-warning payment-recieved" orders_id = "{{ $users->orders_id }}" style="width: 100%; margin-bottom: 5px;" href="#">{{ trans('labels.Recieved Payment') }}</a>
                                            @else
                                            <a class="btn btn-success" >{{ trans('labels.Recieved') }}</a>
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4">{{ trans('labels.NoRecordFound') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                               
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

        <!-- bankinfo -->
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="paymentModalLabel">{{ trans('labels.Recieved Payment') }}</h4>
                    </div>
                    {!! Form::open(array('url' =>'admin/deliveryboys/floatingcash/recieved', 'name'=>'deleteCustomer', 'id'=>'deleteCustomer', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                    {!! Form::hidden('orders_id', '', array('class'=>'form-control', 'id'=>'orders_id')) !!}
                    <div class="modal-body">
                        <p>{{ trans('labels.Are you sure you have recieved payment from this order') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.No') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('labels.Yes') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

@endsection
