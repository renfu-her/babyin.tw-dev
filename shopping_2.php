<?php
  require_once 'config.php';
  include "uploads/captcha/simple-php-captcha.php";
  $_SESSION['captcha'] = simple_php_captcha();


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
        <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up">我要結帳</h2>
        <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="150">Checkout</h4>
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
                      <p class="mb-0"><?=$ary_data['title']?></p>
                      <p class="mb-0"><?=$ary_allSelectRep[$value['select1']]?></p>
                    </div>
                  </td>
                  <td class="align-middle border-sm-top">
                    <span class="cart-tag d-block d-sm-none text-muted" disable>單價</span>
                    <p class="mb-0">NT$<?=number_format($ary_data['price'])?></p>
                  </td>
                  <td class="quantity align-middle border-sm-top">
                    <span class="cart-tag d-block d-sm-none text-muted" disable>數量</span>
                    <p class="mb-0"><?=$value['total']?></p>
                  </td>
                  <td class="total align-middle border-sm-top">
                    <span class="cart-tag d-block d-sm-none text-muted" disable>小計</span>
                    <p class="text-danger mb-0">NT$<?=number_format($perProdTotal)?></p>
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
                <h5 class="text-danger">全館周年慶商品免運</h5>
              </div>
            </div>
          </div>

          <div class="col-sm-12 my-3">
            <div class="row">
              <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6">
                <h2 class="text-black mb-0">
                  總計
                  <span class="pl-3">NT<?=number_format($allProdTotal)?></span>
                </h2>
              </div>
            </div>
          </div>

          <form class="w-100" method="post" action="proc.php?proc=shoppingFinish" enctype="multipart/form-data">
            <div class="col-sm-12 border rounded mt-3">
              <div class="form-group row m-3">
                <legend  class="col-form-label col-sm-3 text-md-right text-sm-left text-danger align-self-center">
                  <h3 class="mb-0">付款方式</h3>
                </legend >
                <div class="col-sm-9 align-self-center">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="payment" id="inlineRadio1" value="1" checked>
                    <label class="form-check-label" for="inlineRadio1">線上刷卡</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="payment" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">ATM轉帳</label>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="col-sm-12 border rounded mt-3">

              <div class="form-group row m-3">
                <div class="col-md-3 col-sm-12 align-self-center">
                  <h3 class="text-md-right text-sm-left text-danger mb-0">收貨人資訊</h3>
                </div>
                <div class="col-md-9 col-sm-12 align-self-center">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="sameAsMember">
                    <label class="form-check-label" for="gridCheck1">同訂購人資料</label>
                  </div>
                </div>
              </div>

              <div class="form-group row m-3">
                <div class="col-md-9 offset-md-3 col-sm-12">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center" for="name"><span class="text-danger">*</span>收貨姓名</label>
                    <div class="col-sm-6 align-self-center">
                      <input ref="<?=$_SESSION['login']['uname']?>" type="text" class="form-control" id="name" placeholder="請填真實姓名" required name="uname">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center"><span class="text-danger">*</span>性別</label>
                    <div class="col-sm-6 align-self-center">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="1" checked ref="<?=$_SESSION['login']['gender']?>">
                        <label class="form-check-label" for="male">男</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="2" ref="<?=$_SESSION['login']['gender']?>">
                        <label class="form-check-label" for="female">女</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center" for="phone"><span class="text-danger">*</span>聯絡電話</label>
                    <div class="col-sm-6 align-self-center">
                      <input type="text" class="form-control" id="phone" placeholder="" required name="tel" ref="<?=$_SESSION['login']['tel']?>">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center" for="shippment"><span class="text-danger">*</span>寄送方式</label>
                    <div class="col-sm-6 align-self-center">
                      <select id="shippment" class="form-control" name="shippment" data-width="fit">
                        <option value="0">請選擇</option>
                        <option value="1">郵寄</option>
                        <option value="2">到店自取</option>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group row addr" style="display:none;">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left"><span class="text-danger">*</span>寄送地址</label>
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                          <select id="city" class="form-control checkSameMember" name="city" data-width="fit" ref="<?=$_SESSION['login']['city']?>">
                          </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                          <select id="city" class="form-control" name="district" data-width="fit" ref="<?=$_SESSION['login']['district']?>">
                            <option value="0" >鄉鎮市區</option>
                          </select>
                        </div>
                        <div class="col-md-12 col-sm-12">
                          <input type="text" class="form-control" id="address" placeholder="" required name="addr" ref="<?=$_SESSION['login']['addr']?>">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row timeslot" style="display:none;">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center" for="timeslot"><span class="text-danger">*</span>取貨時段</label>
                    <div class="col-sm-6 align-self-center">
                      <select id="timeslot" class="form-control" name="timeslot" data-width="fit">
                        <option value="0" selected="" disabled="">請選擇</option>
                        <option value="09:00-10:00">09:00-10:00</option>
                        <option value="10:00-11:00">10:00-11:00</option>
                        <option value="11:00-12:00">11:00-12:00</option>
                        <option value="12:00-13:00">12:00-13:00</option>
                        <option value="13:00-14:00">13:00-14:00</option>
                        <option value="14:00-15:00">14:00-15:00</option>
                        <option value="15:00-16:00">15:00-16:00</option>
                        <option value="16:00-17:00">16:00-17:00</option>
                        <option value="17:00-18:00">17:00-18:00</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row atmCode" style="display:none;">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center" for="bankaccount"><span class="text-danger">*</span>匯款帳號</label>
                    <div class="col-sm-6 align-self-center">
                      <input type="text" class="form-control" id="bankaccount" placeholder="提供帳號後五碼" required name="bankaccount">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left" for="note">訂購備註</label>
                    <div class="col-sm-6">
                      <textarea class="form-control" rows="5" id="note" name="info"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col -->


            <div class="col-sm-12 border rounded mt-3" style="display:none;">

              <div class="form-group row m-3">
                <legend  class="col-form-label col-sm-3 text-md-right text-sm-left text-danger align-self-center">
                  <h3 class="mb-0">開立發票</h3>
                </legend >
                <div class="col-sm-9 align-self-center">
                  <div class="form-check form-check-inline mr-0">
                    <input class="form-check-input" type="radio" name="receipt" id="donate" value="1" checked>
                    <label class="form-check-label" for="donate">公益捐贈</label>
                  </div>
                  <div class="form-check form-check-inline mx-1">
                    <input class="form-check-input" type="radio" name="receipt" id="receipt2" value="2">
                    <label class="form-check-label" for="receipt2">二聯式</label>
                  </div>
                  <div class="form-check form-check-inline mr-0">
                    <input class="form-check-input" type="radio" name="receipt" id="receipt3" value="3">
                    <label class="form-check-label" for="receipt3">三聯式</label>
                  </div>
                </div>
              </div>

              <div class="form-group row m-3 invoiceArea" style="display:none;">
                <div class="col-md-9 offset-md-3 col-sm-12">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label text-md-right text-sm-left align-self-center pr-0" for="note">發票寄送地址</label>
                    <div class="col-sm-6 align-self-center">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="idCheck1" name="invoiceSameAsMember">
                        <label class="form-check-label" for="idCheck1">同訂購人資料</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                          <select id="city" class="form-control invoiceCheckSameMember" data-width="fit" name="invoiceCity" data-width="fit" ref="<?=$_SESSION['login']['city']?>">
                          </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                          <select id="city" class="form-control" name="invoiceDistrict" data-width="fit">
                            <option value="0" >鄉鎮市區</option>
                          </select>
                        </div>
                        <div class="col-md-12 col-sm-12">
                          <input type="text" class="form-control" id="address" placeholder="" required name="invoiceAddr" ref="<?=$_SESSION['login']['addr']?>">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row invoiceTitleArea">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center" for="billtitle">發票抬頭</label>
                    <div class="col-sm-6 align-self-center">
                      <input type="text" class="form-control" id="billtitle" placeholder="發票抬頭" name="invoiceTitle">
                    </div>
                  </div>

                  <div class="form-group row invoiceTitleArea">
                    <label class="col-sm-2 col-form-label pr-0 text-md-right text-sm-left align-self-center" for="taxid">發票統編</label>
                    <div class="col-sm-6 align-self-center">
                      <input type="text" class="form-control" id="taxid" placeholder="發票統編" name="invoiceTaxid">
                    </div>
                  </div>

                </div>
              </div>
            </div>
  
            <div class="col-sm-12 sum-row">
              <div class="form-group row mt-4">
                <div class="col-md-9 offset-md-3 col-sm-12">
                  <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label text-md-right px-0 align-self-center">
                      <span class="text-danger">*</span>輸入右方驗證碼
                    </label>
                    <div class="col-sm-6 align-self-center">
                      <div class="input-group">
                        <input type="text" class="form-control align-self-center" id="verify" placeholder="" required name="captcha">
                        <div class="d-flex pl-2 align-self-center">
                          <img src="uploads/captcha/<?=$_SESSION['captcha']['image_src']?>" width="68px" height="24px" class="img-fluid captchaImg"/>
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
  
                  <div class="form-group row">
                    <div class="col-sm-6 offset-sm-2">
                      <button type="submit" class="btn btn-danger btn-purchase w-100 rounded-pill mb-3 px-5 py-3 shoppingFinish">訂購完成</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          

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
  <script src="js/address.js"></script>
  <script>

    $(function(){

      var citySelected = '';
      var districtSelected = '<?=$_SESSION['login']['district']?>';
      var selectedHtml = '';

      var cityContent = '<option value="0" >縣市</option>';

      Object.keys(address).forEach(function (key) {
        selectedHtml = citySelected==key ? 'selected="selected"' : '';
        cityContent += '<option value="'+key+'" '+selectedHtml+' >'+key+'</option>';
      });

      $('select[name="city"]')
        .html(cityContent)
        .change(function(){
          if($('select[name="city"] option:SELECTED').val() == 0){
            $('select[name="district"]').html('<option value="0" >請選擇縣市</option>');
          }else{
            var distContent = '';
            address[$('select[name="city"] option:SELECTED').val()].forEach(function (key, value) {
              selectedHtml = districtSelected==key ? 'selected="selected"' : '';
              distContent += '<option value="'+key+'" '+selectedHtml+' >'+key+'</option>';
            });
            $('select[name="district"]').html('').html(distContent);
          }
        });

      $('select[name="invoiceCity"]')
        .html(cityContent)
        .change(function(){
          if($('select[name="invoiceCity"] option:SELECTED').val() == 0){
            $('select[name="invoiceDistrict"]').html('<option value="0" >請選擇縣市</option>');
          }else{
            var distContent = '';
            address[$('select[name="invoiceCity"] option:SELECTED').val()].forEach(function (key, value) {
              selectedHtml = districtSelected==key ? 'selected="selected"' : '';
              distContent += '<option value="'+key+'" '+selectedHtml+' >'+key+'</option>';
            });
            $('select[name="invoiceDistrict"]').html('').html(distContent);
          }
        });
        

      $('input[name="payment"]').change(function(){
        if($('input[name="payment"]:checked').val() == '2'){
          $('.atmCode').show();
        }else{
          $('.atmCode').hide();
        }
        // countTotal();
      });

      $('select[name="shippment"]').change(function(){
        if($('select[name="shippment"] option:SELECTED').val() == '1'){
          $('.timeslot').hide();
          $('.addr').show();
        }else if($('select[name="shippment"] option:SELECTED').val() == '2'){
          $('.timeslot').show();
          $('.addr').hide();
        }else if($('select[name="shippment"] option:SELECTED').val() == '0'){
          $('.timeslot').hide();
          $('.addr').hide();
        }
        // countTotal();
      });




      $('input[name="sameAsMember"]').click(function(){
        if($('input[name="sameAsMember"]').is(':checked')){
          $('input[name="uname"]').val( $('input[name="uname"]').attr('ref') );
          $('input[name="tel"]').val( $('input[name="tel"]').attr('ref') );
          $('input[name="addr"]').val( $('input[name="addr"]').attr('ref') );
          $('input[name="gender"][value="'+$('input[name="gender"]').attr('ref')+'"]').prop("checked", true);
          $('.checkSameMember').each(function(ind, ele){
            var sameValue = $(ele).attr('ref');
            $(ele)
              .find('option[value="'+sameValue+'"]')
              .prop("selected", true);
          });
          $('select[name="city"]').change();
        }else{
          $('input[name="uname"]').val( '' );
          $('input[name="tel"]').val( '' );
          $('input[name="addr"]').val( '' );
          $('input[name="gender"]').prop("checked", false);
          $('.checkSameMember').each(function(ind, ele){
            var sameValue = $(ele).attr('ref');
            $(ele)
              .find('option')
              .prop("selected", false);
          });
          $('select[name="city"]').change();
        }
      });

      $('input[name="invoiceSameAsMember"]').click(function(){
        if($('input[name="invoiceSameAsMember"]').is(':checked')){
          $('input[name="invoiceAddr"]').val( $('input[name="invoiceAddr"]').attr('ref') );
          $('.invoiceCheckSameMember').each(function(ind, ele){
            var sameValue = $(ele).attr('ref');
            $(ele)
              .find('option[value="'+sameValue+'"]')
              .prop("selected", true);
          });
          $('select[name="invoiceCity"]').change();
        }else{
          $('input[name="invoiceAddr"]').val( '' );
          $('.invoiceCheckSameMember').each(function(ind, ele){
            var sameValue = $(ele).attr('ref');
            $(ele)
              .find('option')
              .prop("selected", false);
          });
          $('select[name="invoiceCity"]').change();
        }
      });


      $('input[name="receipt"]').click(function(){
        if($('input[name="receipt"]:checked').val() == '1'){
          $('.invoiceArea').hide();
        }else{
          $('.invoiceArea').show();
        }
        if($('input[name="receipt"]:checked').val() == '2'){
          $('.invoiceTitleArea').hide();
        }else{
          $('.invoiceTitleArea').show();
        }

      });


      $('.shoppingFinish').click(function(){

        if(!$('input[name="payment"]:checked').val()){
          alert('請選擇付款方式');
          return false;
        }else if($('input[name="payment"]:checked').val()=='2' && $('input[name="bankaccount"]').val()==''){
          alert('請填寫匯款帳號');
          return false;
        }else if($('input[name="uname"]').val()==''){
          alert('請填寫收貨姓名');
          return false;
        }else if(!$('input[name="gender"]:checked').val()){
          alert('請選擇性別');
          return false;
        }else if($('input[name="tel"]').val()==''){
          alert('請填寫聯絡電話');
          return false;
        }else if($('select[name="shippment"] option:SELECTED').val()=='0'){
          alert('請選擇寄送方式');
          return false;
        }else if($('select[name="shippment"] option:SELECTED').val() == '1' && ($('input[name="addr"]').val()=='' || $('select[name="city"] option:SELECTED').val() == '0' || $('select[name="district"] option:SELECTED').val() == '0') ){
          alert('請填寫正確地址');
          return false;
        }else if($('select[name="shippment"] option:SELECTED').val() == '2' && $('select[name="timeslot"] option:SELECTED').val() == '0'){
          alert('請選擇取貨時段');
          return false;
        }

        // if(!$('input[name="receipt"]:checked').val()){
        //   alert('請選擇開立發票方式');
        //   return false;
        // }else if($('input[name="receipt"]:checked').val()!='1' && ( $('select[name="invoiceCity"] option:SELECTED').val()=='0' || $('select[name="invoiceDistrict"] option:SELECTED').val()=='0' || $('input[name="invoiceAddr"]').val()=='') ){
        //   alert('請選擇發票寄送正確地址');
        //   return false;
        // }else if($('input[name="receipt"]:checked').val()=='3' && ( $('input[name="invoiceTitle"]').val()=='' || $('input[name="invoiceTaxid"]').val()=='' ) ){
        //   alert('請填寫發票抬頭&發票統編');
        //   return false;
        // }

        $('#loading').fadeIn(300,function(){
          $.ajax({
              type: "POST",
              url: 'proc.php?proc=shoppingFinishCaptcha',
              data: '&captcha='+$('input[name="captcha"]').val(),
              error: function(xhr) {
                $('#loading').fadeOut();
                alert('網路錯誤');
              },
              success: function (data, status, xhr) {
                if(data == 'captcha'){
                  $('#loading').fadeOut();
                  alert('驗證碼錯誤!');
                }else{
                  $('form').submit();
                }

              }
          });
        });
        

      });




      function countTotal(){
        var allProdTotal = 0;
        $('.cart-item').each(function(ind, ele){
          var prodPrice = parseInt($(ele).find('.qty_input').attr('ref'));
          var prodTotal = parseInt($(ele).find('.qty_input').val());
          allProdTotal += prodPrice*prodTotal;
        });

        $('.priceTotal').html('NT$'+allProdTotal);
        $('.priceTotalplusFee').html('NT$'+(allProdTotal));
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
                if(nextPage != 'none'){
                  top.location.href = nextPage;
                }else{
                  $('#loading').fadeOut();
                }
              }
          });
        });

      }


      $('.refresh').click(function(){
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