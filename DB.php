<?php
$db = new mysql($db_host,$db_user,$db_password,$db_table,$db_conn,$pre,$coding);  
  
class mysql{  
      
    private    $db_host;  
    private    $db_user;  
    private    $db_password;  
    private    $db_table;  
    private    $db_conn;           //数据库连接标识;  
    private    $result;         //执行query命令的结果资源标识  
    private    $sql;      //sql执行语句  
    private    $pre;      //数据库表前缀    
    private    $coding;  //数据库编码，GBK,UTF8,gb2312  
      
      
    function __construct($db_host,$db_user,$db_password,$db_table,$db_conn,$pre,$coding){  
          
        $this->db_host     = $db_host;  
        $this->db_user     = $db_user;  
        $this->db_password = $db_password;  
        $this->db_table    = $db_table;  
        $this->db_conn     = $db_conn;  
        $this->pre         = $pre;  
        $this->coding      = $coding;  
        $this->connect();  
      
    }  
      
    function connect(){  
          
        $this->db_conn = @mysql_connect($this->db_host,$this->db_user,$this->db_password) or die($this->show_error("数据库链接错误,请检查数据库链接配置！"));  
        if(!mysql_select_db($this->db_table,$this->db_conn)){  
              
            echo "没有找到数据表：".$this->db_table;  
        }  
        mysql_select_db($this->db_table,$this->db_conn);  
        $this->query("SET NAMES $this->coding");  
    }  
      
    /*执行SQL语句的函数*/  
    function query($sql){  
          
        if(emptyempty($sql)){  
            $this->show_error("你的sql语句不能为空！");  
        }else{            
            $this->sql = $sql;  
        }  
        $result = mysql_query($this->sql,$this->db_conn);  
          
        return $this->result = $result;  
    }  
      
    /*创建添加新的数据库*/  
    public function create_database($database_name){  
        $database=$database_name;  
        $sqlDatabase = 'create database '.$database;  
        return $this->query($sqlDatabase);  
    }  
          
    // 根据select查询结果计算结果集条数   
    public function db_num_rows(){   
         if($this->result==null){  
            if($this->show_error){  
                $this->show_error("sql语句错误!");  
            }             
         }else{  
            return  mysql_num_rows($this->result);   
         }  
    }  
      
    /*查询服务器所有数据库*/  
    //将系统数据库与用户数据库分开，更直观的显示？  
    public function show_databases(){  
        $this->query("show databases");  
        echo "现有数据库：".$amount =$this->db_num_rows($rs);  
        echo "<br />";  
        $i=1;  
        while($row = $this->fetch_array($rs)){             
            echo "$i $row[Database]";             
            echo "<br />";  
            $i++;  
        }  
    }  
      
    //以数组形式返回主机中所有数据库名   
    public function databases()   
    {   
        $rsPtr=mysql_list_dbs($this->db_conn);   
        $i=0;   
        $cnt=mysql_num_rows($rsPtr);   
        while($i<$cnt)   
        {   
          $rs[]=mysql_db_name($rsPtr,$i);   
          $i++;   
        }   
        return print_r($rs);   
    }  
      
      
    /*查询数据库下所有的表*/  
    function show_tables($database_name){  
        $this->query("show tables");  
        echo "现有数据库：".$amount = $this->db_num_rows($rs);  
        echo "<br />";  
        $i=1;  
        while($row = $this->fetch_array($rs)){  
            $columnName="Tables_in_".$database_name;  
            echo "$i $row[$columnName]";  
            echo "<br />";  
            $i++;  
        }  
    }  
  
    /* 
    mysql_fetch_row()    array  $row[0],$row[1],$row[2] 
    mysql_fetch_array()  array  $row[0] 或 $row[id] 
    mysql_fetch_assoc()  array  用$row->content 字段大小写敏感 
    mysql_fetch_object() object 用$row[id],$row[content] 字段大小写敏感 
    */  
    /*取得记录集,获取数组-索引和关联,使用$row['content'] */  
    public function fetch_array()    
    {         
        return @mysql_fetch_array($this->result);   
    }     
      
    //获取关联数组,使用$row['字段名']  
    public function fetch_ass()   
    {   
        return @mysql_fetch_assoc($this->result);   
    }  
          
