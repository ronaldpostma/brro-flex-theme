jQuery(function($) {
    console.log('Brro Flex Theme loaded.');
    var body = $('body');
    var html = $('html');
    var screen = $(window);
    var screenPosition = screen.scrollTop();
    var footer = $('footer');
    var header = $('header');
    // GLOBAL HELPER FUNCTIONS
    //
    //
    // CHECK IF *ELEMENT IS IN VIEWPORT - REMOVE IF NOT USED
    $.fn.brroViewport = function(viewportTop, viewportBottom) {
        //var elementTop = $(this).offset().top;
        var element = $(this);
        var elementTop = element.length ? element.offset().top : 0;
        var elementBottom = elementTop + $(this).outerHeight();
        return elementBottom > viewportTop && elementTop < viewportBottom;
    };
    // Amount of vertical pixels of the element currently inside the viewport
    $.fn.brroViewportAmount = function(viewportTop, viewportBottom) {
        var element = $(this);
        if (!element.length) { return 0; }
        var elementTop = element.offset().top;
        var elementBottom = elementTop + element.outerHeight();
        var visibleTop = Math.max(elementTop, viewportTop);
        var visibleBottom = Math.min(elementBottom, viewportBottom);
        var overlap = visibleBottom - visibleTop;
        return overlap > 0 ? overlap : 0;
    };
    // Helper function to get the viewport boundaries set at top of functions with "var viewport = brro_calc_viewport();"
    function brro_calc_viewport() { 
        var top = screen.scrollTop();
        var bottom = top + screen.height();
        return { top, bottom };
    }
    //
    //
    //
    //
    // THROTTLE TO LIMIT CALLS ON SCROLL, USED IN SCROLL FUNCTIONS - DON'T REMOVE
    window.brro_throttle_scroll = function(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    };
    //
    //
    //
    //
    //
    // ON PAGE LOAD: HEADER MANIPULATIONS
    // ADD STICKY MADE UP EFFECTS CLASS
    function brro_sticky_header_effects() {
        if (screen.scrollTop() >= 20) {
            header.addClass('brro-sticky-effects');
            if (body.hasClass('home')) {
                // Do something to the logo if needed
            }
        } else {
            header.removeClass('brro-sticky-effects');
            if (body.hasClass('home')) {
                // Revert doing something to the logo if needed
            }
        }
    }
    brro_sticky_header_effects();
    // ON SCROLL: HEADER MANIPULATIONS
    function brro_stickyheader() {
        // ADD STICKY MADE UP EFFECTS CLASS
        brro_sticky_header_effects();
        // MAKE HEADER GO UP AND DOWN CLASS
        if (screenPosition >= 1 && screen.scrollTop() > screenPosition) {
            header.addClass('brro-headerup');
        } else {
            header.removeClass('brro-headerup');
        }
        screenPosition = screen.scrollTop();
    }
    //
    //
    //
    //
    //
    //
    $(document).on('click', 'a#to-top', function() {
        let attempts = 0;
        const interval = setInterval(function() {
            if (header.hasClass('brro-sticky-effects') || attempts >= 8) {
                header.removeClass('brro-sticky-effects');
                clearInterval(interval);
            }
            attempts++;
        }, 200);
    });
    //
    //
    //
    //
    // Smooth scroll to anchor (skip href="#" and invalid hashes)
    $('a[href^="#"]').on('click', function(event) {
        var href = this.getAttribute('href');
        if (!href || href === '#' || href.length < 2) {
            return;
        }
        var target = $(href);
        if (!target.length) {
            return;
        }
        event.preventDefault();
        console.log('Smooth scrolling to anchor:', target.offset().top);
        $('html, body').animate({
            scrollTop: target.offset().top
        }, 600);
    });
    //
    //
    // GROUP ALL RESIZE AND SCROLL FUNCTIONS
    function brro_run_on_scroll() {
        brro_stickyheader();
        //brro_back_to_top();
    }
    
    function brro_run_on_resize() {
        // Clear cached values on resize
        brro_stickyheader();
        //brro_back_to_top();
    }
    // LISTEN AND EXECUTE RESIZE AND SCROLL FUNCTIONS
    screen.on('scroll', window.brro_throttle_scroll(brro_run_on_scroll, 25));
    screen.on('resize', window.brro_throttle_scroll(brro_run_on_resize, 100));
});