<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Models\hoadon;
use App\Models\HoadonChitiet;
use App\Models\loaisanpham;
use App\Models\RatingStar;
use App\Models\sanpham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Session;

class HomeController extends Controller
{
    //Trang chủ
    public function page_home(){
        $get_product = DB::table('sanphams')->take(4)->latest()->get();
        $get_pk_product = DB::table('phankhucs')->get();
        return view('customer.index')->with([
            'get_product'=>$get_product,
            'get_pk_product'=>$get_pk_product
        ]);
    }

    //Trang cửa hàng
    public function page_shop($id_pk,$id_loaidulieu){

        //neu =9999 thi lay 8 san pham moi them san pham
        if ($id_pk == 9999){
            $get_products = DB::table('sanphams')->take(8)->latest()->get();
            Session()->forget('id_pk');
            Session()->forget('id_pk_loaisp');
            Session()->put('id_pk_new',"Tất cả sản phẩm");
            return view('customer.page_product',['get_products'=> $get_products])->with('id_pk_new');
        }else {
            //nguoc lai  kiem tra
            //neu id_loaidulieu =1 thi lay tat ca phan khuc thuoc loai san pham id_pk
            if ($id_loaidulieu == 1){
                $get_pk_product = DB::table('phankhucs')->where('maloai', $id_pk)->get();
                $tenloai = DB::table('loaisanphams')->where('id', $id_pk)->get();
                Session()->forget('id_pk_new');
                Session()->forget('id_pk');
                Session()->put('id_pk_loaisp', "Tất cả sản phẩm");
                return view('customer.page_product')->with([
                    'get_pk_product' => $get_pk_product,
                    'tenloai' => $tenloai,
                    'id_pk_loaisp'
                ]);
                //nguoc lai
            }else{
                //lay tat ca san pham bat ke phan khuc nao
                if ($id_pk == 0) {
                    $get_products = DB::table('sanphams')->get();
                    Session()->forget('id_pk_new');
                    Session()->forget('id_pk_loaisp');
                    Session()->put('id_pk', "Tất cả sản phẩm");
                    return view('customer.page_product')->with([
                        'get_products'=>$get_products,
                        'id_pk'
                    ]);
                }else {
                    //lay san pham theo phan khuc cho truoc dua vao id_pk
                    Session()->forget('id_pk_new');
                    Session()->forget('id_pk_loaisp');
                    Session()->forget('id_pk');
                    $get_products = DB::table('sanphams')->where('ma_phankhuc', $id_pk)->get();
                    $get_phankhuc = DB::table('phankhucs')->where('id', $id_pk)->get();
                    return view('customer.page_product')->with([
                        'get_products'=>$get_products,
                        'get_phankhuc'=>$get_phankhuc
                    ]);
                }
            }
        }

    }

    //Trang chi tiết cửa hàng
    public function page_detail_shop ($id){
        $get_product = DB::table('sanphams')->where('id', $id)->get();
        $get_pk_product = DB::table('phankhucs')->get();
        return view('customer.page_detail_product')->with([
            'get_product'=>$get_product,
            'get_pk_product'=>$get_pk_product
        ]);
    }
    //trang thuong hieu
    public function thuonghieu($id){
        $ncc = DB::table('ncc_sanphams')->where('ma_ncc','=',$id)->get();
        return view('customer.thuonghieu')->with([
            'ncc'=>$ncc,
            'id_ncc'=>$id
        ]);
    }

    //tim kiem san pham
    public function searchProduct(Request $request){
        $keyWord = $request->input('search_product');
        $product = DB::table('sanphams')->where('tensp', 'LIKE', '%'.$keyWord.'%')->paginate(8);
        $count = DB::table('sanphams')->where('tensp', 'LIKE', '%'.$keyWord.'%')->count();
        return view('customer.search_product')->with([
            'product' => $product,
            'count' => $count,
            'keyWord'=>$keyWord
        ]);
    }

    //trang danh gia sao
    public function postRatingStar($userId, $productId, Request $request){
        $get_count_rating = DB::table('rating_stars')->where([['user_id', '=', $userId], ['product_id', '=', $productId]])->count();
        if ($get_count_rating >= 1){
            Session::put('message_error');
            return redirect()->back()->with('message_error', 'Bạn đã đánh giá rồi!');
        }else{
            $add_rating = new RatingStar();
            $add_rating->rating_star = $request->input('rating');
            $add_rating->user_id = $userId;
            $add_rating->product_id = $productId;
            $add_rating->save();
            Session::put('message_success');
            return redirect()->back()->with('message_success', 'Đã đánh giá SAO');
        }
    }
    //Trang liên lạc
    public function page_contact (){
        return view('customer.page_contact');
    }

    //Trang blog
    public function page_blog (){
        return view('customer.page_blog');
    }
    public function page_single_blog (){
        return view('customer.page_single_blog');
    }
    public function page_reguler (){
        return view('customer.page_regular');
    }

