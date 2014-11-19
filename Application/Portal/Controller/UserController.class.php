<?php

/**
 * 三方登录
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;
use Org\Util\Date;
use Admin\Model\CreditModel;

class UserController extends HomeBaseController {
    public function login() {
    	$type = I('get.type');
        if($type == 'qq') {
            $appkey = C('OAUTH.QQ_APPKEY');
            $scope = C('OAUTH.QQ_SCOPE');
            $callback = C('OAUTH.QQ_CALLBACK');
            $qq = new \Common\Lib\ORG\QQConnect();
            $qq->login($appkey, $callback, $scope);
        } else if($type == 'weibo') {
            $appkey = C('OAUTH.WEIBO_APPKEY');
            $scope = C('OAUTH.WEIBO_SCOPE');
            $callback = C('OAUTH.WEIBO_CALLBACK');
            $weibo = new \Common\Lib\ORG\WeiboConnect();
            $weibo->login($appkey, $callback, $scope);
        } else {
            $this->error('无效的登录类型！');
        }
    }

    public function auth() {
        $type = I('get.type');
        if($type == 'qq') {
            $appkey = C('OAUTH.QQ_APPKEY');
            $appsecretkey = C('OAUTH.QQ_APPSECRETKEY');
            $callback = C('OAUTH.QQ_CALLBACK');
            $qq = new \Common\Lib\ORG\QQConnect();
            $info = $qq->callback($appkey, $appsecretkey, $callback);
            if($info=='get token or openid error!'){
                $this->redirect('/Portal/user/login', array('type' => 'qq'));
            }
            $user = $qq->get_user_info($info['token'], $info['openid'], $appkey);
            $this->auths($info['openid'],$user,$type);
        } else if($type == 'weibo') {
            $appkey = C('OAUTH.WEIBO_APPKEY');
            $appsecretkey = C('OAUTH.WEIBO_APPSECRETKEY');
            $callback = C('OAUTH.WEIBO_CALLBACK');
            $weibo = new \Common\Lib\ORG\WeiboConnect();
            $info = $weibo->callback($appkey, $appsecretkey, $callback);
            if($info=='get token or openid error!'){
                $this->redirect('/Portal/user/login', array('type' => 'weibo'));
            }
            $user = $weibo->get_user_info($info['token'], $info['openid']);
            $this->auths($info['openid'],$user,$type);
        } else {
            $this->error('无效的回调类型！');
        }
        $this->assign('face', $user['figureurl_1'] ? $user['figureurl_1'] : $user['avatar_large']);
        $this->assign('nickname', $user['nickname'] ? $user['nickname'] : $user['screen_name']);
        $this->assign('type', $type == 'qq' ? 'QQ号码' : '微博帐号');
        $this->display();
    }

    //发送验证码
    public function sendPhone(){
        if(IS_POST){
            $phone = I('post.mobile');
            // 随机码
            $code = rand ( 100000, 999999 );
            $openid = session('openid');
            $result = M('Auth')->where("openid='%s'",array($openid))->save(array('mobile'=>$phone,'code'=>$code));
            if($result){
                if ($this->sendMESSAGES ( $phone, '【' . C ( 'SENDSMS' ) . '】您的验证码为：' . $code )) {
                    session ( 'mobile-code', $code );
                    $this->success ();
                } else {
                    session ( 'mobile-code', null );
                    $this->error ();
                }
            }else{
                $this->error ();
            }
        }
    }

    //提交
    public function submit(){
        $openid = session('openid');
        if($openid==''){
            $this->redirect('/Portal/Member/index');
        }

        $auth = M('Auth');
        $result = $auth->where("openid='%s'",array($openid))->find();
        if(empty($result) || $result['uid']>0){
            $this->redirect('/Portal/Member/index');
        }

        $_info = M('Members')->where("user_login_name='%s'",array(I('post.nike')))->find();

        if(!empty($_info)){
            $auth->where("openid='%s'",array($openid))->save(array('uid'=>$_info['ID']));
        }else{
            $data['user_tel'] = $result['mobile'];
            $data['create_time'] = time();
            $data['user_login_name'] = I('post.nike');
            $data['group'] = 2;
            $data['type'] = 'personal';
            $data['last_login_time'] = time();
            $data['last_login_ip'] = get_client_ip();
            $ids = M('Members')->add($data);
            $auth->where("openid='%s'",array($openid))->save(array('uid'=>$ids));
        }

        $uid = $_info['ID'] ? $_info['ID'] : $ids;

        $this->logins($uid);
    }

    //读取
    protected function auths($openid,$info,$type){
        $auth = M('Auth');
        
        $result = $auth->where("openid='%s'",array($openid))->find();
        //是否存在
        if(!empty($result)){
            //更新
            $auth->where("openid='%s'",array($openid))->save(array(
                    'data' => serialize($info),
                    'dateline' => time()
                ));

            //是否绑定
            if($result['uid']){
                $this->logins($result['uid']);
            }
        }else{
            $auth->add(array(
                    'type' => $type,
                    'openid' => $openid,
                    'data' => serialize($info),
                    'dateline' => time()
                ));
        }

        //
        session('openid',$openid);
    }

    protected function logins($uid){
        //登录
        $_info = M ( 'Members' )->where ("ID=%d",array($uid))->find();

        $_SESSION ["MEMBER_type"] = 'local';
        $_SESSION ["MEMBER_id"] = $_info ["ID"];
        $_SESSION ['MEMBER_name'] = $_info ["user_login_name"];
        session ( "roleid", $_info ['role_id'] );
        session ( "type", $_info ['type'] );
        session ( "score", $_info ['score'] );
        session ( "redcoin", $_info ['redcoin'] );
        // 写入此次登录信息
        $data = array (
                'last_login_time' => time (),
                'last_login_ip' => get_client_ip () 
        );
        M ( 'Members' )->where ( array (
                '' => $_info ["ID"] 
        ) )->save ( $data );

        session ('mobile-code', null );
        session('openid', null );

        $this->redirect('/Portal/xdal/index', array('menu_id' => 2));
    }
}