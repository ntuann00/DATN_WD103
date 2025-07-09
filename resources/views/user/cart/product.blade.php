<form action="{{ route('cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="sku" value="{{ $product->sku }}">
    
    <label>Màu sắc:</label>
    <input type="text" name="color" value="Đỏ" class="form-control">

    <label>Dung lượng:</label>
    <input type="text" name="capacity" value="64GB" class="form-control">

    <label>Mùi:</label>
    <input type="text" name="scent" value="Hoa hồng" class="form-control">

    <label>Kết cấu:</label>
    <input type="text" name="texture" value="Lỏng" class="form-control">

    <label>Số lượng:</label>
    <input type="number" name="quantity" value="1" class="form-control">

    <button type="submit" class="btn btn-primary">Thêm vào giỏ</button>
</form>
