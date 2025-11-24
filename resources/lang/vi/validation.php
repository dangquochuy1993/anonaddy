<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dòng ngôn ngữ cho bộ xác thực
    |--------------------------------------------------------------------------
    |
    | Những dòng sau chứa thông báo lỗi mặc định được dùng bởi lớp validator.
    | Một số quy tắc có nhiều phiên bản như các quy tắc về kích thước. Hãy
    | tự do điều chỉnh các thông báo này để phù hợp với ứng dụng của bạn.
    |
    */

    'accepted' => ':attribute phải được chấp nhận.',
    'active_url' => ':attribute không phải là URL hợp lệ.',
    'after' => ':attribute phải là ngày sau :date.',
    'after_or_equal' => ':attribute phải là ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ được chứa chữ cái.',
    'alpha_dash' => ':attribute chỉ được chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
    'alpha_num' => ':attribute chỉ được chứa chữ cái và số.',
    'array' => ':attribute phải là một mảng.',
    'before' => ':attribute phải là ngày trước :date.',
    'before_or_equal' => ':attribute phải là ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => ':attribute phải nằm trong khoảng :min đến :max.',
        'file' => ':attribute phải có dung lượng từ :min đến :max kilobyte.',
        'string' => ':attribute phải có từ :min đến :max ký tự.',
        'array' => ':attribute phải có từ :min đến :max phần tử.',
    ],
    'boolean' => ':attribute chỉ được nhận giá trị true hoặc false.',
    'confirmed' => 'Giá trị xác nhận của :attribute không khớp.',
    'date' => ':attribute không phải là ngày hợp lệ.',
    'date_equals' => ':attribute phải là ngày bằng :date.',
    'date_format' => ':attribute không đúng định dạng :format.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải gồm :digits chữ số.',
    'digits_between' => ':attribute phải có từ :min đến :max chữ số.',
    'dimensions' => ':attribute có kích thước ảnh không hợp lệ.',
    'distinct' => ':attribute có giá trị trùng lặp.',
    'email' => ':attribute phải là địa chỉ email hợp lệ.',
    'exists' => ':attribute đã chọn không hợp lệ.',
    'file' => ':attribute phải là một tập tin.',
    'filled' => ':attribute không được để trống.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobyte.',
        'string' => ':attribute phải dài hơn :value ký tự.',
        'array' => ':attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobyte.',
        'string' => ':attribute phải dài hơn hoặc bằng :value ký tự.',
        'array' => ':attribute phải có tối thiểu :value phần tử.',
    ],
    'image' => ':attribute phải là hình ảnh.',
    'in' => ':attribute đã chọn không hợp lệ.',
    'in_array' => ':attribute không tồn tại trong :other.',
    'integer' => ':attribute phải là số nguyên.',
    'ip' => ':attribute phải là địa chỉ IP hợp lệ.',
    'ipv4' => ':attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là địa chỉ IPv6 hợp lệ.',
    'json' => ':attribute phải là chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobyte.',
        'string' => ':attribute phải ngắn hơn :value ký tự.',
        'array' => ':attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobyte.',
        'string' => ':attribute phải ngắn hơn hoặc bằng :value ký tự.',
        'array' => ':attribute không được có nhiều hơn :value phần tử.',
    ],
    'max' => [
        'numeric' => ':attribute không được lớn hơn :max.',
        'file' => ':attribute không được lớn hơn :max kilobyte.',
        'string' => ':attribute không được dài hơn :max ký tự.',
        'array' => ':attribute không được có nhiều hơn :max phần tử.',
    ],
    'mimes' => ':attribute phải là tập tin có định dạng: :values.',
    'mimetypes' => ':attribute phải là tập tin có định dạng: :values.',
    'min' => [
        'numeric' => ':attribute phải tối thiểu :min.',
        'file' => ':attribute phải tối thiểu :min kilobyte.',
        'string' => ':attribute phải có ít nhất :min ký tự.',
        'array' => ':attribute phải có ít nhất :min phần tử.',
    ],
    'not_in' => ':attribute đã chọn không hợp lệ.',
    'not_regex' => 'Định dạng của :attribute không hợp lệ.',
    'numeric' => ':attribute phải là số.',
    'present' => ':attribute phải được cung cấp.',
    'regex' => 'Định dạng của :attribute không hợp lệ.',
    'required' => ':attribute là bắt buộc.',
    'required_if' => ':attribute là bắt buộc khi :other là :value.',
    'required_unless' => ':attribute là bắt buộc trừ khi :other thuộc :values.',
    'required_with' => ':attribute là bắt buộc khi :values xuất hiện.',
    'required_with_all' => ':attribute là bắt buộc khi tất cả :values xuất hiện.',
    'required_without' => ':attribute là bắt buộc khi :values không xuất hiện.',
    'required_without_all' => ':attribute là bắt buộc khi không có giá trị nào trong :values xuất hiện.',
    'same' => ':attribute và :other phải giống nhau.',
    'size' => [
        'numeric' => ':attribute phải bằng :size.',
        'file' => ':attribute phải có dung lượng :size kilobyte.',
        'string' => ':attribute phải có :size ký tự.',
        'array' => ':attribute phải chứa :size phần tử.',
    ],
    'starts_with' => ':attribute phải bắt đầu bằng một trong các giá trị: :values',
    'string' => ':attribute phải là chuỗi ký tự.',
    'timezone' => ':attribute phải là múi giờ hợp lệ.',
    'unique' => ':attribute đã được sử dụng.',
    'uploaded' => 'Tải lên :attribute thất bại.',
    'url' => 'Định dạng :attribute không hợp lệ.',
    'uuid' => ':attribute phải là UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Dòng ngôn ngữ xác thực tùy chỉnh
    |--------------------------------------------------------------------------
    |
    | Tại đây bạn có thể định nghĩa thông báo tùy chỉnh cho từng thuộc tính
    | theo cú pháp "attribute.rule". Điều này giúp bạn nhanh chóng tạo ra
    | dòng ngôn ngữ dành riêng cho một quy tắc xác thực cụ thể.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'thông-báo-tùy-chỉnh',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tùy chỉnh tên thuộc tính
    |--------------------------------------------------------------------------
    |
    | Các dòng sau được dùng để thay thế placeholder của thuộc tính bằng một
    | tên thân thiện hơn như "Địa chỉ email" thay vì "email". Điều này giúp
    | thông báo trở nên dễ hiểu hơn.
    |
    */

    'attributes' => [],

];
