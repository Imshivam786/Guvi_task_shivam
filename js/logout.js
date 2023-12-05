if(localStorage.getItem("userdata") != null){
    localStorage.removeItem("userdata");
    location.href = 'register.html';
    alert("you have successfully logged out")
} 