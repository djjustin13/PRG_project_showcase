CKEDITOR.replace( 'article-ckeditor' );

$(document).ready(function(){
    $('input[type="file"]').change(function(e){
        var files = e.target.files;
        var text = "";
        for (index = 0; index < files.length; ++index) {
            text += files[index].name +', ';
        }
        $('#file-display').val(text);
    });

});