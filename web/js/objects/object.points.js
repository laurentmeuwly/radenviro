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