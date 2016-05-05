<?php

App::uses('TwitterLoginAppController', 'TwitterLogin.Controller');
App::import('Vendor', 'TwitterLogin.twitteroauth/OAuth');
App::import('Vendor', 'TwitterLogin.twitteroauth/twitteroauth');

// Twitters Controller
class TwittersController extends TwitterLoginAppController {

  public $autoRender = false;
  public $uses = 'User';
  public $helpers = array('Html','Form','Session');

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
    
    if ($connection->http_code) {
      $url = $connection->getAuthorizeURL($request_token['oauth_token']);
      $this->redirect($url);
    } else {
      $this->redirect('/twitter_login/users');
    }
  }
  
  public function callback() {
    CakeSession::start();
    $connection = new TwitterOAuth(
      CONSUMER_KEY,
      CONSUMER_SECRET,
      $this->Session->read('oauth_token'),
      $this->Session->read('oauth_token_secret')
    );
  
    $this->Session->delete('oauth_token');
    $this->Session->delete('oauth_token_secret');
  
    $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
    // ユーザーの名前とアイコンを取得
    $content = $connection->get('account/verify_credentials');
    $content = (array)$content;
  
    if (!$this->check_exist_user($access_token)) $this->create_user($access_token, $content);
    
    $user_data = array(
      'oauth_token' => $access_token['oauth_token'],
      'oauth_token_secret' => $access_token['oauth_token_secret']
    );
  
    $redirect_url = $this->Auth->login($user_data) ? '/success' : '/';
    $this->redirect('/twitter_login/users' . $redirect_url);
  }


  private function check_exist_user($access_token) {
    $params = array(
      'conditions' => array(
        'oauth_token' => $access_token['oauth_token']
      )
    );
    return $this->User->find('first', $params) ? true : false;
  }

  private function create_user($access_token, $content) {
    $data = array(
      'User' => array(
        'twitter_id' => $access_token['user_id'],
        'account' => $access_token['screen_name'],
        'username' => $content['name'],
        'image' => $content['profile_image_url'],
        'oauth_token' => $access_token['oauth_token'],
        'oauth_token_secret' => $access_token['oauth_token_secret']
      )
    );
    $this->User->save($data);
  }
}
