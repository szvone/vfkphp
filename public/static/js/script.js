"use strict";
$(document).ready(function() {

    // card js start
    $(".card-header-right .close-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function() {
            $this.parents('.card').remove();
        }, 800);
    });
    $(".card-header-right .reload-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').addClass("card-load");
        $this.parents('.card').append('<div class="card-loader"><i class="fa fa-spinner rotate-refresh"></div>');
        setTimeout(function() {
            $this.parents('.card').children(".card-loader").remove();
            $this.parents('.card').removeClass("card-load");
        }, 3000);
    });
    $(".card-header-right .card-option .fa-chevron-left").on('click', function() {
        var $this = $(this);
        if ($this.hasClass('fa-chevron-right')) {
            $this.parents('.card-option').animate({
                'width': '35px',
            });
        } else {
            $this.parents('.card-option').animate({
                'width': '190px',
            });
        }
        $(this).toggleClass("fa-chevron-right").fadeIn('slow');
    });
    $(".card-header-right .minimize-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("fa-minus").fadeIn('slow');
        $(this).toggleClass("fa-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("fa-window-restore");
    });

    $(".card-header-right .icofont-spinner-alt-5").on('mouseenter mouseleave', function() {
        $(this).toggleClass("rotate-refresh").fadeIn('slow');
    });
    $("#more-details").on('click', function() {
        $(".more-details").slideToggle(500);
    });
    $(".mobile-options").on('click', function() {
        $(".navbar-container .nav-right").slideToggle('slow');
    });
    $(".search-btn").on('click', function() {
        $(".main-search").addClass('open');
        $('.main-search .form-control').animate({
            'width': '200px',
        });
    });
    $(".search-close").on('click', function() {
        $('.main-search .form-control').animate({
            'width': '0',
        });
        setTimeout(function() {
            $(".main-search").removeClass('open');
        }, 300);
    });
    // $(".header-notification").on('click', function() {
    //     $(this).children('.show-notification').slideToggle(500);
    //     $(this).toggleClass('active');
    //
    // });


    $(document).ready(function(){
        $(".header-notification").click(function(){
            $(this).find(".show-notification").slideToggle(500);
            $(this).toggleClass('active');
        });
    });
    $(document).on("click", function(event){
        var $trigger = $(".header-notification");
        if($trigger !== event.target && !$trigger.has(event.target).length){
            $(".show-notification").slideUp(300);
            $(".header-notification").removeClass('active');
        }
    });

    // card js end
    $.mCustomScrollbar.defaults.axis = "yx";
    $("#styleSelector .style-cont").slimScroll({
        setTop: "1px",
        height:"calc(100vh - 495px)",
    });
    $(".main-menu").mCustomScrollbar({
        setTop: "1px",
        setHeight: "calc(100% - 56px)",
    });
    /*chatbar js start*/
    /*chat box scroll*/
    var a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5,
        color: '#1b8bf9'
    });

    // search
    $("#search-friends").on("keyup", function() {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function() {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    // open chat box
    $('.displayChatbox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat').toggle('slide', options, 500);
    });

    //open friend chat
    $('.userlist-box').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
    });
    //back to main chatbar
    $('.back_chatBox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    $('.back_friendlist').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.p-chat-user').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    // /*chatbar js end*/
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
});
$(document).ready(function() {
    // $(".theme-loader").animate({
    //     opacity: "0"
    // },1000);
    // setTimeout(function() {
    //     $(".theme-loader").remove();
    // }, 800);
});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;

    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}

/* --------------------------------------------------------
        Color picker - demo only
        --------------------------------------------------------   */
