<?php
require_once '../TPL/header.php';
session_start();

// Utilisation de la superglobale $_GET
if (isset($_GET['id'])) {
    $valeur = $_GET['id'];
    $promoControllerURL = "http://localhost:4000/pageController/" .$valeur;

    // Effectuer la requête GET
    $jsonPromo = file_get_contents($promoControllerUrl);
    $dataPromo = json_decode($jsonPromo, true);
    echo($dataPromo);
}
?>

<main class="main" overflow="hidden">

    <img class="banniereProfil" src="<?= $gcef ?>">
    </img>

    <div class="profileInvitation">
        <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">
        <div class="nomPromo">
            <h3 class="textWhite"><?= $dataPromo ?></h3>
            <p class="textGray">Promo</p>
        </div>
        <!-- <btn class="modifierProfil textWhite"> Modifier le Profil -->
        <a class="boutonModifier textWhite" href="../page/modifierprofile.php">Modifier le Profil</a>
        <!-- </btn> -->
    </div>
    <br>
    <div class="Description">
        <h4 class="textWhite">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. </h4>
        <br>

        <p class="textGray"> 42 abonnés 666 abonnements
        <form action="http://localhost:4000/group/join/users_id" method="POST">
        </form>
        </p>
    </div>

    <div class="contentBtn">
        <button id="left-button" class="enlarge textWhite">Publications</button>
        <button id="right-button" class="textWhite">Liste d'Amis</button>
    </div>

    <div class="Publication" id="contentPublication">
        <div class="contentPublication">
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
            <img class="img1" src=""></img>
        </div>
    </div>

    <div class="Amis AmisOff" id="contentAmis">
        <div class="contentprofileFriend">

            <button class=" friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin </h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
        </div>
    </div>

</main>
<script src="../js/profile.js"></script>
</body>

</html>