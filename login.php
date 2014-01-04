<?php

 $HTML = '<h1>ВХОД</h1><br /><form action="controller.php?action=login" method="post">
  ПОТРЕБИТЕЛ: <input type="text" name="f_user"/><br />
  <br />ПАРОЛА:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="f_pass"/><br />
  <br /><input type="submit" value="Вход"/> 
  </form>'; 

  require_once('design.php');
?>