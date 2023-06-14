<?php
require_once '../TPL/header.php';
session_start();
?>

	<main class="main">

		<div class="onePublication">
			<?php include "containerpublication.php" ?>
			</div>


				<h2 class="Commentaire textWhite">Commentaire</h2>

				<div class="hube">
				<div class="contentCommentaire">
				<div class="oneComment">
				<div class="containerProfile">
				<img class="imageProfile" src="">
				<div		class="profile">
				<h3 class="textWhite">Tom</h3>
				<p class="textGray">Promo</p>
				<p class="textGray">Maintenant</p>
				</div>
				</div>
				<h3 class="leCommentaire textWhite">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
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
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
				</h3>
				</div>

			</div>
		</div>

	</main>

</body>
</html>