@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Danh sách thuộc tính</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Số lượng giá trị thuộc tính</th>
                    <th>Hoạt động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attributes as $attribute)
                    <tr>
                        <td>{{ $attribute->id }}</td>
                        <td>
                            <a href="{{ route('admin.attributes.show', $attribute->id) }}" style="color: black;">
                                {{ $attribute->name }}
                            </a>
                        </td>
                        <td>{{ $attribute->values_count }}</td>
                        <td>
                            <a href="{{ route('admin.attributes.edit', $attribute->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        </td>
                    </tr>

                    <!-- Dòng ẩn chứa danh sách biến thể con -->
                    <tr id="children-{{ $attribute->id }}" style="display: none;">
                        <td colspan="4">
                            @if ($attribute->values->count())
                                <ul>
                                    @foreach ($attribute->values as $val)
                                        <li>{{ $val->value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>Không có biến thể con.</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $attributes->links() }}
    </div>

    <script>
        function toggleValues(id) {
            const row = document.getElementById('values-' + id);
            row.style.display = (row.style.display === 'none') ? '' : 'none';
        }
    </script>
@endsection
