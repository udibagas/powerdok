@component('mail::message')
# Approval Completed

Approval has been completed!

@component('mail::button', ['url' => '/'])
View Task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
