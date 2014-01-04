<?php
  session_start();
  require_once('config.php');

// NEW Product  
  if($_GET['action'] == 'new') 
  {
    if(isset($_POST['f_product']) && trim($_POST['f_product']) != '') {

      mysql_open();
      $product = mysql_real_escape_string($_POST['f_product']);
      $id = (int) $_POST['f_prod_id'];
      $descrip = mysql_real_escape_string($_POST['f_descrip']);
      $price = (float) $_POST['f_price'];
      $quantity = (int) $_POST['f_quantity'];
      
      if($id > 0)
      { // Промяна на продукт
        $Query = mysql_query('UPDATE products SET name="'.$product.'", descrip="'.$descrip.'", price="'.$price.'", quantity="'.$quantity.'" WHERE id = '.$id)or die(mysql_error());
      }
      else
      { // Нов продукт
        $Query = mysql_query('INSERT INTO products (name, descrip, price, quantity) 
                              VALUES ("'.$product.'", "'.$descrip.'", "'.$price.'", "'.$quantity.'")') or die(mysql_error());
      }
      
      if($Query)
      {
        $_SESSION['status'] = 'Вмъкването е успешно!';
        
        $_SESSION['last_product'] = '';
        $_SESSION['last_descrip'] = '';
        $_SESSION['last_price'] = '';
        $_SESSION['last_quantity'] = '';
        
        header('location: products.php');
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
      $_SESSION['last_prod_id'] = $_POST['f_prod_id'];
      $_SESSION['last_product'] = $_POST['f_product'];
      $_SESSION['last_descrip'] = $_POST['f_descrip'];
      $_SESSION['last_price'] = $_POST['f_price'];
      $_SESSION['last_quantity'] = $_POST['f_quantity'];
    
      header('location: product.php');
    }
  }
     
// REMOVE Product  
  if( ($_GET['action'] == 'remove') && ($_GET['prod_id']>0) ) 
  {
    if( $_SESSION['user_id']>1)    
    {
      mysql_open();
      $id = mysql_real_escape_string($_GET['prod_id']);
      $QGet = mysql_query('DELETE FROM products WHERE id = "'.$id.'" LIMIT 1') or die(mysql_error());
    } else {
        $_SESSION['status'] = 'Достъпът е отказан!';
    }
    mysql_close();  
    
    header('location: products.php');
    }
?>
