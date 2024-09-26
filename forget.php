<?php
  require_once 'config.php';
  include "uploads/captcha/simple-php-captcha.php";
  $_SESSION['captcha'] = simple_php_captcha();


  if($_SESSION['login']){
    header("Location:./");
    exit;
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
              <li class="breadcrumb-item active" aria-current="page">忘記密碼</li>
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
        <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">忘記密碼</h2>
        <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="600">Forget Password</h4>
        <hr class="page_line" data-aos="flip-right" data-aos-delay="0" data-aos-duration="3000">
        <p class="p-t14 text-center" data-aos="zoom-in-up" data-aos-delay="700">請輸入您註冊的電子郵件E-mail，密碼將會寄到您的E-mail信箱。</p>
      </div>

      <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="900" data-aos-offset="0">
        <div class="row justify-content-center">
          <div class="col-md-7 col-sm-12 my-3">
            <form method="post" action="proc.php?proc=forget" enctype="multipart/form-data" onsubmit="return checkform();">
              <div class="form-group row mb-3">
                <label for="inputEmail" class="col-sm-3 col-form-label text-md-right text-sm-left pr-0">
                  <span class="text-danger">*</span>電子郵件 
                </label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="inputEmail" placeholder="" required name="email">
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right pr-0 align-self-center"><span class="text-danger">*</span>輸入右方驗證碼</label>
                <div class="col-sm-7 align-self-center">
                  <div class="input-group">
                    <input type="text" class="form-control align-self-center" id="verify" placeholder="" required name="captcha">
                    <div class="d-flex pl-2 align-self-center">
                      <img src="uploads/captcha/<?=$_SESSION['captcha']['image_src']?>" width="68px" height="24px" class="img-fluid"/>
                    </div>
                    <div class="input-group-append">
                      <label class="refresh mn-0">
                        <button class="btn btn-refresh hvr-icon-spin" type="submit">更換 <i class="fas fa-sync-alt hvr-icon px-1"></i>
                        </button>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-sm-7 offset-sm-3 py-2">
                  <button class="btn btn-lg btn-danger btn-purchase btn-block rounded-pill mb-3 hvr-grow" type="submit">確認送出</button>
                  <button class="btn btn-lg bg-secondary text-white btn-block rounded-pill mb-3 hvr-grow" type="reset">取消重填</button>
                </div>
              </div>

            </form>
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

    <?php       echo ($ary_get['err'] == 'captcha') ? 'alert("驗證碼錯誤");' : '';
      echo ($ary_get['status'] == 'succForgetEmail') ? 'alert("請查看您的Email信箱");' : '';
    ?>

    function checkform () {
      var ree = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

      if(!ree.test($('input[name="email"]').val() )){
        alert('email格式不正確');
        return false;
      }else{
        return true;
      }


    }


    $(function(){
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