$('#styleSelector').append('' +
    '<div class="selector-toggle">' +
        '<a href="javascript:void(0)"></a>' +
    '</div>' +
    '<ul>' +
        '<li>' +
            '<p class="selector-title main-title st-main-title"><b>Gradient </b>able Customizer</p>' +
            '<span class="text-muted">Live customizer with tons of options</span>'+
        '</li>' +
        '<li>' +
            '<p class="selector-title">Main layouts</p>' +
        '</li>' +
        '<li>' +
            '<div class="theme-color">' +
                '<a href="#" data-toggle="tooltip" title="light Sidebar" class="navbar-theme" navbar-theme="themelight1"><span class="head"></span><span class="cont"></span></a>' +
                '<a href="#" data-toggle="tooltip" title="Dark Sidebar" class="navbar-theme" navbar-theme="theme1"><span class="head"></span><span class="cont"></span></a>' +
                '<a href="#" data-toggle="tooltip" title="Sidebar with image" class="Layout-type" layout-type="img"><span class="head"></span><span class="cont"></span></a>' +
                '<a href="#" data-toggle="tooltip" title="light Layout" class="Layout-type" layout-type="light"><span class="head"></span><span class="cont"></span></a>' +
                '<a href="#" data-toggle="tooltip" title="Dark Layout" class="Layout-type" layout-type="dark"><span class="head"></span><span class="cont"></span></a>' +
            '</div>' +
        '</li>' +
    '</ul>' +
    '<div class="style-cont m-t-10">' +
        '<ul class="nav nav-tabs  tabs" role="tablist">' +
            '<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#sel-layout" role="tab">Layouts</a></li>' +
            '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sel-sidebar-setting" role="tab">Sidebar Settings</a></li>' +
        '</ul>' +
        '<div class="tab-content tabs">' +
            '<div class="tab-pane active" id="sel-layout" role="tabpanel">' +
                '<ul>' +
                    '<li class="theme-option">' +
                        '<div class="checkbox-fade fade-in-primary">' +
                            '<label>' +
                                '<input type="checkbox" value="false" id="theme-layout" name="vertical-item-border">' +
                                '<span class="cr"><i class="cr-icon fa fa-check txt-success"></i></span>' +
                                '<span>Box Layout - with patterns</span>' +
                            '</label>' +
                        '</div>' +
                    '</li>' +
                    '<li class="theme-option d-none" id="bg-pattern-visiblity">' +
                        '<div class="theme-color">' +
                            '<a href="#" class="themebg-pattern small" themebg-pattern="pattern1">&nbsp;</a>' +
                            '<a href="#" class="themebg-pattern small" themebg-pattern="pattern2">&nbsp;</a>' +
                            '<a href="#" class="themebg-pattern small" themebg-pattern="pattern3">&nbsp;</a>' +
                            '<a href="#" class="themebg-pattern small" themebg-pattern="pattern4">&nbsp;</a>' +
                            '<a href="#" class="themebg-pattern small" themebg-pattern="pattern5">&nbsp;</a>' +
                            '<a href="#" class="themebg-pattern small" themebg-pattern="pattern6">&nbsp;</a>' +
                        '</div>' +
                    '</li>' +
                    '<li class="theme-option">' +
                        '<div class="checkbox-fade fade-in-primary">' +
                            '<label>' +
                                '<input type="checkbox" value="false" id="sidebar-position" name="sidebar-position" checked>' +
                                '<span class="cr"><i class="cr-icon fa fa-check txt-success"></i></span>' +
                                '<span>Fixed Sidebar Position</span>' +
                            '</label>' +
                        '</div>' +
                    '</li>' +
                    '<li class="theme-option">' +
                        '<div class="checkbox-fade fade-in-primary">' +
                            '<label>' +
                                '<input type="checkbox" value="false" id="header-position" name="header-position" checked>' +
                                '<span class="cr"><i class="cr-icon fa fa-check txt-success"></i></span>' +
                                '<span>Fixed Header Position</span>' +
                            '</label>' +
                        '</div>' +
                    '</li>' +
                '</ul>' +
            '</div>' +
            '<div class="tab-pane" id="sel-sidebar-setting" role="tabpanel">' +
                '<ul>' +
                    '<li class="theme-option">' +
                        '<p class="sub-title drp-title">Menu Type</p>' +
                        '<div class="form-radio" id="menu-effect">'+
                            '<div class="radio radiofill radio-primary radio-inline" data-toggle="tooltip" title="Color icon">'+
                                '<label>'+
                                    '<input type="radio" name="radio" value="st1" onclick="handlemenutype(this.value)">'+
                                    '<i class="helper"></i><span class="micon st1"><i class="ti-home"></i></span>'+
                                '</label>'+
                            '</div>'+
                            '<div class="radio radiofill radio-success radio-inline" data-toggle="tooltip" title="simple icon">'+
                                '<label>'+
                                    '<input type="radio" name="radio" value="st2" onclick="handlemenutype(this.value)" checked="true">'+
                                    '<i class="helper"></i><span class="micon st2"><i class="ti-home"></i></span>'+
                                '</label>'+
                            '</div>'+
                        '</div>'+
                    '</li>' +
                    '<li class="theme-option">' +
                        '<p class="sub-title drp-title">SideBar Effect</p>' +
                        '<select id="vertical-menu-effect" class="form-control minimal">' +
                            '<option name="vertical-menu-effect" value="shrink">shrink</option>' +
                            '<option name="vertical-menu-effect" value="overlay">overlay</option>' +
                            '<option name="vertical-menu-effect" value="push">Push</option>' +
                        '</select>' +
                    '</li>' +
                    '<li class="theme-option">' +
                        '<p class="sub-title drp-title">Hide/Show Border</p>' +
                        '<select id="vertical-border-style" class="form-control minimal">' +
                            '<option name="vertical-border-style" value="solid">Style 1</option>' +
                            '<option name="vertical-border-style" value="dotted">Style 2</option>' +
                            '<option name="vertical-border-style" value="dashed">Style 3</option>' +
                            '<option name="vertical-border-style" value="none">No Border</option>' +
                        '</select>' +
                    '</li>' +
                    '<li class="theme-option">' +
                        '<p class="sub-title drp-title">Drop-Down Icon</p>' +
                        '<select id="vertical-dropdown-icon" class="form-control minimal">' +
                            '<option name="vertical-dropdown-icon" value="style1">Style 1</option>' +
                            '<option name="vertical-dropdown-icon" value="style2">style 2</option>' +
                            '<option name="vertical-dropdown-icon" value="style3">style 3</option>' +
                        '</select>' +
                    '</li>' +
                    '<li class="theme-option">' +
                        '<p class="sub-title drp-title">Sub Menu Drop-down Icon</p>' +
                        '<select id="vertical-subitem-icon" class="form-control minimal">' +
                            '<option name="vertical-subitem-icon" value="style1">Style 1</option>' +
                            '<option name="vertical-subitem-icon" value="style2">style 2</option>' +
                            '<option name="vertical-subitem-icon" value="style3">style 3</option>' +
                            '<option name="vertical-subitem-icon" value="style4">style 4</option>' +
                            '<option name="vertical-subitem-icon" value="style5">style 5</option>' +
                            '<option name="vertical-subitem-icon" value="style6">style 6</option>' +
                            '<option name="vertical-subitem-icon" value="style7">style 7</option>' +
                        '</select>' +
                    '</li>' +
                '</ul>' +
            '</div>' +
        '<ul>' +
            '<li>' +
                '<p class="selector-title">Header color</p>' +
            '</li>' +
            '<li>' +
                '<span class="selector-title">Dark</span>' +
            '</li>' +
            '<li class="theme-option">' +
                '<div class="theme-color">' +
                    '<a href="#" class="header-theme" header-theme="theme1" active-item-color="theme1"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="theme2" active-item-color="theme2"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="theme3" active-item-color="theme3"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="theme4" active-item-color="theme4"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="theme5" active-item-color="theme5"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="theme6" active-item-color="theme6"><span class="head"></span><span class="cont"></span></a>' +
                '</div>' +
            '</li>' +
            '<li>' +
                '<span class="selector-title">light</span>' +
            '</li>' +
            '<li class="theme-option">' +
                '<div class="theme-color">' +
                    '<a href="#" class="header-theme" header-theme="themelight1" active-item-color="theme7"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="themelight2" active-item-color="theme8"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="themelight3" active-item-color="theme9"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="themelight4" active-item-color="theme10"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="themelight5" active-item-color="theme11"><span class="head"></span><span class="cont"></span></a>' +
                    '<a href="#" class="header-theme" header-theme="themelight6" active-item-color="theme12"><span class="head"></span><span class="cont"></span></a>' +
                '</div>' +
            '</li>' +
            '<li>' +
                '<p class="selector-title">Navbar image</p>' +
            '</li>' +
            '<li class="theme-option">' +
                '<div class="theme-color">' +
                    '<a href="#" class="navbg-pattern image" navbg-pattern="img1">&nbsp;</a>' +
                    '<a href="#" class="navbg-pattern image" navbg-pattern="img2">&nbsp;</a>' +
                    '<a href="#" class="navbg-pattern image" navbg-pattern="img3">&nbsp;</a>' +
                    '<a href="#" class="navbg-pattern image" navbg-pattern="img4">&nbsp;</a>' +
                    '<a href="#" class="navbg-pattern image" navbg-pattern="img5">&nbsp;</a>' +
                '</div>' +
            '</li>' +
            '<li>' +
                '<p class="selector-title">Active link color</p>' +
            '</li>' +
            '<li class="theme-option">' +
                '<div class="theme-color">' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme1">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme2">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme3">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme4">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme5">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme6">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme7">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme8">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme9">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme10">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme11">&nbsp;</a>' +
                    '<a href="#" class="active-item-theme small" active-item-theme="theme12">&nbsp;</a>' +
                '</div>' +
            '</li>' +
            '<li>' +
                '<p class="selector-title">Menu Caption Color</p>' +
            '</li>' +
            '<li class="theme-option">' +
                '<div class="theme-color">' +
                    '<a href="#" class="leftheader-theme small" lheader-theme="theme1">&nbsp;</a>' +
                    '<a href="#" class="leftheader-theme small" lheader-theme="theme2">&nbsp;</a>' +
                    '<a href="#" class="leftheader-theme small" lheader-theme="theme3">&nbsp;</a>' +
                    '<a href="#" class="leftheader-theme small" lheader-theme="theme4">&nbsp;</a>' +
                    '<a href="#" class="leftheader-theme small" lheader-theme="theme5">&nbsp;</a>' +
                    '<a href="#" class="leftheader-theme small" lheader-theme="theme6">&nbsp;</a>' +
                '</div>' +
            '</li>' +
        '</ul>' +
    '</div>' +
'</div>' +
'<ul>'+
    '<li>' +
        '<a href="#" class="btn btn-success btn-block m-r-15 m-t-10 m-b-10">Profile</a>' +
        '<a href="http://html.codedthemes.com/gradient-able/doc" target="_blank" class="btn btn-primary btn-block m-r-15 m-t-5 m-b-10">Online Documentation</a>' +
    '</li>' +
    '<li class="text-center">' +
        '<span class="text-center f-18 m-t-15 m-b-15 d-block">Thank you for sharing !</span>' +
        '<a href="https://www.facebook.com/codedthemes" target="_blank" class="btn btn-facebook soc-icon m-b-20"><i class="fa fa-facebook"></i></a>' +
        '<a href="https://twitter.com/codedthemes" target="_blank" class="btn btn-twitter soc-icon m-l-20 m-b-20"><i class="fa fa-twitter"></i></a>' +
    '</li>' +
'</ul>'+
'');
