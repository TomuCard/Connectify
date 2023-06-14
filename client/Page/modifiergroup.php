<?php
require_once '../TPL/header.php';
session_start();
?>
<main class="main">

<body>
    <div class="wrappersGroup">
        <h1 class="modifGroup textWhite">Veuillez modifier votre Group </h1>
        <form action="http://localhost:4000/profile/signup" method="POST" class="   ">

            <h1 class="modifierNameGroup textWhite">
                Modifier le Nom du Group :
            </h1>
            <input name="username" type="text" placeholder="Modifier votre Nom d'utilisateur">
            <h1 class="modifierDescriptionGroup textWhite">
                Modifier la Description :
            </h1>
            <textarea class="modifierespaceDesc" rows="4" cols="36"></textarea>

            <div class="containerModifGroup">
                <a class="modifButtonredGroup textWhite red" href="../Page/messagegroup.php">Annuler</a>
                <a class="modifButtongreenGroup textWhite green" href="../Page/messagegroup.php">Modifier</a>
            </div>
        </form>
    </div>
    <div class="supprime">
        <a class="supprimeButton textWhite red" href="">Supprimer le Group </a>
    </div>
</body>
</main>
</body>

</html>