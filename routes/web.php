<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DistrictsController;
use App\Http\Controllers\TehsilsController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\InstitutionsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\SemestersController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\StandardsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DatesheetsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubjectGroupsController;
use App\Http\Controllers\DataEntryController;
use App\Http\Controllers\FeeGroupsController;
use App\Http\Controllers\DataEntryStudentsController;
use App\Http\Controllers\AssesmentCenterController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ImportExportsController;
use App\Http\Controllers\FailedJobsController;

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

Route::get('/', function(){
	return Redirect::to('users/login');
});

Route::group(['prefix' => 'admin', 'middleware' => 'isadmin'], function () {

    Route::get('/', [AdminController::class, 'index']);
    Route::get('/index', [AdminController::class, 'index']);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');

	Route::get('/districts', [DistrictsController::class, 'index']);
	Route::get('/districts/index', [DistrictsController::class, 'index'])->name('districts.index');
	Route::get('/districts/create', [DistrictsController::class, 'create'])->name('districts.create');
	Route::post('/districts/store', [DistrictsController::class, 'store'])->name('districts.store');
	Route::post('/districts/destroy', [DistrictsController::class, 'destroy'])->name('districts.destroy');
	Route::get('/districts/edit/{id}', [DistrictsController::class, 'edit']);
	Route::post('/districts/update', [DistrictsController::class, 'update'])->name('districts.update');

	Route::get('/tehsils', [TehsilsController::class, 'index']);
	Route::get('/tehsils/index', [TehsilsController::class, 'index'])->name('tehsils.index');
	Route::get('/tehsils/create', [TehsilsController::class, 'create'])->name('tehsils.create');
	Route::post('/tehsils/store', [TehsilsController::class, 'store'])->name('tehsils.store');
	Route::post('/tehsils/destroy', [TehsilsController::class, 'destroy'])->name('tehsils.destroy');
	Route::get('/tehsils/edit/{id}', [TehsilsController::class, 'edit']);
	Route::post('/tehsils/update', [TehsilsController::class, 'update'])->name('tehsils.update');

	Route::get('/sessions', [SessionsController::class, 'index']);
	Route::get('/sessions/index', [SessionsController::class, 'index'])->name('sessions.index');
	Route::get('/sessions/create', [SessionsController::class, 'create'])->name('sessions.create');
	Route::post('/sessions/store', [SessionsController::class, 'store'])->name('sessions.store');
	Route::post('/sessions/destroy', [SessionsController::class, 'destroy'])->name('sessions.destroy');
	Route::get('/sessions/edit/{id}', [SessionsController::class, 'edit']);
	Route::post('/sessions/update', [SessionsController::class, 'update'])->name('sessions.update');

	Route::get('/institutions', [InstitutionsController::class, 'index']);
	Route::get('/institutions/index', [InstitutionsController::class, 'index'])->name('institutions.index');
	Route::get('/institutions/create', [InstitutionsController::class, 'create'])->name('institutions.create');
	Route::post('/institutions/store', [InstitutionsController::class, 'store'])->name('institutions.store');
	Route::post('/institutions/destroy', [InstitutionsController::class, 'destroy'])->name('institutions.destroy');
	Route::get('/institutions/edit/{id}', [InstitutionsController::class, 'edit']);
	Route::post('/institutions/update', [InstitutionsController::class, 'update'])->name('institutions.update');

	Route::get('/students', [StudentsController::class, 'index']);
	Route::get('/students/index', [StudentsController::class, 'index'])->name('students.index');
	Route::get('/students/search', [StudentsController::class, 'search'])->name('students.search');
	Route::get('/students/searchstudent', [StudentsController::class, 'searchstudent'])->name('students.searchstudent');
	Route::get('/students/create', [StudentsController::class, 'create'])->name('students.create');
	Route::get('/students/createsearchedstudent/{session_id}/{class_id}/{center_id}', [StudentsController::class, 'createsearchedstudent']);
	Route::post('/students/store', [StudentsController::class, 'store'])->name('students.store');
	Route::post('/students/destroy', [StudentsController::class, 'destroy'])->name('students.destroy');
	Route::get('/students/edit/{id}', [StudentsController::class, 'edit']);
	Route::get('/students/editsearchedstudent/{id}/{session_id}/{class_id}/{center_id}', [StudentsController::class, 'editsearchedstudent']);
	Route::post('/students/update', [StudentsController::class, 'update'])->name('students.update');
	Route::get('/students/getFeeData', [StudentsController::class, 'getFeeData'])->name('students.getFeeData');
	Route::get('/students/updatefee/{id}/{semester_id}', [StudentsController::class, 'updatefee']);
	Route::get('/students/updatefeebysearch/{id}/{semester_id}/{session_id}/{class_id}/{center_id}', [StudentsController::class, 'updatefeebysearch']);
	Route::post('/students/storefee', [StudentsController::class, 'storefee'])->name('students.storefee');
	Route::post('/students/getsubjectsgroupdata', [StudentsController::class, 'getsubjectsgroupdata'])->name('students.getsubjectsgroupdata');

	Route::get('/subjects', [SubjectsController::class, 'index']);
	Route::get('/subjects/index', [SubjectsController::class, 'index'])->name('subjects.index');
	Route::get('/subjects/create', [SubjectsController::class, 'create'])->name('subjects.create');
	Route::post('/subjects/store', [SubjectsController::class, 'store'])->name('subjects.store');
	Route::post('/subjects/destroy', [SubjectsController::class, 'destroy'])->name('subjects.destroy');
	Route::get('/subjects/edit/{id}', [SubjectsController::class, 'edit']);
	Route::post('/subjects/update', [SubjectsController::class, 'update'])->name('subjects.update');

	Route::get('/subjectgroups', [SubjectGroupsController::class, 'index']);
	Route::get('/subjectgroups/index', [SubjectGroupsController::class, 'index'])->name('subjectgroups.index');
	Route::get('/subjectgroups/create', [SubjectGroupsController::class, 'create'])->name('subjectgroups.create');
	Route::post('/subjectgroups/store', [SubjectGroupsController::class, 'store'])->name('subjectgroups.store');
	Route::post('/subjectgroups/destroy', [SubjectGroupsController::class, 'destroy'])->name('subjectgroups.destroy');
	Route::get('/subjectgroups/edit/{id}', [SubjectGroupsController::class, 'edit']);
	Route::post('/subjectgroups/update', [SubjectGroupsController::class, 'update'])->name('subjectgroups.update');

	Route::get('/datesheets', [DatesheetsController::class, 'index']);
	Route::get('/datesheets/index', [DatesheetsController::class, 'index'])->name('datesheets.index');
	Route::get('/datesheets/create', [DatesheetsController::class, 'create'])->name('datesheets.create');
	Route::post('/datesheets/store', [DatesheetsController::class, 'store'])->name('datesheets.store');
	Route::post('/datesheets/destroy', [DatesheetsController::class, 'destroy'])->name('datesheets.destroy');
	Route::get('/datesheets/edit/{id}', [DatesheetsController::class, 'edit']);
	Route::post('/datesheets/update', [DatesheetsController::class, 'update'])->name('datesheets.update');
	Route::post('/datesheets/getsemesters', [DatesheetsController::class, 'getsemesters'])->name('datesheets.getsemesters');
	Route::get('/datesheets/printdatesheets', [DatesheetsController::class, 'printdatesheets'])->name('datesheets.printdatesheets');
	Route::post('/datesheets/downloaddatesheet', [DatesheetsController::class, 'downloaddatesheet'])->name('datesheets.downloaddatesheet');

	Route::get('/fees', [FeesController::class, 'index']);
	Route::get('/fees/index', [FeesController::class, 'index'])->name('fees.index');
	Route::get('/fees/create', [FeesController::class, 'create'])->name('fees.create');
	Route::post('/fees/store', [FeesController::class, 'store'])->name('fees.store');
	Route::post('/fees/destroy', [FeesController::class, 'destroy'])->name('fees.destroy');
	Route::get('/fees/edit/{id}', [FeesController::class, 'edit']);
	Route::post('/fees/update', [FeesController::class, 'update'])->name('fees.update');
	Route::get('/fees/generatefeedetails', [FeesController::class, 'generatefeedetails'])->name('fees.generatefeedetails');
	Route::post('/fees/generatefeedetailsbyinstitutions', [FeesController::class, 'generatefeedetailsbyinstitutions'])->name('fees.generatefeedetailsbyinstitutions');
	Route::post('/fees/getcolumnsfordatatable', [FeesController::class, 'getcolumnsfordatatable'])->name('fees.getcolumnsfordatatable');
	Route::get('/fees/downloadfeereport/{id}/{session_id}', [FeesController::class, 'downloadfeereport']);
	Route::get('/fees/downloadcompletefeereport/{id}', [FeesController::class, 'downloadcompletefeereport']);

	Route::get('/feegroups', [FeeGroupsController::class, 'index']);
	Route::get('/feegroups/index', [FeeGroupsController::class, 'index'])->name('feegroups.index');
	Route::get('/feegroups/create', [FeeGroupsController::class, 'create'])->name('feegroups.create');
	Route::post('/feegroups/store', [FeeGroupsController::class, 'store'])->name('feegroups.store');
	Route::post('/feegroups/destroy', [FeeGroupsController::class, 'destroy'])->name('feegroups.destroy');
	Route::get('/feegroups/edit/{id}', [FeeGroupsController::class, 'edit']);
	Route::post('/feegroups/update', [FeeGroupsController::class, 'update'])->name('feegroups.update');


	Route::get('/semesters', [SemestersController::class, 'index']);
	Route::get('/semesters/index', [SemestersController::class, 'index'])->name('semesters.index');
	Route::get('/semesters/create', [SemestersController::class, 'create'])->name('semesters.create');
	Route::post('/semesters/store', [SemestersController::class, 'store'])->name('semesters.store');
	Route::post('/semesters/destroy', [SemestersController::class, 'destroy'])->name('semesters.destroy');
	Route::get('/semesters/edit/{id}', [SemestersController::class, 'edit']);
	Route::post('/semesters/update', [SemestersController::class, 'update'])->name('semesters.update');

	Route::get('/banks', [BanksController::class, 'index']);
	Route::get('/banks/index', [BanksController::class, 'index'])->name('banks.index');
	Route::get('/banks/create', [BanksController::class, 'create'])->name('banks.create');
	Route::post('/banks/store', [BanksController::class, 'store'])->name('banks.store');
	Route::post('/banks/destroy', [BanksController::class, 'destroy'])->name('banks.destroy');
	Route::get('/banks/edit/{id}', [BanksController::class, 'edit']);
	Route::post('/banks/update', [BanksController::class, 'update'])->name('banks.update');

	Route::get('/classes', [StandardsController::class, 'index']);
	Route::get('/classes/index', [StandardsController::class, 'index'])->name('classes.index');
	Route::get('/classes/create', [StandardsController::class, 'create'])->name('classes.create');
	Route::post('/classes/store', [StandardsController::class, 'store'])->name('classes.store');
	Route::post('/classes/destroy', [StandardsController::class, 'destroy'])->name('classes.destroy');
	Route::get('/classes/edit/{id}', [StandardsController::class, 'edit']);
	Route::post('/classes/update', [StandardsController::class, 'update'])->name('classes.update');

	Route::get('/exams', [ExamsController::class, 'index']);
	Route::get('/exams/index', [ExamsController::class, 'index'])->name('exams.index');
	Route::get('/exams/editmarksbysearch', [ExamsController::class, 'editmarksbysearch'])->name('exams.editmarksbysearch');
	Route::get('/exams/edit/{id}/{semester_id}/{session_id}/{class_id}/{center_id}', [ExamsController::class, 'edit']);
	Route::post('/exams/update', [ExamsController::class, 'update'])->name('exams.update');
	Route::get('/exams/generateslips', [ExamsController::class, 'generateslips'])->name('exams.generateslips');
	Route::get('/exams/generateslipsbysearch', [ExamsController::class, 'generateslipsbysearch'])->name('exams.generateslipsbysearch');
	Route::get('/exams/downloadslip/{id}', [ExamsController::class, 'downloadslip']);
	Route::post('/exams/generateinbulk', [ExamsController::class, 'generateinbulk'])->name('exams.generateinbulk');
	Route::post('/exams/downloadall', [ExamsController::class, 'downloadall'])->name('exams.downloadall');
	Route::post('/exams/generateslipbysessionid', [ExamsController::class, 'generateslipbysessionid'])->name('exams.generateslipbysessionid');
	Route::post('/exams/generateslipbydistrictid', [ExamsController::class, 'generateslipbydistrictid'])->name('exams.generateslipbydistrictid');
	Route::post('/exams/generateslipbyinstitutionid', [ExamsController::class, 'generateslipbyinstitutionid'])->name('exams.generateslipbyinstitutionid');
	Route::post('/exams/generateslipbytehsilid', [ExamsController::class, 'generateslipbytehsilid'])->name('exams.generateslipbytehsilid');
	Route::post('/exams/generateslipbycenterid', [ExamsController::class, 'generateslipbycenterid'])->name('exams.generateslipbycenterid');
	Route::post('/exams/generateslipbyclassid', [ExamsController::class, 'generateslipbyclassid'])->name('exams.generateslipbyclassid');
	Route::post('/exams/generateslipbystudenttype', [ExamsController::class, 'generateslipbystudenttype'])->name('exams.generateslipbystudenttype');
	Route::get('/exams/generateawardsheetbydata', [ExamsController::class, 'generateawardsheetbydata'])->name('exams.generateawardsheetbydata');
	Route::post('/exams/generateawardsheet', [ExamsController::class, 'generateawardsheet'])->name('exams.generateawardsheet');
	Route::get('/exams/downloadawardsheet/{id}/{session_id}/{semester_id}/{class_id}', [ExamsController::class, 'downloadawardsheet']);
	Route::get('/exams/generategazette', [ExamsController::class, 'generategazette'])->name('exams.generategazette');
	Route::post('/exams/downloadgazettebyss', [ExamsController::class, 'downloadgazettebyss'])->name('exams.downloadgazettebyss');
	Route::post('/exams/downloadgazettecombined', [ExamsController::class, 'downloadgazettecombined'])->name('exams.downloadgazettecombined');
	Route::post('/exams/downloadcompletegazette', [ExamsController::class, 'downloadcompletegazette'])->name('exams.downloadcompletegazette');
	Route::post('/exams/resetautgeneratedmeritlist', [ExamsController::class, 'resetautgeneratedmeritlist'])->name('exams.resetautgeneratedmeritlist');
	Route::post('/exams/startautogeneration', [ExamsController::class, 'startautogeneration'])->name('exams.startautogeneration');
	Route::post('/exams/generatecompletegazette', [ExamsController::class, 'generatecompletegazette'])->name('exams.generatecompletegazette');
	Route::post('/exams/downloadgazettecoverpage', [ExamsController::class, 'downloadgazettecoverpage'])->name('exams.downloadgazettecoverpage');
	Route::post('/exams/downloadministermessagepage', [ExamsController::class, 'downloadministermessagepage'])->name('exams.downloadministermessagepage');
	Route::post('/exams/downloadsecretarymessage', [ExamsController::class, 'downloadsecretarymessage'])->name('exams.downloadsecretarymessage');
	Route::post('/exams/downloadcontrollermessage', [ExamsController::class, 'downloadcontrollermessage'])->name('exams.downloadcontrollermessage');
	Route::post('/exams/downloadpreamble', [ExamsController::class, 'downloadpreamble'])->name('exams.downloadpreamble');
	Route::post('/exams/downloadpositionholders', [ExamsController::class, 'downloadpositionholders'])->name('exams.downloadpositionholders');
	Route::post('/exams/downloaddistrictwisepositionholders', [ExamsController::class, 'downloaddistrictwisepositionholders'])->name('exams.downloaddistrictwisepositionholders');
	Route::post('/exams/overalltoptenpositionholders', [ExamsController::class, 'overalltoptenpositionholders'])->name('exams.overalltoptenpositionholders');
	Route::post('/exams/downloadpiegraphoverallsummary', [ExamsController::class, 'downloadpiegraphoverallsummary'])->name('exams.downloadpiegraphoverallsummary');
	Route::post('/exams/downloadbargraphdistrictwiseresultsummary', [ExamsController::class, 'downloadbargraphdistrictwiseresultsummary'])->name('exams.downloadbargraphdistrictwiseresultsummary');
	Route::post('/exams/downloadbargraphdistrictwisesummary', [ExamsController::class, 'downloadbargraphdistrictwisesummary'])->name('exams.downloadbargraphdistrictwisesummary');
	Route::post('/exams/downloadsubjectwiseresultpercentage', [ExamsController::class, 'downloadsubjectwiseresultpercentage'])->name('exams.downloadsubjectwiseresultpercentage');
	Route::post('/exams/bargraphsubjectwisedistrictsummary', [ExamsController::class, 'bargraphsubjectwisedistrictsummary'])->name('exams.bargraphsubjectwisedistrictsummary');
	Route::post('/exams/printcompletegazettewithpages', [ExamsController::class, 'printcompletegazettewithpages'])->name('exams.printcompletegazettewithpages');
	Route::post('/exams/generatetableofcontents', [ExamsController::class, 'generatetableofcontents'])->name('exams.generatetableofcontents');

	Route::get('/settings/index', [SettingsController::class, 'index']);
	Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');

	Route::get('/failedjobs/index', [FailedJobsController::class, 'index'])->name('failedjobs.index');
	Route::post('/failedjobs/destroy', [FailedJobsController::class, 'destroy'])->name('failedjobs.destroy');
	Route::post('/failedjobs/destroyall', [FailedJobsController::class, 'destroyall'])->name('failedjobs.destroyall');

	Route::get('/exams/generatemarksheets', [ExamsController::class, 'generatemarksheets'])->name('exams.generatemarksheets');
	Route::get('/exams/generatemarksheetsbysearch', [ExamsController::class, 'generatemarksheetsbysearch'])->name('exams.generatemarksheetsbysearch');
	Route::post('/exams/downloadallmarksheets', [ExamsController::class, 'downloadallmarksheets'])->name('exams.downloadallmarksheets');
	Route::post('/exams/downloadalldetailedmarksheets', [ExamsController::class, 'downloadalldetailedmarksheets'])->name('exams.downloadalldetailedmarksheets');
	Route::get('/exams/downloadmarksheet/{id}', [ExamsController::class, 'downloadmarksheet']);
	Route::get('/exams/downloaddetailedmarksheet/{id}', [ExamsController::class, 'downloaddetailedmarksheet']);
	Route::get('/exams/updatemarksbycenters', [ExamsController::class, 'updatemarksbycenters'])->name('exams.updatemarksbycenters');
	Route::post('/exams/storemarksbycenters', [ExamsController::class, 'storemarksbycenters'])->name('exams.storemarksbycenters');
	Route::post('/exams/storedatabystudents', [ExamsController::class, 'storedatabystudents'])->name('exams.storedatabystudents');
	
	Route::get('/importsexports/export', [ImportExportsController::class, 'export'])->name('importsexports.export');
	Route::post('/importsexports/reset', [ImportExportsController::class, 'reset'])->name('importsexports.reset');
	Route::post('/importsexports/set', [ImportExportsController::class, 'set'])->name('importsexports.set');
	Route::post('/importsexports/exportstudents', [ImportExportsController::class, 'exportstudents'])->name('importsexports.exportstudents');
	Route::post('/importsexports/resetstudents', [ImportExportsController::class, 'resetstudents'])->name('importsexports.resetstudents');

	Route::get('/importsexports/import', [ImportExportsController::class, 'import'])->name('importsexports.import');
	Route::post('/importsexports/importstudents', [ImportExportsController::class, 'importstudents'])->name('importsexports.importstudents');
	Route::post('/importsexports/importexamdata', [ImportExportsController::class, 'importexamdata'])->name('importsexports.importexamdata');
});

