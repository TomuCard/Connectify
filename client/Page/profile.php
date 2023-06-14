<?php
ini_set('display_errors', 1);
require_once '../TPL/header.php';
session_start();

$id = $_SESSION['id'];

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $userInfo = "http://localhost:4000/user/" . $id;
    $json = file_get_contents($userInfo);
    $user = json_decode($json, true);

}else{
    
    $userInfo = "http://localhost:4000/user/" . $id;
    $json = file_get_contents($userInfo);
    $user = json_decode($json, true);

    $searchRelation = "http://localhost:4000/relation/search/" . $id;
    $jsonSearchRelation = file_get_contents($searchRelation);
    $searchRelations = json_decode($jsonSearchRelation, true);
}

?>

<main class="main" overflow="hidden">

    <img class="banniereProfil" src="<?= $user['banner'] ?>"/>
    
    
    <div class="profileInvitation">
        <img src="<?=$user['picture']?>" alt="Image de profile" class="imageProfile">
        <div class="nomPromo">
            <h3 class="textWhite"><?=$user['firstname']?> <?=$user['lastname']?></h3>
            <p class="textGray"><?=$user['promo_name'] ?></p>
            <a class="textWhite" href="../Page/creategroup.php">Créer un groupe</a>
        </div>
        <!-- <btn class="modifierProfil textWhite"> Modifier le Profil -->
            <?php if(!isset($_GET['id'])): ?>
                <a class="boutonModifier textWhite" href="../Page/modifierprofile.php">Modifier le Profil</a>
                <?php endif; ?>
                <!-- </btn> -->
            </div>
            <br>
            <div class="Description">
                <p class="textWhite"><?=$user['description'] ?></p>
            </div>
            
            <div class="contentBtn">
                <?php if(isset($_GET['id'])): ?>
                    <a class="enlarge textWhite" href="http://localhost:4000/relation/add/<?= $_GET['id']?>" >Ajouter en ami.</a>
                    <?php endif; ?>
                    <button id="left-button" class="enlarge textWhite">Publications</button>
                    <?php if(!isset($_GET['id'])): ?>
                        <button id="right-button" class="textWhite">Liste d'Amis</button>
                        <form action="http://localhost:4000/profile/logout" method="POST">
                        <button id="right-button" class="textWhite">déconnection</button>
                </form>
            <?php endif; ?>
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
                        <?php foreach($searchRelations as $searchR): ?>
                            <img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">
                            <div class="nomPromo">
                                <h3 class="textWhite"><?=$searchR['firstname']?> <?=$searchR['lastname']?></h3>
                            </div>
                        <?php endforeach; ?>
                    </div>
            </button>
        </div>
    </div>
</main>
<script src="../js/profile.js"></script>
</body>

</html>