<x-mail::message>
# Introduction

Dear {{$name}},

I hope this email finds you well.

We would like to inform you that your application for new registration email was completed. Please check the attachment for the status of approval by BTM.

For your reference, please find the attached copy of your application form.

Should you need further assistance, please feel free to reach out.

Thank you for your attention and cooperation.

<x-mail::button :url="$link">
View Form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>