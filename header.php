<header class="header">
	<div class="u-flex-between">
      <?php if($_SERVER['REQUEST_URI'] !== '/idom/realgachi/top.php'){ ?>
		<a href="top.php"><img  class="header-logo"src="img/logo.jpg" alt="リアルガチレビュー"></a>
		<?php } ?>
		<?php
			if(!empty($_SESSION['u_id'])){
		?>
      <section <?php $_SERVER['REQUEST_URI'] !== '/idom/realgachi/top.php' ? print 'class="menuarea u-width-70"': print 'class="u-width-100"'; ?>>
				<ul id="fade-in" class="dropmenu">
					<li style="width: 20%;"><a href="userMypage.php">マイページ</a></li>
					<li style="width: 20%;"><a href="">レビュー</a>
						<ul>
							<li><a href="schoolList.php">スクール一覧</a></li>
							<li><a href="portfolioList.php">ポートフォリオ一覧</a></li>
						</ul>
					</li>
					<li style="width: 20%;"><a href="matchingtest.php">学ぶべき言語探し</a></li>
					<li style="width: 20%;"><a href="contact.php">お問い合わせ</a></li>
					<li style="width: 20%;"><a href="userLogout.php">ログアウト</a></li>
				</ul>
			</section>
		<?php
			}else if(!empty($_SESSION['c_id'])){
		?>
      <section <?php $_SERVER['REQUEST_URI'] !== '/idom/realgachi/top.php' ? print 'class="menuarea u-width-70"': print 'class="u-width-100"'; ?>>
				<ul id="fade-in" class="dropmenu">
					<li style="width: 25%;"><a href="companyMypage.php">マイページ</a></li>
					<li style="width: 25%;"><a href="">レビュー</a>
						<ul>
							<li><a href="schoolList.php">スクール一覧</a></li>
							<li><a href="portfolioList.php">ポートフォリオ一覧</a></li>
						</ul>
					</li>
					<li style="width: 25%;"><a href="contact.php">お問い合わせ</a></li>
					<li style="width: 25%;"><a href="companyLogout.php">ログアウト</a></li>
				</ul>
			</section>
		<?php
			}else{
		?>
      <section <?php $_SERVER['REQUEST_URI'] !== '/idom/realgachi/top.php' ? print 'class="menuarea u-width-70"': print 'class="u-width-100"'; ?>>
				<ul id="fade-in" class="dropmenu">
					<li style="width: 25%;"><a href="">ログイン</a>
						<ul>
							<li><a href="userLogin.php">スクール生徒・卒業生</a></li>
							<li><a href="companyLogin.php">企業</a></li>
						</ul>
					</li>
					<li style="width: 25%;"><a href="">レビュー</a>
						<ul>
							<li><a href="schoolList.php">スクール一覧</a></li>
							<li><a href="portfolioList.php">ポートフォリオ一覧</a></li>
						</ul>
					</li>
					<li style="width: 25%;"><a href="matchingtest.php">学ぶべき言語探し</a></li>
					<li style="width: 25%;"><a href="contact.php">お問い合わせ</a></li>
				</ul>
			</section>
		<?php
			}
		?>
  </div>
</header>