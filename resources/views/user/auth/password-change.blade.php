                            <div class="dashboard-profile">
                                <div class="table-title-area">
                                    <h3>Đổi Mật Khẩu</h3>
                                    <p>Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác</p>
                                </div>

                                <!-- Alert Messages -->
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        <i class="bi bi-check-circle-fill"></i>
                                        {{ session('success') }}
                                    </div>
                                @elseif (session('error'))
                                    <div class="alert alert-danger">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="password-section">
                                    <div class="password-header">
                                        <div class="password-header-icon">
                                            🔐
                                        </div>
                                        <div class="password-header-text">
                                            <h4>Cập Nhật Mật Khẩu Mới</h4>
                                            <p>Mật khẩu của bạn phải có ít nhất 8 ký tự</p>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('repassword.update') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <!-- Current Password -->
                                                <div class="form-inner">
                                                    <label for="current_password">
                                                        <i class="bi bi-lock"></i> Mật khẩu hiện tại
                                                    </label>
                                                    <div class="password-input-group">
                                                        <input type="password" id="current_password" name="current_password"
                                                            class="form-control" placeholder="Nhập mật khẩu hiện tại"
                                                            required>
                                                        <button type="button" class="password-toggle"
                                                            onclick="togglePassword('current_password')">
                                                            <i class="bi bi-eye" id="current_password_icon"></i>
                                                        </button>
                                                    </div>
                                                    @if ($errors->has('current_password'))
                                                        <div class="text-danger">
                                                            <i class="bi bi-exclamation-circle"></i>
                                                            {{ $errors->first('current_password') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- New Password -->
                                                <div class="form-inner">
                                                    <label for="new_password">
                                                        <i class="bi bi-shield-lock"></i> Mật khẩu mới
                                                    </label>
                                                    <div class="password-input-group">
                                                        <input type="password" id="new_password" name="new_password"
                                                            class="form-control" placeholder="Nhập mật khẩu mới"
                                                            onkeyup="checkPasswordStrength(this.value)" required>
                                                        <button type="button" class="password-toggle"
                                                            onclick="togglePassword('new_password')">
                                                            <i class="bi bi-eye" id="new_password_icon"></i>
                                                        </button>
                                                    </div>
                                                    <div class="password-strength">
                                                        <div class="password-strength-bar" id="strength-bar"></div>
                                                    </div>
                                                    @if ($errors->has('new_password'))
                                                        <div class="text-danger">
                                                            <i class="bi bi-exclamation-circle"></i>
                                                            {{ $errors->first('new_password') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Confirm Password -->
                                                <div class="form-inner">
                                                    <label for="new_password_confirmation">
                                                        <i class="bi bi-shield-check"></i> Xác nhận mật khẩu mới
                                                    </label>
                                                    <div class="password-input-group">
                                                        <input type="password" id="new_password_confirmation"
                                                            name="new_password_confirmation" class="form-control"
                                                            placeholder="Nhập lại mật khẩu mới" required>
                                                        <button type="button" class="password-toggle"
                                                            onclick="togglePassword('new_password_confirmation')">
                                                            <i class="bi bi-eye" id="new_password_confirmation_icon"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="mt-4">
                                                    <button type="submit" class="primary-btn3">
                                                        <i class="bi bi-check-lg"></i> Cập Nhật Mật Khẩu
                                                    </button>
                                                    <button type="reset" class="btn-secondary">
                                                        <i class="bi bi-arrow-clockwise"></i> Đặt Lại
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="password-requirements">
                                                    <h5>Yêu cầu mật khẩu</h5>
                                                    <div class="requirement-item" id="length-req">
                                                        <i class="bi bi-circle"></i>
                                                        <span>Ít nhất 8 ký tự</span>
                                                    </div>
                                                    <div class="requirement-item" id="uppercase-req">
                                                        <i class="bi bi-circle"></i>
                                                        <span>Một chữ cái viết hoa</span>
                                                    </div>
                                                    <div class="requirement-item" id="lowercase-req">
                                                        <i class="bi bi-circle"></i>
                                                        <span>Một chữ cái viết thường</span>
                                                    </div>
                                                    <div class="requirement-item" id="number-req">
                                                        <i class="bi bi-circle"></i>
                                                        <span>Một chữ số</span>
                                                    </div>
                                                    <div class="requirement-item" id="special-req">
                                                        <i class="bi bi-circle"></i>
                                                        <span>Một ký tự đặc biệt</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>