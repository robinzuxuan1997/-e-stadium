<?php

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

    public static function checkLogin($usr, $pwd){
       $queryText = "SELECT * FROM profile WHERE Username='{$usr}' AND Password='{$pwd}'";
       return self::execQuery($queryText);
    }

    public static function checkUserExists($usr){
       $queryText = "SELECT * FROM profile WHERE Username = '{$usr}'";
       //TODO: Look into, this and addnewacct our being called back to back too quick 
       return mysqli_query(self::getConn(), $queryText);
    }

    public static function addNewAcct($usr, $pwd, $fnm, $lnm, $age){
       $queryText = "INSERT INTO profile (Username, Password, Firstname, LastName , Age) Values('{$usr}', '{$pwd}', '{$fnm}', '{$lnm}', '{$age}')"; 
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
       self::closeConn();
       return $result;
    }
}
?>
