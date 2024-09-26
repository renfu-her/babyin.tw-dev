<?php

        $ary_data = $obj_products_pic->fetchAll('*' , " data_pkey = '".$ary_get['t']."' order by sort DESC ");

        

    ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>  
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>  
    <script>
    $(function() {
        $( "#jui_item_ul" ).sortable({
            placeholder: "ui-state-highlight"
        });

        $( "#jui_item_ul" ).disableSelection();

        $('#save').click(function(){
            $('#data_order').val('');
            $('li').each(function(ind,ele){
                if($('#data_order').val() == ''){
                    $('#data_order').val( $(ele).attr('ref') );
                }else{
                    $('#data_order').val( $('#data_order').val() + ',' + $(ele).attr('ref') );
                }
            });
            $('#form1').submit();
        });
    });

    </script>
    <style type="text/css">
        h2{
            font-weight: bold;
        }
    </style>

    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>請拖曳調整排序</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="">
                    <ul class="to_do" id="jui_item_ul">
                        <?php
                        foreach($ary_data as $value){
                        ?>
                        <li class="jui_item_li" ref="<?php  echo $value['pkey']?>" style="cursor: move;">
                            <img src="../uploads/<?=$value['pic']?>" height="90px">
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data" >
                <input name="c" type="hidden" id="proc" value="<?php  echo $ary_get['c']?>" />
                <input name="sort" type="hidden" id="proc" value="<?php  echo $ary_get['sort']?>" />
                <input name="self_post" type="hidden" id="self_post" value="33" />
                <input name="data_order" type="hidden" id="data_order" value="" />
                <input type="button" id="save" class="btn btn-danger" value="儲存" style="float: right;"/>
            </form>
        </div>
    </div>








