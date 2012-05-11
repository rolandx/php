<?php

/*
**  打印出最近一段时间的网站订单。 by wzs 090913
**  时间格式有两种：一是到本周一网站所有的订单（已排除前期的订单）；另一种是上一周的网站订单（周一至周日）
*/

header("Content-type: text/html; charset=utf-8");
require 'connect.php';

if(date('w')==5){
   $start = strtotime("this friday-1 week");
   $end = strtotime("this friday"); 
}else{
   $start = strtotime("last friday-1 week");
   $end = strtotime("last friday"); 
} 

 if($_GET['op']=="latest"){
 	$time = " order_id>118 AND created<$end ";
 	$filename = date("Ymd",$end).urlencode("订单");
 }else{
 	$time =" created>=$start AND created<$end ";
 	$filename = date("Ymd",$start)."-".date("Ymd",$end).urlencode("订单");
 }

//echo date("Y-m-d",$end); 
$sql = "SELECT order_id,order_total,delivery_first_name,delivery_company,delivery_phone,delivery_street1,delivery_city,delivery_postal_code,created FROM `uc_orders` WHERE $time AND order_status='payment_received' AND order_total>500";
//echo $sql;
$re = mysql_query($sql);

$num = mysql_num_rows($re);

if($num>0){
		

	header("Content-type:application/vnd.ms-excel;charset:utf-8"); 
	header("Content-Disposition:filename=$filename.xls"); 
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo ' <TABLE height=60 cellSpacing=0 borderColorDark=#ffffff width="100%"  
	bgColor=#ffffff borderColorLight=#c0c0c0 border=1> 
	   <tbody>
	      <strong>2u4u网站用户订单（'.date("Ymd",$start).'-'.date("Ymd",$end).'）</strong>	
		<tr>
		 <td align="center" >订单号</td>
		 <td align="center" >姓名</td>
		 <td align="center" >订单时间</td>	
		 <td align="center" >名称</td>	
		 <td align="center" >数量</td>	
		 <td align="center" >码洋</td>	
		 <td align="center" >兑换积分</td>	
		 <td align="center" >内容</td>
		 <td align="center" >邮寄地址</td>
		 <td align="center" >邮编</td>	
		 <td align="center" >联系电话</td>
	</tr>'; 
	
	while($row=mysql_fetch_array($re)){
			 if($_GET['info']=='update'){  
	   	$sql2 = "UPDATE `uc_orders` SET order_status='completed' WHERE order_id='$row[order_id]' LIMIT 1";
	   	mysql_query($sql2);
	 }
		
		$query1 = "SELECT nid,title,qty,price FROM `uc_order_products` WHERE order_id=$row[order_id]";
		$ress = mysql_query($query1);
		
		  while($arr = mysql_fetch_array($ress)){   //要考虑到一个订单中有多个商品
		
	   	$query = "SELECT field_product_neirongtiyao_value as content,field_product_mayang_value as mayang FROM `content_type_product` WHERE nid=$arr[nid] ORDER BY vid DESC LIMIT 1"; 
	   	$result =  mysql_fetch_array(mysql_query($query));
	    if(strpos($result[content],"1.")!==false)
                $content =substr(str_replace("1.","; ",strip_tags($result[content])),1);	

	 
	   	echo "<tr><td align='center'>".$row[order_id]."</td>";
	    echo "<td align='center'>".$row[delivery_first_name]."</td>";
	    echo "<td align='center'>".date("Ymd",$row[created])."</td>";
	    echo "<td align='center'>".$arr[title]."</td>";
	    echo "<td align='center'>".intval($arr[qty])."</td>";              //要考虑到订单中的商品数量
	    echo "<td align='center'>".$result[mayang]."</td>"; 	   
	    echo "<td align='center'>".intval($arr[price])*intval($arr[qty])."</td>";
	  	echo "<td align='center'>".$content."</td>";
	    echo "<td align='center'>".$row[delivery_city].$row[delivery_street1].$row[delivery_company]."</td>";
	   	echo "<td align='center'>".$row[delivery_postal_code]."</td>";
	   	echo "<td align='center'>".$row[delivery_phone]."</td>";
	   	echo "</tr>";
	   }	
	}
}else 
    echo "上周没有订单或订单已经发出!";
    
