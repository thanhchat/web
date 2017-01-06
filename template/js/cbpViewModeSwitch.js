/**
 * cbpViewModeSwitch.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
(function() {
	function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        var expires = "; expires=" + date.toUTCString();
    }
    else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name,"",-1);
	}
	var default_view = 'grid'; // choose the view to show by default (grid/list)
	
    // check the presence of the cookie, if not create "view" cookie with the default view value
    if(!readCookie('viewp')){
        createCookie('viewp', default_view, 7);
    }
	
	var container = document.getElementById( 'cbp-vm' ),
		optionSwitch = Array.prototype.slice.call( container.querySelectorAll( 'div.cbp-vm-options > a' ) );

	function init() {
		if(readCookie('viewp') == 'list'){ 
			optionSwitch.forEach( function( el, i ) {
				if(el.id=='grid'){
						classie.remove( container, el.getAttribute( 'data-view' ) );
						classie.remove( el, 'cbp-vm-selected' );
				}
					// add the view class for this option
				if(el.id=='list'){
					classie.add( container, el.getAttribute( 'data-view' ) );
						// this option stays selected
					classie.add( el, 'cbp-vm-selected' );
				}
			} );
		} 

		if(readCookie('viewp')== 'grid'){ 
			optionSwitch.forEach( function( el, i ) {
				if(el.id=='list'){
						classie.remove( container, el.getAttribute( 'data-view' ) );
						classie.remove( el, 'cbp-vm-selected' );
				}
				if(el.id=='grid'){
					classie.add( container, el.getAttribute( 'data-view' ) );
					// this option stays selected
					classie.add( el, 'cbp-vm-selected' );
				}
			} );
		}
		optionSwitch.forEach( function( el, i ) {
			el.addEventListener( 'click', function( ev ) {
				ev.preventDefault();
				_switch( this );
				new WOW().init();
			}, false );
		} );
	}

	function _switch( opt ) {
		// remove other view classes and any any selected option
		if(opt.id=='list'){
			createCookie('viewp', 'list',7); 
			optionSwitch.forEach(function(el) { 
				if(el.id=='grid'){
					classie.remove( container, el.getAttribute( 'data-view' ) );
					classie.remove( el, 'cbp-vm-selected' );
				}
				if(el.id=='list'){
					classie.add( container, el.getAttribute( 'data-view' ) );
					classie.add( el, 'cbp-vm-selected' );
				}
			});
		}
		if(opt.id=='grid'){
			createCookie('viewp', 'grid',7);
			optionSwitch.forEach(function(el) { 
				if(el.id=='list'){
					classie.remove( container, el.getAttribute( 'data-view' ) );
					classie.remove( el, 'cbp-vm-selected' );
				}
				if(el.id=='grid'){
					classie.add( container, el.getAttribute( 'data-view' ) );
					classie.add( el, 'cbp-vm-selected' );
				}
			});
		}
		// add the view class for this option
	}
	
	init();
	

})();