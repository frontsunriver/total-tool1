@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Home Banners') }} <small>{{ trans('labels.Listing The Home Banners') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Banners') }}</li>
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
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">

                    @foreach($result['languages'] as $key=>$languages)
                    <li class="@if($key==0) active @endif"><a href="#banners_<?=$languages->languages_id?>" data-toggle="tab"><?=$languages->name?><span style="color:red;">*</span></a></li>
                    @endforeach

                  </ul>
                  {!! Form::open(array('url' =>'admin/homebanners/insert', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                    <div class="tab-content">
                    @php 
                    $i =0;
                    @endphp
                      @foreach($result['banners'] as $key=>$banners_content)                 
                      
                      <div style="margin-top: 15px;" class="tab-pane @if($i==0) active @endif" id="banners_<?=$key?>">
                        @foreach($banners_content as $key=>$banner)
                        
                        <div class="">     
                          
                          <div class="row">
                            <div class="col-xs-12">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Banner') }} </label>
                                <div class="col-sm-10 col-md-4">

                                    <!-- Modal -->
                                    <div class="modal fade" id="new-image-<?=$banner['language_id']?>-<?=$banner['banner_name']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h3 class="modal-title text-primary" id="myModalLabel">@lang('website.Choose Image') </h3>
                                                </div>

                                                <div class="modal-body manufacturer-image-embed">
                                                    @if(isset($allimage))
                                                    <select class=" show-html " name="image_id_<?=$banner['language_id']?>_<?=$banner['banner_name']?>">
                                                        <option value=""></option>
                                                        @if($banner['image'] !='')
                                                        
                                                        @foreach($allimage as $key=>$image)
                                                        <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}" @if ($image->id == $banner['image']) {{'selected'}} @endif > {{$image->id}} </option>
                                                        @endforeach
                                                        
                                                        @else
                                                        
                                                        @foreach($allimage as $key=>$image)
                                                        <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                        @endforeach

                                                        @endif
                                                    </select>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left">{{ trans('labels.Add Banner') }}</a>
                                                    <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                    <button type="button" class="btn btn-primary selected-image" imageselected="imageselected_<?=$banner['language_id']?>_<?=$banner['banner_name']?>" attribute="selected_<?=$banner['language_id']?>_<?=$banner['banner_name']?>" data-dismiss="modal">@lang('labels.Done')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="imageselected_<?=$banner['language_id']?>_<?=$banner['banner_name']?>" >
                                      @if($banner['image'] !='')
                                       <button type="button" class="btn btn-primary bannerBtn" data-toggle="modal" data-target="#new-image-<?=$banner['language_id']?>-<?=$banner['banner_name']?>">
                                        @lang('labels.Choose Banner')
                                        </button>
                                      @else
                                      <button type="button" class="btn btn-primary field-validate bannerBtn" data-toggle="modal" data-target="#new-image-<?=$banner['language_id']?>-<?=$banner['banner_name']?>">
                                        @lang('labels.Choose Banner')
                                        </button>
                                      @endif
                                        <br>
                                        <div id="selected_<?=$banner['language_id']?>_<?=$banner['banner_name']?>" class="selectedthumbnail col-md-5" style="display: none"> </div>
                                        <div class="closimage">
                                            <button type="button" class="close pull-left image-close " 
                                              style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Choose Banner') }}</span>
                                </div>
                            </div>

                            @if(!empty($banner['path']))
                            <div class="form-group">
                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                <div class="col-sm-10 col-md-4">
                                    <img src="{{asset($banner['path'])}}" alt="" width=" 100px">
                                </div>
                            </div>
                            @endif
                           </div>
                          </div>

                        <div class="row">
                          <div class="col-xs-12">
                            <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Text') }} </label>
                              <div class="col-sm-10 col-md-8">
                                  <textarea name="text_<?=$banner['language_id']?>_<?=$banner['banner_name']?>" class="form-control"
                                    rows="5">{{stripslashes($banner['text'])}}</textarea>
                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.Enter Detail') }}</span> 
                              </div>
                            </div>
                          </div>
                        </div>

                        </div>

                        @endforeach
                      </div>
                      @php 
                        $i++;
                      @endphp
                      @endforeach
                      <!-- /.tab-pane -->
                    </div>
                    <div class="box-footer text-center">
                      <button type="submit" class="btn btn-primary pull-right" id="normal-btn">{{ trans('labels.Submit') }}</button>
                  </div>
                  </form>
                  <!-- /.tab-content -->
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
<script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
<script>
  $(document).on('click','.selected-image', function(){
    var image_src = $('.thumbnail.selected').children('img').attr('src');
    var attribute = $(this).attr('attribute');
    var imageselected = $(this).attr('imageselected');    
    $('#'+attribute).html('<img src="'+image_src+'" class = "thumbnail" style="max-height: 100px; margin-top: 20px;">');
    $('#'+attribute).show();   
    $('.image-close').show();
    $('#'+imageselected).removeClass('has-error');
    $('#'+imageselected).children('.bannerBtn').removeClass('field-validate');
    $('.thumbnail.selected').removeClass('selected');
});
</script>

@endsection

