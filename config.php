<?php

function mysql_open(){
  if($_SERVER['SERVER_ADDR'] == '127.0.0.1') 
  {
      $dbhost = "localhost";
      $dbuser = "root";
      $dbpass = "";
      $dbname = "dbkp3";
}
  else
  {
      $dbhost = "localhost";   
      $dbuser = "root";
      $dbpass = "";
      $dbname = "dbkp3";
  }
 
  $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die("Сайтът не може да се свърже към базата данни <br />". mysql_error());
  mysql_select_db($dbname, $conn) or die("Сайтът не може да се свърже към таблицата от базата данни <br />". mysql_error());
  mysql_query('set names utf8', $conn); 
}
