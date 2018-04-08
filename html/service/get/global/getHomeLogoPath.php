<?php
require '../../jsonwrapper/jsonwrapper.php';
require 'global.php';
$temp['homeLogoPath'] = $data['homeLogoPath'];
echo json_encode($temp);

?>
