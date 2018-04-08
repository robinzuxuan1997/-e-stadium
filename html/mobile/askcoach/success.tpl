<? $p->startTemplate(); ?>
<? if (count($errors) > 0) foreach($errors as $error) { ?><script>window.alert("<?=$error?>");</script><? echo "\n"; } ?>
    <div>
        <div class="mobile_h1" style="margin-bottom: 1em; font-decoration: none;">
        Question submitted!</div>
        <div class="normal">
        <span class="form_label">Your Name:</span>
        <br />
        <?=$name?><br /><br />
        <span class="form_label">Your E-mail:</span><br />
        <?=$email?><br /><br />
        <span class="form_label">Your Hometown:</span><br />
        <?=$hometown?><br /><br />
        <span class="form_label">Your Question:</span><br />
        <?=$question?>
        <br /><br />
        <a href="<?=$webpath['ask']?>">Ask another question</a>
        </div>
    </div>
<? $p->close(); ?>
