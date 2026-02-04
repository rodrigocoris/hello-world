<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\CetiController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ApplicationController;

Route::get('/404', [ErrorController::class, 'error404'])->name('error.404');
Route::get('/403', [ErrorController::class, 'error403'])->name('error.403');
Route::get('/500', [ErrorController::class, 'error500'])->name('error.500');

Route::middleware(['registrationFlow'])->group(function() {
// Route::middleware(['guest'])->group(function () {
    # Routes for google authentication
    Route::get('/login-google', [GoogleController::class, 'redirectToGoogleLogin'])->name('login.google');
    Route::get('/register-google', [GoogleController::class, 'redirectToGoogleRegister'])->name('register.google');
    Route::get('/google-callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

    # Routes for github authentication
    Route::get('/login-github', [GithubController::class, 'redirectToGithubLogin'])->name('login.github');
    Route::get('/register-github', [GithubController::class, 'redirectToGithubRegister'])->name('register.github');
    Route::get('/github-callback', [GithubController::class, 'handleGithubCallback'])->name('github.callback');

    # Routes for CETI authentication
    Route::get('/login-ceti', [CetiController::class, 'redirectToCetiLogin'])->name('login.ceti');
    Route::get('/register-ceti', [CetiController::class, 'redirectToCetiRegister'])->name('register.ceti');
    Route::post('/ceti-callback', [CetiController::class, 'handleCetiCallback'])->name('ceti.callback');

    # Routes for normal authentication
    Route::get('/iniciar-sesion', [AuthController::class, 'indexLogin'])->name('auth.login');
    Route::get('/registrarse', [AuthController::class, 'indexSingUp'])->name('auth.sing-up');
    Route::get('/reset-form', [AuthController::class, 'resetForm'])->name('auth.reset-form');
    Route::get('/recuperar-contraseña', [AuthController::class, 'indexRecovery'])->name('auth.recovery');
    Route::get('/recuperar-contraseña', [AuthController::class, 'createRecovery'])->name('auth.recovery-token');
    Route::get('/cambiar-contraseña/{extenced_token}', [AuthController::class, 'createChangePassword'])->name('auth.change-password');
    
    Route::get('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

    //Route::middleware(['recaptcha'])->group(function() {
        Route::post('/iniciar-sesion', [AuthController::class, 'login'])->name('auth.login.post');
        Route::post('/verificar-suscripcion', [AuthController::class, 'createVerifySubscription'])->name('auth.verify-suscription.create');
        Route::post('/registrarse', [AuthController::class, 'getSingUpData'])->name('auth.get-sing-up-data.post');
        Route::post('/recuperar-contraseña', [AuthController::class, 'sendRecoveryEmail'])->name('auth.send-recovery-email.post');
        Route::put('/cambiar-contraseña', [AuthController::class, 'changePassword'])->name('auth.change-password.put');
    //});
    
    Route::get('/verificar-correo-electronico', [AuthController::class, 'createVerifyEmail'])->name('auth.verify-email');
    Route::post('/obtener-tiempo-de-reenvio', [AuthController::class, 'getResendTime'])->name('auth.get-resend-time');
    
    Route::post('/reenviar-codigo', [AuthController::class, 'resendCode'])->name('auth.resend-code');
    Route::post('/validar-codigo', [AuthController::class, 'validateCode'])->name('auth.validate-code');
    // });
    
    Route::get('/formulario-organizacion', [AuthController::class, 'organizationCreate'])->name('organization.create');
    Route::post('/formulario-organizacion', [AuthController::class, 'organizationStore'])->name('organization.store');

    Route::get('/planes', [SubscriptionController::class, 'indexPlans'])->name('plans');
    Route::get('/pagar-suscripcion', [SubscriptionController::class, 'showPaymentForm'])->name('auth.pay-subscription');
    Route::post('/pagar-suscripcion/procesar', [SubscriptionController::class, 'paySubscription'])->name('auth.payment.process');
    Route::post('/suscripcion-exitosa', [SubscriptionController::class, 'successSubscription'])->name('auth.success-subscription');

    Route::post('/update-account-data', [AuthController::class, 'updateAccountData'])->name('auth.update-account-data');

    Route::get('/ejercicio/{exercise_token}', [ExerciseController::class, 'show'])->name('exercises.show');
    Route::post('/ejercicio/ejecutar', [ExerciseController::class, 'execute'])->name('exercise.execute');
    Route::get('/ejercicio/cpp/demo', [ExerciseController::class, 'demo'])->name('exercise.demo');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/post/{slug}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('/modulo/{module}', [ModuleController::class, 'show'])->name('module.show');
    Route::get('/panel', [ModuleController::class, 'list'])->name('dashboard');

    // Route::middleware(['auth'])->group(function() {   
        Route::get('/ejercicios/{lesson_id}', [ExerciseController::class, 'list'])->name('exercise.list');

        Route::get('/ejercicio', function () {
            return view('user.exercise');
        });

        Route::get('/mi-perfil', function() {
            return view('user.my-profile');
        });

        Route::post('/ejercicio/procesar', [ExerciseController::class, 'getUserCode'])->name('exersice.get-user-code');
    // });

    Route::redirect('/', '/inicio');
    Route::get('/inicio', [ApplicationController::class, 'index'])->name('landing-page');

    Route::get('/terminos-de-servicio', function () {
        return view('privacy.terms-of-service');
    });

    Route::get('/politicas-de-privacidad', function () {
        return view('privacy.privacy-policy');
    });
    
    Route::get('/cambiar-contraseña', function () {
        return view('login.change-password');
    });

    Route::get('/nosotros', [ApplicationController::class, 'aboutUs'])->name('about-us');
    Route::get('/ayuda', [ApplicationController::class, 'help'])->name('ayuda');

    Route::get('/test/{lesson}', function ($lesson) {
        return view('test.api-test', compact('lesson'));
    });

    Route::get('/nodos', function () {
        return view('test.nodes');
    });
    
    Route::get('/contacto', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contacto/enviar-mensaje', [ContactController::class, 'sendEmail'])->name('contact.sendEmail');
});

Route::get('/categoria/{title}/{description}', function ($title, $description) {
    return view('application.category-view', [
        'title' => urldecode($title),
        'description' => urldecode($description)
    ]);
});

Route::get('/old-exercise', function () {
    return view('test.old-exercise');
});