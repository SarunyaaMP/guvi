// Data from register form is acquired and inserted into database using ajax
$(document).ready( function() { 
    $("register_form").submit( function(event){

        // prevent default form submission behavior
        event.preventDefault();

        //getting form data
        var formData = {
            'username' : $('input[name=username]').val(),
            'email' : $('input[name=email]').val(),
            'password' : $('input[name=password]').val(),
            'dob' : $('input[name=dob]').val(),
            'age' : $('input[name=age]').val(),
            'contact' : $('input[name=contact]').val()
        };

        // using ajax to insert the register data into database
        $.ajax({
            type: 'POST',
            url: '../php/register.php',
            data: formData,
            dataType: 'json',
            success: function(data){
                window.location.href = "../login.html";
                alert(data);
            },
            error: function(xhr, status, error){
                console.error(xhr);
            }
        });
    });
});