<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\MusicFormController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\MessageController;



Route::get('/ping', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->middleware('refresh_token');


Route::middleware('check.user')->group(function () {
    Route::get('/dashboardd', [DashboardController::class,'showDashboardd'])->name('dashboardd');
});


Route::get('/clear', [CacheController::class, 'clear'])->name('clear');

Route::get('/share/{id}', [DashboardController::class, 'share'])->name('share_track');


Route::middleware('superadmincheck')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'showDashboard')->name('dashboard');
        Route::post('/logout','logout')->name('dashboard.logout');
        Route::get('/analytics','analytics')->name('analytics');
        Route::get('/profile','profile')->name('profile');
        Route::get('/filter_info','filterInfo')->name('filter_info');
        Route::get('/view_user/{id}','viewDashboard')->name('viewdashboardusers');
        Route::get('/alltracks','allTracks')->name('allTracks');
        Route::get('/view_tracks/{id}','viewTracks')->name('view_tracks');
        Route::get('/download/{id}', 'download')->name('download_track');
       

    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users','allUser')->name('allUser');
        Route::get('/add_new_user','addNewUser')->name('add_new_user');
        Route::delete('/delete_user/{id}','deleteUser')->name('deleteUser');
        Route::get('/states','allState')->name('all_states');
        Route::post('/create_user','createUser')->name('create_user');
        Route::get('/active_user','allActiveUser')->name('allActiveUser');
        Route::get('/inactive_user','allInactiveUser')->name('allInactiveUser');
        Route::get('users-export','export')->name('users.export');
        Route::get('/all_deleted_user','alldeletedUser')->name('all_deleted_user');
        Route::post('/deleted_userCompletely','deleted_userCompletely')->name('deleted_userCompletely');
        Route::post('/restore_userCompletely','restore_userCompletely')->name('restore_userCompletely');

    });

    Route::controller(FileUploadController::class)->group(function () {
        Route::post('/update_profile','updateProfile')->name('update_profile');
        Route::post('/user_update_profile/{id}','userUpdateProfile')->name('update_user_profile');

    });
    
    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages','getMessage')->name('messages.create');
        Route::post('/messages','store')->name('messages.store');
    });

    Route::controller(SubscriptionController::class)->group(function () {
         
         Route::get('/subscription','subscription_form')->name('subscription');
         Route::get('/all_subscription','allsubscription')->name('allsubscription');
         Route::get('/choosesubscription','choosesubscription')->name('choosesubscription');
         Route::post('/add_subscription','add_subscription')->name('add_subscription');
         Route::get('/edit_subscription/{id}','edit_subscription')->name('edit_subscription');
         Route::post('/editSub/{id}','editSub')->name('editSub');
    });
    
    Route::controller(PermissionController::class)->group(function () {

        Route::get('/manage_permission','managePermission')->name('manage_permission');
        Route::post('/create_permission','createPermission')->name('create_permission');
        Route::post('/delete_permission','deletePermission')->name('delete_permission');
        Route::post('/update_permission','updatePermission')->name('update_permission');

        // assign permission to role 
        Route::get('/assign_permission_role','assignPermissionRole')->name('assign_permission_role');
        Route::post('/create_permission_role','createPermissionRole')->name('create_permission_role');
        Route::get('/edit_permission_role/{id}','editPermissionRole')->name('edit_permission_role');
        Route::post('/update_permission_role','updatePermissionRole')->name('update_permission_role');
        Route::post('/delete_permission_role','deletePermissionRole')->name('delete_permission_role');
        
        // assign permission to route
        Route::get('/assign_permission_route','assignPermissionRoute')->name('assign_permission_route');
        Route::post('/create_permission_route','createPermissionRoute')->name('create_permission_route');
        Route::get('/edit_permission_route/{id}','editPermissionRoute')->name('edit_permission_route');
        Route::post('/update_permission_route','updatePermissionRoute')->name('update_permission_route');
    
    });
    
    Route::controller(ChangePasswordController::class)->group(function () {
          Route::post('change-password/{id}','store')->name('change.password');
          Route::post('change_user_password/{id}','storeUserPassword')->name('change.user.password');
    });
    
    Route::controller(AnalyticsController::class)->group(function () {
         Route::get('admin_analytics','adminAnalytics')->name('admin_analytics');
         Route::get('/filter_artist','filterArtistInfo')->name('filter_artist');
         Route::get('/filter_artist_track','filterArtistTrackInfo')->name('filter_artist_track');
         Route::get('/filter_artist_album','filterArtistAlbum')->name('filter_artist_album');
    });
    
    Route::controller(RoleController::class)->group(function () {
         Route::get('/manage_role','manageRole')->name('manage_role');
         Route::post('/create_role','createRole')->name('create_role');
         Route::post('/delete_role','deleteRole')->name('delete_role');
         Route::post('/update_role','updateRole')->name('update_role');
    });
    
    Route::controller(SettingsController::class)->group(function () {
        
         Route::get('/settings','settings')->name('settings');
         Route::post('/createsettings','createsettings')->name('createsettings');
         Route::post('/updatesettings','updatesettings')->name('updatesettings');
         Route::post('/apiexchangerate','apiexchangerate')->name('apiexchangerate');
         Route::get('/vatsettings','Vat')->name('vat');
         Route::post('/updatevat','updateVat')->name('updatevat');
    });
    
    Route::controller(PaymentController::class)->group(function () {
         Route::get('/payment','Payments')->name('payment');
         Route::get('/earnings','Earnings')->name('earnings');
         Route::get('/split_sheet','splitSheet')->name('split_sheet');
         Route::get('/split-sheet/{release}','getTracks')
         ->name('split.sheet.tracks');
    });
    
    
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactions','transactions')->name('transactions');
        Route::post('/resolve_account','resolveAccount')->name('resolve_account');
    });
    
    Route::resource('posts', PostController::class);

    Route::controller(UploadController::class)->group(function () {
        Route::post('/upload/image','upload')->name('upload.image');
    });

     Route::controller(MusicFormController::class)->group(function () {

        // Youtube validation
        Route::post('/release_youtube_valid','youtubeValidation')->name('releases.youtube');
            
        Route::get('/releases/create','showStep')->name('releases.create');
        // Ajax endpoints
        Route::post('/releases/ajax-save-step','ajaxSaveStep')->name('releases.ajax.save');
        Route::post('/releases/upload-audio','uploadAudio')->name('releases.upload.audio');
        Route::post('/releases/upload-artwork','uploadArtwork')->name('releases.upload.artwork');
        Route::post('/releases/generate-isrc','generateIsrc')->name('releases.generate.isrc');
        Route::post('/releases/save-tracks','saveTrackDetails')->name('releases.save.tracks');
        Route::post('/releases/save-outlets','saveOutlets')->name('releases.save.outlets');
        Route::post('/releases/submit-final', 'submitFinal')->name('releases.submit.final');
        Route::get('/releases/load-draft', 'loadDraft')->name('releases.load.draft');
        Route::get('/edit_music/{id}','editMusicProductForm')->name('edit_music_form');
        Route::get('/releases/load-edit/{id}','loadEditRelease')->name('releases.load.edit');

        Route::put('/update_basic/{id}', 'updateBasic')->name('release.update.basic');
        Route::post('/update_artwork/{id}', 'updateArtwork')->name('release.update.artwork');
        Route::post('/update_audios/{id}', 'updateAudio')->name('release.update.audio');
        Route::put('/update_tracks/{id}', 'updateTracks')->name('release.update.tracks');
        Route::put('/update_outlets/{id}', 'updateOutlets')->name('release.update.outlets');
        Route::post('update_final/{id}', 'submitFinalUpdate')->name('release.update.final');
        Route::delete('/delete_audio/{track}','deleteAudio')->name('release.delete.audio');
        Route::get('/get_tracks/{id}', 'getTracks');
        Route::post('/clear_audios','clearAllAudios')->name('music.clearAudios');
        Route::post('/delete_audio_track','deleteAudioTrack');
        Route::post('/release_approval','releaseApproval');
        
    });


    Route::controller(ReleaseController::class)->group(function () {
        Route::get('/music_product','musicProduct')->name('music_product');
        Route::get('/approved_music_product','approveMusicProduct')->name('approve_music_product');
        Route::get('/labels','musicLabels')->name('music_labels');
        Route::get('/artists','musicArtist')->name('music_artist');
        Route::get('/music_release','musicRelease')->name('music_release');
        Route::post('/store_music_release','storeMusicRelease')->name('store_music_release');
        Route::get('/fetch_music/{id}', 'fetchMusic')->name('fetchMusic');
        Route::post('/start_music', 'startMusicRelease')->name('start_music_release');
        Route::get('/last_release','getLastRelease')->name('last_release');
        Route::get('/edit_music_product/{id}','editMusicProduct')->name('edit_music_product');
        Route::post('/update_music','updateMusicRelease')->name('update_music_release');
    });

    
    
});


    





