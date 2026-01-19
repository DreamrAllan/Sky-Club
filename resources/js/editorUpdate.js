import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import ImageTool from '@editorjs/image';
import Quote from '@editorjs/quote';
import Embed from '@editorjs/embed';
import Checklist from '@editorjs/checklist';
import LinkTool from '@editorjs/link';
import List from '@editorjs/list';
import Table from '@editorjs/table'
import axios from 'axios';
import Warning from '@editorjs/warning';
import Delimiter from '@editorjs/delimiter';

let saveBtn = document.getElementById('save-data');

if (saveBtn) {
    let meta = document.head.querySelector('meta[name="csrf-token"]');

    const content = document.getElementById('editorjs').dataset.content
    ? JSON.parse(document.getElementById('editorjs').dataset.content)
    : { blocks: [] };
        console.log(meta);

    const editor = new EditorJS({
        holder: 'editorjs',
        placeholder: 'Tulis artikel di sini...',
        data: content,
        tools: {
            header: {
                class: Header,
                inlineToolbar: true,
                config: {
                    placeholder: 'Enter a header',
                    levels: [1, 2, 3, 4, 5],
                    defaultLevel: 3,
                },
            },
            list: {
                class: List,
                inlineToolbar: true,
            },
            image: {
                class: ImageTool,
                config: {
                    endpoints: {
                        byFile: '/admin/article/upload-image', // Endpoint untuk upload file
                        byUrl: '/admin/article/fetch-image', // Endpoint untuk fetch URL gambar
                    },
                    additionalRequestHeaders: {
                        'X-CSRF-TOKEN': meta.content,
                    },
                }
            },
            checklist: {
                class: Checklist,
                inlineToolbar: true,
            },
            linkTool: {
                class: LinkTool,
                config: {
                    endpoint: '', // Your backend endpoint for url data fetching,
                }
            },
            quote: Quote,
            delimiter: Delimiter,
            Warning: Warning,
            table: {
                class: Table,
                inlineToolbar: true,
            },
        },
        onReady: () => {
            console.log('Editor.js is ready to work!');
            document.getElementById('editorjs').classList.add('prose', 'max-w-none');
        },
        onChange: () => {
            console.log('Editor content changed!');
        },
    });


    saveBtn.addEventListener('click', (e) => {
    e.preventDefault();

    const articleId = saveBtn.dataset.id;
    const url = `/admin/article/edit/${articleId}`;
    const title = document.getElementById('title').value;

    editor.save().then((outputData) => {
        axios.post(url, {
            title: title,
            content: outputData,
        }, {
            headers: { 'X-CSRF-TOKEN': meta.content },
        })
        .then((response) => {
            window.location.href = '/admin/article';
            console.log('Data saved successfully:', response);
        })
        .catch((error) => {
            console.error('Error saving data:', error);
        });
    }).catch((error) => {
        console.error('Saving failed:', error);
    });
});

}
