<?php
session_start();
require_once('config.php');

  $HTML = '<h1>Потребителски изход</h1>';

if(isset($_SESSION['user_id']))
{ // Ако сме се логнали, имаме бутон за изход
  $HTML .= '<input type="button" value="Изход" onclick="window.location=\'controller.php?action=logout\';">';
}

require_once('design.php');
?>
