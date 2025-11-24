@component('mail::message')

# Lỗi mã hóa khóa GPG

Xảy ra lỗi khi mã hóa email vừa được AnonAddy chuyển tiếp cho bạn.

Nguyên nhân có thể do khóa đã hết hạn.

Dấu vân tay của khóa: **{{ $recipient->fingerprint }}**

Tính năng mã hóa cho người nhận này đã bị tắt. Hãy cập nhật khóa nếu bạn muốn tiếp tục sử dụng.

@component('mail::button', ['url' => config('app.url').'/recipients'])
Cập nhật khóa
@endcomponent
@endcomponent
