reBg.jpg Photo by Sharon McCutcheon on Unsplash. Used in registration.php/userAccount.php
timetableBg.jpg Photo by Curtis MacNewton on Unsplash. Used in individualTimetable.php
allocationBg.jpg Photo by Harry cao on Unsplash. Used in tutorialAllocation.php
masterBg.jpg Photo by Drew Beamer on Unsplash. Used in masterList.php
detailBg.jpg Photo by Cole Keister on Unsplash. Used in enrolledDetails.php/unitDetail.php/unitEnrolment.php/unitManagement.php
home.jpg Photo by Marvin Meyer on Unsplash. Used in home.php

In masterList.php use jquery.tabledit.min.js to update the staff table.

//Role Description
Access Level: 
Degree Coordinator(DC):5,
Unit Coordinator(UC):4,
Lecturer:3,
Tutor:2,
Staff member:1,
Student:0.

//Current Account: 
DC ID:1 PASSWORDS:Qwe123!
UC1 ID:2 PASSWORDS:Qwe123!
UC2 ID:3 PASSWORDS:Qwe123!
Lecturer1 ID:4 PASSWORDS:Qwe123!
Lecturer2 ID:5 PASSWORDS:Qwe123!
Tutor1 ID:6 PASSWORDS:Qwe123!
Tutor2 ID:7 PASSWORDS:Qwe123!
Staff1 ID:8 PASSWORDS:Qwe123!
Staff2 ID:9 PASSWORDS:Qwe123!
Student1 ID:10001 PASSWORDS:Qwe123!
Student2 ID:10002 PASSWORDS:Qwe123!

/*
ACCESS: ALL
*/

//home.php
If users don't login, users can click on login/Register button to Login.php.
If users login, users can click on logout button to logout.

//login.php
Users can fill the ID and password click login button to login.
Users can click register button and redirect to registration.php.

//Registration.php
If user is a student, student can fill the blanks and click register as a student button.
If user is a staff, staff can click I'm a staff panel button, and fill the blanks and click register as a staff button.

// unitDetail.php
After users login, users can view the list of available units, and click on the unit "View Details" button will redirect to the details page.
e.g. Click on KIT502 View Details Button will redirect to unitDetail.php?code=KIT502

//User account
Users can update their information and see the timetable.

/*
ACCESS: Student
*/

//unitEnrolment.php
Only students can access this page.
If students do not login, the page will redirect to login.php automatically.
In the current enrolment panel, students can see which units they enrolled and can click on the withdraw button to withdraw the units.
In the available units panel, students can see the available units which DC create, and select a semester and campus in order to enroll the unit.
If students withdraw their unit, their tutorials will also be withdrawn.

//tutorialAllocation.php
Only students can access this page.
If students do not login, the page will redirect to login.php automatically.
Students can see the tutorial times which DC/UC create in different unit panels, there are three states of the action button (Select, Allocated, Full).
Select Button: the capacity of the tutorial is not full, click this button will enroll this tutorial. If the student has already enrolled in another tutorial, the tutorial will change to which the student selects automatically.
Allocated Button: The tutorial which the student has already enrolled, if the student clicks on the allocated button, the students will withdraw the tutorial.
Full Button: The student cannot click on the button because the capacity of the tutorial has already been full.
Even if the student click the select button, but there might be several students enroll one tutorial at the same time, so in the backend will check the capacity, it might reject because the tutorial has been full.

//individualTimetable.php
Only students can access this page.
If students do not login, the page will redirect to login.php automatically.
If students do not enroll in any units, there will be no records to show.
Students can see the lecture or tutorial details in which they enrolled.

/*
ACCESS: Staff
*/


//masterList.php
Access:DC
In staff management panel:
Click create new staff button and there is a form which DC could fill in the modal.
Click edit button, DC could update the staff information using jquery.tabledit.min.js.
Click remove button of each line will remove the staff.
In unit management panel:
Click create new unit button and there is a form which DC could fill in the modal.
Click edit button DC can change the information and click confirm button to save these changes.
Click remove button of each line will remove the unit.
When DC remove the unit, the all related data will be deleted, such as delete studnets' timetable, students' enrolment, lecture and tutorial details.

//unitManagement.php
Access:DC UC
DC could manage all units, UC could only manage the unit which belongs to their own.
Click on the unit which DC/UC wants to manage and will redirect to the management page. e.g. unitManagement.php?code=KIT502
There should be only one lecture in each available semester and campus unit.
There could be several tutorials in each available semester and campus unit.
Click on edit button in lecture / tutorial panel, there will be a modal, DC/UC can change and save the lecture / tutorial data.
Click on create new lecture / tutorial button, DC/UC can create a new lecture / tutorial for the unit.
Click on remove button in each lecture / tutorial, the all related data will be deleted, such as delete studnets' timetable,lecture and tutorial details.

//enrolledDetails.php
Access: DC UC lecturer, tutor
DC can see all students who are enrolled.
UC can see all students who are enrolled units belong to them.
Lecturer and tutor can see the students related to their lecture / tutorial.