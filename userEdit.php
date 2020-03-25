<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('==========');
debug('ユーザー情報投稿・編集ページ');
debug('==========');
debugLogStart();

//ログイン認証
require('userAuth.php');

//================================
// 画面処理
//================================
// DBからユーザーデータを取得
$dbh = dbConnect();
$dbFormData = getUser($dbh,$_SESSION['u_id']);
$dbHistoryData = getHistory($dbh,$_SESSION['u_id']);

debug('userEdit:取得したユーザー情報：'.print_r($dbFormData,true));
debug('userEdit:取得した職歴：'.print_r($dbHistoryData,true));

//該当ユーザー以外がURLを入力した場合
if(isset($_SESSION['u_id'])){
  if($_SESSION['u_id'] === $dbFormData['id']){
    $u_id = $_SESSION['u_id'];
  }else{
    header("location: userMypage.php");
    exit;
  }
}else if(isset($_SESSION['c_id'])){
  header("location: companyMypage.php");
   exit;
}else{
  header("location: top.php");
  exit;
}

// post送信されていた場合
if(!empty($_POST)){
  debug('userEdit:POST送信があります。');
  debug('userEdit:POST情報：'.print_r($_POST,true));
  debug('userEdit:FILE情報：'.print_r($_FILES,true));

  //変数にユーザー情報を代入
  $u_name = $_POST['u_name'];
  $email = $_POST['email'];
	$description = $_POST['description'];
	$history_name0 = $_POST['history_name0'];
	$history_name1 = $_POST['history_name1'];
	$history_name2 = $_POST['history_name2'];
	$start_date0 = $_POST['start_date0'];
	$start_date1 = $_POST['start_date1'];
	$start_date2 = $_POST['start_date2'];
	$end_date0 = $_POST['end_date0'];
	$end_date1 = $_POST['end_date1'];
	$end_date2 = $_POST['end_date2'];
	$detail0 = $_POST['detail0'];
	$detail1 = $_POST['detail1'];
	$detail2 = $_POST['detail2'];
	$goal = $_POST['goal'];
  //画像をアップロードし、パスを格納
  $pic = ( !empty($_FILES['pic']['name']) ) ? uploadImg($_FILES['pic'],'pic') : '';
  // 画像をPOSTしてない（登録していない）が既にDBに登録されている場合、DBのパスを入れる（POSTには反映されないので）
  $pic = ( empty($pic) && !empty($dbFormData['pic']) ) ? $dbFormData['pic'] : $pic;

  //DBの情報と入力情報が異なる場合にバリデーションを行う
  if($dbFormData['u_name'] !== $u_name){
		//未入力チェック
    validRequired($u_name, 'u_name');
    //名前の最大文字数チェック
    validMaxLen($u_name, 'u_name');
  }
  if($dbFormData['email'] !== $email){
    //emailの最大文字数チェック
    validMaxLen($email, 'email');
    if(empty($err_msg['email'])){
      //emailの重複チェック
      validEmailDupUser($dbh,$email);
    }
    //emailの形式チェック
    validEmail($email, 'email');
    //emailの未入力チェック
    validRequired($email, 'email');
  }
  if(empty($err_msg)){
    debug('バリデーションOKです。');

    //例外処理
    try {
      // DBへ接続
      $dbh = dbConnect();
      // SQL文作成
      $sql = 'UPDATE u_profile SET u_name = :u_name, email = :email, description = :description, goal = :goal, pic = :pic WHERE id = :u_id';
      $data = array(':u_name' => $u_name , ':email' => $email, 'description' => $description, ':goal' => $goal, ':pic' => $pic, ':u_id' => $dbFormData['id']);
      // クエリ実行
			$stmt = queryPost($dbh, $sql, $data);
			
			if($dbHistoryData[0]){	
				$sql = 'UPDATE history SET history_name = :history_name0, start_date = :start_date0, end_date = :end_date0, detail = :detail0 ,update_date = :update_date WHERE id = :h_id';
				$data = array(':history_name0' => $history_name0 , ':start_date0' => $start_date0, 'end_date0' => $end_date0, ':detail0' => $detail0,':update_date' => date('Y-m-d H:i:s'),':h_id' => $dbHistoryData[0]['id']);
				$stmt = queryPost($dbh, $sql, $data);
			}else{
				$sql = 'INSERT INTO history (history_name,start_date,end_date,detail,u_id,create_date) VALUES(:history_name0,:start_date0,:end_date0,:detail0,:u_id,:create_date)';
				$data = array(':history_name0' => $history_name0 , ':start_date0' => $start_date0, 'end_date0' => $end_date0, ':detail0' => $detail0,':u_id' => $_SESSION['u_id'],':create_date' => date('Y-m-d H:i:s'));
				$stmt = queryPost($dbh, $sql, $data);
			}
			
			if($dbHistoryData[1]){	
				$sql = 'UPDATE history SET history_name = :history_name1, start_date = :start_date1, end_date = :end_date1, detail = :detail1 ,update_date = :update_date WHERE id = :h_id';
				$data = array(':history_name1' => $history_name1 , ':start_date1' => $start_date1, 'end_date1' => $end_date1, ':detail1' => $detail1,':update_date' => date('Y-m-d H:i:s'),':h_id' => $dbHistoryData[1]['id']);
				$stmt = queryPost($dbh, $sql, $data);
			}else{
				$sql = 'INSERT INTO history (history_name,start_date,end_date,detail,u_id,create_date) VALUES(:history_name1,:start_date1,:end_date1,:detail1,:u_id,:create_date)';
				$data = array(':history_name1' => $history_name1 , ':start_date1' => $start_date1, 'end_date1' => $end_date1, ':detail1' => $detail1,':u_id' => $_SESSION['u_id'],':create_date' => date('Y-m-d H:i:s'));
				$stmt = queryPost($dbh, $sql, $data);
			}
			
			if($dbHistoryData[2]){
				$sql = 'UPDATE history SET history_name = :history_name2, start_date = :start_date2, end_date = :end_date2, detail = :detail2 ,update_date = :update_date WHERE id = :h_id';
				$data = array(':history_name2' => $history_name2 , ':start_date2' => $start_date2, 'end_date2' => $end_date2, ':detail2' => $detail2,':update_date' => date('Y-m-d H:i:s'),':h_id' => $dbHistoryData[2]['id']);
				$stmt = queryPost($dbh, $sql, $data);
			}else{
				$sql = 'INSERT INTO history (history_name,start_date,end_date,detail,u_id,create_date) VALUES(:history_name2,:start_date2,:end_date2,:detail2,:u_id,:create_date)';
				$data = array(':history_name2' => $history_name2 , ':start_date2' => $start_date2, 'end_date2' => $end_date2, ':detail2' => $detail2,':u_id' => $_SESSION['u_id'],':create_date' => date('Y-m-d H:i:s'));
				$stmt = queryPost($dbh, $sql, $data);
			}
			if($stmt){
				$_SESSION['msg_success'] = SUC02;
				debug('マイページへ遷移します。');
				header("Location:userMypage.php"); //マイページへ
			}
		} catch (Exception $e) {
			error_log('エラー発生:' . $e->getMessage());
			$err_msg['common'] = MSG07;
		}
	}
}

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
	$siteTitle = 'ユーザー情報編集';
	require('head.php'); 
