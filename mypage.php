<?php
require('function.php');

debug('==========');
debug('ユーザーログイン認証ページ　');
debug('==========');
debugLogStart();

require_once 'common.php';
require_once "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

//セッションに入れておいたさっきの配列
$access_token = $_SESSION['access_token'];

//OAuthトークンとシークレットも使って TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

//ユーザー情報をGET
$user = $connection->get('account/verify_credentials');
//(ここらへんは、Twitter の API ドキュメントをうまく使ってください)

//ユーザ情報を取得
$t_id = $user->id;
$screen_name = $user->screen_name;
$u_name = $user->name;
$description= $user->description;
$pic = $user->profile_image_url_https;
// こんな感じで必要な情報を変数にいれたり、
//  各値をセッションに入れたりします。
$_SESSION['t_id'] = $t_id;
$_SESSION['screen_name'] = $screen_name;
$_SESSION['name'] = $u_name;
$_SESSION['description'] = $description;
$_SESSION['profile_image_url_https'] = $pic;

debug('MP $t_id：'.print_r($t_id,true));
debug('MP $screen_name：'.print_r($screen_name,true));
debug('MP $u_name：'.print_r($u_name,true));
debug('MP $description：'.print_r($description,true));
debug('MP $pic：'.print_r($pic,true));
$dbh = dbConnect();
$result = validTidDup($dbh,$t_id);

if(empty($result)){
	debug('$t_idがない');
	//例外処理
	try{
		// DBへ接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'INSERT INTO u_profile (u_name,description,pic,t_id,screen_name,login_time,create_date) VALUES (:u_name,:description,:pic,:t_id,:screen_name,:login_time,:create_date)';
		$data = array(':u_name'=>$u_name,':description'=>$description,':pic'=>$pic,':t_id'=>$t_id,':screen_name' => $screen_name,':login_time' => date('Y-m-d H:i:s'),':create_date' => date('Y-m-d H:i:s'));
		
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		// クエリ成功の場合
		if($stmt){
			//ログイン有効期限（デフォルトを１時間とする）
			$sesLimit = 60*60;
			// 最終ログイン日時を現在日時に
			$_SESSION['login_date'] = time();
			$_SESSION['login_limit'] = $sesLimit;
			// ユーザーIDを格納
			$_SESSION['u_id'] = $dbh->lastInsertId();

			debug('セッション変数の中身：'.print_r($_SESSION,true));
			header("Location:schoolList.php"); //マイページへ
		}else{
			debug('mypage:クエリに失敗しました。');
		}
	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
		$err_msg['common'] = MSG07;
	}
}else{
	debug('$t_idがある！');
	try{
		// DBへ接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'UPDATE u_profile SET login_time = :login_time WHERE t_id = :t_id';
		$data = array(':login_time' => date('Y-m-d H:i:s'),':t_id' =>$_SESSION['t_id']);
		
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		// クエリ成功の場合
		if($stmt){
			//ログイン有効期限（デフォルトを１時間とする）
			$sesLimit = 60*60;
			// 最終ログイン日時を現在日時に
			$_SESSION['login_date'] = time();
			$_SESSION['login_limit'] = $sesLimit;
			// ユーザーIDを格納
			$_SESSION['u_id'] = $result['id'];
			unset($_SESSION['c_id']);

			debug('セッション変数の中身：'.print_r($_SESSION,true));
			header("Location:schoolList.php"); //マイページへ
		}else{
			debug('mypage:クエリに失敗しました。');
		}

	} catch (Exception $e) {
		error_log('エラー発生:' . $e->getMessage());
		$err_msg['common'] = MSG07;
	}
}




