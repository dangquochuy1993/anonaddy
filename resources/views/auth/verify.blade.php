@extends('layouts.app')

@section('content')
    <div class="container py-8">
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-md">

                @if (session('resent'))
                    <div class="text-sm border-t-8 rounded text-green-700 border-green-600 bg-green-100  px-3 py-4 mb-4" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div class="px-6 py-8 md:px-10 flex flex-col break-words bg-white rounded-lg shadow-lg">
                    <h1 class="text-center font-bold text-2xl">
                        {{ __('Verify Your Email Address') }}
                    </h1>

                    <div class="mx-auto mt-6 w-24 border-b-2 border-grey-200"></div>

                    <div class="w-full flex flex-wrap mt-8">
                        <p class="leading-normal mb-2 text-center">
                            Trước khi tiếp tục, vui lòng kiểm tra hộp thư <b>{{ user()->email }}</b> để tìm liên kết xác minh. Liên kết này sẽ hết hạn sau 1 giờ.
                        </p>
                        <p class="leading-normal mb-6 text-center">
                            Nếu địa chỉ email đó không chính xác bạn có thể cập nhật tại <a href="{{ route('settings.show') }}" class="text-indigo-700">trang cài đặt</a>.
                        </p>

                        <form method="POST" action="{{ route('verification.resend') }}" class="w-full">
                            @csrf

                            <button type="submit" class="bg-cyan-400 w-full text-center hover:bg-cyan-300 text-cyan-900 font-bold py-3 px-4 rounded focus:ring no-underline mx-auto">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        <p class="text-sm text-grey-600 mt-4 text-center w-full">
                            {{ __('You can resend once per minute.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection