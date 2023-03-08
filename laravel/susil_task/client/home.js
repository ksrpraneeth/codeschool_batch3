var homeApp = angular.module('homeMod', ['ui.router']);
homeApp.config(['$stateProvider', function ($stateProvider) {
    $stateProvider

        .state('About', {
            url: '/About',
            templateUrl: 'About.html'
        })
        .state('Contact', {
            url: 'Contact',
            templateUrl: 'Contact.html'
        })
        .state('product', {
            url: '/product',
            templateUrl: 'product.html',
            controller:'productCtrl'
        })
       
        .state('Cart', {
            url: '/Cart',
            templateUrl: 'Cart.html',
            controller:'cartCtrl'
        })
        .state('productDetails', {
            url: '/product/:id',
            templateUrl: 'productDetails.html',
            controller:'productDetailsCtrl'
        })

}]);
homeApp.controller("logoutCtrl", function ($scope) {
    $scope.logout = function () {

        localStorage.clear();
        window.location.replace("login.html");

    }
});
// homeApp.controller("productCtrl", function ($scope, $http) {
//     $scope.products = [];
//     $scope.showProduct = function () {
//         $http.post("productApi.php").then(
//             function (response) {
//                 $scope.products = response.data.output;
//                 console.log($scope.products);
//             },function(error){

//             }
//         )
//     }
//     $scope.showProduct();
// })
// homeApp.controller("productDetailsCtrl",function($http,$scope,$stateParams){
// $scope.productDetails={};
// console.log($stateParams);
// $http({
//     url:"productDetailsApi.php",
//     method:"get",
//     params:{id:$stateParams.id}
// }).then(function(response){

//     $scope.productDetails=response.data.output;
//     console.log($scope.productDetails);

// })
// // function for add to cart
// $scope.addToCart=function(){
//   console.log(1254) 
//   var cartArray = localStorage.getItem('cart');
//            if(!cartArray){
//             cartArray = [];
//            }else{
//             cartArray = JSON.parse(cartArray);
//            }
      
        
//             const findProduct = cartArray.find(x => x.productid == $scope.productDetails.productid);
//             if(findProduct){
//                 findProduct.quantity = findProduct.quantity + 1;
//             }else{
//                 $scope.productDetails.quantity = 1;
//                 cartArray.push($scope.productDetails);
//             }
          

//             localStorage.setItem('cart',JSON.stringify(cartArray));   
//             alert('Added to Cart Successfully');
// }
// })
// // controller for cart page
// homeApp.controller("cartCtrl", function ($scope, $http) {
//     $scope.cartItems = JSON.parse(localStorage.getItem('cart'));
    
//     console.log($scope.cartItems);
//     $scope.placeOrder=function(){
//         window.alert('order placed successfully')
//         localStorage.removeItem('cart'); 
//         location.replace('index.html');
//     }

// })