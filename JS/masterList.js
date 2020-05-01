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
        $("#pills-first-tab").addClass("active");
        $("#pills-second-tab").removeClass("active");
        $('#pills-first').addClass('active show');
        $("#pills-second").removeClass('active show');
    } else if (getQuery("state") == "1") {
        $("#pills-second-tab").addClass("active");
        $("#pills-first-tab").removeClass("active");
        $('#pills-second').addClass('active show');
        $("#pills-first").removeClass('active show');
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
    if ($('.checkboxGroup').find("input.custom-control-input:checked").length <= 0) {
        $('.checkboxGroup').addClass('is-invalid');
        return false;
    } else {
        $('.checkboxGroup').removeClass('is-invalid');
    }
    var staID = "",
        staName = "",
        staQua = "",
        staExp = "",
        staPre = "",
        staCon = "";
    console.log(staPre);
    var formdata = $(form).serializeArray();
    for (let index = 0; index < formdata.length; index++) {
        const element = formdata[index];
        if (element.name === "staNewID") {
            staID = element.value;
        } else if (element.name === "staNewName") {
            staName = element.value;
        } else if (element.name === "staNewQua") {
            staQua = element.value;
        } else if (element.name === "staNewExp") {
            staExp = element.value;
        } else if (element.name === "staNewPreMon") {
            staPre += "Mon. ";
        } else if (element.name === "staNewPreTue") {
            staPre += "Tue. ";
        } else if (element.name === "staNewPreWed") {
            staPre += "Wed. ";
        } else if (element.name === "staNewPreThu") {
            staPre += "Thu. ";
        } else if (element.name === "staNewPreFri") {
            staPre += "Fri. ";
        } else if (element.name === "staNewCon") {
            staCon = element.value;
        }
        console.log(element);
    }
    console.log(staID, staName, staQua, staExp, staPre, staCon);
    console.log(formdata);
    var tr = $("<tr></tr>");
    tr.html("<td scope= 'row' class = 'align-middle'>" + staID + "</td>" +
        "<td class = 'align-middle'>" + staName + "</td>" +
        "<td class = 'align-middle'>" + staQua + "</td>" +
        "<td class = 'align-middle'>" + staExp + "</td>" +
        "<td class = 'align-middle'>" + staPre + "</td>" +
        "<td class = 'align-middle'>" + staCon + "</td>" +
        "<td class = 'align-middle'>" + "<button type='button' id='btnEdit' class='btn btn-primary btn-lg btn-block' data-toggle='modal' data-target='#manageStaff' onclick='editStaff(this)'>Edit</button></td>" +
        "<td class = 'align-middle'>" + "<button type='button' id='btnRemove' class='btn btn-danger btn-lg btn-block' onclick='removeStaff(this)'>Remove</button></td>"
    );
    $("#staManagementTable").find("tr").last().after(tr);
    $("#createNewStaff").modal('hide');
    return false;
}

//edit staff table
$(function () {
    $("#staManagementTable").Tabledit({
        url: "../php/master_list_engine.php",
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
                [2, "qualification"],
                [3, "expertise"],
                [4, "preferred"],
                [5, "consulation", '{"1":"1pm","2":"2pm"}']
            ]
        },
        restoreButton: false,
        autoFocus: true,
        onSuccess: function (data, textStatus, jqXHR) {
            console.log(data);
            if (data.action === 'delete') {
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
        unit.description = "";
        for (let index = 0; index < formdata.length; index++) {
            const element = formdata[index];
            switch (element.name) {
                case "unitCode":
                    unit.code = element.value;
                    break;
                case "unitName":
                    unit.name = element.value;
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
                case "unitDescription":
                    unit.description = element.value;
                    break;
                default:
                    break;
            }

        }
        console.log(unit);
        $.post('../php/master_list_engine.php', {
            insertUnit: true,
            unitCode: unit.code,
            unitName: unit.name,
            unitSemesters: unit.semesters,
            unitCampuses: unit.campuses,
            unitDescription: unit.description
        }, function (data) {
            console.log(data);
            if (data.exist) {
                alert('Unit exists.');
            } else {
                if (data.insertDetail && data.insertList) {
                    alert('Add new unit successfully.');
                    window.location.href = "../pages/masterList.php?state=1";
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
    var description = td_content.eq(4).text();
    // alert(unitCode + unitName + semesters + campus + description);
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
    $("#unitDescriptionMan").val(description);

    $("#manageUnit").modal('show');

}
//save unit changes
function manageUnitForm(e) {
    var formdata = $(e).serializeArray();
    console.log(formdata);
   return false;
}

//before submiting remove select disabled attr
function unitManagementFormSubmit(unit) {
    console.log($(unit).serializeArray());

    // return false;
}