<?php

namespace App\Service\WechatWork\Config;

class Wechat
{
    const DEFAULT_RETRY_TIMES = 3;

    const SUCCESS              = 0;
    const INVALID_ACCESS_TOKEN = 40014; # invalid access token
}
