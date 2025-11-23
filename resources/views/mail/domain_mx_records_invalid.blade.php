@component('mail::message')

# Bản ghi MX của tên miền không hợp lệ

Kiểm tra DNS gần đây cho tên miền tùy chỉnh **{{ $domain }}** cho thấy các bản ghi MX không còn trỏ về máy chủ AnonAddy. Điều này đồng nghĩa AnonAddy sẽ không thể xử lý email của bạn.

Nếu bạn cố ý thay đổi MX thì có thể bỏ qua email này.

Ngược lại, hãy truy cập trang quản lý tên miền bằng nút bên dưới và kiểm tra lại bản ghi để khắc phục.

@component('mail::button', ['url' => config('app.url').'/domains'])
Kiểm tra tên miền
@endcomponent
@endcomponent
