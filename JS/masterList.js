//clear form
$('#createNewStaff').on('hidden.bs.modal', function (e) {
    $("#fCNSta")[0].reset();
})
//clear form
$('#manageStaff').on('hidden.bs.modal', function (e) {
    $('#fMSta')[0].reset();
})
//edit staff information
function editStaff(e) {
    $(e).parents('tr').find('td').each(function () {
        console.log($(this).text().trim());
    })
    // console.log($(e).parents('tr').find('td'));
}
//edit unit information
function editUnit(e) {
    $(e).parents('tr').find('select').each(function () {
        $(this).removeAttr('disabled')
    })
    $(e).addClass('d-none');
    $(e).parents('tr').find('.btn-success').removeClass('d-none');
}
//confirm changes
function confirmUnit(e) {
    $(e).parents('tr').find('select').each(function () {
        $(this).attr('disabled', 'true')
    })
    $(e).addClass('d-none');
    $(e).parents('tr').find('.btn-primary').removeClass('d-none');

    $("#unitManagementForm").submit();

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

//before submiting remove select disabled attr
function unitManagementFormSubmit(unit) {
    console.log($(unit).serializeArray());

    return false;
}