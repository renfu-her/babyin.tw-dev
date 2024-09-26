<?php
if($ary_get['c'] >= 10 && $ary_get['c'] <= 30){
	$mainMenuClass2 = 'class="active"';
	$mainMenuDisplay2 = 'style="display: block;"';
}

if($ary_get['c'] >= 40 && $ary_get['c'] <= 45){
	$mainMenuClass3 = 'class="active"';
	$mainMenuDisplay3 = 'style="display: block;"';
}

if($ary_get['c'] >= 110 && $ary_get['c'] <= 115){
	$mainMenuClass4 = 'class="active"';
	$mainMenuDisplay4 = 'style="display: block;"';
}

if($ary_get['c'] >= 120 && $ary_get['c'] <= 125){
	$mainMenuClass5 = 'class="active"';
	$mainMenuDisplay5 = 'style="display: block;"';
}





?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
		<ul class="nav side-menu">

			<li <?=$mainMenuClass3?> style="">
				<a> 首頁管理 <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu" <?=$mainMenuDisplay3?>>
					<li <?=($ary_get['c']==40)?'class="current-page"':''?>><a href="index.php?c=40">首頁banner</a></li>
					<li <?=($ary_get['c']==45)?'class="current-page"':''?>><a href="index.php?c=45">廣告專區</a></li>
					<li <?=($ary_get['c']==43)?'class="current-page"':''?>><a href="index.php?c=43">活動訊息banner</a></li>
				</ul>
			</li>

			<li <?=($ary_get['c']==50)?'class="current-page"':''?>><a href="index.php?c=50">關於我們</a></li>
			
			<li <?=($ary_get['c']==60)?'class="current-page"':''?>><a href="index.php?c=60">活動訊息</a></li>

			<li <?=$mainMenuClass2?> style="">
				<a> 產品管理 <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu" <?=$mainMenuDisplay2?>>
					<li <?=($ary_get['c']==20)?'class="current-page"':''?>><a href="index.php?c=20">大類別</a></li>
					<li <?=($ary_get['c']==30)?'class="current-page"':''?>><a href="index.php?c=30">小類別</a></li>
					<li <?=($ary_get['c']==15)?'class="current-page"':''?>><a href="index.php?c=15">產品標籤</a></li>
					<li <?=($ary_get['c']==17)?'class="current-page"':''?>><a href="index.php?c=17">規格</a></li>
					<li <?=($ary_get['c']==10)?'class="current-page"':''?>><a href="index.php?c=10">產品維護</a></li>
				</ul>
			</li>

			<li <?=($ary_get['c']==70)?'class="current-page"':''?>><a href="index.php?c=70">會員專區</a></li>

			<li <?=$mainMenuClass5?> style="">
				<a> 認識印章 <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu" <?=$mainMenuDisplay5?>>
					<li <?=($ary_get['c']==120)?'class="current-page"':''?>><a href="index.php?c=120">認識印章類別</a></li>
					<li <?=($ary_get['c']==123)?'class="current-page"':''?>><a href="index.php?c=123">認識印章</a></li>
				</ul>
			</li>


			<li <?=$mainMenuClass4?> style="">
				<a> 常見問答 <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu" <?=$mainMenuDisplay4?>>
					<li <?=($ary_get['c']==110)?'class="current-page"':''?>><a href="index.php?c=110">常見問答類別</a></li>
					<li <?=($ary_get['c']==113)?'class="current-page"':''?>><a href="index.php?c=113">常見問答</a></li>
				</ul>
			</li>

			<li <?=($ary_get['c']==100)?'class="current-page"':''?>><a href="index.php?c=100">訂單管理</a></li>

			<li <?=($ary_get['c']==90)?'class="current-page"':''?>><a href="index.php?c=90">聯絡我們</a></li>





			<li <?=($ary_get['c']==80)?'class="current-page"':''?>><a href="index.php?c=80">帳號管理</a></li>


		</ul>
	</div>

</div>
