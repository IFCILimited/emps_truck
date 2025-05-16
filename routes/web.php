<?php

use Illuminate\Support\Facades\Route;

use Mews\Captcha\Facades\Captcha;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/check-connection', function () {
//     try {
//         // Perform a basic database query to check the connection
//         $result = DB::select('select 1');

//         // If the query is successful, return a success message
//         return response()->json(['message' => 'Database connection successful']);
//     } catch (\Exception $e) {
//         // If an exception occurs, return an error message
//         return response()->json(['message' => 'Database connection failed: ' . $e->getMessage()], 500);
//     }
// });

// Route::get('/check-zip-extension', function () {
//     if (class_exists('ZipArchive')) {
//         return "Zip extension is loaded and available.";
//     } else {
//         return "Zip extension is not loaded.";
//     }
// });

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/addhar_test',
    'Adhartest@index'
)->name('adhartest');

Route::get(
    '/addhar_test_hit',
    'Adhartest@callhit'
)->name('adhartest_hit');

Auth::routes();
Auth::routes(['verify' => true]);
Auth::routes(['register' => false]);

Route::get('refresh-captcha', function () {
    return response()->json(['captcha' => Captcha::img()]);
})->name('refresh.captcha');


Route::get('/', 'HomeController@index')->name('home');
Route::get('signin/{roleid}', 'HomeController@signin')->name('signin');
Route::get('signup/{utype}', 'HomeController@signup')->name('signup');
Route::get('contact-us/', 'HomeController@contact')->name('contact-us');
Route::get('support/', 'HomeController@support')->name('support');
Route::get('about-us/', 'HomeController@about_us')->name('about-us');
Route::get('feedback/', 'HomeController@feedback')->name('feedback');
Route::get('impotrant_links/', 'HomeController@impotrant_links')->name('impotrant-links');
Route::get('press_release/', 'HomeController@press_release')->name('press_release');
Route::get('FAQs/', 'HomeController@FAQs')->name('FAQs');
Route::get('policy_document/', 'HomeController@policy_document')->name('policy_document');
Route::get('policy_procedure/', 'HomeController@policy_procedure')->name('policy_procedure');
Route::get('draftPMPGuidelines/', 'HomeController@draftPMPGuidelines')->name('draftPMPGuidelines');
Route::get('EVPCSGuidelines/', 'HomeController@EVPCSGuidelines')->name('EVPCSGuidelines');
Route::get('suggestion/', 'HomeController@suggestion')->name('suggestion');
Route::post('suggestion_msg/', 'HomeFormController@suggestion')->name('suggestion_msg');
Route::resource('submit-form', 'HomeFormController');
Route::get('who/', 'HomeController@who')->name('who');
Route::get('model/{oem_id?}', 'HomeFormController@model_scheme')->name('model');

Route::get('dashboard-home/', 'HomeController@dashboard')->name('dashboard-home');
Route::get('Claim-Submission-Announcements/', 'HomeController@ClaimSubmissionAnnouncements')->name('Claim_submission');
// Route::get('models/', 'HomeController@models')->name('models');
Route::get('models/{oem_id?}/{segment?}', 'HomeController@models')->name('models');
// Dashboard (Menu)
Route::group(['middleware' => ['role:MHI|OEM|TESTINGAGENCY|DEALER|PMA', 'verified', 'TwoFA', 'IsApproved']], function () {
    // Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::resource('apivahan', 'APIVahanController');
    Route::get('adv/fetch', 'APIVahanController@fetchADVView')->name('adv.fetch');
    Route::post('adv/fetch', 'APIVahanController@fetchADVApi')->name('adv.fetch.post');
    Route::get('adv/fetch/token', 'APIVahanController@fetchRefToken')->name('adv.fetch.token');
});

Route::get('password/forgot/{userid?}', 'Auth\ForgotPasswordController@index')->name('password.forgot');
Route::post('password/passwordUpdate', 'Auth\ForgotPasswordController@updatePassword')->name('password.passwordUpdate');
Route::post('password/updatePassword', 'Auth\ForgotPasswordController@passwordUpdate')->name('password.updatePassword');

Route::resource('ajax', 'AjaxController');
// Pincode
Route::get('pincode/{pincode}', 'AjaxController@pincodedetail')->name('pincode');
Route::post('/check-email', 'AjaxController@checkEmail')->name('check.email'); //Registration page email check

Route::get('get_modelName/{data}/{id}', 'AjaxController@get_modelName')->name('modelname');

