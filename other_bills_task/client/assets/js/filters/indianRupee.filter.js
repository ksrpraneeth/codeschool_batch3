app.filter("indianRupees", function () {
    return function (input) {
        if (isNaN(input)) return input;
        console.log(typeof(input));
        var rupees = parseInt(input).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        return rupees;
    };
});
