
# twitter_login_cakephp
twitter login for cakephp plugin
Acknowledgement: テスト書かなくてすいません。。。

## use
require
cakephp2.*

setting
https://apps.twitter.com/

at app/Plugin
```
git clone git://github.com/wataru0225/twitter_login_cakephp.git TwitterLogin
```
or at app
```
git submodule add git://github.com/wataru0225/twitter_login_cakephp.git TwitterLogin
git submodule init
git submodule update
```

write core.php 
```
define('CONSUMER_KEY', 'Twitter Consumer Key');
define('CONSUMER_SECRET', 'Twitter Consumer Secret');
define('OAUTH_CALLBACK', 'Twitter Callback URL');
```  

write bootstrap.php
```
CakePlugin::load('TwitterLogin', array('bootstrap' => false, 'routes' => false));
```

execute mysql query
```
CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT,
  twitter_id int(11) NOT NULL,
  account varchar(255) NOT NULL,
  username varchar(255) NOT NULL,
  image varchar(255) NOT NULL,
  oauth_token varchar(128) NOT NULL,
  oauth_token_secret varchar(128) NOT NULL,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  modified timestamp NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;
```

access
```
http://{your_url}/twitter_login/users
```
