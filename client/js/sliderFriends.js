menuBurger = document.getElementById("menuBurger");
retour = document.getElementById("sliderFriendsRetour")
sliderElement = document.getElementById("sliderElement");

menuBurger.addEventListener("click", function() {
    sliderElement.classList.toggle("friendsSliderOff");
});

retour.addEventListener("click", function() {
    sliderElement.classList.toggle("friendsSliderOff");
})
