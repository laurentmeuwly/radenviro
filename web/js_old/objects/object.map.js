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
        this.image.load(function(){
            _self._buildParams();
                    
            mapDatagrid.initialize();
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
            this.zoom.load(function(){
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
