<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CampaignController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::get('/user-list', [UserController::class, 'index'])->name('user-list');
Route::post('/add-new-user', [UserController::class, 'add_new_user'])->name('add_new_user');
Route::get('/approval-requests', [UserController::class, 'approval_requests'])->name('approval_requests');
Route::post('/approve', [UserController::class, 'approve'])->name('approve');
Route::post('/edit-user', [UserController::class, 'edit_user'])->name('edit_user');
Route::post('/delete-user', [UserController::class, 'delete_user'])->name('delete_user');

Route::get('/add-new-client', [ClientController::class, 'add_new_client_view'])->name('add_new_client_view');
Route::post('/add-new-client', [ClientController::class, 'add_new_client'])->name('add_new_client');
Route::get('/all-clients', [ClientController::class, 'all_clients'])->name('all_clients');
Route::get('/all-fav-clients', [ClientController::class, 'all_fav_clients'])->name('all_fav_clients');
Route::get('/change-client-fav-status/{id}', [ClientController::class, 'change_client_fav_status'])->name('change_client_fav_status');
Route::post('/client-filter', [ClientController::class, 'client_filter'])->name('client_filter');
Route::post('/client-edit', [ClientController::class, 'client_edit'])->name('client_edit');
Route::post('/client-edit-submit', [ClientController::class, 'client_edit_submit'])->name('client_edit_submit');
Route::post('/delete-client', [ClientController::class, 'delete_client'])->name('delete_client');

Route::get('/roles', [RoleController::class, 'index'])->name('roles');
Route::post('/add-new-role', [RoleController::class, 'add_new_role'])->name('add_new_role');
Route::post('/edit-role', [RoleController::class, 'edit_role'])->name('edit_role');

Route::get('/add-new-influencer', [InfluencerController::class, 'index'])->name('add_new_influencer');
Route::post('/add-new-influencer', [InfluencerController::class, 'add_new_influencer'])->name('add_new_influencer');
Route::get('/all-influencers', [InfluencerController::class, 'all_influencers'])->name('all_influencers');
Route::get('/influencer-template', [InfluencerController::class, 'influencer_template'])->name('influencer_template');
Route::get('/influencer-template-detail/{id}', [InfluencerController::class, 'influencer_template_detail'])->name('influencer_template_detail');
Route::post('/edit-template-basics', [InfluencerController::class, 'edit_template_basics'])->name('edit_template_basics');
Route::get('/add-influencer-to-template/{id}', [InfluencerController::class, 'add_influencer_to_template'])->name('add_influencer_to_template');
Route::post('/post-influencer-to-template', [InfluencerController::class, 'post_influencer_to_template'])->name('post_influencer_to_template');
Route::post('/remove-influencer-from-template', [InfluencerController::class, 'remove_influencer_from_template'])->name('remove_influencer_from_template');
Route::post('/remove-package-from-template', [InfluencerController::class, 'remove_package_from_template'])->name('remove_package_from_template');
Route::get('/add-campaign-from-template/{id}', [InfluencerController::class, 'add_campaign_from_template'])->name('add_campaign_from_template');
Route::get('/influencer-packages', [InfluencerController::class, 'influencer_packages'])->name('influencer_packages');
Route::get('/influencer-template-packages/{id}', [InfluencerController::class, 'influencer_packages_template']);
Route::post('/add-package-to-template', [InfluencerController::class, 'add_package_to_template'])->name('add_package_to_template');
Route::get('/create-new-package', [InfluencerController::class, 'create_new_package'])->name('create_new_package');
Route::post('/create-package', [InfluencerController::class, 'create_package'])->name('create_package');
Route::post('/package-content-modal', [InfluencerController::class, 'package_content_modal'])->name('package_content_modal');
Route::get('/package-detail/{id}', [InfluencerController::class, 'package_detail'])->name('package_detail');
Route::post('/remove-package', [InfluencerController::class, 'remove_package'])->name('remove_package');

