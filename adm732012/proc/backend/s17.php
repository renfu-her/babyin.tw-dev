<?php

            $total_data = $obj_products_select->fetch('count(*) total' , " type = '2' ");
            $ary_list = explode(',' , $ary_post['data_order'] );
            //print_r($ary_list);
            foreach($ary_list as $key => $value){
                $ary_DBdata = array(
                                    'sort' => ($total_data['total'] * 5 +100)
                );
                $obj_products_select->edit($ary_DBdata , " pkey = '".$ary_list[$key]."' ");
                unset($ary_DBdata);
                $total_data['total']--;
            }
            echo '
            <script type="text/javascript">
            parent.location.href="index.php?msg=succ_edit&'.$_SESSION['redirectPageUrl'].'";
            </script>
            ';
            exit;









