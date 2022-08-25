<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\StandardDeductionController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\IssuedDocumentController;
// use App\Http\Middleware\CheckMaintenanceStatus;
use App\Http\Controllers\User\SalaryController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BidCommentController;

include 'resume.php';
include 'business.php';
include 'hardware.php';

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


// Route::middleware([CheckMaintenanceStatus::class])->group(function(){
//      Route::get('home', [HomeController::class,'home']);
// });
Auth::routes(['register' => false]);
// Auth::routes();

Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware' => ['auth', 'CheckMaintenanceStatus']], function () {

     Route::get('/', 'App\Http\Controllers\Expense\DashboardController@index')->name('dashboard');
     Route::group(['prefix' => 'expense/categories'], function () {
          Route::get('/', 'App\Http\Controllers\Expense\CategoryController@index')->name('categories');
          Route::get('/add', 'App\Http\Controllers\Expense\CategoryController@add')->name('addCategory');
          Route::post('/save', 'App\Http\Controllers\Expense\CategoryController@save')->name('saveCategory');
          Route::get('/edit/{id}', 'App\Http\Controllers\Expense\CategoryController@edit')->name('editCategory');
          Route::post('/update/{id}', 'App\Http\Controllers\Expense\CategoryController@update')->name('updateCategory');
          Route::get('/delete/{id}/{type?}', 'App\Http\Controllers\Expense\CategoryController@delete')->name('deleteCategory');
          Route::get('/publish/{id}', 'App\Http\Controllers\Expense\CategoryController@publish')->name('publishCategory');
          Route::post('/archive', 'App\Http\Controllers\Expense\CategoryController@archive')->name('archiveCategory');
          Route::get('/unarchive/{id}', 'App\Http\Controllers\Expense\CategoryController@unarchive')->name('unarchiveCategory');
     });

     Route::group(['prefix' => 'expense/beneficiary'], function () {
          Route::get('/', 'App\Http\Controllers\Expense\BeneficiaryController@index')->name('beneficiaries');
          Route::get('/add', 'App\Http\Controllers\Expense\BeneficiaryController@add')->name('addBeneficiary');
          Route::post('/save', 'App\Http\Controllers\Expense\BeneficiaryController@save')->name('saveBeneficiary');
          Route::get('/edit/{id}', 'App\Http\Controllers\Expense\BeneficiaryController@edit')->name('editBeneficiary');
          Route::post('/update/{id}', 'App\Http\Controllers\Expense\BeneficiaryController@update')->name('updateBeneficiary');
          Route::get('/delete/{id}', 'App\Http\Controllers\Expense\BeneficiaryController@delete')->name('deleteBeneficiary');
          Route::get('/unarchive/{id}', 'App\Http\Controllers\Expense\BeneficiaryController@unarchive')->name('unArchiveBeneficiary');
          Route::post('/archive', 'App\Http\Controllers\Expense\BeneficiaryController@archive')->name('archiveBeneficaiary');
     });

     Route::group(['prefix' => 'expense/bank-account'], function () {
          Route::get('/', 'App\Http\Controllers\Expense\BankAccountController@index')->name('bankaccounts');
          Route::get('/add', 'App\Http\Controllers\Expense\BankAccountController@add')->name('addBankAccount');
          Route::post('/save', 'App\Http\Controllers\Expense\BankAccountController@save')->name('saveBankAccount');
          Route::get('/edit/{id}', 'App\Http\Controllers\Expense\BankAccountController@edit')->name('editBankAccount');
          Route::post('/update/{id}', 'App\Http\Controllers\Expense\BankAccountController@update')->name('updateBankAccount');
          Route::get('/delete/{id}/{type?}', 'App\Http\Controllers\Expense\BankAccountController@delete')->name('deleteBankAccount');
          Route::post('/archive', 'App\Http\Controllers\Expense\BankAccountController@archive')->name('archiveBank');
          Route::post('/validateAccountNo', 'App\Http\Controllers\Expense\BankAccountController@Check_account_no')->name('validateAccountNo');
     });

     Route::group(['prefix' => 'expense/expenses'], function () {
          Route::get('/', 'App\Http\Controllers\Expense\ExpenseController@index')->name('expenses');
          Route::get('/add', 'App\Http\Controllers\Expense\ExpenseController@add')->name('addExpense');
          Route::post('/save', 'App\Http\Controllers\Expense\ExpenseController@save')->name('saveExpense');
          Route::get('/edit/{id}', 'App\Http\Controllers\Expense\ExpenseController@edit')->name('editExpense');
          Route::post('/update/{id}', 'App\Http\Controllers\Expense\ExpenseController@update')->name('updateExpense');
          Route::get('/delete/{id}', 'App\Http\Controllers\Expense\ExpenseController@delete')->name('deleteExpense');
          Route::get('/filter', 'App\Http\Controllers\Expense\ExpenseController@index')->name('filterExpense');
          Route::get('/export', 'App\Http\Controllers\Expense\ExpenseController@export')->name('exportExpense');
          Route::post('/export', 'App\Http\Controllers\Expense\ExpenseController@exportingExpense')->name('exportingExpense');
          Route::get('/unarchive/{id}', 'App\Http\Controllers\Expense\ExpenseController@unarchive')->name('unArchiveExpense');
          Route::post('/archive', 'App\Http\Controllers\Expense\ExpenseController@archive')->name('archiveExpense');
          Route::get('/import', 'App\Http\Controllers\Expense\ExpenseController@import')->name('importExpense');
          Route::post('/import', 'App\Http\Controllers\Expense\ExpenseController@importExcelSheet')->name('importExcelSheet');
          Route::get('/import/edit/{id}', 'App\Http\Controllers\Expense\ExpenseController@editImport')->name('editImport');
          Route::any('/import/update/{id}', 'App\Http\Controllers\Expense\ExpenseController@updateDraftExpense')->name('updateDraftExpense');
          Route::any('/import/download/{id}', 'App\Http\Controllers\Expense\ExpenseController@download')->name('download');
          Route::get('/import/delete/{id}', 'App\Http\Controllers\Expense\ExpenseController@deleteDraft')->name('deleteDraft');
     });
     
     Route::group(['prefix' => 'users/'], function () {
          Route::resource('roles', RoleController::class);
          Route::resource('users', UserController::class);

          Route::post('update/{id}', [UserController::class, 'update'])->name('updateUser');;
          Route::get('get_positions_and_roles/{department_id?}', [UserController::class, 'get_positions_and_roles'])->name('getPositionsAndRoles');
     });

     Route::group(['prefix' => 'salaries'], function () {
          Route::get('manage', [SalaryController::class, 'manageSalaries'])->name('manageSalaries');
          Route::post('months/save', [SalaryController::class, 'saveSalaryMonth'])->name('saveSalaryMonth');
          Route::get('delete/salary-month/{id}', [SalaryController::class, 'delete'])->name('deleteSalaryMonth');
          Route::get('{salary_month_id}', [SalaryController::class, 'listSalaries'])->name('listSalaries');
          Route::get('add/{salary_month_id}', [SalaryController::class, 'addSalary'])->name('addSalary');
          Route::post('save/{salary_month_id}', [SalaryController::class, 'saveSalary'])->name('saveSalary');
          Route::get('employee_details/{emp_id}', [SalaryController::class, 'getEmployeeDetails'])->name('getEmployeeDetails');
          Route::get('delete/{id}', [SalaryController::class, 'deleteSalary'])->name('deleteSalary');
     });

     Route::get('profile/edit', 'App\Http\Controllers\User\UserController@edit_profile')->name('editProfile');
     Route::patch('update/profile', 'App\Http\Controllers\User\UserController@update_profile')->name('updateProfile');
     Route::get('change/password', 'App\Http\Controllers\User\UserController@change_password')->name('changePassword');
     Route::patch('update/password', 'App\Http\Controllers\User\UserController@update_password')->name('updatePassword');
     Route::get('setting/edit', 'App\Http\Controllers\User\UserController@edit_setting')->name('editSetting');
     Route::patch('setting/update', 'App\Http\Controllers\User\UserController@update_setting')->name('updateSetting');

     //----------------------employees---------------------//

     Route::get('user/detail-view/{id}', [UserController::class, 'userDetailView'])->name('user-detail');
     Route::get('user/change-status', [UserController::class, 'changeStatus'])->name('change-user-status');
     Route::get('user/change-role-dropdown', [UserController::class, 'roleDropdown'])->name('change-role-dropdown');
     Route::post('user/search', [UserController::class, 'search'])->name('search-users');
     Route::get('user/export', [UserController::class, 'userExport'])->name('users-export');
     Route::get('user/bankdetails/export', [UserController::class, 'userBankDetailsExport'])->name('users-bankDetails-export');
     Route::get('/validate-email',[UserController::class, 'validateUserEmail'])->name('validate-email');

     //----------------------user-standard-deductions--------------------//
     Route::get('standard-deduction/index', [StandardDeductionController::class, 'index'])->name('standard-deduction-index')->middleware('permission:standard-deduction-list');
     Route::post('standard-deduction/create', [StandardDeductionController::class, 'createStandardDeduction'])->name('standard-deduction-create')->middleware('permission:standard-deduction-create');
     Route::get('standard-deduction/delete/{id}', [StandardDeductionController::class, 'deleteStandardDeduction'])->name('standard-deduction-delete')->middleware('permission:standard-deduction-delete');

     //----------------------user-bank-details--------------------//

     Route::get('bank-accounts', [BankAccountController::class, 'fetchBankAccounts'])->name('fetch-bank-accounts')->middleware('permission:user-bank-ac-list');
     Route::post('bank-account/create', [BankAccountController::class, 'createBankAc'])->name('bank-account-create')->middleware('permission:user-bank-ac-create');
     Route::get('bank-ac/edit', [BankAccountController::class, 'editBankAc'])->name('bank-ac-edit')->middleware('permission:user-bank-ac-edit');
     Route::post('bank-ac/update', [BankAccountController::class, 'updateBankAc'])->name('bank-ac-update')->middleware('permission:user-bank-ac-edit');
     Route::get('bank-ac/delete', [BankAccountController::class, 'deleteBankAc'])->name('bank-ac-delete')->middleware('permission:user-bank-ac-delete');

     //----------------------issued-documents--------------------//

     Route::get('issued-documents', [IssuedDocumentController::class, 'fetchdocuments'])->name('fetch-documents')->middleware('permission:user-documents-list');
     Route::post('issued-documents/create', [IssuedDocumentController::class, 'createdocuments'])->name('documents-create')->middleware('permission:user-documents-create');
     Route::get('issued-documents/edit', [IssuedDocumentController::class, 'editdocuments'])->name('documents-edit')->middleware('permission:user-documents-edit');
     Route::post('issued-documents/update', [IssuedDocumentController::class, 'updatedocuments'])->name('documents-update')->middleware('permission:user-documents-edit');
     Route::get('issued-documents/delete', [IssuedDocumentController::class, 'deletedocuments'])->name('documents-delete')->middleware('permission:user-documents-delete');

     //-----------------------employee-attendance--------------------//
     Route::get('employee-attendance/punch-in', [AttendanceController::class, 'punchIn'])->name('employee-punch-in');
     Route::get('employee-attendance/punch-out', [AttendanceController::class, 'punchOut'])->name('employee-punch-out');
     Route::get('employee-attendance/get-time', [AttendanceController::class, 'getTotalTime'])->name('get-total-time');
     Route::get('attendance/index', [AttendanceController::class, 'index'])->name('attendance-index');
     Route::get('attendance/detail/{attendance_id}', [AttendanceController::class, 'attendanceDetail'])->name('attendance-detail');
 
     //-----------------------bids--------------------//
     Route::get('bid/comments/{id}', [BidCommentController::class, 'index'])->name('bid-comments');
     Route::post('bid/comments/store', [BidCommentController::class, 'storeComments'])->name('store-comments');
     Route::get('bid/favourite/bids', [BidCommentController::class, 'favouriteBids'])->name('favourite-bids');
});
// });
//
     // Auth::routes();

     /*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
     Route::get('/', 'App\Http\Controllers\Expense\DashboardController@index')->name('dashboard');*/
