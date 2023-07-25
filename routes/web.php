<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\API\StatsController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\EstimateController;
use App\Http\Controllers\Admin\EstimateRequestController;
use App\Http\Controllers\Admin\JobOfferController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Partner\BillingController;
use App\Http\Controllers\Partner\PartnerAccountController;
use App\Http\Controllers\Partner\SpaceGroupController;
use App\Http\Controllers\Partner\SpacesController;
use App\Http\Controllers\Partner\TeamController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\User\AddressesController;
use Illuminate\Support\Facades\Route;

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

$permanentRedirection = [];

// Redirection 301
include_once('redirections301.php');

foreach($permanentRedirection as $here => $there) {
    Route::permanentRedirect($here,$there);
}


Route::get('/', [StaticPageController::class, 'welcome'])->name('welcome');

Route::get('/location-salle', [SpaceController::class, 'list'])->name('catalogue');

Route::get('/espaces/{sg}/salles/{space}', [SpaceController::class, 'show'])->name('space');
Route::get('/espaces/{sg}', [SpaceController::class, 'showGroup'])->name('spaceGroup');
Route::get('/request-quote', [StaticPageController::class, 'requestQuotePage'])->name('request-quote.index');
Route::post('/request-quote', [StaticPageController::class, 'requestQuote'])->name('request-quote.post');

Route::view('/qui-sommes-nous', 'guest.about')->name('about');
Route::view('/notre-equipe', 'guest.team')->name('team');

Route::view('/location-salle-paris', 'guest.paris_space')->name('paris_space');
Route::view('/contactez-nous', 'guest.contactUs')->name('contactUs');
Route::view('/vos-temoignages', 'guest.testimonials')->name('testimonials');
Route::view('/services-restauration', 'guest.restorationDrink')->name('restorationDrink');
Route::view('/services-technique', 'guest.technical')->name('technical');
Route::view('/pages/faq', 'guest.faq')->name('faq');
Route::post('/contact', [MailController::class, 'sendContactMessage'])->name('contact');

Route::get('/email/verify/{token}', [AuthController::class, 'verifyEmail'])->name('auth.verify-email');

Route::view('/jobs', 'jobs.index')->name('offers');
Route::view('/plan-du-site', 'guest.sitemap_page')->name('sitemap_page');

Route::get('/articles/{page?}', [ArticleController::class, 'list'])->name('articles.list');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::middleware(['guest'])->group(function ()
{
    Route::get('/login', [AuthController::class, 'loginPage'])->name('auth.login-page');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::view('/register', 'auth.register')->name('auth.register-page');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::view('/recover-password', 'auth.recover-password')->name('auth.recover-password');
    Route::post('/recover-password', [AuthController::class, 'recover'])->name('auth.request-password');
    Route::view('/reset-password', 'auth.reset-password')->name('auth.reset-page');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
});

Route::get('/invoices/{invoice}/pay', [\App\Http\Controllers\User\BookingController::class, 'redirectToPay'])->name('invoices.redirect-to-pay');

