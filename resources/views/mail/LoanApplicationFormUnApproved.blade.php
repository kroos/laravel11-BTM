<x-mail::message>
# Introduction

Dear {{$name}},

I hope this email finds you well.

Thank you for submitting your equipment loan request with BTM, UniSHAMS. We regret to inform you that your application has not been approved by your Approval Officer.

For further details regarding this decision or any questions, please feel free to reach out directly to your Approval Officer. You may also contact BTM if additional assistance is required.

Thank you for your understanding.

<x-mail::button :url="$link">
View Form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
