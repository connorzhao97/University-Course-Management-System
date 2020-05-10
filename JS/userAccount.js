function stuFormSubmit() {
    if ($("#stuPassword").val().trim() != "") {
        if ($("#stuRePassword").val().trim() != $("#stuPassword").val().trim()) {
            alert("Password does not match");
            return false;
        }
    }
    $("#submitBtn").attr('disabled', 'true');
    $("#stSpinner").removeClass('d-none');

    $.post('../php/user_account_engine.php', {
        student: true,
        name: $("#stuName").val().trim(),
        stuID: $("#stuID").val().trim(),
        email: $("#stuEmail").val().trim(),
        password: $("#stuPassword").val().trim(),
        address: $("#stuAddress").val().trim(),
        birth: $("#stuBirth").val().trim(),
        phone: $("#stuPhoneNumber").val().trim()
    }, function (data) {
        $("#submitBtn").removeAttr('disabled');
        $("#stSpinner").addClass('d-none');
        if (data.update) {
            alert("Save changes successfully");
        } else {
            alert("Save changes failed");
        }
    }, 'json');
    return false;
}



function staFormSubmit() {
    if ($("#staPassword").val().trim() != "") {
        if ($("#staRePassword").val().trim() != $("#staPassword").val().trim()) {
            alert("Password does not match");
            return false;
        }
    }
    $("#submitBtn").attr('disabled', 'true');
    $("#stSpinner").removeClass('d-none');


    $.post('../php/user_account_engine.php', {
        staff: true,
        name: $("#staName").val().trim(),
        staID: $("#staID").val().trim(),
        email: $("#staEmail").val().trim(),
        password: $("#staPassword").val().trim(),
        qualification: $("#staQualification").val().trim(),
        expertise: $("#staExpertise").val().trim(),
        phone: $("#staPhoneNumber").val().trim(),
        unavailability: $("#staUnavailability").val().trim()
    }, function (data) {
        $("#submitBtn").removeAttr('disabled');
        $("#stSpinner").addClass('d-none');
        if (data.update) {
            alert("Save changes successfully");
        } else {
            alert("Save changes failed");
        }
    }, 'json');
    return false;
}