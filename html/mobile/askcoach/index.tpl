<? 
$p->startTemplate();
$p->setDisplayMode("form");
?>
<? if (count($errors) > 0) foreach($errors as $error) { ?><script>window.alert("<?=$error?>");</script><? echo "\n"; } ?>
    <div>
        <div class="mobile_h1" style="margin-bottom: 1em;">Ask the Coach!
            <span class="mobile_h2">(<a href="#info">What's this?</a>)</span>
        </div>
        <div style="margin-bottom: 1em;">
            <form method="post" action="<?=$p->pageName()?>">
            <label for="name" class="form_label">Your Name:</label><br />
            <?$p->displayVar("name");?><br>
            <label for="email" class="form_label">Your E-mail: (for response)</label><br />
            <?$p->displayVar("email");?><br>
            <label for="hometown" class="form_label">Your Hometown:</label><br />
            <?$p->displayVar("hometown");?><br>
            <label for="question" class="form_label" style="text-decoration: underline; font-style: italic;">Your Question* (<500 characters)</label><br />
            <?$p->displayVar("question");?><br>
            <?$p->displayVar("view");?>
            <?$p->displayVar("submit");?>
            </form>
            <p class="small" style="font-style: italic;">Note: Questions submitted through 'Ask the Coach' are not guaranteed to be read by the coach.</p>
            <a name="info"></a>
            <span class="normal" style="font-weight: bold;">What is 'Ask the Coach'?</span><br />
            <div class="normal"><p>Messages submitted through 'Ask the Coach' are forwarded to Purdue Athletics Staff where they are filtered for interesting questions and themes.</p>
            <p>The chosen questions are forwarded to the coach's staff to be discussed on his weekly radio and television shows.</p>
            <p>By using this 'Ask the Coach' application, you acknowledge that any information you enter may be stored and read by Purdue staff and/or students.</p></div>
        </div>
    </div>
<? $p->close(); ?>
