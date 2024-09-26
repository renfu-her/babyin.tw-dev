<?php require_once '../config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "includes/head.php"; ?>
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" action="proc.php?proc=login" />
              <h1>
              	<img src="images/logo.png" style="width: 145px;margin-top: -15px;">
              </h1>
              <div>
                <input type="text" class="form-control" placeholder="帳號" required="" name="acc" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="密碼" required="" name="pwd" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">
                  登入
                </button>
              </div>

              <div class="clearfix"></div>

              <input type="hidden" name="c" value="<?=$ary_get['c']?>" />

            </form>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>
