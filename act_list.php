<?php
  require_once 'config.php';

  $ary_banner = $obj_banner->fetch('*' , " type = '3' ");

  $ary_page['html']['banner']['as'] = $ary_banner['url'] ? '<a href="'. $ary_banner['url'].'">' :'';
  $ary_page['html']['banner']['ae'] = $ary_banner['url'] ? '</a'. $ary_banner['url'].'">' :'';
  $ary_page['html']['banner'] = $ary_banner ? '
      <div class="page-banner text-center">
      '.$ary_page['html']['banner']['as'].'
        <img src="uploads/'.$ary_banner['pic'].'" class="img-fluid">
        '.$ary_page['html']['banner']['ae'].'
      </div>' : '';




  $pageNow = (isset($_GET['page']) and $_GET['page'] != '') ? intval($_GET['page']) : 1;

  $pageNum = 6;              //每頁呈現最大筆數

  $ary_data = $obj_news->fetchAll(' * ', "
                            is_brand = '0'
                                                      ORDER BY newsdate DESC ",True , array($pageNow-1 , $pageNum));

  $newsSpeed = '0';
  foreach($ary_data as $value){
    $ary_page['html']['news'] .= '
      <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-1 pr-2" data-aos="zoom-in" data-aos-delay="'.$newsSpeed.'" data-aos-anchor-placement="top-bottom">
        <a href="act_center.php?p='.$value['pkey'].'">
          <div class="card border-0">
            <img class="card-img-top img-fluid" src="uploads/'.$value['pic'].'" alt="">
            <div class="card-body px-0">
              <p class="card-text mb-1"><small class="text-gold">'.$value['newsdate'].'</small></p>
              <h5 class="card-title text-dark">'.$value['title'].'</h5>
              <p class="card-text">'.$value['des'].'</p>
            </div>
          </div>
        </a>
      </div>
    ';
    $newsSpeed += 150;
  }



  $totalPage = ceil($obj_news->num / $pageNum);

  if($pageNow <= 1){
    $ary_page['html']['prevBtn'] = '';
  }else{
    $ary_page['html']['prevBtn'] = '
      <li class="page-item pr-3">
        <a class="page-link rounded-circle" href="act_list.php?page='.($pageNow-1).'">
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
        <a class="page-link rounded-circle" href="act_list.php?page='.($pageNow+1).'">
            <i class="fas fa-chevron-right"></i>
            <span class="sr-only">下一頁</span>
        </a>
      </li>
    ';
  }

  if($totalPage == 1){
    $ary_page['css']['pageSelectShow'] = 'style="display:none;"';
  }


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
              <li class="breadcrumb-item active" aria-current="page">活動訊息</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </header>


  <!-- Page Content Start -->
  <article class="page-wrapper my-3">
    <div class="container">
      <?=$ary_page['html']['banner']?>

      <section>
        <div class="row">

          <?=$ary_page['html']['news']?>

        </div>
      </section>

      <nav class="my-5" aria-label="Page navigation">
        <ul class="pagination justify-content-center" <?=$ary_page['css']['pageSelectShow']?>>
          <?=$ary_page['html']['prevBtn']?>
          <li class="page-item">
            <div class="dropdown">  
              <button class="btn btn-light btn-page border dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">  
                 <?=$pageNow?>  
              </button>  
              <div class="page-menu dropdown-menu" aria-labelledby="dropdownMenuButton">  
              <?php
                for($i=1 ; $i<=$totalPage ; $i++){
                  echo '<a class="dropdown-item" href="act_list.php?page='.$i.'">'.$i.'</a>';
                }

              ?>
              </div>
            </div>
          </li>

          <?=$ary_page['html']['nextBtn']?>
        </ul>
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

</body>

</html>
