<?php

// functions
function sanitizeRegisterText($text, $isSpaceRemove, $isUpperLowerChar)
{
    $text = strip_tags($text);
    
    if ($isSpaceRemove) 
        $text = str_replace(" ", "", $text);

    if ($isUpperLowerChar) 
        $text = ucfirst(strtolower($text));

    return $text;
}
// functions

if (isset($_POST['registerSubmit'])) {

    $username = sanitizeRegisterText($_POST['registerUsername'], TRUE, FALSE);
    $firstname = sanitizeRegisterText($_POST['registerFirstName'], TRUE, TRUE);
    $lastname = sanitizeRegisterText($_POST['registerLastName'], TRUE, TRUE);
    $email = sanitizeRegisterText($_POST['registerEmail'], TRUE, TRUE);
    $confirmEmail = sanitizeRegisterText($_POST['registerConfirmEmail'], TRUE, TRUE);
    $password = sanitizeRegisterText($_POST['registerPassword'], FALSE, FALSE);
    $confirmPassword = sanitizeRegisterText($_POST['registerConfirmPassword'], FALSE, FALSE);

    $isSuccessful = $account->register($username, $firstname, $lastname, $email, $confirmEmail, $password, $confirmPassword);
    
    if ($isSuccessful) {
        $_SESSION[Constants::$session_loggedin] = $username;
        header('Location: index.php');
    }

}

?>