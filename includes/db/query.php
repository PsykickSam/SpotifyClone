<?php 

class Query {

    /**
     * ------------------
     * Meaning of methods
     * ------------------
     * get -> SELECT
     * add -> INSERT
     * edit -> UPDATE
     * del -> DELETE
     * ------------------------------------------------
     * used for single line query, not for nested query
     * ------------------------------------------------
     */
    
    /**
     * TABLE: Any
     * do: create sql with params
     * params: table, array, condition, cluse
     * return: string sql
     * how to: table -> name of the table
     *         params -> key-value [0] <-> condition [1] <-> key-value [3] <-> clause [2]
     *                -> for not --> ex. ("not", array(column, value))
     *                -> for others --> ex. ("column"=>"value")
     *         condintion -> condition keys array, must be unique
     *         clause -> clause keys array
     */
    public static function get($table, $params, $condtion, $clause) {
        $sql = "SELECT * FROM " . $table;
        if (!$params) {
            return $sql;
        }

        $sql .= " WHERE ";
        foreach ($params as $key => $value) {
            if (in_array($key, $clause)) {
                $sql .= " " . $key . " " . $value . " ";          
            } else if (in_array($key, $condtion)) {
                $sql .= " " . $value . " ";
            } else {
                if ($key == "not") {
                    $sql .= " " . $value[0] . " != '" . $value[1] . "' ";          
                } else {            
                    $sql .= " " . $key . " = '" . $value . "' ";          
                }
            }
        }

        return $sql;
    }

    /**
     * TABLE: Any
     * do: create sql with params
     * params: table, values
     * return: string sql
     * how to: table -> name of the table 
     *         values -> array of values need all the columns of table, if empty then use ('')
     */
    public static function add($table, $values) {
        $sql = "INSERT INTO " . $table . " VALUES (";
        foreach ($values as $key => $value) {
            if ($key != count($values) - 1) {
                $sql .= "'" .$value . "', ";
                continue;
            }
            $sql .= "'" .$value . "'";
        }
        $sql .= ")";

        return $sql;
    }

}

?>