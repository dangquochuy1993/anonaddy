@extends('layouts.app')

@section('content')
    <div class="container py-8">
        @include('shared.status')

        @if(session('backupCode'))
            <div class="text-sm border-t-8 rounded text-yellow-800 border-yellow-600 bg-yellow-100 px-3 py-4 mb-4" role="alert">
                <div class="flex items-center mb-2">
                    <span class="rounded-full bg-yellow-400 uppercase px-2 py-1 text-xs font-bold mr-2">Quan trọng</span>
                    <div>
                        Đã bật 2FA thành công. Vui lòng <b>sao lưu mã dự phòng bên dưới</b>. Nếu bạn đang lưu một mã dự phòng cũ <b>hãy thay thế bằng mã mới này.</b> Khi mất thiết bị 2FA bạn có thể dùng mã dự phòng để tắt 2FA trên tài khoản. <b>Mã chỉ được hiển thị duy nhất lần này nên đừng để thất lạc!</b>
                    </div>
                </div>
                <pre class="flex p-3 text-grey-900 bg-white border rounded">
                    <code class="break-all whitespace-normal">{{ session('backupCode') }}</code>
                </pre>
            </div>
        @endif

        <div class="mb-4">
            <h2 class="text-3xl font-bold">
                Mức sử dụng
            </h2>
            <p class="text-grey-500">Thông tin chi tiết về mức sử dụng tài khoản</p>
        </div>

        <div class="px-6 py-8 md:p-10 bg-white rounded-lg shadow mb-10">
            <div>
                <h3 class="font-bold text-xl">
                    Băng thông
                </h3>

                <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                <p class="mt-6">Bạn đã dùng <b>{{ $user->bandwidth_mb }}MB / {{ $user->getBandwidthLimitMb() }}MB</b> trong tháng hiện tại ({{ now()->format('F') }}).</p>
                <p class="mt-4">Dung lượng băng thông sẽ được đặt lại vào <b>{{ now()->addMonthsNoOverflow(1)->startOfMonth()->format('jS F') }}</b>.</p>
                <p class="mt-4">Đầu mỗi tháng dương lịch, mức sử dụng băng thông sẽ trở về 0. Nếu bạn sắp chạm giới hạn, chúng tôi sẽ gửi email thông báo.</p>
                <p class="mt-4">Khi vượt hạn mức, hệ thống sẽ từ chối email đến cho đến khi băng thông giảm xuống dưới giới hạn.</p>
            </div>
        </div>

        <div class="mb-4">
            <h2 class="text-3xl font-bold">
                Cài đặt
            </h2>
            <p class="text-grey-500">Điều chỉnh tùy chọn của bạn</p>
        </div>

        <div class="px-6 py-8 md:p-10 bg-white rounded-lg shadow mb-10">

            @if($user->hasVerifiedDefaultRecipient())

                <form method="POST" action="{{ route('settings.default_recipient') }}">
                    @csrf

                    <div class="mb-6">

                        <h3 class="font-bold text-xl">
                            {{ __('Update Default Recipient') }}
                        </h3>

                        <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                        <p class="mt-6">Người nhận mặc định được áp dụng cho mọi bí danh mới và các bí danh chưa gán người nhận riêng. Sau khi bí danh đã được tạo trong bảng điều khiển, bạn có thể đổi sang người nhận khác bất kỳ lúc nào.</p>

                        <div class="mt-6 flex flex-wrap mb-4">
                            <label for="default-recipient" class="block text-grey-700 text-sm mb-2">
                                {{ __('Select Recipient') }}:
                            </label>

                            <div class="block relative w-full">
                                <select id="default-recipient" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="default_recipient" required>
                                    @foreach($recipientOptions as $recipient)
                                    <option value="{{ $recipient->id }}" {{ $user->email === $recipient->email ? 'selected' : '' }}>{{ $recipient->email }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>

                            @if ($errors->has('default_recipient'))
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $errors->first('default_recipient') }}
                                </p>
                            @endif
                        </div>

                    </div>

                    <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                        {{ __('Update Default Recipient') }}
                    </button>

                </form>

            @else

                    <form method="POST" action="{{ route('settings.edit_default_recipient') }}">
                    @csrf

                    <div class="mb-6">

                        <h3 class="font-bold text-xl">
                            {{ __('Update Email') }}
                        </h3>

                        <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                        <p class="mt-6">Lỡ nhập sai địa chỉ email khi đăng ký? Hãy cập nhật lại email bên dưới, bạn sẽ nhận được email xác minh mới.</p>

                        <div class="mt-6 flex flex-wrap mb-4">
                            <label for="email" class="block text-grey-700 text-sm mb-2">
                                {{ __('Email') }}:
                            </label>

                            <div class="block relative w-full">
                                <input id="email" type="email" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="email" value="{{ old('email') ?? $user->email }}">
                            </div>

                            @if ($errors->has('email'))
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-6 flex flex-wrap mb-4">
                            <label for="email_confirmation" class="block text-grey-700 text-sm mb-2">
                                {{ __('Confirm Email') }}:
                            </label>

                            <div class="block relative w-full">
                                <input id="email_confirmation" type="email" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="email_confirmation">
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                        {{ __('Update Email') }}
                    </button>

                </form>

            @endif

            <form method="POST" action="{{ route('settings.default_alias_domain') }}" class="pt-16">
                @csrf

                <div class="mb-6">

                    <h3 class="font-bold text-xl">
                        {{ __('Update Default Alias Domain') }}
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="mt-6">Tên miền bí danh mặc định sẽ được chọn sẵn khi bạn tạo bí danh mới trên trang web hoặc tiện ích trình duyệt. Nhờ vậy bạn không cần chọn đi chọn lại tên miền yêu thích mỗi lần.</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="default-alias-domain" class="block text-grey-700 text-sm mb-2">
                            {{ __('Select Default Domain') }}:
                        </label>

                        <div class="block relative w-full">
                            <select id="default-alias-domain" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="domain" required>
                                @foreach($user->domainOptions() as $domainOption)
                                <option value="{{ $domainOption }}" {{ $user->default_alias_domain === $domainOption ? 'selected' : '' }}>{{ $domainOption }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                        @if ($errors->has('domain'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('domain') }}
                            </p>
                        @endif
                    </div>

                </div>

                <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                    {{ __('Update Default Alias Domain') }}
                </button>

            </form>

            <form method="POST" action="{{ route('settings.default_alias_format') }}" class="pt-16">
                @csrf

                <div class="mb-6">

                    <h3 class="font-bold text-xl">
                        {{ __('Update Default Alias Format') }}
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="mt-6">Định dạng bí danh mặc định sẽ được áp dụng sẵn khi bạn tạo bí danh mới, giúp tiết kiệm thời gian chọn lựa lại mỗi lần.</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="default-alias-format" class="block text-grey-700 text-sm mb-2">
                            {{ __('Select Default Format') }}:
                        </label>

                        <div class="block relative w-full">
                                <select id="default-alias-format" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="format" required>
                                    <option value="random_characters" {{ $user->default_alias_format === 'random_characters' ? 'selected' : '' }}>Ký tự ngẫu nhiên</option>
                                    <option value="uuid" {{ $user->default_alias_format === 'uuid' ? 'selected' : '' }}>UUID</option>
                                    <option value="random_words" {{ $user->default_alias_format === 'random_words' ? 'selected' : '' }}>Từ ngẫu nhiên</option>
                                    <option value="custom" {{ $user->default_alias_format === 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
                                </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                        @if ($errors->has('format'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('format') }}
                            </p>
                        @endif
                    </div>

                </div>

                <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                    {{ __('Update Default Alias Format') }}
                </button>

            </form>

            <form class="pt-16" method="POST" action="{{ route('settings.use_reply_to') }}">
                @csrf

                <div class="mb-6">

                    <h3 class="font-bold text-xl">
                        Dùng tiêu đề Reply-To khi trả lời
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="mt-6">Tùy chọn này quyết định email chuyển tiếp sẽ dùng tiêu đề From hay Reply-To khi bạn trả lời. Một số người thích đặt bộ lọc hộp thư khi tiêu đề From chỉ chứa bí danh.
                    </p>
                    <p class="mt-4">Khi bật, trường <b>From:</b> sẽ là địa chỉ bí danh, ví dụ <b>alias{{ '@'.$user->username }}.{{ config('anonaddy.domain') }}</b> thay vì định dạng mặc định <b class="break-words">alias+sender=example.com{{ '@'.$user->username }}.{{ config('anonaddy.domain') }}</b> (định dạng mặc định sẽ được đưa sang Reply-To).</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="use_reply_to" class="block text-grey-700 text-sm mb-2">
                            {{ __('Update Use Reply-To') }}:
                        </label>

                        <div class="block relative w-full">
                            <select id="use_reply_to" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="use_reply_to" required>
                                <option value="1" {{ $user->use_reply_to ? 'selected' : '' }}>Bật</option>
                                <option value="0" {{ ! $user->use_reply_to ? 'selected' : '' }}>Tắt</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                        @if ($errors->has('use_reply_to'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('use_reply_to') }}
                            </p>
                        @endif
                    </div>

                </div>

                <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                    {{ __('Update Use Reply-To') }}
                </button>
            </form>

            <form id="update-password" method="POST" action="{{ route('settings.password') }}" class="pt-16">
                @csrf

                <div class="mb-6">

                    <h3 class="font-bold text-xl">
                        {{ __('Update Password') }}
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="mt-6">Hãy dùng mật khẩu dài, ngẫu nhiên và độc nhất để giữ tài khoản an toàn. Bạn nên sử dụng trình quản lý mật khẩu (ví dụ Bitwarden). Khi đổi mật khẩu, mọi phiên đăng nhập đang hoạt động trên trình duyệt hoặc thiết bị khác cũng sẽ bị đăng xuất.</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="current" class="block text-grey-700 text-sm mb-2">
                            {{ __('Current Password') }}:
                        </label>

                        <input id="current" type="password" class="appearance-none bg-grey-100 rounded w-full p-3 text-grey-700 focus:ring{{ $errors->has('current') ? ' border-red-500' : '' }}" name="current" placeholder="********" required>

                        @if ($errors->has('current'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('current') }}
                            </p>
                        @endif
                    </div>

                    <div class="flex flex-wrap mb-4">
                        <label for="password" class="block text-grey-700 text-sm mb-2">
                            {{ __('New Password') }}:
                        </label>

                        <input id="password" type="password" class="appearance-none bg-grey-100 rounded w-full p-3 text-grey-700 focus:ring{{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" placeholder="********" required>

                        @if ($errors->has('password'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>

                    <div class="flex flex-wrap">
                        <label for="password-confirm" class="block text-grey-700 text-sm mb-2">
                            {{ __('Confirm New Password') }}:
                        </label>

                        <input id="password-confirm" type="password" class="appearance-none bg-grey-100 rounded w-full p-3 text-grey-700 focus:ring" name="password_confirmation" placeholder="********" required>
                    </div>

                </div>

                <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                    {{ __('Update Password') }}
                </button>

            </form>

            <form id="logout-browser-sessions" method="POST" action="{{ route('browser-sessions.destroy') }}" class="pt-16">
                @method('DELETE')
                @csrf

                <div class="mb-6">

                    <h3 class="font-bold text-xl">
                        Phiên trình duyệt
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="mt-6">Nếu cần, bạn có thể đăng xuất khỏi toàn bộ phiên trình duyệt khác trên mọi thiết bị. Khi nghi ngờ tài khoản bị xâm phạm, hãy đổi mật khẩu ngay.</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="current-password-sessions" class="block text-grey-700 text-sm mb-2">
                            {{ __('Current Password') }}:
                        </label>

                        <input id="current-password-sessions" type="password" class="appearance-none bg-grey-100 rounded w-full p-3 text-grey-700 focus:ring{{ $errors->has('current_password_sesssions') ? ' border-red-500' : '' }}" name="current_password_sesssions" placeholder="********" required>

                        @if ($errors->has('current_password_sesssions'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('current_password_sesssions') }}
                            </p>
                        @endif
                    </div>

                </div>

                <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                    {{ __('Logout Other Browser Sessions') }}
                </button>

            </form>

        </div>

        <div class="mb-4">
            <h2 class="text-3xl font-bold">
                Xác thực hai yếu tố
            </h2>
            <p class="text-grey-500">Quản lý các lựa chọn 2FA</p>
        </div>

        <div class="px-6 py-8 md:p-10 bg-white rounded-lg shadow mb-10">

            <div id="two-factor">

                <h3 class="font-bold text-xl">
                    Thông tin
                </h3>

                <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                <p class="mt-6">
                    Xác thực hai yếu tố (2FA) bổ sung một lớp bảo mật ngoài tên đăng nhập và mật khẩu. Có <b>hai lựa chọn 2FA</b> – ứng dụng tạo mã (Google Authenticator, Aegis, andOTP…) hoặc khóa bảo mật phần cứng (YubiKey, SoloKey, Nitrokey…).
                </p>

                <p class="mt-4 pb-16">
                    Khi đăng nhập với 2FA, bạn sẽ được yêu cầu dùng khóa bảo mật hoặc nhập mã OTP tùy phương thức đã kích hoạt. Bạn chỉ có thể bật một phương thức 2FA tại cùng thời điểm.
                </p>

                @if($user->two_factor_enabled || LaravelWebauthn\Facades\Webauthn::enabled($user))
                    <h3 class="font-bold text-xl">
                        Tạo mã dự phòng mới
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="my-4">
                        Mã dự phòng cho phép đăng nhập khi bạn mất thiết bị 2FA.
                        Nếu quên hoặc thất lạc mã cũ hãy tạo mã mới bằng nút bên dưới. <b>Mã chỉ hiển thị một lần</b> nên hãy lưu ở nơi <b>an toàn</b>.
                    </p>

                    <form method="POST" action="{{ route('settings.new_backup_code') }}" class="pb-16">
                        @csrf
                        <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                            Tạo mã dự phòng mới
                        </button>
                    </form>
                @endif

                @if($user->two_factor_enabled)

                    <form method="POST" action="{{ route('settings.2fa_disable') }}">
                        @csrf

                        <div class="mb-6">

                        <h3 class="font-bold text-xl">
                            Tắt ứng dụng xác thực (TOTP)
                        </h3>

                            <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                        <p class="mt-6">Để tắt 2FA bằng ứng dụng, hãy nhập mật khẩu của bạn bên dưới. Bạn có thể bật lại bất cứ lúc nào.</p>

                            <div class="mt-6 flex flex-wrap">
                                <label for="current_password_2fa" class="block text-grey-700 text-sm mb-2">
                                    {{ __('Current Password') }}:
                                </label>

                                <input id="current_password_2fa" type="password" class="appearance-none bg-grey-100 rounded w-full p-3 text-grey-700 focus:ring{{ $errors->has('current_password_2fa') ? ' border-red-500' : '' }}" name="current_password_2fa" placeholder="********" required>

                                @if ($errors->has('current_password_2fa'))
                                    <p class="text-red-500 text-xs italic mt-4">
                                        {{ $errors->first('current_password_2fa') }}
                                    </p>
                                @endif
                            </div>

                        </div>

                        <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                            {{ __('Disable') }}
                        </button>

                    </form>

                @else

                    @if(LaravelWebauthn\Facades\Webauthn::enabled($user))

                        <webauthn-keys />

                    @else

                        <div class="mb-6">

                            <h3 class="font-bold text-xl">
                                Bật ứng dụng xác thực (TOTP)
                            </h3>

                            <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                            <p class="mt-6">Để dùng TOTP bạn cần ứng dụng như Google Authenticator, Aegis hoặc andOTP (Android). Bạn cũng có thể nhập thủ công bằng mã bên dưới. Hãy lưu mã bí mật ở nơi an toàn.</p>

                            <div>
                                {!! $qrCode !!}
                                <p class="mb-2">Mã bí mật: {{ $authSecret }}</p>
                                <form method="POST" action="{{ route('settings.2fa_regenerate') }}">
                                    @csrf
                                    <input type="submit" class="text-indigo-900 bg-transparent cursor-pointer" value="Bấm để tạo lại mã bí mật">

                                    @if ($errors->has('regenerate_2fa'))
                                        <p class="text-red-500 text-xs italic mt-4">
                                            {{ $errors->first('regenerate_2fa') }}
                                        </p>
                                    @endif
                                </form>
                            </div>

                        </div>

                        <form method="POST" action="{{ route('settings.2fa_enable') }}">
                            @csrf
                            <div class="my-6 flex flex-wrap">
                                <label for="two_factor_token" class="block text-grey-700 text-sm mb-2">
                                    {{ __('Verify and Enable') }}:
                                </label>

                                <div class="block relative w-full">
                                    <input id="two_factor_token" type="text" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="two_factor_token" placeholder="123456" />
                                </div>

                                @if ($errors->has('two_factor_token'))
                                    <p class="text-red-500 text-xs italic mt-4">
                                        {{ $errors->first('two_factor_token') }}
                                    </p>
                                @endif
                            </div>
                            <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                                {{ __('Verify and Enable') }}
                            </button>
                        </form>

                        <div class="pt-16">

                            <h3 class="font-bold text-xl">
                                Bật xác thực bằng thiết bị (WebAuthn)
                            </h3>

                            <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                            <p class="my-6">WebAuthn là tiêu chuẩn bảo mật mới của W3C. Bạn có thể dùng bất kỳ khóa phần cứng nào như YubiKey, SoloKey, Nitrokey...</p>

                            <a
                            type="button"
                            href="{{ route('webauthn.create') }}"
                            class="block bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none text-center"
                            >
                                Đăng ký khóa bảo mật mới
                            </a>

                        </div>

                    @endif
                @endif
            </div>

        </div>

        <div class="mb-4">
            <h2 class="text-3xl font-bold">
                Các cài đặt khác
            </h2>
            <p class="text-grey-500">Điều chỉnh những tùy chọn còn lại</p>
        </div>

        <div class="px-6 py-8 md:p-10 bg-white rounded-lg shadow mb-10">

            <form class="mb-16" method="POST" action="{{ route('settings.from_name') }}">
                @csrf

                <div class="mb-6">

                    <h3 class="font-bold text-xl">
                        {{ __('Update From Name') }}
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="mt-6">Tên hiển thị được dùng khi bạn trả lời email được chuyển tiếp ẩn danh. Nếu để trống, bí danh email sẽ được dùng làm tên hiển thị, ví dụ "ebay{{ '@'.$user->username }}.{{ config('anonaddy.domain') }}".</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="from_name" class="block text-grey-700 text-sm mb-2">
                            {{ __('From Name') }}:
                        </label>

                        <div class="block relative w-full">
                            <input id="from_name" type="text" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="from_name" value="{{ $user->from_name }}" placeholder="John Doe" />
                        </div>

                        @if ($errors->has('from_name'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('from_name') }}
                            </p>
                        @endif
                    </div>

                </div>

                <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                    {{ __('Update From Name') }}
                </button>

            </form>

            <form class="mb-16" method="POST" action="{{ route('settings.banner_location') }}">
                @csrf

                <div class="mb-6">

                    <h3 class="font-bold text-xl">
                        {{ __('Update Banner Location') }}
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="mt-6">Đây là phần thông tin xuất hiện trong email chuyển tiếp để bạn biết người gửi và bí danh nhận. Bạn có thể hiển thị ở đầu, cuối email hoặc tắt hẳn.</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="banner_location" class="block text-grey-700 text-sm mb-2">
                            {{ __('Update Location') }}:
                        </label>

                        <div class="block relative w-full">
                            <select id="banner_location" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="banner_location" required>
                                <option value="top" {{ $user->banner_location === 'top' ? 'selected' : '' }}>Phía trên</option>
                                <option value="bottom" {{ $user->banner_location === 'bottom' ? 'selected' : '' }}>Phía dưới</option>
                                <option value="off" {{ $user->banner_location === 'off' ? 'selected' : '' }}>Tắt</option>

                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                        @if ($errors->has('banner_location'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('banner_location') }}
                            </p>
                        @endif
                    </div>

                </div>

                <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                    {{ __('Update Banner Location') }}
                </button>

            </form>

            <form method="POST" action="{{ route('settings.email_subject') }}">
                @csrf

                <div class="mb-6">

                    <h3 class="font-bold text-xl">
                        Thay thế tiêu đề email
                    </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                    <p class="mt-6">Tùy chọn này hữu ích khi bạn <b>sử dụng mã hóa</b>. Sau khi thêm khóa GPG/OpenPGP công khai cho người nhận, nội dung email chuyển tiếp (kể cả tệp đính kèm) sẽ được mã hóa, nhưng tiêu đề thì không. Để tránh lộ nội dung, bạn có thể thay tiêu đề bằng một chuỗi chung chung, ví dụ "Thông báo" hoặc "Xin chào".</p>
                    <p class="mt-4">Nếu để trống, hệ thống sẽ dùng tiêu đề gốc.</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="email_subject" class="block text-grey-700 text-sm mb-2">
                            {{ __('Email Subject') }}:
                        </label>

                        <div class="block relative w-full">
                            <input id="email_subject" type="text" class="block appearance-none w-full text-grey-700 bg-grey-100 p-3 pr-8 rounded shadow focus:ring" name="email_subject" value="{{ $user->email_subject }}" placeholder="The subject" />
                        </div>

                        @if ($errors->has('email_subject'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('email_subject') }}
                            </p>
                        @endif
                    </div>

                </div>

                <button type="submit" class="bg-cyan-400 w-full hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
                    {{ __('Update Email Subject') }}
                </button>

            </form>

        </div>

        <div class="mb-4">
            <h2 class="text-3xl font-bold">
                API
            </h2>
            <p class="text-grey-500">Quản lý token truy cập API</p>
        </div>

        <div class="px-6 py-8 md:p-10 bg-white rounded-lg shadow mb-10">

            <personal-access-tokens />

        </div>

        <div class="mb-4">
            <h2 class="text-3xl font-bold">
                Dữ liệu
            </h2>
            <p class="text-grey-500">Quản lý dữ liệu tài khoản của bạn</p>
        </div>

        <div class="px-6 py-8 md:p-10 bg-white rounded-lg shadow mb-10">

            <div class="mb-6">
                <h3 class="font-bold text-xl">
                    Nhập bí danh
                </h3>

                <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                <p class="mt-6">Bạn có thể nhập bí danh cho <b>các tên miền tùy chỉnh</b> bằng cách tải lên tệp CSV. Lưu ý tính năng này <b>chỉ hỗ trợ tên miền tùy chỉnh</b>.</p>


                <p class="mt-4">Những bí danh <b>đã tồn tại</b> sẽ không được nhập lại.</p>
                <p class="mt-4">Mỗi lần nhập tối đa <b>1.000 dòng</b>. Nếu cần thêm, hãy chia thành nhiều tệp CSV.</p>
                <p class="mt-4">Vui lòng dùng mẫu CSV bên dưới. Chỉ hỗ trợ định dạng CSV.</p>
                <p class="mt-4">Quá trình nhập có thể mất vài phút và bạn sẽ <b>nhận email thông báo</b> khi hoàn tất.</p>
                <p class="mt-4"><a href="/import-aliases-template.csv" rel="nofollow noopener noreferrer" class="text-indigo-700 cursor-pointer">Bấm để tải mẫu CSV</a></p>
            </div>

            <form action="{{ route('aliases.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input type="file" name="aliases_import" required />
                    @if ($errors->has('aliases_import'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('aliases_import') }}
                        </p>
                    @endif
                    <div class="mt-4">
                        <button type="submit" class="bg-cyan-400 block w-full text-center hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">Nhập dữ liệu bí danh</button>
                    </div>
                </div>
            </form>

            <div class="my-6">
                <h3 class="font-bold text-xl">
                    Xuất bí danh
                </h3>

                <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

            <p class="mt-6">Nhấn nút bên dưới để xuất dữ liệu của <b>{{ $user->aliases()->withTrashed()->count() }}</b> bí danh dưới dạng tệp .csv.</p>
            </div>

        <a href="{{ route('aliases.export') }}" class="bg-cyan-400 block w-full text-center hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:outline-none">
            Xuất dữ liệu bí danh
        </a>

        </div>

        <div class="mb-4">
            <h2 class="text-3xl font-bold">
                Khu vực nguy hiểm
            </h2>
            <p class="text-grey-500">Những thao tác không thể hoàn tác</p>
        </div>

        <div class="px-6 py-8 md:p-10 bg-white rounded-lg shadow">

            <form method="POST" action="{{ route('account.destroy') }}">
                @csrf

                <div class="mb-6">

                <h3 class="font-bold text-xl">
                    {{ __('Delete Account') }}
                </h3>

                    <div class="mt-4 w-24 border-b-2 border-grey-200"></div>

                <p class="mt-6">Sau khi xóa tài khoản, bạn không thể khôi phục. Tên người dùng này cũng không thể được sử dụng lại. Hãy chắc chắn trước khi tiếp tục.</p>

                    <div class="mt-6 flex flex-wrap mb-4">
                        <label for="current-password-delete" class="block text-grey-700 text-sm mb-2">
                            {{ __('Enter your password to continue') }}:
                        </label>

                        <input id="current-password-delete" type="password" class="appearance-none bg-grey-100 rounded w-full p-3 text-grey-700 focus:outline-none focus:ring{{ $errors->has('current_password_delete') ? ' border-red-500' : '' }}" name="current_password_delete" placeholder="********" required>

                        @if ($errors->has('current_password_delete'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('current_password_delete') }}
                            </p>
                        @endif
                    </div>

                </div>

                <button type="submit" class="text-white font-semibold bg-red-500 hover:bg-red-600 w-full py-3 px-4 rounded focus:outline-none">
                    {{ __('Delete Account') }}
                </button>

            </form>
        </div>

    </div>
@endsection
