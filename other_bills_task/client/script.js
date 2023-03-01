let app = angular.module('ifmis', ['ui.router'])

app.config(['$stateProvider', function ($stateProvider) {
	$stateProvider
		.state('addAgency', {
			url: '/addAgency',
			templateUrl: 'addAgency.html'
		});
	$stateProvider
		.state('billEntry', {
			url: '/billEntry',
			templateUrl: 'billEntry.html'
		});
	$stateProvider
		.state('viewBill', {
			url: '/viewBill?id',
			templateUrl: 'viewBill.html'
		});
}
]);

app.controller('AddAgencyController', function ($scope, $http) {
	$scope.editable = "false";
	$scope.clear = function () {
		$scope.ifscCodeInput = "",
			$scope.error = '',
			$scope.agencyError = '',
			$scope.details = [];
		$scope.agencyDetails = [];
		$scope.found = false;
		$scope.ifsc = false;
	}
	$scope.check = function () {
		if ($scope.bankAccountNumberInput != $scope.confirmBankAccountNumberInput) {
			swal('error', "Account Number doesn't Match", 'error');
		}
	}
	$scope.searchIfscCode = function () {
		$scope.ifsc = false;
		console.log($scope.ifscCodeInput);
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getIfscCodeDetails',
			data: {
				ifsc_code: $scope.ifscCodeInput
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.details = response.data.data;
					$scope.error = '';
					$scope.ifsc = true;
				} else {
					$scope.error = response.data.message;
					$scope.details = {};
					$scope.ifsc = false;
				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					$scope.error = response.data.errors[(Object.keys(response.data.errors))[0]][0];
					$scope.details = ''
				}
			)
	}
	$scope.addAgency = function () {
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/addAgency',
			data: {
				name: $scope.agencyNameInput,
				account_number: $scope.bankAccountNumberInput,
				account_number_confirmation: $scope.confirmBankAccountNumberInput,
				ifsc_code: $scope.ifscCodeInput
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					// alertMessage(response.data.message);
					swal("Success", response.data.message, "success");
				} else {
					// alert(response.data.message);
					swal("Error", response.data.message, "error");

				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					// alert(response.data.message);
					swal("Error", response.data.errors[(Object.keys(response.data.errors))[0]][0], "error");

				}
			)
	}
	$scope.found = false;
	$scope.ifsc = false;
	$scope.searchAgency = function () {
		$scope.found = false;
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getAgency',
			data: {
				account_number: $scope.accountNumber
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.agencyDetails = response.data.data;
					$scope.agencyError = '';
					$scope.found = true;
				} else {
					swal('error', response.data.message, 'error');
					$scope.agencyDetails = {};
				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					swal('error', response.data.errors[(Object.keys(response.data.errors))[0]][0], 'error');
					$scope.agencyDetails = ''
				}
			)
		$scope.editAgency = function () {
			if (!$scope.ifsc) {
				swal("Error", "Please Validate the IFSC Code", "error");
				return;
			}
			$http({
				method: 'POST',
				url: 'http://127.0.0.1:8000/api/editAgency/' + $scope.agencyDetails.id,
				data: {
					name: $scope.agencyName,
					ifsc_code: $scope.ifscCodeInput
				},
			}).then(
				function (response) {
					if (response.data.status == true) {
						swal("Success", response.data.message, "success");
					} else {
						swal("Error", response.data.errors[(Object.keys(response.data.errors))[0]][0], "error");
					}
				}).catch(
					function (response) {
						// console.log($scope.ifscCodeInput);
						swal("Error", response.data.errors[(Object.keys(response.data.errors))[0]][0], "error");
					}
				)
		}

	}
});

