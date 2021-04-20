@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Inventory Report') }} <small>{{ trans('labels.Inventory Report') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Inventory Report') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->

    <!-- /.row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('labels.Filter') }}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <input type="hidden" value="{{ isset($_GET['products_id']) ? $_GET['products_id'] : '' }}" id="pro_id"/>
            <input type="hidden" value="{{ isset($_GET['value']) ? $_GET['value'] : '' }}" id="op_id"/>

            <div class="box-body no-padding">
              <form  name='registration' method="get" action="{{url('admin/inventoryreport')}}" class="form-validate">
              <input type="hidden" name="type" value="all">
              <div class="box-body">
                <div class="col-xs-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Choose start and end date') }}</label>
                    <input class="form-control reservation dateRange" placeholder="{{ trans('labels.Choose start and end date') }}" readonly value="{{app('request')->input('dateRange')}}" name="dateRange" aria-label="Text input with multiple buttons ">
                  </div>
                </div>

                <div class="col-xs-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Choose Product') }}</label>
                    <select type="button" required class="btn btn-default select2 form-control product_type" data-toggle="dropdown" name="products_id" id="products_id"  >
                        <option value="">{{trans('labels.Choose Product')}}</option>
                        @foreach($result['products'] as $product)
                        <option value="{{$product->products_id}}"  @if( app('request')->input('products_id')) @if  (app('request')->input('products_id') == $product->products_id) {{ 'selected' }} @endif @endif>{{$product->products_name}}</option>
                        @endforeach
                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.Product Type Text') }}.
                        </span>
                    </select>
                  </div>
                </div>
               
                <div class="col-xs-2" style="padding-top: 25px">                  
                  <div class="form-group">
                    <button class="btn btn-primary" id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    @if(app('request')->input('type') and app('request')->input('type') == 'all')  <a class="btn btn-danger " href="{{url('admin/inventoryreport')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                  </div>
                </div>
                 
            </div>
            <div class="row">
              <div class="col-md-12">
                <div id="attribute" style="display:none">
                </div>
              </div>
            </div>    
            
              <!-- /.box-body -->

            </form>  
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.Inventory Report') }} </h3>

            <div class="box-tools pull-right">
              <form action="{{ URL::to('admin/inventoryreportprint')}}" target="_blank" >
                <input type="hidden" name="page" value="invioce">
                <input type="hidden" name="products_id" value="{{app('request')->input('products_id')}}">
                <input type="hidden" name="dateRange" value="{{app('request')->input('dateRange')}}">
                <button type='submit' class="btn btn-default pull-right"><i class="fa fa-print"></i> {{ trans('labels.Print') }}</button>
              </form>
             
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              <div class="box-tools pull-right">
              <?php $instock = 0; $outstock = 0 ; ?>
                    @foreach ($result['reports'] as  $key=>$report)
                      @if($report->stock_type == 'in')
                        @php $instock = $instock + $report->stock; @endphp
                      @endif
                      @if($report->stock_type == 'out')
                        @php $outstock = $outstock + $report->stock; @endphp
                      @endif 
                    @endforeach

                    Current Stock <b><?php echo $instock - $outstock; ?></b>
              </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.Date') }}</th>
                      <th>{{ trans('labels.In Stock') }}</th>
                      <th>{{ trans('labels.Out Stock') }}</th>
                      <th>{{ trans('labels.Reference') }}</th>
                    </tr>
                  </thead>
                   <tbody>
                   
                    @foreach ($result['reports'] as  $key=>$report)
                   
                        <tr>
                            <td>{{ date('m/d/Y', strtotime($report->created_at)) }}</td>
                            @if($report->stock_type == 'in')
                            <td>{{ $report->stock }}</td>
                            @php $instock = $instock + $report->stock; @endphp
                            @else
                            <td>---</td>                            
                            @endif

                            @if($report->stock_type == 'out')
                            <td>{{ $report->stock }}</td>
                            @php $outstock = $outstock + $report->stock; @endphp
                            @else
                            <td>---</td>                            
                            @endif 

                            @if($report->reference_code)
                            <td>{{ $report->reference_code }}</td>
                            @else
                            <td>---</td>                            
                            @endif
                            
                        </tr>
                    @endforeach

                       
                  </tbody>
                </table>
                <div class="col-xs-12" style="background: #eee;">


                  @php
                    if($result['reports']->total()>0){
                      $fromrecord = ($result['reports']->currentpage()-1)*$result['reports']->perpage()+1;
                    }else{
                      $fromrecord = 0;
                    }
                    if($result['reports']->total() < $result['reports']->currentpage()*$result['reports']->perpage()){
                      $torecord = $result['reports']->total();
                    }else{
                      $torecord = $result['reports']->currentpage()*$result['reports']->perpage();
                    }

                  @endphp
                  <div class="col-xs-12 col-md-6" style="padding:30px 15px; border-radius:5px;">
                    <div>Showing {{$fromrecord}} to {{$torecord}}
                        of  {{$result['reports']->total()}} entries
                    </div>
                  </div>
                <div class="col-xs-12 col-md-6 text-right">
                    {{ $result['reports']->appends(\Request::except('type'))->render() }}
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
      var product = $('#pro_id').val();
      var attribute = $('#op_id').val();
      if(product != '' && attribute != ''){
        FetchAttributes(product , attribute);
      }
      $('.product_type').change(function(){
        product_id = $(this).val();
        FetchAttributes(product_id);
    })
  })

  function FetchAttributes(product_id , attribute_id){
    $.ajax({
            url: '{{ URL::to("admin/products/inventory/ajax_attr_inventory")}}'+'/'+product_id,
            type: "GET",
            success: function (res) {
            //console.log(res.products[0].products_type);
              var row = '';
              if(res.attributes.length > 0){
                row += '<div class="form-group">';
                row +='<label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.products_attributes') }}</label>';
                row += '<div class="col-sm-6 col-md-6">';
                row += "<input type='hidden' id='has-attribute' value='1'>";
                  row +='<ul class="list-group list-group-root well list-group-root2">';
                  row += '<li href="#" class="list-group-item"><label style="width:100%">';
                  row += '<input id="attribute_id" type="hidden" class="'+ res.attributes[0].option.id +'" name="attributeid[]" value="">'+ res.attributes[0].option.name +'</label></li>';
                  row += '<ul class="list-group">';
                  
                  for(var j = 0 ; j < res.attributes[0].values.length ; j++){
                    row += '<li class="list-group-item">';
                      if(parseInt(attribute_id) == parseInt(res.attributes[0].values[j].products_attributes_id))
                        row += ' <label><input name="value" type="radio" class="required_one" checked ="checked" value="'+ res.attributes[0].values[j].products_attributes_id +'" attributeid="'+ res.attributes[0].option.id +'">'+ res.attributes[0].values[j].value +'</label></li>';
                      else
                        row += ' <label><input name="value" type="radio" class="required_one"  value="'+ res.attributes[0].values[j].products_attributes_id +'" attributeid="'+ res.attributes[0].option.id +'">'+ res.attributes[0].values[j].value +'</label></li>';
                  }
                    
                  row += '</ul>';
                row += '</ul>';
                row += '<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">';
                row += '{{ trans("labels.Select Option values Text") }}.</span>';
                row += '<span class="help-block hidden">{{ trans("labels.Select Option values Text") }}</span>';
                row += '</div>';
                row += '</div>';
                $('#attribute').show();
                $('#attribute').html(row);
                
              }
              else{
                row += '<div class="form-group">';
                row += '<label for="name" class="col-sm-2 col-md-2 control-label">{{ trans("labels.products_attributes") }}</label>';
                row += '<div class="col-sm-6 col-md-6">';
                row += "<input type='hidden' id='has-attribute' value='1'>";
                row += "<input type='hidden' id='has-attribute' value='0'>";
                row += '<div class="alert alert-info" role="alert">';
                row += "Now you can see the report for simple product";
                row += '</div>';
                row += '<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">';
                row += '{{ trans("labels.Select Option values Text") }}.</span>';
                row += "<span class='help-block hidden'>{{ trans('labels.Select Option values Text') }}</span>";
                row += '</div>';
                row += '</div>';
                $('#attribute').show();
                $('#attribute').html(row);
              }

              
            },
          });
      
  }
</script>
@endsection