Route::group(['prefix' => 'dataentry', 'middleware' => 'isdataentry'], function () {
	Route::get('/index', [DataEntryController::class, 'index']);
	Route::get('/', [DataEntryController::class, 'index']);
	Route::get('/dashboard', [DataEntryController::class, 'index']);

	Route::get('/students/searchbycenter', [DataEntryStudentsController::class, 'searchbycenter']);
	Route::get('/students/searchedstudents', [DataEntryStudentsController::class, 'searchedstudents'])->name('destudents.searchedstudents');
	Route::get('/students/createsearched/{session_id}/{class_id}/{center_id}', [DataEntryStudentsController::class, 'create'])->name('destudents.createsearched');
	Route::get('/students/create', [DataEntryStudentsController::class, 'create'])->name('destudents.create');
	Route::post('/students/store', [DataEntryStudentsController::class, 'store'])->name('destudents.store');
	Route::post('/students/destroy', [DataEntryStudentsController::class, 'destroy'])->name('destudents.destroy');
	Route::get('/students/edit/{id}/{session_id}/{class_id}/{center_id}', [DataEntryStudentsController::class, 'edit']);
	Route::post('/students/update', [DataEntryStudentsController::class, 'update'])->name('destudents.update');
	Route::get('/students/getFeeData', [DataEntryStudentsController::class, 'getFeeData'])->name('destudents.getFeeData');
	Route::get('/students/updatefee/{id}/{semester_id}', [DataEntryStudentsController::class, 'updatefee']);
	Route::get('/students/updatefeestep/{id}/{semester_id}', [DataEntryStudentsController::class, 'updatefeestep']);
	Route::get('/students/updatefeestepsearched/{id}/{semester_id}/{session_id}/{class_id}/{center_id}', [DataEntryStudentsController::class, 'updatefeestepsearched']);
	Route::post('/students/storefee', [DataEntryStudentsController::class, 'storefee'])->name('destudents.storefee');
	Route::post('/students/getsubjectsgroupdata', [DataEntryStudentsController::class, 'getsubjectsgroupdata'])->name('destudents.getsubjectsgroupdata');
});

