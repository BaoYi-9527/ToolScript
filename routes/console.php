<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

# php artisan test
Artisan::command('test', function () {

    $appMsgPushService = new \App\Service\WechatWork\Src\AppMsgPushService();
    $res = $appMsgPushService->textMsgSend('hello world!', ['XXX']);
    dd($res);

    $accessTokenService = new \App\Service\WechatWork\Src\AddressBookService();
//    $res = $accessTokenService->getUserListId();    # ZhangWeiCheng
    $res = $accessTokenService->getUserInfo('XXX');
    dd($res);

});
