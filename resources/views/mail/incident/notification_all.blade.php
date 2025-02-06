<x-mail::message>
Hello {{$user->name}},

New entry for Incidents and Announcements has been submitted with the title and url below.

Title: {{ $incident->title }}
<x-mail::button :url="$incident->url_link">
URL Link
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
