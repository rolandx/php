<?php
header( "Pragma: public" );
header( "Expires: 0" ); // set expiration time
header( "Cache-Component: must-revalidate, post-check=0, pre-check=0" );
header( "Content-type:application/msword");
if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE"))
header( 'Content-Disposition: attachment; filename="'.urlencode("php生成word文档.doc").'"' );//如果是ie存为的名字要urlencode
else header( 'Content-Disposition: attachment; filename="'.'php生成word文档.doc'.'"' );//存为的名字
header( 'Content-Transfer-Encoding: binary' );
$out_put=<<<o



<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 11">
<meta name=Originator content="Microsoft Word 11">
<xml>
<w:WordDocument>
<w:View>Print</w:View>
</xml>
</head>
<body>
{replacement}这里是你要呈现的内容
</body>
</html>



o;
echo $out_put;
?>