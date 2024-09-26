<?php
  require_once 'config.php';


  $ary_data = $obj_news->fetch('*' , " pkey = '".$ary_get['p']."' ");

  if(!$ary_data){header("Location:./");exit;}






$ary_head['title'] = '關於我們-Babyin 寶貝印 印鑑工坊';
$ary_head['keyword'] = '印章店,刻印章,印章刻印,臍帶章,肚臍章,臍帶印章,肚臍印章,手工印章,剃胎毛';




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
              <li class="breadcrumb-item active" aria-current="page"><?=$ary_nav['html']['brandTitle']?></li>
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
            <?=$ary_nav['html']['brand']?>
          </ul>
        </aside>
        <section class="col-md-9 col-sm-12">
          <div class="page-content">

            <!-- ********************* editor start here ********************* -->



            <?=$ary_data['info']?>



            <!-- ********************* editor end here ********************* -->

          </div>
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

  <script type="text/javascript">
    
    $(function(){

      $('img').addClass('img-fluid');

    });


  </script>

</body>

</html>
