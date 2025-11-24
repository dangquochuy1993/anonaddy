@component('mail::message')

# Thư chuyển tiếp thất bại

@if($aliasEmail)
Có một thư gửi tới bí danh **{{ $aliasEmail }}** nhưng không thành công.
@else
Có một thư gửi tới một trong các bí danh của bạn nhưng không thành công.
@endif

@if($originalSender)
Thư được gửi bởi **{{ $originalSender }}** {{ $originalSubject ? 'với tiêu đề: ' . $originalSubject : '' }}

@elseif($originalSubject)
Tiêu đề của thư: **{{ $originalSubject }}**

@endif

Bạn có thể xem lý do thất bại tại trang Thư lỗi.

@component('mail::button', ['url' => config('app.url').'/failed-deliveries'])
Xem thư lỗi
@endcomponent

@endcomponent
