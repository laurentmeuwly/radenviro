var mapSamples = {

    /**
     * Object that contains all the values for points positionning
     */
    params: {
	cookieName: 'map-filters',
        latitudeTop: 47.808455,
        longitudeTop: 5.956082,
        latitudeDown: 45.817920,
        longitudeDown: 10.489140,

        zoom: 400000,
        padding: 15,

        latitudeRatio: 0,
        longitudeRatio: 0,

        latitudeZoom: 0, 
        longitudeZoom: 0
    },

    /**
     * DOM inputs
     */
    inputs: null,

    /**
     * DOM inputs for selecting all other
     */
    selectalls: null,

    /**
     * DOM objects that contains legends
     */
    legends: null,

    /**
     * Object that store legend's points
     */
    points: [],

    /**
     * Zoom's divs
     */
    zooms: null,

    /**
     * Zoomarea objects
     */
    zoomareas: [],
            
    /**
     * Initialization status
     */
    initialized: false,

    /**
     * Initialize internal DOM objects
     */
    initialize: function(params){
        if(!this.initialized){
            this.initialized = true;

            var _self = this;

            this.inputs = $('.section.samples li input[type="checkbox"]').not('.selectall');
            this.selectalls = $('.section.samples li input[type="checkbox"].selectall');
            this.legends = $('.section.samples li');
            this.zooms = $('.section.samples .zooms div');

            this.params = $.extend(this.params, params || {});

            this.inputs.change(function(){
                _self.selectalls.prop('checked', _self.inputs.filter(':checked').length == _self.inputs.length);
            });

            this.selectalls.change(function(){
                _self.inputs.prop('checked', $(this).prop('checked')).change();
            });

            // Create points for each legends
            this._buildLegends();

            // Create zoom area for each zooms
            this._buildZooms();
        }
        return this;
    },
    
    reset: function(){
        this.hideAllPoints();
        this.inputs.prop('checked', false);
        this.selectalls.prop('checked', false);
        
        this.zoomOut();
        this.hideAllZooms();
    },
    
    hideAllPoints: function(){
        $.each(this.points, function(){
            this.hide();
        });
    },
    
    hideAllZooms: function(){
        this.zooms.hide();
    },
    
    showAllZooms: function(){
        this.zooms.show();
    },
    
    selectFirst: function(){  
        this.inputs.first().prop('checked', true).change();
    },
	
    selectFromCookie: function(){
        var inputs = this.getInputsInCookie();
	if(inputs){
	    var elements = this.inputs.filter(inputs.join(','));
	    if(elements.length > 0){
	        elements.prop('checked', true).change();
		return true;
            }
	}
        return false;
    },
    
    zoomOut: function(){
        $.each(this.zoomareas, function(){
            this.zoomOut();
        });
    },

    getInputsInCookie: function(){
	var cookie = $.cookie(this.params.cookieName),
            inputs = [];
        if(cookie && cookie.substr(0,8) === 'samples:'){
            inputs = cookie.substr(8).split(',');
        }
	return inputs.filter(function(n){ return n; });
    },

    _updateCookie: function(id, checked){
        var inputs = this.getInputsInCookie(),
	    index = inputs.indexOf(id);
	if(checked && index == -1){
            inputs.push(id);
	}
	if(!checked && index >= 0){
	    delete(inputs[index]);
	}
	$.cookie(this.params.cookieName, 'samples:' + inputs.join(','));
    },
    
    _buildZooms: function(){
        var _self = this;
        
        this.zooms.each(function(){
            var zoomarea = new mapZoomArea(this, _self.params);
            _self.zoomareas.push(zoomarea);
        });
    },

    _buildLegends: function(){
        var _self = this;

        this.legends.each(function(idx){
            var legendPoints = new mapPoints(this, _self.params, {
                index: idx
            }),
            input = $(this).find('input[type="checkbox"]').first();

            // Store generated points
            _self.points.push(legendPoints);

            // Observe legend input
            input.change(function(){
                if($(this).is(':checked')){
                    // Show all zoom's area
                    _self.showAllZooms(); 
                    
                    // Reset other blocks
                    mapSites.reset();
                    mapNetworks.reset();
                    
                    legendPoints.show();
		    _self._updateCookie('#' + input.attr('id'), true);
                }else{
                    legendPoints.hide();
		    _self._updateCookie('#' + input.attr('id'), false);
                }
            });
        });
    }
};
