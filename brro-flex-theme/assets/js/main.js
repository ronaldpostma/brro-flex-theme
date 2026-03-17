jQuery(function($) {
    console.log('Brro Flex Theme loaded.');
    var body = $('body');
    var html = $('html');
    var screen = $(window);
    var screenPosition = screen.scrollTop();
    var footer = $('footer');
	var header = $('header');
    // Expire localStorage brro_mode after 12 hours
    var BRRO_MODE_KEY = 'brro_mode';
    var BRRO_MODE_TS_KEY = 'brro_mode_ts';
    var BRRO_MODE_TTL_MS = 12 * 60 * 60 * 1000; // 12 hours
    (function brro_expire_mode_if_needed() {
        try {
            var ts = parseInt(localStorage.getItem(BRRO_MODE_TS_KEY), 10);
            if (!ts || isNaN(ts)) { return; }
            if (Date.now() - ts >= BRRO_MODE_TTL_MS) {
                localStorage.removeItem(BRRO_MODE_KEY);
                localStorage.removeItem(BRRO_MODE_TS_KEY);
            }
        } catch (e) {}
    })();
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
    
    function brro_check_if_in_viewport_aboutus() {
        var viewport = brro_calc_viewport();
        var sections = [
            { el: $('#over-ons-section'), nav: $('.secondary-nav li:first-of-type a') },
            { el: $('#klanten'), nav: $('.secondary-nav li:nth-of-type(2) a') },
            { el: $('#contact'), nav: $('.secondary-nav li:last-of-type a') }
        ];
        var maxVisible = 0;
        var maxIndex = -1;
        for (var i = 0; i < sections.length; i++) {
            var s = sections[i];
            var amount = s.el.brroViewportAmount(viewport.top, viewport.bottom);
            if (amount > maxVisible) {
                maxVisible = amount;
                maxIndex = i;
            }
        }
        // Reset all
        $('.secondary-nav a').removeClass('current-section-visible');
        // Set only the most-visible one (if any visible)
        if (maxIndex !== -1 && maxVisible > 0) {
            sections[maxIndex].nav.addClass('current-section-visible');
        }
    }
    brro_check_if_in_viewport_aboutus()
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
        screenPosition >= 1 && screen.scrollTop() > screenPosition
            ? header.addClass('brro-headerup')
            : header.removeClass('brro-headerup')
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
    // Smooth scroll to anchor
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.hash);
        if (target.length) {
            event.preventDefault();
            console.log('Smooth scrolling to anchor:', target.offset().top);
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 600);
        }
    });
    //
    //
    //
    //
    // Header click max/min toggle
    function handleMaxMinToggle(event) {
        // Respond to click, or keydown with Enter/Space
        if (
            event.type === 'click' ||
            (event.type === 'keydown' && (event.key === 'Enter' || event.key === ' '))
        ) {
            // Only prevent default for keyboard so the button remains accessible
            if (event.type === 'keydown') event.preventDefault();
            if (html.hasClass('max-mode')) {
                console.log('Switching from max-mode to min-mode');
                html.removeClass('max-mode');
                html.addClass('min-mode');
                localStorage.setItem('brro_mode', 'min');
                try { localStorage.setItem('brro_mode_ts', String(Date.now())); } catch (e) {}
                console.log('Set brro_mode to min in localStorage:', localStorage.getItem('brro_mode'));
            } else {
                console.log('Switching from min-mode to max-mode');
                html.addClass('max-mode');
                html.removeClass('min-mode');
                localStorage.setItem('brro_mode', 'max');
                try { localStorage.setItem('brro_mode_ts', String(Date.now())); } catch (e) {}
                console.log('Set brro_mode to max in localStorage:', localStorage.getItem('brro_mode'));
            }
        }
    }
    $(document).on('click', '#max-min-toggle .toggle', handleMaxMinToggle);
    $(document).on('keydown', '#max-min-toggle .toggle', handleMaxMinToggle);
    //
    //
    //
    //
    // Click or Enter on alle info button
    function brro_handle_info_box_action(event) {
        // This handler is for both click and keyboard
        // Allow click, or Enter/Space key if keydown
        if (event.type === 'click' || (
            (event.type === 'keydown') && 
            (event.key === 'Enter' || event.key === ' ')
        )) {
            // Only prevent default on keyboard event so button works for a form if needed
            if (event.type === 'keydown') event.preventDefault();
            localStorage.setItem('brro_load_transition', 'true');
            console.log('Setting brro_load_transition to true');
            $('html').addClass('start-exit-transition');
            setTimeout(function() {
                window.location.href = '/alle-info';
            }, 600);
            setTimeout(function() {
                $('html').removeClass('start-exit-transition');
                $('html').addClass('finish-transition');
            }, 1600);
        }
    }
    $(document).on('click', '#info-box, #over-ons-btn', brro_handle_info_box_action);
    $(document).on('keydown', '#info-box, #over-ons-btn', brro_handle_info_box_action);
	// Back navigation: rely on native navigation; ensure transition classes are reset
	$(window).on('popstate', function() {
		$('html').removeClass('start-exit-transition');
		$('html').addClass('finish-transition');
	});
    //
    //
    //
    //
    // Track scroll distance for min-height active state
    let minHeightActiveScrollPosition = 0;
    let wasMinHeightActive = false;
    
    // Cache computed values for performance
    let cachedLoadedHeight = null;
    let cachedMinHeight = null;

    // Resize header on scroll
    function brro_resize_header() {
		const header = document.querySelector('header');
        if (!header) return;
        const actualScrolled = window.pageYOffset || document.documentElement.scrollTop;
        let scrolled = actualScrolled;
        if (scrolled > 650) scrolled = 650;
		// Cache computed min-height only when needed (on resize or first run)
		if (!cachedMinHeight) {
			const computedStyle = getComputedStyle(header);
			cachedMinHeight = parseFloat(computedStyle.minHeight);
		}
		const minHeightPx = cachedMinHeight;
		// Compute intended height using a persistent hidden probe inside the header
		let probe = header.querySelector('#brro-header-probe');
		if (!probe) {
			probe = document.createElement('div');
			probe.id = 'brro-header-probe';
			probe.setAttribute('aria-hidden', 'true');
			header.appendChild(probe);
		}
		// Ensure the probe inherits the same CSS variables from header
		const headerComputed = getComputedStyle(header);
		const loadedVar = headerComputed.getPropertyValue('--loaded-height');
		if (loadedVar) probe.style.setProperty('--loaded-height', loadedVar.trim());
		// Set the height calc we want to measure for the current scroll
		probe.style.height = 'calc(var(--loaded-height) - ' + scrolled + 'px)';
		const intendedHeight = parseFloat(getComputedStyle(probe).height);
		// Check if min-height constraint would be active
		const minHeightActive = intendedHeight < minHeightPx;
        
        // set scrolled height
        header.style.setProperty('--scrolled-height', scrolled + 'px');
        // At this point, the header height is set based on the current scroll position,
        // so if the user loads the page halfway down, the header will be sized correctly.
        //
        // Handle min-height active state and scroll distance tracking
        if (minHeightActive) {
            header.classList.add('brro-min-height-active');
            // Set the scroll position when min-height becomes active
            if (!wasMinHeightActive) {
                minHeightActiveScrollPosition = actualScrolled;
                wasMinHeightActive = true;
            }
            // Calculate distance scrolled from min-height activation point using actual scroll
            const scrollDistance = actualScrolled - minHeightActiveScrollPosition;
            // Only apply translateY if scrolled < 650
            header.style.setProperty('--slogan-translate', `-${scrollDistance}px`);
        } else {
            header.classList.remove('brro-min-height-active');
            // Reset when min-height is no longer active
            minHeightActiveScrollPosition = 0;
            wasMinHeightActive = false;
            header.style.setProperty('--slogan-translate', '0px');
        }
        if (scrolled === 650) {
            header.style.setProperty('--slogan-display', 'none');
        } else {
            header.style.setProperty('--slogan-display', 'revert');
        }
    }
    
    // Initial call
    brro_resize_header();
    
    // Update on scroll
    window.addEventListener('scroll', brro_resize_header);
    //
    //
    // GROUP ALL RESIZE AND SCROLL FUNCTIONS
    function brro_run_on_scroll() {
        brro_stickyheader();
        brro_check_if_in_viewport_aboutus();
        //brro_back_to_top();
        // Clear cached values on scroll
        cachedLoadedHeight = null;
        cachedMinHeight = null;
    }
    
    function brro_run_on_resize() {
        // Clear cached values on resize
        brro_check_if_in_viewport_aboutus();
        brro_stickyheader();
        //brro_back_to_top();
        cachedLoadedHeight = null;
        cachedMinHeight = null;
    }
    // LISTEN AND EXECUTE RESIZE AND SCROLL FUNCTIONS
    screen.on('scroll', window.brro_throttle_scroll(brro_run_on_scroll, 25));
    //
    //
    //
    //
    // Click function exmaple
    //$(document).on('click', '#some-trigger', function() {
        // do something
    //});
    
    // Project popup: open, close, URL param handling, and load content via AJAX
    function brro_open_popup() {
        var $popup = $('#project-popup');
        // Cancel any pending clear if reopening quickly
        var pending = $popup.data('brroClearTimeout');
        if (pending) { clearTimeout(pending); $popup.removeData('brroClearTimeout'); }
        $popup.css('z-index', 9999).addClass('is-open');
    }
    function brro_close_popup() {
        var $popup = $('#project-popup');
        $popup.removeClass('is-open');
        // Delay clearing content so slide-out can finish
        var timeoutId = setTimeout(function() {
            $('#project-popup-content').empty();
            $('#project-popup').css('z-index', -1);
            $popup.removeData('brroClearTimeout');
        }, 800);
        $popup.data('brroClearTimeout', timeoutId);
        // Remove project param from URL
        brro_clear_project_from_url();
    }
    function brro_set_project_in_url(projectId, orientation) {
        try {
            var url = new URL(window.location.href);
            url.searchParams.set('project', String(projectId));
            var ori = brro_sanitize_orientation(orientation);
            if (ori) {
                url.searchParams.set('orientation', ori);
            } else {
                url.searchParams.delete('orientation');
            }
            window.history.pushState({ projectId: projectId }, '', url);
        } catch (e) {}
    }
    function brro_clear_project_from_url() {
        try {
            var url = new URL(window.location.href);
            if (url.searchParams.has('project')) {
                url.searchParams.delete('project');
                url.searchParams.delete('orientation');
                window.history.replaceState({}, '', url);
            }
        } catch (e) {}
    }
    function brro_sanitize_orientation(orientation) {
        var o = (orientation || '').toString().toLowerCase();
        if (o === 'ver' || o === 'hor') { return o; }
        return '';
    }
    function brro_apply_gallery_orientation(orientation) {
		var o = brro_sanitize_orientation(orientation);
		var $popup = $('#project-popup');
		if (!$popup.length) { return; }
		$popup.removeClass('ver hor');
		if (o) { $popup.addClass(o); }
    }
    function brro_fetch_and_open_project(projectId, galleryOrientation) {
        if (!projectId) { return; }
        brro_open_popup();
        $('#project-popup-content').html('<div c="loading acumin size-20-30 medium"">Project wordt geladen…</div>');
        if (!window.brro_ajax || !window.brro_ajax.ajax_url || !window.brro_ajax.nonce) {
            $('#project-popup-content').html('<p class="loadingacumin size-20-30 medium">Er ging iets mis, probeer de pagina te herladen.</p>');
            return;
        }
        $.post(window.brro_ajax.ajax_url, {
            action: 'brro_project_popup',
            nonce: window.brro_ajax.nonce,
            project_id: projectId,
            gallery_orientation: galleryOrientation || ''
        }).done(function(res) {
            if (res && res.success && res.data && res.data.html) {
                $('#project-popup-content').html(res.data.html);
                brro_apply_gallery_orientation(galleryOrientation);
                brro_init_project_gallery_interactions();
            } else {
                $('#project-popup-content').html('<p class="loading acumin size-20-30 medium">Er ging iets mis, probeer de pagina te herladen.</p>');
            }
        }).fail(function() {
            $('#project-popup-content').html('<p class="loading acumin size-20-30 medium">Er ging iets mis, probeer de pagina te herladen.</p>');
        });
    }
    
    $(document).on('click', 'button[pop_id^="project_popup_"]', function(e) {
        e.preventDefault();
        var idStr = $(this).attr('pop_id') || '';
        var projectId = parseInt(idStr.replace('project_popup_', ''), 10);
        if (!projectId) { return; }
        var galleryOrientation = $(this).attr('data-gallery-orientation') || '';
        brro_set_project_in_url(projectId, galleryOrientation);
        brro_fetch_and_open_project(projectId, galleryOrientation);
    });
    
    // Close interactions
    $(document).on('click', '#project-popup', function(e) {
        if ($(e.target).is('#project-popup')) { brro_close_popup(); }
    });
    $(document).on('click', '#project-popup-content .project-popup-close', function() {
        brro_close_popup();
    });
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') { brro_close_popup(); }
    });

    // Auto-open from URL on load
    (function() {
        try {
            var url = new URL(window.location.href);
            var projectParam = url.searchParams.get('project');
            var projectId = projectParam ? parseInt(projectParam, 10) : 0;
            var oParam = url.searchParams.get('orientation') || '';
            var orientation = brro_sanitize_orientation(oParam);
            if (projectId) {
                brro_fetch_and_open_project(projectId, orientation);
            }
        } catch (e) {}
    })();

    // Sync popup state on browser navigation
    $(window).on('popstate', function() {
        try {
            var url = new URL(window.location.href);
            var projectParam = url.searchParams.get('project');
            var projectId = projectParam ? parseInt(projectParam, 10) : 0;
            var oParam = url.searchParams.get('orientation') || '';
            var orientation = brro_sanitize_orientation(oParam);
            if (projectId) {
                brro_fetch_and_open_project(projectId, orientation);
            } else {
                brro_close_popup();
            }
        } catch (e) {}
    });

    
    // Functions and actions to make the .project-gallery draggable via click/touch > drag
	function brro_enable_gallery_drag($el) {
        var el = $el.get(0);
        if (!el) { return; }
        var isDown = false;
        var startX = 0;
        var startY = 0;
        var scrollLeftStart = 0;
        var scrollTopStart = 0;
		var $popup = $el.closest('#project-popup');
		var isHor = $popup.hasClass('hor');
		var isVer = $popup.hasClass('ver');
        var dragged = false;
        function brro_gallery_drag_allowed() {
            return window.matchMedia('(min-width: 1180px)').matches;
        }

        function beginDrag(clientX, clientY) {
            if (!brro_gallery_drag_allowed()) { return; }
            isDown = true;
            dragged = false;
            startX = clientX;
            startY = clientY;
            scrollLeftStart = $el.scrollLeft();
            scrollTopStart = $el.scrollTop();
        }

        function dragTo(clientX, clientY) {
            if (!isDown) { return; }
            if (!brro_gallery_drag_allowed()) {
                endDrag();
                return;
            }
            var dx = clientX - startX;
            var dy = clientY - startY;
            if (!dragged && (Math.abs(dx) > 2 || Math.abs(dy) > 2)) {
                dragged = true;
                $el.addClass('dragging');
            }
			// Re-read orientation in case it changed dynamically
			isHor = $popup.hasClass('hor');
			isVer = $popup.hasClass('ver');
			if (isHor) { $el.scrollLeft(scrollLeftStart - dx); }
			if (isVer) { $el.scrollTop(scrollTopStart - dy); }
            if (!isHor && !isVer) {
                $el.scrollLeft(scrollLeftStart - dx);
                $el.scrollTop(scrollTopStart - dy);
            }
        }

        function endDrag() {
            isDown = false;
            $el.removeClass('dragging');
        }

        // Pointer Events (preferred)
        if (window.PointerEvent) {
            el.addEventListener('pointerdown', function(e) {
                if (e.button !== undefined && e.button !== 0) { return; }
                if (!brro_gallery_drag_allowed()) { return; }
                el.setPointerCapture && el.setPointerCapture(e.pointerId);
                beginDrag(e.clientX, e.clientY);
            });
            el.addEventListener('pointermove', function(e) {
                if (!isDown) { return; }
                if (!brro_gallery_drag_allowed()) {
                    endDrag();
                    return;
                }
                if (e.cancelable) { e.preventDefault(); }
                dragTo(e.clientX, e.clientY);
            });
            el.addEventListener('pointerup', function(e) {
                endDrag();
            });
            el.addEventListener('pointercancel', function() { endDrag(); });
            el.addEventListener('pointerleave', function() { endDrag(); });
        } else {
            // Mouse fallback
            $el.on('mousedown', function(e) {
                if (e.button !== 0) { return; }
                if (!brro_gallery_drag_allowed()) { return; }
                beginDrag(e.clientX, e.clientY);
                $(document).on('mousemove.brroGallery', function(ev) {
                    if (ev.cancelable) { ev.preventDefault(); }
                    dragTo(ev.clientX, ev.clientY);
                });
                $(document).on('mouseup.brroGallery', function() {
                    $(document).off('mousemove.brroGallery mouseup.brroGallery');
                    endDrag();
                });
            });
            // Touch fallback with passive: false
            el.addEventListener('touchstart', function(e) {
                if (e.cancelable) { e.preventDefault(); }
                if (!brro_gallery_drag_allowed()) { return; }
                var t = e.touches && e.touches[0];
                if (!t) { return; }
                beginDrag(t.clientX, t.clientY);
            }, { passive: false });
            el.addEventListener('touchmove', function(e) {
                if (!isDown) { return; }
                if (e.cancelable) { e.preventDefault(); }
                var t = e.touches && e.touches[0];
                if (!t) { return; }
                dragTo(t.clientX, t.clientY);
            }, { passive: false });
            el.addEventListener('touchend', function() { endDrag(); }, { passive: true });
            el.addEventListener('touchcancel', function() { endDrag(); }, { passive: true });
        }

        // Suppress click after a drag so images/links don't trigger
        $el.on('click', function(e) {
            if (dragged) {
                e.preventDefault();
                e.stopImmediatePropagation();
                dragged = false;
            }
        });

        // Prevent native dragstart from images, videos, or other draggable content inside
        $el.find('*').attr('draggable', 'false');
        $el.on('dragstart', function(e) { e.preventDefault(); });
    }

	function brro_bind_gallery_wheel($el) {
        // Convert vertical wheel to horizontal scroll for horizontal galleries
		if (!$el.closest('#project-popup').hasClass('hor')) { return; }
        $el.on('wheel', function(e) {
            if (!window.matchMedia('(min-width: 1180px)').matches) { return; }
            // Allow shift+wheel native behavior, otherwise translate vertical delta to horizontal
            if (!e.shiftKey) {
                e.preventDefault();
                var delta = e.originalEvent.deltaY || e.originalEvent.wheelDeltaY || 0;
                var dx = e.originalEvent.deltaX || 0;
                var step = delta + dx;
                this.scrollLeft += step;
            }
        });
    }

    function brro_init_project_gallery_interactions() {
        var $galleries = $('#project-popup-content .project-gallery');
        if (!$galleries.length) { return; }
        $galleries.each(function() {
            var $el = $(this);
            // Avoid rebinding
            if (!$el.data('brroGalleryBound')) {
                brro_enable_gallery_drag($el);
                brro_bind_gallery_wheel($el);
                $el.data('brroGalleryBound', true);
            }
        });
    }
});