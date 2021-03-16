@component('mail::message')
# Task Approved !

Your task has been approved!

@component('mail::button', ['url' => '/'])
View Task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
