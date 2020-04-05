// //chech validation
// function validate() {
//     if (/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test($("#email").val()) == false) {
//         alert("Please enter a valid email address.")
//         return false;
//     } else if (/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^]).{6,12}/.test($("#password").val()) == false) {
//         alert("Please check your password.");
//         return false;
//     }
// }

// // Example starter JavaScript for disabling form submissions if there are invalid fields
// (function () {
//     'use strict';
//     window.addEventListener('load', function () {
//         // Fetch all the forms we want to apply custom Bootstrap validation styles to
//         var forms = document.getElementsByClassName('needs-validation');
//         console.log(forms);
//         // Loop over them and prevent submission
//         var validation = Array.prototype.filter.call(forms, function (form) {
//             form.addEventListener('submit', function (event) {
//                 if (form.checkValidity() === false) {
//                     event.preventDefault();
//                     event.stopPropagation();
//                 } else if (/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(event.target[0].value) == false)
               
//                 // console.log(form[1]);
//                 // console.log(event.target[1].value);
//                 // if (form.checkValidity() === false) 
//                 {
//                     console.log(event.target[0].value);
//                     console.log("shiba");
//                     event.preventDefault();
//                     event.stopPropagation();
//                 }
//                 form.classList.add('was-validated');
//             }, false);
//         });
//     }, false);
// })();