?>

<body>

<!-- メニュー -->
<?php
	require('header.php'); 
?>

<!-- メインコンテンツ -->
<div class="container">
	<div class="panel--oblong u-mt_3l">
		<h1 class="panel--oblong__title">プロフィール登録</h1>
	</div>
	<div>
		<form action="" method="post" class="form" enctype="multipart/form-data">
			<div class="u-flex-reverse">
				<div class="u-width-70 panel--white u-left u-pb_xxl u-pt_xxl u-pl_xxl u-pr_xxl u-radius__m u-mb_xl u-mt_4l">
					<div class="area-msg">
						<?php 
						if(!empty($err_msg['common'])) echo $err_msg['common'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['u_name'])) echo 'err'; ?>">
						名前<span class="badge-required">＊必須</span>
						<input class="input" type="text" placeholder="フルネーム" name="u_name" value="<?php echo getFormdata($dbFormData, 'u_name');?>">
					</label>
					<div class="area-msg">
						<?php 
						if(!empty($err_msg['u_name'])) echo $err_msg['u_name'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
						Email<span class="badge-required">＊必須</span>
						<input class="input" type="text" placeholder="メールアドレス　（例　web@mail.com）" name="email" value="<?php echo getFormdata($dbFormData, 'email');?>">
					</label>
					<div class="area-msg">
						<?php 
						if(!empty($err_msg['email'])) echo $err_msg['email'];
						?>
					</div>
					<label class="<?php if(!empty($err_msg['description'])) echo 'err'; ?>">
						自己紹介
						<textarea class="textarea" cols="30" rows="10" placeholder="年齢、居住地、エンジニアになりたい理由、プログラミングスキル、長所や短所などご自由にご記入ください。
(例　東京都在住の25歳です。現在は食品メーカーの営業をしています。元々プログラミングに興味があり〇〇というスクールに半年間通って卒業しました。初心者レベルのフロントエンドのスキルはあります。最新PHPの勉強もしています。)" name="description"><?php echo getFormdata($dbFormData, 'description');?></textarea>
					</label>
					<div class="area-msg">
						<?php 
						if(!empty($err_msg['description'])) echo $err_msg['description'];
						?>
					</div>
					<div class="u-width-100">
						職歴（最大3つまで）
						<?php for($a = 0; $a <= 2; $a++){?>
							<div id="history_area<?php echo $a; ?>" class="history_area<?php echo $a; ?> <?php ($a == 0 || isset($_POST["history_name".$a]) || isset($dbHistoryData[$a]))? print 'u-flex-default': print 'js-hidden'; ?>">
								<div id="js-history<?php echo $a ?>" class="js-history u-width-100" name="history<?php echo $a; ?>">
									<label class="<?php if(!empty($err_msg[''])) echo 'err'; ?>">
										職業経歴:<?php echo $a+1; ?>
										<input class="input" type="text" placeholder="株式会社〇〇〇〇" name="history_name<?php echo $a; ?>" value="<?php if(!empty($dbHistoryData[$a])) echo getFormdata($dbHistoryData[$a], 'history_name');?>">
									</label>
									<label class="<?php if(!empty($err_msg[''])) echo 'err'; ?>">
										入社日・退社日
										<div class="u-flex-between">
											<input class="input u-width-40" type="date" name="start_date<?php echo $a; ?>" value="<?php if(!empty($dbHistoryData[$a]))echo getFormdata($dbHistoryData[$a], 'start_date');?>"><span class="u-mt_m">〜</span>
											<input class="input u-width-40 u-mr_3l" type="date" name="end_date<?php echo $a; ?>" value="<?php if(!empty($dbHistoryData[$a]))echo getFormdata($dbHistoryData[$a], 'end_date');?>">
										</div>
									</label>
									<label class="<?php if(!empty($err_msg['description'])) echo 'err'; ?>">
										業務内容など
										<textarea class="textarea" cols="30" rows="10" placeholder="業務内容や役職などをご記入ください。　（例　前職ではメーカーで法人営業をしていました。10名チームのリーダーとして、目標の管理などのマネジメントを行なっていました。）" name="detail<?php echo $a; ?>"><?php if(!empty($dbHistoryData[$a])) echo getFormdata($dbHistoryData[$a], 'detail');?></textarea>
									</label>
									<button type="button" class="delete-history<?php echo $a; ?>"><i class="fas fa-trash-alt"></i></button>
								</div>
							</div>
						<?php } ?>
						<input class="add-history u-width-100 u-center u-m_auto" type="button" value="職歴を追加"/>
					</div>
					<label class="<?php if(!empty($err_msg['goal'])) echo 'err'; ?>">
						今後の目標
						<textarea class="textarea" cols="30" rows="10" placeholder="将来のありたい姿などご記入ください。（例　○年○月末に現在の職場を退職する予定なので、それまでにスキルアップしてフロントエンドエンジニアとして転職したいです。）" name="goal"><?php echo getFormdata($dbFormData, 'goal');?></textarea>
					</label>
					<div class="area-msg">
						<?php 
						if(!empty($err_msg['goal'])) echo $err_msg['goal'];
						?>
					</div>
				</div>
				<label class="js-area-drop area-drop">
					プロフィール写真を<span class="td-ul">アップロードする</span><span class="err"></span>
					<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
					<input class="js-form js-input-file input-file" type="file" name="pic">
					<img src="<?php echo getFormdata($dbFormData,'pic');?>" alt="" class="js-prev-img prev-img--default">
				</label>
				<div class="area-msg">
					<?php 
					if(!empty($err_msg['pic'])) echo $err_msg['pic'];
					?>
				</div>
			</div>
			<div class="btn button u-mt_l u-center u-mb_4l">
				<input type="submit" class="button--yellow text--l" value="登録する">
			</div>
			</form>
	</div>
</div>
<!-- footer -->
<?php
	require('footer.php');
?>
