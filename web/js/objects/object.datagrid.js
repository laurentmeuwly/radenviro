
var mapDatagrid = {
            
    /**
     * DOM object that contains the whole elements
     */
    handler: null, 
            
    /**
     * DOM object that contains datagrid
     */
    datagrid: null,
            
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
                
        this.handler = $('#handler_5_last_result'); 
        this.datagrid = $('#datagrid_5_last_result');
        this.natures = $('#nature_5_last_result');
        this.inputs = $('.section.samples li input[type="checkbox"]').not('.selectall');
        this.nuclides = $('#nuclides_5_last_result');
                
        // Observe change on inputs
        this.inputs.change(function(){
            _self.refresh();
        });
                
        // Observe change on nuclides
        this.nuclides.change(function(){
            if(!_self.preventRefreshingFromNuclides){
                _self.refreshDatagrid($(this).val());
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

                // Store selected legend in datagrid
                this.datagrid.data('legends', legends);

                // Refresh datagrid's nuclides
                this.refreshNuclides();

                // Refersh datagrid based on legends and first available nuclide
                this.refreshDatagrid('first'); 

                this.natures.html(natures.join(',&nbsp;'))
            }else{
                // Reset stored legends
                this.datagrid.data('legends', null);
                        
                this.hide();
            }
        }
                
        return this;
    },
            
    /**
     * Refresh datagrid based on nuclide
     */
    refreshDatagrid: function(nuclide){
        var legends = this.datagrid.data('legends') || [];
        if(this.isVisible() && legends.length > 0 && nuclide){
            this.lastCallKey = legends.join(',');
            var nparams = {
                'url': this.datagrid.data('url') + '&legends[]=' + legends.join('&legends[]=') + '&nuclide=' + nuclide
            } 
            this.datagrid.flexOptions(nparams);
            this.datagrid.flexReload();
        }
                
        return this;
    },
            
    /**
     * Refresh options of nuclides select
     */
    refreshNuclides: function(){
        var _self = this,
        legends = this.datagrid.data('legends') || [];
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
     * Is datagrid refreshable?
     */
    isRefreshable: function(){
        if(this.lastCallKey !== null){
            var legends = this.datagrid.data('legends') || [];
            if(legends.join(',') === this.lastCallKey){
                return false;
            }
        }
        return true;
    },
        
        
    /**
     * Is datagrid visible?
     */    
    isVisible: function(){
        return this.handler.is(':visible');
    }
};