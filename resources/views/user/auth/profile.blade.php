@extends('user.layouts.app')

@section('content')
    <style>
        :root {
            --primary-beige: #D4A574;
            --light-beige: #F5E6D3;
            --dark-beige: #A67C52;
            --cream: #FFF8F0;
            --brown: #6B4423;
            --text-dark: #2C1810;
            --text-light: #8B7355;
        }

        * {
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .dashboard-section {
            background: linear-gradient(135deg, #FFF8F0 0%, #F5E6D3 100%);
            min-height: 100vh;
            padding: 80px 0;
        }

        /* Sidebar Styling */
        .dashboard-left {
            background: white;
            border-radius: 24px;
            box-shadow: 0 15px 45px rgba(166, 124, 82, 0.08);
            padding: 35px 25px;
            position: sticky;
            top: 30px;
            border: 1px solid rgba(212, 165, 116, 0.15);
        }

        .nav-pills {
            gap: 15px;
            display: flex;
            flex-direction: column;
        }

        .nav-btn-style {
            background: #FAFAFA;
            border: 2px solid transparent;
            color: #6B4423;
            padding: 18px 24px;
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            width: 100%;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .nav-btn-style::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #D4A574 0%, #A67C52 100%);
            transition: left 0.4s ease;
            z-index: -1;
        }

        .nav-btn-style:hover::before {
            left: 0;
        }

        .nav-btn-style:hover {
            color: white;
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(212, 165, 116, 0.25);
            border-color: transparent;
        }

        .nav-btn-style.active {
            background: linear-gradient(135deg, #D4A574 0%, #A67C52 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(212, 165, 116, 0.25);
        }

        .nav-btn-style svg {
            fill: currentColor;
            transition: transform 0.3s ease;
            min-width: 20px;
        }

        .nav-btn-style:hover svg {
            transform: scale(1.15) rotate(5deg);
        }

        /* Main Content Area */
        .dashboard-profile {
            background: white;
            border-radius: 24px;
            padding: 45px;
            box-shadow: 0 15px 45px rgba(166, 124, 82, 0.08);
            border: 1px solid rgba(212, 165, 116, 0.15);
        }

        .table-title-area {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #F5E6D3;
        }

        .table-title-area h3 {
            color: #2C1810;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
            position: relative;
            display: inline-block;
            letter-spacing: -0.5px;
        }

        .table-title-area h3::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 70px;
            height: 4px;
            background: linear-gradient(90deg, #D4A574 0%, #A67C52 100%);
            border-radius: 2px;
        }

        .table-title-area p {
            color: #8B7355;
            font-size: 17px;
            margin-top: 18px;
            font-weight: 400;
        }

        /* Form Styling */
        .form-inner {
            margin-bottom: 28px;
        }

        .form-inner label {
            color: #6B4423;
            font-weight: 600;
            margin-bottom: 12px;
            display: block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-inner input {
            width: 100%;
            padding: 16px 22px;
            border: 2px solid #F5E6D3;
            border-radius: 12px;
            background: #FAFAFA;
            color: #2C1810;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-inner input:focus {
            border-color: #D4A574;
            background: white;
            box-shadow: 0 0 0 5px rgba(212, 165, 116, 0.12);
            outline: none;
        }

        /* Password Change Section */
        .password-section {
            background: linear-gradient(145deg, #FFFBF7 0%, #FFF8F0 100%);
            border-radius: 20px;
            padding: 40px;
            border: 2px solid rgba(212, 165, 116, 0.15);
            margin-top: 30px;
        }

        .password-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 35px;
            padding-bottom: 20px;
            border-bottom: 1px solid #F5E6D3;
        }

        .password-header-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #D4A574 0%, #A67C52 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .password-header-text h4 {
            color: #2C1810;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .password-header-text p {
            color: #8B7355;
            font-size: 14px;
            margin: 0;
        }

        .password-input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8B7355;
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #D4A574;
        }

        .password-strength {
            margin-top: 10px;
            height: 4px;
            background: #F5E6D3;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            background: #FF6B6B;
            width: 33%;
        }

        .strength-medium {
            background: #FFD93D;
            width: 66%;
        }

        .strength-strong {
            background: #6BCF7F;
            width: 100%;
        }

        .password-requirements {
            background: #FFF8F0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .password-requirements h5 {
            color: #6B4423;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .requirement-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            color: #8B7355;
            font-size: 14px;
        }

        .requirement-item.valid {
            color: #6BCF7F;
        }

        .requirement-item i {
            font-size: 16px;
        }

        /* Avatar Section */
        .avatar-section {
            text-align: center;
            padding: 35px;
            background: linear-gradient(145deg, #FFF8F0 0%, #F5E6D3 100%);
            border-radius: 24px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 2px solid rgba(212, 165, 116, 0.2);
        }

        .avatar-section p {
            color: #6B4423;
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .avatar-section img {
            border: 6px solid white;
            box-shadow: 0 15px 40px rgba(166, 124, 82, 0.15);
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
        }

        /* Button Styling */
        .primary-btn3 {
            background: linear-gradient(135deg, #D4A574 0%, #A67C52 100%);
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(212, 165, 116, 0.25);
            letter-spacing: 0.5px;
            cursor: pointer;
        }

        .primary-btn3:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(212, 165, 116, 0.35);
            color: white;
        }

        .btn-secondary {
            background: transparent;
            color: #6B4423;
            padding: 16px 40px;
            border-radius: 50px;
            border: 2px solid #D4A574;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-left: 15px;
        }

        .btn-secondary:hover {
            background: #D4A574;
            color: white;
            transform: translateY(-2px);
        }

        /* Alert Messages */
        .alert {
            padding: 18px 24px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInDown 0.4s ease;
        }

        .alert-success {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            color: #1B5E20;
            border: 1px solid #81C784;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%);
            color: #B71C1C;
            border: 1px solid #EF5350;
        }

        .text-danger {
            color: #EF5350;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Enhanced Table Styling */
        /* Container wrapper */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            /* Cho phép scroll ngang */
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            /* Smooth scrolling trên mobile */
            margin-bottom: 20px;
        }

        /* Table styles */
        .eg-table {
            width: 100%;
            min-width: 800px;
            /* Đảm bảo table có độ rộng tối thiểu */
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .eg-table thead tr th {
            color: black !important;
        }

        /* Table header */
        .eg-table thead th {
            background-color: #f8f9fa;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            color: #333;
            white-space: nowrap;
            /* Không xuống dòng */
            border-bottom: 2px solid #dee2e6;
        }

        /* Table cells */
        .eg-table tbody td {
            padding: 12px 8px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        /* Product image */
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Product info */
        .product-name {
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-variant {
            font-size: 12px;
            color: #666;
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 500;
            white-space: nowrap;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        /* Buttons */
        .eg-table .btn {
            white-space: nowrap;
            padding: 4px 12px;
            font-size: 13px;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .table-wrapper {
                margin: 0 -15px;
                /* Full width trên mobile */
                padding: 0 15px;
            }

            .eg-table {
                font-size: 13px;
            }

            .eg-table thead th {
                padding: 10px 6px;
                font-size: 13px;
            }

            .eg-table tbody td {
                padding: 10px 6px;
            }

            .product-img {
                width: 50px;
                height: 50px;
            }
        }

        /* Custom scrollbar cho webkit browsers */
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Product Image in Table */
        .product-img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #F5E6D3;
            transition: all 0.3s ease;
        }

        .product-img:hover {
            transform: scale(1.1);
            border-color: #D4A574;
        }

        /* Order ID Styling */
        .order-id {
            background: linear-gradient(135deg, #FFF8F0 0%, #F5E6D3 100%);
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            color: #A67C52;
            font-size: 13px;
            display: inline-block;
        }

        /* Product Name */
        .product-name {
            font-weight: 600;
            color: #2C1810;
            font-size: 15px;
            line-height: 1.5;
        }

        .product-variant {
            font-size: 12px;
            color: #8B7355;
            margin-top: 4px;
        }

        /* Quantity Badge */
        .quantity-badge {
            background: #F5E6D3;
            color: #6B4423;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
        }

        /* Price Styling */
        .price-text {
            color: #A67C52;
            font-weight: 600;
            font-size: 15px;
        }

        .total-price {
            color: #D4A574;
            font-weight: 700;
            font-size: 16px;
        }

        /* Enhanced Status Badge */
        .status-badge {
            padding: 2px 4px;
            border-radius: 25px;
            font-size: 10px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge::before {
            font-size: 18px;
        }

        .status-pending {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
            color: #E65100;
            border: 1px solid #FFB74D;
        }

        .status-processing {
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
            color: #0D47A1;
            border: 1px solid #64B5F6;
        }

        .status-success {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            color: #1B5E20;
            border: 1px solid #81C784;
        }

        .status-delivered {
            background: linear-gradient(135deg, #F3E5F5 0%, #E1BEE7 100%);
            color: #4A148C;
            border: 1px solid #BA68C8;
        }

        /* Action Buttons */
        .btn-action {
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-confirm {
            background: linear-gradient(135deg, #66BB6A 0%, #4CAF50 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
        }

        .btn-confirm:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.3);
        }

        .btn-review {
            background: linear-gradient(135deg, #D4A574 0%, #A67C52 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(212, 165, 116, 0.2);
        }

        .btn-review:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(212, 165, 116, 0.3);
        }

        /* Empty State */
        .empty-state {
            padding: 80px 40px;
            text-align: center;
        }

        .empty-state-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #FFF8F0 0%, #F5E6D3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #D4A574;
        }

        .empty-state-text {
            color: #8B7355;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .empty-state-subtext {
            color: #A99882;
            font-size: 14px;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, #D4A574 0%, #A67C52 100%);
            color: white;
            padding: 24px 32px;
            border: none;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .modal-body {
            padding: 35px 32px;
            background: #FAFAFA;
        }

        .modal-footer {
            border: none;
            padding: 20px 32px 28px;
            background: #FAFAFA;
        }

        .form-label {
            color: #2C1810;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-select,
        .form-control {
            border: 2px solid #F5E6D3;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #D4A574;
            box-shadow: 0 0 0 4px rgba(212, 165, 116, 0.1);
            outline: none;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .eg-table {
                font-size: 13px;
            }

            .eg-table thead th {
                padding: 18px 12px;
                font-size: 12px;
            }

            .eg-table tbody td {
                padding: 18px 12px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-left {
                margin-bottom: 35px;
                position: relative;
            }

            .dashboard-profile {
                padding: 30px 20px;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            .eg-table {
                min-width: 800px;
            }
        }

        /* Animation */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-profile {
            animation: fadeInUp 0.6s ease;
        }

        .eg-table tbody tr {
            animation: fadeInUp 0.5s ease backwards;
        }

        .eg-table tbody tr:nth-child(1) {
            animation-delay: 0.1s;
        }

        .eg-table tbody tr:nth-child(2) {
            animation-delay: 0.2s;
        }

        .eg-table tbody tr:nth-child(3) {
            animation-delay: 0.3s;
        }

        .eg-table tbody tr:nth-child(4) {
            animation-delay: 0.4s;
        }

        .eg-table tbody tr:nth-child(5) {
            animation-delay: 0.5s;
        }
    </style>

    <div class="dashboard-section">
        <div class="container">
            <div class="row g-4">
                <!-- Dashboard Menu -->
                <div class="col-lg-3">
                    <div class="dashboard-left">
                        <div class="nav flex-column nav-pills">
                            <!-- Profile -->
                            <button class="nav-link nav-btn-style active" id="v-pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-profile">
                                <svg width="20" height="20" viewBox="0 0 22 22">
                                    <path
                                        d="M18.7782 14.2218C17.5801 13.0237 16.1541 12.1368 14.5982 11.5999C16.2646 10.4522 17.3594 8.53136 17.3594 6.35938C17.3594 2.85282 14.5066 0 11 0C7.49345 0 4.64062 2.85282 4.64062 6.35938C4.64062 8.53136 5.73543 10.4522 7.40188 11.5999C5.84598 12.1368 4.41994 13.0237 3.22184 14.2218C1.14421 16.2995 0 19.0618 0 22H1.71875C1.71875 16.8823 5.88229 12.7188 11 12.7188C16.1177 12.7188 20.2812 16.8823 20.2812 22H22C22 19.0618 20.8558 16.2995 18.7782 14.2218ZM11 11C8.44117 11 6.35938 8.91825 6.35938 6.35938C6.35938 3.8005 8.44117 1.71875 11 1.71875C13.5588 1.71875 15.6406 3.8005 15.6406 6.35938C15.6406 8.91825 13.5588 11 11 11Z" />
                                </svg>
                                Hồ Sơ Cá Nhân
                            </button>

                            <!-- Change Password -->
                            <button class="nav-link nav-btn-style" id="v-pills-password-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-password">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                Đổi Mật Khẩu
                            </button>

                            <!-- Orders -->
                            <button class="nav-link nav-btn-style" id="v-pills-purchase-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-purchase">
                                <svg width="20" height="20" viewBox="0 0 22 22">
                                    <path
                                        d="M7.41246 0.0859337C6.34254 0.356638 5.40152 1.12578 4.92027 2.11836C4.61519 2.75429 4.58941 2.90039 4.56793 4.00468L4.54644 4.98437H3.02535H1.50425L1.48707 5.0789C1.43121 5.36679 0.80816 16.6977 0.829644 17.0586C0.898394 18.266 1.66754 19.3402 2.80621 19.8215C3.39488 20.0664 3.38199 20.0664 7.73473 20.0664H11.7222L12.1218 20.466C12.9211 21.2523 13.875 21.7508 14.9535 21.9398C15.5636 22.043 16.6336 22.0043 17.1879 21.8582C19.13 21.334 20.5308 19.9203 21.0422 17.9695C21.1882 17.4066 21.2226 16.457 21.1238 15.834C20.707 13.3117 18.4769 11.3867 15.9589 11.3867H15.5593L15.5379 11.159C15.525 11.0387 15.4433 9.72812 15.3617 8.25C15.28 6.77187 15.1984 5.43554 15.1855 5.27226L15.1597 4.98437H13.6386H12.1175V4.19375C12.1175 3.32148 12.0574 2.87461 11.8726 2.40625C11.4429 1.31914 10.5793 0.511326 9.45348 0.150387C9.13121 0.0429649 9.0066 0.0300751 8.42223 0.0171852C7.86363 0.00429344 7.70035 0.0171852 7.41246 0.0859337ZM8.93785 1.39648C9.80582 1.62851 10.5148 2.35468 10.7211 3.22695C10.764 3.41601 10.7855 3.73398 10.7855 4.24101V4.98437H8.33629H5.88707V4.20664C5.88707 3.34726 5.93004 3.08515 6.14488 2.66836C6.45426 2.0625 7.05582 1.57265 7.70465 1.39648C8.00113 1.31914 8.64137 1.31914 8.93785 1.39648Z" />
                                </svg>
                                Đơn Hàng
                            </button>

                            <!-- Logout -->
                            <button class="nav-link nav-btn-style">
                                <svg width="20" height="20" viewBox="0 0 22 22">
                                    <g clip-path="url(#clip0_382_377)">
                                        <path
                                            d="M21.7273 10.4732L19.3734 8.81368C18.9473 8.51333 18.3574 8.81866 18.3574 9.34047V12.6595C18.3574 13.1834 18.9485 13.4856 19.3733 13.1863L21.7272 11.5268C22.0916 11.2699 22.0906 10.7294 21.7273 10.4732Z" />
                                        <path
                                            d="M18.4963 15.1385C18.1882 14.9603 17.7939 15.0655 17.6156 15.3737C16.1016 17.9911 13.2715 19.7482 10.0374 19.7482C5.21356 19.7482 1.28906 15.8237 1.28906 11C1.28906 6.17625 5.21356 2.25171 10.0374 2.25171C13.2736 2.25171 16.1025 4.0105 17.6156 6.62617C17.7938 6.93434 18.1882 7.03949 18.4962 6.86138C18.8043 6.68315 18.9096 6.28887 18.7314 5.98074C16.9902 2.97053 13.738 0.962646 10.0374 0.962646C4.48967 0.962646 0 5.45184 0 11C0 16.5477 4.48919 21.0373 10.0374 21.0373C13.7396 21.0373 16.9909 19.028 18.7315 16.0191C18.9097 15.711 18.8044 15.3168 18.4963 15.1385Z" />
                                    </g>
                                </svg>
                                Đăng Xuất
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="tab-content">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="v-pills-profile">
                            @include('user.auth.profile-tab')
                        </div>

                        <!-- Password Change Tab -->
                        <div class="tab-pane fade" id="v-pills-password">
                            @include('user.auth.password-change')
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="v-pills-purchase">
                            @include('user.auth.order-tab-profile')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Modals -->
    @foreach ($orders as $order)
        <!-- Review Modal -->
        <div class="modal fade" id="reviewModal{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">✨ Đánh Giá Sản Phẩm</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('orders.review.submit', $order->id) }}">
                        @csrf
                        <div class="modal-body">
                            @foreach ($order->orderDetails as $detail)
                                <input type="hidden" name="product_id" value="{{ $detail->product->id }}">
                            @endforeach

                            <div class="mb-4">
                                <label class="form-label">Mức độ hài lòng</label>
                                <select name="rating" class="form-select" required>
                                    <option value="">-- Chọn đánh giá --</option>
                                    <option value="5">⭐⭐⭐⭐⭐ Xuất sắc</option>
                                    <option value="4">⭐⭐⭐⭐ Tốt</option>
                                    <option value="3">⭐⭐⭐ Bình thường</option>
                                    <option value="2">⭐⭐ Tạm được</option>
                                    <option value="1">⭐ Không hài lòng</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Chia sẻ trải nghiệm của bạn</label>
                                <textarea name="comment" class="form-control" rows="5"
                                    placeholder="Hãy chia sẻ cảm nhận của bạn về sản phẩm..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="primary-btn3" style="border: none;">Gửi đánh giá</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach --}}

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Check password strength
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strength-bar');
            let strength = 0;

            // Check requirements
            const requirements = {
                'length-req': password.length >= 8,
                'uppercase-req': /[A-Z]/.test(password),
                'lowercase-req': /[a-z]/.test(password),
                'number-req': /[0-9]/.test(password),
                'special-req': /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };

            // Update requirement indicators
            for (const [id, met] of Object.entries(requirements)) {
                const element = document.getElementById(id);
                const icon = element.querySelector('i');

                if (met) {
                    element.classList.add('valid');
                    icon.classList.remove('bi-circle');
                    icon.classList.add('bi-check-circle-fill');
                    strength++;
                } else {
                    element.classList.remove('valid');
                    icon.classList.remove('bi-check-circle-fill');
                    icon.classList.add('bi-circle');
                }
            }

            // Update strength bar
            strengthBar.className = 'password-strength-bar';
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength <= 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        }

        // Tab navigation
        document.addEventListener('DOMContentLoaded', function() {
            const navButtons = document.querySelectorAll('.nav-btn-style');
            navButtons.forEach(button => {
                button.addEventListener('click', function() {
                    navButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>

    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
