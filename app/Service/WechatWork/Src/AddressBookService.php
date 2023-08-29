<?php


namespace App\Service\WechatWork\Src;


use App\Service\WechatWork\WechatWorkException;
use GuzzleHttp\Exception\GuzzleException;

class AddressBookService extends BaseService
{
    public function __construct()
    {
        $corpSecret = config('wechat.work.address_book_secret');
        if (empty($corpSecret)) throw new WechatWorkException('The configuration of [address_book_secret] is not configured.');
        parent::__construct($corpSecret);
    }

//    /**
//     * 读取成员[已停用]
//     * @param $userId
//     * @return mixed
//     * @throws GuzzleException
//     * @throws WechatWorkException
//     */
//    public function getUserInfo($userId): mixed
//    {
//        return $this->httpGet('/cgi-bin/user/get', [
//            'access_token' => $this->accessToken,
//            'userid'       => $userId
//        ]);
//    }

    /**
     * 获取成员列ID列表
     * @param string $cursor
     * @param int $limit
     * @return mixed
     * @throws GuzzleException
     * @throws WechatWorkException
     */
    public function getUserListId(string $cursor = '', int $limit = 10000): mixed
    {
        $uri  = '/cgi-bin/user/list_id?access_token=' . $this->accessToken;
        $body = $this->httpPost($uri, [
            'cursor' => $cursor,
            'limit'  => $limit
        ]);

        return $body['dept_user'];
    }





}
