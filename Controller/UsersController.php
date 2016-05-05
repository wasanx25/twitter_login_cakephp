<?php

App::uses('TwitterLoginAppController', 'TwitterLogin.Controller');

// Users Controller
class UsersController extends TwitterLoginAppController {
  public $name = 'Users';
  public $uses = 'User';
  
  public function index() {}
  
  public function success() {
    $user = $this->Auth->user();

  	$params = array(
  		'conditions' => array(
  			'User.oauth_token' => $user['User']['oauth_token'];
      )
    );
    $user_data = $this->User->find('all', $params);
    $this->set('user_data', $user_data);
  }
}

?>
