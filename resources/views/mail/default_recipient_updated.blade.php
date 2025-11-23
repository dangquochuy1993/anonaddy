@component('mail::message')

# Đã cập nhật người nhận mặc định

Người nhận mặc định của tài khoản vừa được đổi từ **{{ $defaultRecipient }}** sang **{{ $newDefaultRecipient }}**.

Nếu bạn không thực hiện thay đổi này, hãy mở trang cài đặt, đăng xuất khỏi mọi phiên trình duyệt khác và đổi mật khẩu ngay.

@component('mail::button', ['url' => config('app.url').'/settings'])
Xem cài đặt
@endcomponent
@endcomponent
