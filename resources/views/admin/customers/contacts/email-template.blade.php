@push('style')
    <style>

        .email-template {
            display: none;
        }

        .email-template.open {
            display: block;
            position: fixed;
            justify-content: end;
            /*position: absolute;*/
            bottom: 0;
            right: 50px;
            z-index: 10026;
            width: 47%;
            background-color: #fff;

        }

        .email-template input[type="text"]:focus, .email-child-wrapper tags.tagify:focus-within {
            outline-offset: calc(-2px);
            border-color: transparent !important;
            outline: rgb(0, 164, 189) solid 2px !important;
            box-shadow: rgb(255, 255, 255) 0px 0px 0px 2px inset !important;
            border-radius: 3px;
        }

        .email-template input[type="text"], .email-child-wrapper tags.tagify {
            padding: .3em .5em
        }


        .email-header-main-wrapper {
            color: #fff;
            display: flex;
            justify-content: space-between;
            padding: 10px 30px;
            background-color: var(--bs-primary);
            cursor: move;
        }

        .email-child-wrapper-one {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .email-child-wrapper-one i {
            height: 20px;
            width: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .email-child-wrapper {
            display: flex;
            align-items: baseline;
            gap: 12px;
            background-color: #fff;
        }

        .email-child-wrapper input, .email-child-wrapper tags.tagify {
            width: 90%;
            border: none;
        }

        .email-child-wrapper input:focus-visible, .email-child-wrapper tags.tagify:focus-within {
            outline: none;
        }


        .email-titles {
            font-weight: 500;
            margin: 0;
        }

        .email-titles-hide {
            color: #ccc;
            font-weight: 500;
            margin: 0;
        }

        .email-titles-show {
            color: var(--bs-primary);
            font-weight: 600;
            margin: 0px;
        }

        .icon-display-email-box {
            color: #ccc;
            font-size: 12px;
        }

        .email-divider {
            background-color: #ddd;
            height: 1px;
        }

        .email-sending-titles {
            font-weight: 700;
            margin: 0;
            color: var(--bs-primary);
            min-width: 6%;
        }

        .email-sender-box {
            padding: 12px 0px;
            margin: 0;
            background-color: #eaf0f6;
            border-color: #cbd6e2;
            /* color: #506e91; */
            font-size: 12px;
            font-weight: 400;
            padding: 4px 17px;
            border-radius: 3px;
            border-style: solid;
            border-width: 1px;
        }

        .email-sender-box-icon {
            color: gray;
            font-size: 10px;
            padding-left: 7px;
        }

        .email-sending-box {
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            padding: 5px 20px;
            min-height: 40px;
        }


        .main-content-email-box {
            background-color: #fff;
            padding: 0px;
            text-align: center;

        }

        .main-content-email-box textarea {
            width: 100%;
            border: none;
            border-radius: 5px;
            margin: 0;
            resize: vertical;
            padding: 0 30px;
        }

        .main-content-email-box textarea:focus-visible {
            outline: none;
        }

        .main-content-email-text {
            color: #000;
            text-align: center;
            font-size: 15px;
        }

        .main-content-email-para {
            margin: 0;
            color: gray;
            padding: 20px 0px;
        }

        .connect-to-inbox-btn {
            background-color: var(--bs-primary);
            border: none;
            color: #fff;
            font-size: 13px;
            font-weight: 400;
            padding: 7px 16px;
            border-radius: 0px;
            font-weight: 600;
            border-radius: 4px;
        }

        .email-footer-div {
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            padding: 10px 20px;
        }

        .email-footer-btn {
            background-color: #fff;
            border: 1px solid var(--bs-primary);
            color: var(--bs-primary);
            font-size: 12px;
            font-weight: 400;
            padding: 3px 17px;
            border-radius: 0px;
            border-radius: 4px;
        }

        .email-sender-name {
            margin: 0;
            color: #33475b;
        }

        .email-sender-emailid {
            color: var(--bs-primary);
            font-weight: 500;
        }

        .email-warning-icon {
            color: #f5c26b;
            padding-left: 9px;
            font-size: 12px;
        }

        .email-titles-dropdown {
            color: var(--bs-primary);
            font-weight: 600;
            margin: 0px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .email-titles-dropdown:hover {
            text-decoration: underline;
        }

        .email-titles-dropdown-menu.show {
            width: 45%;
            width: 22%;
            /* transform: translate3d(240px, 100px, 0px); */
            transform: translate(210px, 100px) !important;
            padding: 21px 40px;
            border-radius: 0;
        }

        .dropdown-img {
            width: 238px;
        }

        .get-started-icon {
            padding-left: 8px;
        }

        .quotes-titles-dropdown-menu.show {
            width: 45%;
            width: 18%;
            /* transform: translate3d(240px, 100px, 0px); */
            transform: translate(316px, 100px) !important;
            padding: 0;
            border-radius: 0;
        }

        .quotes-header-box {
            padding: 21px 32px;

        }

        .quotes-content-para {
            color: #6c757da1;
        }

        .quotes-titles-link {
            color: var(--bs-primary);
            font-weight: 600;
            margin: 0px;

        }

        .quotes-titles-link:hover {
            color: var(--bs-primary);
        }

        tags.tagify.email-sender-name * {
            margin: 1px;
        }

        .tagify__tag {
            background-color: var(--tag-bg);
        }

        .tagify__tag:hover {
            background-color: var(--tag-hover);
        }

        tags.tagify.email-sender-name {
            max-height: 70px;
            overflow: auto;
        }


        .email-child-wrapper input {
            padding: 100px;
            transition: all 0.3s ease;
        }

        .email-child-wrapper input:focus {
            padding: 10px 15px;
            outline: none;
            border-color: #4a90e2;
        }

        .email-template-body {
            max-height: 543px;
            overflow: auto;
        }

        @charset "UTF-8";
        :root {
            --tagify-dd-color-primary: rgb(53, 149, 246);
            --tagify-dd-text-color: black;
            --tagify-dd-bg-color: white;
            --tagify-dd-item-pad: .3em .5em;
            --tagify-dd-max-height: 300px
        }

        .tagify {
            --tags-disabled-bg: #F1F1F1;
            --tags-border-color: #DDD;
            --tags-hover-border-color: #CCC;
            --tags-focus-border-color: #3595f6;
            --tag-border-radius: 3px;
            --tag-bg: #E5E5E5;
            --tag-hover: #D3E2E2;
            --tag-text-color: black;
            --tag-text-color--edit: black;
            --tag-pad: .3em .5em;
            --tag-inset-shadow-size: 1.2em;
            --tag-invalid-color: #D39494;
            --tag-invalid-bg: rgba(211, 148, 148, .5);
            --tag--min-width: 1ch;
            --tag--max-width: 100%;
            --tag-hide-transition: .3s;
            --tag-remove-bg: rgba(211, 148, 148, .3);
            --tag-remove-btn-color: black;
            --tag-remove-btn-bg: none;
            --tag-remove-btn-bg--hover: #c77777;
            --input-color: inherit;
            --placeholder-color: rgba(0, 0, 0, .4);
            --placeholder-color-focus: rgba(0, 0, 0, .25);
            --loader-size: .8em;
            --readonly-striped: 1;
            display: inline-flex;
            align-items: flex-start;
            align-content: baseline;
            flex-wrap: wrap;
            border: 1px solid var(--tags-border-color);
            padding: 0;
            line-height: 0;
            outline: 0;
            position: relative;
            box-sizing: border-box;
            transition: .1s
        }

        @keyframes tags--bump {
            30% {
                transform: scale(1.2)
            }
        }

        @keyframes rotateLoader {
            to {
                transform: rotate(1turn)
            }
        }

        .tagify:has([contenteditable=true]) {
            cursor: text
        }

        .tagify:hover:not(.tagify--focus):not(.tagify--invalid) {
            --tags-border-color: var(--tags-hover-border-color)
        }

        .tagify[disabled] {
            background: var(--tags-disabled-bg);
            filter: saturate(0);
            opacity: .5;
            pointer-events: none
        }

        .tagify[disabled].tagify--empty > .tagify__input:before {
            position: relative
        }

        .tagify[disabled].tagify--select, .tagify[readonly].tagify--select {
            pointer-events: none
        }

        .tagify[disabled]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty), .tagify[readonly]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty) {
            cursor: default
        }

        .tagify[disabled]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty) > .tagify__input, .tagify[readonly]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty) > .tagify__input {
            visibility: hidden;
            width: 0;
            margin: 5px 0
        }

        .tagify[disabled]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty) .tagify__tag > div, .tagify[readonly]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty) .tagify__tag > div {
            padding: var(--tag-pad)
        }

        .tagify[disabled]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty) .tagify__tag > div:before, .tagify[readonly]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty) .tagify__tag > div:before {
            animation: readonlyStyles 1s calc(-1s * (var(--readonly-striped) - 1)) paused
        }

        .tagify[disabled] .tagify__tag__removeBtn, .tagify[readonly] .tagify__tag__removeBtn {
            display: none
        }

        .tagify--loading .tagify__input > br:last-child {
            display: none
        }

        .tagify--loading .tagify__input:before {
            content: none
        }

        .tagify--loading .tagify__input:after {
            vertical-align: middle;
            opacity: 1;
            width: .7em;
            height: .7em;
            width: var(--loader-size);
            height: var(--loader-size);
            min-width: 0;
            border: 3px solid;
            border-color: #eee #bbb #888 transparent;
            border-radius: 50%;
            animation: rotateLoader .4s infinite linear;
            content: "" !important;
            margin: -2px 0 -2px .5em
        }

        .tagify--loading .tagify__input:empty:after {
            margin-left: 0
        }

        .tagify + input, .tagify + textarea {
            position: absolute !important;
            left: -9999em !important;
            transform: scale(0) !important
        }

        .tagify__tag {
            display: inline-flex;
            align-items: center;
            max-width: var(--tag--max-width);
            margin-inline: 5px 0;
            margin-block: 5px;
            position: relative;
            z-index: 1;
            outline: 0;
            line-height: normal;
            cursor: default;
            transition: .13s ease-out
        }

        .tagify__tag > div {
            display: flex;
            flex: 1;
            vertical-align: top;
            box-sizing: border-box;
            max-width: 100%;
            padding: var(--tag-pad);
            color: var(--tag-text-color);
            line-height: inherit;
            border-radius: var(--tag-border-radius);
            white-space: nowrap;
            transition: .13s ease-out
        }

        .tagify__tag > div > * {
            white-space: pre-wrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            vertical-align: top;
            min-width: var(--tag--min-width);
            max-width: var(--tag--max-width);
            transition: .8s ease, .1s color
        }

        .tagify__tag > div > [contenteditable] {
            display: block;
            outline: 0;
            -webkit-user-select: text;
            user-select: text;
            cursor: text;
            margin: -2px;
            padding: 2px;
            max-width: 350px
        }

        .tagify__tag > div > :only-child {
            width: 100%
        }

        .tagify__tag > div:before {
            content: "";
            position: absolute;
            border-radius: inherit;
            inset: var(--tag-bg-inset, 0);
            z-index: -1;
            pointer-events: none;
            transition: .12s ease;
            animation: tags--bump .3s ease-out 1;
            box-shadow: 0 0 0 var(--tag-inset-shadow-size) var(--tag-bg) inset
        }

        .tagify__tag:focus div:before, .tagify__tag:hover:not([readonly]) div:before {
            --tag-bg-inset: -2.5px;
            --tag-bg: var(--tag-hover)
        }

        .tagify__tag--loading {
            pointer-events: none
        }

        .tagify__tag--loading .tagify__tag__removeBtn {
            display: none
        }

        .tagify__tag--loading:after {
            --loader-size: .4em;
            content: "";
            vertical-align: middle;
            opacity: 1;
            width: .7em;
            height: .7em;
            width: var(--loader-size);
            height: var(--loader-size);
            min-width: 0;
            border: 3px solid;
            border-color: #eee #bbb #888 transparent;
            border-radius: 50%;
            animation: rotateLoader .4s infinite linear;
            margin: 0 .5em 0 -.1em
        }

        .tagify__tag--flash div:before {
            animation: none
        }

        .tagify__tag--hide {
            width: 0 !important;
            padding-left: 0;
            padding-right: 0;
            margin-left: 0;
            margin-right: 0;
            opacity: 0;
            transform: scale(0);
            transition: var(--tag-hide-transition);
            pointer-events: none
        }

        .tagify__tag--hide > div > * {
            white-space: nowrap
        }

        .tagify__tag.tagify--noAnim > div:before {
            animation: none
        }

        .tagify__tag.tagify--notAllowed:not(.tagify__tag--editable) div > span {
            opacity: .5
        }

        .tagify__tag.tagify--notAllowed:not(.tagify__tag--editable) div:before {
            --tag-bg: var(--tag-invalid-bg);
            transition: .2s
        }

        .tagify__tag[readonly] .tagify__tag__removeBtn {
            display: none
        }

        .tagify__tag[readonly] > div:before {
            animation: readonlyStyles 1s calc(-1s * (var(--readonly-striped) - 1)) paused
        }

        @keyframes readonlyStyles {
            0% {
                background: linear-gradient(45deg, var(--tag-bg) 25%, transparent 25%, transparent 50%, var(--tag-bg) 50%, var(--tag-bg) 75%, transparent 75%, transparent) 0/5px 5px;
                box-shadow: none;
                filter: brightness(.95)
            }
        }

        .tagify__tag--editable > div {
            color: var(--tag-text-color--edit)
        }

        .tagify__tag--editable > div:before {
            box-shadow: 0 0 0 2px var(--tag-hover) inset !important
        }

        .tagify__tag--editable > .tagify__tag__removeBtn {
            pointer-events: none;
            opacity: 0;
            transform: translate(100%) translate(5px)
        }

        .tagify__tag--editable.tagify--invalid > div:before {
            box-shadow: 0 0 0 2px var(--tag-invalid-color) inset !important
        }

        .tagify__tag__removeBtn {
            order: 5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50px;
            cursor: pointer;
            font: 14px/1 Arial;
            background: var(--tag-remove-btn-bg);
            color: var(--tag-remove-btn-color);
            width: 14px;
            height: 14px;
            margin-inline: auto 4.6666666667px;
            overflow: hidden;
            transition: .2s ease-out
        }

        .tagify__tag__removeBtn:after {
            content: "×";
            transition: .3s, color 0s
        }

        .tagify__tag__removeBtn:hover {
            color: #fff;
            background: var(--tag-remove-btn-bg--hover)
        }

        .tagify__tag__removeBtn:hover + div > span {
            opacity: .5
        }

        .tagify__tag__removeBtn:hover + div:before {
            box-shadow: 0 0 0 var(--tag-inset-shadow-size) var(--tag-remove-bg, rgba(211, 148, 148, .3)) inset !important;
            transition: box-shadow .2s
        }

        .tagify:not(.tagify--mix) .tagify__input br {
            display: none
        }

        .tagify:not(.tagify--mix) .tagify__input * {
            display: inline;
            white-space: nowrap
        }

        .tagify__input {
            flex-grow: 1;
            display: inline-block;
            min-width: 110px;
            margin: 5px;
            padding: var(--tag-pad);
            line-height: normal;
            position: relative;
            white-space: pre-wrap;
            color: var(--input-color);
            box-sizing: inherit;
            overflow: hidden
        }

        .tagify__input:focus {
            outline: 0
        }

        .tagify__input:focus:before {
            transition: .2s ease-out;
            opacity: 0;
            transform: translate(6px)
        }

        @supports (-ms-ime-align:auto) {
            .tagify__input:focus:before {
                display: none
            }
        }

        .tagify__input:focus:empty:before {
            transition: .2s ease-out;
            opacity: 1;
            transform: none;
            color: #00000040;
            color: var(--placeholder-color-focus)
        }

        @-moz-document url-prefix() {
            .tagify__input:focus:empty:after {
                display: none
            }
        }

        .tagify__input:before {
            content: attr(data-placeholder);
            width: 100%;
            height: 100%;
            margin: auto 0;
            z-index: 1;
            color: var(--placeholder-color);
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            pointer-events: none;
            opacity: 0;
            position: absolute
        }

        .tagify__input:after {
            content: attr(data-suggest);
            display: inline-block;
            vertical-align: middle;
            position: absolute;
            min-width: calc(100% - 1.5em);
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: pre;
            color: var(--tag-text-color);
            opacity: .3;
            pointer-events: none;
            max-width: 100px
        }

        .tagify__input .tagify__tag {
            margin: 0 1px
        }

        .tagify--mix {
            display: block
        }

        .tagify--mix .tagify__input {
            padding: 5px;
            margin: 0;
            width: 100%;
            height: 100%;
            line-height: 1.5;
            display: block
        }

        .tagify--mix .tagify__input:before {
            height: auto;
            display: none;
            line-height: inherit
        }

        .tagify--mix .tagify__input:after {
            content: none
        }

        .tagify--select {
            cursor: default
        }

        .tagify--select:after {
            content: ">";
            opacity: .5;
            position: absolute;
            top: 50%;
            right: 0;
            bottom: 0;
            font: 16px monospace;
            line-height: 8px;
            height: 8px;
            pointer-events: none;
            transform: translate(-150%, -50%) scaleX(1.2) rotate(90deg);
            transition: .2s ease-in-out
        }

        .tagify--select[aria-expanded=true]:after {
            transform: translate(-150%, -50%) rotate(270deg) scaleY(1.2)
        }

        .tagify--select[aria-expanded=true] .tagify__tag__removeBtn {
            pointer-events: none;
            opacity: 0;
            transform: translate(100%) translate(5px)
        }

        .tagify--select .tagify__tag {
            flex: 1;
            max-width: none;
            margin-inline-end: 2em;
            margin-block: 0;
            padding-block: 5px;
            cursor: text
        }

        .tagify--select .tagify__tag div:before {
            display: none
        }

        .tagify--select .tagify__tag + .tagify__input {
            display: none
        }

        .tagify--empty .tagify__input:before {
            transition: .2s ease-out;
            opacity: 1;
            transform: none;
            display: inline-block;
            width: auto
        }

        .tagify--mix .tagify--empty .tagify__input:before {
            display: inline-block
        }

        .tagify--focus {
            --tags-border-color: var(--tags-focus-border-color);
            transition: 0s
        }

        .tagify--invalid {
            --tags-border-color: #D39494
        }

        .tagify__dropdown {
            position: absolute;
            z-index: 9999;
            transform: translateY(-1px);
            border-top: 1px solid var(--tagify-dd-color-primary);
            overflow: hidden
        }

        .tagify__dropdown[dir=rtl] {
            transform: translate(-100%, -1px)
        }

        .tagify__dropdown[placement=top] {
            margin-top: 0;
            transform: translateY(-100%)
        }

        .tagify__dropdown[placement=top] .tagify__dropdown__wrapper {
            border-top-width: 1.1px;
            border-bottom-width: 0
        }

        .tagify__dropdown[position=text] {
            box-shadow: 0 0 0 3px rgba(var(--tagify-dd-color-primary), .1);
            font-size: .9em
        }

        .tagify__dropdown[position=text] .tagify__dropdown__wrapper {
            border-width: 1px
        }

        .tagify__dropdown__wrapper {
            scroll-behavior: auto;
            max-height: var(--tagify-dd-max-height);
            overflow: hidden;
            overflow-x: hidden;
            color: var(--tagify-dd-text-color);
            background: var(--tagify-dd-bg-color);
            border: 1px solid;
            border-color: var(--tagify-dd-color-primary);
            border-bottom-width: 1.5px;
            border-top-width: 0;
            box-shadow: 0 2px 4px -2px #0003;
            transition: .3s cubic-bezier(.5, 0, .3, 1), transform .15s;
            animation: dd-wrapper-show 0s .3s forwards
        }

        @keyframes dd-wrapper-show {
            to {
                overflow-y: auto
            }
        }

        .tagify__dropdown__header:empty {
            display: none
        }

        .tagify__dropdown__footer {
            display: inline-block;
            margin-top: .5em;
            padding: var(--tagify-dd-item-pad);
            font-size: .7em;
            font-style: italic;
            opacity: .5
        }

        .tagify__dropdown__footer:empty {
            display: none
        }

        .tagify__dropdown--initial .tagify__dropdown__wrapper {
            max-height: 20px;
            transform: translateY(-1em)
        }

        .tagify__dropdown--initial[placement=top] .tagify__dropdown__wrapper {
            transform: translateY(2em)
        }

        .tagify__dropdown__item {
            box-sizing: border-box;
            padding: var(--tagify-dd-item-pad);
            margin: 1px;
            white-space: pre-wrap;
            cursor: pointer;
            border-radius: 2px;
            outline: 0;
            max-height: 60px;
            max-width: 100%;
            line-height: normal;
            position: relative
        }

        .tagify__dropdown__item--active {
            background: var(--tagify-dd-color-primary);
            color: #fff
        }

        .tagify__dropdown__item:active {
            filter: brightness(105%)
        }

        .tagify__dropdown__item--hidden {
            padding-top: 0;
            padding-bottom: 0;
            margin: 0 1px;
            pointer-events: none;
            overflow: hidden;
            max-height: 0;
            transition: var(--tagify-dd-item--hidden-duration, .3s) !important
        }

        .tagify__dropdown__item--hidden > * {
            transform: translateY(-100%);
            opacity: 0;
            transition: inherit
        }

        .tagify__dropdown__item--selected:before {
            content: "✓";
            font-family: monospace;
            position: absolute;
            inset-inline-start: 6px;
            text-indent: 0;
            line-height: 1.1
        }

        .tagify__dropdown:has(.tagify__dropdown__item--selected) .tagify__dropdown__item {
            text-indent: 1em
        }

        .main-content-email-box {
            max-width: 100%;
        }

        .rich-email-editor {
            min-height: 100px;
            max-height: 280px;
            overflow: auto;
            border: none;
            padding: 5px 10px;
        }

        .rich-email-editor.ql-container.ql-snow .ql-editor::before {
            padding: 0px 10px;
        }

        .ql-container.ql-snow {
            border: none;
        }
        .ql-editor.ql-blank {
            min-height: 100px;
        }
        .quoted-history-wrapper {
            display: flex;
            justify-content: flex-start;
            margin-left: 25px;
        }

        .email-minimized .email-template-body,
        .email-minimized .email-child-wrapper,
        .email-minimized .email-footer-div {
            display: none;
        }

        .email-minimized .email-divider {
            display: none;
        }
