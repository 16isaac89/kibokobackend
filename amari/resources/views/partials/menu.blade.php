<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li>
            <select class="searchable-field form-control mb-3">
                <!-- Placeholder for searchable field -->
            </select>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt"></i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
@if(auth()->user()->designation == 1 || auth()->user()->designation == "1" )
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon"></i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon"></i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon"></i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon"></i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.custcategory.index") }}" class="c-sidebar-nav-link {{ request()->is("/custcategories") || request()->is("/custcategories/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-user c-sidebar-nav-icon"></i>
                            Customer Categories
                        </a>
                    </li>
                    @can('customer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.customers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/customers") || request()->is("admin/customers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-plus c-sidebar-nav-icon"></i>
                                {{ trans('cruds.customer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon"></i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('reports_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/products*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-chart-bar c-sidebar-nav-icon"></i>
                    Reports
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.all.reports") }}" class="c-sidebar-nav-link {{ request()->is("admin/presaleorders") || request()->is("admin/presaleorders/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-file-invoice c-sidebar-nav-icon"></i>
                            All Reports
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.presaleorders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/presaleorders") || request()->is("admin/presaleorders/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-file-invoice c-sidebar-nav-icon"></i>
                            Presale Order Invoice
                        </a>
                    </li>
                     <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.presaleorders.general") }}" class="c-sidebar-nav-link {{ request()->is("admin/vanreports") || request()->is("admin/vanreports/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-bus c-sidebar-nav-icon"></i>
                            Presale Order Subdealer
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
		@endif

        @can('dealer_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/dealers*") || request()->is("admin/routes*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-industry c-sidebar-nav-icon"></i>
                    Dealer Management
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.dealers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/dealers") || request()->is("admin/dealers/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-user-tie c-sidebar-nav-icon"></i>
                            Dealers
                        </a>
                    </li>
					@if(auth()->user()->designation == 1 || auth()->user()->designation == "1" )
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.routes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/routes") || request()->is("admin/routes/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-route c-sidebar-nav-icon"></i>
                            Routes
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.product-divisions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/product-divisions") || request()->is("admin/product-divisions/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-user-tie c-sidebar-nav-icon"></i>
                            Division
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.dispatch.index") }}" class="c-sidebar-nav-link
                        {{ request()->is("admin/dispatch") || request()->is("admin/dispatch/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-user-tie c-sidebar-nav-icon"></i>
                            Dispatch Purchase
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.captainperfomance.index") }}" class="c-sidebar-nav-link
                        {{ request()->is("admin/captainperfomance") || request()->is("admin/captainperfomance/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-user-tie c-sidebar-nav-icon"></i>
                            Perfomance
                        </a>
                    </li>
					@endif
                </ul>
            </li>
        @endcan


@if(auth()->user()->designation == 1 || auth()->user()->designation == "1" )
         @can('product_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/products*") ? "c-show" : "" }} {{ request()->is("admin/maps*") ? "c-show" : "" }} {{ request()->is("admin/push-notifications*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-hand-holding-usd c-sidebar-nav-icon">

                    </i>
                    Manage Products
                </a>
                <ul class="c-sidebar-nav-dropdown-items">


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

                     @can('product_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.products.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-list c-sidebar-nav-icon">

                                </i>
                                Products
                            </a>
                        </li>
                    @endcan
                    @can('push_notification_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.push-notifications.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/push-notifications") || request()->is("admin/push-notifications/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-flag c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.pushNotification.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
		@endif

        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt"></i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
