tinymce.init({
    height: 500,
    menubar: false,
    statusbar: false,
    selector: "#noteareaID",
    plugins: "codesample image link lists",
    contextmenu: 'paraphrase',
    toolbar: "",
    readonly: true, 

    setup:function(ed) {
        
    
        // ed.on('keydown', function(e) {
        //     console.log('add');
        //     window.livewire.emit('set:notevalues', ed.getContent(), ed.getContent({format : 'text'}));
        // });

        ed.addShortcut('ctrl+S', 'Save', () => {
            insertUsername();
        });

        const insertUsername = () => {

        };

        ed.ui.registry.addMenuButton('insertUsername', {
        icon: 'save',
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