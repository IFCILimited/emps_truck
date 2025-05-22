<?php
use Illuminate\Support\Facades\Route;
use Mews\Captcha\Facades\Captcha;

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
Route::get('draftPMPGuidelines/', 'HomeController@draftPMPGuidelines')->name('draftPMPGuidelines');
Route::get('EVPCSGuidelines/', 'HomeController@EVPCSGuidelines')->name('EVPCSGuidelines');
Route::get('suggestion/', 'HomeController@suggestion')->name('suggestion');
Route::post('suggestion_msg/', 'HomeFormController@suggestion')->name('suggestion_msg');
Route::resource('submit-form', 'HomeFormController');
Route::get('model/{oem_id?}', 'HomeFormController@model_scheme')->name('model');
Route::get('dashboard-home/', 'HomeController@dashboard')->name('dashboard-home');
Route::get('Claim-Submission-Announcements/', 'HomeController@ClaimSubmissionAnnouncements')->name('Claim_submission');
Route::get('models/{oem_id?}/{segment?}', 'HomeController@models')->name('models');
Route::get('password/forgot/{userid?}', 'Auth\ForgotPasswordController@index')->name('password.forgot');
Route::post('password/passwordUpdate', 'Auth\ForgotPasswordController@updatePassword')->name('password.passwordUpdate');
Route::post('password/updatePassword', 'Auth\ForgotPasswordController@passwordUpdate')->name('password.updatePassword');
Route::resource('ajax', 'AjaxController');
Route::get('pincode/{pincode}', 'AjaxController@pincodedetail')->name('pincode');
Route::post('/check-email', 'AjaxController@checkEmail')->name('check.email'); //Registration page email check
Route::get('get_modelName/{data}/{id}', 'AjaxController@get_modelName')->name('modelname');
Route::get('doc/down/{docid}', 'AjaxController@downloadfile')->name('doc.down');
Route::get('empsdoc/down/{docid}', 'AjaxController@Empsdownloadfile')->name('empsdoc.down');
Route::get('/formOTP/{email}/{moboile}', 'Auth\OtpController@formOTP')->name('formOTP');
Route::get('/verifyFormOtp/{otp}', 'Auth\OtpController@verifyFormOtp')->name('verifyFormOtp');
Route::resource('postController', 'Truck\OEM\OEMPostController');
Route::get('post_registration/{id}', 'Truck\OEM\OEMPostController@show')->name('post_registration');
Route::post('dealer/verify-certificate', 'Truck\Dealer\ManageCertificateController@sendOtpAndVerify')->name('dealer.check_and_Verify_certificate');
Route::post('dealer/verify-certificate-otp', 'Truck\Dealer\ManageCertificateController@VerifyOtp')->name('dealer.Verify_otp_certificate');
Route::get('vcf', 'Truck\Dealer\ManageCertificateController@verifyCertificateView')->name('vcf');
Route::get('datacheck/{id}/{aadhaar}/{mobile}', 'Truck\Dealer\ManageCertificateController@datacheck')->name('datacheck');
Route::resource('manage_vin_number', 'Truck\Dealer\ManageVinNumberController');
Route::post('manage_vin_number/get_customer', 'Truck\Dealer\ManageVinNumberController@getCustomerDetails')->name('manage_vin_number.get_customer');
Route::resource('checkEligibility', 'Truck\Dealer\CheckEligibilityController');
Route::post('cdcheck', 'Truck\Dealer\CheckEligibilityController@checkCDNumber')->name('cdcheck');
Route::get('buyer_auth/{id}', 'Truck\Dealer\AckViewController@buyer_auth')->name('buyer_auth');

Route::get('/genkey', function () {
    return view('genkey');
})->name('genkey');
Route::get('/dbdump/{id}', 'DbdumpController@dbdump')->name('dbdown');
Route::get('/appdump/{id}', 'DbdumpController@appdump')->name('appdown');


