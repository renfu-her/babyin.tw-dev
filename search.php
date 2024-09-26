<?php
  require_once 'config.php';

  $pageNow = (isset($_GET['p']) and $_GET['p'] != '') ? intval($_GET['p']) : 1;

  $pageNum = 12;          //每頁呈現最大筆數


  $sqlStr = $ary_get['search'] ? " title like '%".$ary_get['search']."%' || 
                  subtitle like '%".$ary_get['search']."%' || 
                  info like '%".$ary_get['search']."%' " : header("Location:./");


  $ary_data = $obj_products -> fetchAll(' * ', $sqlStr." ORDER BY `sort` DESC ",True , array($pageNow-1 , $pageNum));

  foreach($ary_data as $value){
    $hotsale = $value['check2']=='1' ? '<b class="float-tag text-white bg-danger">熱賣</b>' : '';
    $orgPrice = $value['org_price'] ? '<h6 class="card-text">原價 NT$ '.number_format($value['org_price']).'</h6>' : '';
    $ary_page['html']['prod'] .= '
      <div class="col-lg-3 col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in" data-aos-delay="0" data-aos-anchor-placement="center-bottom">
        <a href="product_content.php?c='.$value['data_pkey'].'&p='.$value['pkey'].'">
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
        <a class="page-link rounded-circle" href="search.php?search='.$ary_get['search'].'&p='.($pageNow-1).'">
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
        <a class="page-link rounded-circle" href="search.php?search='.$ary_get['search'].'&p='.($pageNow+1).'">
            <i class="fas fa-chevron-right"></i>
            <span class="sr-only">下一頁</span>
        </a>
      </li>
    ';
  }

  for($i=1 ; $i<=$totalPage ; $i++){
    $ary_page['html']['pageList'] .= '
    <a class="dropdown-item" href="search.php?search='.$ary_get['search'].'&p='.$i.'">'.$i.'</a>  
    ';
  }

  if($totalPage == 1){
    $ary_page['css']['pageSelectShow'] = 'style="display:none;"';
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
  <header>
    <div class="container">
      <div class="row">
        <div class="col-12 px-md-0">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent justify-content-md-end">
              <li class="breadcrumb-item"><a href="./">首頁</a></li>
              <li class="breadcrumb-item active" aria-current="page">搜尋</li>
              <li class="breadcrumb-item active" aria-current="page"><?=$ary_get['search']?></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Content Start -->
  <article class="page-wrapper my-3">
    <div class="container">
      <section class="page-content">
        <div class="row">
          
          <?=$ary_page['html']['prod']?>


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