.quoted-history-container {
    position: relative;
    margin-top: 10px;
}
.quoted-history-container img {
    max-width: 300px !important;
}
        .show-quoted-btn {
            background: #f0f0f0; /* light highlight */
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 11px; /* bigger size */
            font-weight: bold;
            cursor: pointer;
            color: #333;
            padding: 5px 15px;
            margin-bottom: 5px;
            transition: all 0.2s ease-in-out;

            position: absolute;
            left: 0;
            top: 0;
            line-height: 1;

            transform: translateY(-100%); /* move it just above the quoted box */
            z-index: 2;
            display: none;
        }
        .quoted-history {
            padding-right:20px !important ;
            text-align: left !important;
        }
        button.show-quoted-btn.btn.btn-sm.btn-outline-secondary {
            padding: 6px 18px;
            margin: 8px 30px;
        }

    </style>
@endpush
<section class="new-template-mail email-template" id="emailTemplate">
    <div class="container-fluid p-0">
        <div class="row justify-content-end">
            <div class="col-lg-12">
                <div class="email-header-main-wrapper">
                    <div class="email-child-wrapper-one">
                        <i class="fa fa-angle-down minimize-btn" aria-hidden="true" style="cursor:pointer;"></i>
                        <p class="email-titles" style="cursor:pointer;">Email</p>
                    </div>
                    <div class="email-child-wrapper-one">
                        <i class="fa fa-external-link-square" aria-hidden="true" style="cursor:pointer;"></i>
                        <i class="fa fa-times close-btn" aria-hidden="true" style="cursor:pointer;"></i>
                    </div>
                </div>
                <div class="email-child-wrapper" style="display:none;padding: 10px 20px;">
                    <p class="email-titles-hide">Templates</p>
                    <p class="email-titles-show">Sequence <span><i class="fa fa-lock icon-display-email-box"
                                                                   aria-hidden="true"></i></span></p>
                    <p class="email-titles-hide">Documnets</p>
                    <!-- <p class="email-titles-show">Meetings </p> -->
                    <div class="">
                        <button class="email-titles-dropdown dropdown-toggle" type="button"
                                id="dropdownMenuButtonmeet" data-bs-toggle="dropdown" aria-expanded="false">
                            Meetings
                        </button>
                        <ul class="dropdown-menu email-titles-dropdown-menu"
                            aria-labelledby="dropdownMenuButtonmeet">
                            <li>
                                <h4 class="main-content-email-text">Connect with your Email</h4>
                            </li>
                            <li class="text-center">
                                <img src="img/dropdown-img.png" class="img-fluid dropdown-img">
                            </li>
                            <li class="text-center">
                                <p class="main-content-email-para">Lorem ipsum, dolor sit amet consectetur
                                    adipisicing elit.
                                    Obcaecati culpa optio ex et,</p>
                                <button class="connect-to-inbox-btn">Get started<span><i
                                            class="fa fa-external-link get-started-icon"
                                            aria-hidden="true"></i></span></button>
                            </li>
                        </ul>
                    </div>

                    <div class="">
                        <button class="email-titles-dropdown dropdown-toggle" type="button"
                                id="dropdownMenuButtonquote" data-bs-toggle="dropdown" aria-expanded="false">
                            Quotes
                        </button>
                        <ul class="dropdown-menu quotes-titles-dropdown-menu"
                            aria-labelledby="dropdownMenuButtonquote">
                            <li class="quotes-header-box">
                                <p class="main-content-email-para quotes-content-para ">Lorem ipsum, dolor sit amet
                                    consectetur</p>
                            </li>
                            <li class="email-footer-div">

                                <a href="#" class="quotes-titles-link">How do I create quotes? <span><i
                                            class="fa fa-external-link icon-display-email-box get-started-icon"
                                            aria-hidden="true"></i></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="email-divider "></div>
                <div class="email-template-body">
                    <div class="email-child-wrapper" style="  padding: 5px 20px;">
                        <p class="email-sending-titles"> To </p>

                        <input
                            class="email-sender-name"
                            id="toFieldInput"
                            name="to"
                            value="{{$customer_contact->email ?? "    "}}"
                            type="text"
                            placeholder="Add recipients"
                            style="border: none;"
                        >
                    </div>
                    <div class="email-child-wrapper d-none" id="ccField" style="  padding: 5px 20px;">
                        <p class="email-sending-titles"> Cc </p>

                        <input
                            class="email-sender-name" id="ccFieldInput"
                            type="email"
                            name="cc"
                            placeholder="Add Cc recipients"
                            style="border: none;"
                        >
                    </div>
                    <div class="email-child-wrapper d-none" id="bccField" style="  padding: 5px 20px;">
                        <p class="email-sending-titles"> Bcc </p>

                        <input
                            class="email-sender-name" id="bccFieldInput"
                            name="bcc"
                            type="text"
                            placeholder="Add Bcc recipients"
                            style="border: none;">
                    </div>
                    <div class="email-sending-box">
                        <div class="email-child-wrapper">
                            <p class="email-sending-titles">From</p>
                            <p class="email-sender-name" style="min-width: 520px;">
                                <select name="from_email" class="form-select form-control from_email"
                                        style="width: auto; display: inline-block;border:none;">
                                    @foreach($pseudo_emails as $item)
                                        <option value="{{ $item['email'] }}"
                                                data-name="{{ $item['name'] }}"
                                                data-company="{{ $item['company'] }}"
                                            {{ $loop->first ? 'selected' : '' }}>
                                            {{ $item['name'] }} ({{ $item['email'] }})
                                        </option>
                                    @endforeach
                                </select>

                                <span id="from_company">
                                        from {{ $pseudo_emails->first()['company'] ?? 'Unknown' }}
                                </span>
                            </p>

                        </div>
                        <div class="email-child-wrapper">
                            <p class="email-sending-titles" onclick="toggleCcField(this)" style="padding:0 5px;">Cc</p>
                        </div>
                        <div class="email-child-wrapper">
                            <p class="email-sending-titles" onclick="toggleBccField(this)">Bcc</p>
                        </div>
                    </div>
                    <div class="email-divider"></div>
                    <div class="email-child-wrapper" style="  padding: 5px 20px;">
                        <p class="email-sending-titles"> Subject </p>
                        {{--                    <p class="" style="margin: 0;">Re: <span> #Professional Image Editing</i>--}}
                        {{--                            </span></p>--}}
                        <input type="text" name="subject" id="emailSubject" value="{{ $subject ?? '' }}"/>
                    </div>
                    <div class="email-divider"></div>
                    <div class="main-content-email-box">
                        <!-- Editable body -->
                        <div class="rich-email-editor"
                             data-placeholder="Write your message...">
                        </div>

                        <!-- Quoted history (non-editable) -->
                        <div class="quoted-history-container">
                            <button class="show-quoted-btn btn btn-sm btn-outline-secondary " type="button" title="Show quoted">
                                ...
                            </button>

                            <div class="quoted-history-wrapper">
                                <div class="quoted-history"
                                    style="display: none;border-left: 0px solid rgb(204, 204, 204);padding-left: 0px;padding-top: 15px;font-size: 13px;color: rgb(85, 85, 85);">
                                    <!-- quoted content goes here -->
                                    Previous email reply or forwarded message content...
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="email_content" id="emailContent">

                        <!-- inside .main-content-email-box, next to #emailContent -->
                        <input type="hidden" name="email_content" id="emailContent">
                        <input type="hidden" name="thread_id" id="thread_id">
                        <input type="hidden" name="in_reply_to" id="in_reply_to">
                        <input type="hidden" name="references" id="references">

                        <input type="hidden" name="is_forward" id="is_forward">
                        <input type="hidden" name="forward_id" id="forward_id">


                    </div>

                </div>

                <div class="email-footer-div ">
                    <button class="email-footer-btn" id="sendEmailBtn">Send</button>
                    <button class="email-footer-btn close-btn gap-2">Cancel</button>
                </div>
            </div>

        </div>
    </div>
</section>
@push('script')
    <script>
        $(function () {
            $(".from_email").on("change", function () {
                let selected = $(this).find(":selected");

                $("#from_name").val(selected.data("name"));
                $("#from_company").text("from " + selected.data("company"));
            });
        });
        function toggleCcField(element) {
            document.getElementById('ccField').classList.toggle('d-none');
            element.parentElement.classList.add('d-none');
            if (!document.getElementById('ccField').classList.contains('d-none')) {
                document.querySelector('#ccField input').focus();
            }
        }
        function toggleBccField(element) {
            document.getElementById('bccField').classList.toggle('d-none');
            element.parentElement.classList.add('d-none');
            if (!document.getElementById('bccField').classList.contains('d-none')) {
                document.querySelector('#bccField input').focus();
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            const suggestions = [
                    @foreach($pseudo_emails as $item)
                {
                    value: "{{ $item['email'] }}",
                    name: "{{ $item['name'] }}",
                }{{ !$loop->last ? ',' : '' }}
                    @endforeach
            ];

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const toFieldInput = document.getElementById('toFieldInput');
            if (toFieldInput) {
                const tagify = new Tagify(toFieldInput, {
                    pattern: emailPattern,
                    delimiters: ", ",
                    placeholder: "Add recipients",
                    enforceWhitelist: false,
                    whitelist: suggestions,
                    dropdown: {
                        enabled: 1,
                        maxItems: 5,
                        position: "input",
                        closeOnSelect: true,
                        highlightFirst: true,
                        fuzzySearch: true,
                        searchKeys: ['value', 'name']
                    }
                });

                if (toFieldInput.value) {
                    tagify.addTags(`{{ $customer_contact->name ?? '' }}`);
                }
            }

            const ccFieldInput = document.getElementById('ccFieldInput');
            if (ccFieldInput) {
                new Tagify(ccFieldInput, {
                    pattern: emailPattern,
                    delimiters: ", ",
                    placeholder: "Add Cc recipients",
                    enforceWhitelist: false,
                    whitelist: suggestions,
                    dropdown: {
                        enabled: 1,
                        maxItems: 5,
                        position: "input",
                        closeOnSelect: true,
                        highlightFirst: true,
                        fuzzySearch: true,
                        searchKeys: ['value', 'name']
                    }
                });
            }

            const bccFieldInput = document.getElementById('bccFieldInput');
            if (bccFieldInput) {
                new Tagify(bccFieldInput, {
                    pattern: emailPattern,
                    whitelist: suggestions,
                    dropdown: {
                        enabled: 1,
                        maxItems: 5,
                        position: "input",
                        closeOnSelect: true,
                        highlightFirst: true,
                        fuzzySearch: true,
                        searchKeys: ['value', 'name']
                    }
                });
            }

            document.getElementById('sendEmailBtn').addEventListener('click', function (e) {
                e.preventDefault();

                const quill = window.quillInstances['editor_0'];
                const emailContent = document.getElementById('emailContent');

                if (quill) {
                    emailContent.value = quill.root.innerHTML;
                }

                // validation
                const subjectEl = document.getElementById('emailSubject');
                const fromEl = document.querySelector('[name="from_email"]');
                const toEl = document.querySelector('[name="to"]');

                let valid = true;

                // From validation
                if (!fromEl.value.trim()) {
                    toastr.error("From email is required.");
                    valid = false;
                }

                // To validation
                if (!toEl.value.trim() || JSON.parse(toEl.value).length === 0) {
                    toastr.error("At least one recipient (To) is required.");
                    valid = false;
                }

                // Subject validation
                if (!subjectEl.value.trim()) {
                    toastr.error("Subject is required.");
                    valid = false;
                }

                // Check total email content size including base64 images
                const totalSize = new Blob([emailContent.value]).size;
                if (totalSize > 1048576) {
                    toastr.error("Total email content including images should not exceed 1 MB.");
                    valid = false;
                }

                // Stop if required fields invalid
                if (!valid) {
                    return;
                }
                //validation end

                const formData = new FormData();
                formData.append('email_content', emailContent.value);

                formData.append('subject', document.getElementById('emailSubject').value);

                const fields = ['to', 'cc', 'bcc'].map(n => document.querySelector(`[name="${n}"]`));
                const extract = f => f && f.value.trim() ? JSON.parse(f.value).map(i => i.value) : [];

                fields.forEach((f, i) => extract(f).forEach(email =>
                    formData.append(`${['to', 'cc', 'bcc'][i]}[]`, email)
                ));


                formData.append('from', document.querySelector('[name="from_email"]').value);
                formData.append('customer_id', "{{ $customer_contact->id ?? '' }}");
                formData.append('thread_id', document.getElementById('thread_id').value || '');
                formData.append('in_reply_to', document.getElementById('in_reply_to').value || '');
                formData.append('references', document.getElementById('references').value || '');

                formData.append('is_forward', document.getElementById('is_forward').value || '');
                formData.append('forward_id', document.getElementById('forward_id').value || '');

                AjaxRequestPromise(`{{ route("admin.customer.contact.send.email") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response.success) {
                            console.log('success', response);
                            // Reset subject
                            document.getElementById('emailSubject').value = "";

                            // Reset body
                            if (window.quillInstances && window.quillInstances['editor_0']) {
                                window.quillInstances['editor_0'].root.innerHTML = "";
                            }

                            // Reset cc/bcc
                            const ccField = document.querySelector('[name="cc"]');
                            const bccField = document.querySelector('[name="bcc"]');
                            if (ccField) ccField.value = "";
                            if (bccField) bccField.value = "";
                            window.refreshTimeline();
                            resetEmailTemplatePosition();

                        } else {
                            // toastr.error(response.message || "Failed to send email");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // toastr.error("Something went wrong while sending email!");
                    });

            });
        })

        // dynamic function for reset position

        function resetEmailTemplatePosition() {
            const emailTemplate = document.querySelector('#emailTemplate');
            if (emailTemplate) {
                emailTemplate.classList.remove('open');
                emailTemplate.classList.remove("email-minimized");

                emailTemplate.style.position = "fixed";
                emailTemplate.style.bottom = "0";
                emailTemplate.style.right = "50px";
                emailTemplate.style.left = "auto";
                emailTemplate.style.top = "auto";
            }
        }

        //minimize and show email template (jQuery version)
        $(document).ready(function () {
            var $emailTemplate = $("#emailTemplate");
            var $minimizeBtn = $emailTemplate.find(".minimize-btn");

            $minimizeBtn.on("click", function () {
                $emailTemplate.toggleClass("email-minimized");

                if ($emailTemplate.hasClass("email-minimized")) {
                    $minimizeBtn.removeClass("fa-angle-down").addClass("fa-angle-up");
                } else {
                    $minimizeBtn.removeClass("fa-angle-up").addClass("fa-angle-down");
                }
            });
        });

        $(function () {
            let offsetX = 0, offsetY = 0, isDragging = false;

            const $dragElement = $("#emailTemplate");
            const $dragHandle = $dragElement.find(".email-header-main-wrapper");

            $dragHandle.on("mousedown", function (e) {
                isDragging = true;

                const rect = $dragElement[0].getBoundingClientRect();
                $dragElement.css({
                    top: rect.top,
                    left: rect.left,
                    bottom: "auto",
                    right: "auto",
                    position: "fixed"
                });

                offsetX = e.clientX - rect.left;
                offsetY = e.clientY - rect.top;

                $("body").css("user-select", "none");
            });

            $(document).on("mousemove", function (e) {
                if (!isDragging) return;

                const winW = $(window).width();
                const winH = $(window).height();
                const elemW = $dragElement.outerWidth();
                const elemH = $dragElement.outerHeight();

                // calculate new position
                let newLeft = e.clientX - offsetX;
                let newTop = e.clientY - offsetY;

                // clamp values to viewport
                if (newLeft < 0) newLeft = 0;
                if (newTop < 0) newTop = 0;
                if (newLeft + elemW > winW) newLeft = winW - elemW;
                if (newTop + elemH > winH) newTop = winH - elemH;

                $dragElement.css({
                    left: newLeft,
                    top: newTop
                });
            });

            $(document).on("mouseup", function () {
                isDragging = false;
                $("body").css("user-select", "auto");
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const closeBtns = document.querySelectorAll(".close-btn");
            const emailTemplate = document.querySelector("#emailTemplate");

            closeBtns.forEach(btn => {
                btn.addEventListener("click", function () {
                    document.getElementById('emailSubject').value = "";

                    if (window.quillInstances && window.quillInstances['editor_0']) {
                        window.quillInstances['editor_0'].root.innerHTML = "";
                    }

                    const ccField = document.querySelector('[name="cc"]');
                    const bccField = document.querySelector('[name="bcc"]');
                    if (ccField) ccField.value = "";
                    if (bccField) bccField.value = "";

                    resetEmailTemplatePosition();

                });
            });
        });


    </script>
<script>
document.addEventListener("click", function (e) {
    if (e.target.closest(".show-quoted-btn")) {
        const btn = e.target.closest(".show-quoted-btn");
        const quoted = btn.parentElement.querySelector(".quoted-history");

        const isVisible = quoted.style.display === "block";
        quoted.style.display = isVisible ? "none" : "block";

        // Change button text between "..." and "Hide"
        btn.textContent = isVisible ? "..." : "Hide";
    }
});
</script>
@endpush
