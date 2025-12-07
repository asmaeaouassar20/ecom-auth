<?php
    session_start();  // ctive la session pour pouvoir lire les messages stockés avant (ex : erreurs).

    $errors = [ // tableau pour récupérer les erreurs stockées dans la session.
        'login' => $_SESSION['login_error'] ?? '',
        'register' => $_SESSION['resgister_error'] ?? ''
    ];


    /**
     * → Choisit quel formulaire afficher par défaut :
     *   Si une erreur existe pour l’inscription, on montre le formulaire “register”.
     *   Sinon, on affiche “login”.
     */
    $activeForm = $_SESSION['register_error'] ?? 'login';

    session_unset(); // → Vide toutes les variables de la session (efface les messages après les avoir affichés).
                    // C’est pour éviter que les erreurs se réaffichent à chaque rechargement.


    function showError($error){
        return !empty($error) ? "<p class='error-messsage'>$error</p>" : '';
    }

    function isActiveForm($formName, $activeForm){
        return $formName===$activeForm ? 'active' : '';
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full-Stack Login & Register Form With User & Admin Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="form-box <?= isActiveForm('login',$activeForm) ?>" id="login-form">
            <form action="login_register.php" method="post">
                <h2>Login</h2>
                <?= showError($errors['login']); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a  onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>


        <div class="form-box <?= isActiveForm('register', $activeForm); ?> " id="register-form">
            <form action="login_register.php" method="post">
                <h2>Register</h2>
                <?= showError($errors['register']); ?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">--Select Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a onclick="showForm('login-form')" >Login</a></p>
            </form>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>