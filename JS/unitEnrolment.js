
/**
 * @description: get unit enrollment information
 * @param form get form information 
 * @return: false
 */
function enrolUnit(form) {
    var formdata = $(form).serializeArray();
    $.post('../php/unit_enrolment_engine.php', {
        enrol: true,
        unitID: $(form).parents('div .card').attr('id'),
        unitListID: formdata[0].value,
    }, function (data) {
        if (data.insert) {
            alert('Enrol ' + formdata[0].name + ' successfully');
            window.location.href = "../pages/unitEnrolment.php?state=1";
        }
    }, 'json');
    return false;
}
/**
 * @description: withdraw unit
 * @param form get form information 
 * @return: false
 */
function withdrawUnit(form) {
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