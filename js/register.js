const myaction = {
  collect_data: function (e, data_type) {
    e.preventDefault();
    e.stopPropagation();
    var inputs = document.querySelectorAll("form input, form select");
    // console.log(inputs);
    let myform = new FormData();
    myform.append('data_type',data_type);
    for (var i = 0; i < inputs.length; i++) {
      myform.append(inputs[i].name, inputs[i].value);
    }
    myaction.send_data(myform);
    console.log(myform);
  },

  send_data: function (form) {
    var ajax = new XMLHttpRequest();

    document.querySelector(".progress").classList.remove("d-none");

    ajax.addEventListener("readystatechange", function () {
      if (ajax.readyState == 4) {
        if (ajax.status == 200) {
          myaction.handle_result(ajax.responseText);
        } else {
          console.log(ajax);
          alert("An error occurred");
        }
      }
    });

    ajax.upload.addEventListener("progress", function (e) {
      let percent = Math.round((e.loaded / e.total) * 100);
      document.querySelector(".progress-bar").style.width = percent + "%";
      document.querySelector(".progress-bar").innerHTML =
        "Working..." + percent + "%";
    });

    ajax.open("post", "./php/register.php", true);
    ajax.send(form);
  },
  handle_result : function (result){
    // console.log(result);
    var obj = JSON.parse(result);
    if(obj.success){
        alert("Profile created successfully");
        window.location.href = 'login.html';

    }else{
        // errors
        let error_inputs= document.querySelectorAll(".js-error");
        
        for (var i = 0; i < error_inputs.length; i++) {
            error_inputs[i].innerHTML = "";
        }

        for(key in obj.errors){
            document.querySelector(".js-error-"+key).innerHTML = obj.errors[key];
        }

    }
  }
};
