reBg.jpg Photo by Sharon McCutcheon on Unsplash.
timetableBg.jpg Photo by Curtis MacNewton on Unsplash.
allocationBg.jpg Photo by Harry cao on Unsplash.
masterBg.jpg Photo by Drew Beamer on Unsplash.
detailBg.jpg Photo by Cole Keister on Unsplash.
502.jpg Photo by Ilya Pavlov on Unsplash.
503.jpg Photo by Marvin Meyer on Unsplash.
710.jpg Photo by Axel Ahoi on Unsplash.
707.jpg Photo by Helloquence on Unsplash.

Because we don't use a database in assignment 1, I put all page links in the navbar.
Because we cannot log in, every role can access all the pages and show all functions in the pages.

//In home.html
After login, users could click on different unit cards and link to that unitDetail.html.
e.g.: If users click on KIT502 unit, and then will redirect to unitDetail.html?kit502. According to different unit code, there will be different information in unit detail pages.
After logging in, the button will change to log out.

//In login.html
Users can fill the blanks and click login button to login.
Users can click register button and redirect to registration.html.

//In register.html
If user is a student, student can fill the blanks and click register as a student button.
If user is a staff, student can click I'm a staff panel button, and fill the blanks and click register as a staff button.

//In unitDetail.html
According to different parameters in URL, there will get different data from the database.
There is a enrol units button in the jumbotron.

//In unitEnrolment.html
Users can select available units time and check the enrol checkbox.
When click enrol checked units, users can enrol these units.
If users don't check the enrol checkbox, they cannot enrol the unit even they select time.

//In individualTimetable.html
Users can redirect to unit management page and allocation page.
Users can view the timetable of this week.
After linking to a database, users can click pagination buttons and view different timetables of each week.

//In tutorialAllocation.html
If users don't log in, they can only view the time lists of each unit.
If users are logged in, there will have an allocation button with three states(Select, Allocated, Full) in the first column.

//In masterList.html
DC can manage staff details in the staff management panel.
UC can allocates lecturer for each unit in the unit management panel.

//unitManagement.html
Only DC can access to it.