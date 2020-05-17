//clear creat staff form
$('#createNewStaff').on('hidden.bs.modal', function (e) {
    $("#fCNSta")[0].reset();
})

//clear manage staff form
$('#manageStaff').on('hidden.bs.modal', function (e) {
    $('#fMSta')[0].reset();
})

//clear creat unit form
$('#createNewUnit').on('hidden.bs.modal', function (e) {
    $("#fCNUnit")[0].reset();
})

//clear manage unit form
$("#manageUnit").on('hidden.bs.modal', function (e) {
    $('#fMUnit')[0].reset();
})

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




/*
NOTE STAFF
*/

//edit staff information
function editStaff(e) {
    $(e).parents('tr').find('td').each(function () {
        console.log($(this).text().trim());
    })
    // console.log($(e).parents('tr').find('td'));
}


//remove staff from database and tables
function removeStaff(e) {
    $(e).parents('tr').remove();
}

//create new staff
function createNewStaffForm(form) {
    if ($("#staNewPassword").val().trim() != $("#staRePassword").val().trim()) {
        alert("Password does not match");
        return false;
    }
    sta = new Object();
    sta.ID = "";
    sta.name = "";
    sta.password = "";
    sta.qualification = "";
    sta.expertise = "";
    sta.role = "";
    var formdata = $(form).serializeArray();
    console.log(formdata);
    for (let index = 0; index < formdata.length; index++) {
        const element = formdata[index];
        switch (element.name) {
            case "staNewID":
                sta.ID = element.value.trim();
                break;
            case "staNewName":
                sta.name = element.value.trim();
                break;
            case "staNewPassword":
                sta.password = element.value.trim();
                break;
            case "staNewQua":
                sta.qualification = element.value.trim();
                break;
            case "staNewExp":
                sta.expertise = element.value.trim();
                break;
            case "staNewRole":
                sta.role = element.value.trim();
                break;
            default:
                break;
        }
    }
    console.log(sta);
    $.post('../php/master_list_staff_engine.php', {
        insertStaff: true,
        staffID: sta.ID,
        staffName: sta.name,
        staffPassword: sta.password,
        staffQualification: sta.qualification,
        staffExpertise: sta.expertise,
        staffRole: sta.role
    }, function (data) {
        if (data.exist) {
            alert("Staff Exists.");
        } else {
            if (data.insert) {
                alert("Create New Staff Successfully.");
                window.location.href = "../pages/masterList.php?state=0";
            }
        }
    }, 'json');

    // $("#createNewStaff").modal('hide');
    return false;
}

//edit staff table
$(function () {
    $("#staManagementTable").Tabledit({
        url: "../php/master_list_staff_engine.php",
        toolbarClass: 'd-inline',
        buttons: {
            edit: {
                class: 'btn btn-sm btn-light',
                html: '<span class="fas fa-pencil-alt"></span>',
                action: 'edit'
            },
            delete: {
                class: 'btn btn-sm btn-light',
                html: '<span class="fas fa-trash-alt"></span>',
                action: 'delete'
            }
        },
        columns: {
            identifier: [0, 'staffID'],
            editable: [
                [1, "name"],
                [2, "qualification", '{"Bachelor":"Bachelor", "Master":"Master", "PhD":"PhD"}'],
                [3, "expertise"],
                [5, "role", '{"1":"Staff", "2":"Tutor", "3":"Lecturer", "4":"Unit Coordinator", "5":"Degree Coordinator"}']
            ]
        },
        restoreButton: false,
        autoFocus: true,
        onSuccess: function (data, textStatus, jqXHR) {
            console.log(data);
            if (data.action === 'edit') {
                if (data.update) {
                    alert("Update Staff Successfully");
                }
            } else if (data.action === 'delete') {
                alert("Remove Staff Successfully");
                $('#' + data.id).remove();
            }
        }
    });
})

/*
NOTE UNIT
*/

//create new unit
function createNewUnitForm(form) {
    if ($("#semesterCheckboxGroup").find("input.custom-control-input:checked").length <= 0) {
        alert("Please select at least one semester.");
        return false;
    } else if ($("#campusCheckboxGroup").find("input.custom-control-input:checked").length <= 0) {
        alert("Please select at least one campus.");
        return false;
    } else {
        var formdata = $(form).serializeArray();
        console.log(formdata);
        unit = new Object();
        unit.code = "";
        unit.name = "";
        unit.semesters = "";
        unit.campuses = "";
        unit.unitCoordinatorID = "";
        unit.description = "";
        for (let index = 0; index < formdata.length; index++) {
            const element = formdata[index];
            switch (element.name) {
                case "unitCode":
                    unit.code = element.value.trim();
                    break;
                case "unitName":
                    unit.name = element.value.trim();
                    break;
                case "unitSem1":
                    unit.semesters += "Semester 1,";
                    break;
                case "unitSem2":
                    unit.semesters += "Semester 2,";
                    break;
                case "unitWinter":
                    unit.semesters += "Winter School,";
                    break;
                case "unitSpring":
                    unit.semesters += "Spring School,";
                    break;
                case "unitPandora":
                    unit.campuses += "Pandora,";
                    break;
                case "unitRivendell":
                    unit.campuses += "Rivendell,";
                    break;
                case "unitNeverland":
                    unit.campuses += "Neverland,";
                    break;
                case "unitCoordinatorID":
                    unit.unitCoordinatorID = element.value.trim();
                    break;
                case "unitDescription":
                    unit.description = element.value.trim();
                    break;
                default:
                    break;
            }

        }
        console.log(unit);
        $.post('../php/master_list_unit_engine.php', {
            insertUnit: true,
            unitCode: unit.code,
            unitName: unit.name,
            unitSemesters: unit.semesters,
            unitCampuses: unit.campuses,
            unitCoordinatorID: unit.unitCoordinatorID,
            unitDescription: unit.description
        }, function (data) {
            console.log(data);
            if (data.exist) {
                alert('Unit Exists.');
            } else {
                if (data.UC) {
                    if (data.insertDetail && data.insertList) {
                        alert('Add New Unit successfully.');
                        window.location.href = "../pages/masterList.php?state=1";
                    }

                } else {
                    alert('Staff ID not exist or incorrect, Please check.');
                }

            }
        }, 'json');
    }
    return false;
}