app.controller('AddBillController', function ($scope, $http, $filter, $state) {
	$scope.formDetails = [];
	$scope.found = false;
	$http({
		method: 'POST',
		url: 'http://127.0.0.1:8000/api/getFormNumber',
	}).then(
		function (response) {
			if (response.data.status == true) {
				$scope.formDetails = response.data.data;
			} else {
				console.log(response);
				// alertMessage(response.data.message);
			}
		}
	).catch(
		function (response) {
			alert(response.data.message);
		}
	)
	$scope.getFormType = function () {
		$scope.clear();
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getFormType',
			data: {
				form_number_id: $scope.formNumberSelect
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.formTypes = response.data.data;
				} else {
					console.log(response);
				}
			}
		).catch(
			function (response) {
				console.log(response.data.message);
			}
		)
	}
	$scope.searchAgency = function () {
		$scope.clearAgencyDetails();
		$scope.found = false;
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getAgency',
			data: {
				account_number: $scope.accountNumber
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.agencyDetails = response.data.data;
					$scope.IfscDetails = response.data.ifsc;
					$scope.agencyError = '';
					$scope.accountNumber = '';
					$scope.found = true;
					$scope.billList == true;
				} else {
					swal('error', response.data.message, 'error');
					$scope.agencyDetails = {};
					$scope.found = false;
					$scope.billList == false;
				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					swal('error', response.data.errors[(Object.keys(response.data.errors))[0]][0], 'error');
					$scope.agencyDetails = ''
				}
			)
	}
	$scope.agencyBill = [];
	$scope.gross = 0;
	$scope.bill = [];
	$scope.ptDeduction = 0;
	$scope.tdsIt = 0;
	$scope.gst = 0;
	$scope.gis = 0;
	$scope.telanganaHarithaNidhi = 0;
	$scope.netAmount = 0;
	$scope.billList = false;
	$scope.updateNetAmount = function () {
		$scope.netAmount = parseInt($scope.gross) + parseInt($scope.ptDeduction) + parseInt($scope.tdsIt) + parseInt($scope.gst) + parseInt($scope.gis) + parseInt($scope.telanganaHarithaNidhi);
	}
	$scope.addBill = function () {
		// $scope.agencyBill.forEach(element => {
		// 	if (element.account_number == $scope.agencyBill.agency_account_number) {
		// 		swal("Error", "Agency Already Added", "error");
		// 		return;
		// 	}
		// });
		console.log($scope.gis);
		if ($scope.gross > 0 && !isNaN($scope.netAmount)) {
			$scope.billList = true;
			$scope.found = false;
			$scope.agencyBill.push({
				'agency_name': $scope.agencyDetails.name,
				'agency_account_number': $scope.agencyDetails.account_number,
				'agency_bank_name': $scope.agencyDetails.bank_ifsc.bank_name,
				'agency_branch': $scope.agencyDetails.bank_ifsc.branch,
				'agency_ifsc_code': $scope.agencyDetails.bank_ifsc.ifsc_code,
				'agency_gross': $scope.gross,
				'agency_pt_deduction': $scope.ptDeduction,
				'agency_tdsIt': $scope.tdsIt,
				'agency_gst': $scope.gst,
				'agency_gis': $scope.gis,
				'agency_telangana_haritha_nidhi': $scope.telanganaHarithaNidhi,
				'agency_net_amount': $scope.netAmount
			});
		}
		else {
			swal("Error", "All Fields are Required", "error");
		}
	}
	$scope.clearAgencyDetails = function () {
		$scope.gross = '';
		$scope.ptDeduction = 0;
		$scope.tdsIt = 0;
		$scope.gst = 0;
		$scope.gis = 0;
		$scope.telanganaHarithaNidhi = 0;
		$scope.netAmount = 0;
		$scope.agencyDetails = {};
	}
	$scope.scrutinyAnswers = [];
	$scope.getHoaScrutinyItems = function () {
		$scope.clear();
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getHoaScrutinyItems',
			data: {
				form_type_id: $scope.formTypeSelect
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.hoaDetails = response.data.data.hoas;
					response.data.data.scrutinyItems.forEach(element => {
						$scope.scrutinyAnswers.push({
							'description': element.description,
							'answer': 'yes'
						});
					});
				} else {
					console.log(response);
				}
			}
		).catch(
			function (response) {
				console.log(response.data.message);
			}
		)
	}
	$scope.removeEntry = function (i) {
		$scope.agencyBill.splice(i, 1);
	}
	$scope.attachmentsArray = [];
	$scope.files = [];
	$scope.addFile = function () {
		console.log($scope.remarks);
		let file = document.getElementById('attachments').files[0];
		if (file == undefined) {
			swal('error', 'Please Select File', 'error');
			return;
		}
		$scope.attachmentsArray.push({
			path: file.name,
			'remarks': $scope.remarks || ''
		});
		$scope.files.push(file)
		document.getElementById("attachments").value = null;
		$scope.remarks = '';
	}
	$scope.removeFile = function (i) {
		$scope.attachmentsArray.splice(i, 1);
	}
	$scope.clear = function () {
		$scope.agencyBill = [];
		$scope.attachmentsArray = [];
		$scope.scrutinyAnswers = [];
		$scope.billList = false;
		$scope.found = false;
		$scope.selectHoa = '';
		$scope.referenceNumber = '';
		$scope.purpose = '';
		$scope.serviceHead = '';
	}
	$scope.otp = false;
	$scope.generateOtp = function () {
		if ($scope.phoneNumber == null) {
			swal('error', 'Please Select Mobile Number', 'error');
			return;
		}
		$scope.otp = true;
	}
	$scope.otpVerified = false;
	$scope.verifyOtp = function () {
		if (($scope.otpInput.length) < 4) {
			swal('error', 'Invalid Otp', 'error');
		}
		else {
			swal('success', 'Otp Verified', 'success');
			$scope.otpVerified = true;
		}
	}
	$scope.submitBill = function () {
		if ((document.getElementById('attachments').files[0]) != null) {
			swal('error', 'Please Add the File Before Submitting', 'error');
			return;
		}
		if (!$scope.otpVerified) {
			swal('error', 'Please Verify Otp Before Submitting', 'error');
			return;
		}
		console.log($scope.selectHoa)
		let data = {
			form_number: $scope.formNumberSelect,
			form_type: $scope.formTypeSelect,
			agency_bill: JSON.stringify($scope.agencyBill),
			hoa: $scope.selectHoa,
			reference_number: $scope.referenceNumber,
			purpose: $scope.purpose,
			otp:$scope.otpVerified,
			scrutiny_answers: JSON.stringify($scope.scrutinyAnswers),
			attachments_array: JSON.stringify($scope.attachmentsArray),
			gross: $filter('sumOfValue')($scope.agencyBill, 'agency_gross'),
			pt_deduction: $filter('sumOfValue')($scope.agencyBill, 'agency_pt_deduction'),
			tds: $filter('sumOfValue')($scope.agencyBill, 'agency_tdsIt'),
			gst: $filter('sumOfValue')($scope.agencyBill, 'agency_gst'),
			gis: $filter('sumOfValue')($scope.agencyBill, 'agency_gis'),
			telangana_haritha_nidhi: $filter('sumOfValue')($scope.agencyBill, 'agency_telangana_haritha_nidhi'),
			net_amount: $filter('sumOfValue')($scope.agencyBill, 'agency_net_amount'),
		};
		let formData = new FormData();
		for (let ele in data) {
			formData.append(ele, data[ele]);
		}
		$scope.files.forEach(file => {
			formData.append('files[]', file);
		})
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/submitBill',
			headers: { 'Content-Type': undefined },
			transformRequest: angular.identity,
			data: formData
		}).then(
			function (response) {
				if (response.data.status == true) {
					swal("Success", response.data.message, "success");
					$scope.clear();
					$state.go('viewBill', { id: response.data.data });
				} else {
					console.log(response.data.message);
					swal("Error", response.data.message, "error");

				}
			}).catch(
				function (response) {
					console.log(response.data.errors[0]);
					swal("Error", response.data.errors[(Object.keys(response.data.errors))[0]][0], "error");
				}
			)
	}
});

app.controller('ViewBillController', function ($scope, $http, $stateParams) {
	$http({
		method: 'POST',
		url: 'http://127.0.0.1:8000/api/getTransactionDetails',
		data: {
			id: $stateParams.id
		},
	}).then(
		function (response) {
			if (response.data.status == true) {
				$scope.billData = response.data.data.transaction;
				$scope.agencyBill = response.data.data.agenciesBill;
			} else {
				console.log(response);
				swal('Error',response.data.message,'error');
			}
		}).catch(
			function (response) {
				console.log(response.data.errors[(Object.keys(response.data.errors))[0]][0])
			}
		)
});

app.filter('sumOfValue', function () {
	return function (data, key) {
		if (angular.isUndefined(data) || angular.isUndefined(key))
			return 0;
		var sum = 0;
		angular.forEach(data, function (value) {
			sum = sum + parseInt(value[key], 10);
		});
		return sum;
	}
});

app.filter('numberToWord', function () {
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
	}

});


