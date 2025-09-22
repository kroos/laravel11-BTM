<x-mail::message>
# BTMgo

Dear {{$name}},

We hope this email finds you well.

We would like to inform that your application is currently been given approval by your Superior.

For your reference, please find the attached copy of your application form.

Should you need further assistance, please feel free to reach out Bahagian Teknologi Maklumat, UniSHAMS.

Thank you for your attention.

<x-mail::button :url="$link">
View Form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
