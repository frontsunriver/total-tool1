@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ trans('labels.Drivers Report') }} <small>{{ trans('labels.Drivers Report') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">{{ trans('labels.Drivers Report') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.Driver Listing') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('labels.#') }}</th>
                                            <th>{{ trans('labels.Driver ID') }}</th>
                                            <th>{{ trans('labels.FirstName') }}</th>
                                            <th>{{ trans('labels.LastName') }}</th>
                                            <th>{{ trans('labels.Email') }}</th>
                                            <th>{{ trans('labels.Phone') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @if(count($result['reportdata'])>0)
                                        @foreach ($result['reportdata'] as $key=>$data)
                                        <tr>
                                            <td> {{ ++$key }}</td>
                                            <td> {{ $data->id }}</td>
                                            <td> {{ $data->first_name }}</td>
                                            <td> {{ $data->last_name }}</td>
                                            <td> {{ $data->email }}</td>
                                            <td> {{ $data->phone }}</td>
                                            <td>
                                                <a class="btn btn-primary" style="width: 100%; margin-bottom: 5px;" href="{{url('admin/driverreportsdetail')}}/{{ $data->id }}">{{ trans('labels.View') }}</a>
                                            </td>
                                       </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6"><strong>{{ trans('labels.NoRecordFound') }}</strong></td>
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

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection