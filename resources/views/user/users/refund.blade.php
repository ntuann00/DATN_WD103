@extends('user.layouts.app')

@section('content')
<div class="dashboard-section mt-110 mb-110">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab">
                            <div class="dashboard-profile">

                                <div class="table-title-area">
                                    <h3>Hoàn hàng</h3>
                                </div>

                                <div class="form-wrapper">
                                    <!-- action -->
                                    <form method="POST" action="{{ route('save_refund',$Order->id) }}" onsubmit="return confirmSubmit()" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row align-items">
                                            <!-- data -->
                                            <div class="col-12">
                                                <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                                    <div class="form-inner">
                                                        <label for="">Lý do hoàn hàng:</label>
                                                        <input type="text" name="reason">
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                                    <div class="form-inner">
                                                        <label for="">Ghi chú:</label>
                                                        <input type="text" name="description">
                                                    </div>
                                                </div>
                                            
                                                <label class="form-label">Phương thức hoàn tiền:</label><br>
                                                <!-- Nhóm nút -->
                                                <div class="btn-group" role="group">
                                                    <!-- Nút nhận off -->
                                                    <input type="radio" class="btn-check" name="toggleForm" id="no" autocomplete="off" checked>
                                                    <label class="btn btn-outline-secondary" for="no">Nhận tại cửa hàng</label>

                                                    <!-- Nút tknh -->
                                                    <input type="radio" class="btn-check" name="toggleForm" id="yes" autocomplete="off">
                                                    <label class="btn btn-outline-secondary" for="yes">Tài khoản ngân hàng</label>
                                                    <i class="md-6">Nếu bạn chọn hoàn tiền bằng Tài khoản ngân hàng mà không điền thông tin.
                                                        Hệ thống sẽ mặc định bạn chọn nhận tại cửa hàng.
                                                    </i>
                                                </div>
                                            </div>
                                            <!-- data -->
                                            <div class="collapse mt-3" id="extraForm">
                                                <div class="border rounded p-3">
                                                    <div class="mb-6">
                                                        <label class="form-label">Ngân hàng</label>
                                                        <input type="text" name="bank" class="form-control">
                                                    </div>
                                                    <div class="mb-6">
                                                        <label class="form-label">Số Tài Khoản</label>
                                                        <input type="text" name="stk" class="form-control">
                                                    </div>
                                                    <div class="mb-6">
                                                        <label class="form-label">Họ và tên chủ thẻ</label>
                                                        <input type="text" name="holder_name" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- refund info -->

                                            <!-- image -->
                                            <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                                <div class="form-inner">
                                                    <label for="">Ảnh sản phẩm:</label>
                                                    <input class="" type="file" name="img">
                                                </div>
                                            </div>
                                            <!-- image -->
                                        </div>

                                        <div class="col-12">
                                            <div class="button-group">
                                                <!-- <a href="#" class="primary-btn3 black-bg  hover-btn5 hover-white">
                                                    Gửi yêu cầu
                                                </a> -->
                                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                                    Gửi yêu cầu
                                                </button> -->
                                                <button class="primary-btn3 black-bg hover-btn5 hover-white" type="submit"> Gửi yêu cầu</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- orderinfo -->
                <div class="col-lg-5">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab">
                            <div class="dashboard-profile">
                                <div class="table-title-area">
                                    <h3>Thông tin đơn hàng</h3>
                                </div>
                                <div class="form-wrapper">
                                    <!-- action -->
                                    <form method="POST" action="#" enctype="multipart/form-data">
                                        <div class="row align-items">
                                            <!-- data -->
                                            

                                            <!-- data -->
                                            <div class="row align-items">
                                            <div class="col-12">
                                                <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                                    <div class="form-inner">
                                                        <label for="">Tên sản phẩm:</label>
                                                        <input type="text" value="{{$Product->name }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                                    <div class="form-inner">
                                                        <label for="">Đơn giá:</label>
                                                        <input type="text" name="name" value="{{$Detail->price }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                                    <div class="form-inner">
                                                        <label for="">Số lượng:</label>
                                                        <input type="text" name="name" value="{{$Detail->quantity }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                                    <div class="form-inner">
                                                        <label for="">Tổng:</label>
                                                        <input type="text" name="name" value="{{$Order->total }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                                    <div class="form-inner">
                                                        <label for="">Trạng thái:</label>
                                                        <input type="text" name="name" value="{{$Order->status_id }}"
                                                            readonly>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- order_info -->

            </div>
        </div>
    </div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Xác nhận gửi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn gửi yêu cầu hoàn tiền không?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-success" id="confirmSubmit">Xác nhận</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
    // Khi chọn "bank" => luôn mở form
    document.getElementById('yes').addEventListener('change', function () {
        let collapseDiv = document.getElementById('extraForm');
        let bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseDiv);
        bsCollapse.show();
    });

    // Khi chọn "cửa hàng" => luôn đóng form
    document.getElementById('no').addEventListener('change', function () {
        let collapseDiv = document.getElementById('extraForm');
        let bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseDiv);
        bsCollapse.hide();
    });

    function confirmSubmit() {
        return confirm(`Bạn có chắc chắn muốn gửi yêu cầu hoàn tiền không? Hãy kiểm tra lại và đảm bảo bạn đã điền đủ các trường cần nhập.`);
    }

</script>
@endpush