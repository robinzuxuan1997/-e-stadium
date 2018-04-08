<html>
<?php
if (isset($_GET['status'])) {
    /*
    file_put_contents("GTbbWifiStatus.txt","up");
    or
    file_put_contents("GTbbWifiStatus.txt","down");
     */
    file_put_contents("GTbbWifiStatus.txt",$_GET['status']);
}
?>
<head lang="en">
    <meta charset="UTF-8">
    <title>GT Baseball Wi-Fi Controller</title>
    <style>
        body {
            margin-top: 5%;
            text-align: center;
        }

        .button {
            width: 200px;
            height: 100px;
            color: #000000;
            font-size: large;
            font-weight: bold;
            padding: 10px;
            border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
        }

        .button:active{
            background-color: #000000;
            color: #FFFFFF;
        }

        .on {
            background-color: #00FF00;
        }

        .off {
            background-color: #FF0000;
        }
    </style>
</head>
<body>
<h1>GT Baseball Wi-Fi Controller</h1>
<button class="button big-btn on" onclick="writeStatus('up');">Turn ON Wi-Fi</button>
<br/><br/><br/>
<button class="button big-btn off" onclick="writeStatus('down');">Turn OFF Wi-Fi</button>

<script src="jquery-1.11.2.js"></script>
<script>
    function writeStatus(status){
        var url = "controller.php?status=" + status;
        $.ajax( url )
            .done(function() {
                if(status == "up"){
                    alert( "Turned ON WiFi" );
                }
                else if(status == "down"){
                    alert( "Turned OFF WiFi" );
                }

            })
            .fail(function() {
                alert( "error" );
            });
    }
</script>
</body>

</html>
