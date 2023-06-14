<?php
require_once '../TPL/header.php';
session_start();

if (isset($_GET['id'])) {
	$valeur = $_GET['id'];
	$commentURL = "http://localhost:4000/comment/add/6" . $valeur;

	// Effectuer la requête GET
	$jsonPages = file_get_contents($pagesURL);
	$dataPages = json_decode($jsonPages, true);

	// Utiliser les données récupérées
	// Par exemple, afficher le contenu de la réponse JSON
	echo $dataPages['content'];
}
?>

<main class="main">

	<div class="onePublication">
		<?php include "containerpublication.php" ?>
	</div>

	<h2 class="Commentaire textWhite">Espace Commentaire</h2>

	<div class="ajoutCommentaire">
		<form action="">
			<h4 class="ajoutComment textWhite">
				Ajouter un Commentaire :
			</h4>
			<textarea class="modifierespaceDesc" rows="4" cols="36"></textarea>
			<button class="buttonPublier3">PUBLIER</button>
		</form>
	</div>
	<div class="hube">
		<div class="contentCommentaire">
			<div class="oneComment">
				<div class="containerProfile">
					<img class="imageProfile" src="">
					<div class="profile">
						<h3 class="textWhite">Tom</h3>
						<p class="textGray">Promo</p>
						<p class="textGray">Maintenant</p>
					</div>
				</div>
				<h3 class="leCommentaire textWhite">
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
					the
					industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
					type
					and scrambled it to make a type specimen book. It has survived not only five centuries
				</h3>
			</div>

			<div class="oneComment">
				<div class="containerProfile">
					<img class="imageProfile" src="">
					<div class="profile">
						<h3 class="textWhite">Tom</h3>
						<p class="textGray">Promo</p>
						<p class="textGray">Maintenant</p>
					</div>
				</div>
				<h3 class="leCommentaire textWhite">
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
					the
					industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
					type
					and scrambled it to make a type specimen book. It has survived not only five centuries
				</h3>
			</div>

		</div>
	</div>

</main>

</body>

</html>