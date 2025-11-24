@component('mail::message')

# Đăng nhập 2FA thất bại

Có người vừa nhập sai OTP khi cố đăng nhập vào tài khoản AnonAddy của bạn. Tên đăng nhập (**{{ $username }}**) và mật khẩu đều đúng.

Việc đăng nhập đã bị chặn. Nếu đó là bạn thì có thể bỏ qua thông báo này.

Nếu **không phải bạn**, hãy đăng nhập và **đổi mật khẩu ngay lập tức**.

@component('mail::button', ['url' => config('app.url').'/settings'])
Đổi mật khẩu
@endcomponent
@endcomponent
