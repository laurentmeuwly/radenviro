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