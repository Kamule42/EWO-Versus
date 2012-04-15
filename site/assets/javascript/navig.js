function anchor_intern(uri){
    if(uri.charAt(uri.length) != '/')
        uri += '/';
    navig_load(uri);
}

$(window).bind('popstate', function(event) {
    // if the event has our history data on it, load the page fragment with AJAX
    var state = event.originalEvent.state;
    if (state) {
         navig_load(state.path);
    }
});


function navig_load(uri){
    $.get(uri+"ajax", function(data) {
        if (history && history.pushState) {
          history.pushState({path:uri}, document.title, uri);
        }
        $('#body').html(data);
    });
}