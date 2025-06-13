@extends('admin.layouts.app')

@section('content')
<div class="container">
   <h2>Sửa Attribute Value</h2>

<form method="POST" action="{{ route('attributeValues.update', $attributeValue->id) }}">
    @csrf
    @method('PUT')

     <div class="mb-3">
            <label for="attribute_id">Vai trò:</label>
            <select name="attribute_id" class="form-control">
                <option value="">-- Chọn vai trò --</option>
                @foreach ($attributes as $attribute)
                    <option value="{{ $attribute->id }}" {{ old('attribute_id', $attributeValue->attribute_id) == $attribute->id ? 'selected' : '' }}>
                        {{ $attribute->name }}
                    </option>
                @endforeach
            </select>
        </div>

    <div class="mb-3">
                <label for="value" class="form-label">Tên biến thể con </label>
                <input type="text" class="form-control" id="value" name="value" value="{{$attributeValue->value}}"
                    required>
            </div>

    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>
</div>
@endsection
