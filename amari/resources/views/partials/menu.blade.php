<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li>
            <select class="searchable-field form-control">

            </select>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/drivers*") ? "c-show" : "" }} {{ request()->is("admin/customers*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.custcategory.index") }}" class="c-sidebar-nav-link {{ request()->is("/custcategories") || request()->is("/custcategories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                Customer Categories
                            </a>
                        </li>



                    @can('customer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.customers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/customers") || request()->is("admin/customers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-plus c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.customer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan


        @can('reports_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/products*") ? "c-show" : "" }} {{ request()->is("admin/maps*") ? "c-show" : "" }} {{ request()->is("admin/push-notifications*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-hand-holding-usd c-sidebar-nav-icon">

                    </i>
                    Manage Products
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('product_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.products.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-list c-sidebar-nav-icon">

                            </i>
                            Products
                        </a>
                    </li>
                @endcan


                        @can('units_access')
                <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.productunits.index") }}" class="c-sidebar-nav-link {{ request()->is("/product/units/index") || request()->is("/product/units/index/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">
                                </i>
                                Product Units
                            </a>
                        </li>
                        @endcan

                        @can('product_category_access')
                <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.productcategory.index") }}" class="c-sidebar-nav-link {{ request()->is("/productcategory") || request()->is("/productcategory/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">
                                </i>
                                Category
                            </a>
                        </li>
                        @endcan


                    @can('brand_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.brands.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-book c-sidebar-nav-icon">
                                </i>
                                Brand
                            </a>
                        </li>
                    @endcan




                </ul>
            </li>
        @endcan




        {{-- @can('stock_movement_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/drivers*") ? "c-show" : "" }} {{ request()->is("admin/customers*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-warehouse c-sidebar-nav-icon">

                    </i>
                    Stock Movement Reports
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('stock_movement_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.stock.count") }}" class="c-sidebar-nav-link {{ request()->is("admin/stockcount") || request()->is("admin/stockcount/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-tag c-sidebar-nav-icon">

                                </i>
                                Stock Count
                            </a>
                        </li>
                    @endcan
                    @can('stock_movement_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.stock.request") }}" class="c-sidebar-nav-link {{ request()->is("admin/stockrequest") || request()->is("admin/stockrequests/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-window-restore c-sidebar-nav-icon">

                                </i>
                               Stock Request
                            </a>
                        </li>
                    @endcan
                    @can('stock_movement_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.stock.hold") }}" class="c-sidebar-nav-link {{ request()->is("admin/stockhold") || request()->is("admin/stockhold/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-archive c-sidebar-nav-icon">

                                </i>
                                Detailed Stock Hold
                            </a>
                        </li>
                    @endcan
                    @can('stock_movement_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.stock.vanmovement") }}" class="c-sidebar-nav-link {{ request()->is("admin/vanmovement") || request()->is("admin/vanmovement/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-copy c-sidebar-nav-icon">

                                </i>
                                Detailed Stock Movement Van
                            </a>
                        </li>
                    @endcan

                    @can('stock_movement_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.gstock.hold") }}" class="c-sidebar-nav-link {{ request()->is("admin/vanmovement") || request()->is("admin/vanmovement/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-copy c-sidebar-nav-icon">

                                </i>
                                General Stock Hold
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan --}}


        {{-- @can('reports_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/reports*") ? "c-show" : "" }} {{ request()->is("admin/reports*") ? "c-show" : "" }} {{ request()->is("admin/reports*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                    </i>
                    Reports
                </a>
                <ul class="c-sidebar-nav-dropdown-items">

                    @can('map_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.maps.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/reports") || request()->is("admin/reports/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-street-view c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.map.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('salesreport_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{route("admin.sales.report") }}" class="c-sidebar-nav-link">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Sales Report
                            </a>
                        </li>
                    @endcan

                    @can('exec_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.exec.reports") }}" class="c-sidebar-nav-link {{ request()->is("admin/maps") || request()->is("admin/maps/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Sales Executive Summary
                            </a>
                        </li>
                    @endcan

                    @can('subd_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.subd.reports") }}" class="c-sidebar-nav-link {{ request()->is("admin/maps") || request()->is("admin/maps/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Sub DWise
                            </a>
                        </li>
                    @endcan

                    @can('route_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.route.reports") }}" class="c-sidebar-nav-link {{ request()->is("admin/maps") || request()->is("admin/maps/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Route Wise
                            </a>
                        </li>
                    @endcan
                    @can('van_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.van.reports") }}" class="c-sidebar-nav-link {{ request()->is("admin/maps") || request()->is("admin/maps/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Van Wise
                            </a>
                        </li>
                    @endcan

                    @can('rep_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.rep.reports") }}" class="c-sidebar-nav-link {{ request()->is("admin/maps") || request()->is("admin/maps/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Rep Wise
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan --}}

        {{-- @can('sales_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sales*") ? "c-show" : "" }} {{ request()->is("admin/sales*") ? "c-show" : "" }} {{ request()->is("admin/sales*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                    </i>
                    Sales Management
                </a>
                <ul class="c-sidebar-nav-dropdown-items">

                    @can('sales_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.sales.index") }}" class="c-sidebar-nav-link {{ request()->is("all/sales") || request()->is("all/sales/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                All Sales
                            </a>
                        </li>
                    @endcan


                </ul>
            </li>
        @endcan --}}


        {{-- @can('reports_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/reports*") ? "c-show" : "" }} {{ request()->is("admin/reports*") ? "c-show" : "" }} {{ request()->is("admin/reports*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                    </i>
                    Sales Report
                </a>
                <ul class="c-sidebar-nav-dropdown-items">



                    @can('salesreport_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{route("admin.salesreports.daybook") }}" class="c-sidebar-nav-link">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Day Book
                            </a>
                        </li>
                    @endcan

                    @can('salesreport_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.salesreports.summaryday") }}" class="c-sidebar-nav-link {{ request()->is("admin/summarydaybook") || request()->is("admin/summarydaybook/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Summary Day Book
                            </a>
                        </li>
                    @endcan
                    @can('salesreport_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.salesreport.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/salesreport") || request()->is("admin/salesreport/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Sales Report
                            </a>
                        </li>
                    @endcan
                    @can('salesreport_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.salesreports.pfm") }}" class="c-sidebar-nav-link {{ request()->is("admin/pfm") || request()->is("admin/pfm/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                Customer PFM
                            </a>
                        </li>
                    @endcan


                </ul>
            </li>
        @endcan --}}

        {{-- @can('purchases_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/purchases*") ? "c-show" : "" }} {{ request()->is("admin/purchases*") ? "c-show" : "" }} {{ request()->is("admin/purchases*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                    </i>
                    Purchases
                </a>
                <ul class="c-sidebar-nav-dropdown-items">

                    @can('purchases_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.purchases.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/purchases") || request()->is("admin/purchases/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                                </i>
                                All Purchases
                            </a>
                        </li>
                    @endcan


                </ul>
            </li>
        @endcan --}}

        {{-- @can('accounting_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/purchases*") ? "c-show" : "" }} {{ request()->is("admin/purchases*") ? "c-show" : "" }} {{ request()->is("admin/purchases*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                    </i>
                    Accounting
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                @can('performance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.expensecategories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/expense/categories") || request()->is("admin/expensecategory/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-street-view c-sidebar-nav-icon">

                                </i>
                                Expenses Category
                            </a>
                        </li>
                    @endcan

                @can('performance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.expenses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/expenses") || request()->is("admin/expenses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-street-view c-sidebar-nav-icon">

                                </i>
                                Expenses
                            </a>
                        </li>
                    @endcan




                </ul>
            </li>
        @endcan --}}

        @can('dealer_access')
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.dealers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/dealers") || request()->is("admin/dealers/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-industry c-sidebar-nav-icon">

                </i>
                Dealers
            </a>
        </li>
    @endcan
    @can('routes_access')
    <li class="c-sidebar-nav-item">
        <a href="{{ route("admin.routes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/routes") || request()->is("admin/routes/*") ? "c-active" : "" }}">
            <i class="fa-fw fas fa-industry c-sidebar-nav-icon">

            </i>
            Routes
        </a>
    </li>
@endcan
<li class="c-sidebar-nav-item">
    <a href="{{ route("admin.presaleorders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/presaleorders") || request()->is("admin/presaleorders/*") ? "c-active" : "" }}">
        <i class="fa-fw fas fa-industry c-sidebar-nav-icon">

        </i>
        Presale Orders
    </a>
</li>
    {{-- <li class="c-sidebar-nav-item">
        <a href="{{ route("admin.settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/settings") || request()->is("admin/settings/*") ? "c-active" : "" }}">
            <i class="fa-fw fas fa-industry c-sidebar-nav-icon">

            </i>
            Settings
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a href="{{ route("admin.subscriptions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/subscriptions") || request()->is("admin/subscriptions/*") ? "c-active" : "" }}">
            <i class="fa-fw fas fa-industry c-sidebar-nav-icon">

            </i>
            Subscriptions
        </a>
    </li> --}}
    {{-- <li class="c-sidebar-nav-item">
        <a href="{{ route("admin.contactus.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contactus") || request()->is("admin/contactus/*") ? "c-active" : "" }}">
            <i class="fa-fw fas fa-industry c-sidebar-nav-icon">

            </i>
            Messages
        </a>
    </li> --}}

        {{-- @can('van_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.vans.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/vans") || request()->is("admin/vans/*") ? "c-active" : "" }}">
                                <i class="fa fa-truck fa-lg c-sidebar-nav-icon" aria-hidden="true"></i>
                                </i>
                                Vans
                            </a>
                        </li>
                    @endcan



          @can('dispatch_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.dispatch.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/dispatch") || request()->is("admin/dispatch/*") ? "c-active" : "" }}">
                                <i class="fa fa-cart-plus fa-lg c-sidebar-nav-icon" aria-hidden="true"></i>
                                </i>
                                Dispatch
                            </a>
                        </li>
                    @endcan




                  {{--   @can('map_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.maps.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/maps") || request()->is("admin/maps/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-street-view c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.map.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('efris_setting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.efris-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/efris-settings") || request()->is("admin/maps/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-street-view c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.efrisSetting.title') }}
                            </a>
                        </li>
                    @endcan


        @can('performance_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/purchases*") ? "c-show" : "" }} {{ request()->is("admin/purchases*") ? "c-show" : "" }} {{ request()->is("admin/purchases*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-bar-chart c-sidebar-nav-icon">

                    </i>
                    Performance
                </a>
                <ul class="c-sidebar-nav-dropdown-items">

                @can('performance_setting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.performance-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/performance-settings") || request()->is("admin/performance-settings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-street-view c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.performanceSetting.title') }}
                            </a>
                        </li>
                    @endcan



                @can('performance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.performances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/performances") || request()->is("admin/maps/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-street-view c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.performance.title') }}
                            </a>
                        </li>
                    @endcan




                </ul>
            </li>
        @endcan --}}




            {{-- @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                            <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                            </i>
                            {{ trans('global.change_password') }}
                        </a>
                    </li>
                @endcan
            @endif
            --}}
            <li class="c-sidebar-nav-item">
                <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
    </ul>

</div>
