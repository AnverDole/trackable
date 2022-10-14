
@component('mail::message')

<h1 style="color:#0d6efd">Forgot Password</h1>

Hi {{ $firstname }}, You are receiving this email because we received a password reset request for your account
associated with {{ $email }}.

Please click bellow button.

@component('mail::button', ['url' => route('auth.forgot-password.change', ['token' => $token, 'email' => $email])])
    Reset Password
@endcomponent


If you did not request a password reset, no further action is required

Regards,<br>
Team {{ config('app.name') }}.

@endcomponent

