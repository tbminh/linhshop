@extends('layout.master')
@section('title','Trang chủ')
@section('content')

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" style="height: 600px !important;">
          <div class="carousel-item active">
            <img class="d-block w-100" src="{{asset('public/upload_img/slider11.jpg')}}"  alt="First slide">
            <div class="carousel-caption d-none d-md-block text-left" style="top: 140px;">
                <div class="hero-content">
                    <h6></h6>
                    <h1 style="color: #fff;">C H Ả N H <br>
                    C O S M E T I C S</h1>
                    <a href="{{ url('page-shop/9999/1')}}" class="btn essence-btn">Xem ngay</a>
                </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="https://theblushboutique.com.au/wp-content/uploads/2017/02/slider-makeup.jpg"  alt="Second slide">
            <div class="carousel-caption d-none d-md-block text-left" style="top: 140px;">
                <div class="hero-content">
                    <h6></h6>
                    <h1 style="color: #fff;">C H Ả N H <br>
                    C O S M E T I C S</h1>
                    <a href="{{ url('page-shop/9999/1')}}" class="btn essence-btn">Xem ngay</a>
                </div>
            </div>
        </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{asset('public/upload_img/slider4.jpg')}}"  alt="Third slide">
            <div class="carousel-caption d-none d-md-block text-left" style="top: 140px;">
                <div class="hero-content">
                    <h6></h6>
                    <h1 style="color: #fff;">C H Ả N H <br>
                    C O S M E T I C S</h1>
                    <a href="{{ url('page-shop/9999/1')}}" class="btn essence-btn">Xem ngay</a>
                </div>
            </div>
        </div>
    </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    <!-- ##### Top Catagory Area Start ##### -->
    <div class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{asset('public/upload_img/slider2.jpg')}});">
                        <div class="catagory-content">
                            <a href="{{route('page_shop',[1,1])}}">Mỹ phẩm</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{asset('public/upload_img/slider3.jpg')}});">
                        <div class="catagory-content">
                            <a href="{{route('page_shop',[3,1])}}">Trang điểm</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{asset('public/upload_img/slider4.jpeg')}});">
                        <div class="catagory-content">
                            <a title="Tạm hết hàng" href="#">Chăm sóc tóc</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Top Catagory Area End ##### -->

    <!-- ##### CTA Area Start ##### -->
    <div class="cta-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cta-content bg-img background-overlay" style="background-image: url({{asset('public/upload_img/slider1.jpg')}});">
                        <div class="h-100 d-flex align-items-center justify-content-end">
                            <div class="cta--text">
                                <h6 style="color: #333;">-50%</h6>
                                <h2>Giảm giá</h2>
                                <a href="{{ url('page-shop/0/0')}}" class="btn essence-btn">Xem ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### CTA Area End ##### -->

    <!-- ##### New Arrivals Area Start ##### -->
    <section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Sản Phẩm Nổi Bật</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="popular-products-slides owl-carousel">
                        @foreach($get_product as $get_products)
                            <div class="single-product-wrapper">
                                <!-- Product Image -->
                                <div class="product-img">
                                    @foreach((array)json_decode($get_products->hinh_sp, true) as $image)
                                        <img  src="{{asset('public/upload_img/'.$image)}}" alt="">
                                        @break
                                    @endforeach
                                    <!-- Favourite -->
                                    <div class="product-favourite">
                                        <a href="#" class="favme fa fa-heart"></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    @foreach($get_pk_product as $get_pk_products)
                                        @if($get_pk_products->id == $get_products->ma_phankhuc )
                                            <span>{{trans($get_pk_products->tenphankhuc)}}</span>
                                        @endif
                                    @endforeach
                                    <a href="{{route('page_detail_product',$get_products->id)}}">
                                        <h6>{{trans($get_products->tensp)}}</h6>
                                    </a>
                                    <p class="product-price">{{number_format($get_products->gia_sp)}} VNĐ</p>

                                    <!-- Hover Content -->
                                    <div class="hover-content">
                                        <!-- Add to Cart -->
                                        <div class="add-to-cart-btn">
                                            <a href="#" class="btn essence-btn">Thêm vào giỏ hàng</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### New Arrivals Area End ##### -->

    <!-- ##### Brands Area Start ##### -->
    <div class="brands-area d-flex align-items-center justify-content-between">
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{asset('public/page_admin/img/core-img/brand1.png')}}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{asset('public/page_admin/img/core-img/brand2.png')}}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{asset('public/page_admin/img/core-img/brand3.png')}}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{asset('public/page_admin/img/core-img/brand4.png')}}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{asset('public/page_admin/img/core-img/brand5.png')}}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{asset('public/page_admin/img/core-img/brand6.png')}}" alt="">
        </div>
    </div>
    <!-- ##### Brands Area End ##### -->

    <script>
        var msg = '{{Session::get('login_success')}}';
        var exist = '{{Session::has('login_success')}}';
        if(exist){
            swal({
                title: "Đăng nhập thành công",
                text: "",
                type: "success",
                timer: 1200,
                showConfirmButton: false,
                position: 'top-end',
            });
        }
    </script>
@endsection
