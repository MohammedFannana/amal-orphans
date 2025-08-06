<?php

use App\Models\Orphan;
use App\Models\Association;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OrphanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\ExcelController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Middleware\MarkNotificationAsRead;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Front\QuestionController;
use App\Http\Controllers\Sponsor\SponserController;
use App\Http\Controllers\Association\ReviewController;
use App\Http\Controllers\Association\ExpenseController;
use App\Http\Controllers\Association\ResearcherController;
use App\Http\Controllers\Association\AssociationController;
use App\Http\Controllers\Admin\AdController as AdminAdController;
use App\Http\Controllers\Admin\OrphanController as AdminOrphanController;
use App\Http\Controllers\Sponsor\MessageController as SponsorMessageController;
use App\Http\Controllers\Admin\AssociationController as AdminAssociationController;
use App\Http\Controllers\Association\OrphanController as AssociationOrphanController;
use App\Http\Controllers\Researcher\ResearcherController as ResearcherResearcherController;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/' , [FrontController::class , 'index'])->name('home');
Route::get('/waiting/orphan' , [FrontController::class , 'showOrphanToSponsored'])->name('front.waiting.orphan');
Route::post('/contact/send', [FrontController::class, 'send'])->name('contact.send');
Route::get('/about' , [FrontController::class , 'aboutUs'])->name('about.us');

Route::prefix('orphan')->group(function(){

    Route::middleware('auth:orphan')->group(function(){

        Route::get('', [OrphanController::class ,'index'])->name('orphan.primary.index');
        Route::get('/balance', [OrphanController::class ,'balance'])->name('orphan.primary.balance');
        Route::get('/message' , [MessageController::class , 'create'])->name('orphan.message.create');
        Route::post('amal/message' , [MessageController::class , 'amalSendMessage'])->name('orphan.amal.message');
        Route::post('sponsor/message' , [MessageController::class , 'SponsorSendMessage'])->name('orphan.sponsor.message');
        Route::get('/notification' , [NotificationController::class , 'OrphanNotification'])->name('orphan.notification');
        Route::get('complete-profile/{orphan}', [OrphanController::class, 'completeProfile'])->name('complete.profile');
        Route::put('/complete-profile/{orphan}', [OrphanController::class, 'storeProfile'])->name('complete.profile.store');

    });

    Route::get('/create', [OrphanController::class ,'create'])->name('orphan.create');

    //auth from assocaiton and admin
    Route::get('/{orphan}/edit', [OrphanController::class ,'edit'])->name('orphan.edit');
    Route::put('/{orphan}', [OrphanController::class ,'update'])->name('orphan.update');

    Route::post('/store' , [OrphanController::class , 'store'])->name('orphan.store');
    Route::get('/image/show' , [OrphanController::class , 'showImage'])->name('orphan.primary.image');
    Route::get('/video/show' , [OrphanController::class , 'showVideo'])->name('orphan.primary.video');
    Route::get('/audio/show' , [OrphanController::class , 'showAudio'])->name('orphan.primary.audio');



});


Route::middleware('auth:association')->prefix('association')->name('association.')->group(function(){

    Route::resource('/researcher' , ResearcherController::class);
    Route::get('/register/orphan' , [AssociationOrphanController::class , 'registeredOrphan'])->name('orphan.register');
    Route::get('/candidate/orphan' , [AssociationOrphanController::class , 'candidateOrphan'])->name('orphan.candidate');
    Route::get('/auditor/orphan' , [AssociationOrphanController::class , 'auditorOrphan'])->name('orphan.auditor');
    Route::get('/certified/orphan' , [AssociationOrphanController::class , 'certifiedOrphan'])->name('orphan.certified');
    Route::get('/waiting/orphan' , [AssociationOrphanController::class , 'waitingOrphan'])->name('orphan.waiting');
    Route::get('/sponsored/orphan' , [AssociationOrphanController::class , 'sponsoredOrphan'])->name('orphan.sponsored');
    Route::post('/review' , [ReviewController::class , 'associationReview'])->name('orphan.review');
    Route::resource('/orphan' , AssociationOrphanController::class);

    Route::get('/orphans/{orphan}/edit' , [OrphanController::class , 'edit'])->name('orphans.edit');
    Route::put('/orphans/{orphan}' , [OrphanController::class , 'update'])->name('orphans.update');

    Route::get('view/orphan/sponsorship/{orphan}' , [AssociationOrphanController::class , 'SponsorshipView'])->name('orphan.view.sponsorship');
    Route::get('view/orphan/{orphan}' , [ResearcherResearcherController::class , 'view'])->name('orphan.view1');

    //Amounts paid route
    // Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    // Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    // Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    // Route::delete('/expenses/{expenses}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::get('/expenses/active', [ExpenseController::class, 'makeActive'])->name('expenses.active');
    Route::resource('/expenses' , ExpenseController::class);


    Route::get('/message' , [MessageController::class , 'message'])->name('message.index');
    Route::post('/message/store/{id}' , [MessageController::class , 'activeMessage'])->name('message.store');
    Route::delete('/message/delete/{id}' , [MessageController::class , 'deleteMessage'])->name('message.delete');
    Route::get('/notification' , [NotificationController::class , 'AssociationNotification'])->name('notification');

});


