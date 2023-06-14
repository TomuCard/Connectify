<?php
require_once '../TPL/header.php';
session_start();
?>

<main class="main">

    <body>
        <div class="wrapper">
            <h1 class="titreConnexion textWhite">Inscription</h1>
            <p class="textSignin textWhite">Utilisez les identifiants fournis par votre établissement</p>
            <form action="http://localhost:4000/profile/signup" method="POST" enctype="multipart/form-data">
                <input name="picture" type="file" placeholder="Enter picture" accept=".jpeg, .jpg, .png">
                <input name="firstname" type="text" placeholder="Enter First name">
                <input name="lastname" type="text" placeholder="Enter LastName">
                <input name="username" type="text" placeholder="Enter username">
                <input name="mail" type="text" placeholder="Enter mail">
                <input name="role_id" type="text" placeholder="Enter role">
                <!--
                <select name="role_id"> 
                    <option value="student">Etudiant</option>
                    <option value="teacher">Professeur</option>
                </select>
                -->
                <input name="promo_id" type="text" placeholder="Enter promo">
                <input name="password" type="password" placeholder="Password">
                <button class="SignUp" href="http://localhost:3000/Page/login.php">SignUp</button>
            </form>
        </div>
    </body>
</main>
</body>

</html>