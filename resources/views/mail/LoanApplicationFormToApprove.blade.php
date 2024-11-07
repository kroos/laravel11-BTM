<x-mail::message>
# Introduction

Dear {{ $apprv }},

This is to inform you that {{ $name }}, from your department, has submitted a request to borrow equipment from the BTM, UniSHAMS. The details of the application are available in the system for your review.

Please find the attached PDF form for your reference. Kindly log into the system to assess the request and provide your approval or rejection based on your discretion. You have the authority to approve or decline this application as you see fit.

If you have any questions or require further information regarding the request, feel free to reach out.

Thank you for your attention to this matter.

<x-mail::button :url="$link">
View Form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
