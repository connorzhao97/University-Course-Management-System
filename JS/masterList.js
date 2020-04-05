$(function () {
    $('.selectpicker').selectpicker();
});

$('#createNewStaff').on('hidden.bs.modal', function (e) {
    $("#fCNSta")[0].reset();
})