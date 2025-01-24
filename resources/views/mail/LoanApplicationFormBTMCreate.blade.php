<x-mail::message>
# Introduction

Dear {{ $admin }},


I hope this email finds you well.

Please be informed, {{ $name }} has completed and submitted a form for a loan equipment. The completed form is attached to this email for your reference and necessary action.

Kindly review the attached form and proceed with the next steps as per your standard procedure.

Thank you for your attention to this matter.

<x-mail::button :url="$link">
View Form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
