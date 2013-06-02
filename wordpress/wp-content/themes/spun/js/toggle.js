jQuery( document ).ready( function( $ ) {

	// Submenu highlighting
	$("ul.sub-menu").closest("li").addClass('parent');
	$(".main-navigation ul.children").closest("li").addClass('parent');

	var $comments = $( '#content' );

	// Toggle comments on
	$( '.comments-link' ).unbind( 'click' ).click( function() {

		$('html,body').animate( { scrollTop: $("#comments-toggle").offset().top },'slow' );
		$comments.find( '#comments' ).slideToggle( 'ease' );
		$(this).toggleClass( 'toggled-on' );

	} );

	var $sidebar = $( '#main' );

	// Toggle sidebar on
	$( '.sidebar-link' ).unbind( 'click' ).click( function() {
		$( 'html,body' ).animate( { scrollTop: $( "#secondary" ).offset().top },'slow' );
		$sidebar.find( '#secondary' ).slideToggle( 'ease' );
		$(this).toggleClass( 'toggled-on' );
		if ( $(this).hasClass( 'toggled-on' ) )
			$(this).text( '-' );
		else
			$(this).text( '+' );
	} );

	//Toggle the the main navigation menu for small screens.
	var $masthead = $( '#masthead' ),
	    timeout = false;

	$.fn.smallMenu = function() {
		$masthead.find( '.site-navigation' ).removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
		$masthead.find( '.site-navigation h1' ).removeClass( 'assistive-text' ).addClass( 'menu-toggle' );

		$( '.menu-toggle' ).unbind( 'click' ).click( function() {
			$masthead.find( '.menu' ).slideToggle( 'ease' );
			$( this ).toggleClass( 'toggled-on' );
		} );
	};

	// Check viewport width on first load.
	if ( $( window ).width() < 600 )
		$.fn.smallMenu();

	// Check viewport width when user resizes the browser window.
	$( window ).resize( function() {
		var browserWidth = $( window ).width();

		if ( false !== timeout )
			clearTimeout( timeout );

		timeout = setTimeout( function() {
			if ( browserWidth < 600 ) {
				$.fn.smallMenu();
			} else {
				$masthead.find( '.site-navigation' ).removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
				$masthead.find( '.site-navigation h1' ).removeClass( 'menu-toggle' ).addClass( 'assistive-text' );
				$masthead.find( '.menu' ).removeAttr( 'style' );
			}
		}, 200 );
	} );
} );