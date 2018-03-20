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
    this.staticmap = 'http://www.radenviro.ch/staticmap/api/staticmap?center='+_ref.data('latitude')+','+_ref.data('longitude')+'&zoom='+_ref.data('zoom')+'&size=430x290&maptype=roadmap&sensor=false'
    
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
