<?php
session_start();
session_destroy();
require("includes/header.php");
?>
<form name="redirect">
    <center>
        <br><br>
        <b>You will be redirected on home page in<br><br>
            
                <output name="redirect2" > 
            
            </b>
    </center>
    <script>
        //target URL 
        var targetURL = "http://127.0.0.1:8000/forums"
        // second to start counting down from
        var countdownfrom = 5


        var currentsecond = document.redirect.redirect2.value = countdownfrom + 1
        function countredirect() {
            if (currentsecond != 1) {
                currentsecond -= 1
                document.redirect.redirect2.value = currentsecond
            }
            else {
                window.location = targetURL
                return
            }
            setTimeout("countredirect()", 1000)
        }

        countredirect()

    </script>