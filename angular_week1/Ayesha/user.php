<?php
session_start();
if(!isset($_SESSION['userId'])){
    header("Location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>IFMIS</title>

        <!-- Boostrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
            crossorigin="anonymous"
        />
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"
        ></script>
        <!-- Jquery -->
        <script
            src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous"
        ></script>
        <!--Angular-->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="style.css" />

    
    </head>
    <body ng-app="app">
        <!-- Main -->
        <div class="main">
            <!-- Sidebar -->
            <div id="sidebar" class="sidebar overflow-auto">
                <div class="sidebarHeader p-2 d-flex flex-column justify-content-center text-white text-center">
                    <i class="bi bi-person-fill"></i>
                    <p class="username" id="username" ng-controller="menuController">
                       {{profilename}}
                    </p>
                    <p id="id">(3065)</p>
                    <a href="#" class="text-white-50 mt-2 text-decoration-none">View Profile</a>
                    <a href="#" class="text-white-50 mb-2 text-decoration-none">Change Password</a>
                </div>
                <!-- Menu -->
                <ul class="menu list-unstyled text-white" ng-controller="menuController">
                    <li class="px-2 py-2" ng-repeat="menu in menus">{{menu.name}}</li>
                </ul>
            </div>
            <!-- Body -->
            <div class="body text-warning overflow-auto">
                <!-- Header -->
                <div class="header  d-flex align-items-center justify-content-center justify-content-md-between">
                    <!--left side of header-->
                    <div class="left d-flex align-items-center">
                        <!-- Menu Button -->
                        <div class="menuBtn fs-3" id="sidebarToggler" role="button">
                            <i class="bi bi-list"></i>
                        </div>
                        <!--IFMIS Logo -->
                        <img src="https://d20exy1ygbh3sg.cloudfront.net/fms/images/newUi/ifmis-logo.png" alt="" class="d-none d-md-block img-fluid"/>
                        <!-- Modules Button -->
                        <div class="modulesBtn p-2  align-items-center d-flex d-none d-md-block">
                            <i class="bi bi-boxes"></i>
                            <span>Modules</span>
                        </div>
                    </div>
                    <!-- right side of header -->
                    <div class="right">
                        <!-- Logout Button -->
                        <div class="logoutBtn d-flex align-items-center" ng-click="logout()">                 
                        <a href="logout.php" class="nav-link" >Logout</a>
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                    </div>
                </div>
                <!-- Content -->
                <div class="content container p-4 text-dark">
                    <!-- Top-->
                    <div class="topbar d-flex align-items-center">
                        <button class="btn btn-dark">
                            <i class="bi bi-arrow-left"></i>
                            <span>Back</span>
                        </button>
                        <div class="details">
                            <span class="fs-6 fw-bold">Ayesha Fatima/3065</span>
                        </div>
                    </div>
                    <!-- Section -->
                    <div class="section row mt-3" ng-controller="menuController" ng-init="formEdit=false">
                        <!-- Left of section -->
                        <div class="left col-lg-8 col-md-7 col-12 p-0">
                            <!-- Title -->
                            <p class="title fs-6 fw-bold m-0">
                                Pension details
                            </p>
                            <!-- Pension details -->
                            <div class="bg-white p-3 d-flex flex-column gap-4 table">
                                <!--ROW1-->
                                <div class="row">
                                    <!-- PPO ID -->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            PPO ID: 
                                        </div>
                                        <!-- Value -->
                                        <div class="value fw-bolder" id="ppo_id"  ng-show="!formEdit">
                                            {{data.ppoid}}
                                        </div>
                                        <div class="value fw-bolder" id="ppo_id"  ng-show="formEdit">
                                            <input type="text" id="ppoid" required ng-model="data.ppoid">
                                        </div>
                                        <div class="text-danger">{{ppoidError}}</div>
                                    </div>
                                    <!-- PPO Number -->
                                    <div class="col-12 col-md-4">
                                        <!-- Label -->
                                        <div class="title fw-semibold text-secondary">
                                            PPO Number:
                                        </div>
                                        <!-- Value -->
                                        <div class="value fw-bolder" id="ppo_number"  ng-show="!formEdit">
                                          {{data.pension}}
                                        </div>
                                        <div class="value fw-bolder" id="ppo_id"  ng-show="formEdit">
                                            <input type="text"id="ppension" ng-model="data.pension">
                                        </div>
                                        <div class="text-danger">{{ppoNumError}}</div>
                                    </div>
                                    <!--Pension Type-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            Pension Type:
                                            {{data.pension}}
                                        </div>
                                        <div class="value fw-bolder text-primary" id="type">
                                        </div>
                                    </div>
                                </div>
                                <!--ROW2-->
                                <div class="row">
                                    <!--Pension Category-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            PENSION CATEGORY:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="pensioncategory"   ng-show="!formEdit">
                                          {{data.pension}}
                                        </div>
                                        <div class="value fw-bolder" id="ppo_id"  ng-show="formEdit">
                                            <input type="text" id="pension" ng-model="data.pension">
                                        </div>
                                        <div class="text-danger">{{pensionError}}</div>
                                    </div>
                                    <!--date of recruitment-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            Date of Recruitment:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="recruitment" ng-show="!formEdit">
                                            {{data.dor}}
                                        </div>
                                        <div class="value fw-bolder" id="ppo_id"  ng-show="formEdit">
                                            <input type="text" id="dor" ng-model="data.dor">
                                        </div>
                                        <div class="text-danger">{{dorError}}</div>
                                    </div>
                                </div>
                                <!--ROW3-->
                                <div class="row">
                                    <!--Pension start date-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            PENSION START DATE:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="pensiondate" ng-show="!formEdit">
                                            {{data.startDate}}
                                        </div>
                                        <div class="value fw-bolder" id="ppo_id"  ng-show="formEdit">
                                            <input type="text" id="startDate" ng-model="data.startDate">
                                        </div>
                                        <div class="text-danger">{{startDateError}}</div>
                                    </div>
                                    <!--efp-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            EFP UPTO:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="efp" ng-show="!formEdit">
                                          {{data.efp}}
                                        </div>
                                        <div class="value fw-bolder" id="ppo_id"  ng-show="formEdit">
                                            <input type="text" id="efp" ng-model="data.efp">
                                        </div>
                                        <div class="text-danger">{{efpError}}</div>
                                    </div>
                                </div>
                                
                                <!--ROW4-->
                                <div class="row">
                                    <!--scale-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            SCALE TYPE:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="scaletype" ng-show="!formEdit">
                                           {{data.scaleType}}
                                        </div>
                                        <div class="value fw-bolder" id="ppo_id"  ng-show="formEdit">
                                            <input type="text"  id="scaleType" ng-model="data.scaleType">
                                        </div>
                                        <div class="text-danger">{{scaleError}}</div>
                                    </div>
                                    <!--state>-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            State:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="state">
                                            {{data.state}}
                                        </div>
                                    </div>
                                </div>
                                <!--ROW5-->
                                <div class="row">
                                    <!--PRC-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            PRC:
                                        </div>
                                        <!--label-->
                                        <div class="value fw-bolder" id="prc">{{data.prc}}</div>
                                    </div>
                                    <!--fp dod-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            FP DOD:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="fp">{{data.fp}}</div>
                                    </div>
                                </div>
                                <!--ROW6-->
                                <div class="row">
                                    <!--family pensioner-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            Family Pensioner Name:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="pensionname"  ng-if="!formEdit">
                                          {{data.familyPensionName}}
                                        </div>
                                        <div class="value fw-bolder" id="pensionname"  ng-if="formEdit">
                                            <input type="text" id="familyPensionName" ng-model="data.familyPensionName">
                                          </div>
                                          <div class="text-danger">{{nameError}}</div>
                                    </div>
                                    <!--HOA-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                        HOA:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="hoa">
                                         {{data.hoa}}
                                        </div>
                                    </div>
                                </div>
                                <!--ROW7-->
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            PRESENT BASIC:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder text-primary" id="presentbasic">
                                            {{data.presentBasic}}
                                        </div>
                                    </div>
                                    <!--cvp amount-->
                                    <div class="col-12 col-md-4">
                                        <div class="title fw-semibold text-secondary">
                                            CVP Amount:
                                        </div>
                                        <!--value-->
                                        <div class="value fw-bolder" id="cvp" >{{data.cvp}}</div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <div class="lightBlueBackground p-3">
                                <div class="detailsGroup fw-semibold">
                                    <div class="title">
                                        <!--NFP-->
                                        NFP (NORMAL SERVICE PENSION):
                                    </div>
                                    <div class="value">
                                        0 (Comp:- 0.00) (TG:- 0.00) (AP:- 0.00)
                                    </div>
                                </div>
                                <div class="detilsGroup fw-semibold">
                                    <div class="title">
                                        <!--EFP-->
                                        EFP (ENHANCED SERVICE PENSION):
                                    </div>
                                    <div class="value">
                                        0 (Comp:- 0.00) (TG:- 0.00) (AP:- 0.00)
                                    </div>
                                </div>
                                <div class="detilsGroup fw-semibold">
                                    <div class="title">
                                        <!--FP-->
                                        FP (FAMILY PENSION):
                                    </div>
                                    <div class="value">
                                        6432 (Comp:- 0.00) (TG:- 0.00) (AP:-
                                        0.00)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right side of content -->
                        <div class="col-lg-4 col-md-5 col-12 right">
                            <div class="actions">
                                <!-- Status -->
                                <div class="title d-flex gap-2 align-items-center">
                                    <span class="fw-bold fs-6">Status</span>
                                    <div role="button" class="edit text-success fw-semibold">
                                        <span ng-show="formEdit==false" ng-click="formEdit=true">Edit</span>
                                    </div>
                                    <div role="button" class="edit text-success fw-semibold">
                                        <div  ng-show="formEdit==true" ng-click="saveEdit()">Save</div>
                                    </div>
                                </div>
                                <div class="status d-flex align-items-center justify-content-between mt-2">
                                    <div class="statusValue d-flex flex-column align-items-start">
                                        <p class="statusText fw-bold p-2 warning m-0 px-3">
                                            Temporary Stop
                                        </p>
                                        <p class="m-0 text-danger fw-semibold">
                                            Reason: 02-death of Service Pensioner
                                        </p>
                                    </div>
                                    <div class="btn moddalToggleBtn btn-sm btn-light fw-bold" data-bs-toggle="modal" data-bs-target="#addLegalHeirModal">
                                    Add Legal Heir
                                    </div>
                                </div>

                                <!-- Personal Details -->
                                <div class="personalDetails mt-2">
                                    <p class="fw-bolder">
                                        Personal Details
                                    </p>
                                    <div class="bg-white p-3">
                                        <div class="row justify-content-between">
                                            <div class="col-5">
                                                <div class="text-black-50 fw-semibold">PENSIONER NAME:</div>
                                                <p class="m-0 fw-bolder text-primary">
                                                    {{data.familyPensionName}}
                                                </p>
                                            </div>
                                            <!--gender-->
                                            <div class="col-5">
                                                <div class="text-black-50 fw-semibold">GENDER:</div>
                                                <p class="m-0 fw-bolder">
                                                    {{data.gender}}
                                                </p>
                                            </div>
                                        </div>
                                        <!--DOB-->
                                        <div class="row justify-content-between mt-3">
                                            <div class="col-5">
                                                <div class="text-black-50 fw-semibold">DATE OF BIRTH:</div>
                                                <p class="m-0 fw-bolder">
                                                   {{data.dob}}
                                                </p>
                                            </div>
                                            <!--Age-->
                                            <div class="col-5">
                                                <div class="text-black-50 fw-semibold">AGE:</div>
                                                <p class="m-0 fw-bolder">
                                                   {{data.age}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pension Info -->
                                <div class="pensionInfo">
                                    <div class="title d-flex align-items-center">
                                        <p class="fw-bolder">
                                            Pension Info
                                        </p>
                                        <span>(Update/Edit)</span>
                                    </div>
                                    <div class="bg-white p-3">
                                        <!-- Family Pension -->
                                        <div class="row justify-content-between">
                                            <div class="col">
                                                <div class="text-black-50 d-flex" >
                                               <div class="fw-semibold">FAMILY PENSION</div>
                                                    <div class="edit text-success fw-semibold ms-2">
                                                        <i style="font-size: 8px;" class="bi bi-pencil-fill text-white bg-success"></i>
                                                        <span>Edit</span>
                                                    </div>
                                                </div>
                                                <div class="m-0 fw-bolder d-flex">
                                                    <span>Eligible</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Employee ID-->
                                        <div class="row justify-content-between mt-3">
                                            <div class="col-12 col-md-10 col-lg-8" >
                                           <div class="text-black-50">
                                                    <div class="fw-semibold">EMPLOYEE ID</div>
                                                </div>
                                                <div class="m-0 fw-bolder d-flex">
                                                <input type="text"  placeholder="Enter Employee Id" class="twelevePx form-control rounded-0">
                                                    <button class="btn btn-primary rounded-0  bg-success">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="pensionInfo mt-3">
                                    <div class="title mb-2 d-flex align-items-center"></div>
                                        <div class="fw-bolder fourteenPx m-0 d-flex">
                                    
                                            <span class="fourteenPx me-2"
                                                >Contact Info</span
                                            >
                                            <div
                                                role="button"
                                                class="edit text-success fw-semibold"
                                            >
                                                <i
                                                    class="bi bi-pencil-fill text-white bg-success"
                                                ></i>
                                                <span>Edit</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white p-3">
                                        <div class="row my-2">
                                            <div class="col-6">
                                                <strong class="text-secondary"
                                                    >PHONE</strong
                                                >
                                                <p
                                                    class="m-0 fw-bold text-black"
                                                >
                                                    {{data.phone}}
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <strong class="text-secondary"
                                                    >EMAIL</strong
                                                >
                                                <p
                                                    class="m-0 fw-bold text-danger"
                                                >
                                                    {{data.email}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-6">
                                                <strong class="text-secondary"
                                                    >PAN</strong
                                                >
                                                <p
                                                    class="m-0 fw-bold text-black"
                                                >
                                                    {{data.pan}}
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <strong class="text-secondary"
                                                    >AADHAR NO</strong
                                                >
                                                
                                                <p
                                                    class="m-0 fw-bold text-danger"
                                                >{{data.adharNo}}</p>

                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-6">
                                                <strong class="text-secondary"
                                                    >ADDRESS</strong
                                                >
                                                <p
                                                    class="m-0 fw-bold text-black"
                                                >
                                                    {{data.address}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div
            class="modal modal-lg fade"
            id="addLegalHeirModal"
            aria-hidden="true"
        >
            <div class="modal-dialog rounded-0">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="title fw-bold p-0 m-0">Legal Heir</h6>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <!-- Modal Body -->
                    <form id="form" class="form" action="" autocomplete="off">
                    <div class="modal-body p-3 d-flex flex-column gap-3">
                        <!--form legal-->
                        
                       

                        <!-- Input Fields -->
                        <!--Legal heir name-->
                        <div class="row justify-content-between">
                            <div class="col-12 col-sm-6">
                                <div class="inputGroup">
                                    <label for="firstName">Legal Heir Name
                                        <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Name" class="form-control" id="legalname">
                                </div>
                                <div id="nameerror" class="text-danger"></div>
                            </div>
                            <!--Legal Heir relation-->
                            <div class="col-12 col-sm-6">
                                <div class="inputGroup">
                                    <label for="firstName">Legal Heir Relation
                                        <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        placeholder="Relation"
                                        class="form-control"
                                        id="relation"
                                    />
                                </div>
                                
                                <div id="relationerror" class="text-danger"></div>
                            </div>
                        </div>
                        <!--Phone number-->
                        <div class="row justify-content-between">
                            <div class="col-12 col-sm-6">
                                <div class="inputGroup">
                                    <label for="firstName">Phone Number
                                        <span class="text-danger">*</span></label>
                                    <input
                                        type="number"
                                        inputmode="numeric"
                                        placeholder="Phone"
                                        class="form-control"
                                        id="phone"
                                    />
                                </div>
                                
                                <div id="phnoerror" class="text-danger"></div>
                            </div>
                        </div>
                        <p class="fw-bolder">Bank Details</p>
                        <!--Bank A/C No-->
                        <div class="row justify-content-between">
                            <div class="col-12 col-sm-6">
                                <div class="inputGroup">
                                    <label for="firstName"
                                        >Bank A/C No
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        placeholder="Bank Acno"
                                        class="form-control"
                                        id="bankacno"
                                    />
                                </div>
                                
                                <div id="bankerror" class="text-danger"></div>
                            </div>
                            <!--Confirm bank A/C No-->
                            <div class="col-12 col-sm-6">
                                <div class="inputGroup">
                                    <label for="firstName"
                                        >Confirm Bank A/C No
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        placeholder="Confirm Bank Acno"
                                        class="form-control"
                                        id="confirmBankac"
                                    />
                                </div>
                                
                                <div id="cbankerror" class="text-danger"></div>
                            </div>
                        </div>
                        <!--IFSC Code-->
                        <div class="row justify-content-between">
                            <div class="col-12 col-sm-6">
                                <div class="inputGroup">
                                    <label for="firstName"
                                        >IFSC Code
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <div class="searchInput d-flex">
                                        <input
                                            type="text"
                                            placeholder="Enter IFSC code & Search"
                                            class="form-control"
                                            id="ifsc"
                                        />
                                        <!--search button-->
                                        <button
                                            class="btn btn-primary rounded-0"
                                            style="font-size: 12px"
                                            id="ifscButton"
                                            onclick="clickbutton();"
                                        >
                                            Search
                                        </button>
                                    </div>
                                </div>
                                <div id="ifscerror" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-12 col-sm-6">
                                <div class="inputGroup">
                                    <label for="firstName">Bank Name</label
                                    ><br />
                                    <span class="text-secondary" id="bankName"
                                        >Please Enter IFSC Code first to get
                                        Bank Name</span
                                    >
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="inputGroup">
                                    <label for="firstName">Bank Branch</label
                                    ><br />
                                    <span class="text-secondary" id="bankBranch"
                                        >Please Enter IFSC Code first to get
                                        Bank Branch</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="justify-content-between text-danger" id="message"></div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <!--submit button-->
                        <button type="submit" class="btn btn-primary" value="submit" id="submit">
                            Save
                        </button>
                      </form>
                    </div>
                </div>
            
            </div>
        </div>
        <script src="./index.js"></script>
    </body>
</html>