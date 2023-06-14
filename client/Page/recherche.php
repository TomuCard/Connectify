<?php
require_once '../TPL/header.php';
session_start();

$searchBarre = $_POST['searchBarre'];
$query = $_POST['query'];

$searchQuery = "http://localhost:4000/user/profile/relation/search/" . $searchBarre . '/' . $query;
// Effectuer la requête GET
$json = file_get_contents($searchQuery);
$results = json_decode($json, true); 
?>
<main class="Search">
    <form class="recherche" action="http://localhost:3000/Page/recherche.php" method="POST">
        <input class="searchBarre" type="text" placeholder="Recherche" name="searchBarre">
        <div class="buttonSearch">
            <div class="radioSearch">
                <input type="radio" name="query" class="demo1" id="demo1-a" value="user" checked>
                <label for="demo1-a">Utilisateur</label>
                <input type="radio" name="query" class="demo1" id="demo1-b" value="group">
                <label for="demo1-b">Groupe</label>
            </div>
            <div class="radioSearch">
                <input type="radio" name="query" class="demo1" id="demo1-c" value="promo">
                <label for="demo1-c">Promo</label>
                <input type="radio" name="query" class="demo1" id="demo1-d" value="publication">
                <label for="demo1-d">Publication</label>
            </div>
            <button class="sendSearch">Recherche</button>
        </div>
    </form>


    <div class="searchUSers" id="contentUsers">
        <div class="contentUsers contentUsersOff">
            <button class="friendList">
                <div class="profileInvitation sliderFriendsContent">
                    <img src="../asset/IconProfile.svg" alt="Image de profile"  class="imageProfile">

                    <div class="nomPromo">
                        <h3 class="textWhite">Rubens Bonnin</h3>
                        <p class="textGray">Promo</p>
                    </div>
                </div>
            </button>
        </div>
    </div>

    <div class="searchPublication" id="contentPublications">

        <div class="contentPublications">

            <?php if($query == "user"): ?>
                <div style="display: flex;">
                    <?php foreach($results as $result): ?>
                        <a href="http://localhost:3000/Page/profile.php?id=<?= $result["id"]?>">
                            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <?php if($result["picture"]): ?>
                                    <img class="img1" src="<?= $result["picture"] ?>"></img>
                                <?php endif; ?>
                                <?php if(!$result["picture"]): ?>
                                    <img class="img1" src="../asset/IconProfile.svg" alt='image profile'></img>
                                    <p><?= $result["picture"] ?></p>
                                <?php endif; ?>
                                <span style="color: white;"><?= $result["firstname"] ?> <?= $result["lastname"] ?></span>
                            </div> 
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if($query == "group"): ?>
                <div style="display: flex;">
                    <?php foreach($results as $result): ?>
                        <a href="http://localhost:3000/Page/group.php?id=<?= $result["id"]?>">
                            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <?php if($result["picture"]): ?>
                                    <img class="img1" src="<?= $result["picture"] ?>"></img>
                                <?php endif; ?>
                                <?php if(!$result["picture"]): ?>
                                    <img class="img1" src="../asset/IconProfile.svg"></img>
                                <?php endif; ?>
                                <span style="color: white;"><?= $result["name"] ?></span>
                            </div> 
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if($query == "promo"): ?>
                <div style="display: flex;">
                    <?php foreach($results as $result): ?>
                        <a href="#">
                            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <?php if($result["picture"]): ?>
                                    <img class="img1" src="<?= $result["picture"] ?>"></img>
                                <?php endif; ?>
                                <?php if(!$result["picture"]): ?>
                                    <img class="img1" src="../asset/IconProfile.svg"></img>
                                <?php endif; ?>
                                <span style="color: white;"><?= $result["promo_name"] ?></span>
                            </div> 
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>