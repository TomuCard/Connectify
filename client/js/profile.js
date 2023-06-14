// Fonction pour le Switch Publications -> Amis et Amis -> Publication dans le Profil
var btn = document.getElementById("button1");

function leftClick() {
  btn.style.left = "0";
}

function rightClick() {
  btn.style.left = "110px";
}
//Fonction bouton agrandi
var leftButton = document.getElementById("left-button");
var rightButton = document.getElementById("right-button");
var Amis = document.getElementById("contentAmis");
var Publications = document.getElementById("contentPublication");

// Ajoutez des événements de clic aux boutons
leftButton.addEventListener("click", function () {
  // Ajoutez la classe "enlarge" au bouton de gauche
  leftButton.classList.add("enlarge");
  Amis.classList.add("AmisOff");
  Publications.classList.remove("publicationOff");
  // Supprimez la classe "enlarge" du bouton de droite
  rightButton.classList.remove("enlarge");
});

rightButton.addEventListener("click", function () {
  // Ajoutez la classe "enlarge" au bouton de droite
  rightButton.classList.add("enlarge");
  Publications.classList.add("publicationOff");
  Amis.classList.remove("AmisOff");
  // Supprimez la classe "enlarge" du bouton de gauche
  leftButton.classList.remove("enlarge");
});
