@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.reviews') }} <small>{{ trans('labels.ListingAllReviews') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.reviews') }}</li>
            </ol>
        </section>

        <!--  content -->
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
                                    @if ($errors)
                                        @if($errors->any())
                                            <div @if ($errors->first()=='Default can not Deleted!!') class="alert alert-danger alert-dismissible" @else class="alert alert-success alert-dismissible" @endif role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="row default-div hidden">
                                <div class="col-xs-12">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        {{ trans('labels.DefaultLanguageChangedMessage') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('reviews_id', trans('labels.ID') )</th>
                                            <th>@sortablelink('products_name',  trans('labels.products_name') )</th>
                                            <th>@sortablelink('reviews_text',  trans('labels.reviews_text') )</th>
                                            <th>@sortablelink('created_at',  trans('labels.Date') )</th>
                                            <th>{{trans('labels.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($result['reviews'])
                                            @foreach ($result['reviews'] as $review)

                                                <tr>
                                                    <td>
                                                        {{ $review->reviews_id}}
                                                        @if($review->reviews_read == 0 and $review->reviews_status == 0)
                                                        <span class="label label-success">{{ trans('labels.new') }}</span>
                                                        @elseif($review->reviews_read == 1 and $review->reviews_status == 0)
                                                        <span class="label label-info">{{ trans('labels.pending') }}</span>
                                                        @elseif($review->reviews_read == 1 and $review->reviews_status == 1)
                                                        <span class="label label-primary">{{ trans('labels.seen') }}</span>
                                                        @elseif($review->reviews_read == 1 and $review->reviews_status == -1)
                                                        <span class="label label-danger">{{ trans('labels.Deactive') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $review->products_name }}</td>
                                                    <td width="40%">{{ $review->reviews_text }}</td>
                                                    <td>{{ $review->created_at }}</td>
                                                    <td>
                                                        @if($review->reviews_read == 0 and $review->reviews_status == 0)
                                                      <a class="btn btn-warning" style="width: 100%;  margin-bottom: 5px;" href="{{ URL::to('admin/reviews/edit/'.$review->reviews_id.'/0')}}">{{ trans('labels.pending') }}</a>
                                                      </br>
                                                      @endif
                                                      <a class="btn btn-success" style="width: 100%;  margin-bottom: 5px;"  href="{{ URL::to('admin/reviews/edit/'.$review->reviews_id.'/1')}}">{{ trans('labels.Active') }}</a>
                                                    </br>
                                                    <a class="btn btn-danger" style="width: 100%;  margin-bottom: 5px;"  href="{{ URL::to('admin/reviews/edit/'.$review->reviews_id.'/-1')}}">{{ trans('labels.Deactive') }}</a>
                                                      </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.Nolanguageexist') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                        @if($result['reviews'] != null)
                                        <div class="col-xs-12 text-right">
                                            {{$result['reviews']->links()}}
                                        </div>
                                        @endif
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
            <!-- deletelanguagesModal -->
            <div class="modal fade" id="deleteLanguagesModal" tabindex="-1" role="dialog" aria-labelledby="deleteLanguagesModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteLanguagesModalLabel">{{ trans('labels.DeleteLanguages') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/languages/delete', 'name'=>'deletelanguages', 'id'=>'deletelanguages', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'languages_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.confrimLanguageDelete') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deletelanguages">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!--  row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