// Document Download
Route::get('doc/down/{docid}', 'AjaxController@downloadfile')->name('doc.down');
Route::get('empsdoc/down/{docid}', 'AjaxController@Empsdownloadfile')->name('empsdoc.down');

// OTP at Form
Route::get('/formOTP/{email}/{moboile}', 'Auth\OtpController@formOTP')->name('formOTP');
Route::get('/verifyFormOtp/{otp}', 'Auth\OtpController@verifyFormOtp')->name('verifyFormOtp');

Route::resource('postController', 'OEM\OEMPostController');
Route::get('post_registration/{id}', 'OEM\OEMPostController@show')->name('post_registration');

Route::group(['middleware' => ['verified', 'IsApproved']], function () {
    Route::get('/verifymobile', 'Auth\OtpController@verifyMobileForm')->name('verifyMobileForm');
    Route::post('/verifymobile', 'Auth\OtpController@verifyMobile')->name('verifyMobile');
    Route::get('/getotp', 'Auth\OtpController@getLoginOTP')->name('getLoginOTP');
    Route::post('/verifyotp', 'Auth\OtpController@verifyLoginOTP')->name('verifyLoginOTP');
    Route::post('/resendOtp', 'Auth\OtpController@verifyLoginOTP')->name('resendOtp');
    //  Route::get('dashboard', 'Admin\AdminController@index')->name('dashboard');
});
Route::group(['middleware' => ['verified', 'TwoFA', 'IsApproved']], function () {
    // Route::get('dashboard', 'Admin\AdminController@index')->name('dashboard');
    Route::get('dashboard/{segment}', 'Admin\AdminController@segmentWise')->name('dashboard.segment');
    Route::get('dashboard/dealer/{segment}', 'Admin\AdminController@segmentDealerWise')->name('dashboard.dealer.segment');
    Route::get('dashboard/dealer/{segment}/{dealerId}', 'Admin\AdminController@segmentDealerVinWise')->name('dashboard.dealer.segment.dealerId');
    Route::get('dashboard', 'Admin\VahanDashboardController@index')->name('dashboard');
Route::get('dashboardNew/{segment}', 'Admin\VahanDashboardController@segmentWise')->name('dashboardNew.segment');
});


// MHI
Route::group(['middleware' => ['role:MHI|MHI-AS|MHI-DS|MHI-OnlyView|PMA', 'verified', 'TwoFA', 'IsApproved']], function () {
    // Admin Create
    Route::resource('superAdmin', 'Admin\AdminCreationController');
    Route::get('claimDetails/{flag}', 'Admin\AdminController@claimDetails')->name('claimDetails');
    Route::get('claimDetails/{flag}/download', 'Admin\AdminController@downloadClaimDetails')->name('claimDetails.download');

    // Admin Dashboard

    Route::get('uploaddoc', 'Admin\AdminController@uploaddoc')->name('uploaddoc');
    Route::post('uploadcheck', 'Admin\AdminController@uploadcheck')->name('uploadcheck');
    Route::resource('manageOEMApproval', 'Admin\ManageOEMApprovalController');

    Route::get('modelsFilter/{colunm?}/{order?}', 'Admin\ManageOEMApprovalController@modelsFilter')->name('modelsFilter');

    Route::get('modelsView/{status}', 'Admin\ManageOEMApprovalController@modelsView')->name('modelsView');

    // Pre/Post-Registration
    Route::resource('oemRegistration', 'Admin\ManageOemController');
    Route::get('preRegister/{status}', 'Admin\ManageOemController@preRegister')->name('preRegister');
    Route::get('postRegister/{status}', 'Admin\ManageOemController@postRegister')->name('postRegister');
    Route::get('oemPostRegistration', 'Admin\ManageOemController@oemPostRegistration')->name('oemPostRegistration');
    Route::post('PreApproveReject', 'Admin\ManageOemController@PreApproveReject')->name('PreApproveReject');
    

    // Truck & Buses

    Route::resource('truckoemRegistration', 'Truck\Admin\ManageOemController');
    Route::get('truckpreRegister/{status}', 'Truck\Admin\ManageOemController@preRegister')->name('truckpreRegister');
    Route::get('truckpostRegister/{status}', 'Truck\Admin\ManageOemController@postRegister')->name('truckpostRegister');
    Route::post('truckPreApproveReject', 'Truck\Admin\ManageOemController@PreApproveReject')->name('truckPreApproveReject');
    Route::get('truckoemPostRegistration', 'Truck\Admin\ManageOemController@oemPostRegistration')->name('truckoemPostRegistration');
   
    // Bank Approval
    Route::resource('bankApproval', 'Admin\ManageBankApprovalController');


});

