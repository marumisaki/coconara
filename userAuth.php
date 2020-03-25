<?php

//================================
// ユーザーログイン認証・自動ログアウト
//================================

//ユーザーの場合
if( !empty($_SESSION['u_id'])){
	// ログインしている場合
	if( !empty($_SESSION['login_date']) ){
		debug('ログイン済みユーザーです。');
		// 現在日時が最終ログイン日時＋有効期限を超えていた場合
		if( ($_SESSION['login_date'] + $_SESSION['login_limit']) < time()){
			debug('ログイン有効期限オーバーです。');
			// セッションを削除（ログアウトする）
			session_destroy();
			// ログインページへ
			header("Location:userLogin.php");
		}else{
			debug('ログイン有効期限以内です。');
			//最終ログイン日時を現在日時に更新
			$_SESSION['login_date'] = time();

			if(basename($_SERVER['PHP_SELF']) === 'userLogin.php'){
				debug('スクールリストへ遷移します。');
				header("Location:schoolList.php"); //マイページへ
			}
		}
	}
	}else{
		debug('未ログインユーザーです。');
		if(basename($_SERVER['PHP_SELF']) !== 'userLogin.php'){
			 header("Location:userLogin.php"); //ログインページへ
		}
	}
