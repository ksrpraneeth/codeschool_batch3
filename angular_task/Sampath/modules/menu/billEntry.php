<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.js"></script>
<script src="./assets/js/task.js"></script>
<div ng-app="app" ng-controller="mainController">
    <div class="billEntry bg-white h-100 w-100 overflow-auto p-3">
        <div class="gap-3 mb-2">
            <div class="title fs-4 fw-bold border-bottom py-2">
                Supplementary Bill
            </div>
        </div>

        <!-- New Bill Div -->
        <div class="newEmpDiv col-12 col-md-8 col-lg-6">
            <div class="sectionEmpSearch" id="sectionEmpSearch">
                <div class="filterDiv">
                    <div class="label">Search Filter Type</div>
                    <div class="filters d-flex gap-3 my-3">
                        <div class="form-check">
                            <input value="billID" ng-model="selectedFilter" id="billIdFilterOption"
                                class="form-check-input" type="radio" name="billIdFilter" />
                            <label class="form-check-label" for="billIdFilterOption">
                                Bill ID
                            </label>
                        </div>
                        <div class="form-check">
                            <input value="empCode" ng-model="selectedFilter" id="empCodeFilterOption"
                                class="form-check-input" type="radio" name="billIdFilter" />
                            <label class="form-check-label" for="empCodeFilterOption">
                                EmpCode
                            </label>
                        </div>
                        <div class="form-check">
                            <input value="accNo" ng-model="selectedFilter" id="bankAcNoFilterOption"
                                class="form-check-input" type="radio" name="billIdFilter" />
                            <label class="form-check-label" for="bankAcNoFilterOption">
                                Bank Ac No
                            </label>
                        </div>
                    </div>
                    <div class="filterInputDivs">
                        <div class="filterInputDiv"></div>
                    </div>
                </div>
                <div class="filterInputsDiv">
                    <div class="filterInput" ng-hide="selectedFilter != 'billID'">
                        <div class="label">Select Bill ID</div>
                        <div class="input">
                            <select name="" class="form-select" ng-model="searchQuery" ng-change="getEmployees()">
                                <option value="" hidden>Select</option>
                                <option value="{{ billId.id }}" ng-repeat="billId in billIDs">
                                    {{ billId.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="filterInput" ng-hide="selectedFilter != 'empCode'">
                        <div class="label">Enter Employee Code</div>
                        <div class="input">
                            <input type="text" name="" id="empCodeInput" class="form-control"
                                placeholder="Enter Employee Code" ng-model="searchQuery"
                                ng-keydown="$event.keyCode === 13 && getEmployees()" />
                        </div>
                    </div>

                    <div class="filterInput" ng-hide="selectedFilter != 'accNo'">
                        <div class="label">
                            Enter Employee Bank Account Number
                        </div>
                        <div class="input">
                            <input type="text" name="" id="empBankAcNo" class="form-control"
                                placeholder="Enter Employee Bank Account Number" ng-model="searchQuery"
                                ng-keydown="$event.keyCode === 13 && getEmployees()" />
                        </div>
                    </div>
                </div>
                <!-- Employee -->
                <div class="employeeDiv mt-3" ng-hide="searchQuery == '' || employees.length == 0">
                    <div class="label">Select Employee</div>
                    <select class="form-select" name="" ng-model="employee">
                        <option value="" hidden>Select Employee</option>
                        <option value="{{employee.id}}" ng-repeat="employee in employees">
                            {{employee.name}} - {{employee.emp_code}}
                        </option>
                    </select>
                </div>
                <div class="text-danger" id="sectionEmpSearchError"></div>
            </div>

            <!-- Details Div -->
            <div id="detailsDiv" class="mt-3" ng-hide="employee == ''">
                <div id="billMonthYearDiv" class="">
                    <div class="billMonthYear">
                        <div class="label">
                            <span>Select Month and Year</span>
                        </div>
                        <input type="month" name="" id="monthAndYear" class="form-control" ng-model="monthYear" />
                    </div>
                </div>

                <!-- Earnings and Deductions -->
                <div class="d-flex flex-column gap-3 mt-3">
                    <!-- earningDeductionType -->
                    <div class="addingsType">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="addingType" id="earningOption"
                                ng-model="earningDeductionType" value="earning" />
                            <label class="form-check-label" for="earningOption">
                                Earnings
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="addingType" id="deductionOption"
                                ng-model="earningDeductionType" value="deduction" />
                            <label class="form-check-label" for="deductionOption">
                                Deductions
                            </label>
                        </div>
                    </div>

                    <!-- Earning Select -->
                    <select class="form-select" ng-hide="addingType == '' || earningsDeductions.length == 0"
                        ng-model="earningAddingValue" id="addingOption">
                        <option value="" hidden>Select</option>
                        <option value="{{earningDeduction.id}}" ng-repeat="earningDeduction in earningsDeductions">
                            {{earningDeduction.name}}
                        </option>
                    </select>

                    <div class="mb-3" ng-hide="earningAddingValue == ''">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" placeholder="Amount" ng-model="amount"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                    </div>
                </div>
            </div>

            <button id="submitForm" class="btn btn-success mt-3" ng-click="addToCurrentBill()"
                ng-hide="employee == '' || monthYear == '' || !amount || amount == '0' || earningAddingValue == ''">
                Add To Bill
            </button>
        </div>

        <!-- Single Bill Table -->
        <div class="singleBillTablemt-5" ng-hide="currentBill.employee == ''">
            <div class="tableData overflow-auto">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Month & Year</th>
                            <th ng-hide="currentBill.earnings.length == 0" colspan="{{ currentBill.earnings.length }}">
                                Earnings
                            </th>
                            <th ng-hide="currentBill.deductions.length == 0"
                                colspan="{{ currentBill.deductions.length }}">
                                Deductions
                            </th>
                            <th>Total Earnings</th>
                            <th>Total Deductions</th>
                            <th>Total Net</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{currentBill.employee}}</td>
                            <td ng-repeat="earning in currentBill.earnings">
                                {{earning.name}}
                            </td>
                            <td ng-repeat="deduction in currentBill.deductions">
                                {{deduction.name}}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                {{currentBill.monthYear.getFullYear() + " -
                                " + (currentBill.monthYear.getMonth()+1)}}
                            </td>
                            <td ng-repeat="earning in currentBill.earnings">
                                <input type="text" class="form-control" style="width: 100px"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    ng-model="earning.amount" />
                            </td>
                            <td ng-repeat="deduction in currentBill.deductions">
                                <input type="text" class="form-control" style="width: 100px"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    ng-model="deduction.amount" />
                            </td>
                            <td>{{currentBill.earnings | sumOfArray}}</td>
                            <td>{{currentBill.deductions | sumOfArray}}</td>
                            <td>
                                {{(currentBill.earnings | sumOfArray) -
                                (currentBill.deductions | sumOfArray)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Lists -->
            <div class="row m-0">
                <div class="col-12 col-md-6">
                    <h5>Earnings</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="earning in currentBill.earnings">
                                <td>{{earning.name}}</td>
                                <td>{{earning.amount}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <h5>Deductions</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="deduction in currentBill.deductions">
                                <td>{{deduction.name}}</td>
                                <td>{{deduction.amount}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <button class="btn btn-primary" ng-click="addToSBill()">Add Employee Bill</button>
        </div>
        <!-- Supplementary Bill -->
        <div id="sBillTable" ng-hide="sBill.length == 0">
            <table class="table table-bordered mt-4" id="">
                <thead>
                    <tr class="fw-bold bg-dark text-white">
                        <td>Employee Code</td>
                        <td>Employee Name</td>
                        <td>Month</td>
                        <td>Year</td>
                        <td>Earnings Total</td>
                        <td>Deductions Total</td>
                        <td>Total</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody id="sBillTableBody">
                    <tr ng-repeat="bill in sBill">
                        <td>{{ bill.employee }}</td>
                        <td>{{ bill.empCode }}</td>
                        <td>{{ bill.month }}</td>
                        <td>{{ bill.year }}</td>
                        <td>{{ bill.earningsTotal }}</td>
                        <td>{{ bill.deductionsTotal }}</td>
                        <td>{{ bill.netTotal }}</td>
                        <td>
                            <button class="btn btn-dark" ng-click="showBill($index)" data-bs-toggle="modal"
                                data-bs-target="#viewEmployeeBillModal">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="submitButtonDiv d-flex justify-content-end">
                <button class="btn btn-dark" id="submitToDatabase" ng-click="submitBill()">
                    Submit Bill
                </button>
            </div>
        </div>

        <!-- View Employee Bill Modal -->
        <div class="modal modal-lg fade" id="viewEmployeeBillModal" aria-labelledby="viewEmpBillLabel" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-11 col-md-6">
                                <h6 class="title">Earnings</h6>
                                <div class="earningsTable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary bg-opacity-10">
                                                <th>Name</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="viewEarningsData">
                                            <tr ng-repeat="earning in viewBill.earnings">
                                                <td>{{earning.name}}</td>
                                                <td>{{earning.amount}}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Earnings</th>
                                                <th id="">
                                                    <span id="totalViewEarnings">{{viewBill.earnings |
                                                        sumOfArray}}</span>
                                                    .Rs/
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-11 col-md-6">
                                <h6 class="title">Deductions</h6>
                                <div class="earningsTable">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-danger bg-opacity-10">
                                                <th>Name</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="viewDeductionsData">
                                            <tr ng-repeat="deduction in viewBill.deductions">
                                                <td>{{deduction.name}}</td>
                                                <td>{{deduction.amount}}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Deductions</th>
                                                <th id="">
                                                    <span id="totalViewDeductions">{{viewBill.deductions |
                                                        sumOfArray}}</span>
                                                    .Rs/
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Total Text -->
                        <div class="totalDiv d-flex justify-content-end">
                            <strong>Total:&nbsp;</strong>
                            <strong id="viewTotalAmount">{{(viewBill.earnings | sumOfArray) - (viewBill.deductions |
                                sumOfArray)}}</strong>
                            <strong>&nbsp;.Rs/</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</html>