// OEM
Route::group(['middleware' => ['role:OEM|OEM-Truck|PMA|DEALER', 'verified', 'TwoFA', 'IsApproved']], function () {


    Route::get('unactiveUser', 'OEM\ManageUserDeactivationController@index')->name('unactiveUser');
    Route::put('unactiveUser/update', 'OEM\ManageUserDeactivationController@deactiveUser')->name('unactiveUser.update');

    // OEM Dashboard
    // Route::resource('oem', 'OEM\OEMController');

    // Post-Registration
    // Route::resource('postController', 'OEM\OEMPostController');
    // Route::get('post_registration/{id}', 'OEM\OEMPostController@show')->name('post_registration');
    Route::resource('claimGenerate', 'OEM\Claim\ClaimGenerateController');

    Route::post('claimGenerate/show', 'OEM\Claim\ClaimGenerateController@show')->name('claimGenerate.show');
    Route::get('claimGenerate/search/{modSeg}/{modName}', 'OEM\Claim\ClaimGenerateController@search')->name('claimGenerate.search');

    Route::resource('claimToMhi', 'OEM\Claim\ClaimToMhiController');
    Route::post('claimToMhi/show', 'OEM\Claim\ClaimToMhiController@show')->name('claimToMhi.show');
    Route::get('claimSubmitted', 'OEM\Claim\ClaimToMhiController@claimSubmitted')->name('claimSubmitted');


    // Manage Dealer
    Route::get('manageDealer/operator', 'OEM\ManageDealerController@operator')->name('manageDealer.operator');
    Route::resource('manageDealer', 'OEM\ManageDealerController');
    Route::get('manageDealer/resendMail/{did}', 'OEM\ManageDealerController@resendMail')->name('manageDealer.resendMail');
    Route::get('updateDealer/{status}/{did}', 'OEM\ManageDealerController@updateDealer')->name('updateDealer');
    Route::post('upload-excel', 'OEM\ManageDealerController@uploadExcel')->name('upload-excel');

    // Manage Model
    Route::resource('oemModel', 'OEM\OemModelController');
    Route::get('oemModel/models/{id}', 'OEM\OemModelController@models')->name('oemModel.models');
    Route::get('oemModel/revalidate/{id}', 'OEM\OemModelController@revalidate')->name('oemModel.revalidate');
    Route::post('oemModel/revalidatestore', 'OEM\OemModelController@revalidatestore')->name('oemModel.revalidatestore');
    Route::get('oemModel/final_submit/{id}', 'OEM\OemModelController@final_submit')->name('oemModel.final_submit');
    Route::get('oemModel/show/{id}', 'OEM\OemModelController@show')->name('oemModel.show');
    Route::get('oemModel/get_cat/{id}', 'OEM\OemModelController@get_category');
    Route::post('oemModel/calculate_incentive_amt', 'OEM\OemModelController@calculate_incentive_amt')->name('oemModel.calculate_incentive_amt');



    //Plant Detail
    Route::resource('xEVPlants', 'OEM\xEVPlantsController');

    // Bank Detail
    Route::resource('bankDetails', 'OEM\BankDetailController');

    // Production Data
    Route::resource('manageProductionData', 'OEM\ManageProductionDataController');
    Route::get('manageProductionData/downloadexcel/{id}', 'OEM\ManageProductionDataController@downloadexcel')->name('manageProductionData.downloadexcel');
    Route::get('manageProductionData/create/{id}', 'OEM\ManageProductionDataController@create')->name('manageProductionData.create');
    Route::get('manageProductionData/edit/{id}', 'OEM\ManageProductionDataController@edit')->name('manageProductionData.edit');
    Route::get('productionData/finalSubmit/{id}', 'OEM\ManageProductionDataController@finalSubmit')->name('productionData.finalSubmit');

    Route::get('download/productiondata', 'OEM\ManageProductionDataController@downloadFile')->name('downloadFile.productiondata');
    Route::post('uploadProductionData', 'OEM\ManageProductionDataController@uploadExcel')->name('uploadProductionData');
    Route::get('manageProductionData/deleteTempData/{id}/{status}', 'OEM\ManageProductionDataController@deleteTempData')->name('manageProductionData.deleteTempData');


    Route::get('manageBuyerDetails/create/{id}', 'OEM\ManageBuyerDetailsController@create')->name('manageBuyerDetails.create');

    //  Route::resource('manageBuyerDetails', 'OEM\ManageBuyerDetailsController')->except(['create']);
    Route::resource('manageBuyerDetails', 'OEM\ManageBuyerDetailsController@manageBuyerDetails')->except(['create', 'index']);
    Route::get('manageBuyerDetails/returnToDealer/{status}', 'OEM\ManageBuyerDetailsController@returnToDealer')->name('manageBuyerDetails.returnToDealer');
    Route::patch('manageBuyerDetails/update/{id}', 'OEM\ManageBuyerDetailsController@update')->name('manageBuyerDetails.update');
    Route::get('manageBuyerDetails/index/{id}', 'OEM\ManageBuyerDetailsController@index')->name('manageBuyerDetails.index');
    Route::get('downloadBuyerList/{status}', 'OEM\ManageBuyerDetailsController@downloadBuyerList')->name('downloadBuyerList');
    Route::resource('manageUser', 'OEM\ManageUserController');
    Route::resource('VinChassis', 'OEM\VINChassisController');
    Route::get('downloadBuyerStages', 'OEM\VINChassisController@downloadBuyerStages')->name('downloadBuyerStages');
    Route::get('uploadSales', 'OEM\ManageUserController@uploadSales')->name('uploadSales');
    Route::get('uploadSalesReport', 'OEM\ManageUserController@uploadSalesReport')->name('uploadSalesReport');

    Route::get('sales/download/{data}', 'OEM\ManageUserController@salesDownload')->name('sales.download');
    Route::post('uploadSalesData', 'OEM\ManageUserController@uploadSalesData')->name('uploadSalesData');
    Route::get('manageBulkBuyerDetails/index/{id}', 'OEM\ManageBulkBuyerDetailsController@index')->name('manageBulkBuyerDetails.index');
    Route::get('manageBulkBuyerDetails/create/{id}', 'OEM\ManageBulkBuyerDetailsController@managePreview')->name('manageBulkBuyerDetails.create');
    Route::put('manageBulkBuyerDetails/action/{id}', 'OEM\ManageBulkBuyerDetailsController@manageOemRevertApprove')->name('manageBulkBuyerDetails.action');
    Route::get('bulkdownloadBuyerList/{status}', 'OEM\ManageBulkBuyerDetailsController@bulkdownloadBuyerList')->name('bulkdownloadBuyerList');
	Route::get('Empsbuyer/index/{id}', 'OEM\EmpsAuthBuyerController@index')->name('Empsbuyer.index');
    Route::get('Empsbuyer/create/{id}', 'OEM\EmpsAuthBuyerController@create')->name('Empsbuyer.cerate');
    Route::resource('Empsbuyer', 'OEM\EmpsAuthBuyerController')->except(['create', 'index']);


    Route::get('claimUploadDoc/{claimid}', 'OEM\Claim\ClaimToMhiController@claimUploadDoc')->name('claimUploadDoc');
    Route::post('claimDocStore', 'OEM\Claim\ClaimToMhiController@claimDocStore')->name('claimDocStore');
    Route::post('claimDocUpdate', 'OEM\Claim\ClaimToMhiController@claimDocUpdate')->name('claimDocUpdate');
    Route::get('claimDocSubmit/{claimid}', 'OEM\Claim\ClaimToMhiController@claimDocSubmit')->name('claimDocSubmit');
    Route::post('revertClaimDoc', 'OEM\Claim\ClaimToMhiController@revertClaimDoc')->name('revertClaimDoc');



});

