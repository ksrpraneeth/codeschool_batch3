var app = angular.module("app", ["ui.router"]).filter("sumColumn", function () {
  return function (dataSet, columnToSum) {
    let sum = 0;
    for (let i = 0; i < dataSet.length; i++) {
      sum += parseFloat(dataSet[i][columnToSum]) || 0;
    }
    return sum;
  };
});
//loader
app.run(function($rootScope){
  $rootScope.url='http://127.0.0.1:8000/api';
  $rootScope.loading=false;
  $rootScope.$on('httpRequest',function()
  {
    $rootScope.loading=true;
  });
  $rootScope.$on('httpResponse',function()
  {
    $rootScope.loading=false;
  });
})
app.factory('httpInterceptor',function($q,$rootScope){
  return{
    request:function(config){
      $rootScope.$emit('httpRequest');
      return config || $q.when(config);
    },
    response:function(response){
      $rootScope.$emit('httpResponse');
      return response|| $q.when(response);
    },
    responseError:function(rejection){
      $rootScope.$emit('httpResponse');
      return $q.reject(rejection);
    },
  }
})
app.config(
  function ($stateProvider,$httpProvider) {
    $stateProvider
      .state("addAgency", {
        url: "/addAgency",
        templateUrl: "addAgency.html",
      })
      .state("billEntry", {
        url: "/billEntry",
        templateUrl: "billEntry.html",
      })
      .state("viewbill", {
        url: "/viewbill?id",
        templateUrl: "viewbill.html",
      });
      $httpProvider.interceptors.push('httpInterceptor');
  });
