<?php
	require_once 'config.php';


	$pageNow = (isset($_GET['p']) and $_GET['p'] != '') ? intval($_GET['p']) : 1;

	$pageNum = 9;          //每頁呈現最大筆數

	if($ary_get['c']){
		$sqlSeries = $ary_get['c'];
	}else{
		$ary_series = $obj_category -> fetch('*' , " data_pkey = '0' order by sort DESC ");
		$ary_series2 = $obj_category -> fetch('*' , " data_pkey = '".$ary_series['pkey']."' order by sort DESC ");
		$sqlSeries = $ary_series2['pkey'];		
	}

	// $ary_prodTag = $obj_banner->fetch('*' , " type = '4' ");
	// $ary_page['html']['prodTag'] = $ary_prodTag['title'];
	$ary_tag = $obj_banner->fetchAll('*' , " type = '4' ");
	foreach($ary_tag as $value){
		$ary_tagRe[$value['pkey']] = $value['title'];
	}


	foreach($ary_nav['ary']['category'] as $key => $value){
		unset($submenuLi);
	    if(!$value['subCategory']){
	      continue;
	    }
		foreach((array)$value['subCategory'] as $key2 => $value2){
			$submenuLi .= '
				<li><a href="product_list.php?c='.$value2['pkey'].'" class="">'.$value2['title'].'</a></li>
			';
			if($ary_get['c'] == $value2['pkey']){
				$ary_nav['html']['prodListTitle2'] = $value2['title'];
			}

		}

		$menuOpen1 = $ary_categorySubBelong[$sqlSeries]==$key ? 'aria-expanded="true"' : 'aria-expanded="false"';
		$menuOpen2 = $ary_categorySubBelong[$sqlSeries]==$key ? '' : 'collapsed';
		$menuOpen3 = $ary_categorySubBelong[$sqlSeries]==$key ? 'show' : '';
		if($ary_categorySubBelong[$sqlSeries]==$key){
			$ary_nav['html']['prodListTitle1'] = $value['title'];
		}

		$ary_page['html']['submenu'] .= '
			<div class="card">
				<div class="card-header" id="heading'.$key.'">
					<h2 class="mb-0">
						<button class="btn btn-link text-black '.$menuOpen2.'" type="button" data-toggle="collapse" data-target="#collapse'.$key.'" '.$menuOpen1.' aria-controls="collapse'.$key.'">
							'.$value['title'].'
						</button>
					</h2>
				</div>
		
				<div id="collapse'.$key.'" class="collapse '.$menuOpen3.'" aria-labelledby="heading'.$key.'" data-parent="#accordionLeftMenu">
					<div class="card-body">
						<ul class="accordin-menu">
							'.$submenuLi.'
						</ul>
					</div>
				</div>
			</div>
		';
	}

	$ary_prod = $obj_products -> fetchAll(' * ', " data_pkey = '".$sqlSeries."' ORDER BY `sort` DESC ",True , array($pageNow-1 , $pageNum));

	foreach($ary_prod as $value){
		$hotsale = $ary_tagRe[$value['check2']] ? '<b class="float-tag text-white bg-danger">'.$ary_tagRe[$value['check2']].'</b>' : '';
		$orgPrice = $value['org_price'] ? '<h6 class="card-text">原價 NT$ '.number_format($value['org_price']).'</h6>' : '';
		$ary_page['html']['prod'] .= '
			<div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in" data-aos-delay="0" data-aos-anchor-placement="center-bottom">
				<a href="product_content.php?c='.$sqlSeries.'&p='.$value['pkey'].'">
					<div class="card product-card border-0">
						<div class="card-top">
							<img src="./uploads/'.$value['listpic'].'" class="card-img-top img-fluid" alt="">
							'.$hotsale.'
						</div>
						<div class="card-body px-0">
							<h5 class="card-title">'.$value['title'].'</h5>
							<p class="card-text">'.$value['subtitle'].'</p>
							'.$orgPrice.'
							<h5 class="card-text text-danger">現金價 NT$ '.number_format($value['price']).'</h5>
						</div>
					</div>
				</a>
			</div>
		';
	}

	// echo '<pre>';
	// print_r($ary_prod);

	$totalPage = ceil($obj_products->num / $pageNum);

	if($pageNow <= 1){
		$ary_page['html']['prevBtn'] = '';
	}else{
		$ary_page['html']['prevBtn'] = '
			<li class="page-item pr-3">
				<a class="page-link rounded-circle" href="product_list.php?c='.$sqlSeries.'&p='.($pageNow-1).'">
					<i class="fas fa-chevron-left"></i>
					<span class="sr-only">上一頁</span>
				</a>
			</li>
		';
	}

	if($pageNow >= $totalPage){
		$ary_page['html']['nextBtn'] = '';
	}else{
		$ary_page['html']['nextBtn'] = '
			<li class="page-item pl-3">
				<a class="page-link rounded-circle" href="product_list.php?c='.$sqlSeries.'&p='.($pageNow+1).'">
						<i class="fas fa-chevron-right"></i>
						<span class="sr-only">下一頁</span>
				</a>
			</li>
		';
	}

	for($i=1 ; $i<=$totalPage ; $i++){
		$ary_page['html']['pageList'] .= '
		<a class="dropdown-item" href="product_list.php?c='.$sqlSeries.'&p='.$i.'">'.$i.'</a>  
		';
	}

	if($totalPage == 1){
		$ary_page['css']['pageSelectShow'] = 'style="display:none;"';
	}



