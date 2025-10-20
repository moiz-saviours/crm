@php
    $isSent = $message->sender_id == auth()->id() && $message->sender_type == get_class(auth()->user());
    $avatarText = $isSent ? 'ME' : substr($message->sender->name ?? 'U', 0, 2);
    $avatarTitle = $isSent ? 'You' : ($message->sender->name ?? 'User');
@endphp
<div class="message {{ $isSent ? 'sent' : 'received' }}">
    @if(!$isSent)
    <div class="message-avatar" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $avatarTitle }}">
        {{ $avatarText }}
    </div>
    @endif
    
    <div class="message-bubble">
        <div class="message-content">
            {{ $message->content }}
        </div>
        <div class="message-footer">
            <div class="message-time">
                {{ $message->created_at->format('h:i A') }}
            </div>
        </div>
        
        @if($message->attachments && $message->attachments->count() > 0)
        <div class="message-attachments mt-2">
            @foreach($message->attachments as $attachment)
            <div class="attachment-item small">
                <i class="fas fa-file me-1"></i>
                <span>{{ $attachment->file_name }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    
    @if($isSent)
    <div class="message-avatar" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $avatarTitle }}">
        {{ $avatarText }}
    </div>
    @endif
</div>