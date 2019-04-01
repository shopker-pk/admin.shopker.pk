<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            @if(!empty(Session::get('role') == 0))
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
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li><a href="javascript::void(0);" class="menu-item">Brands</a>
                            <ul class="menu-content">
                                <li><a href="{{ route('manage_brands') }}" class="menu-item">Manage Brands</a><li>
                                <li><a href="{{ route('add_brands') }}" class="menu-item">Add Brands</a><li>
                            </ul>
                        </li>
                        <li><a href="javascript::void(0);" class="menu-item">Variations</a>
                            <ul class="menu-content">
                                <li><a href="{{ route('manage_variations') }}" class="menu-item">Manage Variations</a><li>
                                <li><a href="{{ route('add_variations') }}" class="menu-item">Add Variations</a><li>
                            </ul>
                        </li>
                        <li><a href="javascript::void(0);" class="menu-item">Products</a>
                            <ul class="menu-content">
                                <li><a href="{{ route('manage_products') }}" class="menu-item">Manage Products</a><li>
                                <li><a href="{{ route('add_products') }}" class="menu-item">Add Products</a><li>
                            </ul>
                        </li>
                    </ul>
                    <li class="nav-item">
                        <a href="javascript::void(0);"><i class="fa fa-send-o fa-fw"></i><span data-i18n="" class="menu-title">Orders</span></a>
                        <ul class="menu-content">
                            <li>
                                <a href="{{ route('manage_seller_orders') }}"><span data-i18n="" class="menu-title">Manage Orders</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="javascript::void(0);"><i class="fa fa-bullhorn fa-fw"></i><span data-i18n="" class="menu-title">Advertisement</span></a>
                        <ul class="menu-content">
                            <li>
                                <li><a href="javascript::void(0);" class="menu-item">Banners</a>
                                    <ul class="menu-content">
                                        <li><a href="{{ route('manage_banner_advertisements') }}" class="menu-item">Manage Banners</a><li>
                                        <li><a href="{{ route('add_banner_advertisements') }}" class="menu-item">Add Banners</a><li>
                                    </ul>
                                </li>
                                <li><a href="javascript::void(0);" class="menu-item">Coupons</a>
                                    <ul class="menu-content">
                                        <li><a href="{{ route('manage_coupons') }}" class="menu-item">Manage Coupons</a><li>
                                        <li><a href="{{ route('add_coupon') }}" class="menu-item">Add Coupons</a><li>
                                    </ul>
                                </li>
                                <li><a href="javascript::void(0);" class="menu-item">Daily Deals</a>
                                    <ul class="menu-content">
                                        <li><a href="{{ route('manage_daily_deals') }}" class="menu-item">Manage Daily Deals</a><li>
                                    </ul>
                                </li>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="javascript::void(0);"><i class="fa fa-money fa-fw"></i><span data-i18n="" class="menu-title">Payments</span></a>
                        <ul class="menu-content">
                            <li><a href="{{ route('manage_admin_invoices') }}" class="menu-item">Manage Invoices</a><li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="javascript::void(0);"><i class="ft-settings"></i><span data-i18n="" class="menu-title">Settings</span></a>
                        <ul class="menu-content">
                            <li><a href="javascript::void(0);" class="menu-item">Shipping Areas</a>
                                <ul class="menu-content">
                                    <li><a href="{{ route('manage_shipping_areas') }}"><span data-i18n="" class="menu-title">Manage Shipping Areas</span></a><li>
                                    <li><a href="{{ route('add_shipping_areas') }}" class="menu-item">Add Shipping Areas</a><li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('edit_store_setting') }}"><span data-i18n="" class="menu-title">Store Settings</span></a>
                                <a href="{{ route('admin_profile_settings') }}"><span data-i18n="" class="menu-title">Profile Settings</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="javascript::void(0);"><i class="fa fa-users fa-fw"></i><span data-i18n="" class="menu-title">CRM</span></a>
                        <ul class="menu-content">
                            <li>
                                <a href="{{ route('manage_customers') }}"><span data-i18n="" class="menu-title">Manage Customers</span></a>
                                <a href="{{ route('manage_vendors') }}"><span data-i18n="" class="menu-title">Manage Vendors</span></a>
                                <li><a href="javascript::void(0);" class="menu-item">Admins</a>
                                <ul class="menu-content">
                                    <li><a href="{{ route('manage_admins') }}"><span data-i18n="" class="menu-title">Manage Admins</span></a><li>
                                    <li><a href="{{ route('add_admins') }}" class="menu-item">Add Admins</a><li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="javascript::void(0);"><i class="fa fa-desktop fa-fw"></i><span data-i18n="" class="menu-title">CMS</span></a>
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
            @endif
        </ul>
    </div>
</div>
<div class="app-content content">
    <div class="content-wrapper">