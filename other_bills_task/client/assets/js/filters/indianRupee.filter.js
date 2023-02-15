app.filter("indianRupees", function () {
    return function (input) {
      if (isNaN(input)) return input;
      var rupees = parseFloat(input).toLocaleString("en-IN", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
      return rupees;
    };
  });