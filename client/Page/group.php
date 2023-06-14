<?php
require_once '../TPL/header.php';
session_start();

$valeur = $_GET['id'];
$oneGroupInfo = "http://localhost:4000/group/info/" . $valeur;

// Effectuer la requête GET
$json = file_get_contents($oneGroupInfo);
$group = json_decode($json, true);
?>

<main class="main">

        <div class="headerPublication">
                <h2 class="textWhite"><?=$group['name']?></h2>

                <div class="iconPublication">
                        <a href="/Page/modifiergroup.php"><img src="../asset/iconSetting.svg" alt="Paramettre"></a>
                        <a href="/Page/createpost.php?id=<?=$valeur?>"><img src="../asset/icon+.svg" alt="Publier un nouveau post"></a>
                        <a href="/Page/messagegroup.php"><img src="../asset/iconMessage2.svg" alt="Meesage du groupe"></a>
                </div>
        </div>

        <!-- <div class="demandeInvitation">

                <div class="profileButtonInvitation">
                        <button class="iconsButton" id="buttonInvitationGauche"><imgsrc="../asset/iconRetour.svg"></button>

                        <div class="test15">
                                <div class="profileInvitation">
                                        <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                                        <div class="nomPromo">
                                                <h3 class="textWhite">Tom Cardonnel</h3>
                                                <p class="textGray">Promo</p>
                                        </div>
                                </div>
                                <div class="containerInvitationButton">
                                        <button class="invitationButton textWhite red">Refuser</button>
                                        <button class="invitationButton textWhite green">Accepter</button>
                                </div>
                        </div>


                        <button class="iconsButton" id="buttonInvitationDroit"><img
                                        src="../asset/iconRetour.svg"></button>
                </div>
        </div> -->
        <?php include "containerpublication.php" ?>

</main>
</body>

</html>