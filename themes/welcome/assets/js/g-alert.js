(function(e) {
    "use strict";
    e.fn.gAlert = function() {
        return this.each(function() {
            var t = e(this),
                n = t.find(".g-alert-close");
            n && n.click(function() {
                t.animate({
                    height: "0",
                    margin: 0
                }, 400, function() {
                    t.css("display", "none")
                })
            })
        })
    }
})(jQuery), jQuery(document).ready(function() {
    "use strict";
    jQuery(".g-alert").gAlert()
});
