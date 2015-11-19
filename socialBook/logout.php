<? 
    /**
     * logout.php
     *
     * A simple logout module for all of our login modules.
     *
     */

    // enable sessions
    session_start();

    // delete cookies, if any
    setcookie("user", "", time() - 3600);
    setcookie("pass", "", time() - 3600);

    // log user out
    setcookie(session_name(), "", time() - 3600);
    session_destroy();
    header('Location: index.php');
?>
