(function(e) {
    "use strict";
    e.fn.wLang = function() {
        return this.each(function() {
            var t = e(this).find(".w-lang-list"),
                n = e(this).find(".w-lang-current"),
                r = this,
                i = t.height();
            t.css({
                height: 0,
                display: "none"
            }), n.click(function() {
                n.addClass("active"), t.css({
                    display: "block"
                }), t.animate({
                    height: i
                }, 200)
            }), e(document).mouseup(function(i) {
                e(r).has(i.target).length === 0 && t.animate({
                    height: 0
                }, 200, function() {
                    t.css({
                        display: "none"
                    }), n.removeClass("active")
                })
            })
        })
    }
})(jQuery), jQuery(document).ready(function() {
    "use strict";
    jQuery(".w-lang").wLang()
});
