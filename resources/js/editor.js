import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Link from '@tiptap/extension-link'
window.setupEditor = function(content = '') {
    return {
        editor: null,
        content: content,
        init(element) {
            this.editor = new Editor({
                element: element,
                extensions: [
                    StarterKit,
                    Link.configure({
                        openOnClick: false,
                    }),
                ],
                content: this.content,
                onUpdate: ({ editor }) => {
                    this.content = editor.getHTML()
                    // Update hidden input for form submission
                    document.getElementById('content').value = this.content
                },
            })
            // Initialize toolbar buttons
            this.editor.on('selectionUpdate', () => {
                // Update button states based on current formatting
                document.querySelectorAll('[data-toolbar-button]').forEach(button => {
                    const type = button.dataset.toolbarButton
                    if (type === 'bold' || type === 'italic' || type === 'strike') {
                        button.classList.toggle('bg-gray-200', this.editor.isActive(type))
                    }
                })
            })
        },
        destroy() {
            if (this.editor) {
                this.editor.destroy()
            }
        }
    }
}