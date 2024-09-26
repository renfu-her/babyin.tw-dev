<?php
  require_once 'config.php';


  $pageNow = (isset($_GET['p']) and $_GET['p'] != '') ? intval($_GET['p']) : 1;

  $pageNum = 10;          //每頁呈現最大筆數




  if($ary_get['c']){
    $sqlSeries = $ary_get['c'];
  }else{
    $sqlSeries = $ary_articleCategory['0']['pkey'];    
  }

  foreach($ary_articleCategory as $value){
    $active = $value['pkey']==$sqlSeries ? 'active' : '';
    if($value['pkey'] == $sqlSeries){
      $ary_page['html']['pageTitle'] = $value['title'];
    }
    $ary_page['html']['category'] .= '
      <li class="nav-item">
        <a class="nav-link '.$active.'" href="article-list.php?c='.$value['pkey'].'">'.$value['title'].'</a>
      </li>
    ';
  }


  $ary_prod = $obj_article -> fetchAll(' * ', " data_pkey = '".$sqlSeries."' ORDER BY `sort` DESC ",True , array($pageNow-1 , $pageNum));

  $delay = '500';
  foreach($ary_prod as $value){
    $ary_page['html']['article'] .= '
      <li data-aos="zoom-in-up" data-aos-delay="'.$delay.'" data-aos-anchor-placement="top-bottom" data-aos-once="true">
        <a href="article.php?c='.$sqlSeries.'&p='.$value['pkey'].'">
          <span class="pr-3">'.$value['adate'].'</span>'.$value['title'].'
        </a>
      </li>
    ';
    $delay += 100;
  }

  // echo '<pre>';
  // print_r($ary_prod);

  $totalPage = ceil($obj_article->num / $pageNum);

  if($pageNow <= 1){
    $ary_page['html']['prevBtn'] = '';
  }else{
    $ary_page['html']['prevBtn'] = '
      <li class="page-item pr-3">
        <a class="page-link rounded-circle" href="article-list.php?c='.$sqlSeries.'&p='.($pageNow-1).'">
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
        <a class="page-link rounded-circle" href="article-list.php?c='.$sqlSeries.'&p='.($pageNow+1).'">
            <i class="fas fa-chevron-right"></i>
            <span class="sr-only">下一頁</span>
        </a>
      </li>
    ';
  }

  for($i=1 ; $i<=$totalPage ; $i++){
    $ary_page['html']['pageList'] .= '
    <a class="dropdown-item" href="article-list.php?c='.$sqlSeries.'&p='.$i.'">'.$i.'</a>  
    ';
  }

  if($totalPage <= 1){
    $ary_page['css']['pageSelectShow'] = 'style="display:none;"';
  }


$ary_head['title'] = '文章專區-Babyin 寶貝印 印鑑工坊';
$ary_head['keyword'] = '印章店,刻印章,印章刻印,臍帶章價格,臍帶章推薦,做印章多久,印章店,刻印章,印章刻印,印章開運,手工印章,客製化印章';


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
              <li class="breadcrumb-item">認識印章</li>
              <li class="breadcrumb-item active" aria-current="page"><?=$ary_page['html']['pageTitle']?></li>
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
            <?=$ary_page['html']['category']?>
          </ul>
        </aside>

        <section class="col-md-9 col-sm-12">
          <div class="page-content">
            <div class="page-title">
              <h2 class="text-black text-center font-weight-bold mb-4" data-aos="zoom-in-up" data-aos-delay="150"><?=$ary_page['html']['pageTitle']?></h2>
            </div>

            <!-- 20200724 updated--> 
            <div class="list-group-row">
              <ul class="list-unstyled">
                <?=$ary_page['html']['article']?>
              </ul>
            </div>
          </div>
          <!-- 20200724 updated-->

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
