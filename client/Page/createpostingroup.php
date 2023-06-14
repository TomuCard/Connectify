<?php
require_once '../TPL/header.php';
session_start();
?>

        <main class="main">
                <a class="iconRetour" href="../Page/publications.php"> <img src="../asset/iconRetour.svg" alt="iconRetour"> <button class="buttonRetour">Retour</button></a>
        <form>
                <button class="buttonPublier1">PUBLIER</button>
                <div class="profileCreatPost">
                        <img src="../asset/IconProfile.svg" alt="Image de profile creat post" class="imageProfileCreatPost">

                        <div class="nomPromoCreatPost">
                                <h3 class="textWhite">Tom Cardonnel</h3>
                                <p class="textGray">Promo</p>
                        </div>
                </div>
                <div class="ajouterUnTitre">    
                        <input class="textWhite inputPost" type="text" placeholder="Ajouter titre">
                </div>
                <textarea class="textWhite inputDescritpion" type="text" placeholder="Ajouter une description"></textarea>
                
                <input class="buttonPhotos" type="file" placeholder="Enter picture" accept=".jpeg, .jpg, .png">
                
                <button class="buttonPublier2">PUBLIER</button>
        </form>
        </main>
</body>
</html>