Route::middleware('auth:researcher')->prefix('researcher')->name('researcher.')->group(function(){

    Route::get('/orphan' , [ResearcherResearcherController::class , 'index'])->name('orphan.index');
    Route::get('/registered' , [ResearcherResearcherController::class , 'registeredOrphan'])->name('registered');


    Route::get('/orphans/create' , [AssociationOrphanController::class , 'create'])->name('orphans.create');
    Route::get('/first/orphans/create' , [ResearcherResearcherController::class , 'create'])->name('orphans.first.create');
    Route::post('/first/orphans' , [ResearcherResearcherController::class , 'store'])->name('orphans.first.store');

    Route::get('/orphans/{orphan}/edit' , [OrphanController::class , 'edit'])->name('orphans.edit');
    Route::get('view/orphan/{orphan}' , [ResearcherResearcherController::class , 'view'])->name('orphan.view');
    Route::post('/researcher/review' , [ReviewController::class , 'researcherReview'])->name('orphan.review');


});


Route::middleware('auth:web')->prefix('admin')->name('admin.')->group(function(){

    Route::resource('/association' , AdminAssociationController::class);
    Route::resource('/sponsor' , SponsorController::class);
    Route::get('orphan/certified' , [AdminOrphanController::class , 'CertifiedOrphan'])->name('orphan.CertifiedOrphan');
    Route::get('orphan/unsponsored' , [AdminOrphanController::class , 'UnsponsoredOrphan'])->name('orphan.UnsponsoredOrphan');
    Route::get('orphan/sponsored' , [AdminOrphanController::class , 'SponsoredOrphan'])->name('orphan.SponsoredOrphan');
    Route::resource('/orphan' , AdminOrphanController::class);
    Route::get('orphan/generate/waiting' , [AdminOrphanController::class , 'generateWaiting'])->name('orphan.generate.waiting');
    Route::get('orphan/sponsorship/details/{orphan}' , [AdminOrphanController::class , 'sponsorshipDetails'])->name('orphan.sponsorship');
    Route::get('orphan/transfer/show/{orphan}' , [AdminOrphanController::class , 'orphanTransfer'])->name('orphan.transfer');
    Route::get('/notification' , [NotificationController::class , 'AdminNotification'])->name('notification');
    Route::resource('/question', QuestionController::class);
    Route::get('message' , [SponsorMessageController::class , 'AdminviewMessage'])->name('message.view');
    Route::resource('/ad' , AdminAdController::class);

});

Route::middleware('auth:sponsor')->prefix('sponsor')->name('sponsor.')->group(function(){
    Route::get('waiting/orphan' , [SponserController::class , 'waitingIndex'])->name('orphan.waiting.index');
    Route::get('sponsorship/orphan' , [SponserController::class , 'sponsorIndex'])->name('orphan.sponsor.index');
    Route::get('waiting/orphan/view/{orphan}' , [SponserController::class , 'waitingView'])->name('orphan.waiting.view');
    Route::get('sponsor/orphan/view/{orphan}' , [SponserController::class , 'sponsorView'])->name('orphan.sponsor.view');
    Route::get('sponsorship/orphan/view/{orphan}' , [SponserController::class , 'sponsorView'])->name('orphan.sponsor.view');
    Route::get('sponsorship/orphan/create/{orphan}' , [SponserController::class , 'create'])->name('orphan.create');
    Route::post('sponsorship/orphan/store' , [SponserController::class , 'store'])->name('orphan.store');
    Route::get('message' , [SponsorMessageController::class , 'view'])->name('message.view');
    Route::get('/notification' , [NotificationController::class , 'SponsorNotification'])->name('notification');
});

Route::middleware('auth:sponsor,association')->group(function () {
    Route::get('sponsorship/show/{orphan}' , [SponserController::class , 'sponsorshipView'])->name('sponsorship.show');
    Route::get('sponsorship/orphan/payments/{orphan}' , [SponserController::class , 'orphanPayments'])->name('orphan.payments');
});


Route::middleware('auth:sponsor,association,researcher,web,orphan')->group(function () {
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
});

// routes/web.php



Route::get('/review/{orphan}' , [ReviewController::class , 'create'])->name('orphan.review');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/clear-all', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');

    return 'All caches cleared!';
});

Route::get('/cache-all', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');


    return 'All caches cached!';
});

Route::get('/import-orphans', [ExcelController::class, 'importFromStorageByName']);


require __DIR__.'/auth.php';
