$(function () {
    "use strict";
    $(function () {
        $(".preloader").fadeOut()
    }), jQuery(document).on("click", ".mega-dropdown", function (i) {
        i.stopPropagation()
    });
    var i = function () {
        var i = window.innerWidth > 0 ? window.innerWidth : this.screen.width,
                e = 70;
        1170 > i ? ($("body").addClass("mini-sidebar"), $(".navbar-brand span").hide(), $(".sidebartoggler i").addClass("ti-menu")) : ($("body").removeClass("mini-sidebar"), $(".navbar-brand span").show(), $(".sidebartoggler i").removeClass("ti-menu"));
        var s = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1;
        s -= e, 1 > s && (s = 1), s > e && $(".page-wrapper").css("min-height", s + "px")
    };
    $(window).ready(i), $(window).on("resize", i), $(".sidebartoggler").on("click", function () {
        $("body").hasClass("mini-sidebar") ? ($("body").trigger("resize"), $(".scroll-sidebar, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible"), $("body").removeClass("mini-sidebar"), $(".navbar-brand span").show(), $(".sidebartoggler i").addClass("ti-menu")) : ($("body").trigger("resize"), $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"), $("body").addClass("mini-sidebar"), $(".navbar-brand span").hide(), $(".sidebartoggler i").removeClass("ti-menu"))
    }), $(".fix-header .topbar").stick_in_parent({}), $(".nav-toggler").click(function () {
        $("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"), $(".nav-toggler i").addClass("mdi mdi-close")
    }), $(".search-box a, .search-box .app-search .srh-btn").on("click", function () {
        $(".app-search").toggle(200)
    }), $(".right-side-toggle").click(function () {
        $(".right-sidebar").slideDown(50), $(".right-sidebar").toggleClass("shw-rside")
    }), $(".floating-labels .form-control").on("focus blur", function (i) {
        $(this).parents(".form-group").toggleClass("focused", "focus" === i.type || this.value.length > 0)
    }).trigger("blur"), $(function () {
        for (var i = window.location, e = $("ul#sidebarnav a").filter(function () {
            return this.href == i
        }).addClass("active").parent().addClass("active"); ; ) {
            if (!e.is("li"))
                break;
            e = e.parent().addClass("in").parent().addClass("active")
        }
    }), $(function () {
        $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'})
    }), $(function () {
        $('[data-toggle="popover"]').popover({trigger : 'hover'})
    }), $(function () {
        $("#sidebarnav").metisMenu()
    }), $(".message-center").slimScroll({
        position: "right",
        size: "5px",
        color: "#dcdcdc"
    }), $(".aboutscroll").slimScroll({
        position: "right",
        size: "5px",
        height: "80",
        color: "#dcdcdc"
    }), $(".message-scroll").slimScroll({
        position: "right",
        size: "5px",
        height: "570",
        color: "#dcdcdc"
    }), $(".chat-box").slimScroll({
        position: "right",
        size: "5px",
        height: "470",
        color: "#dcdcdc"
    }), $(".slimscrollright").slimScroll({
        height: "100%",
        position: "right",
        size: "5px",
        color: "#dcdcdc"
    }), $("body").trigger("resize"), $(".list-task li label").click(function () {
        $(this).toggleClass("task-done")
    }), $("#to-recover").on("click", function () {
        $("#loginform").slideUp(), $("#recoverform").fadeIn()
    }), $('a[data-action="collapse"]').on("click", function (i) {
        i.preventDefault(), $(this).closest(".card").find('[data-action="collapse"] i').toggleClass("ti-minus ti-plus"), $(this).closest(".card").children(".card-body").collapse("toggle")
    }), $('a[data-action="expand"]').on("click", function (i) {
        i.preventDefault(), $(this).closest(".card").find('[data-action="expand"] i').toggleClass("mdi-arrow-expand mdi-arrow-compress"), $(this).closest(".card").toggleClass("card-fullscreen")
    }), $('a[data-action="close"]').on("click", function () {
        $(this).closest(".card").removeClass().slideUp("fast")
    })
});