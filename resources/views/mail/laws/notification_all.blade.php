<x-mail::message>
Hello {{$user->name}},

New entry for Laws and Frameworks has been submitted with the title and url below.

Title: {{ $law->title }}
<x-mail::button :url="$law->url_link">
URL Link
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
