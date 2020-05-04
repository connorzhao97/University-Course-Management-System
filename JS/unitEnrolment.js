//get unit enrollment information
function enrolUnit(form, stID) {
    var formdata = $(form).serializeArray();
    // console.log($(form).parents('div .card').attr('id'));
    // console.log(formdata);
    //data-
    $.post('../php/unit_enrolment_engine.php', {
        enrol: true,
        stID: stID,
        unitID: $(form).parents('div .card').attr('id'),
        unitListID: formdata[0].value,
    }, function (data) {
        if (data.insert) {
            alert('Enrol ' + formdata[0].name + ' successfully');
            // $(form).find("select").replaceWith("Enrolled");
            // $(form).find("button").remove();
            window.location.href = "../pages/unitEnrolment.php?state=1";
        }
    }, 'json');
    return false;
}

function withdrawUnit(form) {
    console.log($(form).parents('div .card').attr('id'));

    $.post('../php/unit_enrolment_engine.php', {
        withdraw: true,
        unitEnrolID: $(form).parents('div .card').attr('id')
    }, function (data) {
        if (data.withdraw) {
            alert("Withdraw " + $(form).find('h5').html() + " successfully");
            window.location.href = "../pages/unitEnrolment.php?state=0";
        }
    }, 'json');
    return false;

}




//get parameter from url
function getQuery(e) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0] == e) {
            return pair[1];
        }
    }
    return false;
}

$(function () {
    if (getQuery("state") == "0") {
        $('#pills-first-tab').tab('show');
    } else if (getQuery("state") == "1") {
        $('#pills-second-tab').tab('show');
    }
})