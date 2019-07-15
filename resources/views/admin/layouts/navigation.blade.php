<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            <li class="nav-item"><a href="javascript::void(0);"><i class="ft-square"></i><span data-i18n="" class="menu-title">Ecommerce</span></a>
                <ul class="menu-content">
                    <li>
                        <li><a href="javascript::void(0);" class="menu-item">Categories</a>
                            <ul class="menu-content">
                                <li><a href="javascript::void(0)" class="menu-item">Parent Categories</a>
                                    <ul class="menu-content">
                                        <li><a href="{{ route('manage_parent_categories') }}" class="menu-item">Manage</a><li>
                                        <li><a href="{{ route('add_parent_categories') }}" class="menu-item">Add</a><li>
                                    </ul>
                                <li>
                                <li><a href="javascript::void(0)" class="menu-item">Child Categories</a>
                                    <ul class="menu-content">
                                        <li><a href="{{ route('manage_child_categories') }}" class="menu-item">Manage</a><li>
                                        <li><a href="{{ route('add_child_categories') }}" class="menu-item">Add</a><li>
                                    </ul>
                                <li>
                                <li><a href="javascript::void(0)" class="menu-item">Sub Child Categories</a>
                                    <ul class="menu-content">
                                        <li><a href="{{ route('manage_sub_child_categories') }}" class="menu-item">Manage</a><li>
                                        <li><a href="{{ route('add_sub_child_categories') }}" class="menu-item">Add</a><li>
                                    </ul>
                                <li>
                            </ul>
                        </li>
                        <li><a href="javascript::void(0);" class="menu-item">Brands</a>
                            <ul class="menu-content">
                                <li><a href="{{ route('manage_brands') }}" class="menu-item">Manage</a><li>
                                <li><a href="{{ route('add_brands') }}" class="menu-item">Add</a><li>
                            </ul>
                        </li>
                        <li><a href="javascript::void(0);" class="menu-item">Variations</a>
                            <ul class="menu-content">
                                <li><a href="{{ route('manage_variations') }}" class="menu-item">Manage</a><li>
                                <li><a href="{{ route('add_variations') }}" class="menu-item">Add</a><li>
                            </ul>
                        </li>
                    </li>
                </ul>
                <li class="nav-item">
                    <a href="javascript::void(0);"><i class="fa fa-book fa-fw"></i><span data-i18n="" class="menu-title">Products</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('manage_products') }}" class="menu-item">Manage</a><li>
                        <li><a href="{{ route('add_products') }}" class="menu-item">Add</a><li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript::void(0);"><i class="fa fa-send-o fa-fw"></i><span data-i18n="" class="menu-title">Orders</span> ({{ count_new_orders() }})</a>
                    <ul class="menu-content">
                        <li>
                            <a href="{{ route('manage_seller_orders') }}"><span data-i18n="" class="menu-title">Manage</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript::void(0);"><i class="fa fa-bullhorn fa-fw"></i><span data-i18n="" class="menu-title">Advertisement</span></a>
                    <ul class="menu-content">
                        <li>
                            <li><a href="javascript::void(0);" class="menu-item">Banners</a>
                                <ul class="menu-content">
                                    <li><a href="{{ route('manage_banner_advertisements') }}" class="menu-item">Manage</a><li>
                                    <li><a href="{{ route('add_banner_advertisements') }}" class="menu-item">Add</a><li>
                                </ul>
                            </li>
                            <li><a href="javascript::void(0);" class="menu-item">Coupons</a>
                                <ul class="menu-content">
                                    <li><a href="{{ route('manage_coupons') }}" class="menu-item">Manage</a><li>
                                    <li><a href="{{ route('add_coupon') }}" class="menu-item">Add</a><li>
                                </ul>
                            </li>
                            <li><a href="javascript::void(0);" class="menu-item">Daily Deals</a>
                                <ul class="menu-content">
                                    <li><a href="{{ route('manage_daily_deals') }}" class="menu-item">Manage</a><li>
                                </ul>
                            </li>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript::void(0);"><i class="fa fa-money fa-fw"></i><span data-i18n="" class="menu-title">Payments</span></a>
                    <ul class="menu-content">
                        <li>
                            <li><a href="javascript::void(0);" class="menu-item">Invoices</a>
                                <ul class="menu-content">
                                    <li><a href="{{ route('manage_admin_invoices') }}" class="menu-item">Manage</a><li>
                                </ul>
                            </li>
                            <li><a href="javascript::void(0);" class="menu-item">Finance</a>
                                <ul class="menu-content">
                                    <li><a href="{{ route('manage_account_statement') }}" class="menu-item">Account Statement</a><li>
                                    <li><a href="{{ route('manage_orders_overview') }}" class="menu-item">Orders Overview</a><li>
                                </ul>
                            </li>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript::void(0);"><i class="ft-settings"></i><span data-i18n="" class="menu-title">Settings</span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="{{ route('edit_store_setting') }}"><span data-i18n="" class="menu-title">Site</span></a>
                            <a href="{{ route('admin_profile_settings') }}"><span data-i18n="" class="menu-title">Profile</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript::void(0);"><i class="fa fa-users fa-fw"></i><span data-i18n="" class="menu-title">CRM</span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="{{ route('manage_customers') }}"><span data-i18n="" class="menu-title">Customers</span></a>
                            <a href="{{ route('manage_vendors') }}"><span data-i18n="" class="menu-title">Vendors</span></a>
                            <li><a href="javascript::void(0);" class="menu-item">Admins</a>
                            <ul class="menu-content">
                                <li><a href="{{ route('manage_admins') }}"><span data-i18n="" class="menu-title">Manage Admins</span></a><li>
                                <li><a href="{{ route('add_admins') }}" class="menu-item">Add Admins</a><li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript::void(0);"><i class="fa fa-file"></i><span data-i18n="" class="menu-title">CMS</span></a>
                    <ul class="menu-content">
                        <li><a href="javascript::void(0);" class="menu-item">Pages</a>
                            <ul class="menu-content">
                                <li>
                                    <a href="{{ route('manage_pages') }}"><span data-i18n="" class="menu-title">Manage Pages</span></a>
                                    <a href="{{ route('add_pages') }}"><span data-i18n="" class="menu-title">Add Pages</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </li>
        </ul>
    </div>
</div>
<div class="app-content content">
    <div class="content-wrapper">