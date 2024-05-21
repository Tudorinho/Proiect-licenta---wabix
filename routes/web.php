<?php
use Illuminate\Support\Facades\Auth;
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

Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/permissions', [App\Http\Controllers\HomeController::class, 'permissions'])->middleware('admin')->name('home.permissions');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::middleware(['auth'])->group(function () {
    Route::get('users/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('users.profile');
    Route::post('users/change-password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('users.change-password');
    Route::prefix('users')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('projects-sources')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ProjectSourceController::class, 'index'])->name('projects-sources.index');
        Route::get('/create', [App\Http\Controllers\ProjectSourceController::class, 'create'])->name('projects-sources.create');
        Route::post('/', [App\Http\Controllers\ProjectSourceController::class, 'store'])->name('projects-sources.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ProjectSourceController::class, 'edit'])->name('projects-sources.edit');
        Route::put('/{id}', [App\Http\Controllers\ProjectSourceController::class, 'update'])->name('projects-sources.update');
        Route::delete('/{id}', [App\Http\Controllers\ProjectSourceController::class, 'destroy'])->name('projects-sources.destroy');
    });

    Route::prefix('projects-statuses')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ProjectStatusController::class, 'index'])->name('projects-statuses.index');
        Route::get('/create', [App\Http\Controllers\ProjectStatusController::class, 'create'])->name('projects-statuses.create');
        Route::post('/', [App\Http\Controllers\ProjectStatusController::class, 'store'])->name('projects-statuses.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ProjectStatusController::class, 'edit'])->name('projects-statuses.edit');
        Route::put('/{id}', [App\Http\Controllers\ProjectStatusController::class, 'update'])->name('projects-statuses.update');
        Route::delete('/{id}', [App\Http\Controllers\ProjectStatusController::class, 'destroy'])->name('projects-statuses.destroy');
        Route::put('/{id}/update-is-ongoing', [App\Http\Controllers\ProjectStatusController::class, 'updateIsOngoing'])->name('projects-statuses.update-is-ongoing');
    });

    Route::prefix('projects-priorities')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ProjectPriorityController::class, 'index'])->name('projects-priorities.index');
        Route::get('/create', [App\Http\Controllers\ProjectPriorityController::class, 'create'])->name('projects-priorities.create');
        Route::post('/', [App\Http\Controllers\ProjectPriorityController::class, 'store'])->name('projects-priorities.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ProjectPriorityController::class, 'edit'])->name('projects-priorities.edit');
        Route::put('/{id}', [App\Http\Controllers\ProjectPriorityController::class, 'update'])->name('projects-priorities.update');
        Route::delete('/{id}', [App\Http\Controllers\ProjectPriorityController::class, 'destroy'])->name('projects-priorities.destroy');
    });

    Route::prefix('projects-contracts-types')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ProjectContractTypeController::class, 'index'])->name('projects-contracts-types.index');
        Route::get('/create', [App\Http\Controllers\ProjectContractTypeController::class, 'create'])->name('projects-contracts-types.create');
        Route::post('/', [App\Http\Controllers\ProjectContractTypeController::class, 'store'])->name('projects-contracts-types.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ProjectContractTypeController::class, 'edit'])->name('projects-contracts-types.edit');
        Route::put('/{id}', [App\Http\Controllers\ProjectContractTypeController::class, 'update'])->name('projects-contracts-types.update');
        Route::delete('/{id}', [App\Http\Controllers\ProjectContractTypeController::class, 'destroy'])->name('projects-contracts-types.destroy');
    });

    Route::prefix('projects')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
        Route::get('/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');
        Route::post('/', [App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/{id}', [App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/{id}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::post('/{id}/add-action', [App\Http\Controllers\ProjectController::class, 'addAction'])->name('projects.add-action');
        Route::post('/{id}/add-document', [App\Http\Controllers\ProjectController::class, 'addDocument'])->name('projects.add-document');
        Route::put('/{id}/update-action-status/{actionId}', [App\Http\Controllers\ProjectController::class, 'updateActionStatus'])->name('projects.update-action-status');
        Route::get('/quick-search', [App\Http\Controllers\ProjectController::class, 'quickSearch'])->name('projects.quick-search');
    });

    Route::prefix('employees')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/create', [App\Http\Controllers\EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/', [App\Http\Controllers\EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/{id}/edit', [App\Http\Controllers\EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/{id}', [App\Http\Controllers\EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/{id}', [App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employees.destroy');
        Route::get('/quick-search', [App\Http\Controllers\EmployeeController::class, 'quickSearch'])->name('employees.quick-search');
    });

    Route::prefix('worklogs')->group(function () {
        Route::get('', [App\Http\Controllers\WorklogController::class, 'index'])->name('worklogs.index');
        Route::get('/report', [App\Http\Controllers\WorklogController::class, 'report'])->name('worklogs.report');
        Route::get('/create', [App\Http\Controllers\WorklogController::class, 'create'])->name('worklogs.create');
        Route::post('/', [App\Http\Controllers\WorklogController::class, 'store'])->name('worklogs.store');
        Route::get('/{id}/edit', [App\Http\Controllers\WorklogController::class, 'edit'])->name('worklogs.edit');
        Route::put('/{id}', [App\Http\Controllers\WorklogController::class, 'update'])->name('worklogs.update');
        Route::delete('/{id}', [App\Http\Controllers\WorklogController::class, 'destroy'])->name('worklogs.destroy');
    });

    Route::prefix('leaves-types')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\LeaveTypeController::class, 'index'])->name('leaves-types.index');
        Route::get('/create', [App\Http\Controllers\LeaveTypeController::class, 'create'])->name('leaves-types.create');
        Route::post('/', [App\Http\Controllers\LeaveTypeController::class, 'store'])->name('leaves-types.store');
        Route::get('/{id}/edit', [App\Http\Controllers\LeaveTypeController::class, 'edit'])->name('leaves-types.edit');
        Route::put('/{id}', [App\Http\Controllers\LeaveTypeController::class, 'update'])->name('leaves-types.update');
        Route::delete('/{id}', [App\Http\Controllers\LeaveTypeController::class, 'destroy'])->name('leaves-types.destroy');
    });

    Route::prefix('holidays')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\HolidayController::class, 'index'])->name('holidays.index');
        Route::get('/create', [App\Http\Controllers\HolidayController::class, 'create'])->name('holidays.create');
        Route::post('/', [App\Http\Controllers\HolidayController::class, 'store'])->name('holidays.store');
        Route::get('/{id}/edit', [App\Http\Controllers\HolidayController::class, 'edit'])->name('holidays.edit');
        Route::put('/{id}', [App\Http\Controllers\HolidayController::class, 'update'])->name('holidays.update');
        Route::delete('/{id}', [App\Http\Controllers\HolidayController::class, 'destroy'])->name('holidays.destroy');
    });

    Route::prefix('leaves')->group(function () {
        Route::get('', [App\Http\Controllers\LeaveController::class, 'index'])->name('leaves.index');
        Route::get('/calendar', [App\Http\Controllers\LeaveController::class, 'calendar'])->name('leaves.calendar');
        Route::get('/create', [App\Http\Controllers\LeaveController::class, 'create'])->name('leaves.create');
        Route::post('/', [App\Http\Controllers\LeaveController::class, 'store'])->name('leaves.store');
        Route::get('/{id}/edit', [App\Http\Controllers\LeaveController::class, 'edit'])->name('leaves.edit')->middleware('admin');
        Route::put('/{id}', [App\Http\Controllers\LeaveController::class, 'update'])->name('leaves.update')->middleware('admin');
        Route::delete('/{id}', [App\Http\Controllers\LeaveController::class, 'destroy'])->name('leaves.destroy')->middleware('admin');
    });

    Route::get('leaves-balances', [App\Http\Controllers\LeaveBalanceController::class, 'index'])->name('leaves-balances.index');
    Route::prefix('leaves-balances')->middleware('admin')->group(function () {
        Route::get('/create', [App\Http\Controllers\LeaveBalanceController::class, 'create'])->name('leaves-balances.create');
        Route::post('/', [App\Http\Controllers\LeaveBalanceController::class, 'store'])->name('leaves-balances.store');
        Route::get('/{id}/edit', [App\Http\Controllers\LeaveBalanceController::class, 'edit'])->name('leaves-balances.edit');
        Route::put('/{id}', [App\Http\Controllers\LeaveBalanceController::class, 'update'])->name('leaves-balances.update');
        Route::delete('/{id}', [App\Http\Controllers\LeaveBalanceController::class, 'destroy'])->name('leaves-balances.destroy');
    });

    Route::prefix('currencies')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\CurrencyController::class, 'index'])->name('currencies.index');
        Route::get('/create', [App\Http\Controllers\CurrencyController::class, 'create'])->name('currencies.create');
        Route::post('/', [App\Http\Controllers\CurrencyController::class, 'store'])->name('currencies.store');
        Route::get('/{id}/edit', [App\Http\Controllers\CurrencyController::class, 'edit'])->name('currencies.edit');
        Route::put('/{id}', [App\Http\Controllers\CurrencyController::class, 'update'])->name('currencies.update');
        Route::delete('/{id}', [App\Http\Controllers\CurrencyController::class, 'destroy'])->name('currencies.destroy');
    });

    Route::prefix('tasks-lists')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\TaskListController::class, 'index'])->name('tasks-lists.index');
        Route::get('/create', [App\Http\Controllers\TaskListController::class, 'create'])->name('tasks-lists.create');
        Route::post('/', [App\Http\Controllers\TaskListController::class, 'store'])->name('tasks-lists.store');
        Route::get('/{id}/edit', [App\Http\Controllers\TaskListController::class, 'edit'])->name('tasks-lists.edit');
        Route::put('/{id}', [App\Http\Controllers\TaskListController::class, 'update'])->name('tasks-lists.update');
        Route::delete('/{id}', [App\Http\Controllers\TaskListController::class, 'destroy'])->name('tasks-lists.destroy');
    });

    Route::prefix('tasks-lists-users')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\TaskListUserController::class, 'index'])->name('tasks-lists-users.index');
        Route::get('/create', [App\Http\Controllers\TaskListUserController::class, 'create'])->name('tasks-lists-users.create');
        Route::post('/', [App\Http\Controllers\TaskListUserController::class, 'store'])->name('tasks-lists-users.store');
        Route::get('/{id}/edit', [App\Http\Controllers\TaskListUserController::class, 'edit'])->name('tasks-lists-users.edit');
        Route::put('/{id}', [App\Http\Controllers\TaskListUserController::class, 'update'])->name('tasks-lists-users.update');
        Route::delete('/{id}', [App\Http\Controllers\TaskListUserController::class, 'destroy'])->name('tasks-lists-users.destroy');
    });

    Route::get('tasks/list', [App\Http\Controllers\TaskController::class, 'list'])->name('tasks.list');
    Route::post('tasks/{id}/quick-edit', [App\Http\Controllers\TaskController::class, 'quickEdit'])->name('tasks.quick-edit');
    Route::post('tasks/quick-add', [App\Http\Controllers\TaskController::class, 'quickAdd'])->name('tasks.quick-add');
    Route::post('tasks/{id}/mark-as-done', [App\Http\Controllers\TaskController::class, 'markAsDone'])->name('tasks.mark-as-done');
    Route::post('tasks/{id}/cold-emailing-actions', [App\Http\Controllers\TaskController::class, 'coldEmailingActions'])->name('tasks.cold-emailing-actions');
    Route::post('tasks/{id}/cold-emailing-quick-actions', [App\Http\Controllers\TaskController::class, 'coldEmailingQuickActions'])->name('tasks.cold-emailing-quick-actions');
    Route::post('tasks/contact-information', [App\Http\Controllers\TaskController::class, 'getContactInformation'])->name('tasks.contact-information');
    Route::post('tasks/contact-information-update', [App\Http\Controllers\TaskController::class, 'updateContactInformation'])->name('tasks.contact-information-update');
    Route::post('tasks/tasks-lists-report', [App\Http\Controllers\TaskController::class, 'getTaskListReport'])->name('tasks.tasks-lists-report');
    Route::post('tasks/thread-messages', [App\Http\Controllers\TaskController::class, 'getTaskThreadMessages'])->name('tasks.thread-messages');
    Route::post('tasks/{id}/cold-calling-quick-actions', [App\Http\Controllers\TaskController::class, 'coldCallingQuickActions'])->name('tasks.cold-calling-quick-actions');
    Route::post('tasks/{id}/create-deal', [App\Http\Controllers\TaskController::class, 'createDeal'])->name('tasks.create-deal');

    Route::prefix('tasks')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
        Route::get('/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
        Route::post('/', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
        Route::get('/{id}/edit', [App\Http\Controllers\TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/{id}', [App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/{id}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    Route::prefix('tasks-statuses-changes')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\TaskStatusChangeController::class, 'index'])->name('tasks-statuses-changes.index');
        Route::get('/create', [App\Http\Controllers\TaskStatusChangeController::class, 'create'])->name('tasks-statuses-changes.create');
        Route::post('/', [App\Http\Controllers\TaskStatusChangeController::class, 'store'])->name('tasks-statuses-changes.store');
        Route::get('/{id}/edit', [App\Http\Controllers\TaskStatusChangeController::class, 'edit'])->name('tasks-statuses-changes.edit');
        Route::put('/{id}', [App\Http\Controllers\TaskStatusChangeController::class, 'update'])->name('tasks-statuses-changes.update');
        Route::delete('/{id}', [App\Http\Controllers\TaskStatusChangeController::class, 'destroy'])->name('tasks-statuses-changes.destroy');
    });

    Route::prefix('companies')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\CompanyController::class, 'index'])->name('companies.index');
        Route::get('/create', [App\Http\Controllers\CompanyController::class, 'create'])->name('companies.create');
        Route::post('/', [App\Http\Controllers\CompanyController::class, 'store'])->name('companies.store');
        Route::get('/{id}/edit', [App\Http\Controllers\CompanyController::class, 'edit'])->name('companies.edit');
        Route::put('/{id}', [App\Http\Controllers\CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/{id}', [App\Http\Controllers\CompanyController::class, 'destroy'])->name('companies.destroy');
        Route::get('/quick-search', [App\Http\Controllers\CompanyController::class, 'quickSearch'])->name('companies.quick-search');
    });

    Route::prefix('companies-contacts')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\CompanyContactController::class, 'index'])->name('companies-contacts.index');
        Route::get('/create', [App\Http\Controllers\CompanyContactController::class, 'create'])->name('companies-contacts.create');
        Route::post('/', [App\Http\Controllers\CompanyContactController::class, 'store'])->name('companies-contacts.store');
        Route::get('/{id}/edit', [App\Http\Controllers\CompanyContactController::class, 'edit'])->name('companies-contacts.edit');
        Route::put('/{id}', [App\Http\Controllers\CompanyContactController::class, 'update'])->name('companies-contacts.update');
        Route::delete('/{id}', [App\Http\Controllers\CompanyContactController::class, 'destroy'])->name('companies-contacts.destroy');
        Route::get('/quick-search', [App\Http\Controllers\CompanyContactController::class, 'quickSearch'])->name('companies-contacts.quick-search');
    });

    Route::prefix('human-resources')->group(function () {
        Route::get('', [App\Http\Controllers\HumanResourcesController::class, 'index'])->name('human-resources.index');
        Route::get('/create', [App\Http\Controllers\HumanResourcesController::class, 'create'])->name('human-resources.create');
        Route::post('/', [App\Http\Controllers\HumanResourcesController::class, 'store'])->name('human-resources.store');
        Route::get('/{id}/edit', [App\Http\Controllers\HumanResourcesController::class, 'edit'])->name('human-resources.edit');
        Route::put('/{id}', [App\Http\Controllers\HumanResourcesController::class, 'update'])->name('human-resources.update');
        Route::delete('/{id}', [App\Http\Controllers\HumanResourcesController::class, 'destroy'])->name('human-resources.destroy');
        Route::get('/quick-search', [App\Http\Controllers\HumanResourcesController::class, 'quickSearch'])->name('human-resources.quick-search');
        Route::get('/{id}/generate-pdf-hr', [App\Http\Controllers\HumanResourcesController::class, 'generatePDFHR'])->name('human-resources.generate-pdf-hr');
        Route::get('/{id}/pdf-blade', [App\Http\Controllers\HumanResourcesController::class, 'PDFblade'])->name('human-resources.pdf-blade');
    });

    Route::prefix('cold-emailing-credentials')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ColdEmailingCredentialsController::class, 'index'])->name('cold-emailing-credentials.index');
        Route::get('/create', [App\Http\Controllers\ColdEmailingCredentialsController::class, 'create'])->name('cold-emailing-credentials.create');
        Route::post('/', [App\Http\Controllers\ColdEmailingCredentialsController::class, 'store'])->name('cold-emailing-credentials.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ColdEmailingCredentialsController::class, 'edit'])->name('cold-emailing-credentials.edit');
        Route::put('/{id}', [App\Http\Controllers\ColdEmailingCredentialsController::class, 'update'])->name('cold-emailing-credentials.update');
        Route::delete('/{id}', [App\Http\Controllers\ColdEmailingCredentialsController::class, 'destroy'])->name('cold-emailing-credentials.destroy');
    });

    Route::prefix('cold-emailing-rules')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ColdEmailingRulesController::class, 'index'])->name('cold-emailing-rules.index');
        Route::get('/create', [App\Http\Controllers\ColdEmailingRulesController::class, 'create'])->name('cold-emailing-rules.create');
        Route::post('/', [App\Http\Controllers\ColdEmailingRulesController::class, 'store'])->name('cold-emailing-rules.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ColdEmailingRulesController::class, 'edit'])->name('cold-emailing-rules.edit');
        Route::put('/{id}', [App\Http\Controllers\ColdEmailingRulesController::class, 'update'])->name('cold-emailing-rules.update');
        Route::delete('/{id}', [App\Http\Controllers\ColdEmailingRulesController::class, 'destroy'])->name('cold-emailing-rules.destroy');
    });

    Route::prefix('emails-threads')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\EmailThreadController::class, 'index'])->name('emails-threads.index');
        Route::get('/create', [App\Http\Controllers\EmailThreadController::class, 'create'])->name('emails-threads.create');
        Route::post('/', [App\Http\Controllers\EmailThreadController::class, 'store'])->name('emails-threads.store');
        Route::get('/{id}/edit', [App\Http\Controllers\EmailThreadController::class, 'edit'])->name('emails-threads.edit');
        Route::put('/{id}', [App\Http\Controllers\EmailThreadController::class, 'update'])->name('emails-threads.update');
        Route::delete('/{id}', [App\Http\Controllers\EmailThreadController::class, 'destroy'])->name('emails-threads.destroy');
    });

    Route::prefix('emails-threads-messages')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\EmailThreadMessageController::class, 'index'])->name('emails-threads-messages.index');
        Route::get('/create', [App\Http\Controllers\EmailThreadMessageController::class, 'create'])->name('emails-threads-messages.create');
        Route::post('/', [App\Http\Controllers\EmailThreadMessageController::class, 'store'])->name('emails-threads-messages.store');
        Route::get('/{id}/edit', [App\Http\Controllers\EmailThreadMessageController::class, 'edit'])->name('emails-threads-messages.edit');
        Route::put('/{id}', [App\Http\Controllers\EmailThreadMessageController::class, 'update'])->name('emails-threads-messages.update');
        Route::delete('/{id}', [App\Http\Controllers\EmailThreadMessageController::class, 'destroy'])->name('emails-threads-messages.destroy');
    });

    Route::prefix('wiki-categories')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\WikiCategoryController::class, 'index'])->name('wiki-categories.index');
        Route::get('/create', [App\Http\Controllers\WikiCategoryController::class, 'create'])->name('wiki-categories.create');
        Route::post('/', [App\Http\Controllers\WikiCategoryController::class, 'store'])->name('wiki-categories.store');
        Route::get('/{id}/edit', [App\Http\Controllers\WikiCategoryController::class, 'edit'])->name('wiki-categories.edit');
        Route::put('/{id}', [App\Http\Controllers\WikiCategoryController::class, 'update'])->name('wiki-categories.update');
        Route::delete('/{id}', [App\Http\Controllers\WikiCategoryController::class, 'destroy'])->name('wiki-categories.destroy');
    });

    Route::get('wiki-articles/wiki/{wikiCategoryId?}/{wikiArticleId?}', [App\Http\Controllers\WikiArticleController::class, 'wiki'])->name('wiki-articles.wiki');
    Route::prefix('wiki-articles')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\WikiArticleController::class, 'index'])->name('wiki-articles.index');
        Route::get('/create', [App\Http\Controllers\WikiArticleController::class, 'create'])->name('wiki-articles.create');
        Route::post('/', [App\Http\Controllers\WikiArticleController::class, 'store'])->name('wiki-articles.store');
        Route::get('/{id}/edit', [App\Http\Controllers\WikiArticleController::class, 'edit'])->name('wiki-articles.edit');
        Route::put('/{id}', [App\Http\Controllers\WikiArticleController::class, 'update'])->name('wiki-articles.update');
        Route::delete('/{id}', [App\Http\Controllers\WikiArticleController::class, 'destroy'])->name('wiki-articles.destroy');
    });

    Route::prefix('events-types')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\EventTypeController::class, 'index'])->name('events-types.index');
        Route::get('/create', [App\Http\Controllers\EventTypeController::class, 'create'])->name('events-types.create');
        Route::post('/', [App\Http\Controllers\EventTypeController::class, 'store'])->name('events-types.store');
        Route::get('/{id}/edit', [App\Http\Controllers\EventTypeController::class, 'edit'])->name('events-types.edit');
        Route::put('/{id}', [App\Http\Controllers\EventTypeController::class, 'update'])->name('events-types.update');
        Route::delete('/{id}', [App\Http\Controllers\EventTypeController::class, 'destroy'])->name('events-types.destroy');
    });

    Route::prefix('events')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
        Route::get('calendar', [App\Http\Controllers\EventController::class, 'calendar'])->name('events.calendar');
        Route::get('/create', [App\Http\Controllers\EventController::class, 'create'])->name('events.create');
        Route::post('/', [App\Http\Controllers\EventController::class, 'store'])->name('events.store');
        Route::get('/{id}/edit', [App\Http\Controllers\EventController::class, 'edit'])->name('events.edit');
        Route::put('/{id}', [App\Http\Controllers\EventController::class, 'update'])->name('events.update');
        Route::delete('/{id}', [App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');
    });

    Route::prefix('cold-calling-lists')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ColdCallingListsController::class, 'index'])->name('cold-calling-lists.index');
        Route::get('/create', [App\Http\Controllers\ColdCallingListsController::class, 'create'])->name('cold-calling-lists.create');
        Route::post('/', [App\Http\Controllers\ColdCallingListsController::class, 'store'])->name('cold-calling-lists.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ColdCallingListsController::class, 'edit'])->name('cold-calling-lists.edit');
        Route::put('/{id}', [App\Http\Controllers\ColdCallingListsController::class, 'update'])->name('cold-calling-lists.update');
        Route::delete('/{id}', [App\Http\Controllers\ColdCallingListsController::class, 'destroy'])->name('cold-calling-lists.destroy');
    });

    Route::prefix('cold-calling-lists-contacts')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\ColdCallingListsContactsController::class, 'index'])->name('cold-calling-lists-contacts.index');
        Route::get('/create', [App\Http\Controllers\ColdCallingListsContactsController::class, 'create'])->name('cold-calling-lists-contacts.create');
        Route::post('/', [App\Http\Controllers\ColdCallingListsContactsController::class, 'store'])->name('cold-calling-lists-contacts.store');
        Route::get('/{id}/edit', [App\Http\Controllers\ColdCallingListsContactsController::class, 'edit'])->name('cold-calling-lists-contacts.edit');
        Route::put('/{id}', [App\Http\Controllers\ColdCallingListsContactsController::class, 'update'])->name('cold-calling-lists-contacts.update');
        Route::delete('/{id}', [App\Http\Controllers\ColdCallingListsContactsController::class, 'destroy'])->name('cold-calling-lists-contacts.destroy');
        Route::post('/import-contacts', [App\Http\Controllers\ColdCallingListsContactsController::class, 'importContacts'])->name('cold-calling-lists-contacts.import-contacts');
    });

    Route::prefix('deals-statuses')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\DealStatusController::class, 'index'])->name('deals-statuses.index');
        Route::get('/create', [App\Http\Controllers\DealStatusController::class, 'create'])->name('deals-statuses.create');
        Route::post('/', [App\Http\Controllers\DealStatusController::class, 'store'])->name('deals-statuses.store');
        Route::get('/{id}/edit', [App\Http\Controllers\DealStatusController::class, 'edit'])->name('deals-statuses.edit');
        Route::put('/{id}', [App\Http\Controllers\DealStatusController::class, 'update'])->name('deals-statuses.update');
        Route::delete('/{id}', [App\Http\Controllers\DealStatusController::class, 'destroy'])->name('deals-statuses.destroy');
    });

    Route::prefix('deals-sources')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\DealSourceController::class, 'index'])->name('deals-sources.index');
        Route::get('/create', [App\Http\Controllers\DealSourceController::class, 'create'])->name('deals-sources.create');
        Route::post('/', [App\Http\Controllers\DealSourceController::class, 'store'])->name('deals-sources.store');
        Route::get('/{id}/edit', [App\Http\Controllers\DealSourceController::class, 'edit'])->name('deals-sources.edit');
        Route::put('/{id}', [App\Http\Controllers\DealSourceController::class, 'update'])->name('deals-sources.update');
        Route::delete('/{id}', [App\Http\Controllers\DealSourceController::class, 'destroy'])->name('deals-sources.destroy');
    });

    Route::prefix('deals')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\DealController::class, 'index'])->name('deals.index');
        Route::get('/board', [App\Http\Controllers\DealController::class, 'board'])->name('deals.board');
        Route::get('/create', [App\Http\Controllers\DealController::class, 'create'])->name('deals.create');
        Route::post('/', [App\Http\Controllers\DealController::class, 'store'])->name('deals.store');
        Route::get('/{id}/edit', [App\Http\Controllers\DealController::class, 'edit'])->name('deals.edit');
        Route::put('/{id}', [App\Http\Controllers\DealController::class, 'update'])->name('deals.update');
        Route::delete('/{id}', [App\Http\Controllers\DealController::class, 'destroy'])->name('deals.destroy');
    });

    Route::prefix('deals-notes')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\DealNoteController::class, 'index'])->name('deals-notes.index');
        Route::get('/create', [App\Http\Controllers\DealNoteController::class, 'create'])->name('deals-notes.create');
        Route::post('/', [App\Http\Controllers\DealNoteController::class, 'store'])->name('deals-notes.store');
        Route::get('/{id}/edit', [App\Http\Controllers\DealNoteController::class, 'edit'])->name('deals-notes.edit');
        Route::put('/{id}', [App\Http\Controllers\DealNoteController::class, 'update'])->name('deals-notes.update');
        Route::delete('/{id}', [App\Http\Controllers\DealNoteController::class, 'destroy'])->name('deals-notes.destroy');
    });

    Route::prefix('document-folders')->middleware('admin')->group(function () {
        Route::get('/create', [App\Http\Controllers\DocumentFolderController::class, 'create'])->name('document-folders.create');
        Route::post('/store', [App\Http\Controllers\DocumentFolderController::class, 'store'])->name('document-folders.store');
        Route::get('/{id}/edit', [App\Http\Controllers\DocumentFolderController::class, 'edit'])->name('document-folders.edit');
        Route::put('/{id}/update', [App\Http\Controllers\DocumentFolderController::class, 'update'])->name('document-folders.update');

        Route::delete('/{id}', [App\Http\Controllers\DocumentFolderController::class, 'destroy'])->name('document-folders.destroy');
        Route::get('/document-folders/children/{id}', 'DocumentFolderController@getChildren')->name('document-folders.children');

        Route::get('/create-file', [App\Http\Controllers\DocumentFolderFileController::class, 'create'])->name('document-folders.create-file');
        Route::post('/store-file', [App\Http\Controllers\DocumentFolderFileController::class, 'store'])->name('document-folders.store-file');
        Route::get('/{id}/edit-file', [App\Http\Controllers\DocumentFolderFileController::class, 'edit'])->name('document-folders.edit-file');
        Route::put('/{id}/update-file', [App\Http\Controllers\DocumentFolderFileController::class, 'update'])->name('document-folders.update-file');
        Route::delete('/{id}/delete-file', [App\Http\Controllers\DocumentFolderFileController::class, 'destroy'])->name('document-folders.destroy-file');
    });

    Route::middleware(['folder-access'])->group(function () {
        Route::prefix('document-folders')->group(function () {
            Route::get('', [App\Http\Controllers\DocumentFolderController::class, 'index'])->name('document-folders.index');
        });
    });


    Route::prefix('languages')->middleware('admin')->group(function () {
        Route::get('', [App\Http\Controllers\LanguageController::class, 'index'])->name('languages.index');
        Route::get('/create', [App\Http\Controllers\LanguageController::class, 'create'])->name('languages.create');
        Route::post('/store', [App\Http\Controllers\LanguageController::class, 'store'])->name('languages.store');

        Route::get('/{id}/edit', [App\Http\Controllers\LanguageController::class, 'edit'])->name('languages.edit');
        Route::put('/{id}/update', [App\Http\Controllers\LanguageController::class, 'update'])->name('languages.update');

        Route::delete('/{id}', [App\Http\Controllers\LanguageController::class, 'destroy'])->name('languages.destroy');
    });

});


