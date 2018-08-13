<?php 

class Utils {

    public static function getInputValue($name) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return "";
    }

}

?>