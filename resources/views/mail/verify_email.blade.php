@component('mail::message')

# Xin chào!

Vui lòng nhấn nút bên dưới để xác minh địa chỉ email của bạn.

@component('mail::button', ['url' => $verificationUrl])
Xác minh email
@endcomponent

Nếu bạn không tạo tài khoản, hãy bỏ qua email này.

@component('mail::subcopy')
Nếu không nhấn được nút “Xác minh email”, hãy sao chép đường dẫn bên dưới
và dán vào trình duyệt: <span class="break-all">[{{ $verificationUrl }}]({{ $verificationUrl }})</span>
@endcomponent

@endcomponent
