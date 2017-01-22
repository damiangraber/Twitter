document.addEventListener('DOMContentLoaded', function () {

    var formButton = document.querySelector('form button');
    var inputOldPass = document.querySelector('input#oldpass');
    var inputPass1 = document.querySelector('input#pass1');
    var inputPass2 = document.querySelector('input#pass2');


    formButton.addEventListener('click', function (event) {
        var valuePass1 = inputPass1.value;
        var valuePass2 = inputPass2.value;

        if (valuePass1 != valuePass2 || valuePass1.length == 0) {
            console.log('Hasła są różne lub puste');
            event.preventDefault();
        }

    });
});