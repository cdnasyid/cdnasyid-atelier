<?php do_action($this->slug.'-before-title'); ?>

<?php
$id = (int)$_REQUEST['pid'];
echo '<h1>' . cdns_the_title( get_the_title($id), $id, true ) . '</h1>';
?>

<?php do_action($this->slug.'-after-title'); ?>
