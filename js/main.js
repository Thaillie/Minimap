function Minimap(minimap_elem) {
    var map_container = $(minimap_elem).find('.container');
    var map_height = $(map_container).height();
    var map_width = $(map_container).width();

    return {
        bindZoom: function(zoom_amount) {
            $(minimap_elem).on("DOMMouseScroll mousewheel", function(e) {
                if(e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0) {
                    map_height = map_height + zoom_amount;
                    map_width = map_width + zoom_amount;

                    map_container.css({
                        height: map_height,
                        width: map_width
                    });
                } else {
                    map_height = map_height - zoom_amount;
                    map_width = map_width - zoom_amount;

                    map_container.css({
                        height: map_height,
                        width: map_width
                    });
                }
            });
        },
        bindDrag: function() {
            var dragging = false;
            var mouse_y, mouse_x;
            var offset_y, offset_x;
            var container_top, container_left;

            $(map_container).on("mousedown", function(e) {
                e.preventDefault();
                dragging = true;

                mouse_y = e.screenY;
                mouse_x = e.screenX;

                container_top = $(minimap_elem).position().top;
                container_left = $(map_container).position().left;
            });

            $(map_container).on("mousemove", function(e) {
                if (dragging) {
                    offset_y = -(mouse_y - e.screenY);
                    offset_x = -(mouse_x - e.screenX);

                    map_container.css({
                        top: (container_top + offset_y) + 'px',
                        left: (container_left + offset_x) + 'px'
                    });
                }
            });

            $(document).on("mouseup", function() {
                dragging = false;
            });
        }
    };
}

$(document).ready(function() {
    var main = Minimap($("#Minimap"));
    main.bindZoom(20);
    main.bindDrag();
});