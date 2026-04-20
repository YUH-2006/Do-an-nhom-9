@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Quản lý Khách hàng</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Ngày đăng ký</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @php($userId = $user->id ?? $user->getKey())
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?: 'Chưa cập nhật' }}</td>
                        <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Chưa có' }}</td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                @if($userId)
                                    <a href="{{ route('admin.users.edit', ['id' => $userId]) }}" class="btn btn-sm btn-outline-warning">Sửa</a>
                                    <form action="{{ route('admin.users.destroy', ['id' => $userId]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                    </form>
                                @else
                                    <span class="badge text-bg-secondary">Thiếu ID</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($users->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Chưa có khách hàng nào đăng ký</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
