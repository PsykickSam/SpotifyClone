<?php

define('SALTSHA512', '$6$rounds=5000$usesomesillystringforsalt$');

class Account {

    private $errorList;
    private $conn;
    private $db_tables;
    private $querier;

    public function __construct($conn, $db_tables, $querier) {
        $this->errorList = array();
        $this->conn = $conn;
        $this->db_tables = $db_tables;
        $this->querier = $querier;
    }

    // public
    /**
     * Login
     * params: username password
     * return: TRUE/FALSE
     */
    public function login($uname, $pwd) {
        $hash = crypt($pwd, SALTSHA512);

        $conditions = array("andBetweenUsernamePassword");
        $query = array(
            $this->db_tables::$users['columns']['uname']=>$uname, 
            $conditions[0]=>"AND", 
            $this->db_tables::$users['columns']['paswd']=>$hash
        );
        $sql = $this->querier::get($this->db_tables::$users['table'], $query, $conditions, array());
        $result = mysqli_query($this->conn, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            return true;
        }
        array_push($this->errorList, Constant::$loginFailed);
        return false;
    }

    /**
     * Register
     * params: username, firstname, lastname, email, confirm email, password, confirm password
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
            // add user data database
            return $this->addUserDetails($uname, $fname, $lname, $email, $pwd);
        } else {
            return false;
        }
    }

    /**
     * Get Errors
     * params: error
     * return: Error message with span(Tag)
     */
    public function getError($error)
    {
        if (!in_array($error, $this->errorList)) {
            $error = "";
        }
        return "<span class='errorMessage'>$error</span>";
    }

    // private 
    // --> Methods
    /**
     * Insert user details
     * params: username, firstname, lastname, email, password
     * return: 
     */
    private function addUserDetails($uname, $fname, $lname, $email, $pwd)
    {
        $hash = crypt($pwd, SALTSHA512);
        $profilePic = "assets/images/profile-pics/default.png";
        $date = date("Y-m-d");

        $values = array('', $uname, $fname, $lname, $email, $hash, $profilePic, $date);
        $sql = $this->querier::add($this->db_tables::$users['table'], $values);

        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    // --> Validations
    /**
     * Validata username
     * Check: lenth, isExists
     * return: NaN
     */
    private function validateUsername($uname)
    {
        if (strlen($uname) < 5 || strlen($uname) > 25) {
            array_push($this->errorList, Constant::$usernameCharecters);
            return;
        }

        $query = array($this->db_tables::$users['columns']['uname']=>$uname);
        $sql = $this->querier::get($this->db_tables::$users['table'], $query, array(), array());
        $checkUsername = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($checkUsername) != 0) {
            array_push($this->errorList, Constant::$usernameTaken);
            return;
        }
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
            array_push($this->errorList, Constant::$firstnameCharecters);
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
            array_push($this->errorList, Constant::$lastnameCharecters);
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
            array_push($this->errorList, Constant::$emailNotMatch);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorList, Constant::$emailNotValid);
            return;
        }

        $query = array($this->db_tables::$users['columns']['email']=>$email);
        $sql = $this->querier::get($this->db_tables::$users['table'], $query, array(), array());
        $checkEmail = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($checkEmail) != 0) {
            array_push($this->errorList, Constant::$emailTaken);
            return;
        }
    }

     /**
     * Validate password, confirmPassword
     * check: password equals confirmPassword, regx match, lenght
     * return: NaN
     */
    private function validatePasword($pwd, $cpwd) 
    {
        if ($pwd != $cpwd) {
            array_push($this->errorList, Constant::$passwordNotMatch);
            return;
        }

        if (preg_match('/[^A-Za-z0-9]/', $pwd)) {
            array_push($this->errorList, Constant::$passwordNotAlphanumeric);
            return;
        }

        if (strlen($pwd) < 6) {
            array_push($this->errorList, Constant::$passwordCharecters);
            return;
        }
    }

}

?>