<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head id="css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="keywords" content="{{ $meta_keywords }}">
    <meta name="description" content="{{ $meta_description }}">
    <title>{{ $page_title }}</title>
    @include('admin.layouts.style')
</head>
<body data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar">
    @include('admin.layouts.navigation')
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
         <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
               <li class="nav-item mobile-menu d-md-none mr-auto">
                  <a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu font-large-1"></i></a>
               </li>
                <li class="nav-item mr-auto">
                    <a href="{{ route('admin_dashboard') }}" class="navbar-brand">
                        @if(!empty($result->title))
                            <h3 class="brand-text">{{ $result->title }}</h3>
                        @else
                            <h3 class="brand-text">Laravel Ecommerce</h3>
                        @endif
                    </a>
                </li>
               <li class="nav-item d-md-none">
                  <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="fa fa-ellipsis-v"></i></a>
               </li>
            </ul>
         </div>
         <div class="navbar-container content">
            <div id="navbar-mobile" class="navbar-collapse">
               <ul class="nav navbar-nav mr-auto float-left"></ul>
               <ul class="nav navbar-nav float-right">
                  <li class="dropdown dropdown-notification nav-item"></li>
                  <li class="dropdown dropdown-notification nav-item"></li>
                  <li class="dropdown dropdown-user nav-item">
                     <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                        <span class="avatar avatar-online">
                           <img src="{{ asset('public/assets/admin/images/profile_images/'.$result->image) }}" alt=""><i></i>
                        </span>
                        <span class="user-name">{{ $result->first_name }} {{ $result->last_name }}</span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right">
                        @if(session::get('role') == 0)
                           <a href="{{ route('admin_profile_settings') }}" class="dropdown-item"><i class="ft-user"></i> Edit Profile</a>
                           <div class="dropdown-divider"></div>
                           <a href="{{ route('sign_out') }}" class="dropdown-item"><i class="ft-power"></i> Logout</a>
                        @endif
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </nav>
   @include('admin.layouts.messages')