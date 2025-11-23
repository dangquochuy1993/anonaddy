@component('mail::message')

# Nỗ lực trả lời/gửi thất bại

Có một yêu cầu gửi hoặc trả lời bằng bí danh **{{ $aliasEmail }}** từ **{{ $recipient }}** nhưng thất bại vì không vượt qua kiểm tra xác thực và có thể bị giả mạo.

Để gửi hoặc trả lời từ bí danh, miền **{{ \Illuminate\Support\Str::afterLast($recipient, '@') }}** phải có chính sách DMARC hợp lệ và thư của bạn phải được phép theo chính sách đó.

Yêu cầu đang cố gửi đến: **{{ $destination }}**

@if($authenticationResults)
Kết quả xác thực của thư:

{{ $authenticationResults }}
@endif

Nếu đây là hành động của bạn, @if($authenticationResults)hãy xem các kết quả xác thực ở trên và @endif đảm bảo miền của người nhận (**{{ \Illuminate\Support\Str::afterLast($recipient, '@') }}**) đã cấu hình đúng bản ghi SPF, DKIM và DMARC.

Nếu không phải bạn thực hiện, có thể ai đó đang cố gửi email từ bí danh của bạn. Hãy cấu hình DMARC phù hợp (p=quarantine hoặc p=reject) cùng với SPF và DKIM để bảo vệ địa chỉ người nhận khỏi bị giả mạo.

@endcomponent
