const logoutButton = document.getElementById('logout-button');

logoutButton.addEventListener("click",function(){
    event.preventDefault();
    this.closest('form').submit();
});