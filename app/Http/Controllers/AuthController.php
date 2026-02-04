<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserToken;
use App\Models\User;
use App\Models\OrgCategories;
use App\Models\Organization;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller
{
    /**
     * Displays the login page view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Displays the sign-up page view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexSingUp(): View
    {
        return view('auth.sing-up');
    }

    /**
     * Displays the recovery page view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexRecovery(): View
    {
        return view('auth.recovery');
    }

    /**
     * Handles the user subscription verification process.
     * Validates the subscription data and redirects to the appropriate page
     * based on the selected plan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function createVerifySubscription(Request $request): View|RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!@#$%^&*]/', 'confirmed'],
            'plan_id'  => 'required|integer',
        ]);

        if ($request->plan_id === 1) {
            // The free plan was selected, so there is no need to show the payment options.
            $this->singUp($request);
        } else if ($request->plan_id === 2 || $request->plan_id === 3) {
            // Create a session variable with the validated data.
            Session::put('subscription_data', $request);

            return view('auth.verify-subscription');
        }

        return redirect('/403')->withErrors(['error' => 'El rol seleccionado no coincide o parece ser inválido']);
    }

    /**
     * Displays the email verification page based on the session token.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function createVerifyEmail(): View
    {
        $token = Session::get('verification_token');
        $verification = UserToken::where('extenced_token', $token)->first();

        return view('auth.verify-email', ['verification' => $verification]);
    }

    /**
     * Displays the recovery page based on the session token.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function createRecovery(): View|RedirectResponse
    {
        $token = Session::get('verification_token');
        $verification = UserToken::where('extenced_token', $token)->first();

        return view('auth.recovery', ['verification' => $verification]);
    }

    /**
     * Handles the change password process based on the extended token.
     * Validates the token and displays the password change view.
     *
     * @param string $extenced_token
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function createChangePassword(string $extenced_token): View|RedirectResponse
    {
        $verification = UserToken::where('extenced_token', $extenced_token)->first();

        return $this->handleRecoveryProcess($verification->user->username, $verification->token, 'auth.change-password', 'user_email', $verification->extenced_token);
    }

    /**
     * Handles the recovery process by verifying the user and token.
     * If valid, it shows the appropriate view for password change or recovery.
     *
     * @param string $username
     * @param int $token
     * @param string $viewName
     * @param string $emailKey
     * @param string $extenced_token
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    private function handleRecoveryProcess(string $username, int $token, string $viewName, string $emailKey, string $extenced_token): View|RedirectResponse
    {
        $error_message = 'El token de recuperación y/o el nombre de usuario son inválidos o han expirado.';
        $user_verification = $this->verifyUserAndToken($username, $token, $error_message);

        if ($user_verification instanceof RedirectResponse) {
            return $user_verification;
        }

        return view($viewName, [
            $emailKey => $user_verification->email,
            'extenced_token' => $extenced_token
        ]);
    }

    /**
     * Verifies the user and token for the recovery process.
     * If valid, returns the user; otherwise, redirects with an error.
     *
     * @param string $username
     * @param int $token
     * @param string $error_message
     * @return \App\Models\User|\Illuminate\Http\RedirectResponse
     */
    private function verifyUserAndToken(string $username, int $token, string $error_message): User|RedirectResponse
    {
        $user_verification = User::where('username', $username)->first();
        $token_verification = UserToken::where('token', $token)->first();

        if (!$user_verification || !$token_verification) {
            return redirect('/403')->withErrors(['error' => $error_message]);
        }

        return $user_verification;
    }

    /**
     * Authenticates the user by verifying the provided email and password.
     * If the email is verified, the user is redirected to their intended destination.
     * Otherwise, a warning is shown asking them to verify their email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // First verify if the credentials are correct
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // If the credentials are correct, check if the e-mail has been verified.
            if ($user->verified_at === null) {
                Auth::logout();
                return redirect()->back()->with('warning', 'No puedes iniciar sesión hasta verificar tu correo electrónico usando el código de verificación que enviamos a <span style="color:#E61A4F">' . $request->email . '</span>.');
            }

            // If the email has been verified, redirect the user to
            return redirect()->intended('/panel');
        } else {
            // If the credentials are not correct, display the following error message
            return redirect()->back()->with('error', 'Las credenciales no coinciden con nuestros registros.');
        }
    }

    /**
     * Retrieves and validates sign-up data from the request or session.
     * Handles both regular and dynamic requests (e.g., Google or GitHub sign-ups).
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function getSingUpData(Request $request)
    {
        // Initialize $is_dimamic_request as false in case $request is different from session_request
        $is_dimamic_request = true;

        // Define the rules that we will apply to our request
        $rules = [
            'username'     => 'required|string|max:255',
            'email'        => 'required|string|email|max:255',
            'plan_id'      => 'required|integer',
            'payment_term' => 'required|in:monthly,yearly',
        ];

        // Set $dinamic_request to session data if available, otherwise use $request.
        $dinamic_request = match (true) {
            session('google_user_data') !== null => session('google_user_data'),
            session('github_user_data') !== null => session('github_user_data'),

            default => $request,
        };

        // Add the validation rule for the password only if it is not a Google or GitHub session.
        if ($dinamic_request === $request) {
            // Determine if we are dealing with old or new request data
            $is_dimamic_request = false;

            $rules['email']   .= '|unique:users';
            $rules['password'] = ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!@#$%^&*]/', 'confirmed'];
        }

        try {
            // Validate the request with the specified rules
            $validatedData = $request->validate($rules);
        } catch (ValidationException $e) {
            // Get the validation errors
            $errors = $e->errors();

            // Combine all error messages into a single string
            $errorMessage = '';
            foreach ($errors as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $errorMessage .= $error . ' ';
                }
            }

            // Optionally, trim the final string
            $errorMessage = trim($errorMessage);

            save_log('error', $errorMessage, 500, $errors);

            // Redirect back with the combined error message
            return redirect()->back()->with('error', $errorMessage);
        }

        // Adjust the payment term based on the role to avoid inconsistencies
        $payment_term = match (intval($request->plan_id)) {
            1 => [1, 'monthly'],
            2 => $request->payment_term === 'monthly' ? [2, 'monthly'] : [3, 'yearly'],
            4 => [4, 'monthly'],
            default => [intval($request->plan_id), 'monthly'], // or any default value you want
        };

        // Store user data
        session([
            'account_creation_data' => [
                'user_token'      => null,
                'username'        => $is_dimamic_request ? $dinamic_request['username']      : $request->username,
                'email'           => $is_dimamic_request ? $dinamic_request['email']         : $request->email,
                'verified_at'     => $is_dimamic_request ? now()                             : null,
                'password'        => $is_dimamic_request ? $request->password                : $dinamic_request['password'],
                'role_id'         =>                       1,
                'organization_id' =>                       null,
                'plan_id'         =>                       $payment_term[0],
                'payment_term'    =>                       $payment_term[1],
                'external_key'    => $is_dimamic_request ? $dinamic_request['external_key']  : null,
                'external_id'     => $is_dimamic_request ? $dinamic_request['external_id']   : null,
                'external_auth'   => $is_dimamic_request ? $dinamic_request['external_auth'] : null,
            ]
        ]);

        // If the user has registered with an external method, then register your information.
        if ($externalUser = $this->storeUser()) {
            // If the user has registered with an external method, then register your information.
            if ($is_dimamic_request) {
                $planSelected = $payment_term[0];
                return $this->planSelectedRedirection($planSelected, $externalUser); // Redirecciona según el plan seleccionado
            }

            // Redirect to email verification
            else {
                Session::put('email_verified', null);
                return $this->singUp($externalUser);
            }
        }

        // If the user could not be authenticated, display the following error message
        return redirect()->back()->with('error', 'Las credenciales no coinciden con nuestros registros.');
    }

    /**
     * Registers the user and sends a confirmation email with a verification token.
     * After registration, redirects the user to the email verification page.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function singUp($user)
    {
        //Generate 5-digit authentication token
        $token_array = array_map(function () {
            return random_int(0, 9);
        }, range(1, 5));

        // Convert the array to a string if needed
        $token = implode('', $token_array);

        // Generate the extended security token
        $extenced_token = Str::random(64);

        // Save token in email_verifications table
        $verification = UserToken::create([
            'user_id'        => $user->user_id,
            'token'          => $token,
            'extenced_token' => $extenced_token,
            'type'           => 'verification'
        ]);

        // Setting the parameters of the sendConfirmationEmail() function
        $subject = 'Confirmación de correo electrónico';
        $subtitle = '¡Gracias por unirte a Hello World!';

        // Send confirmation email
        $this->sendConfirmationEmail($user->email, $token_array, $user->username, $subject, $subtitle);

        // Save the extended token in the session
        Session::put('verification_token', $verification->extenced_token);

        return redirect()->route('auth.verify-email')->with('success', 'Registro exitoso. Por favor, revisa tu correo electrónico y copia el código de verificación que enviamos para validar tu cuenta.');
    }

    /**
     * Logs out the user and invalidates the session.
     * Redirects the user to the homepage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Stores the user data from the session and creates a new user record.
     * The user is created in the database with the provided account data.
     *
     * @return \App\Models\User
     */
    public function storeUser(): User
    {
        $accountData = Session::get('account_creation_data');

        $user_token = Str::uuid();
        $accountData['user_token'] = (string) $user_token;

        $user = new User();
        $user->user_token        = $user_token;
        $user->username          = $accountData['username'];
        $user->email             = $accountData['email'];
        $user->verified_at       = $accountData['verified_at'];
        $user->password          = Hash::make($accountData['password']);
        $user->role_id           = $accountData['role_id'];
        $user->organization_id   = $accountData['organization_id'];
        $user->external_id       = $accountData['external_id'];
        $user->external_auth     = $accountData['external_auth'];
        $user->save();

        Session::put('account_creation_data', $accountData);

        return $user;
    }

    /**
     * Displays the form to create a new organization.
     * Retrieves and passes all organization categories to the view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function organizationCreate()
    {

        $orgCategories = OrgCategories::all();


        return view('auth.organization-form', [
            'orgCategories' => $orgCategories,
        ]);
    }

    /**
     * Stores a new organization based on the provided request data.
     * Validates the organization data and creates a new organization record.
     * Redirects back to the organization creation page with a success message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function organizationStore(Request $request)
    {
        $request->validate([
            'name_organization' => 'required|string|max:255',
            'org_category' => 'required|exists:org_categories,id',
            'email' => 'required|email',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'description' => 'string',
        ]);

        $location = $request->country . ', ' . $request->state . ', ' . $request->city . ', ' . $request->zip_code . ', ' . $request->street;

        $organization = Organization::create([
            'organization_name' => $request->name_organization,
            'org_category' => $request->org_category,
            'organization_email' => $request->email,
            'location' => $location,
            'description' => $request->description,
        ]);

        if ($organization) {
            $currentUser = Session::get('account_creation_data');

            // Update the user's organization_id with the new organization's ID
            $user = User::where('user_token', $currentUser['user_token'])->first();
            $user->organization_id = $organization->organization_id;
            $user->save();

            return redirect()->route('auth.pay-subscription')->with('info', 'Asegúrate de que todos los datos sean correctos antes de pagar.');
        }

        return redirect()->route('organization.create')->with('error', 'No se pudo registrar la organización, por favor, intenta de nuevo.');
    }

    /**
     * Handles the redirection after a user selects a subscription plan.
     * Depending on the selected plan, the user is redirected to their dashboard, 
     * payment page, or a message for organizational plan selection.
     * 
     * @param int $planSelected The plan selected by the user.
     * @param User|null $user The authenticated user, if available.
     * @return \Illuminate\Http\RedirectResponse|string
     */
    private function planSelectedRedirection(int $planSelected, $user = null)
    {
        // Explicitly redirect to user Dashboard if plan 1 is selected
        if ($planSelected == 1) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        // Explicitly redirect to the payment page if plan 2 or 3 is selected
        else if ($planSelected == 2 || $planSelected == 3) {
            Session::put('complete_payment', null);
            Session::put('user_token', $user->user_token);
            return redirect()->route('auth.pay-subscription')->with('info', 'Asegúrate de que todos los datos sean correctos antes de pagar.');
        }

        // Explicit redirection for selecting how many licenses to take for plan 4
        else if ($planSelected == 4) return redirect()->route('organization.create');

        // Explicit 403 redirection if the selected plan is invalid
        else return redirect('/403')->withErrors(['error' => 'El plan seleccionado no coincide o parece ser inválido']);
    }

    /**
     * Sends a password recovery email to the user with a generated token.
     * Validates the email input and generates a recovery token to send to the user.
     * 
     * @param Request $request The incoming request with the email for recovery.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendRecoveryEmail(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        // Search for the user by email
        $user = User::where('email', $request->email)->first();

        // Return a warning message if the user is not found
        if (!$user) {
            return redirect()->back()->with('warning', 'El correo electrónico que ingresaste no coincide en la base de datos.');
        }

        // Generate a new recovery token
        $token_array = array_map(function () {
            return random_int(0, 9);
        }, range(1, 5));
        $token = implode('', $token_array);

        // Generate the extended security token
        $extenced_token = Str::random(64);

        // Save the token and user email in the UserToken table
        $verification = new UserToken();
        $verification->user_id = $user->user_id;
        $verification->token = $token;
        $verification->extenced_token = $extenced_token;
        $verification->type = 'recovery';
        $verification->save();

        // Send a recovery confirmation email to the user
        $subject = 'Envio de código de recuperación de contraseña';
        $subtitle = 'Este es tu código de recuperación de contraseña, copialo y pegalo en el formulario de recuperación.';
        $this->sendConfirmationEmail($user->email, $token_array, $user->username, $subject, $subtitle);

        // Store the extended token in the session
        Session::put('verification_token', $verification->extenced_token);

        // Redirect the user to the recovery token page with a success message
        return redirect()->route('auth.recovery-token')->with('success', 'Código de recuperación enviado a <span style="color:#E61A4F">' . $request->email . '</span>. Por favor, revisa tu correo electrónico y copia el código de recuperación que te enviamos.');
    }

    /**
     * Changes the user's password after validating the input and user existence.
     * Validates the password and email, then updates the user's password.
     * 
     * @param Request $request The incoming request with the new password and user email.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        // Validate the password and user email inputs
        $request->validate([
            'password'   => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!@#$%^&*]/', 'confirmed'],
            'user_email' => 'required|string|email|max:255|exists:users,email'
        ]);

        // Search for the user by email
        $user = User::where('email', $request->user_email)->first();

        // Return an error if the user is not found
        if (!$user) {
            return redirect()->back()->with('error', 'El usuario no existe.');
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the password reset token if it exists
        UserToken::where('user_id', $user->user_id)->delete();

        // Redirect to the login page with a success message
        return redirect()->route('auth.login')->with('success', 'La contraseña ha sido actualizada con éxito, ya puedes iniciar sesión.');
    }

    /**
     * Validates a verification or recovery code input by the user.
     * Depending on the action (verify or recovery), it either verifies the user or redirects to the change password page.
     * 
     * @param Request $request The incoming request with the validation code and token.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validateCode(Request $request)
    {
        // Validate the input fields: the verification code and extended token
        $request->validate([
            'validate-code.*' => 'required|integer|min:0|max:9',
            'extenced_token' => 'required|string|exists:user_tokens,extenced_token',
            'input_request'  => 'required|string|in:verify,recovery,elimination',
        ]);

        // Combine the verification code digits into a single token
        $token = implode('', $request->input('validate-code'));

        // Search for the verification record with the provided token
        $verification = UserToken::where('extenced_token', $request->extenced_token)
            ->where('token', $token)
            ->first();

        // Return an error if the verification token is invalid
        if (!$verification) {
            return redirect()->back()->with('error', 'Código de verificación inválido. Inténtalo de nuevo.');
        }

        // Check if the verification code is valid within 10 minutes
        $createdTime = strtotime($verification->last_sent_at);
        $currentTime = time();
        $timeDifference = $currentTime - $createdTime;

        if ($timeDifference > 600 && $verification->last_sent_at !== null) { // 600 seconds = 10 minutes
            return redirect()->back()->with('error', 'El código de verificación ha expirado. Solicita uno nuevo.');
        }

        // Handle the "verify" action by updating the user's verification status
        if ($request->input_request === "verify") {
            $user = $verification->user;
            if ($user) {
                $user->verified_at = Carbon::now();
                $user->save();

                Session::forget('email_verified');

                // Update the account data in session
                $accountData = Session::get('account_creation_data');
                $accountData['verified_at'] = Carbon::now();
                Session::put('account_creation_data', $accountData);

                // Redirect to the appropriate plan selection page
                $plan_id = $accountData['plan_id'];
                return $this->planSelectedRedirection($plan_id, $user);
            } else {
                return redirect()->route('auth.verify-email')->with('error', 'No se pudo verificar el correo electrónico. El usuario no existe.');
            }
        }

        // Handle the "recovery" action by redirecting to the change password page
        else if ($request->input_request === "recovery") {
            return redirect()->route('auth.change-password', ['extenced_token' => $request->extenced_token])
                ->with('success', 'Código de recuperación validado con éxito.');
        }
    }

    /**
     * Placeholder method for updating account data.
     * Currently only outputs "updateAccountData" for testing purposes.
     * 
     * @param Request $request The incoming request to update account data.
     * @return void
     */
    public function updateAccountData(Request $request)
    {
        echo "updateAccountData";
    }

    /**
     * Sends a confirmation email with a verification code to the user.
     * The email contains the verification code and some instructions for the user.
     * 
     * @param string $email The email address to send the confirmation to.
     * @param array $token The verification code to be sent to the user, split into an array of digits.
     * @param string $username The username of the recipient.
     * @param string $subject The subject of the email.
     * @param string $subtitle The subtitle or description to include in the email.
     * @return \Illuminate\Http\RedirectResponse Returns a response based on the email sending result.
     */
    protected function sendConfirmationEmail($email, $token, $username, $subject, $subtitle)
    {
        $mail = new PHPMailer(true);

        try {
            // Mail server configuration
            $mail->SMTPDebug  = 0; // Changes to 0 in production
            $mail->isSMTP();
            $mail->Host       = config('mail.mailers.smtp.host');
            $mail->SMTPAuth   = true;
            $mail->Username   = config('mail.mailers.smtp.username');
            $mail->Password   = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = config('mail.mailers.smtp.port');

            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($email, $username);

            // Set UTF-8 encoding
            $mail->CharSet = PHPMailer::CHARSET_UTF8;

            // Mail content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>¡¡Bienvenido a Hello World!!</title>
                <style>
                    body {
                        font-family: Arial;
                        margin: 0;
                        padding: 0;
                        background-color: #f5f5f5;
                    }
                    #functions {
                        color: #F8F8F2;
                    }
                    #operators {
                        color: #F92672;
                    }
                    #string {
                        color: #E6D564;
                    }
                    .container {
                        width: 80%;
                        max-width: 600px;
                        margin: auto;
                        background-color: #ffffff;
                        border: 1px solid #dddddd;
                        border-radius: 10px;
                    }
                    .header {
                        background: linear-gradient(-0.35turn, #5F58FF, #D438BD);
                        background: #14141E;
                        padding: 20px;
                        text-align: center;
                        color: white;
                        border-radius: 10px 10px 0 0;
                    }
                    .header img {
                        width: 100px;
                        height: auto;
                        filter: drop-shadow(0 2px 5px rgba(50, 50, 100, 0.5)); 
                        margin: 10px 0;
                    }
                    .header h2 {
                        margin: 0;
                        font-size: 30px;
                    }
                    .header p {
                        font-size: 20px;
                    }
                    .body-section {
                        text-align: center;
                        background: #ffffff;
                        padding: 20px;
                    }
                    .body-section p {
                        margin: 0 0 15px 0;
                    }
                    .verification-container {
                        display: inline-flex;
                        margin-bottom: 30px;
                    }
                    .verification-code {
                        
                        
                        margin: 0 5px;
                        
                        font-size: 40px;
                        font-weight: bold;
                        text-align: center;
                    
                        border: solid 3px transparent;
                        border-radius: 10px;
                        background-image: linear-gradient(#fff, #fff), linear-gradient(to bottom, #5F58FF, #D438BD);
                        background-origin: border-box;
                        background-clip: content-box, border-box;
                    }
                    .verification-code p {
                        padding: 15px 25px 5px 25px;
                    }
                    .footer {
                        background-color: #0D0D11;
                        color: white;
                        padding: 20px;
                        text-align: center;
                        border-radius: 0 0 10px 10px;
                    }
                    .row-social {
                        display: inline-flex;
                    }
                    .button-3 img {
                        width: 70px;
                        height: 70px;
                        margin: 0 7px;
                    }
                    @media (max-width: 600px) {
                        .container {
                            width: 100%;
                            border: none;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <!-- Encabezado -->
                    <header class="header">
                        <img src="' . config('app.assets') . '/Hello-World-Logo.png" alt="Hello-World logo">
                        <h2 style="font-weight: 600;"><span id="functions">cout</span> <span id="operators"><<</span> <span id="string">"¡Hello ' . $username . '!"</span>;</h2>
                        <p>' . $subtitle . '</p>
                    </header>
                    <!-- Cuerpo del mensaje -->
                    <section class="body-section">
                        <h2>Este es tu código para Hello World:</h2>
                        <div class="verification-container">
                            <div class="verification-code"><p>' . $token[0] . '</p></div>
                            <div class="verification-code"><p>' . $token[1] . '</p></div>
                            <div class="verification-code"><p>' . $token[2] . '</p></div>
                            <div class="verification-code"><p>' . $token[3] . '</p></div>
                            <div class="verification-code"><p>' . $token[4] . '</p></div>
                        </div>
                        <h3>Si este no fuiste tú</h3>
                        <p>Este email se generó debido a un intento de registro en la plataforma Hello World. Ignorar este correo electrónico de ser el caso.</p>
                    </section>
                    <!-- Pie de página -->
                    <section class="footer">
                        <div class="footer-column">
                            <h3>Ponte en contacto con nosotros a través de las redes sociales.</h3>
                            <div class="row-social">
                                <a class="button-3" style="margin: 20px 0;" href="' . config('app.social.facebook') . '" target="_blank"><img src="' . config('app.assets') . '/btn-facebook.png" alt="Facebook"></a>
                                <a class="button-3" style="margin: 20px 0;" href="' . config('app.social.instagram') . '" target="_blank"><img src="' . config('app.assets') . '/btn-instagram.png" alt="Instagram"></a>
                                <a class="button-3" style="margin: 20px 0;" href="' . config('app.social.twitter') . '" target="_blank"><img src="' . config('app.assets') . '/btn-twitter.png" alt="Twitter"></a>
                                <a class="button-3" style="margin: 20px 0;" href="' . config('app.social.youtube') . '" target="_blank"><img src="' . config('app.assets') . '/btn-youtube.png" alt="Youtube"></a>
                                <a class="button-3" style="margin: 20px 0;" href="' . config('app.social.patreon') . '" target="_blank"><img src="' . config('app.assets') . '/btn-patreon.png" alt="Patreon"></a>
                            </div>
                        </div>
                    </section>
                </div>
            </body>
            </html>';

            $mail->send();
            return back()->with("success", "El correo electrónico ha sido enviado.");
        } catch (Exception $e) {
            // Handle mail sending error
            report($e);
            return redirect()->back()->with('error', 'No se pudo enviar el correo de confirmación a (' . $email . '): ' . $e->getMessage());
        }
    }

    /**
     * Resends a verification or recovery code based on the user's request.
     * It generates a new token, updates the timestamp, and sends the token to the user via email.
     * 
     * @param Request $request The incoming request with details about the action (either "recovery" or "verify").
     * @return \Illuminate\Http\RedirectResponse Redirects to the appropriate route with a success message.
     */
    public function resendCode(Request $request)
    {
        // Check if the request is for recovery or verification
        if ($request->input_request === "recovery") {
            // Retrieve the user's token for recovery based on the extended token
            $verification = UserToken::where('extenced_token', $request->extenced_token)->firstOrFail();
            $rq = "recuperación";
        } else if ($request->input_request === "verify") {
            // Retrieve the user's token for verification based on the extended token
            $verification = UserToken::where('extenced_token', $request->extenced_token)->firstOrFail();
            $rq = "Verificación";
        }
        
        // Generate a new 5-digit token randomly
        $token_array = array_map(function () {
            return random_int(0, 9);
        }, range(1, 5));
        $token = implode('', $token_array);

        // Update the user's token and timestamp in the database
        $verification->token        = $token;
        $verification->last_sent_at = Carbon::now();
        $verification->save();

        // Set the subject and subtitle for the confirmation email
        $subject = "Reenvio de código de $rq";
        $subtitle = "Este es tu nuevo código de $rq, copialo y pegalo en el formulario de $rq.";

        // Send the confirmation email with the new token
        $this->sendConfirmationEmail($verification->user->email, $token_array, $verification->user->username, $subject, $subtitle);

        // Store the extended token in the session and redirect to the appropriate page
        if ($request->input_request === "recovery") {
            Session::put('verification_token', $verification->extenced_token);
            return redirect()->route('auth.recovery-token', ['resend' => true])->with('success', 'Se ha enviado un nuevo código de recuperación de contraseña a su correo electrónico.');
        } else if ($request->input_request === "verify") {
            Session::put('verification_token', $verification->extenced_token);
            return redirect()->route('auth.verify-email')->with('success', 'Se ha enviado un nuevo código de verificación a su correo electrónico.');
        }
    }

    /**
     * Checks the remaining time until a user can request a new verification code.
     * Returns the remaining time in seconds based on the last time the code was sent.
     * 
     * @param Request $request The incoming request containing the user information.
     * @return \Illuminate\Http\JsonResponse JSON response with the remaining time in seconds.
     */
    public function getResendTime(Request $request)
    {
        // Get the input values from the request
        $inputRequest = $request->input('input_request');
        $userValue = $request->input('user_value');

        // Initialize the verification variable
        $verification = null;

        // Retrieve the user's verification data based on the request type
        if ($inputRequest === "recovery") {
            $verification = UserToken::where('user_email', $userValue)->firstOrFail();
        } else if ($inputRequest === "verify") {
            $verification = UserToken::where('extenced_token', $userValue)->firstOrFail();
        }

        // If verification data is not found, return an error response
        if (!$verification) {
            return response()->json(['error' => 'Verification data not found.'], 404);
        }

        // Calculate the remaining time until the user can request a new code (1 minute cooldown)
        $remainingTime = 0;
        if ($verification->last_sent_at) {
            $currentTimestamp = time();
            $futureTimestamp = strtotime($verification->last_sent_at . " +1 minute");
            $remainingTime = $futureTimestamp - $currentTimestamp;
        }

        // Return the remaining time in seconds, ensuring it's not negative
        return response()->json([
            'remainingTime' => max(0, round($remainingTime))
        ]);
    }

    /**
     * Resets the session and redirects the user to the signup page.
     * This is typically used for logging out or clearing session data.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects the user to the signup page.
     */
    public function resetForm()
    {
        // Clear all session data
        Session::flush();
        // Redirect the user to the signup page
        return redirect()->route('auth.sing-up');
    }
}