$ary_head['title'] = '商品專區-Babyin 寶貝印 印鑑工坊';
$ary_head['keyword'] = '木印章,紫檀印章,牛角印章,牛角章,生肖印章,水晶印章,結婚對章,公司章,開運手項鍊,胎毛筆';


?>
<!DOCTYPE html>
<html lang="en">

<head>

	<?php include icld.'head.php'; ?>

</head>

<body>

	<!-- Navigation -->
	<?php include icld.'nav.php'; ?>
	<header>
		<div class="container">
		  <div class="row">
		    <div class="col-12 px-md-0">
		      <nav aria-label="breadcrumb">
		        <ol class="breadcrumb bg-transparent justify-content-md-end">
		          <li class="breadcrumb-item"><a href="./">首頁</a></li>
		          <li class="breadcrumb-item active" aria-current="page"><a href="product_list.php?c=<?=$sqlSeries?>"><?=$ary_nav['html']['prodListTitle1']?></a></li>
		          <li class="breadcrumb-item active" aria-current="page"><a href="product_list.php?c=<?=$sqlSeries?>"><?=$ary_nav['html']['prodListTitle2']?></a></li>
		        </ol>
		      </nav>
		    </div>
		  </div>
		</div>
	</header>

	<!-- Page Content Start -->
	<article class="page-wrapper my-3">
		<div class="container">
			<div class="row">
				<aside class="sidebar col-md-3 pl-0 pr-5">
					<div class="accordion" id="accordionLeftMenu">
						<?=$ary_page['html']['submenu']?>
					</div>
				</aside>

				<section class="col-lg-9 col-md-12 col-12">
					<div class="page-content">
						<div class="row">
							<?=$ary_page['html']['prod']?>
						</div>
					</div>

					<nav class="my-5" aria-label="Page navigation">
						<ul class="pagination justify-content-center" <?=$ary_page['css']['pageSelectShow']?>>
							<?=$ary_page['html']['prevBtn']?>
							<li class="page-item">
								<div class="dropdown">  
									<button class="btn btn-light btn-page border dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">  
										<?=$pageNow?> 
									</button>  
									<div class="page-menu dropdown-menu" aria-labelledby="dropdownMenuButton">  
										<?=$ary_page['html']['pageList']?>
									</div>  
								</div>
							</li>
		
							<?=$ary_page['html']['nextBtn']?>
						</ul>
					</nav>
				</section>

				
			</div>
		</div>
	</article>
	<!-- Page Content End -->

	<!-- Footer -->
	<?php include icld.'footer.php'; ?>

	<!-- Go top Button -->
	<a id="back-to-top" href="#" class="btn btn-lg back-to-top" role="button" title="" data-toggle="tooltip" data-placement="left">
		<p>TOP</p>
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- AOS JavaScript -->
	<script src="js/aos.js"></script>

	<!-- Custom JavaScript -->
	<script src="js/babyin.js"></script>

</body>

</html>
