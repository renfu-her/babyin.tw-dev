<?php
  require_once 'config.php';


  if(!$_SESSION['cart']){
    header("Content-Type:text/html; charset=utf-8");
    echo '
    <script>
    alert("購物車沒有任何商品");
    top.location.href = "product_list.php";
    </script>
    ';
    exit;
  }
  if(!$_SESSION['login']){
    header("Location:./login.php");
    exit;
  }


  $ary_allSelect = $obj_products_select -> fetchAll_join();
  foreach($ary_allSelect as $value){
    $ary_allSelectRep[$value['pkey']] = $value['title'];
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
              <li class="breadcrumb-item active" aria-current="page">購物車</li>
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
        <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up">購物車</h2>
        <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="150">Shopping Cart</h4>
      </div>

      <section class="mx-md-5 my-md-2 m-sm-1" data-aos="fade-up" data-aos-delay="450">
        <div class="shopping-cart">
          <div class="table-responsive">
            <table class="table text-center cart-items">
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col">商品</th>
                  <th scope="col">規格</th>
                  <th scope="col">現金價</th>
                  <th scope="col">數量</th>
                  <th scope="col">小計</th>
                  <th scope="col">刪除</th>
                  <th scope="col"></th>
                </tr>
              </thead>

              <tbody>
                <?php                   foreach($_SESSION['cart'] as $value){
                    $ary_data = $obj_products -> fetch('*' , " pkey = '".$value['pkey']."' ");
                    $perProdTotal = $ary_data['price']*$value['total'];
                    $allProdTotal += $perProdTotal;
                ?>
                <tr class="cart-item">
                  <td scope="row"></td>
                  <td class="thumb-img align-middle">
                    <img class="item-img" src="./uploads/<?=$ary_data['listpic']?>" width="106px">
                  </td>
                  <td class="align-middle border-sm-top">
                    <span class="cart-tag d-block d-sm-none text-muted" disable>規格</span>
                    <div class="product-details text-md-left text-sm-center">
                      <a href="#">
                        <p class="mb-0"><?=$ary_data['title']?></p>
                        <p class="mb-0"><?=$ary_allSelectRep[$value['select1']]?></p>
                      </a>
                    </div>
                  </td>
                  <td class="align-middle border-sm-top">
                    <span class="cart-tag d-block d-sm-none text-muted" disable>單價</span>
                    <p class="mb-0">NT$<?=number_format($ary_data['price'])?></p>
                  </td>
                  <td class="quantity align-middle border-sm-top">
                    <span class="cart-tag d-block d-sm-none text-muted" disable>數量</span>
                    <div class="input-group num-row">
                      <button class="btn btn-minus btn-light border btn-sm"><i class="fa fa-minus"></i></button>
                      <input type="text" class="form-control bg-white text-center qty_input" ref="<?=$ary_data['price']?>" prod-data="<?=$value['pkey'].','.$value['select1']?>" value="<?=$value['total']?>">
                      <button class="btn btn-plus btn-light border btn-sm"><i class="fa fa-plus"></i></button>
                    </div>
                  </td>
                  <td class="total align-middle border-sm-top">
                    <span class="cart-tag d-block d-sm-none text-muted" disable>小計</span>
                    <p class="text-danger mb-0 money">NT$<?=number_format($perProdTotal)?></p>
                  </td>
                  <td class="align-middle border-sm-top">
                    <button type="button" class="btn bg-transparent border-0 hvr-buzz-out remove-item">
                      <i class="far fa-trash-alt"></i>
                    </button>
                  </td>
                  <td></td>
                </tr>
                <?php                   }
                ?>
              </tbody>
            </table>
          </div>

          <div class="col-sm-12 dot-line">
            <div class="row">
              <div class="col-sm-3 offset-sm-9 pb-3">
                <h5 class="shopping-free-tag text-danger">全館周年慶商品免運</h5>
              </div>
            </div>
          </div>
          
          <div class="col-sm-12 my-3">
            <div class="row">
              <div class="col-sm-3 offset-sm-9 col-xs-6 offset-xs-6">
                <h2 class="text-black mb-0">
                  總計
                  <span class="pl-3 priceTotalplusFee">NT<?=number_format($allProdTotal)?></span>
                </h2>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="row my-3">
              <div class="col-sm-3 offset-sm-9">
                <button class="btn btn-danger btn-purchase w-100 rounded-pill mb-3 cartNext" type="button">我要結帳</button>
                <button class="btn btn-danger btn-addcart w-100 rounded-pill mb-3" type="button" onclick="javascript:location.href='product_list.php'">繼續購物</button>
              </div>
            </div>
          </div>
        </div>
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
  <script>

    $(function(){

      $('.btn-plus').unbind('click').click(function(){
        var qty_input = $(this).parents('tr').find('.qty_input');
        var prodPrice = parseInt($(this).parents('tr').find('.qty_input').attr('ref'));
        var prodTotal = parseInt(qty_input.val());
        var prodTotalPrice = $(this).parents('tr').find('.money');
        qty_input.val((prodTotal+1));
        prodTotalPrice.html('NT$'+numberFormat(prodPrice*(prodTotal+1)));
        countTotal();
      });
      $('.btn-minus').unbind('click').click(function(){
        var qty_input = $(this).parents('tr').find('.qty_input');
        var prodPrice = parseInt($(this).parents('tr').find('.qty_input').attr('ref'));
        var prodTotal = parseInt(qty_input.val());
        var prodTotalPrice = $(this).parents('tr').find('.money');
        if((prodTotal-1) <= 1){
          prodTotal = 1;
        }else{
          prodTotal = prodTotal -1;
        }
        qty_input.val(prodTotal);
        prodTotalPrice.html('NT$'+numberFormat(prodPrice*prodTotal));
        countTotal();
      });

      $('.qty_input').unbind('keyup').keyup(function(){
        var prodPrice = parseInt($(this).attr('ref'));
        var prodTotalPrice = $(this).parents('tr').find('.money');
        if(parseInt($(this).val()) <= 0 || $(this).val() == ''){
          $(this).val(1);
        }
        prodTotalPrice.html('NT$'+numberFormat(prodPrice*parseInt($(this).val()) ) );
        countTotal();
      });

      $('.remove-item').click(function(){
        var removeTr = $(this).parents('tr');
        removeTr.remove();
        countProdNow('shopping_1.php');
      });

      $('.cartNext').click(function(){
        countProdNow('shopping_2.php');
      });


      function countTotal(){
        var allProdTotal = 0;
        $('.cart-item').each(function(ind, ele){
          var prodPrice = parseInt($(ele).find('.qty_input').attr('ref'));
          var prodTotal = parseInt($(ele).find('.qty_input').val());
          allProdTotal += prodPrice*prodTotal;
        });
        $('.priceTotalplusFee').html('NT'+numberFormat(allProdTotal));
      }

      function countProdNow(nextPage){
        $('#loading').fadeIn(300,function(){
          var allProdData = '';
          $('.cart-item').each(function(ind, ele){
            var prodData = $(ele).find('.qty_input').attr('prod-data');
            var prodTotal = $(ele).find('.qty_input').val();
            allProdData += prodData+','+prodTotal+'|||';
          });
          $.ajax({
              type: "POST",
              url: 'proc.php?proc=renewCart',
              data: 'data='+allProdData,
              error: function(xhr) {
                $('#loading').fadeOut();
                alert('網路錯誤');
              },
              success: function (data, status, xhr) {
                top.location.href = nextPage;
              }
          });
        });

      }

    });



  function numberFormat(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }
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