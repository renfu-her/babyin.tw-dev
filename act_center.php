<?php
  require_once 'config.php';

  $ary_data = $obj_news->fetch('*' , " pkey = '".$ary_get['p']."' ");


  $ary_prevItem = $obj_news->fetch('*' , " newsdate > '".$ary_data['newsdate']."' order by newsdate ASC ");
  $ary_nextItem = $obj_news->fetch('*' , " newsdate < '".$ary_data['newsdate']."' order by newsdate DESC ");


  $ary_page['html']['htmlPrev'] = $ary_prevItem ? '
    <li class="pager-item">
      <a href="act_center.php?p='.$ary_prevItem['pkey'].'" class="anime-up">
        <i class="fas fa-chevron-up text-danger"></i>
        <span class="mx-3">上一則</span>    
        <span>'.$ary_prevItem['title'].'</span>
      </a>
    </li>' : '';
  $ary_page['html']['htmlNext'] = $ary_nextItem ? '
    <li class="pager-item">
      <a href="act_center.php?p='.$ary_nextItem['pkey'].'" class="anime-down">
        <i class="fas fa-chevron-down text-danger"></i>
        <span class="mx-3">下一則</span>    
        <span>'.$ary_nextItem['title'].'</span>
      </a>
    </li>' : '';

  $ary_page['html']['htmlSp'] = $ary_page['html']['htmlPrev']&&$ary_page['html']['htmlNext'] ? '<li class="pager-item"><hr class="gold-dot"></li>' : '';



$ary_head['title'] = '活動訊息-Babyin 寶貝印 印鑑工坊';
$ary_head['keyword'] = '印章店,刻印章,印章刻印,臍帶章,肚臍章,臍帶印章,肚臍印章,臍帶章價格,臍帶章推薦,印章開運,剃胎毛';


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
              <li class="breadcrumb-item active" aria-current="page"><a href="./act_list.php">活動訊息</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?=$ary_data['title']?></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </header>


  <!-- Page Content Start -->
  <article class="page-wrapper my-3">
    <div class="container">
      <div class="page-title">
        <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up"><?=$ary_data['title']?><small class="d-inline-block p-t14 text-gold mb-md-3 mb-3 px-2"><?=$ary_data['newsdate']?></small></h2>
        <p class="text-center mb-4" data-aos="zoom-in-up" data-aos-delay="150"><?=$ary_data['des']?></p>      
      </div>

      <section class="my-5" data-aos="zoom-in" data-aos-delay="450">
        <?=$ary_data['info']?>
      </section>

      <nav class="my-5 d-md-block d-none">
        <ul class="pager"> 
          <?=$ary_page['html']['htmlPrev']?> 
          <?=$ary_page['html']['htmlSp']?>
          <?=$ary_page['html']['htmlNext']?> 
        </ul>  
      </nav>

      <nav class="my-5" aria-label="Page navigation">
        <div class="pagination justify-content-center">
          <a class="btn btn-light btn-page rounded border" href="act_list.php" value="回列表">回列表</a>  
        </div>
      </nav>

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
  <script type="text/javascript">
    
    $(function(){

      $('img').addClass('img-fluid');

    });


  </script>

</body>

</html>
