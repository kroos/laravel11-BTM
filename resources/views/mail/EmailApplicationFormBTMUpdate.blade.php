<x-mail::message>
# Introduction

Dear {{ $admin }},


I hope this email finds you well.

Please be informed that a user has updated the information and submitted a form for a new email account registration. The completed form is attached to this email for your reference and necessary action.

User Details:

    Name: {{ $name }}

Kindly review the attached form and proceed with the next steps as per your standard procedure. Please let me know if you require any additional information.

Thank you for your attention to this matter.

<x-mail::button :url="$link">
View Form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
