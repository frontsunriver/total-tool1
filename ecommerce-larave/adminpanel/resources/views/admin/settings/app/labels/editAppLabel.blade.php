@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Edit Label <small>Edit Label...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/listingAppLabels')}}"><i class="fa fa-bars"></i> List All Labels</a></li>
      <li class="active">Edit Label</li>
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
            <h3 class="box-title">Edit labels </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <br>                       
                       @if (count($errors) > 0)
							  @if($errors->any())
								<div class="alert alert-danger alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  {{$errors->first()}}
								</div>
							  @endif
						@endif
                        
                        @if(session()->has('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        
                        <!-- form start -->                        
                         <div class="box-body">
                         
                            {!! Form::open(array('url' =>'admin/updateAppLabel', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                            {!! Form::hidden('id',  $result['labels_value'][0]->label_id , array('class'=>'form-control', 'id'=>'id')) !!}
                            
                                                       
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">Label Key</label>
                              <div class="col-sm-10 col-md-4">
                                  <select class="form-control" name="label_id" disabled>
                                     @foreach ($result['labels'] as $labels)
                                      <option value="{{$labels->label_id}}" 
                                      	@if($result['labels_value'][0]->label_id == $labels->label_id)
                                        	selected
                                        @endif
                                      >{{$labels->label_name}}</option>
                                    @endforeach
                                  </select>
                              <span class="help-block hidden">This is the general name to identify the language of multiple value.</span>
                              </div>
                            </div>
                            
                                
                                                             
                               <?php $i = 0; $j=0;?>
                                @foreach($result['languages'] as $key=>$languages)
                                	
                                    @if(!empty($result['labels_value'][$j]->language_id)) 
                                    <input type="hidden" name="label_value_id_<?=$languages->languages_id?>" value="{{ $result['labels_value'][$i]->label_value_id}}">
                                    @endif
                                                                        
                                    <div class="form-group">
                                      <label for="name" class="col-sm-2 col-md-3 control-label">Label Value ({{ $languages->name }})</label>
                                      <div class="col-sm-10 col-md-4">
                                        <input type="text" name="label_value_<?=$languages->languages_id?>" class="form-control field-validate" @if(!empty($result['labels_value'][$j]->language_id)) value="{{ $result['labels_value'][$j]->label_value}}" @endif>
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Label Value ({{ $languages->name }}).</span>
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                    </div>
                                 
                                 <?php 
								 	if(count($result['labels_value'])>1) { $i++; }
								 	$j++;
								  ?>
                                @endforeach
                                                                
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                <a href="{{ URL::to('admin/listingAppLabels')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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