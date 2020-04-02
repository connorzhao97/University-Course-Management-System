//chech validation
function validate() {
    if (/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test($("#email").val()) == false) {
        alert("Please enter a valid email address.")
        return false;
    } else if (/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}/.test($("#password").val()) == false) {
        alert("Please check your password.");
        return false;
    }
}