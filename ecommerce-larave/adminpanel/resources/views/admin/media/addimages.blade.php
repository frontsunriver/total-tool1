@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.AddNewImage') }} <small>{{ trans('labels.ListingAllImage') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">{{ trans('labels.AddNewImage') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.ListingAllImage') }} </h3>

                        <div style="margin-right:88px;"class="box-tools pull-left">
                            <button id="btn" type="button" class="btn btn-block btn-danger">Delete</button>

                        </div>
                        <div style="margin-right:162px;"class="box-tools pull-left">
                            <button id="btn11" type="button" class="btn btn-block btn-success" >Select All</button>

                        </div>
                        <div style="margin-right:253px;"class="box-tools pull-left">
                            <button id="btn12" type="button" class="btn btn-block btn-info" >UnSelect All</button>

                        </div>
                        <div class="box-tools pull-left">
                            <button type="button" class="btn btn-block btn-primary" data-toggle="modal"
                                data-target="#myModal">{{ trans('labels.AddNew') }}</button>

                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if (count($errors) > 0)
                                @if($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    {{$errors->first()}}
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>

<style>
  article, aside, figure, footer, header, hgroup,
  menu, nav, section { display: block; }
  ul { list-style: none; }
  ul li { display: inline; }
  img { border: 2px solid white; cursor: pointer; }
  img:hover { border: 2px solid black; }
  img.hover { border: 2px solid black; }
  .margin-bottomset .thumbnail { margin-bottom: 0; }
</style>
</head>



                        <form class="hidden" action="" method="" id="images_form">
                            <input id="images" type="hidden" name="images" value=""/>
                        </form>
                        <div class="row">
                            @if(isset($images))
                                @foreach($images as $image)
                                <div class="col-xs-4 col-md-2 margin-bottomset">
                                    <div class="thumbnail thumbnail-imges">
                                        <img class="test_image" image_id="{{$image->id}}" src="{{asset($image->path)}}" alt="...">
                                    </div>
                                    <a class="btn btn-block btn-primary" href="{{url('admin/media/detail')}}/{{$image->id}}"> @lang('labels.ViewDetail')</a>
                                </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <p id="demo"></p>

            <!-- /.col -->
        </div>
        <!-- /.row -->
<script>

</script>
        <!-- Main row -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add File Here</h4>
                    </div>
                    <div class="modal-body">
                        <p>Click or Drop Images in the Box for Upload.</p>
                        <form action="{{ url('admin/media/uploadimage') }}" enctype="multipart/form-data"
                            class="dropzone " id="my-dropzone">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" disabled="disabled" id="compelete"
                            data-dismiss="modal">Done</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="myModaldetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                        <h3 class="modal-title text-primary" id="myModalLabel">Image Details</h3>
                    </div>

                    {!! Form::open(array('url' =>'admin/deleteimage', 'method'=>'post', 'class' => 'form-horizontal',
                    'enctype'=>'multipart/form-data', 'onsubmit' => 'return ConfirmDelete()')) !!}
                    <div class="image_embed">

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="myDeleteImage"
                            data-toggle="modal">Delete</button>
                        {{--<a href="#myModal2" role="button" type="submit" class="btn btn-danger" data-toggle="modal">Delete</a>--}}
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>


                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div id="myModal2" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmation!!</h4>
                    </div>
                    <div class="modal-body">
                        <p>You are sure to delete It!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="myDeleteImage"
                            data-toggle="modal">Delete</button>
                        <button class="btn btn-default" data-dismiss="modal" data-dismiss="modal"
                            aria-hidden="true">Cancel</button>
                    </div>

                </div>
            </div>
        </div>


        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
