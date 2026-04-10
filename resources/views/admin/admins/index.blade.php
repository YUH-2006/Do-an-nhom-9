@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Quản lý Admin</h2>
        <a href="/admin/admins/create" class="btn btn-primary">
            + Thêm admin
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Phone</th>
                <th width="180">Hành động</th>
            </tr>
        </thead>

        <tbody>
        @foreach($admins as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->name }}</td>
                <td>{{ $a->email }}</td>
                <td>{{ $a->phone }}</td>
                <td>
                    <a href="/admin/admins/{{ $a->id }}/edit" class="btn btn-sm btn-warning">
                        Sửa
                    </a>
                    <a href="/admin/admins/{{ $a->id }}/delete"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Xóa admin này?')">
                        Xóa
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection
