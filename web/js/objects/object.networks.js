var mapNetworks = {

    /**
     * Object that contains all the values for points positionning
     */
    params: {
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
     * DOM objects that contains network's categories
     */
    categories: null,

    /**
     * Object that store site's points
     */
    points: [],
            
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
            this.inputs = $('.section.automatic_network_stations li input[type="radio"]');
            this.categories = $('.section.automatic_network_stations li');

            this.params = $.extend(this.params, params || {});

            // Create points for each legends
            this._buildCategories();
        }
        return this;
    },
    
    reset: function(){
        this.hideAllPoints();
        this.inputs.first().prop('checked', true);
    },
    
    hideAllPoints: function(){
        $.each(this.points, function(){
            this.hide();
        });
    },

    _buildCategories: function(){
        var _self = this;

        this.categories.each(function(){
            var input = $(this).find('input[type="radio"]').first(),
            categoryPoints = new mapPoints(this, _self.params);
            
            // Store generated points
            _self.points.push(categoryPoints);

            // Observe legend input
            input.change(function(){
                if($(this).is(':checked')){
                    
                    // Reset other blocks
                    mapDatagrid.hide();
                    mapSamples.reset();
                    mapSites.reset();
                    
                    _self.hideAllPoints();
                    categoryPoints.show();
                }
            });
        });
    }
};