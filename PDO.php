<?php

//pdo 实现mysql 事务处理 简单示例
/*
实现向数据库中写入多条数据的事务
insert into test values ('test123', 'test123')
*/

$type     = 'mysql';//要连接的数据库类型
$host     = 'localhost';//数据库主机
$dbname   = 'test';//要选择的数据库名称
$password = '';
$username = 'root';

$dsn = "{$type}:dbname={$dbname};host={$host}";

try{

//连接数据库
$pdo = new PDO($dsn, $username, $password);

//编码
$pdo->exec("set names utf8");

//设置错误提示方式
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//开启标准事务
$pdo->beginTransaction();

//构造sql语句
//$sql = "insert into test values (?,?)";
$sql = "insert into test values (:user, :password)";
//或者使用此sql语句 :user :password 与问号功能相似 绑定参数

$stmt = $pdo->prepare($sql);

//为sql语句中的变量绑定变量
$stmt->bindParam(':user', $username);
$stmt->bindParam(':password', $password);

//为sql语句中的变量 赋值
$username = 'test123';
$password = '123456';

$stmt->execute();

$rows = $stmt->rowCount();

if($rows<1){
//如果失败则抛出异常
throw new PDOexception('第一句sql语句执行失败！', '01');

}


$username = 'hello123';
$password = '123456';

$stmt->execute();

$rows = $stmt->rowCount();

if($rows<1){
//如果失败则抛出异常
throw new PDOexception('第二句sql语句执行失败！', '02');

}


$username = 'world123';
$password = '123456';

$stmt->execute();

$rows = $stmt->rowCount();

if($rows<1){
//如果失败则抛出异常
throw new PDOexception('第三句sql语句执行失败！', '02');

}

//如果没有异常被抛出则 sql语句全部执行成功 提交事务
$pdo->commit();


}catch(PDOexception $e){

//如果有异常被抛出 则事务失败 执行事务回滚
$pdo->rollback();

//输出异常信息
echo $e->getCode().'-----'.$e->getMessage();

$pdo = null;

}

?>