const myaction = {
    collect_data: function (e, data_type) {
      e.preventDefault();
      e.stopPropagation();
      var inputs = document.querySelectorAll("form input, form select");
      console.log(inputs);
      let myform = new FormData();
      myform.append('data_type',data_type);
      for (var i = 0; i < inputs.length; i++) {
        myform.append(inputs[i].name, inputs[i].value);
      }
      myaction.send_data(myform);
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
  
      ajax.open("post", "./php/login.php", true);
      ajax.send(form);
    },
    handle_result : function (result){
      var obj = JSON.parse(result);
      if(obj.success){
        alert("login successfully");
        // maintaining login session with browser local storage
        var inputs = document.querySelectorAll("form input, form select");
        var data = [{'email':inputs[0].value},{'password':inputs[1].value}];
        localStorage.setItem("userdata",JSON.stringify(inputs));
        localStorage.setItem("email",inputs[0].value);
        window.location.href = 'profile.html';
  
      }else{
          // errors
          document.querySelector(".js-error-email").innerHTML = obj.errors['email'];
      }
    }
  };
  