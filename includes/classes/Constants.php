<?php

class Constants {

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

}

?>