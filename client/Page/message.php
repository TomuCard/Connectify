<?php
ini_set('display_errors', 1);
require_once '../TPL/header.php';
session_start();

$id = $_SESSION['id'];

$allGroupForUser = "http://localhost:4000/group/user/get/" . $id;
// Effectuer la requête GET
$json = file_get_contents($allGroupForUser);
$groups = json_decode($json, true);

?>

<main class="main">
	<div class="iconAndUser">
		<button id="menuBurger" class="iconsButton"><img src="../asset/iconBurger.svg" alt="menu burger"></button>
		<div class="friendMessage">
			<h2 class="textWhite">Tom Cardonnel</h2>
			<p class="textGray">Promo</p>
		</div>
	</div>

	<div class="containerMessage">
		<div class="slider">
			<div class="unMessage">
				<form action="" method="POST">
					<img src="<?php $transmitter_image ?>" alt="Image de profile" class="imageProfile">
						<div class="userMessage">
							<h3 name="firstname" name="lastname" class="textWhite"></h3>
							<p name="message_content" class="textWhite"><?php $message_content ?></p>	
						</div>
				</form>
			</div>



		</div>
	</div>
	<div class="friendsSlider friendsSliderOff" id="sliderElement">
		<div class="icons">
			<button class="iconRetour retourSlider textWhite" id="sliderFriendsRetour"> <img src="../asset/iconRetour.svg"
			alt="iconRetour">Retour</button>
		</div>
		

		<div class="allFriends">

			<?php foreach($groups as $group): ?>
				<a href='./group.php?id=<?=$group["id"]?>' class="friendList">
					<div class="profileInvitation sliderFriendsContent">
						<img src="../asset/IconProfile.svg" alt="Image de profile" class="imageProfile">
						<div class="nomPromo">
							<h3 class="textWhite"><?=$group["name"]?></h3>
							<p class="textGray"><?=$group["status"]?></p>
						</div>
					</div>
				</a>
			<?php endforeach; ?>

		</div>
	</div>

	<form action="" method="POST" id="messageForm">
    	<input name="message_content" class="sendMessage" type="text" placeholder="Envoyer un message">
	</form>
</main>
<script src="../js/sliderFriends.js"></script>
</body>

</html>