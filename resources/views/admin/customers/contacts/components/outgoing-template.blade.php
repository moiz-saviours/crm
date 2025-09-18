<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f7; margin: 0; padding: 0; color: #333; }
        .email-wrapper { width: 100%; background-color: #f4f4f7; padding: 20px; }
        .email-content { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); overflow: hidden; }
        .email-body { padding: 20px; }
        .email-body p { margin: 15px 0; line-height: 1.6; }
        .email-footer { background-color: #f9f9f9; padding: 12px 15px; font-size: 12px; color: #777; border-top: 1px solid #eee; display: flex; align-items: center; justify-content: space-between; }
        .email-footer img { max-height: 28px; }
        .email-footer .footer-text { text-align: right; }
        .email-footer a { color: #0052cc; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="email-body">
                <h2>{{ $subject }}</h2>
                <p><strong>From:</strong> {{ $fromName }} &lt;{{ $fromEmail }}&gt;</p>
                <p><strong>To:</strong> {{ implode(', ', $toEmails) }}</p>
                <hr>
                {!! $content !!}
            </div>
            <div class="email-footer">
                <div class="footer-logo">
                    <img src="https://saviours.co/wp-content/uploads/2020/12/logo-landscape.png" alt="{{ config('app.name', 'Company Logo') }}">
                </div>
                <div class="footer-text">
                    &copy; {{ date('Y') }} <strong>{{ config('app.name', 'Your Company') }}</strong><br>
                    <a href="{{ config('app.url') }}">{{ config('app.url') }}</a> | 
                    <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>
                </div>
            </div>
        </div>
    </div>
<img src="{{ route('emails.track.open', ['id' => $emailId]) }}"
     width="1"
     height="1"
     alt=""
     style="display:none;" />
    {{-- <img src="https://e72648fff86e.ngrok-free.app/emails/open/{{ $emailId }}?token={{ hash_hmac('sha256', $emailId . now()->startOfMinute(), config('app.key')) }}"
         width="1"
         height="1"
         alt=""
         style="display:none;" /> --}}

</body>
</html>