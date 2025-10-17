<style>
    .thread-email-item {
        margin-left: 20px;
        border-left: 2px solid #e9ecef;
        padding-left: 15px;
    }

    .toggle-thread-btn {
        cursor: pointer;
        color: #007bff;
    }

    .toggle-thread-btn:hover {
        text-decoration: underline;
    }

    .folder-dot {
        font-size: 1.5rem;
        margin-right: 0.2rem;
    }

    .folder-name {
        font-size: 0.675rem;
        vertical-align: super;
    }
</style>

<div id="activities-section" class="px-2">
    @if (!empty($timeline) && count($timeline) > 0)
        {{-- @include('admin.customers.contacts.timeline.static-content.email') --}}
    <!-- Loader -->

        @foreach ($timeline as $item)
            @if ($item['type'] === 'note')
                
                @include('admin.customers.contacts.timeline.partials.card-box.note')
            @elseif ($item['type'] === 'email')
                @include('admin.customers.contacts.timeline.partials.card-box.email')
            @elseif ($item['type'] === 'activity')
                @include('admin.customers.contacts.timeline.partials.card-box.activity')
            @elseif ($item['type'] === 'conversion')
                @include('admin.customers.contacts.timeline.partials.card-box.conversion')
            @endif
        @endforeach
        @else
            <p class="text-muted">No notes or emails found.</p>
        @endif
</div>

