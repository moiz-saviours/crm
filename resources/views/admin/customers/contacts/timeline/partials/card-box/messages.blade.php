@php
    $isSent = $message->sender_id == auth()->id() && $message->sender_type == get_class(auth()->user());
    $avatarText = $isSent ? 'ME' : substr($message->sender->name ?? 'U', 0, 2);
    $avatarTitle = $isSent ? 'You' : $message->sender->name ?? 'User';
@endphp

<div class="message {{ $isSent ? 'sent' : 'received' }}">
    @if (!$isSent)
        <div class="message-avatar" data-bs-toggle="tooltip" title="{{ $avatarTitle }}">
            {{ $avatarText }}
        </div>
    @endif

        @if (!empty($message->content))
            <div class="message-bubble">
                <div class="message-content">
                    {!! nl2br(e($message->content)) !!}
                </div>
                <div class="message-footer mt-1">
                    <div class="message-time small">
                        {{ $message->created_at->format('h:i A') }}
                    </div>
                </div>
            </div>
        @endif

        @if ($message->attachments && $message->attachments->count() > 0)
            <div class="message-attachments mt-2 {{ $isSent ? 'ms-auto text-end' : '' }}" style="max-width: 80%;">
                @foreach ($message->attachments as $attachment)
                    @php
                        $path = asset('storage/' . $attachment->file_path);
                        $icon = match (true) {
                            str_starts_with($attachment->file_type, 'image/') => 'fa-file-image',
                            str_starts_with($attachment->file_type, 'video/') => 'fa-file-video',
                            str_starts_with($attachment->file_type, 'audio/') => 'fa-file-audio',
                            default => 'fa-file',
                        };
                    @endphp

                    <div
                        class="attachment-bubble d-inline-flex align-items-center justify-content-between gap-2 px-3 py-2 mb-1 {{ $isSent ? 'sent-attach' : 'received-attach' }}">
                        <div class="d-flex align-items-center gap-2 text-truncate" style="max-width: 250px;">
                            <i class="fas {{ $icon }}"></i>
                            <a href="{{ $path }}" target="_blank"
                                class="text-decoration-none text-dark small text-truncate">
                                {{ $attachment->file_name }}
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <small class="text-muted">{{ formatFileSize($attachment->file_size) }}</small>
                            <a href="{{ $path }}" download="{{ $attachment->file_name }}"
                                class="text-muted ms-1" title="Download">
                                <i class="fas fa-download small"></i>
                            </a>
                        </div>
                    </div>
                @endforeach

                {{-- Timestamp --}}
                <div class="small text-muted mt-1 {{ $isSent ? 'text-end' : 'text-start' }}">
                    {{ $message->created_at->format('h:i A') }}
                </div>
            </div>
        @endif

    @if ($isSent)
        <div class="message-avatar" data-bs-toggle="tooltip" title="{{ $avatarTitle }}">
            {{ $avatarText }}
        </div>
    @endif
</div>

@php
    if (!function_exists('formatFileSize')) {
        function formatFileSize($bytes)
        {
            if ($bytes == 0) {
                return '0 Bytes';
            }
            $k = 1024;
            $sizes = ['Bytes', 'KB', 'MB', 'GB'];
            $i = floor(log($bytes) / log($k));
            return round($bytes / pow($k, $i), 1) . ' ' . $sizes[$i];
        }
    }
@endphp
