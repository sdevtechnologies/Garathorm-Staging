<x-mail::message>
Hello {{$user->name}},

New entry for Industry References and Best Practices has been submitted with the title and url below.

Title: {{ $industry->title }}
<x-mail::button :url="$industry->url_link">
URL Link
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
