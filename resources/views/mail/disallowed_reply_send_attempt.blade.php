@component('mail::message')

# Nỗ lực trả lời/gửi bị chặn

Có một yêu cầu gửi hoặc trả lời bằng bí danh **{{ $aliasEmail }}** nhưng bị từ chối vì người nhận **{{ $recipient }}** không cho phép trả lời/gửi.

Yêu cầu này đang cố gửi đến: **{{ $destination }}**

Nếu đây là hành động của bạn, hãy tới [trang người nhận]({{ config('app.url').'/recipients' }}) và bật quyền “can reply/send” cho **{{ $recipient }}**.

Nếu không phải bạn thực hiện, có thể ai đó đang cố gửi email từ bí danh của bạn. Hãy đảm bảo miền người nhận có cấu hình DMARC phù hợp (p=quarantine hoặc p=reject) cùng bản ghi SPF và DKIM để tránh bị giả mạo.

@if($authenticationResults)
Kết quả xác thực của thư:

{{ $authenticationResults }}
@endif

@endcomponent
