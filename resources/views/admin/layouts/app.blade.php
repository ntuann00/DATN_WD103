@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@stack('page-css')

<div class="main_content_iner overly_inner ">
    <div class="container-fluid p-0">

        @yield('content') {{-- nội dung dashboard sẽ hiển thị ở đây --}}
        <style>
            table {
                border-collapse: collapse;
            }

            th, td {
                padding: 10px;
                border: 1px solid #ddd;
                text-align: left;
                vertical-align: middle;
                word-wrap: break-word;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            th {
                background-color: #f4f4f4;
            }

            /* Cột ID: nhỏ gọn hơn */
            th:nth-child(1),
            td:nth-child(1) {
                width: 50px;
                max-width: 50px;
                text-align: center;
            }

            /* Các cột tên SP, danh mục, thương hiệu... */
            td:nth-child(2),
            td:nth-child(3),
            td:nth-child(4) {
                max-width: 200px;
            }
        </style>
    </div>
</div>

@push('scripts')

@include('admin.layouts.footer')
