<?php
	require_once 'config.php';




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

		$menuOpen1 = $ary_categorySubBelong[$ary_get['c']]==$key ? 'aria-expanded="true"' : 'aria-expanded="false"';
		$menuOpen2 = $ary_categorySubBelong[$ary_get['c']]==$key ? '' : 'collapsed';
		$menuOpen3 = $ary_categorySubBelong[$ary_get['c']]==$key ? 'show' : '';
		if($ary_categorySubBelong[$ary_get['c']]==$key){
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

	$ary_prod = $obj_products -> fetch(' * ', " pkey = '".$ary_get['p']."' ");
	$ary_prodPic = $obj_products_pic -> fetchAll(' * ', " data_pkey = '".$ary_prod['pkey']."' order by sort DESC ");
	$ary_spec = $obj_products_select -> fetchAll(' * ', " type = '2' order by sort DESC ");

	$ary_page['html']['title'] = $ary_prod['title'];
	$ary_page['html']['subtitle'] = $ary_prod['subtitle'];
	$ary_page['html']['orgPrice'] = $ary_prod['org_price'] ? '<div class="item-price" data-aos="fade-left" data-aos-delay="750" data-aos-anchor-placement="center-bottom" data-aos-once="true"><h5>原價 NT$ '.number_format($ary_prod['org_price']).'</h5></div>' : '';
	$ary_page['html']['price'] = number_format($ary_prod['price']);
	$ary_page['html']['info'] = $ary_prod['info'];
	$ary_page['html']['check1'] = $ary_prod['check1']=='1' ? '<span class="btn btn-outline-danger rounded-pill px-4">預購</span>' : '';

	$ary_specProd = explode(',', $ary_prod['select1']);
	foreach($ary_spec as $value){
		foreach($ary_specProd as $value2){
			$ary_page['html']['spec'] .= $value['pkey']==$value2 ? '<option value="'.$value['pkey'].'">'.$value['title'].'</option>' : '';
		}
	}

	$ary_page['html']['spec'] = $ary_page['html']['spec'] ? '
		<div class="form-group row my-4">
			<label class="col-sm-2 col-form-label">規格</label>
			<div class="col-sm-4">
				<select class="form-control" name="select1">
					<option value="0">請選擇</option>
					'.$ary_page['html']['spec'].'
				</select>
			</div>
		</div>' : '';

		foreach($ary_prodPic as $key => $value){
			$active = $key==0 ? 'active' : '';
			$ary_page['html']['slidePic'] .= '
				<div class="carousel-item '.$active.'">
					<img class="d-block img-fluid" src="./uploads/'.$value['pic'].'" alt="slide">
				</div>
			';
			$ary_page['html']['slidePicList'] .= '
				<li class="list-inline-item '.$active.'" data-target="#productCarouselIndicators" data-slide-to="'.$key.'">
					<img src="./uploads/'.$value['pic'].'" class="img-fluid">
				</li>
			';
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
				  <li class="breadcrumb-item active" aria-current="page"><a href="product_list.php?c=<?=$ary_get['c']?>"><?=$ary_nav['html']['prodListTitle1']?></a></li>
				  <li class="breadcrumb-item active" aria-current="page"><a href="product_list.php?c=<?=$ary_get['c']?>"><?=$ary_nav['html']['prodListTitle2']?></a></li>
				  <li class="breadcrumb-item active" aria-current="page"><?=$ary_page['html']['title']?></li>
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

				<section class="col-md-9 col-sm-12">
					<div class="page-content">
						<div class="row" style="overflow: hidden">
							<div class="col-md-6 col-12 my-md-3 my-0" data-aos="fade-right" data-aos-delay="300" data-aos-anchor-placement="center-bottom" data-aos-once="true">
								<div id="productCarouselIndicators" class="carousel slide my-4" data-ride="carousel">
									<div class="carousel-inner" role="listbox">
										<?=$ary_page['html']['slidePic']?>
									</div>
									
									<a class="carousel-control-prev thumb-control text-black-50 w-auto" href="#productCarouselIndicators" role="button" data-slide="prev">
											<i class="fas fa-chevron-left"></i>
										<span class="sr-only">Previous</span>
									</a>
									<a class="carousel-control-next thumb-control text-black-50 w-auto" href="#productCarouselIndicators" role="button" data-slide="next">
											<i class="fas fa-chevron-right"></i>
										<span class="sr-only">Next</span>
									</a>

									<ol class="carousel-indicators list-inline mx-auto px-2">
										<?=$ary_page['html']['slidePicList']?>
									</ol>
								</div>
							</div>

							<div class="col-md-6 col-12 my-md-3 my-1" style="overflow: hidden">
								<div class="item-tag mb-3">
									<ul class="list-inline mb-0">
										<li class="list-inline-item" data-aos="fade-left" data-aos-delay="450" data-aos-anchor-placement="center-bottom" data-aos-once="true">
											<?=$ary_page['html']['check1']?>
										</li>
									</ul>
								</div>
								<h2 class="item-title" data-aos="fade-left" data-aos-delay="650" data-aos-anchor-placement="center-bottom" data-aos-once="true"><?=$ary_page['html']['title']?></h2>
								<div class="item-description" data-aos="fade-left" data-aos-delay="750" data-aos-anchor-placement="center-bottom" data-aos-once="true">
									<p><?=$ary_page['html']['subtitle']?></p>
								</div>

								<?=$ary_page['html']['orgPrice']?>

								<div class="item-price" data-aos="fade-left" data-aos-delay="850" data-aos-anchor-placement="center-bottom" data-aos-once="true">
									<h4>現金價 NT$<?=$ary_page['html']['price']?></h4>
								</div>

								<form data-aos="fade-left" data-aos-delay="950" data-aos-anchor-placement="center-bottom" data-aos-once="true">
									<?=$ary_page['html']['spec']?>
									<div class="form-group row my-4">
										<label class="col-sm-2 col-form-label">數量</label>
										<div class="col-sm-4">
											<div class="input-group num-row">
												<button class="btn btn-minus btn-light border btn-sm"><i class="fa fa-minus"></i></button>
												<input type="text" class="form-control bg-white text-center qty_input" value="1">
												<button class="btn btn-plus btn-light border btn-sm"><i class="fa fa-plus"></i></button>
											</div>
										</div>
									</div>

									<div class="form-group row my-4">
										<label class="col-sm-12 col-form-label list-tag">全館商品免運費</label>
									</div>

									<div class="form-group row d-md-flex d-none my-4">
										<div class="col-md-6 col-6">
											<button class="btn btn-danger btn-purchase w-100 rounded-pill mb-2" type="button">立即訂購</button>
										</div>
										<div class="col-md-6 col-6">
											<button class="btn btn-danger btn-addcart w-100 rounded-pill mb-2" type="button">加入購物車</button>
										</div>
									</div>
								</form>
							</div>       


							<!-- Floating purchase button fixed on the bottom -->
							
							<div class="col-12 btn-pay-group d-none">
								<dov class="row">
									<div class="col-md-6 col-6">
										<button class="btn btn-danger btn-purchase w-100 rounded-pill" type="button">立即訂購</button>
									</div>
									<div class="col-md-6 col-6">
										<button class="btn btn-danger btn-addcart w-100 rounded-pill" type="button">加入購物車</button>
									</div>
								</dov>
							</div>

							<!-- Floating purchase button fixed on the bottom -->

						</div>
						<!-- /* row */ -->

						<div class="row mb-5" style="overflow: hidden">
							<div class="col-12 tag-row py-4" data-aos="flip-left" data-aos-delay="1000" data-aos-anchor-placement="center-bottom" data-aos-once="true">
								<div class="row">
									<div class="col-md-3 col-6 mb-md-0 mb-3">
										<div class="media" data-aos="fade-down" data-aos-delay="1200" data-aos-anchor-placement="center-bottom" data-aos-once="true">
											<img class="product-img-tag align-self-center mr-3" src="./img/tag-ic01.png" alt="image">
											<div class="media-body align-self-center">
												<h5 class="mt-0">終生保固</h5>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-6 mb-md-0 mb-3">
										<div class="media" data-aos="fade-down" data-aos-delay="1300" data-aos-anchor-placement="center-bottom" data-aos-once="true">
											<img class="product-img-tag align-self-center mr-3" src="./img/tag-ic02.png" alt="image">
											<div class="media-body align-self-center">
												<h5 class="mt-0">鏡面古井刻工</h5>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-6 mb-md-0 mb-3">
										<div class="media" data-aos="fade-down" data-aos-delay="1400" data-aos-anchor-placement="center-bottom" data-aos-once="true">
											<img class="product-img-tag align-self-center mr-3" src="./img/tag-ic03.png" alt="image">
											<div class="media-body align-self-center">
												<h5 class="mt-0">七天鑑賞期內</h5>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-6 mb-md-0 mb-3">
										<div class="media" data-aos="fade-down" data-aos-delay="1500" data-aos-anchor-placement="center-bottom" data-aos-once="true">
											<img class="product-img-tag align-self-center mr-3" src="./img/tag-ic04.png" alt="image">
											<div class="media-body align-self-center">
												<h5 class="mt-0">肚臍照相存證</h5>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /* row */ -->


						<!-- ********************* editor start here ********************* -->


						<?=$ary_page['html']['info']?>


						<!-- ********************* editor start here ********************* -->

					</div>

					<nav class="my-5" aria-label="Page navigation">
						<div class="pagination justify-content-center">
							<button class="btn btn-light btn-page rounded border" onclick="history.back()" value="回列表">回列表</button>  
						</div>
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
<script>

	$(function(){
		



		$('.btn-purchase, .btn-addcart').click(function(){
			var fthis = $(this);
			<?php 				if(!$_SESSION['login']){
					echo "alert('請先登入會員或加入會員');";
					echo "top.location.href = 'login.php';";
				}else{

			?>

					if($('select[name="select1"]') && $('select[name="select1"]').val() == '0'){
						alert('請選擇規格!');
					}else{
						$('#loading').fadeIn(300,function(){
							$.ajax({
								type: "POST",
								url: 'proc.php?proc=addToCart',
								data: 'p=<?=$ary_prod['pkey']?>'+
										'&select1='+$('select[name="select1"]').val()+
										'&total='+$('.qty_input').val(),
								error: function(xhr) {
									$('#loading').fadeOut();
									alert('網路錯誤');
								},
								success: function (data, status, xhr) {
									$('#loading').fadeOut();
									$('.badge').html(data).show();
									if(fthis.hasClass('btn-purchase')){
										top.location.href = 'shopping_1.php';
									}
								}
							});
						});
					}

			<?php 				}

			?>


		});


	});


</script>

	<div style="display: none;" id="loading" >
			<div class="image">
					<img src="img/loading.svg">
			</div>
	</div>
	<style>
	#loading {
			background-color: #000000;
			display: none;
			height: 100%;
			left: 0;
			position: fixed;
			top: 0;
			width: 100%;
			z-index: 10000;
			opacity: 0.8;
	}
	#loading .image {
			left: 50%;
			margin: -60px 0 0 -60px;
			position: absolute;
			top: 50%;
	}



	</style>

</body>

</html>
