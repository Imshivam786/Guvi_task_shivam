function display_image(file){
    var img = document.querySelector(".js-image");
    img.src = URL.createObjectURL(file);
}
if(localStorage.getItem("userdata") == null){
    location.href = 'register.html';
}

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            var dynamicData = JSON.parse(xhr.responseText);
            document.querySelector(".email").innerHTML = dynamicData.email;
            document.querySelector(".firstname").innerHTML = dynamicData.firstname;
            document.querySelector(".lastname").innerHTML = dynamicData.lastname;
            document.querySelector(".gender").innerHTML = dynamicData.gender;
        } else {
            console.error('Error fetching data:', xhr.status);
        }
    }
};

xhr.open('GET', './php/profile.php', true);
xhr.send();
