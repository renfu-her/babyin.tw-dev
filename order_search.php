<?php   require_once 'config.php';

  if(!$_SESSION['login']){
    header("Location:./login.php");
    exit;
  }


  $pageNow = (isset($_GET['p']) and $_GET['p'] != '') ? intval($_GET['p']) : 1;

  $pageNum = 10;          //每頁呈現最大筆數

  $dateLimit = date('Y-m-d H:i:s', ( time() - ( 90*24*60*60 ) ));

  $ary_data = $obj_order -> fetchAll(' * ', " data_pkey = '".$_SESSION['login']['pkey']."' AND createdate > '".$dateLimit."' ORDER BY `pkey` DESC ",True , array($pageNow-1 , $pageNum));

  $totalPage = ceil($obj_order->num / $pageNum);

  if($pageNow <= 1){
    $ary_page['html']['prevBtn'] = '';
  }else{
    $ary_page['html']['prevBtn'] = '
      <li class="page-item pr-3">
        <a class="page-link rounded-circle" href="order_search.php?p='.($pageNow-1).'">
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
        <a class="page-link rounded-circle" href="order_search.php?p='.($pageNow+1).'">
            <i class="fas fa-chevron-right"></i>
            <span class="sr-only">下一頁</span>
        </a>
      </li>
    ';
  }

  for($i=1 ; $i<=$totalPage ; $i++){
    $ary_page['html']['pageList'] .= '
    <a class="dropdown-item" href="order_search.php?p='.$i.'">'.$i.'</a>  
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
              <li class="breadcrumb-item active" aria-current="page">訂單查詢</li>
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
        <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up">訂單查詢</h2>
        <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="150">Order Tracking</h4>
      </div>

      <section data-aos="fade-up" data-aos-delay="450">
        <div class="order-track">
          <span class="hint hint-touch1"><i class="fas fa-hand-point-left"></i>請向左滑</span>
          <div class="table-responsive-sm touch_table1">
            <table class="table text-center">
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col">訂購日期</th>
                  <th scope="col">訂單編號</th>
                  <th scope="col">商品</th>
                  <th scope="col">買付金額</th>
                  <th scope="col">付款狀態</th>
                  <th scope="col">出貨狀態</th>
                  <th scope="col"></th>
                </tr>
              </thead>

              <tbody>
                <?php                   foreach($ary_data as $value){
                    $ary_order = $obj_order_list -> fetchAll('*' , " data_pkey = '".$value['pkey']."' ");
                ?>
                <tr>
                  <th scope="row"></th>
                  <td class="align-middle"><?=date('Y/m/d',strtotime($value['createdate']))?></td>
                  <td class="align-middle"><?=$value['orderno']?></td>
                  <td class="align-middle text-left">
                  <?php                   foreach($ary_order as $value2){
                    echo '
                    <span class="mb-0">'.$value2['prod_title'].'</span> 
                    <p class="mb-0">'.$value2['s1_title'].' * '.$value2['total'].'</p>
                    <br>
                    ';
                  }
                  ?>
                  </td>
                  <td class="align-middle">NT$<?=number_format($value['total'])?></td>
                  <td class="align-middle">
                    <?php                     if($value['status'] == '3'){
                      echo '已付款';
                    }else{
                      echo $ary_config['orderStatus'][$value['status']]['title'];
                    }
                    ?>
                  </td>
                  <td class="align-middle">
                    <?php                     if($value['status'] == '3'){
                      echo '已出貨';
                    }else if($value['status'] == '4'){
                      echo '作廢';
                    }else{
                      echo '備貨中';
                    }
                    ?>
                  </td>
                  <td></td>
                </tr>
                <?php                   }
                ?>
              </tbody>
            </table>
          </div>

          <div class="col-sm-12 dot-line-top">
            <div class="row pt-4 p-t14">
              <div class="col-md-1 col-2 pr-0 text-md-right text-sm-left">註 :</div>
              <div class="col-md-11 col-10 pl-0 pb-3">
                <ol class="pl-md-4 pl-0">
                  <li>商品將於您付款成功後45~60個工作天左右送達。</li>
                  <li>以上資料僅保留六個月內</li>
                </ol>
              </div>
            </div>
          </div>
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
                <?=$ary_page['html']['pageList']?> 
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