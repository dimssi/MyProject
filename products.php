<?php
session_start();
require_once('config.php');

function PrepareOutput($text) {
  return ( trim($text) != '' ? $text : '&nbsp;' );
}

$HTML = '<p> </p><h2>Преглед на всички продукти:</h2>';

mysql_open();
$QGet = mysql_query('SELECT p.id, p.name, p.descrip, p.quantity, p.price FROM products p')or die(mysql_error());

$HTML .= '<table>
          <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
          </tr>';

//$role[1] = 'Client';
//$role[2] = 'Admin';       

$class = 2;

while($row = mysql_fetch_row($QGet)) {
  if ($class == 2) {$class = 1;} else {$class = 2;} // Въведете различен стил за всеки ODD ред на таблицата

  $HTML .= '<tr>
             <td class="row'.$class.'">'.PrepareOutput($row[0]).'</td>
             <td class="row'.$class.'">'.PrepareOutput($row[1]).'</td>
             <td class="row'.$class.'">'.PrepareOutput($row[2]).'</td>
             <td class="row'.$class.'">'.PrepareOutput($row[3]).'</td>
             <td class="row'.$class.'">'.PrepareOutput($row[4],2).'</td>';

  if(isset($_SESSION['user_id'])){
	if ($_SESSION['user_type'] == 2){
    $HTML .= '<td class="row'.$class.'">'.($_SESSION['user_type'] == 2 ? '<a href="product.php?prod_id='.$row[0].'">Промяна</a>' : '&nbsp;').'</td>
              <td class="row'.$class.'">'.($_SESSION['user_type'] == 2 ? '<a href="controller_prod.php?action=remove&amp;prod_id='.$row[0].'">Изтрий</a>' : '&nbsp;').'</td>
            </tr>';
	}}
}
$HTML .= '</table>';
 
if(isset($_SESSION['user_id']))
{
	if($_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1) {
		$HTML .= '<p style="padding: 10px;"><a href="product.php">Нов продукт</a></p>';
	}
}

mysql_close();

require_once('design.php');
?>
