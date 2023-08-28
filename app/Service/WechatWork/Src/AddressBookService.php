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

    /**
     * @param string $cursor
     * @param int $limit
     * @return mixed
     * @throws GuzzleException
     * @throws WechatWorkException
     */
    public function getUserIdList(string $cursor = '', int $limit = 10000): mixed
    {
        $uri  = '/cgi-bin/user/list_id?access_token=' . $this->accessToken;
        $body = $this->httpPost($uri, [
            'cursor' => $cursor,
            'limit'  => $limit
        ]);

        return $body['dept_user'];
    }





}