Route::middleware(['auth', 'select_partner'])->group(function ()
{
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Booking process
    Route::get('/payment-success', [BookingController::class, 'paymentSuccess'])->name('booking.payment-success');
    Route::get('/payment-failed', [BookingController::class, 'paymentFail'])->name('booking.payment-fail');

    Route::get('/settings', [SettingsController::class, 'index'])->name('user.settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('user.settings.update');

    Route::get('/messages', [MailController::class, 'index'])->name('messaging.index');
    Route::get('/api/messages', [MailController::class, 'messages'])->name('api.messaging.list');
    Route::get('/api/messages/{mail}', [MailController::class, 'readMessage'])->name('api.messaging.message.read');
    Route::post('/api/messages', [MailController::class, 'createMail'])->name('api.messaging.create-mail');
    Route::post('/api/messages/{mail}', [MailController::class, 'sendMessage'])->name('api.messaging.message.send');
    Route::post('/api/messages/{mail}/close', [MailController::class, 'closedMessage'])->name('api.messaging.closed');

    Route::get('/contactForm', [ContactFormController::class, 'index'])->name('contactForm.index');



    Route::get('/notifications/mark-as-read', [NotificationController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-as-read');

    /*    Route::get('/become-a-partner/{type}', [OnboardingController::class, 'start'])->name('become-a-partner.start');
        Route::post('/become-a-partner/{type}', [OnboardingController::class, 'store'])->name('become-a-partner.add');*/

    // All partners
    // API partners
    Route::middleware(['role:partner,admin'])->group(function ()
    {
        // Spaces search
        Route::get('/api/spaces/search', [\App\Http\Controllers\API\SpaceController::class, 'search'])->name('api.spaces.search');
        Route::get('/api/spaces/fastsearch/{queryString?}', [\App\Http\Controllers\API\SpaceController::class, 'fastSearch'])->name('api.spaces.fast.search');

        // Bookings
        Route::get('/api/bookings', [\App\Http\Controllers\API\BookingController::class, 'index'])->name('api.bookings.index');
    });


    Route::middleware(['role:partner,admin'])->prefix('/partner')->name('partner.')->group(function ()
    {
        Route::view('/', 'partners.dashboard')->name('dashboard');

        // Actions
        Route::view('/actions', 'partners.actions.index')->name('actions.index');

        // Team
        Route::get('/team', [TeamController::class, 'index'])->name('team.index');
        Route::post('/team', [TeamController::class, 'addUser'])->name('team.invite');
        Route::get('/team/{user}/remove', [TeamController::class, 'removeUser'])->name('team.remove');

        // Settings & Subscription
        Route::get('/settings', [PartnerAccountController::class, 'getSettings'])->name('settings.get');
        Route::put('/settings', [PartnerAccountController::class, 'updateSettings'])->name('settings.update');

    });

    // Calendars
    Route::middleware(['role:partner,admin'])->group(function ()
    {
        // New Calendar
        Route::view('/calendar', 'admin.calendar')->name('calendar');
        Route::get('/calendar/{agenda}/date/{date}', [\App\Http\Controllers\Partner\AgendaController::class, 'getElementsForDate'])->name('calendar.day');
        Route::get('/calendar-elements/{element}/delete', [\App\Http\Controllers\Partner\AgendaController::class, 'deleteElement'])->name('calendar.element.delete');

        // API Calendar
        Route::get('/api/calendars', [\App\Http\Controllers\API\AgendaController::class, 'loadAvailableSpaces']);
        Route::get('/api/calendars/retrieve', [\App\Http\Controllers\API\AgendaController::class, 'retrieve']);
        Route::get('/api/calendar-elements/{element}', [\App\Http\Controllers\API\AgendaController::class, 'getAgendaElement'])->name('calendar.element.get');
        Route::get('/api/calendar/{agenda}/date/{date}', [\App\Http\Controllers\API\AgendaController::class, 'getElementsForDate'])->name('api.calendar.day');
        Route::post('/api/calendar-elements/{element}/update', [\App\Http\Controllers\API\AgendaController::class, 'updateElement'])->name('api.calendar.element.update');
        Route::get('/api/calendar-elements/{element}/delete', [\App\Http\Controllers\API\AgendaController::class, 'removeElement'])->name('api.calendar.element.remove');
    });

    // Partners that are subscribed to annuaire+ & up
    Route::middleware(['role:partner,admin'])->prefix('/partner')->name('partner.')->group(function ()
    {
        // Agenda
        Route::post('/api/agendas/add-element', [\App\Http\Controllers\API\AgendaController::class, 'addElement'])->name('agenda.add-element');
        Route::delete('/api/agendas/remove-element/{element}', [\App\Http\Controllers\API\AgendaController::class, 'removeElement'])->name('agenda.remove-element');

        // Media
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::post('/media/{media}/update/order/{order}', [MediaController::class, 'editMediaOrder'])->name('media.update.order');
        Route::delete('/media/{media}', [MediaController::class, 'removeMedia'])->name('media.remove');

        Route::post('/media/reorder', [MediaController::class, 'reorderMedia'])->name('media.reorder');


        // Bookings
        Route::get('/bookings', [\App\Http\Controllers\Partner\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [\App\Http\Controllers\Partner\BookingController::class, 'show'])->name('bookings.show');

        // Space groups
        Route::name('space-groups.')->prefix('/space-groups')->group(function ()
        {
            Route::get('/', [SpaceGroupController::class, 'index'])->name('index');
            Route::get('/create', [SpaceGroupController::class, 'create'])->name('create');
            Route::post('/create', [SpaceGroupController::class, 'store'])->name('store');

            Route::get('/front-menu', [SpaceGroupController::class, 'frontMenu'])->name('front.menu');

            Route::get('/frontMenu/update/{association?}', [SpaceGroupController::class, 'updateOrderFrontMenu'])->name('front.menu.update');


            Route::prefix('/{space_group}')->group(function ()
            {
                Route::get('/', [SpaceGroupController::class, 'edit'])->name('show');
                Route::post('/edit', [SpaceGroupController::class, 'update'])->name('update');
                Route::post('/edit-description', [SpaceGroupController::class, 'updateDescription'])->name('update-description');
                Route::post('/delete', [SpaceGroupController::class, 'delete'])->name('delete');

                Route::name('space.')->prefix('/space')->group(function ()
                {
                    Route::get('/create', [SpacesController::class, 'create'])->name('create');
                    Route::post('/create', [SpacesController::class, 'store'])->name('store');
                });
            });
        });
        Route::name('spaces.')->prefix('/spaces')->group(function ()
        {
            Route::prefix('/{space}')->group(function ()
            {
                Route::get('/', [SpacesController::class, 'show'])->name('show');
                Route::get('/edit', [SpacesController::class, 'edit'])->name('edit');
                Route::post('/edit', [SpacesController::class, 'update'])->name('update');
                Route::post('/edit-description', [SpacesController::class, 'updateDescription'])->name('update-description');
                Route::post('/edit-tags', [SpacesController::class, 'updateTags'])->name('update-tags');
                Route::post('/delete', [SpacesController::class, 'delete'])->name('delete');
            });
        });

        // Space actions
        Route::get('/actions/{spaceAction}/toggleCompleted', [ActionController::class, 'toggleCompleted'])->name('actions.toggle-completed');

    });

    Route::prefix('/user')->name('user.')->group(function ()
    {
        Route::get('/bookings', [\App\Http\Controllers\User\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [\App\Http\Controllers\User\BookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/final-confirm', [\App\Http\Controllers\User\BookingController::class, 'finalConfirm'])->name('bookings.final-confirm');
        Route::post('/invoices/{invoice}/pay', [\App\Http\Controllers\User\BookingController::class, 'payInvoice'])->name('bookings.pay-invoice');

        // Addresses
        Route::get('/api/addresses', [AddressesController::class, 'index'])->name('addresses.index');
        Route::post('/api/addresses', [AddressesController::class, 'store'])->name('addresses.store');
        Route::put('/api/addresses/{address}', [AddressesController::class, 'update'])->name('addresses.update');
        Route::delete('/api/addresses/{address}', [AddressesController::class, 'delete'])->name('addresses.delete');
    });

    // Actions
    Route::post('/spaces/{space}/add-action', [ActionController::class, 'addElement'])->name('spaces.actions.store');
    Route::post('/spaces/actions', [ActionController::class, 'addElementUser'])->name('spaces.actions.store-two');

    Route::middleware(['role:admin'])->prefix('/admin')->name('admin.')->group(function ()
    {
        // Sellsy
        Route::get('/sellsy/login', [\App\Http\Controllers\API\SellsyController::class, 'requestAuthCode'])->name('sellsy-admin-login');

        // Demandes
        Route::get('/estimate-requests', [EstimateRequestController::class, 'index'])->name('estimate-requests.index');
        Route::get('/estimate-requests/{estreq}', [EstimateRequestController::class, 'show'])->name('estimate-requests.show');
        Route::get('/estimate-requests/{estreq}/close', [EstimateRequestController::class, 'close'])->name('estimate-requests.close');
        Route::get('/estimate-requests/{estreq}/create-estimate', [EstimateRequestController::class, 'createEstimate'])->name('estimate-requests.create-estimate');


        Route::get('/invoices', [\App\Http\Controllers\Admin\BillingController::class, 'partnersIndex'])->name('invoices.partners.index');
        Route::get('/invoices/partners/{invoice}/mark-as-paid', [\App\Http\Controllers\Admin\BillingController::class, 'markAsPaid'])->name('invoices.mark-as-paid');
        Route::view('/invoices/customers', 'admin.billing.customers.index')->name('invoices.customers.index');
        Route::view('/invoices/commissions', 'admin.billing.commission.index')->name('invoices.commission.index');
        Route::post('/invoices/all/{invoice}/change-status', [\App\Http\Controllers\Admin\API\InvoiceController::class, 'changeStatus'])->name('invoices.change-status');


        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/search/{req}', [AdminController::class, 'search'])->name('search');


        // Partners
        Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
        Route::get('/partners/show/{partner}', [PartnerController::class, 'show'])->name('partners.show');
        Route::get('/partners/show/{partner}/delete', [PartnerController::class, 'delete'])->name('partners.delete');
        Route::get('/partners/requests', [PartnerController::class, 'getRequests'])->name('partners.requests.index');
        Route::get('/partners/requests/{partner}/approve', [PartnerController::class, 'approveRequest'])->name('partners.requests.approve');
        Route::get('/partners/requests/{partner}/delete', [PartnerController::class, 'deleteRequest'])->name('partners.requests.delete');
        Route::post('/partners/users/{partner}/add', [PartnerController::class, 'addUser'])->name('partners.users.add');
        // Admin Partners
        Route::get('/api/partners', [PartnerController::class, 'getPartners'])->name('api.partners.index');
        Route::get('/api/partners/search', [PartnerController::class, 'search'])->name('api.partners.search');
        Route::post('/api/partners', [\App\Http\Controllers\Admin\API\PartnerController::class, 'store'])->name('partners.store');


        // User search
        Route::get('/api/users/search', [EstimateController::class, 'searchUser'])->name('api.user.search');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/status/{status?}', [UserController::class, 'index'])->name('users.status');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/hijack', [UserController::class, 'hijack'])->name('users.hijack');
        Route::post('/team', [UserController::class, 'addAdmin'])->name('team.invite');
        Route::get('/team/{user}/remove', [UserController::class, 'removeAdmin'])->name('team.remove');
        Route::get('/team/{user}/desactive', [UserController::class, 'desactive'])->name('team.desactive');
        Route::get('/team/{user}/active', [UserController::class, 'active'])->name('team.active');
        Route::get('/team/{user}/suppressed', [UserController::class, 'suppressed'])->name('team.suppressed');


        // Estimates
        Route::get('/estimates', [EstimateController::class, 'index'])->name('estimates.index');
        Route::get('/api/estimates/{estimate}', [\App\Http\Controllers\Admin\API\EstimateController::class, 'show'])->name('estimates.show.json');
        Route::post('/api/estimates/{estimate}/send-yousign-link', [\App\Http\Controllers\Admin\API\EstimateController::class, 'sendYouSignLink'])->name('estimates.send-yousign');
        Route::post('/api/estimates/{estimate}/offer/elements', [\App\Http\Controllers\Admin\BookingController::class, 'addElement'])->name('estimates.elements.add');
        Route::get('/api/estimates', [\App\Http\Controllers\Admin\API\EstimateController::class, 'index'])->name('estimates.get-json');
        Route::get('/estimates/create', [EstimateController::class, 'create'])->name('estimates.create');
        Route::get('/estimates/{estimate}', [EstimateController::class, 'edit'])->name('estimates.edit');
        Route::post('/api/estimates/{estimate}/mark-as-signed', [\App\Http\Controllers\Admin\API\EstimateController::class, 'markAsSigned'])->name('estimates.mark-as-signed');
        Route::post('/api/estimates/{estimate}/update-note', [\App\Http\Controllers\Admin\API\EstimateController::class, 'updateNote'])->name('estimates.update-note');
        Route::post('/api/estimates/{estimate}/update-options', [\App\Http\Controllers\Admin\API\EstimateController::class, 'updateOptions'])->name('estimates.update-options');
        Route::post('/api/estimates', [EstimateController::class, 'store'])->name('estimates.store');
        Route::post('/api/users/store', [UserController::class, 'storeUser'])->name('users.add');

        // Files
        Route::post('/api/files', [\App\Http\Controllers\Admin\API\EstimateController::class, 'uploadFile']);
        Route::get('/files/view/{file}', [AdminController::class, 'viewFile'])->name('files.view');
        Route::get('/api/files/delete/{file}', [\App\Http\Controllers\Admin\API\EstimateController::class, 'deleteFile'])->name('files.delete');
        Route::get('/files/download/{file}', [AdminController::class, 'downloadFile'])->name('files.download');

        // Bookings
        Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
        Route::get('/bookings/{booking}/json', [\App\Http\Controllers\Admin\BookingController::class, 'getBookingInfo'])->name('bookings.show.json');
        Route::post('/api/bookings/{booking}/update-note', [\App\Http\Controllers\Admin\API\BookingController::class, 'updateNote'])->name('bookings.update-note');
        Route::post('/api/bookings/{booking}/cancel', [\App\Http\Controllers\Admin\API\BookingController::class, 'cancel'])->name('bookings.cancel');

        // Referents for estimates and bookings
        Route::get('/api/admin-list', [\App\Http\Controllers\Admin\API\BookingController::class, 'getAdminList']);
        Route::post('/api/update-referent', [\App\Http\Controllers\Admin\API\BookingController::class, 'updateReferent']);


        // Job offers
        Route::resource('job-offers', JobOfferController::class)->except(['destroy']);
        Route::get('/job-offers/{job}/delete', [JobOfferController::class, 'delete'])->name('job-offers.delete');

        // Pages
        Route::view('/pages', 'admin.pages.index')->name('pages.index');
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::post('/media-tinymce', [MediaController::class, 'tinyMCE']);


        // Blog ADMIN
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::get('/blog/edit/{article_id}', [BlogController::class, 'create'])->name('blog.edit');
        Route::post('/blog/article/update', [BlogController::class, 'update'])->name('blog.article.update');
        Route::post('/blog/article/update/element', [BlogController::class, 'updateElement'])->name('blog.article.update.element');
        Route::delete('/blog/article/delete/element', [BlogController::class, 'deleteElement'])->name('blog.article.delete.element');
        Route::post('/blog/article/category/list', [BlogController::class, 'categoryList'])->name('blog.article.category.list');


        // Settings
        Route::view('/settings', 'admin.settings')->name('settings');
        Route::get('/api/settings', [\App\Http\Controllers\Admin\API\SettingsController::class, 'index']);
        Route::get('/api/settings/spaces', [\App\Http\Controllers\Admin\API\SettingsController::class, 'availableSpaces']);
        Route::post('/api/settings', [\App\Http\Controllers\Admin\API\SettingsController::class, 'update']);

        // Dashboard statistics
        Route::get('/api/stats/general', [StatsController::class, 'generalStats']);
        Route::get('/api/stats/spaces', [StatsController::class, 'spaceStats']);
    });
});

// Pages
Route::get('/pages/{page}', [StaticPageController::class, 'page'])->name('page.show');
