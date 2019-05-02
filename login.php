<?php
    if(isset($_SESSION['logged_in'])){
        session_unset();
        session_destroy();

        header("Location: ".$_SERVER['PHP_SELF']);
        die();
    }


    if(isset($_POST['submit_login'])){
        $login = mysqli_real_escape_string($conn, $_POST['login']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");

        if(empty($login) || empty($password)){
            $_SESSION['error_login'] = "Wszystkie pola są wymagane.";
            header("Location: ".$_SERVER['HTTP_REFERER']);
            die();
        }

        $find_user_query = "SELECT * FROM users WHERE user_login = ?;";
        $find_user_stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($find_user_stmt, $find_user_query);
        mysqli_stmt_bind_param($find_user_stmt, "s", $login);
        mysqli_stmt_execute($find_user_stmt);
        $find_user_result = mysqli_stmt_get_result($find_user_stmt);

        if(mysqli_num_rows($find_user_result) == 0){
            $_SESSION['error_login'] = "Nieprawidłowy login lub hasło.";
            header("Location: ".$_SERVER['HTTP_REFERER']);
            die();
        }

        foreach($find_user_result as $userData){
            $user_id = $userData['user_id'];
            $pass_check = $userData['user_pass'];
        }
        if(!password_verify($password, $pass_check)){
            $_SESSION['error_login'] = "Nieprawidłowy login lub hasło.";
            header("Location: ".$_SERVER['HTTP_REFERER']);
            die();
        
        }

        $_SESSION['logged_in'] = $user_id;
        header("Location: ".$_SERVER['PHP_SELF']);
        die();
    }
?>

<?php
    include "header.php";
?>

<section class='login_page'>
    <form method='POST' class='login_form'>
        <h1>Logowanie</h1>
        <input type='text' placeholder='Login' name='login'  autofocus>
        <input type='password' placeholder="Hasło" name='password' >
        <?php checkErrors("login"); ?>
        <input type='submit' value='Zaloguj' name='submit_login'>
    </form>
</section>

<?php
    include "footer.php";