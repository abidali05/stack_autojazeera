
<p>Dear {{ $dealerName }},</p>
<p>You have a new contact inquiry from {{ $dealerContact->full_name }}.</p>
<p>Details:</p>
<ul>
    <li>Email: {{ $dealerContact->email }}</li>
    <li>Contact Number:
		@php
            $formattedNumber = isset($dealerContact->contact_num) 
                ? preg_replace('/^\+92(\d{3})(\d{7})$/', '+92 $1 $2', $dealerContact->contact_num) 
                : '';
        @endphp
        {{ $formattedNumber }}
	</li>
    <li>Message: {{ $dealerContact->message }}</li>
</ul>

