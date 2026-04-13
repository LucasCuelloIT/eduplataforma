import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Link from '@tiptap/extension-link'

document.addEventListener('DOMContentLoaded', () => {
    const editorContainer = document.getElementById('editor')
    const hiddenInput = document.getElementById('contenido')

    if (!editorContainer) return

    // Botones de la barra de herramientas
    const toolbar = document.getElementById('editor-toolbar')

    const editor = new Editor({
        element: editorContainer,
        extensions: [
            StarterKit,
            Link.configure({ openOnClick: false }),
        ],
        content: hiddenInput.value || '',
        onUpdate({ editor }) {
            hiddenInput.value = editor.getHTML()
        },
    })

    // Acciones de la barra
    toolbar.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]')
        if (!btn) return
        const action = btn.dataset.action

        switch(action) {
            case 'bold':        editor.chain().focus().toggleBold().run(); break
            case 'italic':      editor.chain().focus().toggleItalic().run(); break
            case 'h2':          editor.chain().focus().toggleHeading({ level: 2 }).run(); break
            case 'h3':          editor.chain().focus().toggleHeading({ level: 3 }).run(); break
            case 'bullet':      editor.chain().focus().toggleBulletList().run(); break
            case 'ordered':     editor.chain().focus().toggleOrderedList().run(); break
            case 'link':
                const url = prompt('Ingresá la URL:')
                if (url) editor.chain().focus().setLink({ href: url }).run()
                break
            case 'unlink':      editor.chain().focus().unsetLink().run(); break
            case 'clear':       editor.chain().focus().clearNodes().unsetAllMarks().run(); break
        }
    })

    // Exponer el editor globalmente
    window.tiptapEditor = editor
})