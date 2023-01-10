$('.form-control.is-invalid').on('keyup', function() {
	$(this).removeClass('is-invalid');
});

$(window).on( "load", function() {
    $("#content-loader").fadeOut();
});
