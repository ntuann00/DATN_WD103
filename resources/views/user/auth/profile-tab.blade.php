                            <div class="dashboard-profile">
                                <div class="table-title-area">
                                    <h3>Thông Tin Cá Nhân</h3>
                                    @if (Auth::check())
                                        <p>Xin chào, {{ Auth::user()->name }}! Chào mừng bạn quay trở lại.</p>
                                    @endif
                                </div>

                                <div class="form-wrapper">
                                    <form method="POST" action="{{ route('profile.update') }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-inner">
                                                            <label>Tên Tài Khoản</label>
                                                            <input type="text" value="{{ $user->name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-inner">
                                                            <label>Email</label>
                                                            <input type="text" value="{{ $user->email }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-inner">
                                                            <label>Số Điện Thoại</label>
                                                            <input type="text" value="{{ $user->phone }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-inner">
                                                            <label>Giới Tính</label>
                                                            <input type="text"
                                                                value="{{ $user->gender == 1 ? 'Nam' : 'Nữ' }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-inner">
                                                            <label>Ngày Tham Gia</label>
                                                            <input type="text"
                                                                value="{{ $user->created_at->format('d/m/Y') }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="avatar-section">
                                                    <p>Ảnh Đại Diện</p>
                                                    <img src="{{ asset('storage/' . $user->img) }}" alt="Avatar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-4">
                                            <a href="{{ route('profile.edit', $user->id) }}" class="primary-btn3">
                                                Cập Nhật Thông Tin
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>