//show edit and add agency
app.controller("AgencyController", function ($scope, $http,$rootScope) {
  $scope.edit = "false";
  $scope.ifscdetails = [];
  $scope.ifscError = "";
  $scope.agencyDetailsError = "";
  $scope.searchAgencyDetails = [];
  //fetch ifsc code details from db on button click
  $scope.IfscCodeBtn = function () {
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/ifsccode",
      data: {
        ifsc_code: $scope.ifsc_code,
      },
    }).then(
      function success(response) {
        if (response.data.status == true) {
          $scope.ifscdetails = response.data.data;
          $scope.ifscError = "";
          console.log(response.data.data);
        }
      },
      function error(response) {
        $scope.ifscdetails = "";
        $scope.ifscError =
          response.data.errors[Object.keys(response.data.errors)[0]][0];
      }
    );
  };
  //add agency details to db
  $scope.AgencyBtn = function () {
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/agencydetails",
      data: {
        agency_name: $scope.agency_name,
        account_number: $scope.account_number,
        account_number_confirmation: $scope.account_number_confirmation,
        ifsc_code: $scope.ifsc_code,
      },
    }).then(
      function success(response) {
        if (response.data.status == true) {
          $scope.agencyDetailsError = "";
          swal("Success", response.data.message, "success");
          console.log(response.data.data);
        } else {
          swal("Error", response.data.message, "error");
        }
      },
      function error(response) {
        $scope.agencyDetailsError = "";
        $scope.agencyDetailsError =
          response.data.errors[Object.keys(response.data.errors)[0]][0];
      }
    );
  };
  //
  //search agency details on entering account number
  $scope.accountNumber = "";
  $scope.InvalidAccNo = "";
  $scope.SearchAgencyBtn = function () {
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/searchagency",
      data: {
        account_number: $scope.accountNumber,
      },
    }).then(
      function success(response) {
        if (response.data.status == true) {
          $scope.InvalidAccNo = "";
          //Show and hide display details
          $scope.agencyDetailsDisplay = true;
          $scope.searchAgencyDetails = response.data.data;
          console.log(response.data.data);
        } else {
          $scope.InvalidAccNo = response.data.message;
          $scope.searchAgencyDetails = "";
        }
      },
      function error(response) {
        //
      }
    );
  };
  //Update existing agency details
  $scope.newAgencyNameError = "";
  $scope.UpdateAgencyBtn = function () {
    $http({
      method: "POST",
      url:
        "http://127.0.0.1:8000/api/updateagency/" +
        $scope.searchAgencyDetails.id,
      data: {
        agency_name: $scope.agency_name,
        ifsc_code: $scope.ifsc_code,
      },
    }).then(
      function success(response) {
        if (response.data.status == true) {
          $scope.newAgencyNameError = "";
          swal("Success", response.data.message, "success");
          console.log(response.data.data);
        } else {
          swal("Error", response.data.message, "error");
        }
      },
      function error(response) {
        $scope.newAgencyNameError =
          response.data.errors[Object.keys(response.data.errors)[0]][0];
      }
    );
  };
  //common hide show scope variables on change of page
  $scope.remove = function () {
    $scope.ifscError = "";
    $scope.ifscdetails = [];
    $scope.ifsc_code = "";
    $scope.searchAgencyDetails = [];
    $scope.accountNumber = "";
    $scope.agency_name = "";
    $scope.account_number = "";
    $scope.account_number_confirmation = "";
    $scope.agencyDetailsError = "";
    $scope.InvalidAccNo = "";
    $scope.gst = "";
    $scope.agencyDetailsDisplay = false;
  };
});
//Controller for bills
app.controller("BillController", function ($scope, $http, $filter, $state,$rootScope) {
  //scope variable for show and hide
  $scope.agencyListTable = false;
  //get form number into select box
  $http({
    method: "POST",
    url: "http://127.0.0.1:8000/api/getforms",
    data: {},
  }).then(
    function (response) {
      console.log(response.data.data);
      $scope.forms = response.data.data;
    },
    function error(response) {
      //
    }
  );

  //get form-type according to form-number_id into select box
  $scope.FormChange = function () {
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/getformtype",
      data: {
        form_number_id: $scope.formNumber,
      },
    }).then(
      function (response) {
        $scope.formtypes = response.data.data;
        console.log($scope.formtypes);
        console.log($scope.forms);
      },
      function error(response) {
        //
      }
    );
  };
  //get hoa according to form_type
  $scope.formTypeChanged = function () {
    if (!$scope.formType) {
      return;
    }
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/gethoaformtype",
      data: {
        form_type_id: $scope.formType,
      },
    }).then(
      function (response) {
        console.log(response.data.data[1]);
        $scope.hoanumbers = response.data.data[0];
        $scope.scrutinyitems = response.data.data[1];
      },
      function error(response) {
        //
      }
    );
  };
  //search agency details on entering account number
  $scope.accountNumber = "";
  $scope.InvalidAccNo = "";
  $scope.form_type = "";
  $scope.searchAgencyDetails = {};
  $scope.SearchAgencyBtn = function () {
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/searchagency",
      data: {
        account_number: $scope.accountNumber,
      },
    }).then(
      function success(response) {
        if (response.data.status == true) {
          $scope.InvalidAccNo = "";
          //Show and hide display details
          $scope.searchAgencyDetails = response.data.data;
          console.log(response.data.data);
        } else {
          $scope.InvalidAccNo = response.data.message;
          $scope.searchAgencyDetails = "";
        }
      },
      function error(response) {
        //
      }
    );
  };
  //add agency list details into table
  $scope.gross = 0;
  $scope.ptdedn = 0;
  $scope.tds = 0;
  $scope.gst = 0;
  $scope.gis = 0;
  $scope.thn = 0;
  //show dynamic net amount
  $scope.NetAmtChange = function () {
    $scope.netamt =
      parseInt($scope.gross) -
      parseInt($scope.ptdedn) -
      parseInt($scope.tds) -
      parseInt($scope.gst) -
      parseInt($scope.gis) -
      parseInt($scope.thn);
  };
  $scope.AgencyLists = [];
  $scope.addAgencyTableBtn = function () {
    if ($scope.gross <= 0) {
      swal("Error", "Please enter gross amount.", "error");
    } else {
      $scope.netamt =
        parseInt($scope.gross) -
        parseInt($scope.ptdedn) -
        parseInt($scope.tds) -
        parseInt($scope.gst) -
        parseInt($scope.gis) -
        parseInt($scope.thn);
      $scope.AgencyLists.push({
        agency_name: $scope.searchAgencyDetails.agency_name,
        account_number: $scope.searchAgencyDetails.account_number,
        bank_name: $scope.searchAgencyDetails.agency_ifsc.bank_name,
        bank_branch: $scope.searchAgencyDetails.agency_ifsc.branch,
        ifsc_code: $scope.searchAgencyDetails.agency_ifsc.ifsc_code,
        gross: $scope.gross,
        ptdedn: $scope.ptdedn,
        tds: $scope.tds,
        gst: $scope.gst,
        gis: $scope.gis,
        thn: $scope.thn,
        netamt: $scope.netamt,
      });
      $scope.searchAgencyDetails = {};
      $scope.gross = 0;
      $scope.ptdedn = 0;
      $scope.tds = 0;
      $scope.gst = 0;
      $scope.gis = 0;
      $scope.thn = 0;
      $scope.netamt = 0;
    }
  };
  //delete particular agency list row of table on click of button
  $scope.deleteRow = function (i) {
    $scope.AgencyLists.splice(i, 1);
  };
  //add files
  $scope.attachmentsArray = [];
  $scope.files = [];
  $scope.addFileBtn = function () {
    console.log($scope.remarks);
    let file = document.getElementById("attachments").files[0];
    if (file == undefined) {
      swal("error", "Please Select File", "error");
      return;
    }
    $scope.attachmentsArray.push({
      path: file.name,
      remarks: $scope.remarks || "",
    });
    $scope.files.push(file);
    document.getElementById("attachments").value = null;
    $scope.remarks = "";
  };
  $scope.removeFile = function (i) {
    $scope.attachmentsArray.splice(i, 1);
  };
  $scope.reference_number = "";
  $scope.purpose = "";
  $scope.HoaForm = "";
  //get details of the whole bill form on clicking submit button
  $scope.SubmitBtn = function () {
    let data = {
      form_number: $scope.formNumber,
      form_type: $scope.formType,
      agency_account_number: $scope.accountNumber,
      hoa: $scope.HoaForm,
      reference_number: $scope.reference_number,
      purpose: $scope.purpose,
      agency_details: JSON.stringify($scope.AgencyLists),
      scrutiny_response: JSON.stringify($scope.scrutinyitems),
      attachments_array: JSON.stringify($scope.attachmentsArray),
      gross: $filter("sumColumn")($scope.AgencyLists, "gross"),
      ptdedn: $filter("sumColumn")($scope.AgencyLists, "ptdedn"),
      tds: $filter("sumColumn")($scope.AgencyLists, "tds"),
      gst: $filter("sumColumn")($scope.AgencyLists, "gst"),
      gis: $filter("sumColumn")($scope.AgencyLists, "gis"),
      thn: $filter("sumColumn")($scope.AgencyLists, "thn"),
      netamt: $filter("sumColumn")($scope.AgencyLists, "netamt"),
    };
    let formData = new FormData();
    for (let ele in data) {
      formData.append(ele, data[ele]);
    }
    $scope.files.forEach((file) => {
      formData.append("files[]", file);
    });
    //to get details of all values
    $http({
      method: "POST",
      url: "http://127.0.0.1:8000/api/transactiondetails",
      headers: { "Content-Type": undefined },
      transformRequest: angular.identity,
      data: formData,
    })
      .then(function (response) {
        console.log(response.data.message);

        if (response.data.status == true) {
          console.log(response.data);
          swal("Success", response.data.message, "success");
          $state.go("viewbill", { id: response.data.data });
        } else {
          // console.log(response.data.errors[Object.keys(response.data.errors)[0]][0]);
          swal(
            "Error",
            response.data.errors[Object.keys(response.data.errors)[0]][0],
            "error"
          );
        }
      })
      .catch(function (response) {
        console.log(response.data.message);
        swal(
          "Error",
          response.data.errors[Object.keys(response.data.errors)[0]][0],
          "error"
        );
      });
  };
});

//controllwe for view bill

app.controller("viewBillController", function ($scope, $http, $stateParams) {
  $scope.referenceNumber='';

  $http({
    method: "POST",
    url: "http://127.0.0.1:8000/api/billDetails",
    data: {
      id: $stateParams.id,
    },
  })
    .then(function (response) {
      console.log(response.data.message);
      if (response.data.status == true) {
        console.log(response.data.data);
        console.log($scope.referenceNumber);
        $scope.billDetails = response.data.data.transaction;
        // $scope.referenceNumber=$scope.billDetails[0](reference _number);
        $scope.agencyBillDetails = response.data.data.agenciesDetailBill;
      } else {
        // console.log(response.data.errors[Object.keys(response.data.errors)[0]][0]);
        swal(
          "Error",
          response.data.errors[Object.keys(response.data.errors)[0]][0],
          "error"
        );
      }
    })
    .catch(function (response) {
      console.log(response);
      swal(
        "Error",
        response.data.errors[Object.keys(response.data.errors)[0]][0],
        "error"
      );
    });
});