// Testing Agency
Route::group(['middleware' => ['role:TESTINGAGENCY|MHI|MHI-AS|MHI-DS|MHI-OnlyView|PMA', 'verified', 'TwoFA', 'IsApproved']], function () {
    // Route::resource('TestingAgency', 'TestingAgency\TestingAgencyController');
    Route::resource('modelRequests', 'TestingAgency\ModelRequestController');
    Route::get('modelRequests/create/{id}', 'TestingAgency\ModelRequestController@create')->name('modelRequests.create');
    Route::post('modelPreview', 'TestingAgency\ModelRequestController@modelPreview')->name('modelPreview');
    Route::post('modelRevert', 'TestingAgency\ModelRequestController@modelRevert')->name('modelRevert');
    Route::post('modelRevertMHI', 'TestingAgency\ModelRequestController@modelRevertMHI')->name('modelRevertMHI');
    Route::get('modelRequestsChart/{id}', 'TestingAgency\ModelRequestController@modelChart')->name(name: 'modelChart.show');
});


############### Dealer ####################################

Route::group(['middleware' => ['role:DEALER']], function () {
    Route::get('/dealer/view-certificate/{id}', 'Dealer\ManageCertificateController@index')->name('dealer.view_certificate');
    // 21-10-2024 bulk buyer by Shahil
    Route::get('/multi/buyer/view-certificate/{id}', 'Dealer\ManageCertificateController@multiBuyerVoucher')->name('dealer.multiBuyerVoucher');
    //index listing
    Route::get('buyerdetail/multi-buyers', 'Dealer\MultiBuyerDetailController@index')->name('buyerdetail.multi_buyers');

    //view (new application) 
    Route::get('buyerdetail/multi-create', 'Dealer\MultiBuyerDetailController@multiCreate')->name('buyerdetail.multi_create');
    //store (generate customer Id)
    Route::post('buyerdetail/multi-create', 'Dealer\MultiBuyerDetailController@generateId')->name('buyerdetail.generateId');
    //view edit page
    Route::get('buyerdetail/multi-detail-edit/{id}', 'Dealer\MultiBuyerDetailController@multiEdit')->name('buyerdetail.multi_detail_edit');
    //update (edit page)
    Route::patch('buyerdetail/multi-create/{id}', 'Dealer\MultiBuyerDetailController@multiUpdate')->name('buyerdetail.multi_update');
    //submit to oem
    Route::post('buyerdetail/submit-oem', 'Dealer\MultiBuyerDetailController@manageOemSubmit')->name('buyerdetail.submit_oem');

    //multi invoice and docs page view
    Route::get('buyerdetail/multi-invoice-manage/{id}/{row_id}', 'Dealer\MultiBuyerDetailController@manageInvoice')->name('buyerdetail.manageInvoice');
    //update invoice and docs
    Route::post('buyerdetail/multi-invoice-update', 'Dealer\MultiBuyerDetailController@manageInvoiceDocs')->name('buyerdetail.multi_invoice_update');
    
    //submit individual buyer row
    Route::post('buyerdetail/multi-invoice-submit', 'Dealer\MultiBuyerDetailController@manageInvoiceDocsSubmit')->name('buyerdetail.multi_invoice_submit');

    // 30122024
    Route::post('buyerdetail/update-incentive', 'Dealer\BuyerDetailController@updateIncentive')->name('buyerdetail.update.incentive');

    //final preview
    //Route::get('buyerdetail/multi-buyer-preview/{id}', 'Dealer\MultiBuyerDetailController@managePreview')->name('buyerdetail.multi_buyer_preview');
    //Route::get('buyerdetail/multi-invoice-preview/{id}/{row_id}/{flag}', 'Dealer\MultiBuyerDetailController@mangeInvoicePreview')->name('buyerdetail.manage_invoice_preview');

    Route::post('multibuyerdetail/multi-export-data', 'Dealer\MultiBuyerDetailController@multiexportData')->name('multibuyerdetail.export_data');


    Route::resource('buyerdetail', 'Dealer\BuyerDetailController');
    Route::post('aadhar_api_data', 'Dealer\BuyerDetailController@aadhar_api_data')->name('aadhar_api_data');
    Route::get('vin/getcode/{val}/{oemid}', 'Dealer\BuyerDetailController@getcode')->name('vin.getcode');
    //Route::get('customer/type/{val}','Dealer\BuyerDetailController@type')->name('customer.type');
    Route::get('customer/type/{val}', 'Dealer\BuyerDetailController@type')->name('customer.type');
    Route::get('check/adhar/{name}/{adhar}/{segid}', 'Dealer\BuyerDetailController@CheckAdhar')->name('check.adhar');
    Route::get('sendOtp/{mobile}/{msg}', 'Dealer\BuyerDetailController@sendOtp')->name('sendOtp');
    Route::get('verifybuyer/{otp}', 'Dealer\BuyerDetailController@verifybuyer')->name('verifybuyer');
    Route::match(['PUT', 'PATCH'], 'buyer/update/{id}', 'Dealer\BuyerDetailController@update')->name('buyer.update');
    Route::get('ack/view/{id}', 'Dealer\AckViewController@AckView')->name('ack.view');
    Route::get('buyer/submit/{id}', 'Dealer\AckViewController@FinallSubmit')->name('buyer.submit');
    Route::get('ack/doc/{id}', 'Dealer\AckViewController@AckDoc')->name('buyerdetail.ackdoc');
    //
    Route::match(['PUT', 'PATCH'], 'ack/update/{id}', 'Dealer\AckViewController@update')->name('ack.update');
    Route::get('buyer/oemreturn', 'Dealer\AckViewController@OemReturn')->name('buyer.oemreturn');
    Route::get('buyerbulk/oemreturn', 'Dealer\MultiBuyerDetailController@BulkOemReturn')->name('buyerbulk.oemreturn');
    // E-Voucher
    Route::post('/update-temp-reg', 'Dealer\BuyerDetailController@updateTempReg')->name('update-temp-reg');
    Route::resource('Evoucher', 'Dealer\EvoucherController');
    Route::post('buyerdetail/export-data', 'Dealer\BuyerDetailController@exportData')->name('buyerdetail.export_data');
    Route::post('buyerdetail/search-vin', 'Dealer\BuyerDetailController@searchVin')->name('buyerdetail.search_vin');

    //multi operators
    Route::resource('manageOperator', 'Dealer\ManageOperatorController');
    Route::get('manageOperator/updateOperator/{id}', 'Dealer\ManageOperatorController@updateOperator')->name('updateOperator.update');
    Route::post('save/invoice', 'Dealer\MultiBuyerDetailController@saveInvoice')->name('save.invoice');
    Route::resource('RCReport', 'Dealer\RCReportController');
Route::post('empsbuyer', 'Dealer\EmpsAuthController@create')->name('empsbuyer.create');
    Route::get('empsbuyer/show_detail/{id}', 'Dealer\EmpsAuthController@show_detail')->name('empsbuyer.show_detail');
    Route::get('empsbuyer/emps_auth', 'Dealer\EmpsAuthController@emps_auth')->name('empsbuyer.emps_auth');
    Route::get('empsbuyer/evoucher/{id}', 'Dealer\EmpsAuthController@evoucher')->name('empsbuyer.download');
    Route::post('empsbuyer/export_data', 'Dealer\EmpsAuthController@export_data')->name('empsbuyer.export_data');
    Route::resource('empsbuyer', 'Dealer\EmpsAuthController');

});