    //Thanh toán
    public function page_checkout ($id_user,$total){
        //Thêm vào hóa đơn mới
        $add_order = new hoadon();
        $add_order->ma_user = $id_user;
        $add_order->trangthai_hd = 0;
        $add_order->hinhthucthanhtoan = 0;
        $add_order->tongtien_hd = $total;
        $add_order->save();

        //Xử lí trang chi tiết hóa đơn
        //Lấy hóa đơn  mới nhất
        $get_order_new = DB::table('hoadons')->max('id');
        //Lấy giỏ hàng
        $get_carts = DB::table('giohangs')->where('ma_user',$id_user)->get();
        foreach($get_carts as $get_cart){
            //Lấy giá của sản phẩm
            $get_product = DB::table('sanphams')->where('id',$get_cart->ma_sp)->first();
            $add_detail = new HoadonChitiet();
            $add_detail->ma_hd = $get_order_new;
            $add_detail->ma_sp = $get_cart->ma_sp;
            $add_detail->soluong_sp = $get_cart->soluong_sp;
            $add_detail->giatien = $get_cart->thanhtien;
            $add_detail->save();
            //Trừ số lượng
            $soluong = ($get_product->soluong_sp - $get_cart->soluong_sp);
            DB::table('sanphams')->where('id',$get_cart->ma_sp)->update(['soluong_sp' => $soluong]);
        }
        DB::table('giohangs')->where('ma_user',$id_user)->delete();
        return redirect()->back()->with('success1','Thanh toán thành công');
    }

    //Hàm thêm vào giỏ hàng
    public function add_cart($id_user, $id_product){
        $check_cart = DB::table('giohangs')->where([['ma_user',$id_user],['ma_sp',$id_product]])->first();
        if(isset($check_cart)){
            $get_id = $check_cart->id;
            $update_cart = GioHang::find($get_id);
            $update_cart->soluong_sp = $update_cart->soluong_sp + 1;
            //Lấy số lượng hiện tại
            $get_qty = $update_cart->soluong_sp;
            //Lấy giá sản phẩm
            $get_price = DB::table('sanphams')->where('id',$id_product)->first();
            $update_cart->thanhtien = $get_qty * $get_price->gia_sp ;
            $update_cart->save();
        } else{
            $add_cart = new GioHang();
            $add_cart->ma_user = $id_user;
            $add_cart->ma_sp = $id_product;
            $add_cart->soluong_sp = 1;
            //Lấy giá san phẩm
            $get_price = DB::table('sanphams')->where('id',$id_product)->first();
            $add_cart->thanhtien = $get_price->gia_sp;
            $add_cart->save();
        }

        return redirect()->back()->with('success','Thêm thành công');
    }

    public function add_cart_detail(Request $request,$id_user,$id_product){
        $check_cart = DB::table('giohangs')->where([['ma_user',$id_user],['ma_sp',$id_product]])->first();
        if(isset($check_cart)){
            $get_id = $check_cart->id;
            $update_cart = GioHang::find($get_id);
            $get_qty = $request->input('inputQty');
            $update_cart->soluong_sp = $update_cart->soluong_sp + $get_qty;
            //Lấy số lượng hiện tại
            $get_qty = $update_cart->soluong_sp;
            //Lấy giá sản phẩm
            $get_price = DB::table('sanphams')->where('id',$id_product)->first();
            $update_cart->thanhtien = $get_qty * $get_price->gia_sp ;
            $update_cart->save();
        } else{
            $add_cart = new GioHang();
            $add_cart->ma_user = $id_user;
            $add_cart->ma_sp = $id_product;
            $add_cart->soluong_sp = $request->input('inputQty');
            //Lấy số lượng hiện tại
            $get_qty = $add_cart->soluong_sp;
            //Lấy giá sản phẩm
            $get_price = DB::table('sanphams')->where('id',$id_product)->first();
            $add_cart->thanhtien = $get_qty * $get_price->gia_sp ;
            $add_cart->save();
        }
        return redirect()->back()->with('success','Thêm thành công');
    }

    //Hàm xóa giỏ hàng ajax
    public function delete_cart($id_cart){
        GioHang::where('id',$id_cart)->delete();
        $get_user = Auth::id();
        //tính lại tổng giá
        $total = 0;
        $get_carts = DB::table('giohangs')->where('ma_user',$get_user)->get();
        foreach($get_carts as $get_cart){
            $total = $total + $get_cart->thanhtien;
        }
        return response()->json($total);
    }

    //Hàm cập nhật số lượng giỏ hàng ajax
    //Cập nhật số lượng table-cart
    public function update_cart($key, $qty){
        $add_cart = GioHang::where('id',$key)->first();
        $add_cart->soluong_sp = $qty;
        $get_pro = sanpham::where('id',$add_cart->ma_sp)->first();
        $add_cart->thanhtien = $get_pro->gia_sp * $qty;
        $add_cart->save();

        //Tính tổng giá
        $total = 0;
        $get_id = Auth::id();
        $get_carts = GioHang::where('ma_user',$get_id)->get();
        foreach($get_carts as $get_cart){
            $total = $total + $get_cart->thanhtien;
        }
        return response()->json($total);
    }
}
