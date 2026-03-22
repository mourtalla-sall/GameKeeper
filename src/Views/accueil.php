<?php
require_once './src/Views/Navigation/Header.php';
require_once 'db.php';




$database = Database::getInstance();
$pdo = $database->getConnexion();

$sql = "SELECT * 
    FROM categorie ";
$data = $pdo->prepare($sql);

$data->execute();
$resultats = $data->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="index.css">
<main>
    <section class="content">
        <div class="content-text">
            <H1>Bienvenue au GameKeeper</H1>
            <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.</p>
            <a href="index.php?page=nos_jeux">
                <button class="content-btn">Savoir Plus</button>
            </a>
        </div>
        <div class="content-img">
            <img src="./src/public/image/ps-plus-devoile-sa-selection-de-jeux-gratuits-pour-janvier-2026-avec-un-classique-reinvente-750x410.webp" alt="">
        </div>
    </section>
    <h1 class="title">Nos Categorie de jeux</h1>
    
    <section>
        <div class="categorie">
            <?php
                foreach ($resultats as $key => $value) {
                    $name = $value['name'];
                    $description = $value['description'];
                    echo "<div class='categorie-content'>";
                    echo "<img src='' alt='img'>";
                    echo "<h1>Jeux $name</h1>";
                    echo "<p> $description </p>";
                    echo "<a href='categorie_detail.php?id={$value['id']}' class='btn-voir'>Voir tout</a>";

                echo "</div>";
                   


                }
            ?>

            
        </div>
    </section>
</main>
  

<?php
require_once './src/Views/Navigation/Footer.php'
?>