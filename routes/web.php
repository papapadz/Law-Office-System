<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Collection;
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

$app_url = config("app.url");
if (!empty($app_url)) {
    URL::forceRootUrl($app_url);
    $schema = explode(':', $app_url)[0];
    URL::forceScheme($schema);
}

use App\User;

Auth::routes([
    'verify' => true
]);

Route::get('/', function () {
    if(Auth::user())
        return redirect('home');
    else
        return view('home');
});

Route::middleware(['verified'])->group(function (){
    
    Route::get('/OnCon/', function () {
        return redirect('home');
    });
  
    Route::get('/home', 'HomeController@index')->name('home');
    
    // ADMIN ENDPOINTS
    /** all admin pages will be checked via Admin Middleware, non admins cannot access the following routes */
    Route::middleware(['admin'])->group(function() {
        Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');

        Route::get('/admin/query/{type}', 'AdminController@AdminQueryType')->name('admin.query');

        Route::get('/admin/details/{id}', 'AdminController@QueryDetails')->name('admin.detail');

        Route::get('/admin/account/{id}', 'AdminController@AccountList')->name('admin.account');

        Route::get('/admin/user/{id}', 'AdminController@AccountDetails')->name('admin.user');

        Route::post('/admin/approve', 'AdminController@ApproveLawyer')->name('admin.approve');

        Route::post('/admin/assign', 'AdminController@AssignQuery')->name('admin.assign');

        Route::get('/admin/feedbacks', 'AdminController@feedbacks')->name('admin.feedbacks');

        Route::get('/admin/payments', 'AdminController@payments')->name('admin.payments');

        Route::get('/admin/inquiries', 'AdminController@Inquiries')->name('admin.inquiries');

        Route::post('/admin/inquiries/approve', 'AdminController@ApproveInquiry')->name('inquiries.approve');

        Route::get('/admin/inquiries/{id}', 'AdminController@inquirydetails')->name('inquiry.details');

        Route::get('/admin/feedback/{id}', 'AdminController@feedback')->name('admin.feedback');

        Route::post('/admin/feedback/approve', 'AdminController@ApproveFeedback')->name('feedback.approve');

        Route::get('/admin/createNewAdmin', 'AdminController@createnewadmin')->name('admin.CreateNewAdmin');

        Route::post('/admin/createNewAdmin', 'AdminController@StoreNewAdmin')->name('admin.storeNewAdmin');

        Route::get('/admin/audit', 'AdminController@Audits')->name('admin.audit');
    });
    // ADMIN ENDPOINTS

    /** Added middleware for Clients and Lawyers */
    // LAWYER ENDPOINTS
    //Route::middleware(['lawyer.only'])->group(function() {
        
        Route::get('/lawyer/query/{id}', 'LawyerController@LawyerQuery')->name('lawyer.query');

        Route::post('/lawyer/query', 'LawyerController@AcceptOnlineQuery')->name('lawyer.accept'); 
    //});
    // LAWYER ENDPOINTS
    
    //Route::middleware(['user.only'])->group(function() {
        
        Route::get('/user/profile', 'ProfileController@profile')->name('user.profile');

        Route::post('/user/profile/changepassword', 'ProfileController@ChangePassword')->name('user.changepassword');

        Route::post('/user/profile/updateprofile', 'ProfileController@UpdateProfile')->name('user.updateprofile');

        Route::get('/user/query', 'ProfileController@query')->name('user.queries');

        Route::get('/user/query/{id}', 'ProfileController@QueryProfile')->name('user.query');

        Route::post('/user/accept', 'ProfileController@AcceptQuery')->name('user.accept');

        Route::get('/payment/details/{id}', 'ProfileController@PaymentDetails')->name('payment.details');

        Route::post('/payment/upload', 'ProfileController@UploadPayment')->name('payment.upload');

        Route::post('/profile/upload', 'ProfileController@UploadProfilePicture')->name('profile.upload');
    //});
    
    Route::get('/online/query', 'QueryController@onlinequery')->name('online.query');

    Route::get('/offline/query', 'QueryController@offlinequery')->name('offline.query');

    Route::post('/online/query', 'QueryController@StoreOnlineQuery')->name('store.online.query');

    Route::post('/offline/query', 'QueryController@StoreOfflineQuery')->name('store.offline.query');

    Route::post('/online/submit', 'QueryController@SubmitQuery')->name('online.submit');

    Route::get('/print/{id}','QueryController@print');
});





Route::get('/about', 'HomeController@about')->name('about');
Route::get('/services', 'HomeController@services')->name('services');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::post('/contact/submit', 'HomeController@SubmitContact')->name('contact.submit');

Route::get('/termsAndCondition', 'HomeController@termsAndCondition')->name('termsAndCondition');
Route::get('/privacyPolicy', 'HomeController@privacyPolicy')->name('privacyPolicy');
Route::get('/FAQs', 'HomeController@FAQs')->name('FAQs');

Route::get('/offline', 'QueryController@offline')->name('offline');
Route::get('/online', 'QueryController@online')->name('online');

Route::get('/get-token', 'TokenController@GetToken')->name('get.token');
Route::get('/create-event', 'TokenController@CreateEvent')->name('create.event');

    // Route::post('/online/query', 'QueryController@StoreOnlineQuery')->name('online.query');

/** Route for new captcha */
Route::get('/reload-captcha', [App\Http\Controllers\Auth\RegisterController::class, 'reloadCaptcha']);

/** call this for checking of unassigned queries */
Route::get('/query/check-unassigned', 'QueryController@checkUnassigned');

/** call this for checking of inactive clients */
Route::get('/clients/check-logins', 'ProfileController@archiveUsers');