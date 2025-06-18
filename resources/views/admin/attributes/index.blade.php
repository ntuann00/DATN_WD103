@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách biến thể</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('attributes.create')}}" class="btn btn-primary mb-3">+ Thêm biến thể</a>
     <a href="{{ route('attributeValues.create')}}" class="btn btn-primary mb-3"> Thêm biến thể con</a>
     <a href="{{ route('attributeValues.index')}}" class="btn btn-primary mb-3"> Danh sách</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <td>Hoạt động</td>
            </tr>
        </thead>
        <tbody>
           @foreach ($attributes as $attribute )

           <tr>
            <td>{{ $attribute->id }}</td>
            <td>{{ $attribute->name }}</td>
            <td>
                 <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                        <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
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
         {{ $attributes->links() }}
    </div>
</div>

@endsection