    //获取数字索引数组,使用$row[0],$row[1],$row[2]  
    public function fetch_row()   
    {   
        return @mysql_fetch_row($this->result);   
    }  
      
    //获取对象数组,使用$row->content   
    public function fetch_Object()   
    {   
        return @mysql_fetch_object($this->result);   
    }  
      
    //简化查询select  
    public function findall($table){  
        $table = $this->fulltablename($table);  
        $this->query("select * from $table");  
    }  
      
    public function select($table,$columnName,$condition){  
        $table = $this->fulltablename($table);  
        if(emptyempty($columnName)){  
            $columnName = "*";  
        }  
        $this->query("SELECT $columnName FROM $table $condition");  
    }  
      
    //简化的insert  
    function insert($table,$arr){  
        $table = $this->fulltablename($table);  
        $sql = "INSERT INTO $table ";  
        if(!is_array($arr)){  
            $this->show_error("请输入参数数组！");  
        }else{  
        $k = "";  
        $v = "";  
        foreach($arr as $key => $value){  
            $k .= "`$key`,";  
            $v .= "'".$value."',";  
        }  
        }  
        $sql = $sql." (".substr($k,0,-1).") VALUES (".substr($v,0,-1).")";  
        $this->query($sql);  
    }  
    //简化的update  
    function update($table,$arr,$where){  
        $table = $this->fulltablename($table);  
        $sql = "UPDATE $table SET ";  
        if(!is_array($arr)){  
            $this->show_error("请输入参数数组！");  
        }else{  
        foreach($arr as $key => $value){  
            $sql .= " `".$key."` = '".$value."' ,";  
        }  
        }  
        $sql = substr($sql,0,-1)." where ".$where;  
        return $this->query($sql);  
    }  
    //简化的delete  
    function delete($table,$where = ""){  
        $table = $this->fulltablename($table);  
        if(emptyempty($where)){  
            $this->show_error("条件不能为空!");  
        }else{  
            $where = " where ".$where;  
        }  
        $sql = "DELETE FROM $table ".$where;  
        //echo $sql;  
        return $this->query($sql);  
    }  
      
    //取得上一步 INSERT 操作产生的 ID  
    public function insert_id(){  
        return mysql_insert_id();  
    }  
      
    //加上前缀的数据表  
    public function fulltablename($table){  
        return $table = $this->pre.$table;  
    }  
      
    //查询字段数量  
    public function num_fields($table){  
        $table = $this->fulltablename($table);     
        $this->query("select * from $table");  
        echo "<br />";  
        echo "字段数：".$total = mysql_num_fields($this->result);  
        echo "<pre>";  
        for ($i=0; $i<$total; $i++){  
            print_r(mysql_fetch_field($this->result,$i) );  
        }  
        echo "</pre>";  
        echo "<br />";  
    }  
      
    //取得 MySQL 服务器信息  
    public function mysql_server($num=''){  
        switch ($num){  
            case 1 :  
            return mysql_get_server_info(); //MySQL 服务器信息     
            break;  
              
            case 2 :  
            return mysql_get_host_info();   //取得 MySQL 主机信息  
            break;  
              
            case 3 :  
            return mysql_get_client_info(); //取得 MySQL 客户端信息  
            break;  
              
            case 4 :  
            return mysql_get_proto_info();  //取得 MySQL 协议信息  
            break;  
              
            default:  
            return mysql_get_client_info(); //默认取得mysql版本信息  
        }  
    }  
      
    //析构函数，自动关闭数据库,垃圾回收机制  
    /*public function __destruct() 
    { 
        if(!empty($this->result)){  
            $this->free(); 
        } 
        mysql_close($this->$db_conn); 
    }*/  
      
    /*获得客户端真实的IP地址*/  
    function getip(){   
        if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))  
        {  
            $ip = getenv("HTTP_CLIENT_IP");   
        }  
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){  
            $ip = getenv("HTTP_X_FORWARDED_FOR");   
        }  
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))  
        {  
            $ip = getenv("REMOTE_ADDR");   
        }  
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){  
        $ip = $_SERVER['REMOTE_ADDR'];   
        }  
        else{  
            $ip = "unknown";          
        }  
        return($ip);  
    }  
          
    function show_error($str){        
        echo "<script language='Javascript'> alert('".$str."');history.back(-1);</script>";  
    }  
      
}  
?>  