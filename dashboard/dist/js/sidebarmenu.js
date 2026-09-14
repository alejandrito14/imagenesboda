/*
Template Name: Admin Template
Author: Wrappixel

File: js
*/
// ============================================================== 
// Auto select left navbar
// ============================================================== 
$(function() {
    "use strict";
     var url = window.location + "";
        var path = url.replace(window.location.protocol + "//" + window.location.host + "/", "");
        var element = $('ul#sidebarnav a').filter(function() {
            return this.href === url || this.href === path;// || url.href.indexOf(this.href) === 0;
        });
        element.parentsUntil(".sidebar-nav").each(function (index)
        {
            if($(this).is("li") && $(this).children("a").length !== 0)
            {
                $(this).children("a").addClass("active");
                $(this).parent("ul#sidebarnav").length === 0
                    ? $(this).addClass("active")
                    : $(this).addClass("selected");
            }
            else if(!$(this).is("ul") && $(this).children("a").length === 0)
            {
                $(this).addClass("selected");
                
            }
            else if($(this).is("ul")){
                $(this).addClass('in');
            }
            
        });

    element.addClass("active");

    // Estado inicial del acordeón: todo cerrado excepto el módulo predeterminado.
    var defaultItem = $('#sidebarnav > li.default-open').first();
    var topLevelItems = $('#sidebarnav > li');
    var submenuGroups = topLevelItems.children('ul.first-level');

    submenuGroups.removeClass('in show').attr('aria-expanded', 'false').hide();
    topLevelItems.not(defaultItem).removeClass('selected active');
    topLevelItems.not(defaultItem).children('a.has-arrow').removeClass('active').attr('aria-expanded', 'false');

    if (defaultItem.length) {
        defaultItem.addClass('selected');
        defaultItem.children('a.has-arrow').addClass('active').attr('aria-expanded', 'true');
        defaultItem.children('ul.first-level').addClass('in').attr('aria-expanded', 'true').show();
    }

    $('#sidebarnav a').on('click', function (e) {
        
            if (!$(this).hasClass("active")) {
                // hide any open menus and remove all other classes
                $("ul", $(this).parents("ul:first")).removeClass("in");
                $("a", $(this).parents("ul:first")).removeClass("active");
                
                // open our new menu and add the open class
                $(this).next("ul").addClass("in").attr('aria-expanded', 'true').show();
                $(this).addClass("active").attr('aria-expanded', 'true');
                
            }
            else if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(this).parents("ul:first").removeClass("active");
                $(this).next("ul").removeClass("in").attr('aria-expanded', 'false').hide();
                $(this).attr('aria-expanded', 'false');
            }
    })
    $('#sidebarnav >li >a.has-arrow').on('click', function (e) {
        e.preventDefault();
    });
    
});
