// Fonction qui permet d'aficher un formulaire
function showForm(formeId){
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formeId).classList.add("active");
}