Route::group(['prefix' => 'assessmentcenter', 'middleware' => 'isassessmentcenter'], function () {
	Route::get('/index', [AssesmentCenterController::class, 'index']);
	Route::get('/', [AssesmentCenterController::class, 'index']);
	Route::get('/dashboard', [AssesmentCenterController::class, 'index']);

	Route::get('/marks', [MarksController::class, 'index']);
	Route::get('/marks/index', [MarksController::class, 'index'])->name('marks.index');
	Route::get('/marks/edit/{id}/{semester_id}', [MarksController::class, 'edit']);
	Route::post('/marks/update', [MarksController::class, 'update'])->name('marks.update');
	Route::get('/marks/updatemarksbycenters', [MarksController::class, 'updatemarksbycenters'])->name('marks.updatemarksbycenters');
	Route::post('/marks/storemarksbycenters', [MarksController::class, 'storemarksbycenters'])->name('marks.storemarksbycenters');
	Route::post('/marks/storedatabystudents', [MarksController::class, 'storedatabystudents'])->name('marks.storedatabystudents');
	Route::post('/marks/getsemesters', [MarksController::class, 'getsemesters'])->name('marks.getsemesters');
	
});

Route::get('users/login', [UsersController::class, 'index'])->name('users.login');
Route::post('users/signin', [UsersController::class, 'signin'])->name('users.signin');
Route::get('users/register', [UsersController::class, 'register'])->name('users.register');
//Route::get('users/forgetpassword', [UsersController::class, 'forgetpassword'])->name('users.forgetpassword');
//Route::get('users/resetpassword/{email}', [UsersController::class, 'resetpassword']);
//Route::post('users/verifyemail', [UsersController::class, 'verifyemail'])->name('users.verifyemail');
//Route::post('users/setnewpassword', [UsersController::class, 'setnewpassword'])->name('users.setnewpassword');
Route::get('users/signout', [UsersController::class, 'signout'])->name('users.signout');
//Route::post('users/storeuser', [UsersController::class, 'storeuser'])->name('users.storeuser');
Route::get('users/permissiondenied', [UsersController::class, 'permissiondenied'])->name('users.permissiondenied');