<?php
  require_once 'config.php';


  $ary_article = $obj_article -> fetch(' * ', " pkey = '".$ary_get['p']."' ");
  $ary_category = $obj_article_category -> fetch(' * ', " pkey = '".$ary_get['c']."' ");

  if(!$ary_article || !$ary_category){
    header("Location:./article-list.php");
    exit;
  }

  foreach($ary_articleCategory as $value){
    $active = $value['pkey']==$ary_category['pkey'] ? 'active' : '';
    $ary_page['html']['category'] .= '
      <li class="nav-item">
        <a class="nav-link '.$active.'" href="article-list.php?c='.$value['pkey'].'">'.$value['title'].'</a>
      </li>
    ';
  }




  $ary_page['html']['pageTitle'] = $ary_article['title'];
  $ary_page['html']['categoryTitle'] = $ary_category['title'];
  $ary_page['html']['categoryPkey'] = $ary_category['pkey'];

  $ary_page['html']['pageDate'] = $ary_article['adate'];
  $ary_page['html']['pageContent'] = $ary_article['info'];



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
              <li class="breadcrumb-item"><a href="article-list.php?c=<?=$ary_page['html']['categoryPkey']?>">認識印章</a></li>
              <li class="breadcrumb-item"><a href="article-list.php?c=<?=$ary_page['html']['categoryPkey']?>"><?=$ary_page['html']['categoryTitle']?></a></li>
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
            <div class="page-title mb-4">
              <h2 class="d-inline-block text-black text-left font-weight-bold"><?=$ary_page['html']['pageTitle']?></h2>
              <span class="p-t14 text-gold"><?=$ary_page['html']['pageDate']?></span>
            </div>

            <div class="editor">
              <?=$ary_page['html']['pageContent']?>
            </div>
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

</body>

</html>
