//student form submit
function stuFormSubmit() {
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
    $("#stuSubmitBtn").attr('disabled', 'true');
    $("#stuSpinner").removeClass('d-none');
    //Ajax
    $.post("../php/registration_engine.php", {
        student: true,
        name: $("#stuName").val().trim(),
        stuID: $("#stuID").val().trim(),
        email: $("#stuEmail").val().trim(),
        password: $("#stuPassword").val().trim(),
        address: $("#stuAddress").val().trim(),
        birth: $("#stuBirth").val().trim(),
        phone: $("#stuPhoneNumber").val().trim()
    }, function (data) {
        $("#stuSubmitBtn").removeAttr("disabled");
        $("#stuSpinner").addClass('d-none');
        if (data.exist) {
            alert("User exists");
        } else {
            if (data.insert) {
                alert("Register successfully");
                window.location.href = "../pages/login.php";
            }
        }
    }, 'json');
    return false;
}
//staff form submit
function staFormSubmit() {
    if ($("#staPassword").val() != $("#staRePassword").val()) {
        $("#staRePassword").addClass('is-invalid');
        return false;
    } else {
        $("#staRePassword").removeClass('is-invalid');
    }
    $("#staSubmitBtn").attr('disabled', 'true');
    $("#staSpinner").removeClass('d-none');
    $.post('../php/registration_engine.php', {
        staff: true,
        name: $("#staName").val().trim(),
        staID: $("#staID").val().trim(),
        email: $("#staEmail").val().trim(),
        password: $("#staPassword").val().trim(),
        qualification: $("#staQualification").val().trim(),
        expertise: $("#staExpertise").val().trim(),
        phone: $("#staPhoneNumber").val().trim()
    }, function (data) {
        if (data.exist) {
            $("#staSubmitBtn").removeAttr("disabled");
            $("#staSpinner").addClass('d-none');
            alert("User exists");
        } else {
            if (data.insert) {
                alert("Register successfully");
                window.location.href = "../pages/login.php";
            }
        }
    }, 'json');
    return false;
}