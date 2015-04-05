<?php

class UsersController extends AppController {
    public $name = 'Users';
    public $uses = "User";
    
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {

    }



    public function success() {
    	// 本当はモデルに書いてね！　start
        $oauth_token = $this->Auth->user("oauth_token");
    	$params = array(
    		"conditions" => array(
    			"User.oauth_token" => $oauth_token
			)
		);
		$user_data = $this->User->find("all", $params);
		$this->set("user_data", $user_data);
    }
}

?>