<x-mail::message>
# BTMgo
# Action Required – ICMS Account & Module Registration Request

Dear {{ $apprv }},

We would like to inform you that a request for **Pendaftaran Akaun & Modul ICMS** has been submitted by a member of your department ({{ $name }}) to the **Bahagian Teknologi Maklumat (BTM), UniSHAMS**.

The application details are available in the system for your review, and a PDF copy of the form has been attached for your reference.

Kindly log in to the system to review the request and provide your decision to either approve or decline, based on your discretion.

If you need any further information or assistance, please feel free to reach out to us.

Thank you for your time and prompt attention to this matter.

Best regards,


<x-mail::button :url="$link">
View Form
</x-mail::button>

Best regards,<br>
**Bahagian Teknologi Maklumat (BTM)**
**UniSHAMS**
{{ config('app.name') }}
</x-mail::message>
