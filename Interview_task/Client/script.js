let app = angular.module('bill', ['ui.router']);
app.config(function ($stateProvider) {
	$stateProvider
		.state('addBill', {
			url: '/addBill',
			templateUrl: 'addBill.html'
		});
});

app.controller('AddBillController', function ($scope, $http) {
	$scope.found = false;
	$scope.employeeDetails = [];
	$scope.searchEmployee = function () {
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getEmployeeDetails',
			data: {
				id: $scope.employeeCode
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.employeeDetails = response.data.data;
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
	}
	$scope.getTypes = function () {
		if (!$scope.fromDate || !$scope.toDate) {
			swal('error', 'Please Select Dates', 'error');
			$scope.typeSelect = '';
			return;
		}
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getTypeForms',
			data: {
				id: $scope.typeSelect
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.details = response.data.data;
					$scope.forms = true;
				} else {
					swal('error', response.data.message, 'error');
					$scope.details = {};
					$scope.forms = false;
				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					swal('error', response.data.errors[(Object.keys(response.data.errors))[0]][0], 'error');
					$scope.details = {};
					$scope.forms = false;
				}
			)
	}
	$scope.typesBill = [];
	$scope.displayEarnings = [];
	$scope.displayDeductions = [];
	$scope.totalEarnings = [];
	$scope.totalDeductions = [];
	$scope.earningStatus = false;
	$scope.deductionStatus = false;
	$scope.addBill = function () {
		$scope.index = 1;
		if (!$scope.typeFormSelect) {
			swal('error', 'Please Select Type', 'error');
			return;
		}
		if ($scope.amountInput > 0) {
			for (let i = 0; i < $scope.displayEarnings.length; i++) {
				let element = $scope.displayEarnings[i];
				if (element.typeForm == $scope.typeFormSelect) {
					$scope.earningStatus = true;
				}
			}
			for (let i = 0; i < $scope.displayDeductions.length; i++) {
				let element = $scope.displayDeductions[i];
				if (element.typeForm == $scope.typeFormSelect) {
					$scope.deductionStatus = true;
				}
			}
			for (let i = 0; i < $scope.typesBill.length; i++) {
				let element = $scope.typesBill[i];
				if (element.fromDate == $scope.fromDate && element.toDate == $scope.toDate) {
					if ($scope.typeSelect == '1') {
						for (let j = 0; j < $scope.typesBill[i].earnings.length; j++) {
							let element = $scope.typesBill[i].earnings[j];
							if (element.typeForm == $scope.typeFormSelect) {
								swal('error', 'Type Already Exists', 'error');
								return;
							}
						}
						$scope.typesBill[i].earnings.push({
							typeForm: $scope.typeFormSelect,
							amount: $scope.amountInput,
						});
						$scope.totalEarnings.push({
							typeForm: $scope.typeFormSelect,
							amount: $scope.amountInput,
						});
						if (!$scope.earningStatus) {
							$scope.displayEarnings.push({
								typeForm: $scope.typeFormSelect
							});
						}
					}
					else {
						for (let j = 0; j < $scope.typesBill[i].deductions.length; j++) {
							let element = $scope.typesBill[i].deductions[j];
							if (element.typeForm == $scope.typeFormSelect) {
								swal('error', 'Type Already Exists', 'error');
								return;
							}
						}
						$scope.typesBill[i].deductions.push({
							typeForm: $scope.typeFormSelect,
							amount: $scope.amountInput,
						});
						$scope.totalDeductions.push({
							typeForm: $scope.typeFormSelect,
							amount: $scope.amountInput,
						});
						if (!$scope.deductionStatus) {
							$scope.displayDeductions.push({
								typeForm: $scope.typeFormSelect
							});
						}
					}
					return;
				}
			};

			if ($scope.typeSelect == '1') {
				$scope.typesBill.push({
					employee_id: $scope.employeeDetails.id,
					fromDate: $scope.fromDate,
					toDate: $scope.toDate,
					earnings: [
						{
							typeForm: $scope.typeFormSelect,
							amount: $scope.amountInput,
						}
					],
					deductions: []
				});
				$scope.totalEarnings.push({
					typeForm: $scope.typeFormSelect,
					amount: $scope.amountInput,
				});
				if (!$scope.earningStatus) {
					$scope.displayEarnings.push({
						typeForm: $scope.typeFormSelect
					});
				}
			}
			else {
				$scope.typesBill.push({
					employee_id: $scope.employeeDetails.id,
					fromDate: $scope.fromDate,
					toDate: $scope.toDate,
					deductions: [
						{
							typeForm: $scope.typeFormSelect,
							amount: $scope.amountInput,
						}
					],
					earnings: []
				});
				$scope.totalDeductions.push({
					typeForm: $scope.typeFormSelect,
					amount: $scope.amountInput,
				});
				if (!$scope.deductionStatus) {
					$scope.displayDeductions.push({
						typeForm: $scope.typeFormSelect
					});
				}
			}
			$scope.typeFormSelect = '';
			$scope.amountInput = '';
			$scope.typeSelect = '';
			$scope.earningSum = {};
			$scope.totalEarnings.forEach(function (item) {
				if ($scope.earningSum[item.typeForm]) {
					$scope.earningSum[item.typeForm] += item.amount;
				} else {
					$scope.earningSum[item.typeForm] = item.amount;
				}
			})
			$scope.deductionSum = {};
			$scope.totalDeductions.forEach(function (item) {
				if ($scope.deductionSum[item.typeForm]) {
					$scope.deductionSum[item.typeForm] += item.amount;
				} else {
					$scope.deductionSum[item.typeForm] = item.amount;
				}
			})
		}
		else {
			swal('error', 'Please Enter Amount', 'error');
		}
		console.log($scope.typesBill);
	}

	$scope.getEarning = function (earnings, typeForm) {
		let index = earnings.findIndex((e) => {
			return e.typeForm == typeForm
		})
		return index == -1? '0' : earnings[index].amount;
	}
	$scope.getEarning = function (earnings, typeForm) {
		let index = earnings.findIndex((e) => {
			return e.typeForm == typeForm
		})
		return index == -1? '0' : earnings[index].amount;
	}
	$scope.getDeduction = function (deductions, typeForm) {
		let index = deductions.findIndex((e) => {
			return e.typeForm == typeForm
		})
		return index == -1? ' ' : deductions[index].amount;
	}

	$scope.submitBill = function () {
		let data = {
			'employee_id': $scope.employeeDetails.id,
			'types_bill': JSON.stringify($scope.typesBill),
			'total_deduction': JSON.stringify($scope.totalDeductions),
			'total_earnings': JSON.stringify($scope.totalEarnings),
		};
		let formData = new FormData();
		for (let ele in data) {
			formData.append(ele, data[ele]);
		}
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/submitBill',
			headers: { 'Content-Type': undefined },
			transformRequest: angular.identity,
			data: formData
		})
	}
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
