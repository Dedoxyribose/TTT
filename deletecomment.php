﻿<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php if(file_exists('header.php')) include 'header.php'; ?>

<?php if(file_exists('menu.php')) include 'menu.php'; ?>


<div class="content">

 <script>
var sID=<?php echo $_GET['id'];?>
</script>


<?php

define('ROOT_DIR', dirname(__FILE__));

if(file_exists('keys.php')) include 'keys.php';

$userstable = "comments"; 


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  
$query=sprintf("SELECT * FROM comments, prepods WHERE `comments`.id='%s' AND `prepods`.username=`comments`.author",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);

if ($number==0)
{
$query=sprintf("SELECT * FROM comments, users WHERE `comments`.id='%s' AND `users`.username=`comments`.author",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}	
}

$row=mysql_fetch_array($res);

?>

 <script>
var may=<?php 

if ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)
{
echo 'true'; 
}
else echo 'false';

?>;
</script>

<?php


if ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)
{
if ($row['filename']!="") unlink(ROOT_DIR.$row['filename']);
$query2=sprintf("DELETE FROM comments WHERE `comments`.id='%s'", mysql_real_escape_string($_GET['id']));
$res2 = mysql_query($query2) or die(mysql_error()); 	

echo '<span class="bigtext">Отзыв успешно удален!</span>';
}


?>

</div>

 
 
</body>

</html>