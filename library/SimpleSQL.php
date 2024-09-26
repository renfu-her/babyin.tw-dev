<?php
/*
Class： 
  SimpleSQL

Extends：
  none

Attributes:
  String db->資料庫處理物件
  String tableName->資料表名稱
  String num->紀錄經SELECT查詢的筆數
  String str->紀錄SQL語法
  
Operators:
  建構式(Object db , String tableName)->設定資料庫處理物件及資料表名稱
  Int getNum()->傳回經SELECT查詢的筆數
  Int getStr()->傳回SQL語法
  NULL setTableName(String tableNane)->設定資料表名稱
  Array[][] fetchAll(String fields , String where , Boolean needPages , Array page)->得到查詢的結果，可使用feilds選擇資料表欄位，以及使用where附加SQL語法，若是有分頁，可將needPages，設為true，以及設定傳入的page的陣列值，page[0]代表目前頁數，page[1]代表一頁呈現的筆數；若無分頁，即可將needPages設為false。
  Array[] fetch(String fields , String where)->得到查詢的結果，傳回一維陣列。
  Boolean create(Array ary)->新增一筆資料，傳入的ary的key為欄位名稱，傳入的ary的value為值。
  Boolean edit(Array ary , String where)->更新資料，傳入的ary的key為欄位名稱，傳入的ary的value為值，where可設定限制條件。
  Boolean drop(String where)->刪除資料，where可設定限制條件。
*/


require_once("MyDB.php");


class SimpleSQL {
  
  
  var $db;
  var $tableName = '';
  var $num = 0;
  var $str = '';
  
  
  function SimpleSQL ($db , $tableName = '') {
    
    $this->db = $db;
    $this->tableName = $tableName;
    
  }
  
  
  function getNum() {
    
    return $this->num;
  
  }
  
  
  function getStr() {
    
    return $this->str;
  
  }
  
  
  function setTableName($tableName) {
  
    $this->tableName = $tableName;
    
  }
  
  function fetchAll_NoF($fields = '*' , $where = '' , $needPages = false , $page = array()){

    $this->str = 'SELECT '. $fields .' FROM ' ;
    
    if($where != '')
      $this->str .= ' ' . $where.' ';

    $db = $this->db;
    $sql = $db->SqlQuery($this->str);

    $this->num = $db->NumRows($sql);
    $fnum = $db->NumFields($sql);
    
    $ary = array();
    $j = 0;
    
    if($this->num > 0){

      $int = 0;
      $max = $this->num;

      if($needPages == true){

        $int = $page[0];
        $max = $page[1];
        $db->DataSeek($sql , $int * $max);

      }
      
      $i = 0;
      
      while($row = $db->FetchAry($sql)){
        
        $i++;
        
        $ary[] = $row;
        
        if($i == $max) 
          break;
      
      }
      
    }
    
    return $ary;
    
  }
  
  
  
  function fetchAll($fields = '*' , $where = '' , $needPages = false , $page = array()){

    $this->str = 'SELECT '. $fields .' FROM '. $this->tableName ;

    if(!empty($where)){
      $this->str .= ' WHERE ' . $where;
    }

    $db = $this->db;

    $sql = $db->SqlQuery($this->str);

//    var_dump($db);

    $this->num = $db->NumRows($sql);
    $fnum = $db->NumFields($sql);
    
    $ary = array();
    $j = 0;
    
    if($this->num > 0){

      $int = 0;
      $max = $this->num;

      if($needPages == true){

        $int = $page[0];
        $max = $page[1];
        $db->DataSeek($sql , $int * $max);

      }
      
      $i = 0;
      
      while($row = $db->FetchAry($sql)){
        
        $i++;
        
        $ary[] = $row;
        
        if($i == $max) 
          break;
      
      }
      
    }

//    var_dump($ary);

    return $ary;
    
  }
  
  function fetchAll_join($fields = '*' , $where = '' , $needPages = false , $page = array()){
    
    $this->str = 'SELECT '. $fields .' 
                  FROM '. $this->tableName ;
    
    if($where != '')
      $this->str .= $where;
    
    $db = $this->db;
    $sql = $db->SqlQuery($this->str);
    $this->num = $db->NumRows($sql);
    $fnum = $db->NumFields($sql);

    $ary = array();
    $j = 0;
    
    if($this->num > 0){
      
      $int = 0;
      $max = $this->num;
      
      if($needPages == true){
        
        $int = $page[0];
        $max = $page[1];
        $db->DataSeek($sql , $int * $max);
      
      }
      
      $i = 0;
      
      while($row = $db->FetchAry($sql)){
        
        $i++;
        
        $ary[] = $row;
        
        if($i == $max) 
          break;
      
      }
      
    }
    
    return $ary;
    
  }
  
  function fetch($fields = '*' , $where = '') {
    
    $this->str = 'SELECT ' . $fields . ' 
                  FROM ' . $this->tableName . '';
    
    if($where != '')
      $this->str .= ' WHERE ' . $where;
    
    $db = $this->db;
    
    $sql = $db->SqlQuery($this->str);
    $this->num = $db->NumRows($sql);
//    var_dump($this->num, $sql, $this->str);
    $ary = $db->FetchAry($sql);

    return ($this->num > 0) ? $ary : array();
  
  }
  
  
  function create($ary , $escape = array()) {
    
    $this->str = 'INSERT INTO `' . $this->tableName . '`';

    $cstr = '';
    $fstr = '';
    $i = 1;
    
    foreach($ary as $key => $value){
      
      $cstr .= $key . '` , `';
      $fstr .= (in_array($i , $escape)) ? $value . " , " : "'" . $value . "' , ";
      
      $i++;

    }
		
    $cstr = substr($cstr , 0 , strlen($cstr) - 5);
    $fstr = substr($fstr , 0 , strlen($fstr) - 2);
    
    $this->str = $this->str . '(`' . $cstr . '`) VALUES (' . $fstr . ')';
    
    $db = $this->db;
	$sql = $db->SqlQuery($this->str);
    return $sql;
    
  }
  
  
  function edit($ary , $where = '' , $escape = array()) {
    
    $this->str = 'UPDATE `' . $this->tableName . '` SET ';

    $cstr = '';
    $i = 1;
    
    foreach($ary as $key => $value){
    
      $cstr .= (in_array($i , $escape)) ? $key . ' = ' . $value . ' , '  : $key . " = '" . $value . "' , ";
      
      $i++;
      
    }
    
    $cstr = substr($cstr , 0 , strlen($cstr) - 2);
    
    $this->str = $this->str . $cstr ;
    
    if($where != '') 
      $this->str .= ' WHERE ' . $where;
    
    $db = $this->db;
    $sql = $db->SqlQuery($this->str);
    
    return $sql;
    
  }
  
  
  function drop($where) {
  
    $this->str = 'DELETE FROM ' . $this->tableName . ' WHERE ' . $where;
    
    $db = $this->db;
    $sql = $db->SqlQuery($this->str);
    
    return $sql;
  
  }

  
}
?>
