@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.AddAddresses') }} <small>{{ trans('labels.AddCurrentAddresses') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/customers/display')}}"><i class="fa fa-users"></i> {{ trans('labels.ListingAllCustomers') }}</a></li>
                <li class="active">{{ trans('labels.AddAddresses') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    @if (session('update'))
                        <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong> {{ session('update') }} </strong>
                        </div>
                    @endif

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.ListingCustomerAddresses') }}</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#addAdressModal">{{ trans('labels.AddAddress') }}</button>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
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

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('labels.ID') }}</th>
                                            <th>{{ trans('labels.BasicInfo') }}</th>
                                            <th>{{ trans('labels.AddressInfo') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="contentAttribute">

                                        @if (count($data['customer_addresses']) > 0)
                                            @foreach($data['customer_addresses'] as $customer_addresses)
                                                <tr>
                                                    <td>{{ $customer_addresses->address_book_id }}</td>
                                                    <td>
                                                        <strong>{{ trans('labels.Company') }}:</strong> {{ $customer_addresses->entry_company }}<br>
                                                    <!--<strong>Gender:</strong> {{ $customer_addresses->entry_gender }}<br>-->
                                                        <strong>{{ trans('labels.FirstName') }}:</strong> {{ $customer_addresses->entry_firstname }}<br>
                                                        <strong>{{ trans('labels.LastName') }}:</strong> {{ $customer_addresses->entry_lastname }}
                                                    </td>
                                                    <td>
                                                        <strong>{{ trans('labels.Street') }}:</strong> {{ $customer_addresses->entry_street_address }}<br>
                                                        <strong>{{ trans('labels.Suburb') }}:</strong> {{ $customer_addresses->entry_suburb }}<br>
                                                        <strong>{{ trans('labels.Postcode') }}:</strong> {{ $customer_addresses->entry_postcode }}<br>
                                                        <strong>{{ trans('labels.City') }}:</strong> {{ $customer_addresses->entry_city }}<br>
                                                        <strong>{{ trans('labels.State') }}:</strong>@if(!is_numeric($customer_addresses->entry_state)) {{ $customer_addresses->entry_state }} @else {{ $customer_addresses->zone_name }} @endif<br>
                                                        <!-- <strong>{{ trans('labels.Zone') }}:</strong> {{ $customer_addresses->zone_name }}<br> -->
                                                        <strong>{{ trans('labels.Country') }}:</strong> {{ $customer_addresses->countries_name }}
                                                    </td>
                                                    <td>
                                                        <a class="badge bg-light-blue editAddressModal" user_id = '{{ $data['user_id'] }}' address_book_id = "{{ $customer_addresses->address_book_id }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a address_book_id = "{{ $customer_addresses->address_book_id }}" class="badge bg-red deleteAddressModal"><i class="fa fa-trash " aria-hidden="true"></i></a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="box-footer text-center">
                                <a href="{{ URL::to('admin/customers/display')}}" class="btn btn-primary">{{ trans('labels.SaveComplete') }}</a>
                            </div>
                            <!-- /.box-body -->
                        </div>

                        <!-- addAdressModal -->
                        <div class="modal fade" id="addAdressModal" tabindex="-1" role="dialog" aria-labelledby="addAdressModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="addAdressModalLabel">{{ trans('labels.AddAddress') }}</h4>
                                    </div>
                                    {!! Form::open(array('url' =>'', 'name'=>'addAddressFrom', 'id'=>'addAddressFrom', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                    {!! Form::hidden('user_id',  $data['user_id'] , array('class'=>'form-control', 'id'=>'entry_company')) !!}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Company') }}</label>
                                            <div class="col-sm-10 col-md-8">
                                                {!! Form::text('entry_company',  '', array('class'=>'form-control', 'id'=>'entry_company')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FirstName') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-8">
                                                {!! Form::text('entry_firstname',  '', array('class'=>'form-control field-validate', 'id'=>'entry_firstname')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.LastName') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-8">
                                                {!! Form::text('entry_lastname',  '', array('class'=>'form-control field-validate', 'id'=>'entry_lastname')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Address') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-8">
                                                {!! Form::text('entry_street_address',  '', array('class'=>'form-control field-validate', 'id'=>'entry_street_address')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Suburb') }}</label>
                                            <div class="col-sm-10 col-md-8">
                                                {!! Form::text('entry_suburb',  '', array('class'=>'form-control', 'id'=>'entry_suburb')) !!}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Postcode') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-8">
                                                {!! Form::text('entry_postcode',  '', array('class'=>'form-control field-validate', 'id'=>'entry_postcode')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.City') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-8">
                                                {!! Form::text('entry_city',  '', array('class'=>'form-control field-validate', 'id'=>'entry_city')) !!}
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Country') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-8">
                                                <select id="entry_country_id" class="form-control" name="entry_country_id">
                                                    <option value="">{{ trans('labels.SelectCountry') }}</option>
                                                    @foreach($data['countries'] as $countries_data)
                                                        <option value="{{ $countries_data->countries_id }}">{{ $countries_data->countries_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group selectstate" style="display: none" >
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.State') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-8">
                                                <select class="form-control zoneContent" name="entry_state_box">
                                                    <option value="">{{ trans('labels.State') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group otherstate" style="display: none">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.State') }}<span style="color:red;">*</span></label>
                                            <div class="col-sm-10 col-md-8">
                                                {!! Form::text("entry_state",  "", array("class"=>"form-control entry_state", "id"=>"entry_state")) !!}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.DefaultShippingAddress') }}</label>
                                            <div class="col-sm-10 col-md-8">
                                                <select id="is_default" class="form-control" name="is_default">
                                                    <option value="0">{{ trans('labels.No') }}</option>
                                                    <option value="1">{{ trans('labels.Yes') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                                        <button type="button" class="btn btn-primary form-validate" id="addAddress">{{ trans('labels.AddAddress') }}</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                        <!-- editAddressModal -->
                        <div class="modal fade" id="editAddressModal" tabindex="-1" role="dialog" aria-labelledby="editAddressModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content editContent">

                                </div>
                            </div>
                        </div>

                        <!-- deleteAddressModal -->
                        <div class="modal fade" id="deleteAddressModal" tabindex="-1" role="dialog" aria-labelledby="deleteAddressModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="deleteAddressModalLabel">{{ trans('labels.DeleteAddress') }}</h4>
                                    </div>
                                    {!! Form::open(array('url' =>'admin/customers/deleteAddress', 'name'=>'deleteAddress', 'id'=>'deleteAddress', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                    {!! Form::hidden('user_id',  '', array('class'=>'form-control', 'id'=>'user_id')) !!}
                                    {!! Form::hidden('address_book_id',  '', array('class'=>'form-control', 'id'=>'address_book_id')) !!}
                                    <div class="modal-body">
                                        <p>{{ trans('labels.DeleteAddressText') }}</p>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Cancel') }}</button>
                                            <button type="submit" class="btn btn-primary" id="deleteAddressBtn">{{ trans('labels.Delete') }}</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Main row -->


            <!-- /.row -->

            <!-- Main row -->

    </div>


    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
@endsection
