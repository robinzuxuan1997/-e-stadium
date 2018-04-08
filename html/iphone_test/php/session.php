<?php

include 'objects/UserModel.php';
include 'db/DB.php';

if(isset ($_REQUEST['q'])) {
    $q = $_REQUEST['q'];

    switch ($q) {
        case 1000:
            echo startSession();    //start session
            break;
        case 2021:
            $ans = authenticate($_REQUEST['user'], $_REQUEST['password']);
            if($ans == NULL)
                showLoginForm();
            else
                showChatRoom();
            break;
        case 3042:
            $ans = isLoggedIn();
            if($ans == NULL)
                showLoginForm();
            else
                showChatRoom();
            break;
        default:
            echo 'unhandled query';
    }
}
else {
    echo "<h2>There were some problems parsing request</2>";
}


function showLoginForm() {
    echo '
        <div>
            <form action=\'#\'>
             username:<input type="text" name="username"/></br>
             password:<input type="password" name="password"/></br>
             <input type="submit" title="Login"/>
            </form>
        </div>
        ';
}

function showChatRoom(){
    echo '
        <div>
            <ul class="rounded">
                <li class="forward"><a class="swap" href="#generalchatroom">General Room</a></li>
            </ul>
        </div>
        ';
}

function authenticate($username, $password, $validate=true) {

    /* Add slashes if necessary (for query) */
//    if(!get_magic_quotes_gpc()) {
//        $username = addslashes($username);
//    }

    $db = DB::getInstance();
    $user = UserModel::findById($db, $username);

    if($user == NULL) {
        return false;
    }


    $pass = $user->getPassword();
    $pass = stripslashes($pass);

    $password = stripslashes(md5($password));

    /* Validate that password is correct */
    if($password == $pass) {
        if(validate) {
            startSession();
            $_SESSION['user'] = $user;
        }
        return true; //Success! Username and password confirmed
    }
    else {
        return false; //Indicates password failure
    }
}


function startSession() {
    session_start();   //Tell PHP to start the session
}

function destroySession() {
    unset($_SESSION['user']);
    session_destroy();
}

function isLoggedIn() {

    /* userid has been set */
    if(isset($_SESSION['user'])) {
        $user = $_SESSION['user'];

        return authenticate($user->getUsername, $user->password);
    }

    /* User not logged in */
    else {
        return false;
    }
}

?>