Route::post('/all-influencers/get-data', [InfluencerController::class, 'getData'])->name('influencers.getData');
Route::post('all-influencers/test', [InfluencerController::class, 'test'])->name('influencers.test');
Route::get('/all-influencers2', [InfluencerController::class, 'all_influencers2'])->name('all_influencers2');
Route::post('/add-to-fav', [InfluencerController::class, 'add_to_fav'])->name('add_to_fav');
Route::get('/favourite-influencers', [InfluencerController::class, 'favourite_influencers'])->name('favourite_influencers');
Route::get('/change-fav-status/{id}', [InfluencerController::class, 'change_fav_status'])->name('change_fav_status');
Route::get('/influencer-profile/{id}', [InfluencerController::class, 'influencer_profile'])->name('influencer_profile');
Route::get('/influencer/billing/{id}', [InfluencerController::class, 'influencer_billing'])->name('influencer_billing');
Route::get('/influencer/connections/{id}', [InfluencerController::class, 'influencer_connections'])->name('influencer_connections');
Route::get('/influencer/notification/{id}', [InfluencerController::class, 'influencer_notification'])->name('influencer_notification');
Route::get('/influencer/security/{id}', [InfluencerController::class, 'influencer_security'])->name('influencer_security');
Route::post('/template-content-modal', [InfluencerController::class, 'template_content_modal'])->name('template_content_modal');
Route::post('/influencer-filter', [InfluencerController::class, 'influencer_filter'])->name('influencer_filter');
Route::post('/quick-edit', [InfluencerController::class, 'quick_edit'])->name('quick_edit');
Route::post('/quick-edit-update', [InfluencerController::class, 'quick_edit_update'])->name('quick_edit_update');
Route::post('/edit-profile', [InfluencerController::class, 'edit_profile'])->name('edit_profile');
Route::post('/delete-influencer', [InfluencerController::class, 'delete_influencer'])->name('delete_influencer');
Route::post('/edit-influencer-wallet', [InfluencerController::class, 'edit_influencer_wallet'])->name('edit_influencer_wallet');
Route::post('/delete-influencer-wallet', [InfluencerController::class, 'delete_influencer_wallet'])->name('delete_influencer_wallet');
Route::post('/add-new-influencer-wallet', [InfluencerController::class, 'add_new_influencer_wallet'])->name('add_new_influencer_wallet');
Route::post('/edit-influencer-content', [InfluencerController::class, 'edit_influencer_content'])->name('edit_influencer_content');
Route::post('/delete-influencer-content', [InfluencerController::class, 'delete_influencer_content'])->name('delete_influencer_content');
Route::post('/add-new-influencer-content', [InfluencerController::class, 'add_new_influencer_content'])->name('add_new_influencer_content');
Route::post('/edit-influencer-social', [InfluencerController::class, 'edit_influencer_social'])->name('edit_influencer_social');
Route::post('/add-new-influencer-social', [InfluencerController::class, 'add_new_influencer_social'])->name('add_new_influencer_social');
Route::post('/delete-influencer-social', [InfluencerController::class, 'delete_influencer_social'])->name('delete_influencer_social');
Route::get('/api-integrate', [InfluencerController::class, 'api_integrate'])->name('api_integrate');
Route::get('/integrate-twitter', [InfluencerController::class, 'integrate_twitter'])->name('integrate_twitter');
Route::get('/integrate-youtube', [InfluencerController::class, 'integrate_youtube'])->name('integrate_youtube');
Route::post('/influencer-template-content-edit', [InfluencerController::class, 'influencer_template_content_edit'])->name('influencer_template_content_edit');
Route::post('/influencer-package-content-edit', [InfluencerController::class, 'influencer_package_content_edit'])->name('influencer_package_content_edit');
Route::post('/delete-influencer-template', [InfluencerController::class, 'delete_influencer_template'])->name('delete_influencer_template');
Route::post('/package-selected-influencer', [InfluencerController::class, 'packageSelectedInfluencer'])->name('packageSelectedInfluencer');

Route::get('/tag', [TagController::class, 'index'])->name('tag');
Route::post('/add-tag', [TagController::class, 'add_tag'])->name('add_tag');
Route::post('/edit-tag', [TagController::class, 'edit_tag'])->name('edit_tag');
Route::post('/delete-tag', [TagController::class, 'delete_tag'])->name('delete_tag');

Route::get('/region', [RegionController::class, 'index'])->name('region');
Route::post('/add-region', [RegionController::class, 'add_region'])->name('add_region');
Route::post('/edit-region', [RegionController::class, 'edit_region'])->name('edit_region');
Route::post('/delete-region', [RegionController::class, 'delete_region'])->name('delete_region');

