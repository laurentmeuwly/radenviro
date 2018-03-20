var mapDatatable = {
        
	    /**
	     * DOM object that contains the whole elements
	     */
	    handler: null, 
	            
	    /**
	     * DOM object that contains datatable
	     */
	    datatable: null,
	            
	    /**
	     * DOM object that contains nature's labels
	     */
	    natures: null,
	            
	    /**
	     * DOM inputs that have legends information
	     */
	    inputs: null,
	            
	    /**
	     * DOM select that contains available nuclides
	     */
	    nuclides: null,
	            
	    /**
	     * Cache xfer call for nuclides based on legends
	     */
	    cacheForNuclides: {},
	            
	    /**
	     * Store last call based on legends to prevent 2 same call
	     */
	    lastCallKey: null,
	            
	    /**
	     * Prevent refresh being call by nuclides
	     */
	    preventRefreshingFromNuclides: false,

	    /**
	     * Initialize internal DOM objects
	     */
	    initialize: function(){
	        var _self = this;
	                
	        this.handler = $('#handler_last_result_per_station'); 
	        this.datatable = $('#datatable_last_result_per_station');
	        this.natures = $('#nature_last_result_per_station');
	        this.inputs = $('.section.samples li input[type="checkbox"]').not('.selectall');
	        this.nuclides = $('#nuclides_last_result_per_station');
	                
	        // Observe change on inputs
	        this.inputs.change(function(){
	            _self.refresh();
	        });
	                
	        // Observe change on nuclides
	        this.nuclides.change(function(){
	            if(!_self.preventRefreshingFromNuclides){
	                _self.refreshDatatable($(this).val());
	            }
	        });
	                
	        return this;
	    },
	            
	    /**
	     * Refresh the whole object
	     */
	    refresh: function(force){
	        if(this.inputs.length > 0){
	            var cInputs = this.inputs.filter(':checked'),
	            legends = [],
	            natures = [];
	            if(cInputs.length === 0 && force){
	                cInputs = $(this.inputs.get(0));
	            }
	            if(cInputs.length > 0){
	                this.show();
	                cInputs.each(function(){
	                    var _this = $(this);
	                    legends.push(_this.data('legend'));
	                    natures.push(_this.data('nature'));
	                });

	                // Store selected legend in datatable
	                this.datatable.data('legends', legends);

	                // Refresh datatable's nuclides
	                this.refreshNuclides();

	                // Refresh datatable based on legends and first available nuclide
	                this.refreshDatatable('first'); 

	                this.natures.html(natures.join(' /&nbsp;'))
	            }else{
	                // Reset stored legends
	                this.datatable.data('legends', null);
	                        
	                this.hide();
	            }
	        }
	                
	        return this;
	    },
	            
	    /**
	     * Refresh datatable based on nuclide
	     */
	    refreshDatatable: function(nuclide){
	        var legends = this.datatable.data('legends') || [];
	        if(this.isVisible() && legends.length > 0 && nuclide){
	            this.lastCallKey = legends.join(',');
	            var nparams = {
	                'url': this.datatable.data('url') + '&legends[]=' + legends.join('&legends[]=') + '&nuclide=' + nuclide
	            } 
	            //this.datatable.flexOptions(nparams);
	            //this.datatable.flexReload();
	        }
	                
	        return this;
	    },
	            
	    /**
	     * Refresh options of nuclides select
	     */
	    refreshNuclides: function(){
	        var _self = this,
	        legends = this.datatable.data('legends') || [];
	        if(this.isRefreshable() && this.isVisible() && legends.length > 0){
	            var cacheKey = '?legends[]=' + legends.join('&legends[]='),
	            options = this.cacheForNuclides[cacheKey] || false,
	            _refresh = function(options){
	                _self.preventRefreshingFromInputs = true;
	                _self.nuclides.empty();
	                var elements = '';
	                $.each(options, function(key, data){
	                    elements += '<option value="'+data.value+'">'+data.label+'</option>';
	                });
	                _self.nuclides.append(elements);
	                        
	                // TODO: Improve this call
	                nuclides_change(_self.nuclides); // External global call
	                        
	                _self.preventRefreshingFromInputs = false;
	            };
	            if(!options){
	                $.getJSON(this.nuclides.attr('data-refresh') + cacheKey, function(datas) {
	                    _self.cacheForNuclides[cacheKey] = datas;
	                    _refresh(datas);
	                });
	            }else{
	                _refresh(options);
	            }
	        }
	                
	        return this;
	    },
	    
	    /**
	     * Show the whole object
	     */
	    show: function(){
	        this.handler.show().css('visibility', 'visible');
	    },
	    
	    /**
	     * Hide the whole object
	     */
	    hide: function(){
	        this.handler.hide().css('visibility', 'hidden');
	    },
	        
	    /**
	     * Is datatable refreshable?
	     */
	    isRefreshable: function(){
	        if(this.lastCallKey !== null){
	            var legends = this.datatable.data('legends') || [];
	            if(legends.join(',') === this.lastCallKey){
	                return false;
	            }
	        }
	        return true;
	    },
	        
	        
	    /**
	     * Is datatable visible?
	     */    
	    isVisible: function(){
	        return this.handler.is(':visible');
	    }
};


