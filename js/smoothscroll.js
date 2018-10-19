console.log('Smooth Scroll Initialized.');

if(typeof jQuery == 'undefined'){
    document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>');
}

jQuery(document).ready(function($) {
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {
            var target = $(this.hash);
            
            var headerHeight = 0;
            console.log(headerHeight);
            
            if(smoothScrollData.headerID !=='') {
                headerHeight += $('#' + smoothScrollData.headerId + '').outerHeight(); // Get fixed header height
                console.log(headerHeight);
            }
            
            if(smoothScrollData.offsetAmount == '') {
                smoothScrollData.offsetAmount = 50
            }
            
            var offset = parseInt(smoothScrollData.offsetAmount);
            
            headerHeight += offset; // Offset
            console.log(headerHeight);
            
            if(smoothScrollData.adminBar) {
                headerHeight += $('#wpadminbar').outerHeight(); // Add Admin Bar Height
                console.log(headerHeight);
            }

            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top - headerHeight
                }, 500);

                return false;
            }
        }
    });
});