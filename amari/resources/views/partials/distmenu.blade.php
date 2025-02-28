<div class="am-sideleft">
    <ul class="nav am-sideleft-tab">
      <li class="nav-item">
        <a href="#mainMenu" class="nav-link active"><i class="icon ion-ios-home-outline tx-24"></i></a>
      </li>
      <li class="nav-item">
        <a href="#emailMenu" class="nav-link"><i class="icon ion-ios-email-outline tx-24"></i></a>
      </li>
      <li class="nav-item">
        <a href="#chatMenu" class="nav-link"><i class="icon ion-ios-chatboxes-outline tx-24"></i></a>
      </li>
      <li class="nav-item">
        <a href="#settingMenu" class="nav-link"><i class="icon ion-ios-gear-outline tx-24"></i></a>
      </li>
    </ul>

    <div class="tab-content">
      <div id="mainMenu" class="tab-pane active">
        <ul class="nav am-sideleft-menu">
            @if(\Gate::forUser('dealer')->allows('dashboard_access'))
          <li class="nav-item">
            <a href="{{ route('dashboard.home') }}" class="nav-link active">
              <i class="icon ion-ios-home-outline"></i>
              <span>Dashboard</span>
            </a>
          </li><!-- nav-item -->
@endif
@if(\Gate::forUser('dealer')->allows('reports_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-analytics-outline"></i>
              <span>Reports</span>
            </a>
            <ul class="nav-sub">
              <li class="nav-item"><a href="{{route('salerreports.index')}}" class="nav-link">Sales Report</a></li>
              <li class="nav-item"><a href="{{route('dealer.mapreport')}}" class="nav-link">Sales Map</a></li>
              {{-- <li class="nav-item"><a href="{{route('dealer.tradingreport')}}" class="nav-link">Trading Report</a></li> --}}
              <li class="nav-item"><a href="{{route('dealer.execreport')}}" class="nav-link">Sales Exec Summary</a></li>
              <li class="nav-item"><a href="{{route('dealer.routereport')}}" class="nav-link">Route</a></li>
              <li class="nav-item"><a href="{{route('dealer.vanreport')}}" class="nav-link">Van</a></li>
              <li class="nav-item"><a href="{{route('dealer.repreport')}}" class="nav-link">Rep</a></li>
              <li class="nav-item"><a href="{{route('dealer.brandreport')}}" class="nav-link">Brand</a></li>
            </ul>
          </li><!-- nav-item -->
@endif
@if(\Gate::forUser('dealer')->allows('execreports_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-analytics-outline"></i>
              <span>Executive Reports</span>
            </a>
            <ul class="nav-sub">
              <li class="nav-item"><a href="{{route('execsalerreports.index')}}" class="nav-link">Sales Report</a></li>
              <li class="nav-item"><a href="{{route('execdealer.mapreport')}}" class="nav-link">Sales Map</a></li>
              {{-- <li class="nav-item"><a href="{{route('dealer.tradingreport')}}" class="nav-link">Trading Report</a></li> --}}
              <li class="nav-item"><a href="{{route('execdealer.execreport')}}" class="nav-link">Sales Exec Summary</a></li>
              <li class="nav-item"><a href="{{route('execdealer.routereport')}}" class="nav-link">Route</a></li>
              <li class="nav-item"><a href="{{route('execdealer.vanreport')}}" class="nav-link">Van</a></li>
              <li class="nav-item"><a href="{{route('execdealer.repreport')}}" class="nav-link">Rep</a></li>
              <li class="nav-item"><a href="{{route('execdealer.brandreport')}}" class="nav-link">Brand</a></li>
            </ul>
          </li><!-- nav-item -->
@endif
@if(\Gate::forUser('dealer')->allows('product_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-gear-outline"></i>
              <span>Products</span>
            </a>
            <ul class="nav-sub">
              <li class="nav-item"><a href="{{route('products.index')}}" class="nav-link">Catalog</a></li>
            </ul>
          </li><!-- nav-item -->
          @endif
          @if(\Gate::forUser('dealer')->allows('dispatch_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-filing-outline"></i>
              <span>Dispatch</span>
            </a>
            <ul class="nav-sub">
              <li class="nav-item"><a href="{{route('dispatches.index')}}" class="nav-link">New</a></li>
              <li class="nav-item"><a href="{{route('dealer.dispatch.records')}}" class="nav-link">Records</a></li>
               <li class="nav-item"><a href="{{route('dealer.getstock.requests')}}" class="nav-link">Presale Orders</a></li>
               <li class="nav-item"><a href="{{route('dealer.dispatch.maindealer')}}" class="nav-link">Dealer Dispatch</a></li>
            </ul>
          </li><!-- nav-item -->
@endif

@if(\Gate::forUser('dealer')->allows('user_management_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-navigate-outline"></i>
              <span>User Management</span>
            </a>
            <ul class="nav-sub">
                <li class="nav-item"><a href="{{route('dealerbranches.index')}}" class="nav-link">Branch</a></li>
                @if(\Gate::forUser('dealer')->allows('role_access'))
                <li class="nav-item"><a href="{{route('dealerroles.index')}}" class="nav-link">Roles</a></li>
                @endif
              <li class="nav-item"><a href="{{route('dealer.users.index')}}" class="nav-link">Users</a></li>

            </ul>
          </li><!-- nav-item -->
@endif
@if(\Gate::forUser('dealer')->allows('customer_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-list-outline"></i>
              <span>Customers</span>
            </a>
            <ul class="nav-sub">
              <li class="nav-item"><a href="{{route('customers.index')}}" class="nav-link">All</a></li>
            </ul>
          </li><!-- nav-item -->
@endif

@if(\Gate::forUser('dealer')->allows('van_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-bookmarks-outline"></i>
              <span>Vans</span>
            </a>
            <ul class="nav-sub">
              <li class="nav-item"><a href="{{route('vans.index')}}" class="nav-link">All</a></li>
            </ul>
          </li><!-- nav-item -->
@endif

@if(\Gate::forUser('dealer')->allows('route_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-briefcase-outline"></i>
              <span>Routes</span>
            </a>
            <ul class="nav-sub">
              <li class="nav-item"><a href="{{route('routes.index')}}" class="nav-link">All</a></li>
            </ul>
          </li><!-- nav-item -->
@endif


@if(\Gate::forUser('dealer')->allows('sales_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-briefcase-outline"></i>
              <span>Sales</span>
            </a>
            <ul class="nav-sub">

            <li class="nav-item"><a href="{{route('dealer.getreturns')}}" class="nav-link">Return Requests</a></li>
               <li class="nav-item"><a href="{{route('dealersales.index')}}" class="nav-link">Sales</a></li>
              <!-- <li class="nav-item"><a href="{{route('dealersales.index')}}" class="nav-link">Invoices</a></li>
              <li class="nav-item"><a href="{{route('dealersales.index')}}" class="nav-link">Receipts</a></li>  -->
              @if(Auth::guard('dealer')->user() && Auth::guard('dealer')->user()->dealer->efris === 1)
               <li class="nav-item"><a href="{{route('dealer.creditnote.index')}}" class="nav-link">Credit Notes</a></li>
               @endif
            </ul>
          </li><!-- nav-item -->

@endif
{{-- @if(\Gate::forUser('dealer')->allows('pos_access'))
          <li class="nav-item">
            <a href="" class="nav-link with-sub">
              <i class="icon ion-ios-briefcase-outline"></i>
              <span>POS</span>
            </a>
            <ul class="nav-sub">
              <li class="nav-item"><a href="{{route('dealer.posscreen')}}" class="nav-link">POS</a></li>
            </ul>
          </li><!-- nav-item -->
@endif --}}


        </ul>
      </div><!-- #mainMenu -->



    </div><!-- tab-content -->
  </div><!-- am-sideleft -->
