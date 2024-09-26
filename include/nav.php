<?php


	$ary_navBrand = $obj_news->fetchAll('pkey,title' , " is_brand = '1' order by sort DESC ");
	foreach($ary_navBrand as $value){
		$navActive = strpos($_SERVER['REQUEST_URI'],'brand.php') && $ary_get['p'] == $value['pkey'] ? 'active' : '';
		$ary_nav['html']['brand'] .= '
			<li class="nav-item">
				<a class="nav-link '.$navActive.'" href="brand.php?p='.$value['pkey'].'">'.$value['title'].'</a>
			</li>

		';
		if(strpos($_SERVER['REQUEST_URI'],'brand.php') && $ary_get['p'] == $value['pkey']){
			$ary_nav['html']['brandTitle'] = $value['title'];
		}
	}


	foreach($ary_nav['ary']['category'] as $value){
		unset($ary_nav['html']['subCategory']);
		if(!$value['subCategory']){
			continue;
		}
		foreach($value['subCategory'] as $value2){
			$ary_nav['html']['subCategory'] .= '
				<li class="nav-item">
					<a class="nav-link" href="product_list.php?c='.$value2['pkey'].'">'.$value2['title'].'</a>
				</li>
			';

		}


		$ary_nav['html']['category'] .= '
							<li class="nav-item dropdown no-arrow">
								<a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									'.$value['title'].' <i class="fas fa-angle-down"></i>
								</a>
								<ul class="dropdown-menu sub-sub-menu" aria-labelledby="navbarDropdown">
										'.$ary_nav['html']['subCategory'].'
								</ul>
							</li>

	';

	}



	foreach($ary_articleCategory as $value){
		$active = $value['pkey']==$ary_get['c'] ? 'active' : '';
		$ary_page['nav']['articleCategory'] .= '
		<li class="nav-item">
			<a class="nav-link '.$active.'" href="article-list.php?c='.$value['pkey'].'">'.$value['title'].'</a>
		</li>
		';
	}


	if(strpos($_SERVER['REQUEST_URI'],'brand.php')  ){
		$htmlMenuClass1 = 'active';
	}else if(strpos($_SERVER['REQUEST_URI'],'act_list.php') || strpos($_SERVER['REQUEST_URI'],'act_center.php') ){
		$htmlMenuClass2 = 'active';
	}else if(strpos($_SERVER['REQUEST_URI'],'product_list.php') || strpos($_SERVER['REQUEST_URI'],'product_content.php') ){
		$htmlMenuClass3 = 'active';
	}else if(strpos($_SERVER['REQUEST_URI'],'faq.php') ){
		$htmlMenuClass4 = 'active';
	}


	if($_SESSION['login']){
		$navLogIconLink = 'proc.php?proc=logout';
		$navMemberMenu = '
							<li class="nav-item">
								<a class="nav-link" href="personal.php">個人資料修改</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="order_search.php">訂單查詢</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="proc.php?proc=logout">登出</a>
							</li>
		';
	}else{
		$navLogIconLink = 'login.php';
		$navMemberMenu = '
							<li class="nav-item">
								<a class="nav-link" href="login.php">登入</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="join.php">加入會員</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="forget.php">忘記密碼</a>
							</li>
		';
	}


	if($_SESSION['cart']){
		$htmlCartShow = '';
		$htmlCartNum = count($_SESSION['cart']);
	}else{
		$htmlCartShow = 'display:none;';
		$htmlCartNum = '';
	}



	$ary_series = $obj_faq_category -> fetchAll_join('*' , " order by sort DESC ");

	foreach($ary_series as $key => $value){

		$active = $value['pkey']==$sqlSeries ? 'active' : '';

		$ary_nav['html']['faqmenu'] .= '
			<li class="nav-item">
								<a class="nav-link '.$active.'" href="faq.php?c='.$value['pkey'].'">'.$value['title'].'</a>
			</li>
		';
	}

	// if(strpos($_SERVER['REQUEST_URI'],'index.php') || !strpos($_SERVER['REQUEST_URI'],'.php') ){
	// 	$htmlLogo = '<a class="navbar-brand" href="index.php"><img src="images/logo.png" class="img-responsive" /> </a>';
	// }else{
	// 	$htmlLogo = '<a class="navbar-brand" href="index.php"><img src="images/logo-gray.png" class="img-responsive d-show" /><img src="images/logo.png" class="img-responsive m-show" /> </a>';
	// }

