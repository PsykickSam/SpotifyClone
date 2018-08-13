<?php

class Account {

    private $errorList;

    public function __construct() {
        $this->errorList = array();
    }

    // public
    /**
     * Register
     * params: Username, Firstname, Lastname, Email, Confirm Email, Password, Confirm Password
     * return: TRUE/FALSE
     */
    public function register($uname, $fname, $lname, $email, $cemail, $pwd, $cpwd) 
    {
        $this->validateUsername($uname);
        $this->validateFirstname($fname);
        $this->validateLastname($lname);
        $this->validateEmail($email, $cemail);
        $this->validatePasword($pwd, $cpwd);

        if (empty($this->errorList)) {
            // TODO: insert into database
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get Errors
     * params: Error
     * return: Error message with span(Tag)
     */
    public function getError($error)
    {
        if (!in_array($error, $this->errorList)) {
            $error = "";
        }
        return "<span class='errorMessage'>$error</span>";
    }

    // private --> (START | ->, when | END)
    /**
     * Validata username
     * Check: lenth, isExists
     * return: NaN
     */
    private function validateUsername($uname)
    {
        if (strlen($uname) < 5 || strlen($uname) > 25) {
            array_push($this->errorList, Constants::$usernameCharecters);
            return;
        }

        # TODO: is username exists
    }

    /**
     * Validate lastname
     * check: length
     * return: NaN
     */
    private function validateFirstname($name)
    {
        $len = strlen($name);
        if ($len < 2 || $len > 30) {
            array_push($this->errorList, Constants::$firstnameCharecters);
            return;
        }
    }

    /**
     * Validate lastname
     * check: length
     * return: NaN
     */
    private function validateLastname($name)
    {
        $len = strlen($name);
        if ($len < 2 || $len > 30) {
            array_push($this->errorList, Constants::$lastnameCharecters);
            return;
        }
    }

    /**
     * Validate email, confirmEmail
     * check: emails equals confirmEmail, valid email
     * return: NaN
     */
    private function validateEmail($email, $cemail)
    {
        if ($email != $cemail) {
            array_push($this->errorList, Constants::$emailNotMatch);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorList, Constants::$emailNotValid);
            return;
        }

        # TODO: is email exists
    }

     /**
     * Validate password, confirmPassword
     * check: password equals confirmPassword, regx match, lenght
     * return: NaN
     */
    private function validatePasword($pwd, $cpwd) 
    {
        if ($pwd != $cpwd) {
            array_push($this->errorList, Constants::$passwordNotMatch);
            return;
        }

        if (preg_match('/[^A-Za-z0-9]/', $pwd)) {
            array_push($this->errorList, Constants::$passwordNotAlphanumeric);
            return;
        }

        if (strlen($pwd) < 6) {
            array_push($this->errorList, Constants::$passwordCharecters);
            return;
        }
    }

}

?>