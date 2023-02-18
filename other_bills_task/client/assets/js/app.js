let app = angular.module("app", ["ui.router"]);
let SERVER = "http://127.0.0.1:8000/api";

app.config(function ($httpProvider) {
    $httpProvider.interceptors.push("loadingInterceptor");
});

// Custom Functions
function showError(err) {
    // Toastify({
    //     text: err,
    //     duration: 3000,
    //     newWindow: true,
    //     close: true,
    //     gravity: "top", // `top` or `bottom`
    //     position: "left", // `left`, `center` or `right`
    //     stopOnFocus: true, // Prevents dismissing of toast on hover
    //     style: {
    //         background: "linear-gradient(to right, #b02900, #c9853d)",
    //     },
    // }).showToast();
    Swal.fire({
        title: "Error",
        text: err,
        icon: "error",
        confirmButtonText: "Okay",
    });
}

function showSuccess(msg) {
    // Toastify({
    //     text: msg,
    //     duration: 3000,
    //     newWindow: true,
    //     close: true,
    //     gravity: "top", // `top` or `bottom`
    //     position: "left", // `left`, `center` or `right`
    //     stopOnFocus: true, // Prevents dismissing of toast on hover
    //     style: {
    //         background: "linear-gradient(to right, #00b09b, #96c93d)",
    //     },
    // }).showToast();
    Swal.fire({
        title: "Success",
        text: msg,
        icon: "success",
        confirmButtonText: "Okay",
    });
}

function onlyNumbers(event) {
    var charCode = event.which ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        event.preventDefault();
    }
}

function alphaNumericOnly (e) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
}