Route::group(['middleware' => ['role:MHI|MHI-AS|MHI-DS|MHI-OnlyView|PMA|AUDITOR']], function () {

    Route::get('oemDetails', 'Admin\ManageOemController@oemDetails')->name('oemDetails');
    Route::get('modelDetails/{colunm?}/{order?}', 'Admin\ManageOemController@modelDetails')->name('modelDetails');

    Route::get('modelShow/{id}', 'Admin\ManageOemController@modelShow')->name('modelShow');
    Route::get('claimProcessing', 'PMA\PMAController@index')->name('claimProcessing');
    Route::get('dealers/{id?}', 'PMA\PMAController@dealers')->name('dealers');
    Route::get('dealersShow/{id}', 'PMA\PMAController@dealersShow')->name('dealersShow');
    Route::get('vahanProcess/{claimno}', 'PMA\PMAController@vahanProcess')->name('vahanProcess');
    Route::get('proccessClaim/{claimno}', 'PMA\PMAController@proccessClaim')->name('proccessClaim');
    Route::get('downloadClaim/{claimno}', 'PMA\PMAController@downloadClaim')->name('downloadClaim');
    Route::get('pincodes/{id?}', 'PMA\PMAController@pincodes')->name('pincodes');
    Route::post('addpin', 'PMA\PMAController@addpin')->name('addpin');

    Route::get('OEMSummary/{vehicle_type}', 'Admin\AdminController@OEMSummary')->name('OEMSummaryShow');
    Route::get('OEMSalesReport', 'Admin\AdminController@OEMSalesReport')->name('OEM-Sales-Report');
    Route::get('VahanOEMSalesReport', 'Admin\AdminController@VahanOEMSalesReport')->name('Vahan-OEM-Sales-Report');
    Route::get('VahanOEMSalesReportSegment', 'Admin\AdminController@VahanOEMSalesReportSegment')->name('VahanOEMSalesReportSegment');
    Route::get('OEMSalesReportSegment', 'Admin\AdminController@OEMSalesReportSegment')->name('OEMSalesReportSegment');
    Route::resource('releaseVIN', 'PMA\ReleaseVINController');
    Route::post('releaseVIN/getVIN', 'PMA\ReleaseVINController@getVIN')->name('releaseVIN.getVIN');
    Route::get('OEMEMPSSalesReport', 'Admin\AdminController@OEMEmpsSalesReport')->name('OEM-emps-Sales-Report');
    Route::get('VahanOEMEMPSSalesReport', 'Admin\AdminController@VahanOEMSEmpssalesReport')->name('Vahan-OEM-Emps-Sales-Report');
    Route::resource('claimReport', 'Admin\ClaimReportController');

    Route::post('fetchClaimDetails','Admin\ClaimReportController@fetchClaimDetails')->name('fetchClaimDetails');
    Route::get('fetchClaimVin/{oemId}/{segment_id}','Admin\ClaimReportController@fetchClaimVin')->name('fetchClaimVin');
    Route::get('view-details/{oemId}/{claimnumberformat}', 'Admin\ClaimReportController@viewDetails')->name('viewDetails');

    Route::get('stateSalesReport/{portal}', 'Admin\AdminController@StateSalesReportEdrive')->name('state-sales-report');
    Route::resource('claimEvaluation', 'PMA\ClaimEvaluationController');
    Route::get('claimEvaluation/search/{oem}/{segm}', 'PMA\ClaimEvaluationController@search')->name('claimEvaluation.search');
    Route::get('claimEvaluation/submit/{claim_id}/{auditor_id}', 'PMA\ClaimEvaluationController@claimsubmit')->name('claimEvaluation.submit');
    Route::get('claimEvaluation/download/{id}', 'PMA\ClaimEvaluationController@downloadUploadedFile')->name('claimEvaluation.download');
    Route::get('buyDetailView/{claimId?}', 'PMA\ClaimEvaluationController@buyDetailView')->name('claimEvaluation.buyDetailView');
    Route::post('claimEvaluation/claimstagesubmit/{claim_id}/{stage_id}', 'PMA\ClaimEvaluationController@claimstagesubmit')->name('claimEvaluation.claimstagesubmit');
    Route::resource('oemChartDetails', 'Admin\FlowChart\OemDetailController');

    Route::resource('modelChartDetails', 'Admin\FlowChart\ModelChartDetailController');
    Route::resource('EmpsAuthDetails', 'Admin\FlowChart\EmpsAuthDetailController');
    Route::get('vahanReport/{portal}', 'PMA\PMAController@vahanReportView')->name('vahanReport.View');

});


