@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Quản lý Sản phẩm</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">+ Thêm sản phẩm</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm p-4 mb-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên hoặc danh mục..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Tìm kiếm</button>
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:80px;">ID</th>
                        <th style="width:110px;">Ảnh</th>
                        <th>Thông tin sản phẩm</th>
                        <th style="width:160px;">Danh mục</th>
                        <th style="width:140px;">Giá</th>
                        <th style="width:140px;" class="text-end">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($products as $p)
                    @php($productId = $p->id ?? $p->getKey())
                    <tr>
                        <td class="text-muted">#{{ $p->id }}</td>
                        <td>
                            @if(!empty($p->image))
                                <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" class="rounded" style="width:80px; height:60px; object-fit:cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:80px; height:60px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-image text-muted" viewBox="0 0 16 16">
                                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $p->name }}</div>
                            @if(!empty($p->description))
                                <div class="small text-muted text-truncate" style="max-width: 400px;">
                                    {{ $p->description }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $p->category ?? 'N/A' }}</span>
                        </td>
                        <td class="fw-bold text-primary">{{ number_format($p->price) }}đ</td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                @if($productId)
                                    <a href="{{ route('admin.products.edit', ['id' => $productId]) }}" class="btn btn-sm btn-outline-warning">Sửa</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', ['id' => $productId]) }}"
                                          onsubmit="return confirm('Xóa sản phẩm này?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                    </form>
                                @else
                                    <span class="badge text-bg-secondary">Thiếu ID</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Không tìm thấy sản phẩm nào.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $products->appends(request()->input())->links() }}
        </div>
    </div>

</div>
@endsection

