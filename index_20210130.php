<?php
	require_once 'config.php';
	include "uploads/captcha/simple-php-captcha.php";
	$_SESSION['captcha'] = simple_php_captcha();



	$ary_banner = $obj_banner->fetchAll('*' , " type = '1' OR type = '2' order by sort DESC ");
	$ary_news = $obj_news->fetchAll('*' , " newsdate <= '".date('Y-m-d')."' AND is_brand = '0' order by newsdate DESC limit 6 ");


	$active = 'active';
	$bannerCount = 0;
	$bannerCount2 = 1;
	foreach($ary_banner as $value){
		if($value['type'] == '1'){
			$href = $value['url'] ? 'href="'.$value['url'].'"' : '';
			$ary_page['html']['banner1'] .= '
			<a class="carousel-item '.$active.'" '.$href.'>
			  <img src="uploads/'.$value['pic'].'" class="d-block w-100" alt="">
			</a>
			';
			$ary_page['html']['banner1Dot'] .= '
			<li data-target="#babyinCarousel" data-slide-to="'.$bannerCount.'" class="'.$active.'"></li>
			';
			$bannerCount ++;
			$active = '';
		}else if($value['type'] == '2'){
			$ary_page['html']['banner2']['pic'][$bannerCount2] = 'uploads/'.$value['pic'];
			$ary_page['html']['banner2']['title'][$bannerCount2] = $value['title'];
			$ary_page['html']['banner2']['info'][$bannerCount2] = $value['info'];
			$bannerCount2 ++;
		}
	}

	$ary_page['css']['banner1IsShow'] = $ary_page['html']['banner1'] ? '' : 'style="display:none;"';
	$ary_page['css']['banner1Control'] = $bannerCount > 1 ? '' : 'style="display:none;"';

	$active = 'active';
	foreach($ary_news as $value){
		$ary_page['html']['news'] .= '
		<div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-4 '.$active.'">
			<a href="act_center.php?p='.$value['pkey'].'">
			  <div class="card border-0">
				<img class="card-img-top img-fluid" src="uploads/'.$value['pic'].'" alt="">
				<div class="card-body px-0">
				  <p class="card-text mb-1"><small class="text-gold">'.$value['newsdate'].'</small></p>
				  <h4 class="card-title">'.$value['title'].'</h4>
				  <p class="card-text">'.mb_substr($value['des'],0,20,"UTF-8").'</p>
				</div>
			  </div>
			</a>
		</div>
		';
		$active = '';
	}




?>
<!DOCTYPE html>
<html lang="en">

<head>

	<?php include icld.'head.php'; ?>

</head>

