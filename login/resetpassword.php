<?php
    $pagetype = 'loginpage';
    $title = 'Reset Password';
    require 'partials/pagehead.php';
    require 'vendor/autoload.php';
?>
</head>

<body>
    <div class="container logindiv">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
<?php

$jwt = $_GET['t'];

$conf = new GlobalConf;

$secret = $conf->jwt_secret;

use \Firebase\JWT\JWT;

try {

    $decoded = JWT::decode($jwt, $secret, array('HS256'));

    $email = $decoded->email;
    $tokenid = $decoded->tokenid;
    $userid = $decoded->userid;
    $pw_reset = $decoded->pw_reset;

    $validToken = TokenHandler::selectToken($tokenid, $userid, 0);

    if ($validToken && ($decoded->pw_reset == "true")) {

        require "partials/resetform.php";

    } else {

        echo "<br><br><div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Invalid or expired token, please resubmit <a href='".BASE_URL."/login/forgotpassword.php'>forgot password form</a></div><div id='returnVal' style='display:none;'>false</div>";
    };

} catch (Exception $e) {

    echo "<br><br><div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$e->getMessage()."<br>Token failure, try re-sending request <a href='".BASE_URL."/login/forgotpassword.php'>here</a></div><div id='returnVal' style='display:none;'>false</div>";
}
?>
<div id="message"></div>
</div>
<div class="col-sm-4"></div>
</div>
</body>