<?php 

            $total_data = $obj_banner->fetch('count(*) total' , " type = '1' ");
            $ary_list = explode(',' , $ary_post['data_order'] );
            //print_r($ary_list);
            foreach($ary_list as $key => $value){
                $ary_DBdata = array(
                                    'sort' => ($total_data['total'] * 5 +100)
                );
                $obj_banner->edit($ary_DBdata , " pkey = '".$ary_list[$key]."' ");
                unset($ary_DBdata);
                $total_data['total']--;
            }
            echo '
            <script type="text/javascript">
            parent.location.href="index.php?msg=succ_edit&'.$_SESSION['redirectPageUrl'].'";
            </script>
            ';
            exit;









