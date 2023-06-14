<?php
require_once '../TPL/header.php';
session_start();
$id = $_GET['id'];
?>

        <main class="main">
                <a class="iconRetour" href="../page/publications.php"> <img src="../asset/iconRetour.svg" alt="iconRetour"> <button class="buttonRetour">Retour</button></a>
        <form action="http://localhost:4000/publication/add/<?=$id?>" method="POST">
                                <button class="buttonPublier1">PUBLIER</button>
                <div class="profileCreatPost">
                        <img src="<?=$user['picture']?>" alt="Image de profile creat post" class="imageProfileCreatPost">
                        
                        <div class="nomPromoCreatPost">
                                <h3 class="textWhite"><?=$user['firstname']?> <?=$user['lastname']?></h3>
                                <p class="textGray"><?=$user['promo_name'] ?></p>
                        </div>
                </div>
                <div class="ajouterUnTitre">    
                        <input name="title" class="textWhite inputPost" type="text" placeholder="Ajouter titre">
                </div>
                <textarea name="content" class="textWhite inputDescritpion" type="text" placeholder="Ajouter une description"></textarea>
                
                <input name="picture" class="buttonPhotos" type="file" placeholder="Enter picture" accept=".jpeg, .jpg, .png">
                
                <button class="buttonPublier2">PUBLIER</button>
        </form>
        </main>
</body>
</html>