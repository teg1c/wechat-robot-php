<?php

use GuzzleHttp\Exception\GuzzleException;

/**
 * wechat-robot-php.
 * Author: tegic
 * Email: teg1c@foxmail.com
 * Date: 2020/12/31
 */
class Wechat
{
    const HEART_BEAT = 5005;
    const RECV_TXT_MSG = 1;
    const RECV_PIC_MSG = 3;
    const USER_LIST = 5000;
    const GET_USER_LIST_SUCCESS = 5001;
    const GET_USER_LIST_FAIL = 5002;
    const TXT_MSG = 555;
    const PIC_MSG = 500;
    const AT_MSG = 550;
    const CHATROOM_MEMBER = 5010;
    const CHATROOM_MEMBER_NICK = 5020;
    const PERSONAL_INFO = 6500;
    const DEBUG_SWITCH = 6000;
    const PERSONAL_DETAIL = 6550;

    protected $url = 'http://127.0.0.1:5555';

    public function __construct($url = null)
    {
        $url && $this->url = $url;
    }

    /**
     * 获取好友和群列表
     * @return array|bool|float|int|object|string|null
     * @throws GuzzleException
     */
    public function getContactList()
    {
        $url = '/api/getcontactlist';
        return $this->request($url);
    }

    /**
     * 发送文本消息
     * @param $wxid
     * @param $content
     * @return array|bool|float|int|object|string|null
     * @throws GuzzleException
     */
    public function sendTxt($wxid, $content)
    {
        $url = '/api/sendtxtmsg';
        $headers = [
            'query' => [
                'id' => $this->getId(),
                'type' => self::TXT_MSG,
                'content' => $content,
                'wxid' => $wxid,
            ]
        ];
        return $this->request($url, $headers);
    }

    private function getId()
    {
        return time();
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $headers
     * @return array|bool|float|int|object|string|null
     * @throws GuzzleException
     */
    public function request(string $url, array $headers = [], string $method = 'GET')
    {
        try {
            $response = $this->client()->request($method, $url, $headers);
        } catch (Throwable $e) {
            return [
                'status' => 'Error',
                'content' => $e->getMessage()];
        }
        $content = $response->getBody()->getContents();
        return \GuzzleHttp\json_decode($content, true);
    }

    private function client()
    {
        return new \GuzzleHttp\Client([
            'base_uri' => $this->url,
            'timeout' => 2.0
        ]);
    }
}