Route::get('/content', [ContentController::class, 'index'])->name('content');
Route::post('/add-content', [ContentController::class, 'add_content'])->name('add_content');
Route::post('/edit-content', [ContentController::class, 'edit_content'])->name('edit_content');
Route::post('/delete-content', [ContentController::class, 'delete_content'])->name('delete_content');

Route::get('/social', [SocialController::class, 'index'])->name('social');
Route::post('/add-social', [SocialController::class, 'add_social'])->name('add_social');
Route::post('/edit-social', [SocialController::class, 'edit_social'])->name('edit_social');
Route::post('/delete-social', [SocialController::class, 'delete_social'])->name('delete_social');

Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
Route::post('/add-wallet', [WalletController::class, 'add_wallet'])->name('add_wallet');
Route::post('/edit-wallet', [WalletController::class, 'edit_wallet'])->name('edit_wallet');
Route::post('/delete-wallet', [WalletController::class, 'delete_wallet'])->name('delete_wallet');

// Route::get('/new-campaign', [CampaignController::class, 'index'])->name('new_campaign');
// Route::post('/campaign-influencer-filter', [CampaignController::class, 'influencer_filter'])->name('campaign_influencer_filter');
// Route::get('/all-campaigns', [CampaignController::class, 'all_campaign'])->name('all_campaign');
// Route::get('/approve-campaign', [CampaignController::class, 'approve_campaign'])->name('approve_campaign');
// Route::post('/content-modal', [CampaignController::class, 'content_modal'])->name('content_modal');
// Route::post('/influencer-campaign', [CampaignController::class, 'influencer_campaign'])->name('influencer_campaign');
// Route::post('/campaign-content-custom-price', [CampaignController::class, 'campaign_content_custom_price'])->name('campaign_content_custom_price');
// Route::post('/add-new-campaign', [CampaignController::class, 'add_new_campaign'])->name('add_new_campaign');

Route::get('/new-campaign', [CampaignController::class, 'index'])->name('new_campaign');
Route::post('/campaign-influencer-filter', [CampaignController::class, 'influencer_filter'])->name('campaign_influencer_filter');
Route::get('/all-campaigns', [CampaignController::class, 'all_campaign'])->name('all_campaign');
Route::get('/ongoing-campaigns', [CampaignController::class, 'ongoing_campaigns'])->name('ongoing_campaigns');
Route::get('/draft-campaigns', [CampaignController::class, 'draft_campaigns'])->name('draft_campaigns');
Route::get('/approve-campaign', [CampaignController::class, 'approve_campaign'])->name('approve_campaign');
Route::post('/content-modal', [CampaignController::class, 'content_modal'])->name('content_modal');
Route::post('/influencer-campaign', [CampaignController::class, 'influencer_campaign'])->name('influencer_campaign');
Route::post('/campaign-content-custom-price', [CampaignController::class, 'campaign_content_custom_price'])->name('campaign_content_custom_price');
Route::post('/content-custom-price', [CampaignController::class, 'content_custom_price'])->name('content_custom_price');
Route::post('/add-new-campaign', [CampaignController::class, 'add_new_campaign'])->name('add_new_campaign');
Route::post('/add-new-campaign-from-template', [CampaignController::class, 'add_new_campaign_from_template'])->name('add_new_campaign_from_template');
Route::post('/create-new-campaign', [CampaignController::class, 'create_new_campaign'])->name('create_new_campaign');
Route::get('/campaign-details/{id}', [CampaignController::class, 'campaign_details'])->name('campaign_details');
Route::get('/add-campaign-info/{id}', [CampaignController::class, 'add_campaign_info'])->name('add_campaign_info');
Route::post('/approve-campaign', [CampaignController::class, 'approve_campaign2'])->name('approve_campaign2');
Route::post('/remove-influencer', [CampaignController::class, 'remove_influencer'])->name('remove_influencer');
Route::post('/append-at-right', [CampaignController::class, 'appendAtRight'])->name('appendAtRight');
Route::post('/new-camp-s1', [CampaignController::class, 'new_camp_s1'])->name('new_camp_s1');
Route::post('/post-campaign-info', [CampaignController::class, 'post_campaign_info'])->name('post_campaign_info');
Route::post('/draft-camp-influencer', [CampaignController::class, 'draft_camp_influencer'])->name('draft_camp_influencer');




