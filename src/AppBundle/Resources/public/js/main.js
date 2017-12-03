// Handle main map 
//
//= require main/object.datagrid
//= require main/object.map
//= require main/object.points
//= require main/object.zoomarea
//= require main/object.samples
//= require main/object.sites
//= require main/object.networks
//= require main/object.advancedsearch

(function($){
    $(document.body).ready(function(){
        // Initialize map
        mapHandler.initialize();
        
        // Initialize advanced search
        new advancedSearchHandler();
    });
})(jQuery);
