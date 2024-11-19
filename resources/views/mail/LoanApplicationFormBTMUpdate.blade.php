<x-mail::message>
# Introduction

Dear {{$name}},


We would like to inform you that your application for equipment loan from the BTM was successfully update.

For your reference, please find the attached copy of your application form.

Should you need further assistance, please feel free to reach out.

Thank you for your attention and cooperation.

<x-mail::button :url="$link">
View Form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
