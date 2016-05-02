<?php

App::import('Vendor', 'twitteroauth/OAuth');
App::import('Vendor', 'twitteroauth/twitteroauth');

class TwittersController extends AppController {
    public $name = 'Twitters';
    public $autoRender = false;
    public $uses = "User";
    public $component = array('Auth', 'Html', 'Session');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('redirect_twitter','callback'));
    }

    public function redirect_twitter() {
        CakeSession::start();
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

        $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
        $this->Session->write('oauth_token', $request_token['oauth_token']);
        $this->Session->write('oauth_token_secret', $request_token['oauth_token_secret']);

        //エラー処理
        if ($connection->http_code) {
            $url = $connection->getAuthorizeURL($request_token['oauth_token']);
            $this->redirect($url);
        } else {
            $this->redirect('/');
        }
    }

    // アクセストークンを取得（登録とログインを含む）
    public function callback() {
    	CakeSession::start();
    	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->Session->read('oauth_token'), $this->Session->read('oauth_token_secret'));

    	//セッションからリクエストトークンを削除
        $this->Session->delete('oauth_token');
        $this->Session->delete('oauth_token_secret');

        //アクセストークンを取得
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
        // ユーザーの名前とアイコンを取得
        $content = $connection->get('account/verify_credentials');
        $content = (array)$content;

        // 本当はモデルに書いてね！　start
        $params = array(
        	"conditions" => array(
        		"User.oauth_token" => $access_token['oauth_token']
        	)
        );
        $user_data = $this->User->find("first", $params);
        // 未登録であれば、登録開始
        if (!$user_data) {
        	$user_data = array(
        		"User" => 
        		array(
	        		"twitter_id" => $access_token["user_id"],
	        		"account" => $access_token["screen_name"],
	        		"username" => $content["name"],
	        		"image" => $content["profile_image_url"],
					'oauth_token' => $access_token['oauth_token'],
					'oauth_token_secret' => $access_token['oauth_token_secret']
	        	)
        	);
        	$this->User->save($user_data);
        }
        // end
        
        // ログイン
        $this->request->data['User'] = $user_data;

        if ($this->Auth->login($this->request->data['User'])) {
        	$this->redirect("/users/success");
        }
    }
}

?>