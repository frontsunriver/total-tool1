@extends('admin.layout')
<style>
.wrapper.wrapper2{
	display: block;
}
.wrapper{
	display: none;
}
</style>
<body onload="window.print();">
<div class="wrapper wrapper2">
  <!-- Main content -->
  <section class="invoice" style="margin: 15px;">
      <!-- title row -->
      
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header" style="padding-bottom: 25px">
          <div class="box-body no-padding">
              <form  name='registration' method="get" action="{{url('admin/customers-orders-report')}}">
              <input type="hidden" name="type" value="all">
              <div class="box-body">
              @if(app('request')->input('dateRange'))
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Date') }}</label>
                    <p>{{app('request')->input('dateRange')}}</p>
                  </div>
                </div>
                @endif
                @if( app('request')->input('products_id'))
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Products') }}</label>
                        @foreach($result['products'] as $product)
                        <p> @if( app('request')->input('products_id' ) == $product->products_id) {{ $product->products_name }} @endif </p>
                        @endforeach
                        
                  </div>
                </div>
                @endif

                
      
            </div>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
            <div class="box-tools pull-right" style="margin-right:50px">
              <?php $instock = 0; $outstock = 0 ; ?>
                    @foreach ($result['reports'] as  $key=>$report)
                      @if($report->stock_type == 'in')
                        @php $instock = $instock + $report->stock; @endphp
                      @endif
                      @if($report->stock_type == 'out')
                        @php $outstock = $outstock + $report->stock; @endphp
                      @endif 
                    @endforeach

                    <b> Current Stock <?php echo $instock - $outstock; ?></b>
            </div>
            <hr />
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
                            @else
                            <td>---</td>                            
                            @endif

                            @if($report->stock_type == 'out')
                            <td>{{ $report->stock }}</td>
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
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

      <!-- /.row -->


    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
