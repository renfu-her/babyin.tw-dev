<?php

$pageNow = (isset($_GET['page']) and $_GET['page'] != '') ? intval($_GET['page']) : 1;

$pageNum = 20;              //每頁呈現最大筆數


$ary_data = $obj_member->fetchAll(' * ', " pkey != '0' ORDER BY pkey DESC ",True , array($pageNow-1 , $pageNum));

$htmlPage = paginateAdmin($pageNow, ceil($obj_member->num / $pageNum), "index.php?c=".$ary_get['c']."");





// echo '<pre>';
// print_r($ary_data);

?>
<script>

  $(function(){


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
        <h3>會員</h3>
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

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-fixed-header" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>姓名</th>
                  <th>電話</th>
                  <th>email</th>
                  <th>性別</th>
                  <th>生日</th>
                  <th>地址</th>
                  <th>註冊日期</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>
                <?php                   foreach($ary_data as $value){
                ?>
                <tr>
                  <td>
                    <?=$value['uname']?> 
                  </td>
                  <td>
                    <?=$value['tel']?> 
                  </td>
                  <td>
                    <?=$value['email']?> 
                  </td>
                  <td>
                    <?=$value['gender']=='1'?'男':'女';?> 
                  </td>
                  <td>
                    <?=$value['birthday']?> 
                  </td>
                  <td>
                    <?=$value['city']?> <?=$value['district']?> <?=$value['addr']?> 
                  </td>
                  <td>
                    <?=$value['createdate']?> 
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
