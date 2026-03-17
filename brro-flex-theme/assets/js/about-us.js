jQuery(function($) {
    var homeUrl = (typeof brro_aboutus !== 'undefined' && brro_aboutus.home_url) ? brro_aboutus.home_url : null;
    if (homeUrl) {
        console.log('Loaded home_url from localization:', homeUrl);
    } else {
        console.warn('brro_aboutus.home_url is not defined');
    }
    var previousPage = document.referrer;
    console.log('Previous page (referrer):', previousPage);
    
    var referrerIsHome = previousPage === homeUrl;
    console.log('Referrer is homepage:', referrerIsHome);
    if (referrerIsHome) {
        //localStorage.setItem('brro_transition', 'true');
        //console.log('Setting brro_transition to true');
    }
    $(document).on('click', '#back', function(e) {
        if (homeUrl) {
            e.preventDefault();
            localStorage.setItem('brro_load_transition', 'true');
            console.log('Setting brro_load_transition to true');
            $('html').addClass('start-exit-transition');
            setTimeout(function() {
                window.location.href = homeUrl;
            }, 600);
            setTimeout(function() {
                $('html').removeClass('start-exit-transition');
                $('html').addClass('finish-transition');
            }, 1200);
        } else {
            return;
        }
    });
	// Back navigation: rely on native navigation; ensure transition classes are reset
	$(window).on('popstate', function() {
		$('html').removeClass('start-exit-transition');
		$('html').addClass('finish-transition');
	});
});