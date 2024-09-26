<?php 

    $ary_DBdata['is_show'] = '0';
    if($obj_data_file->edit($ary_DBdata , " pkey = '".$ary_post['p']."' ")){
        echo 'succ';
    }else{
        echo 'DBerr';
    }










