@component('mail::message')

# Cảnh báo mức sử dụng băng thông

Bạn đã dùng **{{ $bandwidthUsage }}MB / {{ $bandwidthLimit }}MB** trong tháng ({{ $month }}).</p>

Băng thông sẽ được đặt lại vào **{{ $reset }}**.

Đầu mỗi tháng, mức sử dụng sẽ **trở về 0**.

Nếu vượt giới hạn, email gửi đến sẽ bị từ chối cho tới khi bạn xuống dưới ngưỡng.

@component('mail::button', ['url' => config('app.url').'/settings'])
Xem mức sử dụng
@endcomponent
@endcomponent
