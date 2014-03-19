<?php

try{
	session_start();
	session_destroy();
}catch(Exception $ex){
	echo $ex->getMessage();
}

?>
