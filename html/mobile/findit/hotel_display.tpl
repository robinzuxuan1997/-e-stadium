<?
$p->startTemplate();
?>

<center><font class="mobile_h1"><u>Find Hotels</u><br></font></center>
<b><font class="mobile_h1"><?=$name?></font></b><br>
<img src="<?=$path->getPath("image_dir_root") . $logo?>"><br>
<br>
<img src="<?=$path->getPath("image_address_icon")?>"><br>
<?=$address?><br>
<?=$city?>, <?=$ustate?>  <?=$zipcode?><br>
<br>
<img src="<?=$path->getPath("image_contact_icon")?>"><br>
<img src="<?=$path->getPath("image_phone_icon")?>"><?=$phone?><br>
<img src="<?=$path->getPath("image_web_icon")?>"><a class="small" href="<?=$website?>"><?=$website?></a><br>
<img src="<?=$path->getPath("image_dollar_icon")?>"><?=$price?><br>
<br>
<img src="<?=$path->getPath("image_driving_icon")?>"><br>
Distance: <?=$distance?> miles<br>
<br>
<?
$p->close();
?>
