<style>
        body {
            font-family: DejaVu Sans, sans-serif !important;
            background-color: white;
            color: black;
        }

        .font-16 {
            font-size: 14px;
        }

        p {
            font-family: DejaVu Sans, sans-serif !important;
        }
    </style>

    <div>
        <div class="d-flex">
            <div><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/logo.png'))) }}" alt=""></div>
            <div style="margin-left: 180px; font-size: 12px;margin-top:-100px">
                SSKPI là một trong những công ty công nghệ hàng đầu Châu Á, bao gồm nhiều dịch vụ và mô hình làm việc đa dạng, chuyên nghiệp ở các lĩnh vực công nghệ hybrid, ứng dụng blockchain hay trí tuệ nhân tạo theo quy chuẩn Nhật Bản.
            </div>
        </div>
    </div>

    <div style="text-align: center; color: #06007A">
        <div style="font-size: 30px; margin-top:30px">
            <b>{{$job->title}}</b>
        </div>
        <div>
            {{$job->position}}
        </div>
    </div>

    <div>
        <h5 style="color: #070085;">MÔ TẢ CÔNG VIỆC</h5>
        <div style="margin-left: 36px; color: black;" class="font-16">
            <?= '<div class="div">' . $job->description . '</div>' ?>
        </div>
        <div style="margin-left: 36px; color: black;" class="font-16">
            <i>*** Địa điểm làm việc:</i> <b>{{$job->location}}</b>
        </div>
    </div>
    <div>
        <h5 style="color: #070085;">YÊU CẦU</h5>
        <div style="margin-left: 36px; color: black;" class="font-16">
            <?= $job->request ?>
        </div>
    </div>
    <div>
        <h5 style="color: #070085;">ĐÃI NGỘ</h5>
        <div style="color: black;margin-left: 36px;" class="font-16">
            Trong thời gian đào tạo ban đầu:
            <p>- Trợ cấp hàng tháng {{$job->wage}} (cụ thể sẽ trao đổi trong phỏng vấn)</p>
            <p>- Vừa học vừa làm 8 tiếng/ngày (Fresher)</p>
            <p>- Nghỉ thứ 7 và Chủ Nhật.</p>
            <p>- Cung cấp máy tính & trang thiết bị hiện đại</p>
            <p>- Được tham gia các Câu lạc bộ dưới sự tài trợ chính thức của Công ty: CLB Bóng đá, cầu
                lông, tiếng anh …</p>
            <p>- Tiếp xúc dự án phát triển sản phẩm nội bộ của công ty với quy trình chuẩn và kỹ thuật phổ
                biến nhất hiện nay.</p>

        </div>
    </div>
