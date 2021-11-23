@extends('layout.master')
@foreach($get_product as $get_products)
    @section('title',trans($get_products->tensp))
@endforeach
@section('content')
    @foreach($get_product as $get_products)
        <!-- ##### Single Product Details Area Start ##### -->
        <section class="single_product_details_area d-flex align-items-center">
            <!-- Single Product Thumb -->
            <div class="single_product_thumb clearfix">
                <div class="">
                    @foreach((array)json_decode($get_products->hinh_sp, true) as $image)
                        <img style="margin-left: 80px" width="60%" src="{{asset('public/upload_img/'.$image)}}" alt="">
                        @break
                    @endforeach
                </div>
            </div>
            <!-- Single Product Description -->
            <div class="single_product_desc clearfix">
                @foreach($get_pk_product as $get_pk_products)
                    @if($get_pk_products->id == $get_products->ma_phankhuc )
                        <span>{{trans($get_pk_products->tenphankhuc)}}</span>
                    @endif
                @endforeach
                <a href="#">
                    <h2>{{trans($get_products->tensp)}}</h2>
                </a>

                @if($get_products->giamgia_sp == 0)
                    <p class="product-price">{{number_format($get_products->gia_sp)}} VNĐ</p>
                @else
                    <p class="product-price"><span class="old-price">{{number_format($get_products->gia_sp)}}VNĐ</span>{{number_format($get_products->gia_sp-($get_products->gia_sp*($get_products->giamgia_sp/100)))}} VNĐ</p>
                @endif
                <!-- Form -->
                <form class="cart-form clearfix" action="{{ url('add-cart-detail/'.Auth::id().'/'.$get_products->id) }}" method="post">
                    @csrf
                    <!-- Select Box -->
                    <label for="#">Số Lượng:  </label>
                    <input type="number" name="inputQty" value="1" style="width: 50px; height:30px; text-align: center;">
                    <!-- Cart & Favourite Box -->
                    <div class="cart-fav-box d-flex align-items-center">
                        <!-- Cart -->
                        @if (Auth::check())
                            <button type="submit" name="addtocart" value="5" class="btn essence-btn">
                                <i class="fa fa-shopping-cart"></i> Thêm Vào giỏ hàng
                            </button>
                        @else
                            <a href="{{ url('page-signin') }}" onclick="return confirm('Bạn phải đăng nhập trước!')" class="btn essence-btn"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                        @endif
                        <!-- Favourite -->
                        <div class="product-favourite ml-4">
                            <a href="#" class="favme fa fa-heart"></a>
                        </div>
                    </div>
                </form>
                <div>
                    <div class="#">
                        <div  class="#">
                            <h3>Mô tả</h3>
                            <p> {{ $get_products->mota_sp }}</p>
                        </div>

                        {{-- <div role="tabpanel" class="tab-pane fade" id="profile">
                            @php($get_product_suppliers = DB::table('product_suppliers')->where('product_id',$view_detail_product->id)->first())
                            @php($get_suppliers = DB::table('suppliers')->where('id', $get_product_suppliers->supplier_id)->first())
                            <p><b style="font-size: 20px">{{ $get_suppliers->supplier_name }}</b>  </p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    @if(Auth()->check())
                        <style>
                            .rating_circle{
                                width: 180px;
                                height: 180px;
                                border-radius: 50%;
                                border: 1px none;
                                font-size: 50px;
                                font-weight: bold;
                            }
                            .rating_text{
                                margin-top:1px;
                                font-size: 20px;
                            }

                            /* Stylingand links*/
                            .starrating > input {display: none;}
                            .starrating > label:before {
                                content: "\f005";
                                margin: 5px;
                                font-size:40px;
                                font-family: FontAwesome, serif;
                                display: inline-block;
                            }
                            .starrating > label{color: #4a5568;}
                            .starrating > input:checked ~ label{ color: #ffca08 ; }
                            .starrating > input:hover ~ label{ color: #ffca08 ;  }
                        </style>
                        <div class="card pb-0 mt-5">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <button class="rating_circle">
                                            @php($avg_rating = DB::table('rating_stars')->where('product_id', $get_products->id)->avg('rating_star'))
                                            {{ round($avg_rating, 1) }} / <span class="text-warning">5 <i class="fa fa-star" style="color:#ffca08;"></i></span>
                                        </button>
                                    </div>
                                    <div class="col-10 col-md-6">
                                        <div class="progress mt-2" style="height:15px;">
                                            <div class="progress-bar bg-success" style="width:100%;height:15px;">5 Sao</div>
                                        </div>
                                        <div class="progress mt-3" style="height:15px;">
                                            <div class="progress-bar bg-info" style="width:80%;height:15px;">4 Sao</div>
                                        </div>
                                        <div class="progress mt-3" style="height:15px;">
                                            <div class="progress-bar bg-primary" style="width:60%;height:15px;">3 Sao</div>
                                        </div>
                                        <div class="progress mt-3" style="height:15px;">
                                            <div class="progress-bar bg-warning" style="width:40%;height:15px;">2 Sao</div>
                                        </div>
                                        <div class="progress mt-3" style="height:15px;">
                                            <div class="progress-bar bg-danger" style="width:20%;height:15px;">1 Sao</div>
                                        </div>
                                    </div>
                                    <div class="col-2 col-md-2 mt-0">
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_5 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star', '=',5]])->count())
                                                {{ $count_5 }}
                                            </b>
                                        </div>
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_4 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star', '=',4]])->count())
                                                {{ $count_4 }}
                                            </b>
                                        </div>
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_3 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star', '=',3]])->count())
                                                {{ $count_3 }}
                                            </b>
                                        </div>
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_2 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star','=',2]])->count())
                                                {{ $count_2 }}
                                            </b>
                                        </div>
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_1 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star','=',1]])->count())
                                                {{ $count_1 }}
                                            </b>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::check())
                                    <form action="{{ route('postRatingStar', [Auth::user()->id, $get_products->id]) }}" method="post" id="FormSubmit">
                                        @csrf
                                        <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                            <input type="radio" id="star5" name="rating" value="5" onclick="return SubmitFormFunction();"/><label for="star5" title="5 star"></label>
                                            <input type="radio" id="star4" name="rating" value="4" onclick="return SubmitFormFunction();"/><label for="star4" title="4 star"></label>
                                            <input type="radio" id="star3" name="rating" value="3" onclick="return SubmitFormFunction();"/><label for="star3" title="3 star"></label>
                                            <input type="radio" id="star2" name="rating" value="2" onclick="return SubmitFormFunction();"/><label for="star2" title="2 star"></label>
                                            <input type="radio" id="star1" name="rating" value="1" onclick="return SubmitFormFunction();"/><label for="star1" title="1 star"></label>
                                        </div>
                                    </form>
                                @else

                                    <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                        <input type="radio" id="star5" name="rating" value="5"/><label for="star5" title="5 star" onclick="MessageFunction()"></label>
                                        <input type="radio" id="star4" name="rating" value="4"/><label for="star4" title="4 star" onclick="MessageFunction()"></label>
                                        <input type="radio" id="star3" name="rating" value="3"/><label for="star3" title="3 star" onclick="MessageFunction()"></label>
                                        <input type="radio" id="star2" name="rating" value="2"/><label for="star2" title="2 star" onclick="MessageFunction()"></label>
                                        <input type="radio" id="star1" name="rating" value="1"/><label for="star1" title="1 star" onclick="MessageFunction()"></label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <style>
                            .rating_circle{
                                width: 180px;
                                height: 180px;
                                border-radius: 50%;
                                border: 1px none;
                                font-size: 50px;
                                font-weight: bold;
                            }
                            .rating_text{
                                margin-top:1px;
                                font-size: 20px;
                            }

                            /* Stylingand links*/
                            .starrating > input {display: none;}
                            .starrating > label:before {
                                content: "\f005";
                                margin: 5px;
                                font-size:40px;
                                font-family: FontAwesome, serif;
                                display: inline-block;
                            }
                            .starrating > label{color: #4a5568;}
                            .starrating > input:checked ~ label{ color: #ffca08 ; }
                            .starrating > input:hover ~ label{ color: #ffca08 ;  }
                        </style>
                        <div class="card pb-0 mt-5">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <button class="rating_circle">
                                            @php($avg_rating = DB::table('rating_stars')->where('product_id', $get_products->id)->avg('rating_star'))
                                            {{ round($avg_rating, 1) }} / <span class="text-warning">5 <i class="fa fa-star" style="color:#ffca08;"></i></span>
                                        </button>
                                    </div>
                                    <div class="col-10 col-md-6">
                                        <div class="progress mt-2" style="height:15px;">
                                            <div class="progress-bar bg-success" style="width:100%;height:15px;">5 Sao</div>
                                        </div>
                                        <div class="progress mt-3" style="height:15px;">
                                            <div class="progress-bar bg-info" style="width:80%;height:15px;">4 Sao</div>
                                        </div>
                                        <div class="progress mt-3" style="height:15px;">
                                            <div class="progress-bar bg-primary" style="width:60%;height:15px;">3 Sao</div>
                                        </div>
                                        <div class="progress mt-3" style="height:15px;">
                                            <div class="progress-bar bg-warning" style="width:40%;height:15px;">2 Sao</div>
                                        </div>
                                        <div class="progress mt-3" style="height:15px;">
                                            <div class="progress-bar bg-danger" style="width:20%;height:15px;">1 Sao</div>
                                        </div>
                                    </div>
                                    <div class="col-2 col-md-2 mt-0">
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_5 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star', '=',5]])->count())
                                                {{ $count_5 }}
                                            </b>
                                        </div>
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_4 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star', '=',4]])->count())
                                                {{ $count_4 }}
                                            </b>
                                        </div>
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_3 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star', '=',3]])->count())
                                                {{ $count_3 }}
                                            </b>
                                        </div>
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_2 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star','=',2]])->count())
                                                {{ $count_2 }}
                                            </b>
                                        </div>
                                        <div class="row">
                                            <b class="rating_text">
                                                @php($count_1 = DB::table('rating_stars')->where([['product_id','=',$get_products->id],['rating_star','=',1]])->count())
                                                {{ $count_1 }}
                                            </b>
                                        </div>
                                    </div>
                                </div>
                                    <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                        <input type="radio" id="star5" name="rating" value="5"/><label for="star5" title="5 star" onclick="MessageFunction()"></label>
                                        <input type="radio" id="star4" name="rating" value="4"/><label for="star4" title="4 star" onclick="MessageFunction()"></label>
                                        <input type="radio" id="star3" name="rating" value="3"/><label for="star3" title="3 star" onclick="MessageFunction()"></label>
                                        <input type="radio" id="star2" name="rating" value="2"/><label for="star2" title="2 star" onclick="MessageFunction()"></label>
                                        <input type="radio" id="star1" name="rating" value="1"/><label for="star1" title="1 star" onclick="MessageFunction()"></label>
                                    </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <br>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0" nonce="6yHBLg1B"></script>
                    <div id="fb-root">
                        <div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width="550" data-numposts="1"></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @if(session()->has('message_success'))
        <script>
            swal({
                title: "{{session()->get('message_success')}}",
                text: "",
                type: "success",
                timer: 1500,
                showConfirmButton: false,
                position: 'center',
            });
        </script>
    @endif

    @if(session()->has('message_error'))
        <script>
            swal({
                title: "{{session()->get('message_error')}}",
                text: "",
                type: "error",
                timer: 1500,
                showConfirmButton: false,
                position: 'center',
            });
        </script>
    @endif
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });

        function MessageFunction() {
            swal({

                title: "Đăng nhập để đánh giá sao",
                text: "",
                type: "error",
                timer: 1500,
                showConfirmButton: false,
                position: 'center',
            });
            setTimeout(function() {
                location.href = "{{ url('/page-signin') }}";
            }, 2000);
        }
        function SubmitFormFunction() {
            document.getElementById("FormSubmit").submit();
        }
    </script>
     <script>
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
          alert(msg);
        }
      </script>

@endsection
