@component('mail::message')
<strong>Subject</strong>: {{$data['subject']}} <br>
<hr>
<strong>Message</strong>: <br>
 {{$data['message']}}
@endcomponent
