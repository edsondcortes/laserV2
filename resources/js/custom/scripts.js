/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 5.0
	Author: PIXINVENT
	Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

import Swal from 'sweetalert2';

var error = $("#serverErrorsMessage");
if(error.length != 0) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        confirmButtonColor: '#021542',
        html: error.html(),
    })
};

var sucess = $("#serverSuccessMessage");
if(sucess.length != 0) {
    console.log(sucess.html());
    Swal.fire({
        icon: 'success',
        title: 'Bom trabalho!',
        confirmButtonColor: '#021542',
        html: sucess.html(),
        timer: 3500,
    })
};

var warning = $("#serverWarningMessage");
if(warning.length != 0) {
    Swal.fire({
        icon: 'warning',
        title: 'Atenção!!!',
        confirmButtonColor: '#021542',
        html: warning.html(),
    })

var confirm = $('#serverConfirmMessage');

};
