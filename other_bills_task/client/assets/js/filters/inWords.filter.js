app.filter("inWords", function () {
    return function (number) {
        if (number) {
            let b = number.toString().length;
            if (b <= 10) {
                number = "000000000" + number;
                let last3 = number.substr(-3, 3);
                let thousand = number.substr(-5, 2);
                let lakh = number.substr(-7, 2);
                let core = number.substr(-10, 3);
                let str = "";
                if (Number(number) != 0) {
                    if (Number(core) != 0) {
                        str =
                            str +
                            ConvertHundreedToword(core) +
                            " " +
                            "core" +
                            " ";
                    }
                    if (Number(lakh) != 0) {
                        str =
                            str +
                            ConversionTenthToword(lakh) +
                            " " +
                            "lakh" +
                            " ";
                    }
                    if (Number(thousand) != 0) {
                        str =
                            str +
                            ConversionTenthToword(thousand) +
                            " " +
                            "thousand" +
                            " ";
                    }
                    str = str + ConvertHundreedToword(last3);
                    str = str.toUpperCase();
                    return str;
                } else {
                    return "zero";
                }

                function ConvertHundreedToword(parameter1) {
                    let One = [
                        "",
                        "One",
                        "Two",
                        "Three",
                        "Four",
                        "Five",
                        "Six",
                        "Seven",
                        "Eight",
                        "Nine",
                        "Ten",
                        "Eleven",
                        "Twelve",
                        "Thrteen",
                        "Fourteen",
                        "Fifteen",
                        "Sixteen",
                        "Sevente",
                        "Eighteen",
                        "Ninteen",
                    ];

                    let Ten = [
                        "",
                        "",
                        "Twenty",
                        "Thirty",
                        "Fourty",
                        "Fifty",
                        "Sixty",
                        "Seventy",
                        "Eighty",
                        "Ninty",
                    ];
                    let hundred = "";
                    let tenth = 0;
                    //checaking for the hundrred place
                    if (Number(parameter1[0]) != 0) {
                        hundred =
                            hundred +
                            One[Number(parameter1[0])] +
                            " " +
                            "hundred" +
                            " ";
                    }

                    //cheacking for the tenth place
                    if (Number(parameter1[1]) == 1) {
                        tenth = tenth + Number(parameter1[1]) + parameter1[2];
                        hundred = hundred + One[tenth];
                    } else if (Number(parameter1[1]) == 0) {
                        hundred = hundred + One[Number(parameter1[2])];
                    } else {
                        hundred =
                            hundred +
                            Ten[Number(parameter1[1])] +
                            One[Number(parameter1[2])];
                    }
                    return hundred;
                }
                //function hundreed ends here

                //function to convert two digit number
                function ConversionTenthToword(Parameter1) {
                    let One = [
                        "",
                        "one",
                        "two",
                        "three",
                        "four",
                        "five",
                        "six",
                        "seven",
                        "eight",
                        "nine",
                        "ten",
                        "eleven",
                        "twelve",
                        "thrteen",
                        "fourteen",
                        "fifteen",
                        "sixteen",
                        "sevente",
                        "eighteen",
                        "ninteen",
                    ];

                    let Ten = [
                        "",
                        "",
                        "twenty",
                        "thirty",
                        "fourty",
                        "fifty",
                        "sixty",
                        "seventy",
                        "eighty",
                        "ninty",
                    ];
                    let TenToword = "";
                    if (Number(Parameter1[0]) > 1) {
                        TenToword =
                            TenToword +
                            Ten[Number(Parameter1[0])] +
                            One[Number(Parameter1[1])];
                    } else if (Number(Parameter1[2]) == 0) {
                        TenToword = TenToword + "ten";
                    } else {
                        TenToword =
                            TenToword +
                            One[Number(Parameter1[0] + Parameter1[1])];
                    }
                    return TenToword;
                }
            } else {
                return "limit exceed";
            }
        }
    };
});
