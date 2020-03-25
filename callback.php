<?php

require('function.php');

require_once 'common.php';
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

//userLogin.phpでセットしたセッション
$request_token = [];  // [] は array() の短縮記法。詳しくは以下の「追々記」参照
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
debug('cb $_SESSION：'.print_r($_SESSION,true));
//Twitterから返されたOAuthトークンと、あらかじめuserLogin.phpで入れておいたセッション上のものと一致するかをチェック
if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
	debug('cb $_REQUEST：'.print_r($_REQUEST,true));
	debug('cb $request_token：'.print_r($request_token,true));
    var_dump($_REQUEST);
    var_dump($request_token);
    die( 'Error!' );
}
//OAuth トークンも用いて TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
debug('$connection'.print_r($connection));

//アプリでは、access_token(配列になっています)をうまく使って、Twitter上のアカウントを操作していきます
$_SESSION['access_token'] = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
/*
ちなみに、この変数の中に、OAuthトークンとトークンシークレットが配列となって入っています。
*/
debug('CB $_SESSION：'.print_r($_SESSION['access_token'],true));
//セッションIDをリジェネレート
session_regenerate_id();

//マイページへリダイレクト
header('location:mypage.php');
