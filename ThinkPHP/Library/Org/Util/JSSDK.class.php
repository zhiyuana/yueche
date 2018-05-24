<?php
namespace Org\Util;
class JSSDK {
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    Session_Start();
    $this->appId = "wx2cfe4d46abc10bb1";
    $this->appSecret = "c54be69b9ad1a763eaa247e8f0f5a2ee";
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );

    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
     $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $time = time();
        $list = $Model->query("select token,time from wp_weixin_access where id = 1 and time > ".$time);
        if($list){
          $accessToken = $list[0]['token'];
        }else{
         $accessToken = $this->getAccessToken();
        }

        $list = $Model->query("select ticket,time from wp_weixin_ticket where id = 1 and time > ".$time);
        if($list){
          $ticket = $list[0]['ticket'];
        }else{
          // 如果是企业号用以下 URL 获取 ticket
        // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
         $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
         $res = json_decode($this->httpGet($url));
         $ticket = $res->ticket;
         $time = time() + 7000;
         $Model->execute("update wp_weixin_ticket set ticket = '".$ticket."',time = '".$time."' where id = 1");
        }
          // var_dump($ticket);DIE;
    return $ticket;
  }

  private function getAccessToken() {
     $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
          $time = time() + 7000;
          $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
          $res = json_decode($this->httpGet($url));
          $access_token = $res->access_token;
          $Model->execute("update wp_weixin_access set token = '".$access_token."',time = '".$time."' where id = 1");
      return $access_token;
  }

  private function httpGet($url) {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    // var_dump($res);die;
    curl_close($res);

    return $res;
  }

  private function get_php_file($filename) {
    return trim(substr(file_get_contents($filename), 15));
  }
  private function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
  }
}

