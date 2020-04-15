//get form information
function loginFormSubmit(form){
    console.log($(form).serializeArray());
    return false;
}