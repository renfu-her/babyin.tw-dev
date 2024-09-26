<?php

$pageNow = (isset($_GET['page']) and $_GET['page'] != '') ? intval($_GET['page']) : 1;

$pageNum = 20;              //每頁呈現最大筆數


$ary_category = $obj_article_category->fetchAll('*' , " pkey != '0' order by sort DESC ");
foreach($ary_category as $value){
	$ary_categoryRe[$value['pkey']] = $value['title'];
}

if(!$ary_get['t'] || $ary_get['t'] == '0'){
	$htmlSelect = $ary_category['0']['pkey'];
	$sqlQuery = $ary_category['0']['pkey'];
}else{
	$htmlSelect = $ary_get['t'];
	$sqlQuery = $ary_get['t'];
}

$ary_data = $obj_article->fetchAll(' * ', "
													data_pkey = '".$sqlQuery."'
                                                    ORDER BY sort DESC ",True , array($pageNow-1 , $pageNum));

$htmlPage = paginateAdmin($pageNow, ceil($obj_article->num / $pageNum), "index.php?c=".$ary_get['c']."&t=".$htmlSelect);









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
        <h3><?=$ary_categoryRe[$htmlSelect]?> </h3>
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

            <select class="form-control pageType" style="float: right;width: auto;">
              <?php                 foreach($ary_category as $value){
                  $htmlSelected = ($htmlSelect == $value['pkey'])?'SELECTED':'';
                  echo '<option '.$htmlSelected.' value="'.$value['pkey'].'">'.$value['title'].'</option>';
                }
              ?>
            </select>
            <a data-fancybox="" data-type="iframe" data-src="proc.php?sort=1&c=<?=$ary_get['c']?>&t=<?=$htmlSelect?>" class="btn btn-round btn-default" style="float: right;">
              排序
            </a>
            <a data-fancybox data-type="iframe" data-src="proc.php?proc=add&c=<?=$ary_get['c']?>&t=<?=$htmlSelect?>" class="btn btn-round btn-primary" style="float: right;">
              新增
            </a>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-fixed-header" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>標題</th>
                  <th></th>
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
                    <?=$value['adate']?> 
                  </td>
                  <td style="text-align: center;vertical-align: middle;width:100px;">
                    <a data-fancybox data-type="iframe" data-src="proc.php?proc=edit&c=<?=$ary_get['c']?>&pk=<?=$value['pkey']?>" class="btn btn-round btn-info btn-xs" >
                      修改
                    </a>

                    <a style="" class="btn btn-round btn-danger btn-xs" onclick="if(window.confirm('確定要刪除？一旦刪除則無法復原。')) location.href='delete.php?c=<?=$ary_get['c']?>&pk=<?=$value['pkey']?>';">
                      刪除
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
