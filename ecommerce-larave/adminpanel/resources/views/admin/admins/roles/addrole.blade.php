@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Add Roles') }} <small>{{ trans('labels.Add Roles') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
       <li><a href="{{ URL::to('admin/manageroles')}}"><i class="fa fa-users"></i> {{ trans('labels.manageroles') }}</a></li>
      <li class="active">{{ trans('labels.Add Roles') }}</li>
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
            <h3 class="box-title"><strong>{{ trans('labels.Type') }}:</strong> {{$result['adminType'][0]->user_types_name}} </h3>
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <!-- form start -->
                         <div class="box-body">
                          @if(session()->has('message'))
                            <div class="alert alert-success" role="alert">
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{ session()->get('message') }}
                            </div>
                        @endif

                            {!! Form::open(array('url' =>'admin/addnewroles', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                            {!! Form::hidden('user_types_id',  $result['user_types_id'], array('class'=>'form-control', 'id'=>'user_types_id')) !!}
                           <div class="row">
                            @foreach($result['data'] as $datas)
                            <div class="col-md-6">
                            <hr>
                            <h4>{{ trans('labels.manage '.$datas['link_name']) }} </h4>
                            <hr>
                            @foreach($datas['permissions'] as $data)
                            <div class="form-group">
                           		<label class="col-sm-3 col-md-5 control-label" style="">{{ trans('labels.manage '.$data['name']) }}</label>
                                <div class="col-sm-10 col-md-4">
                                    <label class=" control-label">
                                          <input type="radio" name="{{$data['name']}}" value="1" class="flat-red" @if($data['value']==1) checked @endif > &nbsp;{{ trans('labels.Yes') }}
                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <label class=" control-label">
                                          <input type="radio" name="{{$data['name']}}" value="0" class="flat-red" @if($data['value']==0) checked @endif >  &nbsp;{{ trans('labels.No') }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                          </div>
                            @endforeach
                          </div>

                              <!-- /.box-body -->
                            <div class="box-footer ">
                              <a style="float:right;"href="{{ URL::to('admin/dashboard/this_month')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                            	<button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
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
