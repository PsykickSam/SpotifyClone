<?php


class Constant {

    // define('SALTSHA512', '$6$rounds=5000$usesomesillystringforsalt$');

    public static $SALTSHA512 = '$6$rounds=5000$usesomesillystringforsalt$';

    // 
    public static $session_loggedin = "userLoggedIn";

    // 
    public static $passwordNotMatch = "Passwords are not matching.";
    public static $passwordNotAlphanumeric = "Password only contains numbers and letters.";
    public static $passwordCharecters = "Password must have atleast 6 charecters.";

    public static $emailNotMatch = "Emails are not matching.";
    public static $emailNotValid = "Email is not valid.";
    public static $emailTaken = "Email is already exists, taken by other user.";
    
    public static $lastnameCharecters = "Lastname should be in between 2 to 30 charecters.";

    public static $firstnameCharecters = "Firstname should be in between 2 to 30 charecters.";
    
    public static $usernameCharecters = "Username should be in between 5 to 25 charecters.";
    public static $usernameTaken = "Username is already exists, taken by other user.";
    
    public static $loginFailed = "Your username and password is incorrect.";

    public static $usernameEmailNotSet = "Username or Email is not set.";
    public static $usernameNotDefined = "Username is not defiend. (e.g. Login to your account first)";
    public static $emailNotDefined = "Email is not defiend. (e.g. Set a valid email first)";
    public static $emailIsAlreadyInUse = "Email is already in use. (e.g. Set an unique email)";

    public static $userNameAndPasswordNotSet = "Username or Password not set correctly.";
    public static $passwordEmpty = "Password is empty.";
    public static $passwordIncorrect = "Password is incorrect.";
    public static $passwordUpdated = "Password is updated.";

    public static $updateEmailSuccess = "Email has beed updated.";

}

?>