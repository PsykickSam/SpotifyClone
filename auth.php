<?php 

include ('includes/utilities/utils.php');

include ('includes/db/db_connect.php');
include ('includes/db/query.php');

include ('includes/classes/Constants.php');
include ('includes/classes/Accounts.php');

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
    </head>

    <body>
        <div id="inputContainer">
            <!-- Login -->
            <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <h3>Login to your Account</h3>
                <p>
                    <?php echo $account->getError(Constants::$loginFailed); ?>
                    <label for="loginUsername">Username</label>
                    <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. jhonDoe" value="<?php echo Utils::getInputValue('loginUsername'); ?>" required>
                </p>
                <p>
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" name="loginPassword" placeholder="Password" value="<?php echo Utils::getInputValue('loginPassword'); ?>" required>
                </p>
                <button type="submit" name="loginSubmit">Login</button>
            </form>

            <!-- Register -->
            <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <h3>Register an Account</h3>
                <p>
                    <?php echo $account->getError(Constants::$usernameCharecters); ?>
                    <?php echo $account->getError(Constants::$usernameTaken); ?>
                    <label for="registerUsername">Username</label>
                    <input type="text" id="registerUsername" name="registerUsername" placeholder="e.g. jhonDoe" value="<?php echo Utils::getInputValue('registerUsername'); ?>" required>
                </p>
                <p>
                    <?php echo $account->getError(Constants::$firstnameCharecters); ?>
                    <label for="registerFirstName">First Name</label>
                    <input type="text" id="registerFirstName" name="registerFirstName" placeholder="e.g. Jhon" value="<?php echo Utils::getInputValue('registerFirstName'); ?>" required>
                </p>
                <p>
                    <?php echo $account->getError(Constants::$lastnameCharecters); ?>    
                    <label for="registerLastName">Last Name</label>
                    <input type="text" id="registerLastName" name="registerLastName" placeholder="e.g. Doe" value="<?php echo Utils::getInputValue('registerLastName'); ?>" required>
                </p>
                <p>
                    <?php echo $account->getError(Constants::$emailNotMatch); ?>
                    <?php echo $account->getError(Constants::$emailNotValid); ?>
                    <?php echo $account->getError(Constants::$emailTaken); ?>
                    <label for="registerEmail">Email</label>
                    <input type="email" id="registerEmail" name="registerEmail" placeholder="Email" value="<?php echo Utils::getInputValue('registerEmail'); ?>" required>
                </p>
                <p>
                    <label for="registerConfirmEmail">Confirm Email</label>
                    <input type="email" id="registerConfirmEmail" name="registerConfirmEmail" placeholder="Confirm Email" value="<?php echo Utils::getInputValue('registerConfirmEmail'); ?>" required>
                </p>
                <p>
                    <?php echo $account->getError(Constants::$passwordNotMatch); ?>
                    <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                    <?php echo $account->getError(Constants::$passwordCharecters); ?>
                    <label for="registerPassword">Password</label>
                    <input type="password" id="registerPassword" name="registerPassword" placeholder="Password" value="<?php echo Utils::getInputValue('registerPassword'); ?>" required>
                </p>
                <p>
                    <label for="registerConfirmPassword">Confirm Password</label>
                    <input type="password" id="registerConfirmPassword" name="registerConfirmPassword" placeholder="Confirm Password" value="<?php echo Utils::getInputValue('registerConfirmPassword'); ?>" required>
                </p>
                <button type="submit" name="registerSubmit">Register</button>
            </form>
        </div>
    </body>
</html>