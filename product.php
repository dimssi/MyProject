<?php
  session_start();
  require_once('config.php');
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  if(isset($_GET['prod_id'])) {
    // Ако е зададено, значи променяме
    mysql_open();
    $QGet = mysql_query('SELECT * FROM products WHERE id = '.(int) $_GET['prod_id']) or die(mysql_error());
    if(mysql_num_rows($QGet) == 1) {
      $_SESSION['last_product'] = mysql_result($QGet,0,'name');
      $_SESSION['last_descrip'] = mysql_result($QGet,0,'descrip');
      $_SESSION['last_price'] = mysql_result($QGet,0,'price');
      $_SESSION['last_quantity'] = mysql_result($QGet,0,'quantity');
    }
    mysql_close();
  }
  if(!isset($_SESSION['last_product'])) {
    $_SESSION['last_descrip'] = '';
    $_SESSION['last_price'] = '';
    $_SESSION['last_quantity'] = '';
  }
  
  $HTML = '<h2>Продукт</h2><p>';
  $HTML .= '<form action="controller_prod.php?action=new" method="post"> ';
  $HTML .= 'ИМЕ: <input type="text" name="f_product" value="'.$_SESSION['last_product'].'"><br />
            <br />ОПИСАНИЕ: <input type="text" name="f_descrip" value="'.$_SESSION['last_descrip'].'"><br />
            <br />ЦЕНА: <input type="text" name="f_price" value="'.$_SESSION['last_price'].'"> <small>Пример: 26.30</small><br />
            <br />БРОЙ: <input type="text" name="f_quantity" value="'.$_SESSION['last_quantity'].'"><br />';
  
  $HTML .= '</select>
            <br/><br/><input type="submit" value="Запис" size="10">';
  $HTML .=  '<input type="hidden" name="f_prod_id" value="'.((int)$_GET['prod_id']).'">';
  $HTML .=  '</form>';
  $HTML .= '</p>';

if(isset($_SESSION['user_id']))
{  
	if ($_SESSION['user_type'] == 2){
		$HTML .= '<p style="padding: 10px;"><a href="product.php">Нов продукт</a></p>';
	}
}

  require_once('design.php');
?>