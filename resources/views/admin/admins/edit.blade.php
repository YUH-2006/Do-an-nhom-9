@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex align-items-center">
        <a href="/admin/admins" class="btn btn-sm btn-light me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
        </a>
        <h2 class="fw-bold mb-0">Chỉnh sửa Admin: {{ $admin->name }}</h2>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <form action="/admin/admins/{{ $admin->id }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Họ và tên</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email đăng nhập</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Mật khẩu mới (Để trống nếu không thay đổi)</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2">Cập nhật Admin</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
