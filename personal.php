<?php   require_once 'config.php';

  if(!$_SESSION['login']){
    header("Location:./login.php");
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
              <li class="breadcrumb-item active" aria-current="page">個人資料修改</li>
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
        <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">個人資料修改</h2>
        <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="600">Personal Data Modification</h4>
        <hr class="page_line" data-aos="flip-right" data-aos-delay="0" data-aos-duration="3000">
      </div>

      <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="750" data-aos-offset="0">
        <div class="row justify-content-center py-3">
          <div class="col-md-7 col-sm-12 my-3">
            <form method="post" action="proc.php?proc=editMember" enctype="multipart/form-data" onsubmit="return checkform();">
              <div class="form-group row mb-3">
                <label for="staticEmail" class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">電子郵件 </label>
                <div class="col-sm-7 align-self-center">
                  <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?=$_SESSION['login']['email']?>">
                </div>
              </div>
              
              <div class="form-group row mb-3">
                <label for="inputPassword" class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span class="text-danger">*</span>密碼</label>
                <div class="col-sm-7 align-self-center">
                  <input type="password" class="form-control" id="inputPassword" placeholder="6~15字元，至少搭配 1 個英文字母" required name="pwd">
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="inputPasswordAgain" class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span class="text-danger">*</span>再次輸入密碼 </label>
                <div class="col-sm-7 align-self-center">
                  <input type="password" class="form-control" id="inputPasswordAgain" placeholder="請再輸入一次密碼" required name="repwd">
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center" for="inputPhone"><span class="text-danger">*</span>手機</label>
                <div class="col-sm-7 align-self-center">
                  <input type="phone" class="form-control" id="inputPhone" placeholder="請輸入電話" required name="tel" value="<?=$_SESSION['login']['tel']?>">
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right text-sm-left"><span class="text-danger">*</span>地址</label>
                <div class="col-sm-7">
                  <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                      <select id="city" class="form-control" name="city" data-width="fit">
                      </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                      <select id="city" class="form-control" name="district" data-width="fit">
                      <option value="0" >鄉鎮市區</option>
                      </select>
                    </div>
                    <div class="col-md-12 col-sm-12">
                      <input type="text" class="form-control" id="address" placeholder="" required name="addr" value="<?=$_SESSION['login']['addr']?>">
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label text-md-right pr-0 align-self-center"><span class="text-danger">*</span>輸入右方驗證碼</label>
                <div class="col-sm-7 align-self-center">
                  <div class="input-group">
                    <input type="text" class="form-control align-self-center" id="verify" placeholder="" required>
                    <div class="d-flex pl-2 align-self-center">
                      <img src="./img/verify.png" class="img-fluid"/>
                    </div>
                    <div class="input-group-append">
                      <label class="refresh mn-0">
                        <button class="btn btn-refresh hvr-icon-spin" type="submit">更換 <i class="fas fa-sync-alt hvr-icon px-1"></i>
                        </button>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

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

  <script src="js/address.js"></script>
  <script>
    
    var citySelected = '';
    var districtSelected = '';
    var selectedHtml = '';
    <?php       echo 'citySelected="'.$_SESSION['login']['city'].'";districtSelected="'.$_SESSION['login']['district'].'";';
    ?>


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
          console.log(address[$('select[name="city"] option:SELECTED').val()]);
          address[$('select[name="city"] option:SELECTED').val()].forEach(function (key, value) {
            selectedHtml = districtSelected==key ? 'selected="selected"' : '';
            distContent += '<option value="'+key+'" '+selectedHtml+' >'+key+'</option>';
          });
          $('select[name="district"]').html('').html(distContent);
        }
      });
      

    <?php       echo $_SESSION['login']['city'] ? '$(\'select[name="city"]\').change();citySelected="";districtSelected="";' : '';
    ?>

    function checkform(){
      // var rem = /^[09]{2}[0-9]{8}$/;
      var ree = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      var rep = /^[A-Za-z0-9]{6,15}$/;

      if(!rep.test($('input[name="pwd"]').val() ) ){
        alert('密碼輸入錯誤,必須是6個英文字 or 數字');
        return false;
      }else if($('input[name="pwd"]').val() != $('input[name="repwd"]').val() ){
        alert('兩次密碼輸入不正確');
        return false;
      }else if( $('select[name="city"] option:SELECTED').val()=='0' || $('select[name="district"] option:SELECTED').val()=='0'  ){
        alert('請選擇正確地址');
        return false;
      }else{
        return true;
      }



    }




  </script>


</body>

</html>
