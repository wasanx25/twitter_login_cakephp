<?php

App::uses('AppController', 'Controller');

class TwitterLoginAppController extends AppController {
  public $components = array(
    'Session',
    'Auth' => array(
      'authenticate' => array(
        'Form' => array(
          'userModel' => 'User',
          'passwordHasher' => array(
            'className' => 'None'
          ),
          'fields' => array(
            'username' => 'oauth_token',
            'password'=>'oauth_token_secret'
          ),
        ),
      ),
      'loginError' => 'パスワードもしくはログインIDをご確認下さい。',
      'authError' => 'ご利用されるにはログインが必要です。',
      'loginAction' => array('controller' => 'users', 'action' => 'index'),
      'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
      'logoutRedirect' => array('controller' => 'users', 'action' => 'index')
    )
  );
  
}
