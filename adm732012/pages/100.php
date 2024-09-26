<?php

$pageNow = (isset($_GET['page']) and $_GET['page'] != '') ? intval($_GET['page']) : 1;

$pageNum = 20;              //每頁呈現最大筆數



if($ary_get['s']){
  $searchStr .= " AND ( 
              pkey = '".$ary_get['s']."' OR 
              orderno = '".$ary_get['s']."' OR 
              uname like '%".$ary_get['s']."%' OR 
              tel like '%".$ary_get['s']."%' OR 
              city like '%".$ary_get['s']."%' OR 
              district like '%".$ary_get['s']."%' OR 
              addr like '%".$ary_get['s']."%' OR 
              email like '%".$ary_get['s']."%' ) ";
}

$ary_data = $obj_order->fetchAll(' * ', " pkey != '0' ".$searchStr." ORDER BY `pkey` DESC ",True , array($pageNow-1 , $pageNum));



$htmlPage = paginateAdmin($pageNow, ceil($obj_order->num / $pageNum), "index.php?c=".$ary_get['c']."");









// echo '<pre>';
// print_r($ary_data);

?>
<script>

  $(function(){




    $('.searchBtn').click(function(){
      var counterStr = '';
      top.location.href = "./?c=<?=$ary_get['c']?>&s="+$('.searchTXT').val()+counterStr;
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
        <h3>訂單</h3>
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

            <div class="input-group col-md-2 col-sm-2 col-xs-2" style="float: right;">
              <input type="text" class="form-control searchTXT" value="<?=$ary_get['s']?>">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary searchBtn">搜尋</button>
              </span>
            </div>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-fixed-header" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>訂單編號</th>
                  <th>會員姓名(帳號)</th>
                  <th>訂單日期</th>
                  <th>購買金額</th>
                  <th>付款方式</th>
                  <th>訂單狀態</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>
                <?php                   foreach($ary_data as $value){
                    $ary_user = $obj_member->fetch('*' , " pkey = '".$value['data_pkey']."' ");
                ?>
                <tr>
                  <td>
                    <?=$value['orderno']?>
                  </td>
                  <td>
                        <?=$ary_user['uname']?>(<?=$ary_user['email']?>)
                  </td>
                  <td>
                        <?=$value['createdate']?>
                  </td>
                  <td>
                        <?=$value['total']?>
                  </td>
                  <td>
                        <?=$ary_config['payment'][$value['payment']]?>
                  </td>
                  <td>
                        <span style="color:<?=$ary_config['orderStatus'][$value['status']]['color']?>;"><?=$ary_config['orderStatus'][$value['status']]['title']?></span>
                  </td>
                  <td style="text-align: center;vertical-align: middle;width:100px;">
                    <a data-fancybox data-type="iframe" data-src="proc.php?proc=edit&c=<?=$ary_get['c']?>&pk=<?=$value['pkey']?>" class="btn btn-round btn-info btn-xs" >
                      資訊修改
                    </a>

                    <a data-fancybox data-type="iframe" data-src="proc.php?proc=edit&c=<?=$ary_get['c']?>-1&pk=<?=$value['pkey']?>" class="btn btn-round btn-info btn-xs" >
                      修改發票資訊
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
