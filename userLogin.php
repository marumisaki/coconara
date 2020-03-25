<?php 

//共通変数・関数ファイルを読込み
require('function.php');

debug('==========');
debug('ユーザーログイン');
debug('==========');
debugLogStart();


//ログイン認証
require('userAuth.php');

require_once 'common.php';
require_once "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


//TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

//コールバックURLをここでセット
$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
debug('$request_token:'.print_r($request_token, true));
//callback.phpで使うのでセッションに入れる
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
debug('oauth_token'.print_r ($_SESSION['oauth_token'],true));
debug('oauth_token_secret'.print_r($_SESSION['oauth_token_secret'],true));

//Twitter.com 上の認証画面のURLを取得( この行についてはコメント欄も参照 )
$oauthUrl = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));
debug('UL $oauthUrl:'.$oauthUrl);

?>

<?php
	$siteTitle = 'ユーザーログイン';
	require('head.php'); 
?>

<body class="">

<!-- メニュー -->
<?php
	require('header.php'); 
?>

 <!-- メインコンテンツ -->
<section class="login container">
	<div class="panel--blue panel--entry u-width-40 u-radius__m">
		<img src="img/star.png" alt="">
		<h1 class="text--3l u-white">ログイン</h1>
		<p class="text--def u-white">レビュー投稿にはログインが必要です！<br>
		※ログインはTwitterのみです</p>
		<button class="button button--yellow  u-mt_5l u-width-60">
			<a href="<?php echo $oauthUrl; ?>" class="text--l u-block u-center ">Twitterでログイン</a>
		</button>
	</div>
</section>

<?php
	require('footer.php'); 
?>