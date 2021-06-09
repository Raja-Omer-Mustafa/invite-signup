@component('mail::message')
# Invitation Link

Your Invitation link!

@component('mail::button', ['url' => route('invitation.process', $invite->token)])
Click to Register
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent