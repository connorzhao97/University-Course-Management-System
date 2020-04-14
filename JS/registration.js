//student form submit
function stuFormSubmit(form) {
    if ($("#stuPassword").val() != $("#stuRePassword").val()) {
        $("#stuRePassword").addClass('is-invalid');
        return false;
    } else {
        $("#stuRePassword").removeClass('is-invalid');
    }
    if ($("#stuPhoneNumber").val().trim() != "" && /^(?:\+?61|0)4 ?(?:(?:[01] ?[0-9]|2 ?[0-57-9]|3 ?[1-9]|4 ?[7-9]|5 ?[018]) ?[0-9]|3 ?0 ?[0-5])(?: ?[0-9]){5}$/.test($("#stuPhoneNumber").val()) == false) {
        $("#stuPhoneNumber").addClass("is-invalid");
        return false;
    } else {
        $("#stuPhoneNumber").removeClass('is-invalid');
    }
    console.log($(form).serializeArray());
    // return false;
}
//staff form submit
function staFormSubmit(form) {
    if ($("#staPassword").val() != $("#staRePassword").val()) {
        $("#staRePassword").addClass('is-invalid');
        return false;
    } else {
        $("#staRePassword").removeClass('is-invalid');
    }
    console.log($(form).serializeArray());
    // return false;
}