var mapHandler = {
        
	    /**
	     * Object that contains all the values for points positionning
	     */
	    params: {   
	        height: 0,      
	        width: 0,
	        
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
	     * DOM object that contains images and points
	     */
	    handler: null,
	                
	    /**
	     * DOM object that contains default map image
	     */
	    image: null,
	    
	    /**
	     * DOM object that contains zoomed map image
	     */
	    zoom: null,
	    
	    /**
	     * DOM object that contains the clone button
	     */
	    closeBtn: null,
	    
	    /**
	     * Store callback done when zooming out 
	     * It's defined in ZoomIn
	     */
	    callbackOnZoomOut: null,
	                
	    /**
	     * Initialize internal DOM objects
	     */
	    initialize: function(){
	        var _self = this;
	        
	        this.handler = $('div.map div.content');
	        this.image = $('#switzerland');
	        this.zoom = $('#switzerland_zoom').css('display', 'none');
	        this.closeBtn = $('#zoom_closebtn').css('display', 'none');
	                    
	        this.closeBtn.click(function(){
	           _self.zoomOut(); 
	        });
	                    
	        // Observe image loading
	        this.image.on('load', function(){
	            _self._buildParams();
	                    
	            mapDatatable.initialize();
	            mapSamples.initialize(_self.params);
	            mapSites.initialize(_self.params);
	            mapNetworks.initialize(_self.params);
	            
	            // Select first must be called after all initialization
		    if(!mapSamples.selectFromCookie()){
	                mapSamples.selectFirst();
		    }
	        }).attr('src', this.image.data('src'));
	    },
	    
	    /**
	     * Zoom in region
	     */
	    zoomIn: function(src, callback, callbackOnZoomOut){
	        if(src && src.length > 0){
	            var _self = this;
	            this.zoom.on('load', function(){
	                _self.zoom.css({
	                    'display': 'none',
	                    'height': _self.image.height(),
	                    'position': 'absolute',
	                    'width': _self.image.width(),
	                    'z-index': 2000
	                }).fadeIn();
	                if(callback){
	                    setTimeout(function(){callback.apply();}, 10);
	                }
	                _self.closeBtn.fadeIn(); 
	            }); 
	        }
	        this.zoom.attr('src', src)
	        this.callbackOnZoomOut = callbackOnZoomOut;
	    },
	    
	    /**
	     * Zoom out region
	     */
	    zoomOut: function(callback){
	        this.zoom.off('load');
	        this.zoom.fadeOut('fast');
	        this.closeBtn.hide();
	        if(callback){
	            setTimeout(function(){callback.apply();}, 10);
	        }
	        this.handler.find('.sublocation').hide();
	        if(this.callbackOnZoomOut){
	            this.callbackOnZoomOut.apply();
	        }
	        this.callbackOnZoomOut = null;
	    },
	            
	    /**
	     * Build params based given map's width/height
	     */
	    _buildParams: function(){
	        var height = this.image.height(), 
	        width = this.image.width(), 
	        latitudeRatio = height / (this.params.latitudeTop - this.params.latitudeDown),
	        longitudeRatio = width / (this.params.longitudeDown - this.params.longitudeTop);
	        this.params = $.extend(this.params, {
	            height: height,
	            width: width,
	            latitudeRatio: latitudeRatio,
	            longitudeRatio: longitudeRatio,
	            latitudeZoom: latitudeRatio / this.params.zoom, 
	            longitudeZoom: longitudeRatio / this.params.zoom
	        });
	    }
	};

var mapPointsIndex = 0;
var mapPoints = function(reference, params, options){
    var _self = this,
    _ref = $(reference);
    
    /**
     * Increment map points global index
     */
    this.index = mapPointsIndex+1;
    mapPointsIndex++;
            
    /**
     * Object that contains all the values for location positionning
     */
    this.params = $.extend({
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
    }, params || {});
            
    /**
     * Object that contains different option
     */
    this.options = $.extend({
        locationClassName: 'location',
        click: function(){
            var _this = $(this),
            link = _this.data('link') || false,
            target = _this.data('link-target') || false;
            if(link){
                switch(target){
                    case '_blank':
                        window.open(link);
                        break;
                    default:
                        window.location = link;
                        break;
                }
            }
        },
        hide: function(){},
        locationPositionning: function(positions, icon, ref){
            return {
                left: ref.params.padding + ((positions[1] - ref.params.longitudeTop) * ref.params.longitudeRatio) - (icon.width() / 2),
                top: ref.params.padding + ((ref.params.latitudeTop - positions[0]) * ref.params.latitudeRatio) - (icon.height() / 2)
            }
        },
        additionalPositionningParams: []
    }, options || {});
    
    /**
     * DOM object that contains map
     */
    this.map = $('div.map div.content');
            
    /**
     * Array of all locations
     */
    this.locations = _ref.find('span.' + this.options.locationClassName);
            
    /**
     * Store location's build status
     */
    this.locationsBuilded = false
            
    /**
     * Store location's build process status
     */
    this.locationsBuilding = false
            
    /**
     * Asynchrone location building
     */
    setTimeout(function(){
        if(!this.locationsBuilding && !_self.locationsBuilded){
            _self._buildLocations();
        }
    }, 700+(this.index * 200));
};
        
/**
 * Show all locations
 */
mapPoints.prototype._buildLocations = function(){
    var _self = this;
    if(!this.locationsBuilding && !this.locationsBuilded){
        this.locationsBuilding = true;
        this.locations.hide().each(function(){
            var location = $(this),
            icon = $('#' + location.data('icon')),
            latitude = location.data('latitude'),
            longitude = location.data('longitude'),
            positions = [latitude,longitude];
            location.data('positions', positions);
            location.css($.extend(
            {
                cursor: 'pointer'
            }, 
            _self.options.locationPositionning.apply(location, $.merge([positions, icon, _self], _self.options.additionalPositionningParams ))
                )).append(icon.clone()).appendTo(_self.map);
            location.qtip({
                content:{
                    text: location.find('span.text').html() || '&nbsp;',
                    title:{
                        text: location.find('span.title').html()
                    }
                },
                style: {
                    classes: 'qtip-blue qtip-shadow'
                },
                hide: { 
                    delay: 400,
                    fixed: true,
                    when:{
                        event: 'mouseout'
                    }
                }
            });
            if(_self.options.click){
                location.click(_self.options.click);
            }
        });
        this.locationsBuilding = false;
        this.locationsBuilded = true;
    }
            
}; 

/**
 * Show all locations
 */
mapPoints.prototype.show = function(){
    if(!this.locationsBuilding && !this.locationsBuilded){
        this._buildLocations();
    }
    this.locations.fadeIn();
};

/**
 * Hide all locations
 */
mapPoints.prototype.hide = function(){
    this.locations.hide();
    if(this.options.hide){
        var _self = this;
        this.locations.each(function(){
            var location = $(this);
            setTimeout(function(){
                _self.options.hide.apply(location);
            }, 10);
        });
    }
}

/**
 * Hide all locations
 */
mapPoints.prototype.getLocation = function(id){
    return this.locations.filter('#'+id);
}

var mapZoomArea = function(reference, params){
    var _ref = $(reference),
    _self = this;
            
    /**
     * Object that contains all the values for location positionning
     */
    this.params = $.extend({
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
    }, params || {});
    
    /**
     * Zoom bounds
     */
    this.bounds = $.extend({},{
        east: _ref.data('elongitude'),
        north: _ref.data('nlatitude'),
        south: _ref.data('slatitude'),
        west: _ref.data('wlongitude'),
        latitudeRatio: this.params.height / (_ref.data('nlatitude') - _ref.data('slatitude')),
        longitudeRatio: this.params.width / (_ref.data('elongitude') - _ref.data('wlongitude'))
    });
    
    /**
     * Static Google Map
     */
    this.staticmap = 'http://www.radenviro.ch/staticmap/api/staticmap?center='+_ref.data('latitude')+','+_ref.data('longitude')+'&zoom='+_ref.data('zoom')+'&size=430x290&maptype=roadmap&sensor=false&key=AIzaSyDK6w895niOatsoaOFyiihNCuRnvGiA6gA'
    
    /**
     * DOM object that contains map
     */
    this.map = $('div.map div.content');
    
    /**
     * Locations
     */
    this.locations = [];
    
    /**
     * Store zoom status
     */
    this.zoomed = false;
    
    /**
     * Append zoom area to map
     */
    var bottom = this.params.padding + ((this.params.latitudeTop - this.bounds.south) * this.params.latitudeRatio),
    left = this.params.padding + ((this.bounds.west - this.params.longitudeTop) * this.params.longitudeRatio),
    right = this.params.padding + ((this.bounds.east - this.params.longitudeTop) * this.params.longitudeRatio),
    top = this.params.padding + ((this.params.latitudeTop - this.bounds.north) * this.params.latitudeRatio);
    _ref.css({
        left: left,
        height: bottom - top,
        top: top,
        width: right - left
    }).click(function(){
        _self.zoomIn();
    });
    this.map.append(_ref);
};

mapZoomArea.prototype.restoreLocationPosition = function(location){
    var _location = $(location),
    left = _location.data('original-left'),
    top = _location.data('original-top');
    _location.css({
        left: left,
        top: top,
        'z-index': 1050
    });
};

mapZoomArea.prototype.setLocationPosition = function(location){
    var _self = this,
    _location = $(location),
    left = _location.data('zoom-left'),
    top = _location.data('zoom-top');
    if(!left && !top){
        var latitude = _location.data('latitude'),
        longitude = _location.data('longitude'),
        icon = $('#' + _location.data('icon'));
        left = _self.params.padding + ((longitude - _self.bounds.west) * _self.bounds.longitudeRatio) - (icon.width() / 2);
        top = _self.params.padding + ((_self.bounds.north - latitude) * _self.bounds.latitudeRatio) - (icon.height() / 2);
        _location.data('zoom-left', left);
        _location.data('zoom-top', top);
    }
    _location.css({
        left: left,
        top: top,
        'z-index': 2050
    });
};

mapZoomArea.prototype.zoomIn = function(){
    var _self = this;
    
    this.zoomOut();
    mapHandler.zoomIn(this.staticmap,function(){
        if(_self.locations.length === 0){
            _self.map.find('.location.samples').each(function(){
                var _this = $(this),
                latitude = _this.data('latitude'),
                longitude = _this.data('longitude');
                if(latitude >= _self.bounds.south && latitude <= _self.bounds.north && longitude >= _self.bounds.west && longitude <= _self.bounds.east){
                    _self.locations.push(this);
                    _this.data('original-left', _this.css('left'));
                    _this.data('original-top', _this.css('top'));
                    _self.setLocationPosition(this);
                }
            });
        }else{
            $.each(_self.locations, function(){
                _self.setLocationPosition(this);
            });
        }
        _self.map.find('.zoomarea').hide();
    }, function(){
        $.each(_self.locations, function(){
            _self.restoreLocationPosition(this);
        });
        _self.map.find('.zoomarea').show();
    });
    
    this.zoomed = true;
};

mapZoomArea.prototype.zoomOut = function(){
    if(this.zoomed){
        var _self = this;
        $.each(this.locations, function(){
            _self.restoreLocationPosition(this);
        });
        _self.map.find('.zoomarea').show();
        mapHandler.zoomOut();
    } 
    this.zoomed = false;
};

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
	                    var googleStaticMap = 'http://www.radenviro.ch/staticmap/api/staticmap?center=' + location.data('latitude') + ',' + location.data('longitude') + '&zoom=' + location.data('zoom') + '&size=430x290&maptype=roadmap&sensor=false&key=AIzaSyDK6w895niOatsoaOFyiihNCuRnvGiA6gA';
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
	                    mapDatatable.hide();
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
	                    mapDatatable.hide();
	                    mapSamples.reset();
	                    mapSites.reset();
	                    
	                    _self.hideAllPoints();
	                    categoryPoints.show();
	                }
	            });
	        });
	    }
	};

