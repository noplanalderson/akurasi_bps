CKEDITOR.editorConfig = function( config ) {
    config.toolbarGroups = [
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] }
    ];

    config.removeButtons = 'NewPage,Preview,Print,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Language,Flash,PageBreak,About,ShowBlocks,Save,Smiley,SpecialChar,PasteFromWord,PasteText,Insert,Styles,Colors,Tools,Others,Anchor,Source,CreateDiv,Subscript,Blockquote';
};