//get form information
function loginFormSubmit() {
    $.post('../php/login_engine.php', {
        stID: $("#stID").val().trim(),
        password: $("#password").val().trim()
    }, function (data) {
        if (data.exist) {
            if(data.login){
               window.location.href="../pages/home.php";
            }else{
                alert("ID or Password incorrect.");
            }
        } else {
            alert("User does not exist.");
        }
    }, 'json');
    return false;
}