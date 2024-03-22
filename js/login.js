// Data from login form is acquired and checked to authenticate the user using ajax to interact with the database

$(document).ready(function () {
  $("#login_form").submit(function (event) {
    // prevent default form submission behavior
    event.preventDefault();

    // getting form data
    var formData = {
      'email': $('input[name=email]').val(),
      'password': $('input[name=password]').val(),
    };

    // getting email for the logged in user to store the data in localStorage
    var email = $('input[name=email]').val();

    // using ajax to authenticate the user
    $.ajax({
      type: 'post',
      url: '../php/login.php',
      data: formData,
      dataType: 'json',
      encode: true,
      success: function (response) {
        if (response === 'success') {
          localStorage.setItem('current_email', email);
          window.location.href = "../profile.html;"
        }
        else {
          alert("Invalid login credentials");
        }
      }
    })
  });
});


