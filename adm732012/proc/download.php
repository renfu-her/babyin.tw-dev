<?php

    $ary_file = $obj_data_file->fetch('*' , " pkey = '".$ary_get['p']."' AND is_show = '1' ");
    $filename = "uploads/".$ary_file['name_new'];
    $outputfilename = $ary_file['name_org'];
    header('Content-type:application/force-download'); 
    header("Content-Disposition:  attachment; filename=\"" . $outputfilename . "\";" );
    header("Content-Transfer-Encoding:  binary");
    readfile($filename);
    // header("Location:./uploads/".$ary_file['name_new']);
    exit;

