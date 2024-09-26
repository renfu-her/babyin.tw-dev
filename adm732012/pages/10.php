<?php

$pageNow = (isset($_GET['page']) and $_GET['page'] != '') ? intval($_GET['page']) : 1;

$pageNum = 20;              //每頁呈現最大筆數


$ary_category = $obj_category->fetchAll('*' , " data_pkey = '0' order by sort DESC ");
foreach($ary_category as $value){
	$ary_subCategory = $obj_category->fetchAll('*' , " data_pkey = '".$value['pkey']."' order by sort DESC ");
	foreach($ary_subCategory as $value2){
		$ary_categoryRe[$value2['pkey']] = $value['title'].'-'.$value2['title'];
	}
}

if(!$ary_get['t'] || $ary_get['t'] == '0'){
	$ary_subCategory = $obj_category->fetch('*' , " data_pkey = '".$ary_category['0']['pkey']."' order by sort DESC ");
	$htmlSelect = $ary_subCategory['pkey'];
	$sqlQuery = $ary_subCategory['pkey'];
}else{
	$htmlSelect = $ary_get['t'];
	$sqlQuery = $ary_get['t'];
}

$ary_spec = $obj_products_select->fetchAll_join();
foreach($ary_spec as $value){
	$ary_specRe[$value['pkey']] = $value['title'];
}

$ary_data = $obj_products->fetchAll(' * ', "
													data_pkey = '".$sqlQuery."'
                                                    ORDER BY sort DESC ",True , array($pageNow-1 , $pageNum));

$htmlPage = paginateAdmin($pageNow, ceil($obj_products->num / $pageNum), "index.php?c=".$ary_get['c']."&t=".$htmlSelect);


$ary_tag = $obj_banner->fetchAll('*' , " type = '4' ");
foreach($ary_tag as $value){
  $ary_tagRe[$value['pkey']] = $value['title'];
}






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
        					$ary_subCategory = $obj_category->fetchAll('*' , " data_pkey = '".$value['pkey']."' order by sort DESC ");
        					foreach($ary_subCategory as $value2){
        	                  $htmlSelected = ($htmlSelect == $value2['pkey'])?'SELECTED':'';
        	                  echo '<option '.$htmlSelected.' value="'.$value2['pkey'].'">'.$value['title'].'-'.$value2['title'].'</option>';
        					}
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
                  <th>副標題</th>
                  <th>列表圖片 268x294</th>
                  <th>圖片 460x346</th>
                  <th>原價</th>
                  <th>現金價</th>
                  <th>預購</th>
                  <th>產品標籤</th>
                  <th>規格</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>
                <?php                   foreach($ary_data as $value){
                    $ary_pic = $obj_products_pic->fetchAll('*' , " data_pkey = '".$value['pkey']."' order by sort DESC ");
                ?>
                <tr>
                  <td>
                    <?=$value['title']?> 
                  </td>
                  <td>
                    <?=$value['subtitle']?> 
                  </td>
                  <td>
                    <img src="../uploads/<?=$value['listpic']?>" height="120px">
                  </td>
                  <td>
                    <?php                       if($ary_pic){
                        echo '<a style="cursor: pointer;" data-fancybox="" data-type="iframe" data-src="proc.php?sort=1&c='.$ary_get['c'].'-1&t='.$value['pkey'].'" >排序</a><br><br>';
                      }
                      foreach($ary_pic as $value2){
                        echo '<img src="../uploads/'.$value2['pic'].'" height="120px"><a style="cursor: pointer;" onclick="if(window.confirm(\'確定要刪除？一旦刪除則無法復原。\')) location.href=\'delete.php?c='.$ary_get['c'].'-1&pk='.$value2['pkey'].'\';">刪除</a><br>';
                      }
                    ?>
                    
                  </td>
                  <td>
                    <?=number_format($value['org_price'])?>
                  </td>
                  <td>
                    <?=number_format($value['price'])?>
                  </td>
                  <td>
                    <?=($value['check1']=='1')?'是':'否';?>
                  </td>
                  <td>
                    <?=$ary_tagRe[$value['check2']]?>
                  </td>
                  <td>
                    <?php                     $ary_prodSpec = explode(',', $value['select1']);
                    foreach($ary_prodSpec as $value2){
                    	echo $ary_specRe[$value2].'<br>';
                    }
                    ?>
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
