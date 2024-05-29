<x-mail::message>
<p style="margin: 0">Dear {{ $mailData['first_name'] }} {{ $mailData['last_name'] }},</p>
<p style="margin: 0">We have received your appointment request for {{ $mailData['service_title'] }}. Our agent will reach you shortly.</p>
<p style="margin: 0">Regards,</p>
<p>Smart Move Finance</p>

<x-mail::button :url="$url">
Visit Site
</x-mail::button>

To whom it may concern:

<p style="margin: 0">Name : {{ $mailData['first_name'] }} {{ $mailData['last_name'] }}</p>
<p style="margin: 0">Email : {{ $mailData['email'] }} </p>
<p style="margin: 0">Phone : {{ $mailData['phone'] }} </p>
<p style="margin: 0">Message : {{ $mailData['message'] }} </p>
<p style="margin: 0">Location : {{ $mailData['location'] }} </p>

</x-mail::message>
