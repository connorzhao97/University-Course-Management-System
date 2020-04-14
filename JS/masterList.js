//clear form
$('#createNewStaff').on('hidden.bs.modal', function (e) {
    $("#fCNSta")[0].reset();
})
//clear form
$('#manageStaff').on('hidden.bs.modal', function (e) {
    $('#fMSta')[0].reset();
})

function editStaff(e) {
    $(e).parents('tr').find('td').each(function () {
        console.log($(this).text().trim());
    })
    // console.log($(e).parents('tr').find('td'));
}

function editUnit(e) {
    $(e).parents('tr').find('select').each(function () {
        $(this).removeAttr('disabled')
    })
    $(e).addClass('d-none');
    $(e).parents('tr').find('.btn-success').removeClass('d-none');
}

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
    console.log($(e).parents('tr').attr('id'));
}

//validate
function validate() {
    if ($('.checkboxGroup').find("input.custom-control-input:checked").length <= 0) {
        $('.checkboxGroup').addClass('is-invalid');
        return false;
    } else {
        $('.checkboxGroup').removeClass('is-invalid');
        return true;
    }
}

//before submit remove select disabled attr
function unitManagementFormSubmit(unit) {
console.log($(unit).serializeArray());

return false;
}