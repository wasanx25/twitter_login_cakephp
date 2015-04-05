
# twLogin
cakephpによるtwitterログインのテンプレート

ここにはないけど、app/Config/core.phpに
「Consumer Key」と「Consumer Secret」と「Callback URL」を設定する。

`define('CONSUMER_KEY', 'Consumer Key');  
define('CONSUMER_SECRET', 'Consumer Secret');  
define('OAUTH_CALLBACK', 'Callback URL');`  

データベース構造は以下のような感じ

  `CREATE TABLE IF NOT EXISTS "users" (
  "id" int(11) NOT NULL AUTO_INCREMENT,
  "twitter_id" int(11) NOT NULL,
  "account" varchar(255) NOT NULL,
  "username" varchar(255) NOT NULL,
  "image" varchar(255) NOT NULL,
  "oauth_token" varchar(128) NOT NULL,
  "oauth_token_secret" varchar(128) NOT NULL,
  "created" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  "modified" timestamp NOT NULL,
  PRIMARY KEY ("id")
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;`
