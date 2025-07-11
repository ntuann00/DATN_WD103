@extends('user.layouts.app')

@section('content')
<div class="checkout-section pt-110 mb-110">
  <div class="container">
    <div class="row gy-5">
      <div class="col-lg-7">
        {{-- form như trước --}}
      </div>
      <div class="col-lg-5">
        {{-- -> truyền vào $cart và $total --}}
        @include('user.checkout._summary', ['cart'=>$cart, 'total'=>$total])
      </div>
    </div>
  </div>
</div>
@endsection
