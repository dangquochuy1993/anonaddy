@component('mail::message')

# Tên miền chưa được xác thực để gửi

Kiểm tra DNS gần đây với tên miền tùy chỉnh **{{ $domain }}** đã thất bại. Điều này nghĩa là tên miền chưa được xác thực để gửi thư cho tới khi bạn cấu hình đúng bản ghi.

Bảng kiểm tra thất bại vì:

**{{ $reason }}**

Hãy truy cập trang tên miền bằng nút bên dưới để khắc phục.

Trong lúc chờ, email từ tên miền tùy chỉnh của bạn sẽ được gửi qua tên miền mặc định của AnonAddy.

@component('mail::button', ['url' => config('app.url').'/domains'])
Kiểm tra tên miền
@endcomponent
@endcomponent
