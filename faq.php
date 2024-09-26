<?php
	require_once 'config.php';


	$pageNow = (isset($_GET['p']) and $_GET['p'] != '') ? intval($_GET['p']) : 1;

	$pageNum = 10;          //每頁呈現最大筆數


	$ary_series = $obj_faq_category -> fetchAll_join('*' , " order by sort DESC ");


	if($ary_get['c']){
		$sqlSeries = $ary_get['c'];
	}else{
		$sqlSeries = $ary_series['0']['pkey'];		
	}

	foreach($ary_series as $key => $value){

		$active = $value['pkey']==$sqlSeries ? 'active' : '';

		$ary_page['html']['submenu'] .= '
			<li class="nav-item">
				<a class="nav-link '.$active.'" href="faq.php?c='.$value['pkey'].'">'.$value['title'].'</a>
			</li>
		';
		if($value['pkey']==$sqlSeries){
			$ary_page['html']['categoryTitle'] = $value['title'];
		}

	}

	$ary_faq = $obj_faq -> fetchAll(' * ', " data_pkey = '".$sqlSeries."' ORDER BY `sort` DESC ",True , array($pageNow-1 , $pageNum));

	$faqDelay = 500;
	foreach($ary_faq as $key => $value){

		$ary_page['html']['faq'] .= '

			<div class="card mb-3" data-aos="zoom-in-up" data-aos-delay="'.$faqDelay.'" data-aos-anchor-placement="top-bottom" data-aos-once="true">
				<div class="card-header" id="heading1">
				  <h2 class="mb-0">
					<button class="btn btn-link collapsed d-flex align-items-center" type="button" data-toggle="collapse" data-target="#faq'.$key.'" aria-expanded="false" aria-controls="faq'.$key.'">
					  <i class="fas fa-question-circle pr-2"></i>
					  '.$value['title'].'
					</button>
				  </h2>
				</div>
				<div id="faq'.$key.'" class="collapse" aria-labelledby="heading1" data-parent="#faqAccordion">
				  <div class="card-body">
					'.$value['info'].'
				  </div>
				</div>
			</div>

		';
		$faqDelay += 100;
	}

	// echo '<pre>';
	// print_r($ary_prod);

	$totalPage = ceil($obj_faq->num / $pageNum);

	if($pageNow <= 1){
		$ary_page['html']['prevBtn'] = '';
	}else{
		$ary_page['html']['prevBtn'] = '
			<li class="page-item pr-3">
				<a class="page-link rounded-circle" href="faq.php?c='.$sqlSeries.'&p='.($pageNow-1).'">
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
				<a class="page-link rounded-circle" href="faq.php?c='.$sqlSeries.'&p='.($pageNow+1).'">
						<i class="fas fa-chevron-right"></i>
						<span class="sr-only">下一頁</span>
				</a>
			</li>
		';
	}

	for($i=1 ; $i<=$totalPage ; $i++){
		$ary_page['html']['pageList'] .= '
		<a class="dropdown-item" href="faq.php?c='.$sqlSeries.'&p='.$i.'">'.$i.'</a>  
		';
	}

	if($totalPage == 1){
		$ary_page['css']['pageSelectShow'] = 'style="display:none;"';
	}

$ary_head['title'] = '常見問答-Babyin 寶貝印 印鑑工坊';
$ary_head['keyword'] = '印章店,刻印章,印章刻印,肚臍章,臍帶印章,肚臍印章,臍帶章價格,臍帶章推薦,印章開運,手工印章,客製化印章';


?>
<!DOCTYPE html>
<html lang="en">

<head>

	<?php  include icld.'head.php'; ?>

</head>

<body>

  <!-- Navigation -->
	<?php  include icld.'nav.php'; ?>
	<header>
		<div class="container">
		  <div class="row">
		    <div class="col-12 px-md-0">
		      <nav aria-label="breadcrumb">
		        <ol class="breadcrumb bg-transparent justify-content-md-end">
		          <li class="breadcrumb-item"><a href="./">首頁</a></li>
		          <li class="breadcrumb-item active" aria-current="page">常見問答</li>
		          <li class="breadcrumb-item active" aria-current="page"><?php echo $ary_page['html']['categoryTitle']?></li>
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
		<aside class="sidebar col-md-3">
		  <ul class="nav flex-column">
			<?php echo $ary_page['html']['submenu']?>
		  </ul>
		</aside>

		<section class="col-md-9 col-sm-12">
		  <div class="page-content">
			<div class="page-title">
			  <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="150">常見問題</h2>
			  <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="300">Q & A</h4>
			</div>

			<div class="faq accordion" id="faqAccordion">

				<?php echo $ary_page['html']['faq']?>
		  
			</div>

		  </div>

		  <nav class="my-5" aria-label="Page navigation">
			<ul class="pagination justify-content-center" <?php echo $ary_page['css']['pageSelectShow']?>>
				<?php echo $ary_page['html']['prevBtn']?>
			  <li class="page-item">
				<div class="dropdown">  
				  <button class="btn btn-light btn-page border dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">  
					<?php echo $pageNow?>
				  </button>  
				  <div class="page-menu dropdown-menu" aria-labelledby="dropdownMenuButton">  
						<?php echo $ary_page['html']['pageList']?>
				  </div>  
				</div>
			  </li>
	
				<?php echo $ary_page['html']['nextBtn']?>
			</ul>
		  </nav>

		</section>

		
	  </div>
	</div>
  </article>
  <!-- Page Content End -->

  <!-- Footer -->
	<?php  include icld.'footer.php'; ?>

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
