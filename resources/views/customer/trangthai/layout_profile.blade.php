@extends('layout.master')
@section('title','Trạng thái đơn hàng')
@section('content')
    <link rel="stylesheet" href="{{ asset('public/style_profile_user.css') }}">
    <style>
        table thead tr th{
            text-align: center;
        }
    
        table tbody tr td{
            text-align: center;
        }
        .list-group{
                display: none;
        }
        .tabbable .nav-tabs{
            margin-bottom: 10px;
        }
    </style>
    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <br>
                    <div id="user-profile-2" class="user-profile">
                        <div class="tabbable"><br><br>
                            <ul class="nav nav-tabs padding-0">
                                <li>
                                    <a href="{{ url('page-info/'.Auth::id()) }}">
                                        <i class="orange ace-icon fa fa-cc-mastercard bigger-120"></i>
                                        Đơn hàng chưa nhận
                                    </a>  
                                </li>
                                <li>
                                    <a href="{{ url('page-complete/'.Auth::id()) }}">
                                        <i class="pink ace-icon fa fa-check bigger-120"></i>
                                        Đơn hàng đã nhận
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('page-cancel/'.Auth::id()) }}">
                                        <i class="pink ace-icon fa fa-close bigger-120"></i>
                                        Đã hủy
                                    </a>
                                </li>
                            </ul>
    
                            <div class="tab-content no-border padding-0"><br>
                                <div id="home" class="tab-pane in active">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-3 center"><br><br><br>
                                            <span class="profile-picture">
                                                <img class="editable img-responsive" alt="Avatar" id="avatar2 "
                                                src="https://e7.pngegg.com/pngimages/348/800/png-clipart-man-wearing-blue-shirt-illustration-computer-icons-avatar-user-login-avatar-blue-child.png" >
                                            </span>
    
                                            <div class="space space-4">
                                                <a href="#" class="btn btn-info btn-block">
                                                    <i class="fa fa-info-circle"></i> <b>Thông tin giao hàng</b>
                                                </a>
                                            </div>
                                                
                                            <br>
                                        </div>
                                        <!-- /.col -->
    
                                        <div class="col-xs-12 col-sm-9">
                                            @yield('content-profile-col-9')
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
    
                                    <div class="space-20"></div>
    
                                </div>
                                <!-- /#home -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection