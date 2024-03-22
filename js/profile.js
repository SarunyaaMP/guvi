
$(document).ready(function() {

    // using ajax to fill the profile of the user with the registered data
    $.ajax({
        url: '../php/profile.php',
        type : 'GET',
        data : {
            email : localStorage.getItem('current_email')
        },
        success : function(response){
            document.querySelector('#my-form input[name="email"]').value = response.email;
            document.querySelector('#my-form input[name="username"]').value = response.name;
            document.querySelector('#my-form input[name="dob"]').value = response.dob;
            document.querySelector('#my-form input[name="age"]').value = response.age;
            document.querySelector('#my-form input[name="contact"]').value = response.contact;
        },
        error : function(xhr, status, error){
            console.log('Error: '+ error);
        }
    });
});

// used when the user wants to update the data
function updateData(event){

    // prevent default form submission behavior
    event.preventDefault();

    // getting updated data
    const name = $('#new_name').val();
    const dob = $('#new_dob').val();
    const age = $('#new_age').val();
    const contact = $('#new_contact').val();

    // using ajax to update the data
    $.ajax({
        url: '../php/profile.php',
        type: 'PUT',
        data: {
            name : name,
            dob : dob,
            age : age,
            contact : contact,
            email : localStorage.getItem('current_email')
        },
        success: function(response) {
            if (response == 'success') {
                alert('Profile updated successfully!');
                document.querySelector('#my-form input[name="email"]').value = email;
                document.querySelector('#my-form input[name="name"]').value = name;
                document.querySelector('#my-form input[name="dob"]').value = dob;
                document.querySelector('#my-form input[name="age"]').value = age;
                document.querySelector('#my-form input[name="contact"]').value = contact;
            } else {
                alert('Error updating profile!');
            }
        }
    });
}