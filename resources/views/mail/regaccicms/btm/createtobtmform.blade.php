<x-mail::message>
# Introduction

Dear {{ $admin }},

I hope this email finds you well.

Please be informed, {{ $name }} has completed and submitted a form request for **Pendaftaran Akaun & Modul ICMS**. The completed form is attached to this email for your reference and has been processed.

Thank you for your attention to this matter.

<x-mail::button :url="$link">
View Form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
