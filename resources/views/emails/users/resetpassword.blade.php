@component('mail::message')
# Permintaan Reset Password

Hai, {{ $user }}<br>
Kami telah menerima permintaan Anda untuk mereset password {{ config('app.name') }}. Silakan klik tombol di bawah ini untuk mereset password Anda.

@component('mail::button', ['url' => route('show.reset.password', ['token' => $token, 'email' => $email]), 'color' => 'default button-wide'])
Reset Password
@endcomponent

<i>Link reset password akan kadaluarsa dalam {{ config('app.pass_expired')/60 }} menit</i><br>

Abaikan email ini jika Anda tidak pernah meminta untuk mereset password.<br>

<br>
- Tim {{ config('app.name') }}
@endcomponent
