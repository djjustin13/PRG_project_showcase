function sort(e, s) {e.preventDefault();
    var url = window.location.href;
    var arr = url.split('?');
    if (arr.length > 1 && arr[1] !== '') {
        window.location.href += "&sort="+s;
    }else {
        window.location.href += "?sort="+s;
    }
    return false; };