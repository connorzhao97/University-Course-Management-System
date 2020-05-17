//clear creat lecture form
$('#createLecture').on('hidden.bs.modal', function (e) {
    $("#createLectureForm")[0].reset();
})

//clear create tutorial formdata
$('#createTutorial').on('hidden.bs.modal', function (e) {
    $("#createTutorialForm")[0].reset();
})

//toggle remove button
function showRemove(e){
    var removeBtn=$(e).next();
    if (removeBtn.attr('class').includes('d-none')) {
        removeBtn.removeClass('d-none');
    } else {
        removeBtn.addClass('d-none');
    }
}

/* NOTE lecture */
//create new lecture
function createNewLectureForm(form, details_id) {
    lec = new Object();
    lec.details_id = details_id;
    lec.day = "";
    lec.time = "";
    lec.location = "";
    lec.sc = "";
    lec.lecturerID = "";
    lec.consulation = "";
    var formdata = $(form).serializeArray();
    console.log(formdata);
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
    console.log(lec);
    $.post('../php/unit_management_engine.php', {
        insertLecture: true,
        details_id: lec.details_id,
        units_lists_id: lec.sc,
        day: lec.day,
        time: lec.time,
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
                    alert('The Lecture insert successfully');
                    window.location.reload();
                }
            }
        }
    }, 'json');
    return false;
}



/*NOTE tutorial */
//create new tutorial
function createNewTutorialForm(form, details_id) {
    tuto = new Object();
    tuto.details_id = details_id;
    tuto.day = "";
    tuto.time = "";
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
            case "tutoDay":
                tuto.day = element.value.trim();
                break;
            case "tutoHour":
                tuto.time = element.value.trim();
                break;
            case "tutoMinute":
                tuto.time += ":" + element.value.trim();
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
    console.log(tuto);

    $.post('../php/unit_management_engine.php', {
        insertTutorial: true,
        details_id: tuto.details_id,
        units_lists_id: tuto.sc,
        day: tuto.day,
        time: tuto.time,
        location: tuto.location,
        sta_id: tuto.tutorID,
        capacity: tuto.capacity,
        consulation: tuto.consulation
    }, function (data) {
        if (!data.tutor) {
            alert('The Tutor ID does not exist or not a tutor')
        } else {
            if (data.insert) {
                alert('The Tutorial insert successfully');
                window.location.reload();
            }
        }
    }, 'json');
    return false;
}


//edit tutorial




//remore tutorial
