$("#btnCreate").click(function () {
    alert('2')
})
$(function () {
    $('.selectpicker').selectpicker();
});


function edit(params) {
    console.log(params)
    console.log(params.parentNode.parentNode.parentNode);
}