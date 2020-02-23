<?php
include("../../../phpini.php");

if(!empty($_SESSION['cart']['products']))
{
	echo count($_SESSION['cart']['products']);
}else{
	echo 0;
}
?>