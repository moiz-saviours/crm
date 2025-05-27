<!-- Channel Dropdown -->
<div class="dropdown">
    <!-- Toggler -->
    <button class="header__btn channels btn" type="button" id="channelDropdown" data-bs-toggle="dropdown"
            aria-label="Channel dropdown" aria-expanded="false">
        <span class="d-block position-relative">
            {{ $currentChannel }}
        </span>
    </button>

    <!-- Channel dropdown menu -->
    <div class="dropdown-menu dropdown-menu-end w-md-300px" aria-labelledby="channelDropdown">
        <div class="border-bottom px-3 py-2 mb-2">
            <h5>Channels</h5>
        </div>
        <div class="list-group list-group-borderless channel-list px-3">
            <!-- Current channel will be shown immediately -->
            <div class="list-group-item py-1">
                <span class="text-decoration-none text-primary fw-bold">
                    {{ $currentChannel }} (Current)
                </span>
            </div>
            <!-- Loading indicator for other channels -->
            <div class="list-group-item py-1 text-muted loading-channels" style="display: none;">
                Checking available channels...
            </div>
            <!-- Channels will be appended here -->
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function () {
            const storageKey = 'channelsData_{{ auth()->id() }}';
            let channelsData = JSON.parse(sessionStorage.getItem(storageKey)) || null;
            let isChecking = false;
            if (channelsData) {
                renderChannels(channelsData);
            }

            $('.header__btn.channels.btn').on('click', function () {
                const $channelList = $(this).closest('.dropdown').find('.channel-list');
                const $loadingIndicator = $channelList.find('.loading-channels');
                $channelList.children().not(':first').remove();
                if (channelsData && channelsData.timestamp > Date.now() - 300000) { // 5 minute cache
                    renderChannels(channelsData);
                    return;
                }
                if (isChecking) {
                    $loadingIndicator.show();
                    return;
                }

                // Start new check
                isChecking = true;
                $loadingIndicator.show();

                $.ajax({
                    url: '{{$channelCheckRoute}}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        channelsData = {
                            data: response.validChannels || [],
                            timestamp: Date.now()
                        };
                        sessionStorage.setItem(storageKey, JSON.stringify(channelsData));
                        renderChannels(channelsData);
                    },
                    error: function () {
                        $channelList.append('<div class="text-danger">Failed to load channels. Try again later.</div>');
                    },
                    complete: function () {
                        isChecking = false;
                        $loadingIndicator.hide();
                    }
                });
            });

            function renderChannels(data) {
                const $channelList = $('.channel-list');
                $channelList.children().not(':first').remove();

                if (!data.data || !data.data.length) {
                    $channelList.append('<div class="text-muted">No additional channels found.</div>');
                    return;
                }
                data.data.forEach((channel, index) => {
                    const listItem = `
                        <div class="list-group-item py-1" style="display:none;">
                            <a href="${channel.url}" target="_blank"
                               class="text-decoration-none text-primary fw-bold">
                                ${channel.name}
                            </a>
                        </div>`;
                    const $item = $(listItem);
                    $channelList.append($item);
                    $item.fadeIn(150 * (index + 1));
                });
            }
        });
    </script>
@endpush
