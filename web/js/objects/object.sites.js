var mapSites = {
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
     * DOM object that contains detailed sites
     */
    selects: null,
    /**
     * DOM objects that contains site's categories
     */
    categories: null,
    /**
     * Object that store site's points
     */
    points: [],
    /**
     * Store zoom status
     */
    zoomed: false,
    /**
     * Initialization status
     */
    initialized: false,
    /**
     * Initialize internal DOM objects
     */
    initialize: function(params) {
        if(!this.initialized){
            this.initialized = true;

            this.inputs = $('.section.sites li input[type="radio"]');
            this.selects = $('.section.sites select');
            this.categories = $('.section.sites li');

            this.params = $.extend(this.params, params || {});

            // Create points for each legends
            this._buildCategories();
        }
        return this;
    },
    selectFromCookie: function(){
        var input = this.getInputInCookie();
        if(input){
            var element = this.inputs.filter(input);
            if(element.length > 0){
                elements.prop('checked', true).change();
                return true;
            }
        }
        return false;
    },
    getInputInCookie: function(){
        var cookie = $.cookie(this.params.cookieName);
        if(cookie && cookie.substr(0,6) === 'sites:'){
            return cookie.substr(6);
        }else{
            return '';
        }
    },
    _updateCookie: function(id){
        $.cookie(this.params.cookieName, 'sites:' + id);
    },
    reset: function() {
        this.hideAllPoints();
        this.selects.hide();
        this.inputs.first().prop('checked', true);
        if (this.zoomed) {
            mapHandler.zoomOut();
        }
    },
    hideAllPoints: function() {
        $.each(this.points, function() {
            this.hide();
        });
    },
    _buildCategories: function() {
        var _self = this;

        this.categories.each(function() {
            var input = $(this).find('input[type="radio"]').first(),
                    select = _self.selects.filter('#' + input.attr('id') + '_sites'),
                    categoryPoints = new mapPoints(this, _self.params, {
                click: function() {
                    var location = $(this);
                    var bounds = {
                        east: location.data('elongitude'),
                        north: location.data('nlatitude'),
                        south: location.data('slatitude'),
                        west: location.data('wlongitude'),
                        latitudeRatio: _self.params.height / (location.data('nlatitude') - location.data('slatitude')),
                        longitudeRatio: _self.params.width / (location.data('elongitude') - location.data('wlongitude'))
                    };
                    var googleStaticMap = 'http://www.radenviro.ch/staticmap/api/staticmap?center=' + location.data('latitude') + ',' + location.data('longitude') + '&zoom=' + location.data('zoom') + '&size=430x290&maptype=roadmap&sensor=false';
                    mapHandler.zoomOut();
                    mapHandler.zoomIn(googleStaticMap, function() {
                        var sublocations = location.data('sublocations');
                        if (!sublocations) {
                            sublocations = new mapPoints(location, _self.params, {
                                locationClassName: 'sublocation',
                                locationPositionning: function(positions, icon, ref, parentPositions) {
                                    return {
                                        left: ref.params.padding + ((positions[1] - bounds.west) * bounds.longitudeRatio) - (icon.width() / 2),
                                        top: ref.params.padding + ((bounds.north - positions[0]) * bounds.latitudeRatio) - (icon.height() / 2)
                                    }
                                },
                                additionalPositionningParams: [location.data('positions')]
                            });
                            location.data('sublocations', sublocations);
                        }
                        sublocations.show();
                        select.val(location.data('id'));
                    }, function() {
                        select.find('option').first().prop('selected', true);
                        _self.zoomed = false;
                    });
                    _self.zoomed = true;
                },
                hide: function() {
                    var sublocations = this.data('sublocations');
                    if (sublocations) {
                        sublocations.hide();
                    }
                }
            });

            // Observe select change for zooming
            select.change(function() {
                var location = categoryPoints.getLocation('location_site_' + $(this).val());
                if (location.length > 0) {
                    location.click();
                }
            });

            // Store generated points
            _self.points.push(categoryPoints);

            // Observe legend input
            input.change(function() {
                if ($(this).is(':checked')) {

                    // Reset other blocks
                    mapHandler.zoomOut();
                    mapDatagrid.hide();
                    mapSamples.reset();
                    mapNetworks.reset();

                    _self.hideAllPoints();
                    categoryPoints.show();

                    _self.selects.hide();
                    select.show();
		    _self._updateCookie('#' + input.attr('id'));
                }
            });
        });
    }
};
