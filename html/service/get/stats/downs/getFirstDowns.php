<?php
require '../stats.php';
$data['firstDowns'] = $total->getFirstDowns();
echo json_encode($data);
?>
