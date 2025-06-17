@component('mail::message')
@php
    $logoUrl = $message->embed(public_path('assets/img/favicon.png'));
@endphp

<div style="text-align: center; margin: 0 0 25px 0;">
    <img src="{{ $logoUrl }}" alt="{{ config('app.name') }}" width="50" style="height: auto;">
</div>

<h1 style="text-align: center; color: #111827; font-size: 20px; font-weight: 600; margin: 0 0 20px 0;">Two-Factor Authentication Required</h1>

<p style="font-size: 14px; line-height: 1.5; color: #4b5563; margin: 0 0 16px 0;">Hello {{ $user->name }},</p>

<p style="font-size: 14px; line-height: 1.5; color: #4b5563; margin: 0 0 12px 0;">Please use the following verification code to complete your login:</p>

@component('mail::panel')
    <div style="text-align: center; font-family: monospace; font-size: 24px; font-weight: 700; letter-spacing: 4px; color: #111827; padding: 12px 0;">{{ $code }}</div>
@endcomponent

<div style="background-color: #f9fafb; border-radius: 6px; padding: 16px; margin: 24px 0;">
    <h2 style="font-size: 15px; font-weight: 600; color: #111827; margin: 0 0 12px 0;">Security Information</h2>
    <table style="width: 100%; font-size: 13px; color: #4b5563;">
        <tr>
            <td style="width: 120px; padding: 4px 0; vertical-align: top; font-weight: 500;">Request IP:</td>
            <td style="padding: 4px 0; font-family: monospace;">{{ $ipAddress }}</td>
        </tr>
        <tr>
            <td style="width: 120px; padding: 4px 0; vertical-align: top; font-weight: 500;">Request Time:</td>
            <td style="padding: 4px 0;">{{ $time }}</td>
        </tr>
    </table>
</div>

<div style="margin: 24px 0;">
    <h2 style="font-size: 15px; font-weight: 600; color: #111827; margin: 0 0 12px 0;">Security Notice</h2>
    <ul style="font-size: 13px; color: #4b5563; padding-left: 20px; margin: 0;">
        <li style="margin-bottom: 8px;">⏱️ <strong>Expires in 5 minutes</strong> - Single use only</li>
        <li style="margin-bottom: 8px;">🔒 <strong>Confidential</strong> - Never share this code</li>
        <li style="margin-bottom: 8px;">🛡️ <strong>No employee</strong> will ever request this code</li>
    </ul>
</div>

@component('mail::panel')
    <h3 style="font-size: 14px; font-weight: 600; color: #dc2626; margin: 0 0 8px 0;">⚠️ Unauthorized Request?</h3>
    <ol style="font-size: 13px; color: #4b5563; padding-left: 20px; margin: 0;">
        <li style="margin-bottom: 4px;">Immediately change your account password</li>
        <li style="margin-bottom: 4px;">Review recent account activity</li>
    </ol>
@endcomponent

<p style="font-size: 12px; color: #6b7280; margin: 24px 0 0 0;">
    For your security, this email was sent exclusively to {{ $user->email }}.<br>
    Do not forward or share this message.
</p>

@component('mail::subcopy')
    <p style="font-size: 11px; color: #9ca3af; margin: 0; line-height: 1.5;">
        This message contains confidential information intended only for the recipient.<br>
        © {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.<br>
        <span style="font-family: monospace; font-size: 10px;">ID: {{ Str::random(16) }}</span>
    </p>
@endcomponent
@endcomponent