Route::group(['middleware' => ['role:PMA|MHI-AS|MHI-DS|MHI-OnlyView']], function () {
    Route::get('modelmis', 'PMA\PMAController@modelmis')->name('modelmis');
    Route::get('evoucherReport', 'PMA\PMAController@evoucherReport')->name('evoucherReport');
    Route::get('oemWiseSales', 'PMA\PMAController@oemWiseSales')->name('oemWiseSales');
    Route::post('evoucherReportfiler', 'PMA\PMAController@evoucherReportFilter')->name('evoucherReportFilter');

    
Route::get('oemwisemodel', 'PMA\OEMWiseModelController@index')->name('oemwisemodel.index');
Route::get('oemwisemodel/show/{oemid}', 'PMA\OEMWiseModelController@show')->name('oemwisemodel.show');
Route::get('oemwisemodel/modelDetails/{modelid}', 'PMA\OEMWiseModelController@modelDetails')->name('oemwisemodel.modelDetails');


});



Route::group(['middleware' => ['role:OEM|DEALER|PMA|AUDITOR']], function () {
    //Route::get('vahanReport/{portal}', 'PMA\PMAController@vahanReportView')->name('vahanReport.View');
    Route::post('vahanReport/generate', 'PMA\PMAController@vahanReportGenerate')->name('vahanReport.generate');

    Route::get('ackdoc/finalview/{id}', 'Dealer\AckViewController@view')->name('ackdoc.finalview');
    Route::get('viewclaims/{id}', 'PMA\PMAController@viewclaims')->name('viewclaims');
    Route::get('buyerdetail/multi-buyer-preview/{id}/{userType}', 'Dealer\MultiBuyerDetailController@managePreview')->name('buyerdetail.multi_buyer_preview');
    Route::get('buyerdetail/multi-invoice-preview/{id}/{row_id}/{flag}/{user}', 'Dealer\MultiBuyerDetailController@mangeInvoicePreview')->name('buyerdetail.manage_invoice_preview');
	Route::get('buyerdetail/vin/multi-invoice-preview/{id}/{row_id}', 'Dealer\MultiBuyerDetailController@mangeVinWiseInvoicePreview')->name('buyerdetail.vin.manage_invoice_preview');
    Route::resource('manageCompanyDetails', 'OEM\ManageCompanyDetailsController');
    Route::post('manageCompanyDetails/submitToPma', 'OEM\ManageCompanyDetailsController@submitToPma')->name('manageCompanyDetails.submitToPma');

    Route::get('vahanModel', 'PMA\PMAController@manageVahanModel')->name('vahanModel');
    Route::get('fetchModelDetails', 'PMA\PMAController@fetchModelDetails')->name('fetch-model-details');
    Route::post('vahanModelSave', 'PMA\PMAController@saveVahanModel')->name('vahanModel.save');
    Route::get('vahanModelExport', 'PMA\PMAController@exportVahan')->name('vahanModel.export');





});

