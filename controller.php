<?php
  session_start();
  require_once('config.php');

// REGISTER  
  if($_GET['action'] == 'register') 
  {
    if(isset($_POST['f_user']) && trim($_POST['f_user']) != '' &&
       isset($_POST['f_pass']) && trim($_POST['f_pass']) != '' &&
       isset($_POST['f_mail']) && trim($_POST['f_mail']) != '') {

      mysql_open();
      
      $user = mysql_real_escape_string($_POST['f_user']);
      $mail = mysql_real_escape_string($_POST['f_mail']);
      $pass = mysql_real_escape_string($_POST['f_pass']);
      
      $type = (int) $_POST['f_type'];
      $id = (int) $_POST['f_id'];
      
      if($id > 0)
      { // Значи променяме...
        $Query = mysql_query('UPDATE users SET user="'.$user.'", pass="'.$pass.'", mail="'.$mail.'", type_id='.$type.' WHERE id = '.$id)or die(mysql_error());
      }
      else
      { // Значи вмъкваме...
        $Query = mysql_query('INSERT INTO users(user, pass, mail, type_id) VALUES("'.$user.'", "'.$pass.'", "'.$mail.'", '.$type.')') or die(mysql_error());
      }
      
      if($Query)
      {
        $_SESSION['status'] = 'Успешно вмъкване!';
        
        $_SESSION['last_user'] = '';
        $_SESSION['last_mail'] = '';
        $_SESSION['last_pass'] = '';
        
        header('location: users.php');
      }
      else
      {
        $_SESSION['status'] = 'Грешка!!!';
        header('location: reg.php');
      }
      
       
      mysql_close();
    }
    else
    {
      // Тука ще има съобщение за задължителни полета
      $_SESSION['status'] = 'Всички полета са задължителни!';
    
      // Записваме нещата, 
      // за да не ги въвежда потребителя отново...
      $_SESSION['last_user'] = $_POST['f_user'];
      $_SESSION['last_mail'] = $_POST['f_mail'];
      $_SESSION['last_pass'] = $_POST['f_pass'];
      $_SESSION['last_type'] = $_POST['f_type'];
    
      header('location: reg.php');
    }
  }
  
// LOGIN  
  if($_GET['action'] == 'login')
  {
    if(
      isset($_POST['f_user']) && 
      isset($_POST['f_pass'])
    )
    {
      mysql_open();
      
      $user = mysql_real_escape_string($_POST['f_user']);
      $pass = mysql_real_escape_string($_POST['f_pass']);
      
      
      $QGet = mysql_query('SELECT * FROM users WHERE user = "'.$user.'" AND pass = "'.$pass.'" LIMIT 1') or die(mysql_error());
      
      // Проверяваме дали има такъв User & Pass
      if(mysql_num_rows($QGet) != 0)
      {
        
        $_SESSION['user_id'] = mysql_result($QGet, 0, 'id');
        $_SESSION['user_name'] = mysql_result($QGet, 0, 1);
        $_SESSION['user_type'] = mysql_result($QGet, 0, 'type_id');
        $_SESSION['status'] = 'Добре дошли,'." ".$_SESSION['user_name']."!";
        
        header('location: users.php');
      }
      else
      {
        $_SESSION['status'] = 'Достъпът е отказан!';
        header('location: login.php'); 
      }
      
      mysql_close();
    }
  }

// LOGOUT  
  if($_GET['action'] == 'logout')
  {
    $_SESSION['user_id'  ] = false;
    $_SESSION['user_name'] = false;
    $_SESSION['user_type'] = false;
    
    unset($_SESSION['user_id']  );
    unset($_SESSION['user_name']);
    unset($_SESSION['user_type']);
    
    $_SESSION['status'] = 'Вие излезнахте от профила си!';
    
    header('location: users.php');
  }

    
// REMOVE  
  if( ($_GET['action'] == 'remove') && ($_GET['id']>0) ) 
  {
    if( $_SESSION['user_type']>1)    
    {
      mysql_open();
      $user = mysql_real_escape_string($_GET['id']);
      $QGet = mysql_query('DELETE FROM users WHERE id = "'.$user.'" LIMIT 1') or die(mysql_error());
    } else {
        $_SESSION['status'] = 'Достъпът е отказа!';
    }
    mysql_close();  
    
    header('location: users.php');
    }
?>
