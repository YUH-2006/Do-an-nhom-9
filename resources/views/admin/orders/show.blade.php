@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
        </a>
        <h2 class="fw-bold mb-0">Chi tiết đơn hàng #{{ $order->id }}</h2>
    </div>

    <div class="row g-4">
        <!-- Thông tin đơn hàng -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-4">Danh sách sản phẩm</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->image)
                                        <img src="{{ asset($item->product->image) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $item->product_name }}</div>
                                            <div class="small text-muted">ID: #{{ $item->product_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-end text-muted">{{ number_format($item->price) }}đ</td>
                                <td class="text-end fw-bold text-primary">{{ number_format($item->subtotal) }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="text-end fw-bold h4 text-primary">{{ number_format($order->total) }}đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4">Ghi chú khách hàng</h5>
                <p class="text-muted mb-0">{{ $order->note ?: 'Không có ghi chú' }}</p>
            </div>
        </div>

        <!-- Sidebar thông tin -->
        <div class="col-md-4">
            <!-- Cập nhật trạng thái -->
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-4">Trạng thái đơn hàng</h5>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cập nhật trạng thái</button>
                </form>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-4">Thông tin giao hàng</h5>
                <div class="mb-3">
                    <div class="text-muted small">Người nhận</div>
                    <div class="fw-bold">{{ $order->shipping_name }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Số điện thoại</div>
                    <div class="fw-bold">{{ $order->shipping_phone }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small">Địa chỉ</div>
                    <div class="fw-bold">{{ $order->shipping_address }}</div>
                </div>
                <div class="mb-0">
                    <div class="text-muted small">Phương thức thanh toán</div>
                    <div class="badge bg-light text-dark px-3 py-2 border fw-normal">{{ $order->payment_method }}</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4">Tài khoản đặt hàng</h5>
                @if($order->user)
                <div class="d-flex align-items-center">
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 5-4 5 3 5 4Z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $order->user->name }}</div>
                        <div class="small text-muted">{{ $order->user->email }}</div>
                    </div>
                </div>
                @else
                <div class="text-muted italic small">Khách vãng lai (Guest)</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
