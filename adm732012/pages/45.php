<?php

$pageNow = (isset($_GET['page']) and $_GET['page'] != '') ? intval($_GET['page']) : 1;

$pageNum = 20;              //每頁呈現最大筆數



$ary_data = $obj_banner->fetchAll(' * ', " type = '2' ORDER BY sort DESC ",True , array($pageNow-1 , $pageNum));

$htmlPage = paginateAdmin($pageNow, ceil($obj_banner->num / $pageNum), "index.php?c=".$ary_get['c']."");








// echo '<pre>';
// print_r($ary_data);

?>
<script>

  $(function(){

    $('.pageType').change(function(){
      var fthis = $(this);
      top.location.href = 'index.php?c=<?=$ary_get['c']?>&t='+fthis.val();
    });

  });

</script>
<style>
.table>tbody>tr>td{
  vertical-align: middle;
}
</style>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>廣告專區</h3>
      </div>

      <!-- <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div> -->
    </div>

    <div class="clearfix"></div>

    <div class="row">



      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2></h2>

            <a data-fancybox="" data-type="iframe" data-src="proc.php?sort=1&c=<?=$ary_get['c']?>&t=<?=$htmlSelect?>" class="btn btn-round btn-default" style="float: right;">
              排序
            </a>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-fixed-header" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>標題</th>
                  <th>圖片 552x344</th>
                  <th>描述</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>
                <?php                   foreach($ary_data as $value){
                ?>
                <tr>
                  <td>
                    <?=$value['title']?> 
                  </td>
                  <td>
                    <img src="../uploads/<?=$value['pic']?>" height="120px">
                  </td>
                  <td>
                    <?=$value['info']?> 
                  </td>
                  <td style="text-align: center;vertical-align: middle;width:100px;">
                    <a data-fancybox data-type="iframe" data-src="proc.php?proc=edit&c=<?=$ary_get['c']?>&pk=<?=$value['pkey']?>" class="btn btn-round btn-info btn-xs" >
                      修改
                    </a>



                  </td>
                </tr>
                <?php                   }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>


    </div>

    <div class="row">
        <div class="col-sm-5"></div>
        <div class="col-sm-7">
          <?=$htmlPage;?>
        </div>
    </div>


  </div>
</div>
