<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link rel="stylesheet" href="./src/Views/Navigation/navigation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <img  src="./src/public/image/modele-logo.png" alt="logo">
        </div>
        <nav>
            <input type="checkbox" id="check">
            <label for="check" class="checkbtn">
                <i class="fa fa-bars"></i>  
            </label>
            <ul>
               
               

            <?php
                if (isset($_SESSION['user_id'])) {

                    echo '<li><a href="index.php?page=profil">Profil</a></li>';
                    echo '<li><a href="index.php?page=Deconnexion">Déconnexion</a></li>';
                    
                } else {
                    echo'<li><a href="index.php?page=accueil">Acceuil</a></li>';
                    echo'<li><a href="index.php?page=nos_jeux">Nos Jeux</a></li>';
                    echo '<li><a href="index.php?page=login">Connexion</a></li>';
                    echo '<li><a href="index.php?page=register">Inscription</a> </li>';
                    
                }
            ?>
            </ul>
        </nav>
    </header>
