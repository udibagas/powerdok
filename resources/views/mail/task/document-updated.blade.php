@component('mail::message')
# Document Updated

Document has been updated!

@component('mail::button', ['url' => '/'])
View Document
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
