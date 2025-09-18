                @if(empty($emails) || count($emails) === 0)
                    <p class="text-muted">No emails found.</p>
                @else
                    @foreach($emails['emails'] as $email)
                        <div class="email-box-container" style="margin: 0; border-radius: 0; margin-top: 15px;">
                            
                            {{-- Header --}}
                            <div class="toggle-btnss" data-target=".{{ $email['uuid'] }}">
                                <div class="activ_head">
                                    <div class="email-child-wrapper">
                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                        <div>
                                            <h2>
                                                {{ $email['from'][0]['name'] ?? 'Unknown Sender' }} 
                                                - {{ $email['subject'] ?? '(No Subject)' }}
                                            </h2>
                                            <p class="user_cont">from: {{ $email['from'][0]['email'] ?? 'Unknown' }}</p>
                                            <p class="user_cont">to: {{ $email['to'][0]['email'] ?? 'Unknown' }}</p>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <p>
                                            {{ !empty($email['date']) 
                                                ? \Carbon\Carbon::parse($email['date'])->format('M d, Y h:i A') 
                                                : 'Unknown Date' }}
                                        </p>
                                        @if(!empty($email['attachments']) && count($email['attachments']) > 0)
                                            <p class="attachment-count" style="font-size: 12px; color: #666; margin: 2px 0;">
                                                <i class="fa fa-paperclip" aria-hidden="true"></i>
                                                {{ count($email['attachments']) }} 
                                                attachment{{ count($email['attachments']) > 1 ? 's' : '' }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Body --}}
                            <div  class="contentdisplaytwo {{ $email['uuid'] }}" style="display: none;">
                                <div class="user_cont user-email-template">

                                    {{-- Email Body --}}
                                    <div class="email-preview">
                                        {!! $email['body']['html'] ?? nl2br($email['body']['text'] ?? '') !!}
                                    </div>

                                    {{-- Attachments --}}
                                    @if(!empty($email['attachments']) && count($email['attachments']) > 0)
                                        <div class="attachments-section" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                                            <h4 style="margin-bottom: 10px; color: #333;">
                                                <i class="fa fa-paperclip" aria-hidden="true"></i>
                                                Attachments ({{ count($email['attachments']) }})
                                            </h4>
                                            <div class="attachments-list">
                                                @foreach($email['attachments'] as $attachment)
                                                    <div class="attachment-item" style="display: flex; align-items: center; padding: 8px 12px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; margin-bottom: 8px;">
                                                        @php
                    $type = strtolower($attachment['type'] ?? '');
                    $icon = 'fa-file-o';
                    if (str_contains($type, 'pdf')) $icon = 'fa-file-pdf-o';
                    elseif (str_contains($type, 'word')) $icon = 'fa-file-word-o';
                    elseif (str_contains($type, 'excel')) $icon = 'fa-file-excel-o';
                    elseif (str_contains($type, 'powerpoint')) $icon = 'fa-file-powerpoint-o';
                    elseif (str_contains($type, 'image')) $icon = 'fa-file-image-o';
                    elseif (str_contains($type, 'text')) $icon = 'fa-file-text-o';
                    elseif (str_contains($type, 'zip') || str_contains($type, 'rar') || str_contains($type, '7z')) $icon = 'fa-file-archive-o';
                @endphp
                                                        <div class="attachment-icon" style="margin-right: 10px; font-size: 16px; color: #6c757d;">
                                                            <i class="fa {{ $icon }}" aria-hidden="true"></i>
                                                        </div>

                                                        <div class="attachment-info" style="flex: 1;">
                                                            <div class="attachment-name" style="font-weight: 500; color: #212529;">
                                                                {{ $attachment['filename'] ?? 'Unknown File' }}
                                                            </div>
                                                            <div class="attachment-details" style="font-size: 12px; color: #6c757d;">
                                                                Type: {{ strtoupper($attachment['type'] ?? 'unknown') }}
                                                                @if(!empty($attachment['size']))
                                                                    | Size: {{ number_format($attachment['size']/1024, 1) }} KB
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="attachment-actions">
                                                            @if(!empty($attachment['download_url']))
                                                                <a href="{{ $attachment['download_url'] }}"
                                                                download="{{ $attachment['filename'] ?? 'attachment' }}"
                                                                class="btn btn-sm btn-outline-primary"
                                                                style="text-decoration: none; padding: 4px 8px; border: 1px solid #007bff; color: #007bff; border-radius: 3px; font-size: 12px;">
                                                                    <i class="fa fa-download" aria-hidden="true"></i> Download
                                                                </a>
                                                            @else
                                                                <span class="text-muted" style="font-size: 12px;">
                                                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> No download link
                                                                </span>
                                                            @endif
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif