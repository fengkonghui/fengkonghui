<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://2le.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace Common\Lib\ORG;
class QQConnect {

    private function get_access_token($appkey, $appsecretkey, $code, $callback, $state) {
        if($state == $_SESSION['state']) {
            $url = "https://graph.qq.com/oauth2.0/token";
            $param = array(
                "grant_type"    =>    "authorization_code",
                "client_id"     =>    $appkey,
                "client_secret" =>    $appsecretkey,
                "code"          =>    $code,
                "state"         =>    $state,
                "redirect_uri"  =>    $callback
            );

            $response = get($url, $param);
            if($response == false) {
                return false;
            }
            $params = array();
            parse_str($response, $params);
            return $params["access_token"];
        } else {
            exit("The state does not match. You may be a victim of CSRF.");
        }
    }

    private function get_openid($access_token) {
        $url = "https://graph.qq.com/oauth2.0/me"; 
        $param = array(
            "access_token"    => $access_token
        );

        $response  = get($url, $param);
        if($response == false) {
            return false;
        }
        if (strpos($response, "callback") !== false) {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if (isset($user->error) || $user->openid == "") {
            return false;
        }
        return $user->openid;
    }

    public function get_user_info($token, $openid, $appkey, $format = "json") {
        $url = "https://graph.qq.com/user/get_user_info";
        $param = array(
            "access_token"      =>    $token,
            "oauth_consumer_key"=>    $appkey,
            "openid"            =>    $openid,
            "format"            =>    $format
        );

        $response = get($url, $param);
        if($response == false) {
            return false;
        }

        $user = json_decode($response, true);
        return $user;
    }

    public function login($appkey, $callback, $scope='') {
        $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
        $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
            . $appkey . "&redirect_uri=" . urlencode($callback)
            . "&state=" . $_SESSION['state']
            . "&scope=".$scope;
        redirect($login_url);
    }

    public function callback($appkey, $appsecretkey, $callback) {
        $code = $_GET['code'];
        $state = $_SESSION['state'];

        $token = $this->get_access_token($appkey, $appsecretkey, $code, $callback, $state);
        $openid = $this->get_openid($token);
        if(!$token || !$openid) {
            return 'get token or openid error!';
            // exit('get token or openid error!');
        }

        return array('openid' => $openid, 'token' => $token);
    }

}