// print_r($ary_nav);

?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KLLW9NT"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<nav class="navbar navbar-expand-lg navbar-light navbar-white bg-white">
		<div class="container px-0">
 
			<span class="fake-row mx-auto"><!-- hidden spacer to center brand on mobile --></span>
			<a class="navbar-brand mx-auto" href="./">
					<img src="./img/brand_logo.png" class="img-fluid">
			</a>


		 <!---------------------------- Hamburger Button ---------------------------->
			<button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarResponsive">
				<span> </span>
				<span> </span>
				<span> </span>
			</button>
			<!-- 
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon text-gold"></span>
			</button> 
			-->
			<!---------------------------- Hamburger Button ---------------------------->

			<!---------------------------- Main Menu ---------------------------->
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav main-menu mr-auto">
					<li class="nav-item dropdown no-arrow">
						<a class="nav-link dropdown-toggle <?php echo $htmlMenuClass1?>" href="#" id="aboutUsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								關於我們 <i class="fas fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu" aria-labelledby="aboutUsDropdown">
							<?php echo $ary_nav['html']['brand']?>
						</ul>
					</li>

					<li class="nav-item">
						<a class="nav-link <?php echo $htmlMenuClass2?>" href="act_list.php">活動訊息</a>
					</li>

					<li class="nav-item product-item dropdown no-arrow">
						<a class="nav-link dropdown-toggle <?php echo $htmlMenuClass3?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							商品專區 <i class="fas fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdown">
							<?php echo $ary_nav['html']['category']?>
						</ul>
					</li>

					<li class="nav-item dropdown no-arrow">
						<a class="nav-link dropdown-toggle" href="#" id="memberDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							會員專區 <i class="fas fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu" aria-labelledby="memberDropdown">
							<?php echo $navMemberMenu?>
						</ul>
					</li>

					<li class="nav-item dropdown no-arrow">
						<a class="nav-link dropdown-toggle" href="#" id="infomationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						  認識印章 <i class="fas fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu" aria-labelledby="infomationDropdown">
						  <?php echo $ary_page['nav']['articleCategory']?>
						</ul>
					</li>


					<li class="nav-item dropdown no-arrow">
						<a class="nav-link dropdown-toggle" href="#" id="faqDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							常見問答 <i class="fas fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu" aria-labelledby="faqDropdown">
							<?php echo $ary_nav['html']['faqmenu']?>
						</ul>
					</li>

										
				</ul>
				<!---------------------------- Main Menu ---------------------------->


				<!---------------------------- Search fields ---------------------------->
				<form class="form-inline my-2 my-lg-0" action="search.php" method="get">
					<div class="input-group">
						<input type="text" class="form-control input-search input-border-radius-50 bg-search" placeholder="搜尋" aria-label="Search" aria-describedby="basic-addon2" name="search" value="<?php echo $ary_get['search']?>">
						<div class="input-group-append">
							<button class="btn btn-widget text-white input-border-radius-50 bg-search" type="submit">
								<i class="fas fa-search"></i>
							</button>
						</div>
					</div>
				</form>
				<!---------------------------- Search fields ---------------------------->

			</div>

			<!---------------------------- Shopping Cart & Login fields ---------------------------->
			<ul class="navbar-nav navbar-navright flex-row ml-md-auto ml-0 pr-md-3 pr-2">
				<li class="nav-item mx-md-3 mx-2">
					<a class="nav-link btn-widget" href="<?php echo $navLogIconLink?>">
						<i class="far fa-user"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link btn-widget" href="shopping_1.php">
						<i class="fas fa-shopping-cart"></i>
						<span class="badge badge-danger" style="<?php echo $htmlCartShow?>"><?php echo $htmlCartNum?></span>
					</a>
				</li>
			</ul>
			<!---------------------------- Shopping Cart & Login fields ---------------------------->

		</div>
	</nav>
		<!-- /.container -->
