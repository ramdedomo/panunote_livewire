tinymce.init({
    min_height: 800,
    menubar: false,
    branding: false,
    selector: "#noteareaID",
    resize: true,
    plugins: "codesample image link lists",
    contextmenu: 'paraphrase',
    toolbar: "insertUsername | customInsertButton | styles | fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | removeformat | | undo redo | alignleft aligncenter alignright |  image link unlink codesample | bullist numlist ",

    setup:function(ed) {
        
        ed.ui.registry.addMenuItem('paraphrase', {
            text: 'Paraphrase',
            context: 'tools',
            onAction: function () {
                window.livewire.emit('set:paraphrasetext', ed.selection.getContent({format: 'text'}));
            }
        });


        ed.ui.registry.addIcon('bubbles', '<svg width="24" height="24" viewBox="0 0 448 512"><path xmlns="http://www.w3.org/2000/svg" d="M224 256c-35.2 0-64 28.8-64 64c0 35.2 28.8 64 64 64c35.2 0 64-28.8 64-64C288 284.8 259.2 256 224 256zM433.1 129.1l-83.9-83.9C341.1 37.06 328.8 32 316.1 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V163.9C448 151.2 442.9 138.9 433.1 129.1zM128 80h144V160H128V80zM400 416c0 8.836-7.164 16-16 16H64c-8.836 0-16-7.164-16-16V96c0-8.838 7.164-16 16-16h16v104c0 13.25 10.75 24 24 24h192C309.3 208 320 197.3 320 184V83.88l78.25 78.25C399.4 163.2 400 164.8 400 166.3V416z"></svg>');


        // ed.on('keydown', function(e) {
        //     console.log('add');
        //     window.livewire.emit('set:notevalues', ed.getContent(), ed.getContent({format : 'text'}));
        // });

        // ed.on('Change', function(e) {
        //     window.livewire.emit('set:notevalues', ed.getContent(), ed.getContent({format : 'text'}));
        //     window.livewire.emit('set:submit');
        // });
        

        ed.addShortcut('ctrl+S', 'Save', () => {
            insertUsername();
        });

        ed.addShortcut('ctrl+shift+A', 'Mark as Answer', () => {
            highlight();
        });

        const insertUsername = () => {
            window.livewire.emit('set:notevalues', ed.getContent(), ed.getContent({format : 'text'}));
            window.livewire.emit('set:submit');
        };

        const highlight = () =>{
            ed.execCommand('backColor', false, 'rgb(241, 196, 15)');
        };

        
        ed.ui.registry.addButton('customInsertButton', {
            icon: 'checkmark',
            text: 'Mark as Answer',
            tooltip: 'ctrl+A',
            shortcut: 'ctrl+A',
            onAction: () => highlight()
        });

        ed.ui.registry.addMenuButton('insertUsername', {
        icon: 'bubbles',
        fetch: (callback) => {
            const items = [
            {
                type: 'menuitem',
                text: 'Save',
                shortcut: 'ctrl+S',
                onAction: () => insertUsername()
            }
            ];
            callback(items);
        }
        });
    },


    style_formats: [
        { title: "Title", block: "h1" },
        { title: "Heading", block: "h2" },
        { title: "Sub heading", block: "h3" },
        { title: "Paragraph", block: "p" },
        { title: "Code", inline: "code" },
        { title: "Quote", block: "blockquote" },
        { title: "Callout", block: "div", classes: "call-out" },
    ],

});