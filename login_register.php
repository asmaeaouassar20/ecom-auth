<?php
session_start();    // Démarre une session pour stocker des variables accessibles entre plusieurs pages (ex : messages, login).
require_once 'config.php';  // Importe un fichier une seule fois (souvent la connexion BDD) pour éviter les doublons et erreurs.

if(isset($_POST['register'])){  // Vérifie si une variable existe et n’est pas null (ex : si un bouton a été cliqué).
    $name = $_POST['name'];
    $email = $POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // PASSWORD_DEFAULT
                                                                            // → Utilise l’algorithme de hachage recommandé par PHP pour sécuriser les mots de passe.
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT email FROM users WHERE email='$email'");

    if($checkEmail->num_rows>0){
        $_SESSION['register_error'] = 'Email is already registred !';
        $_SESSION['active_form'] = 'register';
    }else{
        $conn->query("INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$password','$role')");
    }

    header("Location : index.php");     // Redirige l’utilisateur vers une autre page (ici : index.php).
    exit();  // Arrête immédiatement l’exécution du script (important après une redirection).
}


if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($result->num_rows>0){
        $user=$result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if($user['role']==='admin'){
                header("Location: admin_page.php");
            }else{
                header("Location: user_page.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form']='login';
    header("Location: index.php");
    exit();
}

?>