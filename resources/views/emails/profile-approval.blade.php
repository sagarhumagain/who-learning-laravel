@component('mail::message')
<strong>Subject</strong>: {{$data['subject']}} <br>
<hr>
<strong>Message</strong>: <br>
 {{$data['message']}}
 @if($data['url'])
 @component('mail::button', ['url' => $data['url']])
   View on {{config('app.name')}}
 @endcomponent
@endif

@endcomponent
