<?php
/**
 * wechat-robot-php.
 * Author: tegic
 * Email: teg1c@foxmail.com
 * Date: 2020/12/30
 */
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/Wechat.php';

$url = "http://127.0.0.1:5555";
$wechat = new Wechat($url);
echo "<pre>";
print_r($wechat->getContactList());
print_r($wechat->sendTxt('filehelper','test msg'));
