<?php

use App\Http\Controllers\admin\articleConfiguration;
use App\Models\Booking;
use App\Http\Controllers\admin\fieldConfiguration;
use App\Http\Controllers\admin\voucherConfiguration;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SparingController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\ListBookingController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\FieldScheduleController;
use App\Http\Controllers\auth\SetPasswordController;
use App\Http\Controllers\RescheduleRequestController;
use App\Http\Controllers\auth\ForgotPasswordController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/try', function () {
    return view('articles.articledetail');
});

//Route Register
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

//Route Login
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authentication'])->middleware('guest')->name('login.authentication');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('forgotPassword.index');
Route::post('/forgot-password', [ForgotPasswordController::class, 'validateData'])->middleware('guest')->name('forgotPassword.validate');
Route::get('/set-password/{id}', [SetPasswordController::class, 'edit'])->middleware('password.forgot')->name('setPassword.edit');
Route::put('/set-password/{id}', [SetPasswordController::class, 'update'])->name('setPassword.update');

//Route Article Umum
Route::get('/article', [ArticleController::class, 'userIndex'])->name('article.userIndex');
Route::get('/article/{id}', [ArticleController::class, 'Usershow'])->name('article.userShow');
// Route::get('/article/{id}', [ArticleController::class, 'userShow'])->name('article.userShow');

// Field Schedule (halaman pilih jadwal untuk dipesan)
Route::get('/field-schedule', [FieldScheduleController::class, 'index'])->name('schedule.index');
Route::post('/field-schedule', [FieldScheduleController::class, 'scheduleValidate'])->middleware('auth')->name('schedule.scheduleValidate');
Route::get('/field-schedule/reschedule/{list_booking}', [FieldScheduleController::class, 'reschedule'])->name('schedule.reschedule');
Route::post('/field-schedule/reschedule/{list_booking}', [FieldScheduleController::class, 'rescheduleValidate'])->name('schedule.rescheduleValidate');
Route::post('/field-schedule/cancel/{list_booking}', [ListBookingController::class, 'cancel'])->name('schedule.cancel');

// Booking & Pembayaran
Route::get('/payment', [BookingController::class, 'payment'])->name('booking.payment');
Route::post('payment/voucher', [BookingController::class, 'useVoucher'])->name('booking.voucher');
Route::post('payment/user-offline', [BookingController::class, 'userOffline'])->name('booking.userOffline');
Route::post('/payment', [BookingController::class, 'store'])->name('booking.store');
Route::get('/payment/uploud', [BookingController::class, 'paymentUploud'])->name('booking.paymentUploud');
Route::put('/payment/uploadImage', [BookingController::class, 'paymentUploudValidate'])->name('booking.paymentUploudValidate');
Route::get('/payment/success', [BookingController::class, 'paymentSuccess'])->name('booking.paymentSuccess');
Route::get('/payment/image/{filename}', [FileController::class, 'getPaymentUploud'])->name('booking.paymentImage');

//sparring
Route::get('/sparing', [SparingController::class, 'index'])->name('sparing.index');
Route::post('/sparing', [SparingController::class, 'store'])->name('sparing.store');
Route::post('/sparing/request/{sparing}', [SparingController::class, 'addRequest'])->name('sparing.request');
Route::put('/sparing/accept/{sparing_req}', [SparingController::class, 'acceptRequest'])->name('sparing.accept');
Route::put('/sparing/reject/{sparing_req}', [SparingController::class, 'rejectRequest'])->name('sparing.reject');

// rating
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

// profile
Route::get('/profile-user', [ProfileUserController::class, 'index'])->name('profile.show');
Route::put('/profile-user', [ProfileUserController::class, 'update'])->name('profile.update');
Route::post('/profile-user/image', [ProfileUserController::class, 'updateImage'])->name('profile.updateImage');

// Notification
Route::get('/notification', [NotificationController::class, 'index'])->name('notication.index');
Route::post('/notification/read/{notification}', [NotificationController::class, 'markAsRead'])->name('notification.markAsRead');