var advancedSearchHandler = function() {
    var _self = this;
    this.networks = $('.advsearch_environments select');
    this.stations = $('.advsearch_stations select');
    this.stationsHandler = $('.advsearch_stations');
    this.nuclides = $('.advsearch_nuclides option');
    this.nuclidesSelect = $('.advsearch_nuclides select');
    this.nuclidesHandler = $('.advsearch_nuclides');
    this.submits = $('.advsearch_submits input');
    this.submitsHandler = $('.advsearch_submits');
    
    this.nuclides.each(function(){
        var _this = $(this);
        var stations = _this.data('stations') || '0';
        try{
            _this.data('estations', stations.split(','));
        }catch(e){
            _this.data('estations', []);
        }
    });
    
    var selectedUrl = '';
    var baseUrl = _self.nuclidesHandler.data('url') + '/';

    var hideStations = function() {
        _self.stationsHandler.hide();
        _self.stations.hide().find('option').prop('selected', false).attr('selected', false);
        return _self;
    };

    var hideNuclides = function() {
        _self.nuclidesHandler.hide();
        _self.nuclides.hide().prop('selected', false).attr('selected', false);
        return _self;
    };

    var showStation = function(classname) {
        if (classname.length > 0) {
            _self.stationsHandler.show();
            _self.stations.filter('.' + classname).show();
            _self.stations.not('.' + classname).hide().find('option').prop('selected', false).attr('selected', false);
            _self.nuclides.hide().prop('selected', false).attr('selected', false);
        } else {
            hideStations();
            hideNuclides();
        }
        return _self;
    };

    var showNuclid = function(id) {
        if (id.length > 0) {
            _self.nuclidesHandler.show();
            _self.nuclides.filter(function(){
                return $(this).data('estations').indexOf(id) >= 0;
            }).show();
            _self.nuclides.filter(function(){
                return $(this).data('estations').indexOf(id) < 0;
            }).hide().find('option').prop('selected', false).attr('selected', false);
        } else {
            hideNuclides();
        }
        return _self;
    };
    
    var resetSubmits = function(){
        _self.submitsHandler.hide();
        selectedUrl = '';
    };
    
    this.submits.click(function(){
        if(selectedUrl.length > 0){
            window.location = selectedUrl + '#' + $(this).data('anchor');
        }
    });
    this.nuclidesSelect.change(function() {
        if (selectedUrl.length > 0) {
            _self.submitsHandler.show();
        }
    });
    this.stations.change(function() {
        resetSubmits();
        var selected = $(this).find('option:selected');
        var url = selected.data('url') || '';
        if (url.length > 0) {
            window.location = $(this).find('option:selected').data('url');
        } else {
            var val = selected.val() || '';
            if(val.length > 0){
                showNuclid(val);
                selectedUrl = baseUrl + val;
            }
        }
    });
    this.networks.change(function() {
        showStation($(this).find('option:selected').data('stations') || '');
        resetSubmits();
    });

    var selectedNetwork = this.networks.find('option:selected');
    var selectedNetworkStation = selectedNetwork.data('stations') || '';
    if(selectedNetworkStation.length > 0){
        var selectedStation = this.stations.filter('.' + selectedNetworkStation);
        showStation(selectedNetwork.data('stations') || '');
        if (selectedStation.length > 0) {
            var val = selectedStation.find('option:selected').val() || '';
            if(val.length > 0){
                showNuclid(val);
                selectedUrl = baseUrl + val;
            }
        }
    }
};





// Handle main map 

(function($){
    $(document.body).ready(function(){
        // Initialize map
        mapHandler.initialize();
        
        // Initialize advanced search
        new advancedSearchHandler();
    });
})(jQuery);
