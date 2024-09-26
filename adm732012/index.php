<?php require_once '../config.php';


if($_SESSION['AdminLogin'] != true ){
    header('Location:./login.php?c='.$_GET['c'].'');
}

$_SESSION['redirectPageUrl'] = http_build_query($_GET);


if(file_exists('pages/'.$_GET['c'].'.php')){
  $includeContentPath = 'pages/'.$_GET['c'].'.php';
}else{
  $includeContentPath = 'pages/dashboard.php';
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "includes/head.php"; ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title">
                <i class="fa">
                  <?=($ary_adminConfig['logoImges'])? '<img src="'.$ary_adminConfig['logoImges'].'" width="13px">':'';?>
                </i>
                <span style="position: relative;top: 3px;font-weight: 500;"><?=$ary_adminConfig['logoTitle']?>系統管理</span>
              </a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            <?php include "includes/menu.php"; ?>
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
        <?php include "includes/navigation.php"; ?> 
        <!-- /top navigation -->

        <!-- page content -->

        <?php include $includeContentPath; ?>


        <!-- /page content -->

        <!-- footer content -->
        <footer>
        <?php include "includes/footer.php"; ?>
        </footer>
        <!-- /footer content -->
      </div>
    </div>


  </body>
</html>