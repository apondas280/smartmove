<x-mail::message>
<p style="margin: 0">Dear Smart Move Financial,</p>
<p style="margin: 0">Here is my message for you:</p>
<p>{{ $mailData['message'] }}</p>
<p style="margin: 0">Regards,</p>
<p style="margin: 0">{{ $mailData['name'] }}</p>
<p style="margin: 0">{{ $mailData['email'] }}</p>
<p style="margin: 0">{{ $mailData['phone'] }}</p>
<p>{{ $mailData['address'] }}</p>

<x-mail::button :url="$url">
Visit Site
</x-mail::button>

</x-mail::message>
