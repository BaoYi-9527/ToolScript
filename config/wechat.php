<?php

return [
    // 企业微信
    'work' => [
        'corp_id'             => env('WECHAT_WORK_CROP_ID', ''),  # 企业微信企业ID
        'address_book_secret' => env('WECHAT_WORK_ADDRESS_BOOK_SECRET', ''),    # 通讯录秘钥,
        'default_app_secret'  => env('WECHAT_WORK_DEFAULT_APP_SECRET', ''), # 默认的企业自建应用秘钥
        'default_app_id'      => env('WECHAT_WORK_DEFAULT_APP_ID', 0), # 默认的企业自建应用ID
    ]
];
