<?php

// functions
function sanitizeLoginText($text, $isSpaceRemove)
{
    $text = strip_tags($text);
    
    if ($isSpaceRemove) 
        $text = str_replace(" ", "", $text);

    return $text;
}
// functions

if (isset($_POST['loginSubmit'])) {

    $username = sanitizeLoginText($_POST['loginUsername'], TRUE);
    $password = sanitizeLoginText($_POST['loginPassword'], FALSE);

    $result = $account->login($username, $password);

    if ($result) {
        $_SESSION[Constant::$session_loggedin] = $username;

        header("Location: index.php");
    }
    
}

?>