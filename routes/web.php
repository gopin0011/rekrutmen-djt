<?php

use App\Http\Controllers\ApplicantActivityController;
use App\Http\Controllers\ApplicantAnswerController;
use App\Http\Controllers\ApplicantCareerController;
use App\Http\Controllers\ApplicantDocumentController;
use App\Http\Controllers\ApplicantFamilyController;
use App\Http\Controllers\ApplicantLanguageController;
use App\Http\Controllers\ApplicantProfileController;
use App\Http\Controllers\ApplicantReferenceController;
use App\Http\Controllers\ApplicantStudyController;
use App\Http\Controllers\ApplicantTrainingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CorpController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PsychotestController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\RescheduleController;

use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/reset-password', [UsersController::class, 'resetPasswordShow']);
Route::post('/reset-password', [UsersController::class, 'resetPassword']);

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    // IMPORT KANDIDAT
    Route::get('/import', [HomeController::class, 'formImport']);
    Route::post('/import-xls', [HomeController::class, 'importXlsKandidat'])->name('doUploadKandidat');

    // HOME
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // UBAH PASSWORD
    Route::get('users/ubah-password', [UsersController::class, 'changepassword'])->name('password.change');
    Route::post('users/ubah-password', [UsersController::class, 'storepassword'])->name('password.store');

    // UBAH PASSWORD
    Route::get('users/ubah-data', [UsersController::class, 'changedata'])->name('data.change');
    Route::post('users/ubah-data', [UsersController::class, 'storedata'])->name('data.store');

    // CORP
    Route::get('corps/data', [CorpController::class, 'showData'])->name('corps.data');
    Route::resource('corps', CorpController::class);

    // DEPT
    Route::get('depts/data', [DeptController::class, 'showData'])->name('depts.data');
    Route::resource('depts', DeptController::class);

    // DIRECTOR
    Route::get('director', [DirectorController::class, 'edit'])->name('director.edit');
    Route::post('director', [DirectorController::class, 'store'])->name('director.store');

    // USER
    Route::get('users/data', [UsersController::class, 'showData'])->name('users.data');
    Route::get('applicant/data', [UsersController::class, 'applicantData'])->name('applicants.data');
    Route::resource('users', UsersController::class);

    // FORM
    Route::get('forms/data', [FormController::class, 'showData'])->name('forms.data');
    Route::resource('forms', FormController::class);

    // STAFF
    Route::get('staff/active/data/{id}', [StaffController::class, 'showDataStaffActive'])->name('staffActive.data');
    Route::get('staff/active/{id}', [StaffController::class, 'staffActive'])->name('staffActive.all');

    Route::get('staff/resign/data/{id}', [StaffController::class, 'showDataStaffResign'])->name('staffResign.data');
    Route::get('staff/resign/{id}', [StaffController::class, 'staffResign'])->name('staffResign.all');

    Route::get('tlh/active/data/{id}', [StaffController::class, 'showDataTlhActive'])->name('tlhActive.data');
    Route::get('tlh/active/{id}', [StaffController::class, 'tlhActive'])->name('tlhActive.all');

    Route::get('tlh/resign/data/{id}', [StaffController::class, 'showDataTlhResign'])->name('tlhResign.data');
    Route::get('tlh/resign/{id}', [StaffController::class, 'tlhResign'])->name('tlhResign.all');

    Route::get('staff/data', [StaffController::class, 'showStaff'])->name('staff.data');
    Route::resource('staff', StaffController::class);

    // INVITATION
    Route::get('invitations/data', [InvitationController::class, 'showData'])->name('invitations.data');
    Route::get('invitations/send/{id}', [InvitationController::class, 'sendMessage'])->name('invitations.send');
    Route::resource('invitations', InvitationController::class);

    // VACANCY
    Route::get('vacancies/data', [VacancyController::class, 'showData'])->name('vacancies.data');
    Route::resource('vacancies', VacancyController::class);

    // APPLICATION
    Route::get('applications/print/{id}', [ApplicationController::class, 'print'])->name('applications.print');

    Route::get('applications/data/{id}', [ApplicationController::class, 'showData'])->name('applications.data');
    Route::get('applications/all', [ApplicationController::class, 'indexAll'])->name('applications.all');
    Route::get('applications/today', [ApplicationController::class, 'indexToday'])->name('applications.today');
    Route::post('applications/storeadmin', [ApplicationController::class, 'storeAdmin'])->name('applications.storeadmin');
    Route::resource('applications', ApplicationController::class);
    Route::get('pdfviewer/{id}', [ApplicationController::class, 'showPdf'])->name('applications.showpdf');

    // INTERVIEW
    Route::get('interviews/0/{id}', [InterviewController::class, 'index'])->name('interviews.show');
    Route::post('interviews/0/{id}', [InterviewController::class, 'store'])->name('interviews.store');

    // PSYCHOTEST
    Route::get('psychotests/0/{id}', [PsychotestController::class, 'index'])->name('psychotests.show');
    Route::post('psychotests/0/{id}', [PsychotestController::class, 'store'])->name('psychotests.store');

    // APPLICANT PROFILE
    Route::resource('applicant_profiles', ApplicantProfileController::class);

    // APPLICANT FAMILY
    Route::get('applicant_families/data', [ApplicantFamilyController::class, 'showData'])->name('applicant_families.data');
    Route::resource('applicant_families', ApplicantFamilyController::class);

    // APPLICANT STUDY
    Route::get('applicant_studies/data', [ApplicantStudyController::class, 'showData'])->name('applicant_studies.data');
    Route::resource('applicant_studies', ApplicantStudyController::class);

    // APPLICANT CAREER
    Route::get('applicant_careers/data', [ApplicantCareerController::class, 'showData'])->name('applicant_careers.data');
    Route::resource('applicant_careers', ApplicantCareerController::class);

    // APPLICANT LANGUAGE
    Route::get('applicant_languages/data', [ApplicantLanguageController::class, 'showData'])->name('applicant_languages.data');
    Route::resource('applicant_languages', ApplicantLanguageController::class);

    // APPLICANT TRAININGS
    Route::get('applicant_trainings/data', [ApplicantTrainingController::class, 'showData'])->name('applicant_trainings.data');
    Route::resource('applicant_trainings', ApplicantTrainingController::class);

    // APPLICANT ACTIVITY
    Route::get('applicant_activities/data', [ApplicantActivityController::class, 'showData'])->name('applicant_activities.data');
    Route::resource('applicant_activities', ApplicantActivityController::class);

    // APPLICANT REFERENCE
    Route::get('applicant_references/data', [ApplicantReferenceController::class, 'showData'])->name('applicant_references.data');
    Route::resource('applicant_references', ApplicantReferenceController::class);

    // APPLICANT ANSWER
    Route::resource('applicant_answers', ApplicantAnswerController::class);

    // APPLICANT DOCUMENT
    Route::get('applicant_documents/data', [ApplicantDocumentController::class, 'showData'])->name('applicant_documents.data');
    Route::resource('applicant_documents', ApplicantDocumentController::class);
    Route::post('applicant_documents/additional', [ApplicantDocumentController::class, 'storeAdditional'])->name('applicant_documents.additional.store');
    Route::delete('applicant_documents/additional/{id}', [ApplicantDocumentController::class, 'destroyAdditional'])->name('applicant_documents.additional.delete');
    Route::get('applicant_documents/additional/{userId}/{vacancyId}/{additionalUploadId}', [ApplicantDocumentController::class, 'showDataAdditional'])->name('applicant_documents.additional.data');

    // APPLICANT
    Route::get('candidates/data', [CandidateController::class, 'showData'])->name('candidates.data');
    Route::resource('candidates', CandidateController::class);

    // ADMIN EDITOR
    Route::get('mod-edit', [EditorController::class, 'index'])->name('mod.edit');

    Route::get('mod-edit/profiles/{id}', [EditorController::class, 'profile'])->name('profile.edit');

    Route::get('mod-edit/families/{id}', [EditorController::class, 'family'])->name('families.edit');
    Route::get('applicant_families/data/{id}', [EditorController::class, 'familyData'])->name('families.data');

    Route::get('mod-edit/studies/{id}', [EditorController::class, 'study'])->name('sturies.edit');
    Route::get('applicant_studies/data/{id}', [EditorController::class, 'studyData'])->name('studies.data');

    Route::get('mod-edit/careers/{id}', [EditorController::class, 'career'])->name('careers.edit');
    Route::get('applicant_careers/data/{id}', [EditorController::class, 'careerData'])->name('careers.data');

    Route::get('mod-edit/activities/{id}', [EditorController::class, 'activity'])->name('activities.edit');
    Route::get('applicant_activities/data/{id}', [EditorController::class, 'activityData'])->name('activities.data');

    Route::get('mod-edit/references/{id}', [EditorController::class, 'ref'])->name('references.edit');
    Route::get('applicant_references/data/{id}', [EditorController::class, 'refData'])->name('references.data');

    Route::get('mod-edit/documents/{id}', [EditorController::class, 'doc'])->name('documents.edit');
    Route::get('applicant_documents/data/{id}', [EditorController::class, 'docData'])->name('documents.data');

    Route::get('reschedule/', [RescheduleController::class, 'index'])->name('reschedule.index');
    Route::get('notifications', [RescheduleController::class, 'notifications'])->name('reschedule.notif');

    //Overtime
    Route::group(['prefix' => 'overtimes'], function() {
        Route::post('/store', [OvertimeController::class, 'store'])->name('overtimes.store');   
        Route::post('/detailcreate/{id}', [OvertimeController::class, 'insert'])->name('overtimes.insert');   
        Route::get('/', [OvertimeController::class, 'index'])->name('overtimes.index');   
        Route::get('/create', [OvertimeController::class, 'create'])->name('overtimes.create');   
        Route::get('/detailcreate/{id}', [OvertimeController::class, 'detailcreate'])->name('overtimes.detailcreate');   
        Route::get('/manager-app', [OvertimeController::class, 'man'])->name('overtimes.man');   
        Route::get('/hr-app', [OvertimeController::class, 'hr'])->name('overtimes.hr');   
        Route::get('/end', [OvertimeController::class, 'end'])->name('overtimes.end');   
        Route::get('/all', [OvertimeController::class, 'start'])->name('overtimes.start');   
        Route::get('/today', [OvertimeController::class, 'today'])->name('overtimes.today');   
        Route::get('/{id}/deletedetail', [OvertimeController::class, 'deletedetail'])->name('overtimes.deletedetail');
        Route::get('/{id}/delete', [OvertimeController::class, 'delete'])->name('overtimes.delete');
        Route::post('/{id}/edit', [OvertimeController::class, 'edit'])->name('overtimes.edit');
        Route::get('/print/{id}', [OvertimeController::class, 'print'])->name('overtimes.print');
        Route::get('/ca/create', [OvertimeController::class, 'ca'])->name('overtimes.ca');
        Route::post('/ca/print', [OvertimeController::class, 'caprint'])->name('overtimes.caprint');
        Route::post('/acc/{id}', [OvertimeController::class, 'acc'])->name('overtimes.acc');
        Route::get('/data/{data}', [OvertimeController::class, 'showData'])->name('overtimes.data');   
        
    });

    // encrypt or update
    // Route::get('encrypt/employees', [StaffController::class, 'convert']);
    // Route::get('encrypt/users', [UsersController::class, 'convert']);
    // Route::get('encrypt/invitations', [InvitationController::class, 'convert']);
    // Route::get('encrypt/vacancies', [VacancyController::class, 'convert']);
    // Route::get('encrypt/apply', [ApplicationController::class, 'convert']);
    // Route::get('encrypt/profile', [\App\Http\Controllers\ApplicantProfileController::class, 'convert']);
    // Route::get('encrypt/career', [\App\Http\Controllers\ApplicantCareerController::class, 'convert']);
    // Route::get('encrypt/training', [\App\Http\Controllers\ApplicantTrainingController::class, 'convert']);
    // Route::get('encrypt/study', [\App\Http\Controllers\ApplicantStudyController::class, 'convert']);
    // Route::get('encrypt/ref', [\App\Http\Controllers\ApplicantReferenceController::class, 'convert']);
    // Route::get('encrypt/fam', [\App\Http\Controllers\ApplicantFamilyController::class, 'convert']);
});

