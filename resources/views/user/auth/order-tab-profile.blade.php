                            <div class="dashboard-profile">
                                <div class="table-title-area">
                                    <h3>Đơn Hàng Của Bạn</h3>
                                    <p>Quản lý và theo dõi tất cả đơn hàng của bạn tại đây</p>
                                </div>

                                <div class="table-wrapper">
                                    <table class="eg-table">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn</th>
                                                <th>Hình ảnh</th>
                                                <th>Tổng tiền</th>
                                                <th>Thanh toán</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                                    </td>
                                                    <td>
                                                        <img src="{{ $order->orderDetails->first()->productVariant->images->first()->image_url ?? 'default.jpg' }}"
                                                            alt="product" class="product-img">
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="total-price">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                                                    </td>
                                                    <td>
                                                        <span class="status-badge status-processing">
                                                            {{ $order->payment->name ?? 'Thanh toán khi nhận hàng' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-success">{{ $order->status_payment == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('ordersDetail.show', $order->id) }}"
                                                            class="badge bg-dark p-2">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="empty-state">
                                                        <div class="empty-state-icon">🛒</div>
                                                        <div class="empty-state-text">Bạn chưa có đơn hàng nào</div>
                                                        <div class="empty-state-subtext">Hãy khám phá và mua sắm ngay!
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