<body>

  <!-- Navigation -->
	<?php include icld.'nav.php'; ?>

  <!-- Carousel Silder Content -->
  <div class="container" <?=$ary_page['css']['banner1IsShow']?>>

	<!-- Carousel Header -->
	<header id="babyinCarousel" class="carousel slide">
	  <ol class="carousel-indicators" <?=$ary_page['css']['banner1Control']?>>
		<?=$ary_page['html']['banner1Dot']?>
	  </ol>
	  <div class="carousel-inner">
		<?=$ary_page['html']['banner1']?>
	  </div>
	  <a class="carousel-control-prev text-black-50 w-auto" href="#babyinCarousel" role="button" data-slide="prev" <?=$ary_page['css']['banner1Control']?>>
		<i class="fas fa-chevron-left"></i>
		<span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next text-black-50 w-auto" href="#babyinCarousel" role="button" data-slide="next" <?=$ary_page['css']['banner1Control']?>>
		<i class="fas fa-chevron-right"></i>
		<span class="sr-only">Next</span>
	  </a>
	</header>

  </div>
  <!-- Carousel Silder Content -->


  <!-- Page Content -->
  <div class="container py-4">
	<!-- Page Features -->
	<div class="row my-4" style="overflow-x: hidden; overflow-y: hidden;">
	  <div class="col-md-4 offset-md-1 col-12 mb-md-0 mb-4" data-aos="zoom-in-right" data-aos-delay="450" data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">
		<img src="./img/fea_01.png" class="img-fluid align-self-center" alt="...">
	  </div>
	  <div class="col-md-7 col-12 align-self-center" data-aos="zoom-in-left" data-aos-delay="450" data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">
		  <h3 class="font-weight-bold mt-0">獨一無二客製化商品</h3>
		  <h5 class="text-gold mt-0">純手工，精緻胎毛藝術工藝，藝術無價，精緻鑲工，把幸福一直延續下去</h5>
		  <p class="mb-0">從事印章業界十幾餘年，不忍其中國文化傳承5000多餘年之歷史，漸行漸遠逐漸沒落，故大膽創立印章界之潮品牌「babyin」寶貝印 印鑑工坊進而推廣實行精緻刻印之精神及其專業服務態度.望能持續推廣中國文化之美與傳承</p>
	  </div>
	</div>
  </div>
  <!-- Page Content -->
  
  <!-- Activity Message Content -->
  <div class="container mb-5">
	<h2 class="text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="300" data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">活動訊息</h2>
	<h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="350" data-aos-anchor-placement="top-bottom" data-aos-offset="0" data-aos-once="true">Activity Message</h4>
	<div class="row mx-auto my-auto">
	  <div id="MessageCarousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner row w-100 mx-auto" role="listbox">

		  <?=$ary_page['html']['news']?>
	
		</div>

		<a class="carousel-control-prev text-black-50 w-auto" href="#MessageCarousel" role="button" data-slide="prev">
		  <i class="fas fa-chevron-left"></i>
		  <span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next text-black-50 w-auto" href="#MessageCarousel" role="button" data-slide="next">
		  <i class="fas fa-chevron-right"></i>
		  <span class="sr-only">Next</span>
		</a>
	  </div>
	</div>
  </div>
  <!-- Activity Message Content -->

  <!-- Parrallax Scrolling Effect -->
  <section class="parrallax py-5">
	<div class="container my-md-4 my-0">
	  <div class="row mx-auto my-auto" style="overflow-x: hidden; overflow-y: hidden;">

		<div class="d-md-flex flex-md-equal w-100 pl-md-3 mb-5" data-aos="fade-down-left" data-aos-delay="100" data-aos-anchor-placement="top-bottom" data-aos-once="true">
		  <div class="col-md-6 offset-md-6 col-12 mr-md-3 px-3 px-md-5 text-center overflow-hidden">
			<div class="mx-auto">
			  <img src="<?=$ary_page['html']['banner2']['pic']['1']?>" class="img-fluid">
			</div>
			<div class="p-3">
			  <h3 class="text-black display-5"><?=$ary_page['html']['banner2']['title']['1']?></h3>
			  <p class="mb-0"><?=$ary_page['html']['banner2']['info']['1']?></p>
			</div>
			
		  </div>
		</div>

		<div class="d-md-flex flex-md-equal w-100 mt-n8 mt-sm-0 pl-md-3 mb-5" data-aos="fade-down-right" data-aos-delay="450" data-aos-anchor-placement="top-bottom" data-aos-once="true">
		  <div class="col-md-6 col-12 ml-md-3 px-3 px-md-5 text-center overflow-hidden">
			<div class="mx-auto">
			  <img src="<?=$ary_page['html']['banner2']['pic']['2']?>" class="img-fluid">
			</div>
			<div class="p-3">
			  <h3 class="text-black display-5"><?=$ary_page['html']['banner2']['title']['2']?></h3>
			  <p class="mb-0"><?=$ary_page['html']['banner2']['info']['2']?></p>
			</div>
		  </div>
		</div>

		<div class="d-md-flex flex-md-equal w-100 mt-n8 mt-sm-0 pl-md-3" data-aos="fade-up-left" data-aos-delay="800" data-aos-anchor-placement="top-bottom" data-aos-once="true">
		  <div class="col-md-6 offset-md-6 col-12 mr-md-3 px-3 px-md-5 text-center overflow-hidden">
			<div class="mx-auto">
			  <img src="<?=$ary_page['html']['banner2']['pic']['3']?>" class="img-fluid">
			</div>
			<div class="py-3">
			  <h3 class="text-black display-5"><?=$ary_page['html']['banner2']['title']['3']?></h3>
			  <p class="mb-0"><?=$ary_page['html']['banner2']['info']['3']?></p>
			</div>
		  </div>
		</div>

	  </div>
	</div>
  </section>
  <!-- Parrallax Scrolling Effect -->

  <!-- Contact us -->
  <div class="container my-3">
	<h2 class="text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="300" data-aos-offset="0" data-aos-once="true">
	  <span class="bg-white px-5 py-2">與我聯絡</span>
	</h2>
	<h4 class="text-center text-gold" data-aos="zoom-in-up" data-aos-delay="450" data-aos-offset="0" data-aos-once="true">
	  <span class="bg-white px-5">Contact Us</span>
	</h4>
	<hr class="w-100 my-0 mt-n4">
	<div class="row mx-auto my-5"style="overflow-x: hidden; overflow-y: hidden;">
	  <div class="col-md-6 col-sm-12 py-2" data-aos="zoom-in-right" data-aos-offset="0" data-aos-once="true">
		<h2 class="text-dark font-weight-bold"><img src="./img/logo_red.png">印鑑工坊</h2>
		<p class="text-justify mb-1">您好 歡迎來店挑選，我們將會有專人為您服務</p>
		<p class="text-justify mb-4">營業時間 : 上午09:00~晚上21:00(全年無休)</p>
		<div class="card no-border p0 map-container">
			
		</div>
	  </div>
	  <div class="col-md-6 col-sm-12 py-2"  data-aos="zoom-in-left" data-aos-offset="0" data-aos-once="true">
		<form class="needs-validation" name="sentMessage" id="contactForm" enctype="multipart/form-data" onsubmit="return checkform();">
		  <div class="form-group row">
			<label for="inputUsername" class="col-md-3 pr-md-0 col-sm-4 col-form-label text-right m-text-left"><span class="text-danger">*</span>姓名</label>
			<div class="col-md-9 col-sm-8">
			  <input type="username" class="form-control" id="inputUsername" name="name" placeholder="姓名" required>
			</div>
		  </div>

		  <div class="form-group row">
			<label for="inputPhone" class="col-md-3 pr-md-0 col-sm-4 col-form-label text-right m-text-left"><span class="text-danger">*</span>電話</label>
			<div class="col-md-9 col-sm-8">
			  <input type="phone" class="form-control" id="inputPhone" placeholder="電話" name="tel" required>
			</div>
		  </div>

		  <div class="form-group row">
			<label for="inputEmail" class="col-md-3 pr-md-0 col-sm-4 col-form-label text-right m-text-left"><span class="text-danger">*</span>Email</label>
			<div class="col-md-9 col-sm-8">
			  <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" required>
			</div>
		  </div>

		  <div class="form-group row">
			<label for="formTextarea" class="col-md-3 pr-md-0 col-sm-4 col-form-label text-right m-text-left"><span class="text-danger">*</span>留言</label>
			<div class="col-md-9 col-sm-8">
			  <textarea class="form-control" id="formTextarea" rows="5" required></textarea>
			</div>
		  </div>

		  <div class="form-group row mb-3">
			<label class="col-md-3 col-sm-4 col-form-label text-md-right pr-0 align-self-center"><span class="text-danger">*</span>輸入右方驗證碼</label>
			<div class="col-md-9 col-sm-8 align-self-center">
			  <div class="input-group">
				<input type="text" class="form-control align-self-center" id="verify" placeholder="" name="captcha" required>
				<div class="d-flex pl-2 align-self-center">
					<img src="uploads/captcha/<?=$_SESSION['captcha']['image_src']?>" width="68px" height="24px" class="img-fluid captchaImg" />
				</div>
				<div class="input-group-append">
				  <label class="refresh mn-0">
					<a class="btn btn-refresh hvr-icon-spin" style="cursor: pointer;">更換 <i class="fas fa-sync-alt hvr-icon px-1"></i>
					</a>
				  </label>
				</div>
			  </div>
			</div>
		  </div> 

		  <button class="btn btn-warning text-white bg-gold btn-lg btn-block border-0 col-md-9 offset-md-3 col-sm-10 offset-sm-2 hvr-grow" type="submit">確認送出</button>
		</form>
		
	  </div>
	</div>
  </div>
  <!-- Contact us -->

  <!-- /.container -->

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

  <!-- End of your HTML body -->
  <!-- <script src="./vendor/sakura/js/jquery-sakura.min.js"></script>
  <script>
	  // domReady
	  $(function() {
		  $('body').sakura();
	  });

	  // windowLoad
	  $(window).load(function() {
		  $('body').sakura();
	  });
  </script>
   -->
  <script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
	'use strict';
	window.addEventListener('load', function() {
	  // Fetch all the forms we want to apply custom Bootstrap validation styles to
	  var forms = document.getElementsByClassName('needs-validation');
	  // Loop over them and prevent submission
	  var validation = Array.prototype.filter.call(forms, function(form) {
		form.addEventListener('submit', function(event) {
		  if (form.checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
		  }
		  form.classList.add('was-validated');
		}, false);
	  });
	}, false);
  })();


		function checkform () {
			$('#loading').fadeIn(300,function(){
					$.ajax({
							type: "POST",
							url: 'proc.php?proc=contact',
							data: 'uname='+$('input[name="name"]').val()+
									'&tel='+$('input[name="tel"]').val()+
									'&email='+$('input[name="email"]').val()+
									'&info='+$('textarea').val()+
									'&captcha='+$('input[name="captcha"]').val(),
							error: function(xhr) {
								$('#loading').fadeOut();
								alert('網路錯誤');
							},
							success: function (data, status, xhr) {
								$('#loading').fadeOut();
								if(data == 'succ'){
									alert('感謝您的來信 ,我們已收到信件將會處理確認');
									// $('input').val('');
									// $('textarea').val('');
								}else if(data == 'captcha'){
									alert('驗證碼錯誤!');
								}else{
									// top.location.href = "./";
								}

							}
					});
			});
			return false;
		}


		$(function(){
			$('.btn-refresh').click(function(){
				$('#loading').fadeIn(300,function(){
						$.ajax({
								type: "POST",
								url: 'proc.php?proc=captcha',
								data: '',
								error: function(xhr) {
									$('#loading').fadeOut();
									alert('網路錯誤');
								},
								success: function (data, status, xhr) {
									$('#loading').fadeOut();
									$('.captchaImg').attr('src','uploads/captcha/'+data);

								}
						});
				});
			});


			$('.map-container').html('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3615.08330759507!2d121.49602831562903!3d25.031246744554526!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a9b1e1c611f5%3A0xb7f7029aa88763fc!2zMTA45Y-w5YyX5biC6JCs6I-v5Y2A6I6S5YWJ6LevMzAy6Jmf!5e0!3m2!1szh-TW!2stw!4v1561976370651!5m2!1szh-TW!2stw" width="100%" height="320" frameborder="0" style="border:0" allowfullscreen></iframe>');

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
