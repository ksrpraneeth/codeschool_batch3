var homeApp = angular.module('homeMod', ['ui.router']);


homeApp.config(['$urlRouterProvider', '$stateProvider', function ($urlRouterProvider, $stateProvider) {

    $urlRouterProvider.otherwise('/product');
    $stateProvider
        .state('About', {
            url: '/About',
            templateUrl: 'About.html'
        })
        .state('Contact', {
            url: '/Contact',
            templateUrl: 'Contact.html'
        })
        .state('product', {
            url: '/product',
            templateUrl: 'product.html',
            controller: 'productCtrl'
        })

        .state('Cart', {
            url: '/Cart',
            templateUrl: 'Cart.html',
            controller: 'cartCtrl'
        })
        .state('productDetails', {
            url: '/product/:id',
            templateUrl: 'productDetails.html',
            controller: 'productDetailsCtrl'
        })
        .state('myOrder', {
            url: '/myOrder',
            templateUrl: 'myOrder.html',
            controller: 'myOrderCtrl'
        })


}]);
homeApp.controller("logoutCtrl", function ($scope) {
    $scope.logout = function () {

        localStorage.clear();
        window.location.replace("login.html");

    }
});
homeApp.controller("productCtrl", function ($scope, $http) {
    var token = JSON.parse(localStorage.getItem('token'));
    if (!token) {
        return;
    }
    $scope.products = [];
    $scope.showProduct = function () {
        $http.get("http://127.0.0.1:8000/api/product", {
            headers: {
                Authorization: `Bearer` + token
            },
        }).then(
            function (response) {

                $scope.products = response.data.output;
                // console.log($scope.products);
            }, function (error) {

            }
        )
    }
    $scope.showProduct();
})
// productdetails controller
homeApp.controller("productDetailsCtrl", function ($http, $scope, $stateParams) {
    var token = JSON.parse(localStorage.getItem('token'));
    if (!token) {
        return;
    }
    $scope.productDetails = {};
    console.log($stateParams);
    $http({
        url: "http://127.0.0.1:8000/api/productDetails",
        method: "get",
        params: { id: $stateParams.id },
        headers: {
            Authorization: `Bearer` + token
        },
    }).then(function (response) {
        console.log(response);
        $scope.productDetails = response.data.output;
        // console.log($scope.productDetails);

    })



    // // function for add to cart
    $scope.addToCart = function () {

        var cartArray = localStorage.getItem('cart');
        if (!cartArray) {
            cartArray = [];
        } else {
            cartArray = JSON.parse(cartArray);
        }


        const findProduct = cartArray.find(x => x.productid == $scope.productDetails.productid);
        if (findProduct) {
            findProduct.quantity = findProduct.quantity + 1;
        } else {
            $scope.productDetails.quantity = 1;
            cartArray.push($scope.productDetails);
        }


        localStorage.setItem('cart', JSON.stringify(cartArray));
        alert('Added to Cart Successfully');
    }
})

// controller for cart page
homeApp.controller("cartCtrl", function ($scope, $http) {
    var token = JSON.parse(localStorage.getItem('token'));
    if (!token) {
        return;
    }
    $scope.cartItems = JSON.parse(localStorage.getItem('cart'));
    

    $http({
        url: "http://127.0.0.1:8000/api/userAddress",
        method: "get",
        headers: {
            Authorization: `Bearer` + token
        },
    }).then(function (response) {
        $scope.result = response.data.output;
        console.log($scope.result);

    })

    // for  placeOrder
    $scope.placeOrder = function () {
        cartItems = JSON.parse(localStorage.getItem('cart'));
        let items = [];
        for (let i = 0; i < cartItems.length; i++) {
            items.push({ productid: cartItems[i].productid, quantity: cartItems[i].quantity });
        }
        var formData = {
            addressId: $scope.selectedOption,
            items: items,
            


        }
        console.log(formData)

        // $http.post('http://127.0.0.1:8000/api/order', formData)
        //     .then(function (response) {

        //         if (response.data == 'success') {

        //             window.alert('order placed successfully')
        //             localStorage.removeItem('cart');
        //             location.replace('index.html');

        //         }
        //         else {
        //             window.alert('can not place the order')
        //         }

        //     });
        $http({
            url: "http://127.0.0.1:8000/api/order",
            method: "post",
            data:formData,
            headers: {
                Authorization: `Bearer` + token
            },
        }).then(function (response){
            if (response.data == 'success'){

                            window.alert('order placed successfully')
                            localStorage.removeItem('cart');
                            location.replace('index.html');
        
                        }
                        else {
                            window.alert('can not place the order')
                        }
    
        })


    }



})

// controller for my order page
homeApp.controller("myOrderCtrl", function ($scope, $http) {
    var token = JSON.parse(localStorage.getItem('token'));
    if (!token) {
        return;
    }
   

    $http({
        url: "http://127.0.0.1:8000/api/myOrder",
        method: "get",
        headers: {
            Authorization: `Bearer` + token
        },
    }).then(function (response) {
        $scope.myorder = response.data.Data;
        
    })
})


