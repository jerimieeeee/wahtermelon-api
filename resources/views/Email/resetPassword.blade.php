<x-mail::message>
# Introduction

The body of your message.


@component('mail::button', ['url' => $url.'/'.$token])
        Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
