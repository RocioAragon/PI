$(function() {
    $("#userForm").validate({
        // Specify validation error messages
        messages: {
            user: "Por favor, introduzca su usuario.",
            pass: "Por favor, introduzca su contraseña."
        },
        submitHandler: function(form) {
            //form.submit();
        }
    });
});