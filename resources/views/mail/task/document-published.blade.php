@component('mail::message')
# Document Published

Document has been published!

@component('mail::button', ['url' => '/'])
View Invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
