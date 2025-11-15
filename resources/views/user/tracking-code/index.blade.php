@extends('user.layouts.app')
@section('title','Tracking Code')

@section('content')
@push('style')
    <style>
        .trck_head {
            color: var(--bs-primary);
            font-size: 1.5rem;
        }
        .scrpt_area {
            color: var(--bs-primary);
            text-align: left;
            line-height: 25px;
            font-family: monospace !important;
            font-size: 15px;
            border: 1px solid #c5c5c5;
            border-radius: 8px;
            letter-spacing: 1px;
        }
    </style>
@endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Tracking Code Installation <i class="fa fa-caret-down"></i></h1>
                    </div>
                </header>
            </div>
        </div>

        <div class="content__boxed">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="mb-4 mt-4">
                        <h3 class=" mt-5"><strong class="trck_head">Embed Code</strong></h3>
                        <p>
                            Copy and paste this tracking code into every page of your site, just before the
                            <code>&lt;/body&gt;</code> tag.
                        </p>
                    </div>

                    <div class="position-relative">
                    <pre id="tracking-code" class="scrpt_area p-3 bg-light" style="white-space: pre-wrap; word-wrap: break-word; user-select: all;">
&lt;!-- Start Of CRM Embed Code --&gt;
&lt;script src="{{ url('assets/js/wl-script.js') }}"&gt;&lt;/script&gt;
&lt;script src="{{ url('assets/js/user-activity.js') }}"&gt;&lt;/script&gt;
&lt;!-- End Of CRM Embed Code --&gt;
                    </pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            const preBox = document.getElementById('tracking-code');

            // user clicks anywhere in the pre box
            preBox.addEventListener('click', () => {
                const selection = window.getSelection();
                selection.removeAllRanges(); // clear previous selection
                const range = document.createRange();
                range.selectNodeContents(preBox); // select all content
                selection.addRange(range);
            });
        </script>
    @endpush

@endsection