//init edit unit information
function editUnit(e) {
    var td_content = $(e).parents('tr').children('td');
    var unitCode = td_content.eq(0).text();
    var unitName = td_content.eq(1).text();
    var semesters = td_content.eq(2).text();
    var campuses = td_content.eq(3).text();
    var unitCoordinatorID = td_content.eq(4).text();
    var description = td_content.eq(6).text();
    //  alert(unitCode + unitName + semesters + campuses + description);
    $("#unitCodeMan").val(unitCode);
    $("#unitNameMan").val(unitName);
    var semester = semesters.split(",");
    for (let index = 0; index < semester.length; index++) {
        const element = semester[index].trim();
        switch (element) {
            case "Semester 1":
                $("#unitSem1Man").prop("checked", true);
                //removeAttr("checked");
                break;
            case "Semester 2":
                $("#unitSem2Man").prop("checked", true);
                break;
            case "Winter School":
                $("#unitWinterMan").prop("checked", true);
                break;
            case "Spring School":
                $("#unitSpringMan").prop("checked", true);
                break;
            default:
                break;
        }
    }
    var campus = campuses.split(',');
    for (let index = 0; index < campus.length; index++) {
        const element = campus[index].trim();
        switch (element) {
            case "Pandora":
                $("#unitPandoraMan").prop("checked", true);
                break;
            case "Rivendell":
                $("#unitRivendellMan").prop("checked", true);
                break;
            case "Neverland":
                $("#unitNeverlandMan").prop("checked", true);
                break;
            default:
                break;
        }
    }
    $('#unitCoordinatorIDMan').val(unitCoordinatorID);
    $("#unitDescriptionMan").val(description);
    $("#manageUnit").modal('show');
}
//save unit changes
function manageUnitForm(form) {
    if ($("#semesterCheckboxGroupMan").find("input.custom-control-input:checked").length <= 0) {
        alert("Please select at least one semester.");
        return false;
    } else if ($("#campusCheckboxGroupMan").find("input.custom-control-input:checked").length <= 0) {
        alert("Please select at least one campus.");
        return false;
    } else {
        var formdata = $(form).serializeArray();
        console.log(formdata);
        unit = new Object();
        unit.code = "";
        unit.name = "";
        unit.semesters = "";
        unit.campuses = "";
        unit.unitCoordinatorID = "";
        unit.description = "";
        for (let index = 0; index < formdata.length; index++) {
            const element = formdata[index];
            switch (element.name) {
                case "unitCode":
                    unit.code = element.value.trim();
                    break;
                case "unitName":
                    unit.name = element.value.trim();
                    break;
                case "unitSem1":
                    unit.semesters += "Semester 1,";
                    break;
                case "unitSem2":
                    unit.semesters += "Semester 2,";
                    break;
                case "unitWinter":
                    unit.semesters += "Winter School,";
                    break;
                case "unitSpring":
                    unit.semesters += "Spring School,";
                    break;
                case "unitPandora":
                    unit.campuses += "Pandora,";
                    break;
                case "unitRivendell":
                    unit.campuses += "Rivendell,";
                    break;
                case "unitNeverland":
                    unit.campuses += "Neverland,";
                    break;
                case "unitCoordinatorIDMan":
                    unit.unitCoordinatorID = element.value.trim();
                    break;
                case "unitDescription":
                    unit.description = element.value.trim();
                    break;
                default:
                    break;
            }

        }
        console.log(unit);
        $.post('../php/master_list_unit_engine.php', {
            editUnit: true,
            unitCode: unit.code,
            unitName: unit.name,
            unitSemesters: unit.semesters,
            unitCampuses: unit.campuses,
            unitCoordinatorID: unit.unitCoordinatorID,
            unitDescription: unit.description
        }, function (data) {
            if (data.UC) {
                if (data.updateDetails) {
                    if (data.updateList) {
                        alert('Change successfully.');
                        window.location.href = "../pages/masterList.php?state=1";
                    }
                }
            } else {
                alert('Staff ID not exist or incorrect, Please check.');
            }

        }, 'json');

    }
    return false;
}
//toggle remove button
function showRemove(e) {
    // $(e).button('toggle');
    var removeBtn = $(e).next();
    if (removeBtn.attr('class').includes('d-none')) {
        removeBtn.removeClass('d-none');
    } else {
        removeBtn.addClass('d-none');
    }
}
//remove unit
function removeUnit(e) {
    var td_content = $(e).parents('tr').children('td');
    var unitCode = td_content.eq(0).text();
    $.post('../php/master_list_unit_engine.php', {
        unitRemove: true,
        unitCode: unitCode
    }, function (data) {
        if (data.deleteDetail && data.deleteList) {
            alert('Remove successfully.');
            $(e).parents('tr').remove();
        }
    }, 'json');
}

//before submiting remove select disabled attr
function unitManagementFormSubmit(unit) {
    console.log($(unit).serializeArray());
}