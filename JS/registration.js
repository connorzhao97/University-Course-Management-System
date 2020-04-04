//check student password
function stuCheckForm() {
    if ($("#stuPassword").val() != $("#stuRePassword").val()) {
        $("#stuRePassword").addClass('is-invalid');
        return false;
    } else {
        $("#stuRePassword").removeClass('is-invalid');
    }
}
//check staff password
function staCheckForm() {
    if ($("#staPassword").val() != $("#staRePassword").val()) {
        $("#staRePassword").addClass('is-invalid');
        return false;
    } else {
        $("#staRePassword").removeClass('is-invalid');
    }
}