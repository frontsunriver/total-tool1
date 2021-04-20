@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.AddConstantBanner') }} <small>{{ trans('labels.AddConstantBanner') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/constantbanners')}}"><i class="fa fa-bars"></i> {{ trans('labels.ListingConstantBanners') }}</a></li>
      <li class="active">{{ trans('labels.AddConstantBanner') }}</li>
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
            <h3 class="box-title">{{ trans('labels.AddConstantBanner') }}</h3>
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <br>

                          @if(session()->has('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              {{ session()->get('error') }}
                            </div>
                          @endif

                          @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              {{ session()->get('success') }}
                            </div>
                          @endif

                        <!-- form start -->
                         <div class="box-body">

                            {!! Form::open(array('url' =>'admin/addNewConstantBanner', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                            	<div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Language') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="languages_id">
                                          @foreach($result['languages'] as $language)
                                              <option value="{{$language->languages_id}}">{{ $language->name }}</option>
                                          @endforeach
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.ChooseLanguageText') }}</span>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Side Banner') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="type">
                                          <option value="1">{{ trans('labels.Right And Left Carousel Side Banner 1') }}</option>
                                          <option value="2">{{ trans('labels.Right And Left Carousel Side Banner 2') }}</option>
                                          <option value="3">{{ trans('labels.First Banner For Banner Style 1') }}</option>
                                          <option value="4">{{ trans('labels.Second Banner For Banner Style 1') }}</option>
                                          <option value="5">{{ trans('labels.Third Banner For Banner Style 1') }}</option>
                                          <option value="6">{{ trans('labels.First Banner For Banner Style 2 & 3 & 4') }}</option>
                                          <option value="7">{{ trans('labels.Second Banner For Banner Style 2 & 3 & 4') }}</option>
                                          <option value="8">{{ trans('labels.Third Banner For Banner Style 2 & 3 & 4') }}</option>
                                          <option value="9">{{ trans('labels.Fourth Banner For Banner Style 2 & 3 & 4') }}</option>
                                          <option value="10">{{ trans('labels.First Banner For Banner Style 5 & 6') }}</option>
                                          <option value="11">{{ trans('labels.Second Banner For Banner Style 5 & 6') }}</option>
                                          <option value="12">{{ trans('labels.Third Banner For Banner Style 5 & 6') }}</option>
                                          <option value="13">{{ trans('labels.Fourth Banner For Banner Style 5 & 6') }}</option>
                                          <option value="14">{{ trans('labels.Fifth Banner For Banner Style 5 & 6') }}</option>
                                          <option value="15">{{ trans('labels.First Banner For Banner Style 7 & 8') }}</option>
                                          <option value="16">{{ trans('labels.Second Banner For Banner Style 7 & 8') }}</option>
                                          <option value="17">{{ trans('labels.Third Banner For Banner Style 7 & 8') }}</option>
                                          <option value="18">{{ trans('labels.Fourth Banner For Banner Style 7 & 8') }}</option>
                                          <option value="19">{{ trans('labels.First Banner For Banner Style 9') }}</option>
                                          <option value="20">{{ trans('labels.Second Banner For Banner Style 9') }}</option>
                                          <option value="21">{{ trans('labels.First Banner For Banner Style 10 & 11 & 12') }}</option>
                                          <option value="22">{{ trans('labels.Second Banner For Banner Style 10 & 11 & 12') }}</option>
                                          <option value="23">{{ trans('labels.Third Banner For Banner Style 10 & 11 & 12') }}</option>
                                          <option value="24">{{ trans('labels.Fourth Banner For Banner Style 10 & 11 & 12') }}</option>
                                          <option value="25">{{ trans('labels.First Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="26">{{ trans('labels.Second Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="27">{{ trans('labels.Third Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="28">{{ trans('labels.Fourth Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="29">{{ trans('labels.Fifth Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="30">{{ trans('labels.First Banner For Banner Style 16 & 17') }}</option>
                                          <option value="31">{{ trans('labels.Second Banner For Banner Style 16 & 17') }}</option>
                                          <option value="32">{{ trans('labels.Third Banner For Banner Style 16 & 17') }}</option>
                                          <option value="33">{{ trans('labels.First Banner For Banner Style 18 & 19') }}</option>
                                          <option value="34">{{ trans('labels.Second Banner For Banner Style 18 & 19') }}</option>
                                          <option value="35">{{ trans('labels.Third Banner For Banner Style 18 & 19') }}</option>
                                          <option value="36">{{ trans('labels.Fourth Banner For Banner Style 18 & 19') }}</option>
                                          <option value="37">{{ trans('labels.Fifth Banner For Banner Style 18 & 19') }}</option>
                                          <option value="38">{{ trans('labels.Sixth Banner For Banner Style 18 & 19') }}</option>
                                          <option value="39">{{ trans('labels.Home Page First Banner') }}</option>
                                          <option value="40">{{ trans('labels.Home Page Second Banner') }}</option>



                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.AddBannerText') }}</span>
                                  </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}</label>
                                    <div class="col-sm-10 col-md-4">
                                        {{--{!! Form::file('newImage', array('id'=>'newImage')) !!}--}}
                                        <!-- Modal -->
                                            <div class="modal fade embed-images" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" id ="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                            <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                        </div>
                                                        <div class="modal-body manufacturer-image-embed">
                                                            @if(isset($allimage))
                                                                <select class="image-picker show-html field-validate" name="image_id" id="select_img">
                                                                    <option  value=""></option>
                                                                    @foreach($allimage as $key=>$image)
                                                                        <option data-img-src="{{asset($image->path)}}"  class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                          <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Icon') }}</a>
                                                          <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                          <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div  id ="imageselected">
                                                {!! Form::button(trans('labels.Add Icon'), array('id'=>'newImage','class'=>"btn btn-primary", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 3px;">{{ trans('labels.LanguageFlag') }}</span>
                                                <div class="closimage">
                                                    <button type="button" class="close pull-right" id="image-close" style="display: none; position: absolute;left: 91px; top: 54px; background-color: black; color: white; opacity: 2.2;" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div  id="selectedthumbnail"></div>
                                                <br>


                                            </div>
                                    </div>
                                </div>



                                <div class="form-group banner-link">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.URL') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('banners_url', '', array('class'=>'form-control field-validate','id'=>'banners_url')) !!}
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="status">
                                          <option value="1">{{ trans('labels.Active') }}</option>
                                          <option value="0">{{ trans('labels.InActive') }}</option>
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.StatusBannerText') }}</span>
                                  </div>
                                </div>

                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                <a href="{{ URL::to('admin/constantbanners')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