// 12-06-2024 MULTI LOGIN

// Route::group(['middleware' => ['role:MHI', 'verified', 'TwoFA', 'IsApproved']], function () {
//     Route::resource('superAdmin', 'Admin\AdminCreationController');
// });

// // E-voucher
// Route::get('dealer/verify-certificate/{dealerId}/{certificateId}', 'Dealer\ManageCertificateController@verifyCertificateView')->name('dealer.verify_certificate');
// Route::post('dealer/verify-certificate', 'Dealer\ManageCertificateController@sendOtpAndVerify')->name('dealer.check_and_Verify_certificate');
// Route::post('dealer/verify-certificate-otp', 'Dealer\ManageCertificateController@VerifyOtp')->name('dealer.Verify_otp_certificate');
// Route::get('verify-certificate/{alias}', 'Dealer\ManageCertificateController@aliasLinkRedirect')->name('verify_certificate.alias');

Route::post('dealer/verify-certificate', 'Dealer\ManageCertificateController@sendOtpAndVerify')->name('dealer.check_and_Verify_certificate');
Route::post('dealer/verify-certificate-otp', 'Dealer\ManageCertificateController@VerifyOtp')->name('dealer.Verify_otp_certificate');
Route::get('vcf', 'Dealer\ManageCertificateController@verifyCertificateView')->name('vcf');

