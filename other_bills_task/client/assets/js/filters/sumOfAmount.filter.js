app.filter("sumOfAmount", function () {
    return function (input, key) {
        let sum = 0;
        input.forEach((element) => {
            sum += parseInt(element[key]);
        });
        return sum;
    };
});
