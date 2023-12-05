if(localStorage.getItem("userdata")==null){
    location.href = 'register.html';
} else{
    location.href = 'profile.html';
}