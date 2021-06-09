@component('mail::message')
# OTP

Your OTP Code!

@component('mail::panel')
{{ route('otp', $user->otp) }}
{{ $user->otp }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent