//lecture or tutorial id which clicked
var lecID = "";
var tutoID = "";
//clear creat lecture form
$('#createLecture').on('hidden.bs.modal', function (e) {
    $("#createLectureForm")[0].reset();
})

//clear create tutorial formdata
$('#createTutorial').on('hidden.bs.modal', function (e) {
    $("#createTutorialForm")[0].reset();
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
//set list content
$(function () {
    if (getQuery("state") == "0") {
        $('#list-lecture-list').tab('show');
    } else if (getQuery("state") == "1") {
        $('#list-tutorial-list').tab('show');
    }
})


//toggle remove button
function showRemove(e) {
    var removeBtn = $(e).next();
    if (removeBtn.attr('class').includes('d-none')) {
        removeBtn.removeClass('d-none');
    } else {
        removeBtn.addClass('d-none');
    }
}

/* NOTE lecture */
/**
 * @description: create a new lecture
 * @param form get form information
 * @param unit_code get unit code
 * @param details_id get unit id
 * @return: false
 */
function createNewLectureForm(form, unit_code, details_id) {
    lec = new Object();
    lec.details_id = details_id;
    lec.day = "";
    lec.time = "";
    lec.duration = "";
    lec.location = "";
    lec.sc = "";
    lec.lecturerID = "";
    lec.consulation = "";
    var formdata = $(form).serializeArray();
    for (let index = 0; index < formdata.length; index++) {
        const element = formdata[index];
        switch (element.name) {
            case "lecDay":
                lec.day = element.value.trim();
                break;
            case "lecHour":
                lec.time = element.value.trim();
                break;
            case "lecMinute":
                lec.time += ":" + element.value.trim();
                break;
            case "lecDuration":
                lec.duration = element.value.trim();
                break;
            case "lecLocation":
                lec.location = element.value.trim();
                break;
            case "lecSC":
                lec.sc = element.value.trim();
                break;
            case "lecLecturerID":
                lec.lecturerID = element.value.trim();
                break;
            case "lecConsulation":
                lec.consulation = element.value.trim();
                break;
            default:
                break;
        }
    }
    $.post('../php/unit_management_engine.php', {
        insertLecture: true,
        details_id: lec.details_id,
        units_lists_id: lec.sc,
        day: lec.day,
        time: lec.time,
        duration: lec.duration,
        location: lec.location,
        sta_id: lec.lecturerID,
        consulation: lec.consulation
    }, function (data) {
        if (data.exist) {
            alert('The Lecture Exists');
        } else {
            if (!data.lecturer) {
                alert('The Lecturer ID does not exist or not a lecturer');
            } else {
                if (data.insert) {
                    alert('The Lecture inserted successfully');
                    window.location.href = "../pages/unitManagement.php?code=" + unit_code + "&state=0";
                }
            }
        }
    }, 'json');
    return false;
}
/**
 * @description: init edit lecture information
 * @param e DOM for getting information from table and put the information into the edit lecture modal
 * @return: null
 */
function editLecture(e) {
    lecID = $(e).parents('tr').attr('id');
    var td_content = $(e).parents('tr').children('td');
    var day = td_content.eq(0).text();
    var time = td_content.eq(1).text();
    var duration = td_content.eq(2).text();
    var location = td_content.eq(3).text();
    var sc = td_content.eq(4).data('lists-id');
    var lectureID = td_content.eq(5).text();
    var consulation = td_content.eq(6).text();
    $("#lecDayMan" + day).prop("selected", true);
    var HM = time.split(":");
    $("#lecHourMan" + HM[0]).prop("selected", true);
    $("#lecMinuteMan" + HM[1]).prop("selected", true);
    $("#lecDurationMan").val(duration);
    $("#lecLocationMan").val(location);
    $("#lecSCMan" + sc).prop("selected", true);
    $("#lecLecturerIDMan").val(lectureID);
    $("#lecConsulationMan").val(consulation);
    $("#manageLecture").modal("show");
}

/**
 * @description: update lecture
 * @param form get form information
 * @param unit_code get unit code
 * @return: false
 */
function manageNewLectureForm(form, unit_code) {
    lec = new Object();
    lec.id = lecID;
    lec.day = "";
    lec.time = "";
    lec.duration = "";
    lec.location = "";
    lec.sc = "";
    lec.lecturerID = "";
    lec.consulation = "";
    var formdata = $(form).serializeArray();
    for (let index = 0; index < formdata.length; index++) {
        const element = formdata[index];
        switch (element.name) {
            case "lecDayMan":
                lec.day = element.value.trim();
                break;
            case "lecHourMan":
                lec.time = element.value.trim();
                break;
            case "lecMinuteMan":
                lec.time += ":" + element.value.trim();
                break;
            case "lecDurationMan":
                lec.duration = element.value.trim();
                break;
            case "lecLocationMan":
                lec.location = element.value.trim();
                break;
            case "lecSCMan":
                lec.sc = element.value.trim();
                break;
            case "lecLecturerIDMan":
                lec.lecturerID = element.value.trim();
                break;
            case "lecConsulationMan":
                lec.consulation = element.value.trim();
                break;
            default:
                break;
        }
    }
    $.post('../php/unit_management_engine.php', {
        updateLecture: true,
        id: lec.id,
        units_lists_id: lec.sc,
        day: lec.day,
        time: lec.time,
        duration: lec.duration,
        location: lec.location,
        sta_id: lec.lecturerID,
        consulation: lec.consulation
    }, function (data) {
        if (!data.lecturer) {
            alert('The Lecturer ID does not exist or not a lecturer');
        } else {
            if (data.scExists) {
                alert('The Semester and Campus already exist');
            } else {
                if (data.update) {
                    alert('The Lecture updated successfully');
                    window.location.href = "../pages/unitManagement.php?code=" + unit_code + "&state=0";
                    lecID = "";
                } else {
                    alert('Something went wrong');
                }
            }
        }
    }, 'json');
    return false;
}

/**
 * @description: remove lecture
 * @param e DOM for getting lecture id
 * @return: null
 */
//remove lecture
function removeLecture(e) {
    var id = $(e).parents('tr').attr('id');
    $.post('../php/unit_management_engine.php', {
        removeLecture: true,
        id: id
    }, function (data) {
        if (data.removeLecture) {
            alert('Remove Lecture Successfully');
            $(e).parents('tr').remove();
        }
    }, 'json');
}


/*NOTE tutorial */
/**
 * @description: create new tutorial
 * @param form get form information
 * @param unit_code get unit code
 * @param details_id get unit id
 * @return: false
 */
function createNewTutorialForm(form, unit_code, details_id) {
    tuto = new Object();
    tuto.details_id = details_id;
    tuto.day = "";
    tuto.time = "";
    tuto.duration = "";
    tuto.location = "";
    tuto.sc = "";
    tuto.tutorID = "";
    tuto.capacity = "";
    tuto.consulation = "";
    var formdata = $(form).serializeArray();
    for (let index = 0; index < formdata.length; index++) {
        const element = formdata[index];
        switch (element.name) {
            case "tutoDay":
                tuto.day = element.value.trim();
                break;
            case "tutoHour":
                tuto.time = element.value.trim();
                break;
            case "tutoMinute":
                tuto.time += ":" + element.value.trim();
                break;
            case "tutoDuration":
                tuto.duration = element.value.trim();
                break;
            case "tutoLocation":
                tuto.location = element.value.trim();
                break;
            case "tutoSC":
                tuto.sc = element.value.trim();
                break;
            case "tutoTutorID":
                tuto.tutorID = element.value.trim();
                break;
            case "tutoCapacity":
                tuto.capacity = element.value.trim();
                break;
            case "tutoConsulation":
                tuto.consulation = element.value.trim();
                break;
            default:
                break;
        }
    }
    $.post('../php/unit_management_engine.php', {
        insertTutorial: true,
        details_id: tuto.details_id,
        units_lists_id: tuto.sc,
        day: tuto.day,
        time: tuto.time,
        duration: tuto.duration,
        location: tuto.location,
        sta_id: tuto.tutorID,
        capacity: tuto.capacity,
        consulation: tuto.consulation
    }, function (data) {
        if (!data.tutor) {
            alert('The Tutor ID does not exist or not a tutor')
        } else {
            if (data.insert) {
                alert('The Tutorial inserted successfully');
                window.location.href = "../pages/unitManagement.php?code=" + unit_code + "&state=1";
            }
        }
    }, 'json');
    return false;
}
/**
 * @description: init edit tutorial information
 * @param e DOM for getting information from table and put the information into the edit tutorial modal
 * @return: null
 */
function editTutorial(e) {
    tutoID = $(e).parents('tr').attr('id');
    var td_content = $(e).parents('tr').children('td');
    var day = td_content.eq(0).text();
    var time = td_content.eq(1).text();
    var duration = td_content.eq(2).text();
    var location = td_content.eq(3).text();
    var sc = td_content.eq(4).data('lists-id');
    var lectureID = td_content.eq(5).text();
    var capacity = td_content.eq(6).text();
    var consulation = td_content.eq(7).text();
    // console.log(day + "," + time + "," + duration + "," + location + "," + sc + "," + lectureID + "," + capacity + "," + consulation);
    $("#tutoDayMan" + day).prop("selected", true);
    var HM = time.split(":");
    $("#tutoHourMan" + HM[0]).prop("selected", true);
    $("#tutoMinuteMan" + HM[1]).prop("selected", true);
    $("#tutoDurationMan").val(duration);
    $("#tutoLocationMan").val(location);
    $("#tutoSCMan" + sc).prop("selected", true);
    $("#tutoTutorIDMan").val(lectureID);
    $("#tutoCapacityMan" + capacity).prop("selected", true);
    $("#tutoConsulationMan").val(consulation);
    $("#manageTutorial").modal("show");
}

/**
 * @description: update tutorial
 * @param form get form information
 * @param unit_code get unit code
 * @return: false
 */
function manageNewTutorialForm(form, unit_code) {
    tuto = new Object();
    tuto.id = tutoID;
    tuto.day = "";
    tuto.time = "";
    tuto.duration = "";
    tuto.location = "";
    tuto.sc = "";
    tuto.tutorID = "";
    tuto.capacity = "";
    tuto.consulation = "";

    var formdata = $(form).serializeArray();
    console.log(formdata);
    for (let index = 0; index < formdata.length; index++) {
        const element = formdata[index];
        switch (element.name) {
            case "tutoDayMan":
                tuto.day = element.value.trim();
                break;
            case "tutoHourMan":
                tuto.time = element.value.trim();
                break;
            case "tutoMinuteMan":
                tuto.time += ":" + element.value.trim();
                break;
            case "tutoDurationMan":
                tuto.duration = element.value.trim();
                break;
            case "tutoLocationMan":
                tuto.location = element.value.trim();
                break;
            case "tutoSCMan":
                tuto.sc = element.value.trim();
                break;
            case "tutoTutorIDMan":
                tuto.tutorID = element.value.trim();
                break;
            case "tutoCapacityMan":
                tuto.capacity = element.value.trim();
                break;
            case "tutoConsulationMan":
                tuto.consulation = element.value.trim();
                break;
            default:
                break;
        }
    }
    console.log(tuto);


    $.post('../php/unit_management_engine.php', {
        updateTutorial: true,
        id: tuto.id,
        units_lists_id: tuto.sc,
        day: tuto.day,
        time: tuto.time,
        duration: tuto.duration,
        location: tuto.location,
        sta_id: tuto.tutorID,
        capacity: tuto.capacity,
        consulation: tuto.consulation
    }, function (data) {
        if (!data.tutor) {
            alert('The Tutor ID does not exist or not a tutor')
        } else {
            if (data.update) {
                alert('The Tutorial updated successfully');
                window.location.href = "../pages/unitManagement.php?code=" + unit_code + "&state=1";
                tutoID = "";
            } else {
                alert('Something went wrong');
            }
        }
    }, 'json');
    return false;
}



/**
 * @description: remove tutorial
 * @param e DOM for getting tutorial id
 * @return: false
 */
function removeTutorial(e) {
    var id = $(e).parents('tr').attr('id');
    $.post('../php/unit_management_engine.php', {
        removeTutorial: true,
        id: id
    }, function (data) {
        if (data.removeTutorial) {
            alert('Remove Tutorial Successfully');
            $(e).parents('tr').remove();
        }
    }, 'json');
}