@extends('customer.trangthai.layout_profile')
@section('content-profile-col-9')
<div class="table-responsive-sm">
    
    @forelse($show_orders as $key => $data)
    @if ($data->trangthai_hd == 0 || $data->trangthai_hd == 1)
        <div class="panel panel-default">
            <div class="panel-heading"><b>Đơn hàng {{ '000'.$data->id }}</b></div>
            <div class="panel-body" style="padding:1px 1px;">
                <table class="table table-striped" border="1" cellspacing="0">
                    <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Tên SP</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Tổng tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($get_details = DB::table('chitiet_hds')->where('ma_hd',$data->id)->get())

                    <?php $total_payment = 0; ?>
                    @foreach($get_details as $get_detail)
                        @php($get_product = DB::table('sanphams')->where('id', $get_detail->ma_sp)->first())
                            <tr>
                                <td data-label="STT">{{ ++$key }}</td>
                                <td data-label="Hình ảnh">
                                    <a href="#">
                                        @foreach((array)json_decode($get_product->hinh_sp, true) as $image)
                                            <img class="img-circle elevation-2" width="50px" height="40px" src="{{asset('public/upload_img/'.$image)}}" width="50" height="50">
                                            @break
                                        @endforeach
                                    </a>
                                </td>
                                <td data-label="Tên SP">
                                    {{ $get_product->tensp }}
                                </td>
                                <td data-label="Giá">
                                {{ number_format($get_product->gia_sp )}} VND
                                </td>
                                <td data-label="Số lượng">
                                {{ $get_detail->soluong_sp }}
                                </td>
                                <td data-label="Tổng tiền">
                                    <?php
                                        $price = $get_product->gia_sp;
                                        $qty = $get_detail->soluong_sp;
                                        $total = $price* $qty;
                                        $total_payment = $total_payment + $total;
                                    ?>
                                    {{ number_format($total) }} VND
                                </td>
                            </tr>
                    @endforeach
                    <tr>
                        <td colspan="5">
                            Tổng thanh toán:
                        </td>
                        <td colspan="2">
                            {{ number_format($total_payment) }} VND
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer text-right">
                <a class="btn btn-danger" href="{{ url('cancel-order/'.$data->id) }}" role="button" onclick="return confirm('Bạn có muốn hủy đơn hàng không ?');">
                    <i class="fa fa-close"></i> Hủy đơn hàng
                </a>
                <a class="btn btn-success" href="{{ url('detail-order/'.$data->id) }}" role="button" >
                    <i class="fa fa-eye"></i> Xem chi tiết
                </a>
            </div><br>
        </div>
    @endif
    @empty
        <div class="alert alert-danger text-center" role="alert">
            <strong style="font-size: 25px;"> Không có đơn hàng</strong>
        </div>
    @endforelse
    {{-- <ul class="pagination justify-content-xl-end" style="margin:20px 0;">
        {{ $show_orders->links() }}
    </ul> --}}
</div>
    @if(session()->has('message'))
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Xóa đơn hàng thành công!',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
    @endif
@endsection