// Admin
Route::prefix('/admin')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/bookings-data', [AdminController::class, 'getData']);

    // field photo
    Route::get('/field-photo', [fieldConfiguration::class, 'fieldPhoto'])->name('field.photo');
    Route::get('/field-description', [fieldConfiguration::class, 'fieldDescription'])->name('field.description');
    Route::get('/field-fasility', [fieldConfiguration::class, 'fieldFasility'])->name('field.fasility');
    Route::post('/upload-image-slider', [fieldConfiguration::class, 'uploadSlider'])->name('upload.slider');
    Route::post('/upload-image-banner', [fieldConfiguration::class, 'uploadBanner'])->name('upload.banner');
    Route::post('/upload-image-image', [fieldConfiguration::class, 'uploadImage'])->name('upload.image');
    Route::delete('/delete-image/{id}', [fieldConfiguration::class, 'deleteImage'])->name('delete.image');
    Route::post('/update-description', [fieldConfiguration::class, 'updateDescription'])->name('description.update');
    Route::post('/update-facilities', [FieldConfiguration::class, 'updateFasility'])->name('facilities.update');

    // all booking
    Route::get('/all-booking', [AdminController::class, 'allBooking'])->name('admin.allBooking');

    // approve booking
    Route::get('/approve-booking', [AdminController::class, 'approveBooking'])->name('admin.booking');
    Route::put('/approve-booking/accept/{booking}', [BookingController::class, 'acceptBooking'])->name('admin.acceptBooking');
    Route::put('/approve-booking/reject/{booking}', [BookingController::class, 'rejectBooking'])->name('admin.rejectBooking');

    // reschedule booking
    Route::get('/reschedule-booking', [AdminController::class, 'rescheduleBooking'])->name('admin.reschedule');
    Route::post('/reschedule-booking/accept/{listBooking}/{request}', [ListBookingController::class, 'acceptReschedule'])->name('admin.acceptReschedule');
    Route::post('/reschedule-booking/reject/{listBooking}/{request} ', [ListBookingController::class, 'rejectReschedule'])->name('admin.rejectReschedule');

    // cancel booking
    Route::get('/cancel-booking', [AdminController::class, 'cancelBooking'])->name('admin.cancel');
    Route::put('/cancel-booking/accept/{listBooking}', [ListBookingController::class, 'acceptCancelBooking'])->name('admin.acceptCancelBooking');
    Route::put('/cancel-booking/reject/{listBooking}', [ListBookingController::class, 'rejectCancelBooking'])->name('admin.rejectCancelBooking');

    // Admin Article
    Route::get('/article', [articleConfiguration::class, 'index'])->name('admin.article');
    Route::get('/article/create', [articleConfiguration::class, 'create'])->name('admin.article.create');
    Route::post('/article/store', [articleConfiguration::class, 'store'])->name('admin.article.store');
    Route::post('/article/upload-image', [articleConfiguration::class, 'upload'])->name('admin.article.upload');
    Route::post('/article/fetch-image', [articleConfiguration::class, 'fetch'])->name('admin.article.fetch');
    Route::get('/show-article/{id}', [ArticleConfiguration::class, 'show'])->name('admin.article.show');
    Route::delete('/article/delete/{id}', [articleConfiguration::class, 'destroy'])->name('admin.article.destroy');
    Route::get('/article/update/{id}', [articleConfiguration::class, 'update'])->name('admin.article.update');
    Route::post('/article/edit/{id}', [articleConfiguration::class, 'edit'])->name('admin.article.edit');

    // Admin Voucher
    Route::get('/voucher', [voucherConfiguration::class, 'index'])->name('admin.voucher');
    Route::post('/voucher/store', [voucherConfiguration::class, 'store'])->name('admin.voucher.store');
    Route::put('/voucher/update/{id}', [voucherConfiguration::class, 'update'])->name('admin.voucher.update');
    Route::delete('/voucher/delete/{id}', [voucherConfiguration::class, 'destroy'])->name('admin.voucher.destroy');
});
