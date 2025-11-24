@component('mail::message')

# Nhắc tên đăng nhập

Tài khoản gắn với địa chỉ email này có tên đăng nhập: **{{ $username }}**

Nếu cũng quên mật khẩu, bạn có thể dùng tên đăng nhập này để đặt lại.

@component('mail::button', ['url' => config('app.url').'/login'])
Đăng nhập ngay
@endcomponent
@endcomponent
