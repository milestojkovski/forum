
<?php
/*
  session_start();
  session_unregister("USERNAME");
  session_unregister("ADMIN");
  require("includes/config.php");



  header("Location: " . $config_basedir); */

//require("includes/config.php");

session_start();
session_destroy();

require("includes/header.php");
//echo"sucessfull logout";
//echo"you will be redirected on home page in 5 seconds.";
//header( "refresh:5;url=$config_basedir" );
?>
<!--<script>
    window.location = "http://127.0.0.1:8000/forums" ;
</script>-->



<!--
<script>
var seconds = 5;
var url = "http://127.0.0.1:8000/forums";
setTimeout("window.location='"+url+"'",seconds);
</script>
-->


<form name="redirect">
    <center>
        <b>You will be redirected to the script in<br><br>
            <form>
                <input type="text" size="3" name="redirect2">
            </form>
            seconds</b>
    </center>


    <script>
        //change below target URL to your own
        var targetURL = "http://127.0.0.1:8000/forums"
        //change the second to start counting down from
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