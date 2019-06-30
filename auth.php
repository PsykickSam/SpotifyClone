<?php 

include ('includes/utilities/utils.php');

include ('includes/db/db_connect.php');
include ('includes/db/query.php');

include ('includes/classes/Constant.php');
include ('includes/classes/Account.php');

$db = new Connection();
$querier = new Query();
$account = new Account($db->connection(), $db->db_tables(), $querier);

// includes -> handlers
include ('includes/handlers/register.hdr.php');
include ('includes/handlers/login.hdr.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome to Spotify</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="assets/css/auth.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="assets/js/auth.js"></script>
    </head>

    <body>
        <?php
        
        if (isset($_POST['registerSubmit'])) {
            echo '
                <script>
                    $(document).ready(function () {
                        $("#registerForm").show()
                        $("#loginForm").hide()
                    })
                </script>';
        } else {
            echo '
                <script>
                    $(document).ready(function () {
                        $("#registerForm").hide()
                        $("#loginForm").show()
                    })
                </script>';
        }

        ?>

        <div id="background">
            <div id="authContainer">

                <div id="inputContainer">
                    <!-- Login -->
                    <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <h2>Login to your Account</h2>
                        <p>
                            <?php echo $account->getError(Constant::$loginFailed); ?>
                            <label for="loginUsername">Username</label>
                            <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. jhonDoe" value="<?php echo Utils::getInputValue('loginUsername'); ?>" required>
                        </p>
                        <p>
                            <label for="loginPassword">Password</label>
                            <input type="password" id="loginPassword" name="loginPassword" placeholder="Password" value="<?php echo Utils::getInputValue('loginPassword'); ?>" required>
                        </p>
                        <button type="submit" name="loginSubmit">LOG IN</button>

                        <div class="hasAccountText">
                            <span>Don't have an account? </span>
                            <span id="hideLogin">Register</span>
                        </div>
                    </form>

                    <!-- Register -->
                    <form id="registerForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <h2>Register an Account</h2>
                        <p>
                            <?php echo $account->getError(Constant::$usernameCharecters); ?>
                            <?php echo $account->getError(Constant::$usernameTaken); ?>
                            <label for="registerUsername">Username</label>
                            <input type="text" id="registerUsername" name="registerUsername" placeholder="e.g. jhonDoe" value="<?php echo Utils::getInputValue('registerUsername'); ?>" required>
                        </p>
                        <p>
                            <?php echo $account->getError(Constant::$firstnameCharecters); ?>
                            <label for="registerFirstName">First Name</label>
                            <input type="text" id="registerFirstName" name="registerFirstName" placeholder="e.g. Jhon" value="<?php echo Utils::getInputValue('registerFirstName'); ?>" required>
                        </p>
                        <p>
                            <?php echo $account->getError(Constant::$lastnameCharecters); ?>    
                            <label for="registerLastName">Last Name</label>
                            <input type="text" id="registerLastName" name="registerLastName" placeholder="e.g. Doe" value="<?php echo Utils::getInputValue('registerLastName'); ?>" required>
                        </p>
                        <p>
                            <?php echo $account->getError(Constant::$emailNotMatch); ?>
                            <?php echo $account->getError(Constant::$emailNotValid); ?>
                            <?php echo $account->getError(Constant::$emailTaken); ?>
                            <label for="registerEmail">Email</label>
                            <input type="email" id="registerEmail" name="registerEmail" placeholder="Email" value="<?php echo Utils::getInputValue('registerEmail'); ?>" required>
                        </p>
                        <p>
                            <label for="registerConfirmEmail">Confirm Email</label>
                            <input type="email" id="registerConfirmEmail" name="registerConfirmEmail" placeholder="Confirm Email" value="<?php echo Utils::getInputValue('registerConfirmEmail'); ?>" required>
                        </p>
                        <p>
                            <?php echo $account->getError(Constant::$passwordNotMatch); ?>
                            <?php echo $account->getError(Constant::$passwordNotAlphanumeric); ?>
                            <?php echo $account->getError(Constant::$passwordCharecters); ?>
                            <label for="registerPassword">Password</label>
                            <input type="password" id="registerPassword" name="registerPassword" placeholder="Password" value="<?php echo Utils::getInputValue('registerPassword'); ?>" required>
                        </p>
                        <p>
                            <label for="registerConfirmPassword">Confirm Password</label>
                            <input type="password" id="registerConfirmPassword" name="registerConfirmPassword" placeholder="Confirm Password" value="<?php echo Utils::getInputValue('registerConfirmPassword'); ?>" required>
                        </p>
                        <button type="submit" name="registerSubmit">REGISTER</button>

                        <div class="hasAccountText">
                            <span>Already have an account? </span>
                            <span id="hideRegister">Login</span>
                        </div>
                    </form>
                </div>

                <div id="loginText">
                    <h1>Get great music, right now</h1>
                    <h2>Listen to loads of songs for free.</h2>
                    <ul>
                        <li>Discover music you'll fall in love with</li>
                        <li>Create your own playlist</li>
                        <li>Follow artist to keep up to date</li>
                    </ul>
                </div>

            </div>
        </div>
    </body>
</html>