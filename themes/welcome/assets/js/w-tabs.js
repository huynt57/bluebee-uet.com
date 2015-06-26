(function(e) {
    "use strict";
    e.fn.wTabs = function() {
        return this.each(function() {
            function u() {
                if (!t.hasClass("layout_accordion") || !! t.data("accordionLayoutDynamic")) s > t.width() ? (t.data("accordionLayoutDynamic", !0), t.hasClass("layout_accordion") || t.addClass("layout_accordion")) : t.hasClass("layout_accordion") && t.removeClass("layout_accordion")
            }
            var t = e(this),
                n = t.find(".w-tabs-item"),
                r = t.find(".w-tabs-section"),
                i = null,
                s = 0,
                o = !1;
            n.each(function() {
                s += e(this).outerWidth(!0)
            }), u(), e(window).resize(function() {
                window.clearTimeout(i), i = window.setTimeout(function() {
                    u()
                }, 50)
            }), r.each(function(i) {
                var s = e(n[i]),
                    u = e(r[i]),
                    a = u.find(".w-tabs-section-title"),
                    f = u.find(".w-tabs-section-content");
                u.hasClass("active") && f.slideDown(), a.click(function() {
                    t.hasClass("type_toggle") ? o || (u.hasClass("active") ? (o = !0, s && s.removeClass("active"), f.slideUp(null, function() {
                        u.removeClass("active"), o = !1
                    })) : (o = !0, s && s.addClass("active"), f.slideDown(null, function() {
                        u.addClass("active"), o = !1
                    }))) : !u.hasClass("active") && !o && (o = !0, n.each(function() {
                        e(this).hasClass("active") && e(this).removeClass("active")
                    }), s && s.addClass("active"), r.each(function() {
                        e(this).hasClass("active") && e(this).find(".w-tabs-section-content").slideUp()
                    }), f.slideDown(null, function() {
                        r.each(function() {
                            e(this).hasClass("active") && e(this).removeClass("active")
                        }), u.addClass("active"), o = !1
                    }))
                }), s && s.click(function() {
                    a.click()
                })
            })
        })
    }
})(jQuery), jQuery(document).ready(function() {
    "use strict";
    jQuery(".w-tabs").wTabs()
});
