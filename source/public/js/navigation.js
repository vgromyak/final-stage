$(document).ready(
    function() {
        var section = $(location).attr('pathname').replace(/^\/+|\/+$/gm,'').split('/').shift();
        //console.log(section);
        var menuItems = $('#navbar ul>li');
        menuItems.each(function(k, item) {
            item = $(item);
            var isCurrent = item.data('section') == section;
            var isActive = item.hasClass('active');
            if (isCurrent && !isActive) {
                item.addClass('active');
            } else if(!isCurrent && isActive) {
                item.removeClass('active');
            }
        });

        var first = $('h1').first();
        if (first.length) {
            document.title = first.html();
        }
    }
);
