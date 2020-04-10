$('#createNewStaff').on('hidden.bs.modal', function (e) {
    $("#fCNSta")[0].reset();
})
$("body").on('click', '[data-stopPropagation]', function (e) {
    e.stopPropagation();
});

function editStaff(e) {

}

function removeStaff(e) {
    $(e).parents('tr').remove();
    console.log($(e).parents('tr').attr('id'));
}

function validate() {
    if ($('.checkboxGroup').find("input.custom-control-input:checked").length <= 0) {
        $('.checkboxGroup').addClass('is-invalid');
        return false;
    } else {
        $('.checkboxGroup').removeClass('is-invalid');
        return true;
    }
}