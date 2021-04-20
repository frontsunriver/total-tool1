
<header class="main-header">


    <!-- Logo -->
    <a href="{{ URL::to('admin/dashboard/this_month')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="font-size:12px"><b>{{ trans('labels.admin') }}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ trans('labels.admin') }}</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" id="linkid" data-toggle="offcanvas" role="button">
        <span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
      </a>
		<div id="countdown" style="
    width: 350px;
    margin-top: 13px !important;
    position: absolute;
    font-size: 16px;
    color: #ffffff;
    display: inline-block;
    margin-left: -175px;
    left: 50%;
"></div>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-list-ul"></i>
              <span class="label label-success">{{ count($unseenOrders) }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">{{ trans('labels.you_have') }} {{ count($unseenOrders) }} {{ trans('labels.new_orders') }}</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                @foreach($unseenOrders as $unseenOrder)
                  <li><!-- start message -->
                    <a href="{{ URL::to("admin/orders/vieworder")}}/{{ $unseenOrder->orders_id}}">
                      <h4>
                        {{ $unseenOrder->customers_name }}
                        <small><i class="fa fa-clock-o"></i> {{  date('d/m/Y', strtotime($unseenOrder->date_purchased))  }}</small>
                      </h4>
                      <p>Ordered Products ({{ $unseenOrder->total_products}})</p>
                    </a>
                  </li>
                @endforeach
                  <!-- end message -->
                </ul>
              </li>
              <!--<li class="footer"><a href="#">See All Messages</a></li>-->
            </ul>
          </li>

          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-users"></i>
              <span class="label label-warning">{{ count($newCustomers) }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">{{ count($newCustomers) }} {{ trans('labels.new_users') }}</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                @foreach($newCustomers as $newCustomer)

                  <li><!-- start message -->
                    <a href="{{ URL::to("admin/customers/edit")}}/{{ $newCustomer->id}}">
                      <div class="pull-left">

                      </div>
                      <h4>
                        {{--{{ date('d/m/Y', $newCustomer->created_at) }}--}}
                        {{ $newCustomer->first_name }} {{ $newCustomer->last_name }}
                        <small><i class="fa fa-clock-o"></i> </small>
                      </h4>
                      <p></p>
                    </a>
                  </li>
                @endforeach
                  <!-- end message -->
                </ul>
              </li>
              <!--<li class="footer"><a href="#">See All Messages</a></li>-->
            </ul>
          </li>
          @if($result['commonContent']['setting']['Inventory'] == '1')
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-th"></i>
              <span class="label label-warning">{{ count($lowInQunatity) }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">{{ count($lowInQunatity) }} {{ trans('labels.products_are_in_low_quantity') }}</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                @foreach($lowInQunatity as $lowInQunatity)
                  <li><!-- start message -->
                  <a href="{{ URL::to("admin/inventoryreport?type=all&dateRange=&products_id=")}}{{ $lowInQunatity->products_id}}">
                      <div class="pull-left">
                         <img src="{{asset('').$lowInQunatity->image}}" class="img-circle" >
                      </div>
                      <h4 style="white-space: normal;">
                        {{ $lowInQunatity->products_name }}
                      </h4>
                      <p></p>
                    </a>
                  </li>
                @endforeach
                  <!-- end message -->
                </ul>
              </li>
              
              <!--<li class="footer"><a href="#">See All Messages</a></li>-->
            </ul>
          </li>
          @endif
          <li class="dropdown user user-menu">
          <a href="javascript:void(0)"  class="clear-cache small-box-footer btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ trans('labels.Clear Cache') }}">
            <i class="fa fa-eraser" aria-hidden="true"></i>
          </a>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }} </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

                <p>
                  {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                  <small>{{ trans('labels.administrator')}}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ URL::to('admin/admin/profile')}}" class="btn btn-default btn-flat">{{ trans('labels.profile_link')}}</a>
                </div>
                <div class="pull-right">
                  <a href="{{ URL::to('admin/logout')}}" class="btn btn-default btn-flat">{{ trans('labels.sign_out') }}</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!--<li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>
