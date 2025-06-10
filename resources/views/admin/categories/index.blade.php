@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách danh mục</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('categories.create')}}" class="btn btn-primary mb-3">+ Thêm danh mục</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Trạng thái</th>
                <td>Hoạt động</td>
            </tr>
        </thead>
        <tbody>
           @foreach ($categories as $category )

           <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td>{{ $category->status }}</td>
            <td>
                 <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
            </td>
           </tr>
               
           @endforeach
        </tbody>
    </table>
    <div>
         {{ $categories->links() }}
    </div>
</div>

@endsection
