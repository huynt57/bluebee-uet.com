jQuery(document).ready(function() {
    $('div.alert').click(function() {
            $('.alert').slideUp();
        });
    "use strict";
    jQuery(".w-nav-list.layout_hor.level_1").navToSelect({
        select: ".w-nav-select-h",
        list: ".w-nav-list",
        item: ".w-nav-item"
    }), jQuery.magnificPopup && (jQuery(".w-gallery-tnails-h").magnificPopup({
        type: "image",
        delegate: "a",
        gallery: {
            enabled: !0,
            navigateByImgClick: !0,
            preload: [0, 1]
        },
        removalDelay: 300,
        mainClass: "mfp-fade",
        fixedContentPos: !1
    }), jQuery("a[ref=magnificPopup][class!=direct-link]").magnificPopup({
        type: "image",
        fixedContentPos: !1
    })), jQuery().carousello && jQuery(".w-listing.type_carousel, .w-clients.type_carousel, .w-portfolio.type_carousel").carousello();
    if (jQuery().isotope) {
        var e = jQuery(".w-portfolio.type_sortable .w-portfolio-list-h");
        e && (e.imagesLoaded(function() {
            e.isotope({
                itemSelector: ".w-portfolio-item",
                layoutMode: "fitRows"
            })
        }), jQuery(".w-filters-item").each(function() {
            var t = jQuery(this),
                n = t.find(".w-filters-item-link");
            n.click(function() {
                if (!t.hasClass("active")) {
                    jQuery(".w-filters-item").removeClass("active"), t.addClass("active");
                    var n = jQuery(this).attr("data-filter");
                    return e.isotope({
                        filter: n
                    }), !1
                }
            })
        }), jQuery(".w-portfolio-item-meta-tags a").each(function() {
            jQuery(this).click(function() {
                var t = jQuery(this).attr("data-filter"),
                    n = jQuery('a[class="w-filters-item-link"][data-filter="' + t + '"]'),
                    r = n.parent(".w-filters-item");
                if (!r.hasClass("active")) return jQuery(".w-filters-item").removeClass("active"), r.addClass("active"), e.isotope({
                    filter: t
                }), !1
            })
        }));
        var t = jQuery(".w-blog.type_masonry .w-blog-list");
        if (t.length) {
            t.imagesLoaded(function() {
                t.isotope({
                    itemSelector: ".w-blog-entry",
                    layoutMode: "masonry"
                })
            });
            var n;
            jQuery(window).resize(function() {
                window.clearTimeout(n), n = window.setTimeout(function() {
                    t.isotope("reLayout")
                }, 50)
            })
        }
        var r = jQuery(".w-gallery.type_masonry .w-gallery-tnails-h");
        if (r.length) {
            r.imagesLoaded(function() {
                r.isotope({
                    layoutMode: "masonry"
                })
            });
            var i;
            jQuery(window).resize(function() {
                window.clearTimeout(i), i = window.setTimeout(function() {
                    r.isotope("reLayout")
                }, 50)
            })
        }
    }
    jQuery().revolution && (jQuery.fn.cssOriginal !== undefined && (jQuery.fn.css = jQuery.fn.cssOriginal), jQuery(".fullwidthbanner").revolution({
        delay: 9e3,
        startwidth: 1e3,
        startheight: 500,
        soloArrowLeftHOffset: 20,
        soloArrowLeftVOffset: 0,
        soloArrowRightHOffset: 20,
        soloArrowRightVOffset: 0,
        onHoverStop: "on",
        fullWidth: "on",
        hideThumbs: !1,
        shadow: 0
    })), jQuery("iframe").each(function() {
        var e = jQuery(this).attr("src"),
            t = "?";
        jQuery.inArray("?", e) !== -1 && (t = "&"), jQuery(this).attr("src", e + t + "wmode=transparent")
    }), jQuery().waypoint && jQuery("body").imagesLoaded(function() {
        jQuery(".animate_afc, .animate_afl, .animate_afr, .animate_aft, .animate_afb, .animate_wfc, .animate_hfc, .animate_rfc, .animate_rfl, .animate_rfr").waypoint(function() {
            if (!jQuery(this).hasClass("animate_start")) {
                var e = jQuery(this);
                setTimeout(function() {
                    e.addClass("animate_start")
                }, 20)
            }
        }, {
            offset: "85%",
            triggerOnce: !0
        })
    });
    var s = !1,
        o = function() {
            var e = parseInt(jQuery(window).scrollTop(), 10),
                t = jQuery(window).height() - 0,
                n = jQuery(window).width() - 0;
            e >= t ? jQuery(".w-toplink").addClass("active") : jQuery(".w-toplink").removeClass("active");
            if (jQuery(".l-canvas").hasClass("headerpos_fixed")) {
                var r, i;
                e > 0 && n > 1023 ? (jQuery(".l-header").hasClass("state_sticky") || jQuery(".l-header").addClass("state_sticky"), jQuery(".l-canvas").hasClass("headertype_extended") && (e > 40 ? (r = Math.max(76 - e, 0), jQuery(".l-subheader.at_top").css({
                    height: r + "px",
                    overflow: "hidden"
                })) : jQuery(".l-subheader.at_top").css({
                    height: "",
                    overflow: ""
                })), i = Math.max(Math.round(90 - e), 50), jQuery(".l-subheader.at_middle").css({
                    height: i + "px",
                    "line-height": i + "px"
                })) : (jQuery(".l-header").hasClass("state_sticky") && jQuery(".l-header").removeClass("state_sticky"), jQuery(".l-subheader.at_middle").css({
                    height: "",
                    "line-height": ""
                }), jQuery(".l-subheader.at_top").css({
                    height: "",
                    overflow: ""
                }))
            }
        };
    o(), jQuery(window).scroll(function() {
        s !== !1 && window.clearTimeout(s), s = window.setTimeout(function() {
            o()
        }, 5)
    }), jQuery(window).resize(function() {
        s !== !1 && window.clearTimeout(s), s = window.setTimeout(function() {
            o()
        }, 5)
    }), jQuery(".w-toplink").click(function(e) {
        e.preventDefault(), e.stopPropagation(), jQuery.smoothScroll({
            scrollTarget: "#"
        })
    })
});
