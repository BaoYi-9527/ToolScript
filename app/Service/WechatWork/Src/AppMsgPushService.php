<?php


namespace App\Service\WechatWork\Src;


use App\Service\WechatWork\WechatWorkException;
use GuzzleHttp\Exception\GuzzleException;

class AppMsgPushService extends BaseService
{
    protected int $appId;

    public function __construct($appId = 0, $corpSecret = '')
    {
        $corpSecret  = $corpSecret ?: config('wechat.work.default_app_secret');
        $this->appId = $appId ?: (int) config('wechat.work.default_app_id');
        if (empty($corpSecret)) throw new WechatWorkException(
            'The configuration of [default_app_secret] is not configured or app secret is not defined.'
        );
        parent::__construct($corpSecret);
    }

    /**
     * 发送应用消息
     * @param $json
     * @return mixed
     * @throws WechatWorkException
     * @throws GuzzleException
     */
    public function msgSend($json): mixed
    {
        $uri = '/cgi-bin/message/send?access_token=' . $this->accessToken;
        return $this->httpPost($uri, $json);
    }

    /**
     * @param $textContent
     * @param array $toUser
     * @param array $toParty
     * @param array $toTag
     * @return mixed
     * @throws GuzzleException
     * @throws WechatWorkException
     */
    public function textMsgSend($textContent, array $toUser = [], array $toParty = [], array $toTag = []): mixed
    {
        if (empty($toUser) && empty($toParty) && empty($toTag)) {
            throw new WechatWorkException('The params of [toUser] or [toParty] or [toTag] cant be empty together.');
        }

        $json = [
            'touser'  => implode('|', $toUser),
            'toparty' => implode('|', $toParty),
            'totag'   => implode('|', $toTag),
            'msgtype' => 'text',
            'agentid' => $this->appId,
            'text'    => [
                'content' => $textContent
            ],
        ];
        return $this->msgSend($json);
    }


}
