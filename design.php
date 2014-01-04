<?php require_once('header.php'); ?>

<?php
  if(isset($_SESSION['status'])) {
    echo $_SESSION['status'];
    echo '<script>alert("'.$_SESSION['status'].'");</script>';
    unset($_SESSION['status']);
  }
  echo $HTML;
  ?>

<?php require_once('right.php'); ?>
<?php require_once('footer.php'); ?>