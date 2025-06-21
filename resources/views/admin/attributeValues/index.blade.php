@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách giá trị thuộc tính</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('attributeValues.create')}}" class="btn btn-primary mb-3"> Thêm giá trị</a>
    <a href="{{ route('attributes.index')}}" class="btn btn-primary mb-3">Danh sách thuộc tính</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên biến thể</th>
                <th>Giá biến thể</th>
                <td>Hoạt động</td>
            </tr>
        </thead>
        <tbody>
           @foreach ($attributeValues as $attributeValue )

           <tr>
            <td>{{ $attributeValue->id }}</td>
            <td>{{ $attributeValue->attribute->name }}</td>
            <td>{{ $attributeValue->value }}</td>
            <td>
                 <a href="{{ route('attributeValues.edit', $attributeValue->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                  <a href="{{ route('attributeValues.show', $attributeValue->id) }}" class="btn btn-sm btn-warning">Chi tiết</a>

                        <form action="{{ route('attributeValues.destroy', $attributeValue->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
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
         {{ $attributeValues->links() }}
    </div>
</div>

@endsection
