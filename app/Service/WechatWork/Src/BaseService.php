<?php


namespace App\Service\WechatWork\Src;


use App\Service\WechatWork\WechatWorkException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class BaseService
{
    private string   $corpSecret;
    private string   $corpId;
    protected Client $client;
    protected string $accessToken;

    /**
     * AccessTokenService constructor.
     * @param $corpSecret
     * @param string $corpId
     * @throws GuzzleException
     * @throws WechatWorkException
     */
    public function __construct($corpSecret, string $corpId = '')
    {
        $this->corpSecret = $corpSecret;
        $this->corpId     = $corpId ?: config('wechat.work.corp_id');

        $this->client = new Client([
            'base_uri' => 'https://qyapi.weixin.qq.com',
            'timeout'  => 30,
            'verify'   => false
        ]);

        $this->requestAccessToken();
    }

    /**
     * GET 请求
     * @param $uri
     * @param array $query
     * @return mixed
     * @throws GuzzleException
     * @throws WechatWorkException
     */
    public function httpGet($uri, array $query = []): mixed
    {
        $response = $this->client->request('GET', $uri, [
            'query' => $query
        ]);

        $response = json_decode($response->getBody()->getContents(), true);
        if (isset($response['errcode']) && $response['errcode'] != 0) {
            throw new WechatWorkException($response['errmsg'] ?? "{$uri} request failed", $response['errcode']);
        }

        return $response;
    }

    /**
     * POST 请求
     * @param $uri
     * @param array $json
     * @return mixed
     * @throws GuzzleException
     * @throws WechatWorkException
     */
    public function httpPost($uri, array $json = []): mixed
    {
        $response = $this->client->request('POST', $uri, [
            'json' => $json
        ]);

        $response = json_decode($response->getBody()->getContents(), true);
        if (isset($response['errcode']) && $response['errcode'] != 0) {
            throw new WechatWorkException($response['errmsg'] ?? "{$uri} request failed", $response['errcode']);
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * set client
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 获取 access_token
     * @param bool $cache
     * @throws WechatWorkException|GuzzleException
     */
    protected function requestAccessToken(bool $cache = true)
    {
        $cacheKey = 'wechat:access_token:'.md5($this->corpSecret);
        if ($cache && Cache::has($cacheKey)) {
            $this->accessToken = Cache::get($cacheKey);
        } else {
            $this->getAccessTokenFromServer($cacheKey);
        }
    }

    /**
     * 获取服务端的 access_token
     * @param $cacheKey
     * @throws WechatWorkException|GuzzleException
     */
    private function getAccessTokenFromServer($cacheKey)
    {
        $response = $this->httpGet('/cgi-bin/gettoken', [
            'corpid'     => $this->corpId,
            'corpsecret' => $this->corpSecret
        ]);

        Cache::put($cacheKey, $response['access_token'], $response['expires_in'] - 60);
        $this->accessToken = $response['access_token'];
    }
}