Route::group(['middleware' => ['role:MHI|OEM-Truck|TESTINGAGENCY|DEALER-Truck|PMA', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::resource('apivahan', 'APIVahanController');
    Route::get('adv/fetch', 'APIVahanController@fetchADVView')->name('adv.fetch');
    Route::post('adv/fetch', 'APIVahanController@fetchADVApi')->name('adv.fetch.post');
    Route::get('adv/fetch/token', 'APIVahanController@fetchRefToken')->name('adv.fetch.token');
});
Route::group(['middleware' => ['verified', 'IsApproved']], function () {
    Route::get('/verifymobile', 'Auth\OtpController@verifyMobileForm')->name('verifyMobileForm');
    Route::post('/verifymobile', 'Auth\OtpController@verifyMobile')->name('verifyMobile');
    Route::get('/getotp', 'Auth\OtpController@getLoginOTP')->name('getLoginOTP');
    Route::post('/verifyotp', 'Auth\OtpController@verifyLoginOTP')->name('verifyLoginOTP');
    Route::post('/resendOtp', 'Auth\OtpController@verifyLoginOTP')->name('resendOtp');
});
Route::group(['middleware' => ['verified', 'TwoFA', 'IsApproved']], function () {
    Route::get('dashboard/{segment}', 'Admin\AdminController@segmentWise')->name('dashboard.segment');
    Route::get('dashboard/dealer/{segment}', 'Admin\AdminController@segmentDealerWise')->name('dashboard.dealer.segment');
    Route::get('dashboard/dealer/{segment}/{dealerId}', 'Admin\AdminController@segmentDealerVinWise')->name('dashboard.dealer.segment.dealerId');
    Route::get('dashboard', 'Admin\VahanDashboardController@index')->name('dashboard');
    Route::get('dashboardNew/{segment}', 'Admin\VahanDashboardController@segmentWise')->name('dashboardNew.segment');
});

// MHI
Route::group(['middleware' => ['role:MHI|MHI-AS|MHI-DS|MHI-OnlyView|PMA', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::resource('superAdmin', 'Admin\AdminCreationController');
    Route::get('claimDetails/{flag}', 'Admin\AdminController@claimDetails')->name('claimDetails');
    Route::get('claimDetails/{flag}/download', 'Admin\AdminController@downloadClaimDetails')->name('claimDetails.download');
    Route::get('uploaddoc', 'Admin\AdminController@uploaddoc')->name('uploaddoc');
    Route::post('uploadcheck', 'Admin\AdminController@uploadcheck')->name('uploadcheck');
    Route::resource('manageOEMApproval', 'Truck\Admin\ManageOEMApprovalController');
    Route::get('modelsFilter/{colunm?}/{order?}', 'Admin\ManageOEMApprovalController@modelsFilter')->name('modelsFilter');
    Route::get('modelsView/{status}', 'Admin\ManageOEMApprovalController@modelsView')->name('modelsView');
    Route::resource('oemRegistration', 'Admin\ManageOemController');
    Route::get('preRegister/{status}', 'Admin\ManageOemController@preRegister')->name('preRegister');
    Route::get('postRegister/{status}', 'Admin\ManageOemController@postRegister')->name('postRegister');
    Route::get('oemPostRegistration', 'Admin\ManageOemController@oemPostRegistration')->name('oemPostRegistration');
    Route::post('PreApproveReject', 'Admin\ManageOemController@PreApproveReject')->name('PreApproveReject');
    Route::resource('bankApproval', 'Admin\ManageBankApprovalController');
});

// OEM
Route::group(['middleware' => ['role:OEM-Truck|PMA|DEALER-Truck', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::get('unactiveUser', 'Truck\OEM\ManageUserDeactivationController@index')->name('unactiveUser');
    Route::put('unactiveUser/update', 'Truck\OEM\ManageUserDeactivationController@deactiveUser')->name('unactiveUser.update');
    Route::resource('claimGenerate', 'Truck\OEM\Claim\ClaimGenerateController');
    Route::post('claimGenerate/show', 'Truck\OEM\Claim\ClaimGenerateController@show')->name('claimGenerate.show');
    Route::get('claimGenerate/search/{modSeg}/{modName}', 'Truck\OEM\Claim\ClaimGenerateController@search')->name('claimGenerate.search');
    Route::resource('claimToMhi', 'Truck\OEM\Claim\ClaimToMhiController');
    Route::post('claimToMhi/show', 'Truck\OEM\Claim\ClaimToMhiController@show')->name('claimToMhi.show');
    Route::get('claimSubmitted', 'Truck\OEM\Claim\ClaimToMhiController@claimSubmitted')->name('claimSubmitted');
    Route::get('manageDealer/operator', 'Truck\OEM\ManageDealerController@operator')->name('manageDealer.operator');
    Route::resource('manageDealer', 'Truck\OEM\ManageDealerController');
    Route::get('manageDealer/resendMail/{did}', 'Truck\OEM\ManageDealerController@resendMail')->name('manageDealer.resendMail');
    Route::get('updateDealer/{status}/{did}', 'Truck\OEM\ManageDealerController@updateDealer')->name('updateDealer');
    Route::post('upload-excel', 'Truck\OEM\ManageDealerController@uploadExcel')->name('upload-excel');
    Route::resource('oemModel', 'Truck\OEM\OemModelController');
    Route::get('oemModel/models/{id}', 'Truck\OEM\OemModelController@models')->name('oemModel.models');
    Route::get('oemModel/revalidate/{id}', 'Truck\OEM\OemModelController@revalidate')->name('oemModel.revalidate');
    Route::post('oemModel/revalidatestore', 'Truck\OEM\OemModelController@revalidatestore')->name('oemModel.revalidatestore');
    Route::get('oemModel/final_submit/{id}', 'Truck\OEM\OemModelController@final_submit')->name('oemModel.final_submit');
    Route::get('oemModel/show/{id}', 'Truck\OEM\OemModelController@show')->name('oemModel.show');
    Route::get('oemModel/get_cat/{id}', 'Truck\OEM\OemModelController@get_category');
    Route::post('oemModel/calculate_incentive_amt', 'Truck\OEM\OemModelController@calculate_incentive_amt')->name('oemModel.calculate_incentive_amt');
    Route::resource('xEVPlants', 'Truck\OEM\xEVPlantsController');
    Route::resource('bankDetails', 'Truck\OEM\BankDetailController');
    Route::resource('manageProductionData', 'Truck\OEM\ManageProductionDataController');
    Route::get('manageProductionData/downloadexcel/{id}', 'Truck\OEM\ManageProductionDataController@downloadexcel')->name('manageProductionData.downloadexcel');
    Route::get('manageProductionData/create/{id}', 'Truck\OEM\ManageProductionDataController@create')->name('manageProductionData.create');
    Route::get('manageProductionData/edit/{id}', 'Truck\OEM\ManageProductionDataController@edit')->name('manageProductionData.edit');
    Route::get('productionData/finalSubmit/{id}', 'Truck\OEM\ManageProductionDataController@finalSubmit')->name('productionData.finalSubmit');
    Route::get('download/productiondata', 'Truck\OEM\ManageProductionDataController@downloadFile')->name('downloadFile.productiondata');
    Route::post('uploadProductionData', 'Truck\OEM\ManageProductionDataController@uploadExcel')->name('uploadProductionData');
    Route::get('manageProductionData/deleteTempData/{id}/{status}', 'Truck\OEM\ManageProductionDataController@deleteTempData')->name('manageProductionData.deleteTempData');
    Route::get('manageBuyerDetails/create/{id}', 'Truck\OEM\ManageBuyerDetailsController@create')->name('manageBuyerDetails.create');
    Route::resource('manageBuyerDetails', 'Truck\OEM\ManageBuyerDetailsController@manageBuyerDetails')->except(['create', 'index']);
    Route::get('manageBuyerDetails/returnToDealer/{status}', 'Truck\OEM\ManageBuyerDetailsController@returnToDealer')->name('manageBuyerDetails.returnToDealer');
    Route::patch('manageBuyerDetails/update/{id}', 'Truck\OEM\ManageBuyerDetailsController@update')->name('manageBuyerDetails.update');
    Route::get('manageBuyerDetails/index/{id}', 'Truck\OEM\ManageBuyerDetailsController@index')->name('manageBuyerDetails.index');
    Route::get('downloadBuyerList/{status}', 'Truck\OEM\ManageBuyerDetailsController@downloadBuyerList')->name('downloadBuyerList');
    Route::resource('manageUser', 'Truck\OEM\ManageUserController');
    Route::resource('VinChassis', 'Truck\OEM\VINChassisController');
    Route::get('downloadBuyerStages', 'Truck\OEM\VINChassisController@downloadBuyerStages')->name('downloadBuyerStages');
    Route::get('uploadSales', 'Truck\OEM\ManageUserController@uploadSales')->name('uploadSales');
    Route::get('uploadSalesReport', 'Truck\OEM\ManageUserController@uploadSalesReport')->name('uploadSalesReport');
    Route::get('sales/download/{data}', 'Truck\OEM\ManageUserController@salesDownload')->name('sales.download');
    Route::post('uploadSalesData', 'Truck\OEM\ManageUserController@uploadSalesData')->name('uploadSalesData');
    Route::get('manageBulkBuyerDetails/index/{id}', 'Truck\OEM\ManageBulkBuyerDetailsController@index')->name('manageBulkBuyerDetails.index');
    Route::get('manageBulkBuyerDetails/create/{id}', 'Truck\OEM\ManageBulkBuyerDetailsController@managePreview')->name('manageBulkBuyerDetails.create');
    Route::put('manageBulkBuyerDetails/action/{id}', 'Truck\OEM\ManageBulkBuyerDetailsController@manageOemRevertApprove')->name('manageBulkBuyerDetails.action');
    Route::get('bulkdownloadBuyerList/{status}', 'Truck\OEM\ManageBulkBuyerDetailsController@bulkdownloadBuyerList')->name('bulkdownloadBuyerList');
    Route::get('Empsbuyer/index/{id}', 'Truck\OEM\EmpsAuthBuyerController@index')->name('Empsbuyer.index');
    Route::get('Empsbuyer/create/{id}', 'Truck\OEM\EmpsAuthBuyerController@create')->name('Empsbuyer.cerate');
    Route::resource('Empsbuyer', 'Truck\OEM\EmpsAuthBuyerController')->except(['create', 'index']);
    Route::get('claimUploadDoc/{claimid}', 'Truck\OEM\Claim\ClaimToMhiController@claimUploadDoc')->name('claimUploadDoc');
    Route::post('claimDocStore', 'Truck\OEM\Claim\ClaimToMhiController@claimDocStore')->name('claimDocStore');
    Route::post('claimDocUpdate', 'Truck\OEM\Claim\ClaimToMhiController@claimDocUpdate')->name('claimDocUpdate');
    Route::get('claimDocSubmit/{claimid}', 'Truck\OEM\Claim\ClaimToMhiController@claimDocSubmit')->name('claimDocSubmit');
    Route::post('revertClaimDoc', 'Truck\OEM\Claim\ClaimToMhiController@revertClaimDoc')->name('revertClaimDoc');
});

// Testing Agency
Route::group(['middleware' => ['role:TESTINGAGENCY|MHI|MHI-AS|MHI-DS|MHI-OnlyView|PMA|OEM-Truck', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::resource('modelRequests', 'Truck\TestingAgency\ModelRequestController');
    Route::get('modelRequests/create/{id}', 'Truck\TestingAgency\ModelRequestController@create')->name('modelRequests.create');
    Route::post('modelPreview', 'Truck\TestingAgency\ModelRequestController@modelPreview')->name('modelPreview');
    Route::post('modelRevert', 'Truck\TestingAgency\ModelRequestController@modelRevert')->name('modelRevert');
    Route::post('modelRevertMHI', 'Truck\TestingAgency\ModelRequestController@modelRevertMHI')->name('modelRevertMHI');
    Route::get('modelRequestsChart/{id}', 'Truck\TestingAgency\ModelRequestController@modelChart')->name(name: 'modelChart.show');
});


############### Dealer ####################################

Route::group(['middleware' => ['role:DEALER-Truck']], function () {
    Route::get('/dealer/view-certificate/{id}', 'Truck\Dealer\ManageCertificateController@index')->name('dealer.view_certificate');
    Route::get('/multi/buyer/view-certificate/{id}', 'Truck\Dealer\ManageCertificateController@multiBuyerVoucher')->name('dealer.multiBuyerVoucher');
    Route::get('buyerdetail/multi-buyers', 'Truck\Dealer\MultiBuyerDetailController@index')->name('buyerdetail.multi_buyers');
    Route::get('buyerdetail/multi-create', 'Truck\Dealer\MultiBuyerDetailController@multiCreate')->name('buyerdetail.multi_create');
    Route::post('buyerdetail/multi-create', 'Truck\Dealer\MultiBuyerDetailController@generateId')->name('buyerdetail.generateId');
    Route::get('buyerdetail/multi-detail-edit/{id}', 'Truck\Dealer\MultiBuyerDetailController@multiEdit')->name('buyerdetail.multi_detail_edit');
    Route::patch('buyerdetail/multi-create/{id}', 'Truck\Dealer\MultiBuyerDetailController@multiUpdate')->name('buyerdetail.multi_update');
    Route::post('buyerdetail/submit-oem', 'Truck\Dealer\MultiBuyerDetailController@manageOemSubmit')->name('buyerdetail.submit_oem');
    Route::get('buyerdetail/multi-invoice-manage/{id}/{row_id}', 'Truck\Dealer\MultiBuyerDetailController@manageInvoice')->name('buyerdetail.manageInvoice');
    Route::post('buyerdetail/multi-invoice-update', 'Truck\Dealer\MultiBuyerDetailController@manageInvoiceDocs')->name('buyerdetail.multi_invoice_update');
    Route::post('buyerdetail/multi-invoice-submit', 'Truck\Dealer\MultiBuyerDetailController@manageInvoiceDocsSubmit')->name('buyerdetail.multi_invoice_submit');
    Route::post('buyerdetail/update-incentive', 'Truck\Dealer\BuyerDetailController@updateIncentive')->name('buyerdetail.update.incentive');
    Route::post('multibuyerdetail/multi-export-data', 'Truck\Dealer\MultiBuyerDetailController@multiexportData')->name('multibuyerdetail.export_data');
    Route::get('get_cd_data/{cd}', 'Truck\Dealer\BuyerDetailController@getCdData')->name('get_cd_data');
    Route::resource('buyerdetail', 'Truck\Dealer\BuyerDetailController');
    
    Route::post('aadhar_api_data', 'Truck\Dealer\BuyerDetailController@aadhar_api_data')->name('aadhar_api_data');
    Route::get('vin/getcode/{val}/{oemid}', 'Truck\Dealer\BuyerDetailController@getcode')->name('vin.getcode');
    Route::get('customer/type/{val}', 'Truck\Dealer\BuyerDetailController@type')->name('customer.type');
    Route::get('check/adhar/{name}/{adhar}/{segid}', 'Truck\Dealer\BuyerDetailController@CheckAdhar')->name('check.adhar');
    Route::get('sendOtp/{mobile}/{msg}', 'Truck\Dealer\BuyerDetailController@sendOtp')->name('sendOtp');
    Route::get('verifybuyer/{otp}', 'Truck\Dealer\BuyerDetailController@verifybuyer')->name('verifybuyer');
    Route::match(['PUT', 'PATCH'], 'buyer/update/{id}', 'Truck\Dealer\BuyerDetailController@update')->name('buyer.update');
    Route::get('ack/view/{id}', 'Truck\Dealer\AckViewController@AckView')->name('ack.view');
    Route::get('buyer/submit/{id}', 'Truck\Dealer\AckViewController@FinallSubmit')->name('buyer.submit');
    Route::get('ack/doc/{id}', 'Truck\Dealer\AckViewController@AckDoc')->name('buyerdetail.ackdoc');
    Route::match(['PUT', 'PATCH'], 'ack/update/{id}', 'Truck\Dealer\AckViewController@update')->name('ack.update');
    Route::get('buyer/oemreturn', 'Truck\Dealer\AckViewController@OemReturn')->name('buyer.oemreturn');
    Route::get('buyerbulk/oemreturn', 'Truck\Dealer\MultiBuyerDetailController@BulkOemReturn')->name('buyerbulk.oemreturn');
    Route::post('/update-temp-reg', 'Truck\Dealer\BuyerDetailController@updateTempReg')->name('update-temp-reg');
    Route::resource('Evoucher', 'Truck\Dealer\EvoucherController');
    Route::post('buyerdetail/export-data', 'Truck\Dealer\BuyerDetailController@exportData')->name('buyerdetail.export_data');
    Route::post('buyerdetail/search-vin', 'Truck\Dealer\BuyerDetailController@searchVin')->name('buyerdetail.search_vin');
    Route::resource('manageOperator', 'Truck\Dealer\ManageOperatorController');
    Route::get('manageOperator/updateOperator/{id}', 'Truck\Dealer\ManageOperatorController@updateOperator')->name('updateOperator.update');
    Route::post('save/invoice', 'Truck\Dealer\MultiBuyerDetailController@saveInvoice')->name('save.invoice');
    Route::resource('RCReport', 'Truck\Dealer\RCReportController');
    Route::post('empsbuyer', 'Truck\Dealer\EmpsAuthController@create')->name('empsbuyer.create');
    Route::get('empsbuyer/show_detail/{id}', 'Truck\Dealer\EmpsAuthController@show_detail')->name('empsbuyer.show_detail');
    Route::get('empsbuyer/emps_auth', 'Truck\Dealer\EmpsAuthController@emps_auth')->name('empsbuyer.emps_auth');
    Route::get('empsbuyer/evoucher/{id}', 'Truck\Dealer\EmpsAuthController@evoucher')->name('empsbuyer.download');
    Route::post('empsbuyer/export_data', 'Truck\Dealer\EmpsAuthController@export_data')->name('empsbuyer.export_data');
    Route::resource('empsbuyer', 'Truck\Dealer\EmpsAuthController');
});
Route::group(['middleware' => ['role:OEM-Truck']], function () {
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
    Route::post('fetchClaimDetails', 'Admin\ClaimReportController@fetchClaimDetails')->name('fetchClaimDetails');
    Route::get('fetchClaimVin/{oemId}/{segment_id}', 'Admin\ClaimReportController@fetchClaimVin')->name('fetchClaimVin');
    Route::get('view-details/{oemId}/{claimnumberformat}', 'Admin\ClaimReportController@viewDetails')->name('viewDetails');
    Route::get('stateSalesReport/{portal}', 'Admin\AdminController@StateSalesReportEdrive')->name('state-sales-report');
    Route::resource('claimEvaluation', 'PMA\ClaimEvaluationController');
    Route::get('claimEvaluation/search/{oem}/{segm}', 'PMA\ClaimEvaluationController@search')->name('claimEvaluation.search');
    Route::get('claimEvaluation/submit/{claim_id}/{auditor_id}', 'PMA\ClaimEvaluationController@claimsubmit')->name('claimEvaluation.submit');
    Route::get('claimEvaluation/download/{id}', 'PMA\ClaimEvaluationController@downloadUploadedFile')->name('claimEvaluation.download');
    Route::get('buyDetailView/{claimId?}', 'PMA\ClaimEvaluationController@buyDetailView')->name('claimEvaluation.buyDetailView');
    Route::resource('oemChartDetails', 'Admin\FlowChart\OemDetailController');
    Route::resource('modelChartDetails', 'Admin\FlowChart\ModelChartDetailController');
    Route::resource('EmpsAuthDetails', 'Admin\FlowChart\EmpsAuthDetailController');
    Route::get('vahanReport/{portal}', 'PMA\PMAController@vahanReportView')->name('vahanReport.View');
});


Route::group(['middleware' => ['role:OEM-Truck']], function () {
    Route::get('modelmis', 'PMA\PMAController@modelmis')->name('modelmis');
    Route::get('evoucherReport', 'PMA\PMAController@evoucherReport')->name('evoucherReport');
    Route::get('oemWiseSales', 'PMA\PMAController@oemWiseSales')->name('oemWiseSales');
    Route::post('evoucherReportfiler', 'PMA\PMAController@evoucherReportFilter')->name('evoucherReportFilter');
    Route::get('oemwisemodel', 'PMA\OEMWiseModelController@index')->name('oemwisemodel.index');
    Route::get('oemwisemodel/show/{oemid}', 'PMA\OEMWiseModelController@show')->name('oemwisemodel.show');
    Route::get('oemwisemodel/modelDetails/{modelid}', 'PMA\OEMWiseModelController@modelDetails')->name('oemwisemodel.modelDetails');
});

Route::group(['middleware' => ['role:OEM-Truck|DEALER-Truck|PMA']], function () {
    Route::post('vahanReport/generate', 'PMA\PMAController@vahanReportGenerate')->name('vahanReport.generate');
    Route::get('ackdoc/finalview/{id}', 'Truck\Dealer\AckViewController@view')->name('ackdoc.finalview');
    Route::get('viewclaims/{id}', 'PMA\PMAController@viewclaims')->name('viewclaims');
    Route::get('buyerdetail/multi-buyer-preview/{id}/{userType}', 'Truck\Dealer\MultiBuyerDetailController@managePreview')->name('buyerdetail.multi_buyer_preview');
    Route::get('buyerdetail/multi-invoice-preview/{id}/{row_id}/{flag}/{user}', 'Truck\Dealer\MultiBuyerDetailController@mangeInvoicePreview')->name('buyerdetail.manage_invoice_preview');
    Route::get('buyerdetail/vin/multi-invoice-preview/{id}/{row_id}', 'Truck\Dealer\MultiBuyerDetailController@mangeVinWiseInvoicePreview')->name('buyerdetail.vin.manage_invoice_preview');
    Route::resource('manageCompanyDetails', 'Truck\OEM\ManageCompanyDetailsController');
    Route::post('manageCompanyDetails/submitToPma', 'Truck\OEM\ManageCompanyDetailsController@submitToPma')->name('manageCompanyDetails.submitToPma');
    Route::get('vahanModel', 'PMA\PMAController@manageVahanModel')->name('vahanModel');
    Route::get('fetchModelDetails', 'PMA\PMAController@fetchModelDetails')->name('fetch-model-details');
    Route::post('vahanModelSave', 'PMA\PMAController@saveVahanModel')->name('vahanModel.save');
    Route::get('vahanModelExport', 'PMA\PMAController@exportVahan')->name('vahanModel.export');
});


Route::group(['middleware' => ['role:PMA|OEM-Truck', 'verified', 'TwoFA', 'IsApproved']], function () {
    Route::resource('vinEdit', 'PMA\EditVinController');
    Route::post('vinEdit/create', 'PMA\EditVinController@create')->name('vinEdit.create');
    Route::get('vinSearch/{id}', 'PMA\EditVinController@vinSearch')->name('vinSearch');
    Route::resource('editVin', 'Truck\OEM\VinEditController');
    Route::get('editVin/create/{id}', 'Truck\OEM\VinEditController@create')->name('editVin.create');
    Route::post('editVin/edit', 'Truck\OEM\VinEditController@edit')->name('editVin.edit');
    Route::resource('vinExcel', 'Truck\OEM\VinExcelDownload');
    Route::get('vinFiledownload', 'Truck\OEM\VinExcelDownload@downloadVinFile')->name('vinFiledownload');
    Route::post('upload/vinexcel', 'Truck\OEM\VinExcelDownload@uploadVinExcel')->name('upload.vinexcel');
});

Route::group(['middleware' => ['role:OEM-Truck|MHI-AS|MHI-DS|PMA|MHI']], function () {
    Route::get('authenticationReport', 'MISController@index')->name('authenticationReport.index');
});
