<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="d-flex">
            <div><img src="{{url('storage/logo.png')}}" alt="" style="height: 70px;margin-top:7px"></div>
            <div style="height: 70px;">
                SSKPI là một trong những công ty công nghệ hàng đầu Châu Á, bao gồm nhiều dịch vụ và mô hình làm việc đa dạng, chuyên nghiệp ở các lĩnh vực công nghệ hybrid, ứng dụng blockchain hay trí tuệ nhân tạo theo quy chuẩn Nhật Bản. <br>
                Gia nhập với chúng tôi, bạn sẽ có cơ hội được phát triển năng lực, tích lũy kinh nghiệm, hoàn thiện bản thân và trở thành thành viên trong một ngôi nhà đầy năng lượng và hạnh phúc hơn bao giờ hết!
            </div>
        </div>
        <br>        
        <div class="text-center" style="font-size: 30px; color: #06007A">
            <b>{{$job->title}}</b>
            <div style="font-size:20px">{{$job->position}}</div>
        </div>
        <div>
            <h5 style="color: #070085;">MÔ TẢ CÔNG VIỆC</h3>
            <div style="margin-left: 36px;">
                {{$job->description}}
            </div>
            <div style="margin-left: 36px;">
                <i>*** Địa điểm làm việc: </i> <b>{{$job->location}}</b>
            </div>
        </div>
        <div>
            <h5 style="color: #070085;">YÊU CẦU</h3>
            <div style="margin-left: 36px;">
                {{$job->request}}
            </div>
        </div>
        <div>
            <h5 style="color: #070085;">ĐÃI NGỘ</h3>
                <div>
                    Trong thời gian đào tạo ban đầu:
                    <ul>
                        <li>Trợ cấp hàng tháng {{$job->wage}} (cụ thể sẽ trao đổi trong phỏng vấn)</li>
                        <li>Vừa học vừa làm 8 tiếng/ngày (Fresher)</li>
                        <li>Nghỉ thứ 7 và Chủ Nhật.</li>
                        <li>Cung cấp máy tính & trang thiết bị hiện đại</li>
                        <li>Được tham gia các Câu lạc bộ dưới sự tài trợ chính thức của Công ty: CLB Bóng đá, cầu
                            lông, tiếng anh …</li>
                        <li>Tiếp xúc dự án phát triển sản phẩm nội bộ của công ty với quy trình chuẩn và kỹ thuật phổ
                            biến nhất hiện nay.</li>
                    </ul>
                </div>
        </div>
        <div class="text-center">
            <img src="../../storage/logo.png" alt="">
        </div>
    </div>
</body>

</html>