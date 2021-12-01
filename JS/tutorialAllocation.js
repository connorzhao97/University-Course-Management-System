/**
 * @description: students can allocate tutorials.
 *  If the tutorial is full or in the allocation process capacity of the tutorial becomes full, students cannot allocate even if students click the button.
 * @param e DOM for getting tutorial id
 * @param details_id unit id
 * @return: null
 */
function allocateTutorial(e, details_id) {
    var id = $(e).parents('tr').attr('id');
    $.post('../php/tutorial_allocation_engine.php', {
        allocate: true,
        id: id,
        details_id: details_id
    }, function (data) {
        if (data.full) {
            alert('This tutorial has been already full, please select another one');
            window.location.href = "../pages/tutorialAllocation.php";
        } else if (data.allocate) {
            alert('Allocate successfully');
            window.location.href = "../pages/tutorialAllocation.php";
        } else if (!data.allocate) {
            alert('Failure');
        }
    }, 'json');
}
/**
 * @description: students withdraw tutorials
 * @param e DOM for getting tutorial id
 * @param details_id unit id
 * @return: null
 */
function withdraw(e, details_id) {
    var id = $(e).parents('tr').attr('id');
    $.post('../php/tutorial_allocation_engine.php', {
        withdraw: true,
        id: id,
        details_id: details_id
    }, function (data) {
        if (data.delete) {
            alert("Withdraw successfully");
            window.location.href = "../pages/tutorialAllocation.php";
        }
    }, 'json');
}