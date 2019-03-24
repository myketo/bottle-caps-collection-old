<?php
    if(isset($_SESSION['logged_in'])){
        session_unset();
        session_destroy();

        header("Location: /home");
        die();
    }

    if(isset($_POST['loginSubmit'])){
        $noErrors = true;

        $login = mysqli_real_escape_string($connect, $_POST['login']);
        $pass = mysqli_real_escape_string($connect, $_POST['pass']);
        

        if(empty($login)){
            $loginError = "Podaj swój login.";
            $noErrors = false;
        }
        
        if(empty($pass)){
            $passError = "Podaj swoje hasło.";
            $noErrors = false;

        }else{
            $CheckForUserQuery = "SELECT * FROM users WHERE user_login=?";
            $CheckForUserStmt = mysqli_stmt_init($connect);
            mysqli_stmt_prepare($CheckForUserStmt, $CheckForUserQuery);
            mysqli_stmt_bind_param($CheckForUserStmt, "s", $login);
            mysqli_stmt_execute($CheckForUserStmt);
            $CheckForUserResult = mysqli_stmt_get_result($CheckForUserStmt);

            if(mysqli_num_rows($CheckForUserResult)==0){
                $error = "Nieprawidłowy login lub hasło.";
                $noErrors = false;
            
            }else{
                foreach($CheckForUserResult as $userData){
                    $user_id = $userData['user_id'];
                    $pass_check = $userData['user_pass'];
                }

                if(!password_verify($pass, $pass_check)){
                    $error = "Nieprawidłowy login lub hasło.";
                    $noErrors = false;
                }
            }
        }

        
        if($noErrors){
            $_SESSION['logged_in'] = $user_id;
            header("Location: /home");
            die();
        }
    }

    include "header.php";
?>

<section class='login'>
    <h2>Logowanie: </h2>

    <form method='POST' class='loginForm'><!-- admin admin -->
        <input type='text' name='login' placeholder='Login..'><?php echo isset($loginError) ? "<br><span class='loginError'>".$loginError."</span><br>" : "<br>" ?>
        <input type='password' name='pass' placeholder='Hasło..'><?php echo isset($passError) ? "<br><span class='loginError'>".$passError."</span><br>" : "<br>" ?>
        <input type='submit' name='loginSubmit' value='Zaloguj'><?php echo isset($error) ? "<br><span class='loginError'>".$error."</span><br>" : "<br>" ?>
    </form>
</section>

<?php include "footer.php"; ?>