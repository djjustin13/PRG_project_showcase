function sort(e, s) {e.preventDefault();
    var url = window.location.href;
    var arr = url.split('?');
    if (arr.length > 1 && arr[1] !== '') {
        window.location.href += "&sort="+s;
    }else {
        window.location.href += "?sort="+s;
    }
    return false; };
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