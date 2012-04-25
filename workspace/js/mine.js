$(document).ready(function(){
    // Hover for the price to show popup
    var popupDelay = 200;
    $(".item figure a.product-link-price").hover(function(){
        //console.log("mouse-in");
        var popup = $(this).parent().parent().find(".popup").show();
        var popupArrow = $(this).parent().parent().find(".popup .pointer").show();
        popup.animate({ opacity: 1, top: "0px"}, popupDelay);
        popupArrow.animate({ opacity: 1, top: "0px"}, popupDelay);
    }, function(){
        var popup = $(this).parent().parent().find(".popup");
        var popupArrow = $(this).parent().parent().find(".popup .pointer").show();
        popup.animate({ opacity: 0, top: "-50px"}, popupDelay);
        popupArrow.animate({ opacity: 0, top: "-50px"}, popupDelay);
    });

    //making footer tabs
    $(".tabs a[data-toggle=tab]").click(function(){
        var anchor = $(this).attr("id");
        var parentLi = $(this).parent();
        //console.log(parentLi);
        var linkedTab = $(this).parent().parent().parent().find(".tab-content #"+anchor);
        var otherTabs = linkedTab.parent().find(".tab-pane");
        var otherLis = parentLi.parent().find("li").removeClass("active");

        parentLi.toggleClass("active");
        otherTabs.hide();
        linkedTab.toggle();
        return false;
    });

    //Let's make aside height and section height equal;
    var aside = $("aside.blok-catalog-category-wrapper");
    var section = $("section.blok-catalog-wrapper");
    if (aside.height() > section.height()) {
        section.height(aside.height());
    }

    //Taht shit used to activate first tab in header and footer
    $('ul.nav-tabs').each(function(){
        $(this).find('li a:first').trigger("click");
    });

    //Toggling custom dropdown
    //$('.dropdown-toggle').dropdown();
    $('.dropdown-toggle').click(function(e){
        e.preventDefault();
        $(".dropdown-menu").hide();
        $(this).parent().find(".dropdown-menu").toggle();
    });

    // Custom dropwodn in detail product page
    $(".additional-content .nav-pills li.dropdown ul.dropdown-menu a").click(function(){
        var parentLi = $(this).parent().parent().parent("li").toggleClass("hidden");
        var link = $(this).attr("id");
        var choosenLi = $(".additional-content .nav-pills li.dropdown#"+link).toggleClass("hidden");
        return false;
    });

    //Extending existing HTML-classes, which validator can understand, by the phone class.
    

    // jQuery Validate плагин
    $("#place-order").validate({
        submitHandler: function(form) {
            $(form).ajaxSubmit(options);
        },
        focusInvalid: false,
        focusCleanup: true
    });

    //Making custom placeholders
    $('input[placeholder], textarea[placeholder]').placeholder();
});