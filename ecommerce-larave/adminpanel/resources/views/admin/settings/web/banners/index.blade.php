@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.constantBanners') }} <small>{{ trans('labels.ListingConstantBanners') }}...</small> </h1>
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
          <div class="box-header">
            {{-- <div class="box-tools pull-right">
            	 <a href="{{ URL::to('admin/addconstantbanner') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewBanner') }}</a>
            </div> --}}

            <div class="form-inline">

              <form  name='registration' id="registration" class="" method="get">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">

                  <div class="input-group-form search-panel ">
                      <select id="parameter" type="button" class="btn btn-default dropdown-toggle form-control input-group-form " data-toggle="dropdown" name="bannerType">
                          <option value="" selected disabled hidden>{{trans('labels.ChooseSliderType')}}</option>
                          <option value="banner1" @if(request()->get('bannerType') == 'banner1') selected @endif>@lang('labels.Banner Style 1')</option>
                          <option value="banner2" @if(request()->get('bannerType') == 'banner2') selected @endif>@lang('labels.Banner Style 2')</option>
                          <option value="banner3" @if(request()->get('bannerType') == 'banner3') selected @endif>@lang('labels.Banner Style 3')</option>
                          <option value="banner4" @if(request()->get('bannerType') == 'banner4') selected @endif>@lang('labels.Banner Style 4')</option>
                          <option value="banner5" @if(request()->get('bannerType') == 'banner5') selected @endif>@lang('labels.Banner Style 5')</option>
                          <option value="banner6" @if(request()->get('bannerType') == 'banner6') selected @endif>@lang('labels.Banner Style 6')</option>
                          <option value="banner7" @if(request()->get('bannerType') == 'banner7') selected @endif>@lang('labels.Banner Style 7')</option>
                          <option value="banner8" @if(request()->get('bannerType') == 'banner8') selected @endif>@lang('labels.Banner Style 8')</option>
                          <option value="banner9" @if(request()->get('bannerType') == 'banner9') selected @endif>@lang('labels.Banner Style 9')</option>
                          <option value="banner10" @if(request()->get('bannerType') == 'banner10') selected @endif>@lang('labels.Banner Style 10')</option>
                          <option value="banner11" @if(request()->get('bannerType') == 'banner11') selected @endif>@lang('labels.Banner Style 11')</option>
                          <option value="banner12" @if(request()->get('bannerType') == 'banner12') selected @endif>@lang('labels.Banner Style 12')</option>
                          <option value="banner13" @if(request()->get('bannerType') == 'banner13') selected @endif>@lang('labels.Banner Style 13')</option>
                          <option value="banner14" @if(request()->get('bannerType') == 'banner14') selected @endif>@lang('labels.Banner Style 14')</option>
                          <option value="banner15" @if(request()->get('bannerType') == 'banner15') selected @endif>@lang('labels.Banner Style 15')</option>
                          <option value="banner16" @if(request()->get('bannerType') == 'banner16') selected @endif>@lang('labels.Banner Style 16')</option>
                          <option value="banner17" @if(request()->get('bannerType') == 'banner17') selected @endif>@lang('labels.Banner Style 17')</option>
                          <option value="banner19" @if(request()->get('bannerType') == 'banner19') selected @endif>@lang('labels.Banner Style 19')</option>

                          
                          <option value="rightsliderbanner" @if(request()->get('bannerType') == 'rightsliderbanner') selected @endif>@lang('labels.Right Slider with Thumbs') </option>
                          <option value="leftsliderbanner" @if(request()->get('bannerType') == 'leftsliderbanner') selected @endif>@lang('labels.Left Slider with Thumbs') </option>
                      </select>
                      <select id="FilterBy" type="button" class="btn btn-default dropdown-toggle form-control input-group-form " data-toggle="dropdown" name="languages_id">
                        <option value="" selected disabled hidden>{{trans('labels.ChooseLanguage')}}</option>
                          @foreach($result['languages'] as $language)
                              <option value="{{$language->languages_id}}" @if(request()->get('languages_id') == $language->languages_id) selected @endif>{{ $language->name }}</option>
                          @endforeach
                      </select>
                      <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                      @if(request()->get('bannerType'))  <a class="btn btn-danger " href="{{url('admin/constantbanners')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                  </div>
              </form>
              <div class="col-lg-4 form-inline" id="contact-form12"></div>

              @if(request()->get('bannerType') == 'banner1')
                <br>
                <img src="{{asset('images\prototypes\banner1.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner2')
                <br>
                <img src="{{asset('images\prototypes\banner2.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner3')
                <br>
                <img src="{{asset('images\prototypes\banner3.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner4')
                <br>
                <img src="{{asset('images\prototypes\banner4.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner5')
                <br>
                <img src="{{asset('images\prototypes\banner5.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner6')
                <br>
                <img src="{{asset('images\prototypes\banner6.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner7')
                <br>
                <img src="{{asset('images\prototypes\banner7.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner8')
                <br>
                <img src="{{asset('images\prototypes\banner8.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner9')
                <br>
                <img src="{{asset('images\prototypes\banner9.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner10')
                <br>
                <img src="{{asset('images\prototypes\banner10.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner11')
                <br>
                <img src="{{asset('images\prototypes\banner11.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner11')
                <br>
                <img src="{{asset('images\prototypes\banner11.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner12')
                <br>
                <img src="{{asset('images\prototypes\banner12.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner13')
                <br>
                <img src="{{asset('images\prototypes\banner13.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner14')
                <br>
                <img src="{{asset('images\prototypes\banner14.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner15')
                <br>
                <img src="{{asset('images\prototypes\banner15.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner16')
                <br>
                <img src="{{asset('images\prototypes\banner16.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner17')
                <br>
                <img src="{{asset('images\prototypes\banner17.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner19')
                <br>
                <img src="{{asset('images\prototypes\banner18.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'banner19')
                <br>
                <img src="{{asset('images\prototypes\banner19.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'rightsliderbanner')
                <br>
                <img src="{{asset('images\prototypes\carousal3.jpg')}}" alt=""  width=100%>
              @elseif(request()->get('bannerType')  == 'leftsliderbanner')
                <br>
                <img src="{{asset('images\prototypes\carousal5.jpg')}}" alt=""  width=100%>
              @endif
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
                      {{-- <th>{{ trans('labels.ID') }}</th> --}}
                      <th>{{ trans('labels.Language Name') }}</th>
                      <th>{{ trans('labels.Image') }}</th>
                      <th>{{ trans('labels.AddedModifiedDate') }}</th>
                      <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($result['banners'])>0)
                    @foreach ($result['banners'] as $key=>$banners)
                        <tr>
                            {{-- <td>{{ $banners->banners_id }}</td> --}}
                            <td>{{ $banners->language_name }}</td>
                            <td><img src="{{asset('').$banners->path}}" alt="" style="max-width: 300px"></td>
                            <td><strong>{{ trans('labels.AddedDate') }}: </strong> {{ date('d M, Y', strtotime($banners->date_added)) }}<br>
                            </td>

                            <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editconstantbanner/{{ $banners->banners_id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <!-- <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteBannerId" banners_id ="{{ $banners->banners_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
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
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->

    <!-- deleteBannerModal -->
	<div class="modal fade" id="deleteBannerModal" tabindex="-1" role="dialog" aria-labelledby="deleteBannerModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteBannerModalLabel">{{ trans('labels.DeleteBanner') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deleteconstantBanner', 'name'=>'deleteBanner', 'id'=>'deleteBanner', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('banners_id',  '', array('class'=>'form-control', 'id'=>'banners_id')) !!}
		  <div class="modal-body">
			  <p>{{ trans('labels.DeleteBannerText') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary" id="deleteBanner">{{ trans('labels.Delete') }}</button>
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
