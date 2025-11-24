@component('mail::message')

# Nhập bí danh hoàn tất

Tệp CSV bạn nhập có tổng cộng **{{ $totalRows }}** bí danh. **{{ $totalImported }}** bí danh đã được nhập thành công.

@if($totalNotImported)
**{{ $totalNotImported }}** bí danh chưa được nhập. Chi tiết lý do xem bên dưới:

@if($totalFailures)
- **{{ $totalFailures }}** bí danh gặp lỗi xác thực
@endif
@if($totalErrors)
- **{{ $totalErrors }}** bí danh bị trùng (đã tồn tại trong cơ sở dữ liệu)
@endif
@endif

Bạn có thể xem các bí danh vừa nhập bằng cách truy cập tài khoản bên dưới.

@component('mail::button', ['url' => config('app.url')])
Xem danh sách bí danh
@endcomponent
@endcomponent
