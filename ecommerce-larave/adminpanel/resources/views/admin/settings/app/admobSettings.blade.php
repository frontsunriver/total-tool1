@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.admobSettings') }} <small>{{ trans('labels.admobSettings') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.admobSettings') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.admobSettings') }} </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!--<div class="box-header with-border">
                                          <h3 class="box-title">Setting</h3>
                                        </div>-->
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            @if( count($errors) > 0)
                                                @foreach($errors->all() as $error)
                                                    <div class="alert alert-success" role="alert">
                                                        <span class="icon fa fa-check" aria-hidden="true"></span>
                                                        <span class="sr-only">{{ trans('labels.Setting') }}:</span>
                                                        {{ $error }}
                                                    </div>
                                                @endforeach
                                            @endif
                                            
                                            {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.admobID') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('admob_id',  $result['commonContent']['setting']['admob_id'], array('class'=>'form-control', 'id'=>'admob_id')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.admobIDText') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.unitIdBanner') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('ad_unit_id_banner',  $result['commonContent']['setting']['ad_unit_id_banner'], array('class'=>'form-control', 'id'=>'ad_unit_id_banner')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.unitIdBannerText') }}</span>
                                                </div>
                                            </div>

                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.unitIdInterstitial') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('ad_unit_id_interstitial',$result['commonContent']['setting']['ad_unit_id_interstitial'], array('class'=>'form-control', 'id'=>'ad_unit_id_interstitial')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.unitIdInterstitialText') }}</span>
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.admobStatus') }}
                                                
                                                </label>
                                                
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="admob" class="form-control">
                                                        <option @if($result['commonContent']['setting']['admob'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.Show') }}</option>
                                                        <option @if($result['commonContent']['setting']['admob'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.Hide') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.admobStatusText') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="android-hide">
                                                <hr>
                                                <h4>{{ trans('labels.admobSettingIOS') }} </h4>
                                                <hr>

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.admobID') }}

                                                    </label>
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text('ios_admob_id', $result['commonContent']['setting']['ios_admob_id'] , array('class'=>'form-control', 'id'=>'ios_admob_id')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.admobIDText') }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.unitIdBanner') }}

                                                    </label>
                                                    
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text('ios_ad_unit_id_banner', $result['commonContent']['setting']['ios_ad_unit_id_banner'], array('class'=>'form-control', 'id'=>'ios_ad_unit_id_banner')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.unitIdBannerText') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.unitIdInterstitial') }}

                                                    </label>
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text('ios_ad_unit_id_interstitial', $result['commonContent']['setting']['ios_ad_unit_id_interstitial'], array('class'=>'form-control', 'id'=>'ios_ad_unit_id_interstitial')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.unitIdInterstitialText') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.admobStatus') }}

                                                    </label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <select name="ios_admob" class="form-control">
                                                            <option @if($result['commonContent']['setting']['ios_admob'] == '1')
                                                                    selected
                                                                    @endif
                                                                    value="1"> {{ trans('labels.Show') }}</option>
                                                            <option @if($result['commonContent']['setting']['ios_admob'] == '0')
                                                                    selected
                                                                    @endif
                                                                    value="0"> {{ trans('labels.Hide') }}</option>
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.admobStatusText') }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                                <a href="{{ URL::to('admin/dashboard/this_month')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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