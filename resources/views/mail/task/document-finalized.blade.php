@component('mail::message')
# Document Finalized

Document has been finalized!

@component('mail::button', ['url' => '/'])
View Document
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
