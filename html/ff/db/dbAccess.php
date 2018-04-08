<?php
include_once("../class/user.php");


class DB{

    private static $conn;

    public static function getConn(){
        if(!isset(self::$conn)){
            self::$conn = mysqli_connect('localhost', 'friendfinder', 'V!p_ff13', 'friendfinder'); 
            if(!self::$conn){
               echo 'Error connecting to database!';
            } 
        }
        return self::$conn;
    }

    public static function closeConn(){
        mysqli_close(self::$conn);
    }

    /*
    * Takes string username and creates/returns user object, null if user does not exist
    */
    public static function getUser($usr){
       $queryText = "SELECT * FROM profile WHERE Username='{$usr}'";
       return self::execQuery($queryText);
       }

    /*
    * Adds user info to database. Returns User object on success, else null
    */
    public static function addNewUser($fname, $lname, $age, $usrName, $pwd){
            $queryText = "INSERT INTO profile VALUES (NULL, '{$usrName}', '{$pwd}', '{$lname}', '{$fname}', '{$age}', NULL, NULL, NULL)";
            return self::execQuery($queryText);
    }

    public static function getFriendship($userid){
        $queryText = "SELECT FriendID FROM friendship WHERE UserID='{$userid}'";
        // part of a string of queries don't close conn
        return  mysqli_query(self::getConn(), $queryText);
    }

    public static function getUserInfo($usrid){
        $queryText = "SELECT * FROM profile WHERE uid='{$usrid}'";
        //return self::execQuery($queryText);
        return mysqli_query(self::getConn(), $queryText);
    }

    public static function updateAccount($username, $password, $firstname, $lastname, $age, $uid){
        $queryText = "UPDATE profile SET Username='{$username}',Password='{$password}',FirstName='{$firstname}',LastName='{$lastname}',Age='{$age}' WHERE uid='{$uid}'";
        return self::execQuery($queryText);
    }

    public static function updateLocation($lat, $long, $time, $uid){
        $queryText = "UPDATE profile SET Latitude='{$lat}',Longitude='{$long}',LogTime='{$time}' WHERE uid='{$uid}'";
        return self::execQuery($queryText);
    }

    private static function execQuery($queryText){

       $result = mysqli_query(self::getConn(),$queryText);
       //self::closeConn();
       return $result;
    }
}
?>