Route::get('user-interview-add/{token}', [\App\Http\Controllers\GuestController::class, 'formUserInterview'])->name('user.form.add.interview');
Route::post('user-interview-add/0/{id}', [\App\Http\Controllers\GuestController::class, 'userInterviewStore'])->name('user.form.add.interview.store');

Route::get('auto-register/{token}', [\App\Http\Controllers\GuestController::class, 'autoRegistration'])->name('auto.register');

Route::get('applications/all-print/{id}', [\App\Http\Controllers\GuestController::class, 'printAll'])->name('applications.printAll');
// https://rekrutmen.djt-system.com/guest-form
Route::get('guest-form', [\App\Http\Controllers\GuestController::class, 'forms'])->name('guest.form');
Route::get('guest-form/data', [\App\Http\Controllers\GuestController::class, 'showDataForm'])->name('guest.form.data');

Route::get('storage/{folder}/{filename}', function ($folder, $filename)
{
    $path = storage_path('app/public/' . $folder.'/'.$filename);
    
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('storage.doc');

Route::get('docs/{id}/rekrutmen.pdf', function ($id)
{
    $path = storage_path('app/public/pelamar/'.$id.'/rekrutmen.pdf');
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('storage.old.doc');

Route::get('interviews/share/{id}/{userId}/{type}', [\App\Http\Controllers\GuestController::class, 'shareHasilInterview'])->name('interviews.share.test');


// Route::get('test', [\App\Http\Controllers\GuestController::class, 'test'])->name('test');
