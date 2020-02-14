var ajax_count = 0;

function ajax_start() {
    ajax_count++;
    if (ajax_count == 1) {
        document.getElementById("ajax-loader-overlay").style.display = 'block';
    }
}

function ajax_finish() {
    if (ajax_count > 0) {
        ajax_count--;
        if (ajax_count == 0) {
            document.getElementById("ajax-loader-overlay").style.display = 'none';
        }
    }
}

function ajax_get(url,success) {
    ajax_start();
    var r = new XMLHttpRequest();
    r.open('GET', url);
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            ajax_finish();
            if (r.status != 200) {
                // load error
            } else {
                success(JSON.parse(r.responseText));
            }
        }
    };
    r.send();
}