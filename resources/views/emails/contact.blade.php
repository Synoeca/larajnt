<x-mail::message>
# Contact from {{$name}}

# Subject: {{$title}}

{{$content}}

<x-mail::button :url="'http://larajnt.test/'">
Visit us
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
