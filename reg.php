<?php
  session_start();
  require_once('config.php');
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  if(isset($_GET['id'])) {
    // Ако е зададено, значи променяме
    mysql_open();
    $QGet = mysql_query('SELECT * FROM users WHERE id = '.(int)$_GET['id']) or die(mysql_error());
    if(mysql_num_rows($QGet) == 1) {
      $_SESSION['last_user'] = mysql_result($QGet,0,'user');
      $_SESSION['last_pass'] = mysql_result($QGet,0,'pass');
      $_SESSION['last_mail'] = mysql_result($QGet,0,'mail');
      $_SESSION['last_type'] = mysql_result($QGet,0,'type_id');   
    }
    mysql_close();
  }
  if(!isset($_SESSION['last_user'])) {
    $_SESSION['last_user'] = '';
  }
  if(!isset($_SESSION['last_pass'])) {
    $_SESSION['last_pass'] = '';
  }
  if(!isset($_SESSION['last_mail'])) {
    $_SESSION['last_mail'] = '';
  }
  if(!isset($_SESSION['last_type'])) {
    $_SESSION['last_type'] = '';
  }
  $HTML = '<h1>Регистрация</h1><p>';
  $HTML .= '<form action="controller.php?action=register" method="post"> ';
  $HTML .= 'ПОТРЕБИТЕЛСКО ИМЕ: <input type="text" name="f_user" value="'.$_SESSION['last_user'].'"><br />
            <br />ПАРОЛ: <input type="text" name="f_pass" value="'.$_SESSION['last_pass'].'"><br />
            <br />E-mail: <input type="text" name="f_mail" value="'.$_SESSION['last_mail'].'"><br />
            <br />ВИД: <select name="f_type">';
  // Get All types from database
  mysql_open();
  $QGet = mysql_query('SELECT * FROM types')or die(mysql_error());
  if(mysql_num_rows($QGet) > 0) {
    while($row = mysql_fetch_row($QGet)) { 
      // Зареждаме типовете потребители
      $HTML .= '<option value="'.$row[0].'"'.($row[0] == $_SESSION['last_type'] ? ' selected="selected"' : '').'>'.$row[1].'</option>';
	 
    }
  }
  mysql_close();
  $HTML .= '</select>
            <br/><br/><input type="submit" value="Регистрация" size="10">';
if(isset($_SESSION['user_id'])){
	if ($_SESSION['user_type'] == 2){
		$HTML .=  '<input type="hidden" name="f_id" value="'.(int)$_GET['id'].'">';
	}
}
  $HTML .= '</form>';
  $HTML .= '</p>';

  require_once('design.php');
?>