Route::get('datacheck/{id}/{aadhaar}/{mobile}', 'Dealer\ManageCertificateController@datacheck')->name('datacheck');

Route::resource('manage_vin_number', 'Dealer\ManageVinNumberController');
Route::post('manage_vin_number/get_customer', 'Dealer\ManageVinNumberController@getCustomerDetails')->name('manage_vin_number.get_customer');

route:
Route::resource('checkEligibility', 'Dealer\CheckEligibilityController');

Route::get('buyer_auth/{id}', 'Dealer\AckViewController@buyer_auth')->name('buyer_auth');

//////
Route::get('/genkey', function () {
    return view('genkey'); })->name('genkey');
Route::get('/dbdump/{id}', 'DbdumpController@dbdump')->name('dbdown');
Route::get('/appdump/{id}', 'DbdumpController@appdump')->name('appdown');
/////


// production data delete menu open at oem login after approval of pma
Route::group(['middleware' => ['role:PMA|OEM','verified', 'TwoFA', 'IsApproved']], function () {

    Route::resource('vinEdit', 'PMA\EditVinController');
    Route::post('vinEdit/create', 'PMA\EditVinController@create')->name('vinEdit.create');
    Route::get('vinSearch/{id}','PMA\EditVinController@vinSearch')->name('vinSearch');
    Route::resource('editVin', 'OEM\VinEditController');
    Route::get('editVin/create/{id}','OEM\VinEditController@create')->name('editVin.create');
    Route::post('editVin/edit','OEM\VinEditController@edit')->name('editVin.edit');

    Route::resource('vinExcel', 'OEM\VinExcelDownload');
    Route::get('vinFiledownload', 'OEM\VinExcelDownload@downloadVinFile')->name('vinFiledownload');
    Route::post('upload/vinexcel', 'OEM\VinExcelDownload@uploadVinExcel')->name('upload.vinexcel');
 
 
});

Route::group(['middleware' => ['role:OEM|MHI-AS|MHI-DS|PMA|MHI']], function () {
    Route::get('authenticationReport', 'MISController@index')->name('authenticationReport.index');
});
