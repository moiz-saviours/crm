import './bootstrap';
// import '../css/app.css';
import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';
import Alpine from 'alpinejs';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';


window.Alpine = Alpine;
window.Tagify = Tagify;
window.quillInstances = {};

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const editors = document.querySelectorAll('.rich-email-editor');

    if (editors.length) {
        editors.forEach((editor, index) => {
            window.quillInstances[`editor_${index}`] = new Quill(editor, {
                theme: 'snow',
                placeholder: editor.dataset.placeholder || 'Type your email here...',
                modules: {
                    toolbar: [
                        [{ 'font': [] }, { 'size': [] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'super' }, { 'script': 'sub' }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }, { 'align': [] }],
                        ['link', 'image', 'video', 'formula'],
                        ['clean']
                    ]
                }
            });
        });
    }
});
