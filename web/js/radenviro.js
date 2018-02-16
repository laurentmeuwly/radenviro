
jQuery(function() {
	
	// load graph page by changing the station
	$('select.stations').change(function() {
	    var url = $(this).find('option:selected').data('url') || '';
	    if (url.length > 0) {
	        window.location = $(this).find('option:selected').data('url');
	    }
	});
	
	// Set datepickers
    /*$('input.datepicker').datepicker({
        dateFormat: 'dd.mm.yy'
    });*/
    
	//eval('var params = ' + (graphNuclides.attr('data-refresh') || '{}'));
	
	$('select.nuclides').change(function() {
	});
	
    var googleRefresh = function(url, station, nuclide) {
        $.getJSON(url + '?nuclide=' + nuclide + '&jsoncallback=?', {}, function(data) {
        	
        });
        
    };
    
});