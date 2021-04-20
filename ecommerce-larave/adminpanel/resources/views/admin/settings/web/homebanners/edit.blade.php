@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.editconstantbanner') }} <small>{{ trans('labels.editconstantbanner') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/constantbanners')}}"><i class="fa fa-bars"></i> {{ trans('labels.ListingConstantBanners') }}</a></li>
      <li class="active">{{ trans('labels.editconstantbanner') }}</li>
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
            <h3 class="box-title">{{ trans('labels.editconstantbanner') }} </h3>
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
                        <!-- /.box-header -->
                        <!-- form start -->
                         <div class="box-body">

                            {!! Form::open(array('url' =>'admin/updateconstantBanner', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                                {!! Form::hidden('id',  $result['banners'][0]->banners_id , array('class'=>'form-control', 'id'=>'id')) !!}
                                {!! Form::hidden('oldImage',  $result['banners'][0]->banners_image, array('id'=>'oldImage')) !!}

                                <div class="form-group hidden">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Language') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="languages_id">
                                          @foreach($result['languages'] as $language)
                                              <option value="{{$language->languages_id}}" @if($language->languages_id==$result['banners'][0]->languages_id) selected @endif>{{ $language->name }}</option>
                                          @endforeach
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.ChooseLanguageText') }}</span>
                                  </div>
                                </div>

                                <div class="form-group hidden">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Side Banner') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="type">
                                          <option value="1" @if($result['banners'][0]->type==1) selected @endif>{{ trans('labels.Right And Left Carousel Side Banner 1') }}</option>
                                          <option value="2" @if($result['banners'][0]->type==2) selected @endif>{{ trans('labels.Right And Left Carousel Side Banner 2') }}</option>
                                          <option value="3" @if($result['banners'][0]->type==3) selected @endif>{{ trans('labels.First Banner For Banner Style 1') }}</option>
                                          <option value="4" @if($result['banners'][0]->type==4) selected @endif>{{ trans('labels.Second Banner For Banner Style 1') }}</option>
                                          <option value="5" @if($result['banners'][0]->type==5) selected @endif>{{ trans('labels.Third Banner For Banner Style 1') }}</option>
                                          <option value="6" @if($result['banners'][0]->type==6) selected @endif>{{ trans('labels.First Banner For Banner Style 2 & 3 & 4') }}</option>
                                          <option value="7" @if($result['banners'][0]->type==7) selected @endif>{{ trans('labels.Second Banner For Banner Style 2 & 3 & 4') }}</option>
                                          <option value="8" @if($result['banners'][0]->type==8) selected @endif>{{ trans('labels.Third Banner For Banner Style 2 & 3 & 4') }}</option>
                                          <option value="9" @if($result['banners'][0]->type==9) selected @endif>{{ trans('labels.Fourth Banner For Banner Style 2 & 3 & 4') }}</option>
                                          <option value="10" @if($result['banners'][0]->type==10) selected @endif>{{ trans('labels.First Banner For Banner Style 5 & 6') }}</option>
                                          <option value="11" @if($result['banners'][0]->type==11) selected @endif>{{ trans('labels.Second Banner For Banner Style 5 & 6') }}</option>
                                          <option value="12" @if($result['banners'][0]->type==12) selected @endif>{{ trans('labels.Third Banner For Banner Style 5 & 6') }}</option>
                                          <option value="13" @if($result['banners'][0]->type==13) selected @endif>{{ trans('labels.Fourth Banner For Banner Style 5 & 6') }}</option>
                                          <option value="14" @if($result['banners'][0]->type==14) selected @endif>{{ trans('labels.Fifth Banner For Banner Style 5 & 6') }}</option>
                                          <option value="15" @if($result['banners'][0]->type==15) selected @endif>{{ trans('labels.First Banner For Banner Style 7 & 8') }}</option>
                                          <option value="16" @if($result['banners'][0]->type==16) selected @endif>{{ trans('labels.Second Banner For Banner Style 7 & 8') }}</option>
                                          <option value="17" @if($result['banners'][0]->type==17) selected @endif>{{ trans('labels.Third Banner For Banner Style 7 & 8') }}</option>
                                          <option value="18" @if($result['banners'][0]->type==18) selected @endif>{{ trans('labels.Fourth Banner For Banner Style 7 & 8') }}</option>
                                          <option value="19" @if($result['banners'][0]->type==19) selected @endif>{{ trans('labels.First Banner For Banner Style 9') }}</option>
                                          <option value="20" @if($result['banners'][0]->type==20) selected @endif>{{ trans('labels.Second Banner For Banner Style 9') }}</option>
                                          <option value="21" @if($result['banners'][0]->type==21) selected @endif>{{ trans('labels.First Banner For Banner Style 10 & 11 & 12') }}</option>
                                          <option value="22" @if($result['banners'][0]->type==22) selected @endif>{{ trans('labels.Second Banner For Banner Style 10 & 11 & 12') }}</option>
                                          <option value="23" @if($result['banners'][0]->type==23) selected @endif>{{ trans('labels.Third Banner For Banner Style 10 & 11 & 12') }}</option>
                                          <option value="24" @if($result['banners'][0]->type==24) selected @endif>{{ trans('labels.Fourth Banner For Banner Style 10 & 11 & 12') }}</option>
                                          <option value="25" @if($result['banners'][0]->type==25) selected @endif>{{ trans('labels.First Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="26" @if($result['banners'][0]->type==26) selected @endif>{{ trans('labels.Second Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="27" @if($result['banners'][0]->type==27) selected @endif>{{ trans('labels.Third Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="28" @if($result['banners'][0]->type==28) selected @endif>{{ trans('labels.Fourth Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="29" @if($result['banners'][0]->type==29) selected @endif>{{ trans('labels.Fifth Banner For Banner Style 13 & 14 & 15') }}</option>
                                          <option value="30" @if($result['banners'][0]->type==30) selected @endif>{{ trans('labels.First Banner For Banner Style 16 & 17') }}</option>
                                          <option value="31" @if($result['banners'][0]->type==31) selected @endif>{{ trans('labels.Second Banner For Banner Style 16 & 17') }}</option>
                                          <option value="32" @if($result['banners'][0]->type==32) selected @endif>{{ trans('labels.Third Banner For Banner Style 16 & 17') }}</option>
                                          <option value="33" @if($result['banners'][0]->type==33) selected @endif>{{ trans('labels.First Banner For Banner Style 18 & 19') }}</option>
                                          <option value="34" @if($result['banners'][0]->type==34) selected @endif>{{ trans('labels.Second Banner For Banner Style 18 & 19') }}</option>
                                          <option value="35" @if($result['banners'][0]->type==35) selected @endif>{{ trans('labels.Third Banner For Banner Style 18 & 19') }}</option>
                                          <option value="36" @if($result['banners'][0]->type==36) selected @endif>{{ trans('labels.Fourth Banner For Banner Style 18 & 19') }}</option>
                                          <option value="37" @if($result['banners'][0]->type==37) selected @endif>{{ trans('labels.Fifth Banner For Banner Style 18 & 19') }}</option>
                                          <option value="38" @if($result['banners'][0]->type==38) selected @endif>{{ trans('labels.Sixth Banner For Banner Style 18 & 19') }}</option>
                                          <option value="39" @if($result['banners'][0]->type==39) selected @endif>{{ trans('labels.Home Page First Banner') }}</option>
                                          <option value="40" @if($result['banners'][0]->type==40) selected @endif>{{ trans('labels.Home Page Second Banner') }}</option>



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
                                                                <select class="image-picker show-html " name="image_id" id="select_img">
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
                                                {!! Form::hidden('oldImage', $result['languages'][0]->image, array('id'=>'oldImage')) !!}
                                                @if(($result['languages'][0]->path!== null))
                                                    <img width="80px" src="{{asset('').$result['banners'][0]->path}}" class="img-circle">
                                                @else
                                                    <img width="80px" src="{{asset('').$result['banners'][0]->path}}" class="img-circle">
                                                @endif

                                            </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.URL') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('banners_url', $result['banners'][0]->banners_url, array('class'=>'form-control','id'=>'banners_url')) !!}

                                  </div>
                                </div>

                                <div class="form-group hidden">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="status">
                                          <option value="1" @if($result['banners'][0]->status==1) selected @endif>{{ trans('labels.Active') }}</option>
                                          <option value="0" @if($result['banners'][0]->status==0) selected @endif>{{ trans('labels.Inactive') }}</option>
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
