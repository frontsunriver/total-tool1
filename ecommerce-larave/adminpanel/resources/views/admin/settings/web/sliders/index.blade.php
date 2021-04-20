@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Sliders') }} <small>{{ trans('labels.ListingAllImages') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Sliders') }}</li>
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
            <div class="col-lg-10 form-inline">

              <form  name='registration' id="registration" class="registration" method="get">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">

                  <div class="input-group-form search-panel ">
                      <select onchange="this.form.submit()" id="sliderType" type="button" class="btn btn-default dropdown-toggle form-control input-group-form " data-toggle="dropdown" name="sliderType">

                          <option value="" selected disabled hidden>{{trans('labels.ChooseSliderType')}}</option>                         

                          <option value="1" @if(request()->get('sliderType') == 1) selected @endif>@lang('labels.Full Screen Slider (1600x420)')</option>
                          <option value="2" @if(request()->get('sliderType') == 2) selected @endif>@lang('labels.Full Page Slider (1170x420)')</option>
                          <option value="3" @if(request()->get('sliderType') == 3) selected @endif>@lang('labels.Right Slider with Thumbs (770x400)') </option>
                          <option value="4" @if(request()->get('sliderType') == 4) selected @endif>@lang('labels.Right Slider with Navigation (770x400)')  </option>
                          <option value="5" @if(request()->get('sliderType') == 5) selected @endif>@lang('labels.Left Slider with Thumbs (770x400)')</option>

                      </select>
                      {{-- <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button> --}}
                      @if(request()->get('sliderType'))  <a class="btn btn-danger " href="{{url('admin/sliders')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                  </div>
              </form>
              <div class="col-lg-4 form-inline" id="contact-form12"></div>
          </div>
            <div class="box-tools pull-right">
             <a href="{{ URL::to('admin/addsliderimage') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddSliderImage') }}</a>
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
                      <th>{{ trans('labels.ID') }}</th>
                      <th>{{ trans('labels.Slider Type') }}</th>
                      <th>{{ trans('labels.Slider Image') }}</th>
                      <th>{{ trans('labels.AddedModifiedDate') }}</th>
                      <th>{{ trans('labels.languages') }}</th>
                      <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($result['sliders'])>0)
                    @foreach ($result['sliders'] as $key=>$sliders)
                        <tr>
                            <td>{{ $sliders->sliders_id }}</td>
                            <td>
                              @if($sliders->carousel_id == 1)
                              @lang('labels.Full Screen Slider (1600x420)')
                              @elseif($sliders->carousel_id == 2)
                              @lang('labels.Full Page Slider (1170x420)')
                              @elseif($sliders->carousel_id == 3)
                              @lang('labels.Right Slider with Thumbs (770x400)')
                              @elseif($sliders->carousel_id == 4)
                              @lang('labels.Right Slider with Navigation (770x400)')
                              @elseif($sliders->carousel_id == 5)
                              @lang('labels.Left Slider with Thumbs (770x400)')
                              @endif</td>


                            <td><img src="{{asset('').$sliders->path}}" alt="" width=" 200px"></td>
                            <td><strong>{{ trans('labels.AddedDate') }}: </strong> {{ date('d M, Y', strtotime($sliders->date_added)) }}<br>
                            <strong>{{ trans('labels.ModifiedDate') }}: </strong>@if(!empty($sliders->date_status_change)) {{ date('d M, Y', strtotime($sliders->date_status_change)) }}  @endif<br>
                            <strong>{{ trans('labels.ExpiryDate') }}: </strong>@if(!empty($sliders->expires_date)) {{ date('d M, Y', strtotime($sliders->expires_date)) }}  @endif</td>

                            <td>{{ $sliders->language_name }}</td>
                            <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editslide/{{ $sliders->sliders_id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                             <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteSliderId" sliders_id ="{{ $sliders->sliders_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </tr>
                    @endforeach
                    @else
                       <tr>
                            <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	
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

    <!-- deleteSliderModal -->
	<div class="modal fade" id="deleteSliderModal" tabindex="-1" role="dialog" aria-labelledby="deleteSliderModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteSliderModalLabel">{{ trans('labels.DeleteSlider') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deleteSlider', 'name'=>'deleteSlider', 'id'=>'deleteSlider', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('sliders_id',  '', array('class'=>'form-control', 'id'=>'sliders_id')) !!}
		  <div class="modal-body">
			  <p>{{ trans('labels.DeleteSliderText') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary" id="deleteSlider">{{ trans('labels.Delete') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection
