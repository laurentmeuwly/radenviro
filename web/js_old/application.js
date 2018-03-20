// This is a manifest file that'll be compiled into application.js, which will include all the files
// listed below.
//
// Any JavaScript/Coffee file within this directory, lib/assets/javascripts, vendor/assets/javascripts,
// or vendor/assets/javascripts of plugins, if any, can be referenced here using a relative path.
//
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// the compiled file.
//
// WARNING: THE FIRST BLANK LINE MARKS THE END OF WHAT'S TO BE PROCESSED, ANY BLANK LINE SHOULD
// GO AFTER THE REQUIRES BELOW.
//
//= require "sprintf-0.7"
//= require jquery
//= require jquery_ujs
//= require "jquery.browser.min"
//= require "jquery.ui.min"
//= require "jquery.qtip.min"
//= require "jquery.ticker"
//= require "jquery.flexigrid.min"
//= require "jquery.cookie"

var nuclides_change = function() {
};
(function($) {
    $(window).load(function() {

        // Initialize tabs
        $('div.tabs').each(function() {
            var _this = $(this);
	    
            setTimeout(function() {
                _this.tabs({
                    create: function(event, ui) {
                        if(ui.panel){
                            var panel = $(ui.panel).css('visibility', 'visible');
                            // Loading graph or table once at creation
                            if (panel.is('#measures-graph.measures-graph') && $.type(loadingGraph) === 'function') {
                                loadingGraph();
                                loadingGraph = null;
                            }
                            if (panel.is('#measures-table.measures-table') && $.type(loadingTable) === 'function') {
                                loadingTable();
                                loadingTable = null;
                            }
                        }
                    },
                    activate: function(event, ui) {
                        if(ui.newPanel){
                            var panel = $(ui.newPanel).css('visibility', 'visible');
			    console.log([
				panel.is('#measures-graph.measures-graph'),
				$.type(loadingGraph) === 'function'
				]);
                            // Loading graph or table once at first tab selection
                            if (panel.is('#measures-graph.measures-graph')) {
				if($.type(loadingGraph) === 'function'){
				    loadingGraph();
				    loadingGraph = null;
				    filterUpdated = false;
				}else if(filterUpdated){
				    $('select.nuclides-graph:first').change();
			    	    filterUpdated = false;
				}
                            }
                            if (panel.is('#measures-table.measures-table')) {
				if($.type(loadingTable) === 'function'){			
                                    loadingTable();
	                            loadingTable = null;
				    filterUpdated = false;
				}else if(filterUpdated){
				    $('select.nuclides-table:first').change();
			    	    filterUpdated = false;
				}
                            }
                        }
                    }
                }).css('visibility', 'visible');
            }, 100);
        });
    });

    $(document.body).ready(function() {
        // Initialize tickers
        $('.ticker').ticker();


        // Initialize datagrids
        $('table.datagrid').each(function() {
            var _this = $(this),
                    thead = _this.find('thead'),
                    colModel = [];
            eval('var params = ' + (_this.attr('data-params') || '{}'));

            thead.find('th').each(function() {
                var _this = $(this),
                        name = _this.attr('class'),
                        sortable = _this.attr('data-sortable') ? true : false,
                        hidden = _this.attr('data-hidden') ? true : false;

                colModel.push({
                    display: _this.html(),
                    name: name,
                    width: _this.width() - 12,
                    sortable: sortable,
                    showTableToggleBtn: true,
                    align: _this.css('text-align'),
                    hide: hidden
                });
            });

            thead.detach();
            _this.flexigrid($.extend(params, {
                colModel: colModel
            })).css('width', 'auto');
        });

        // Set height of static page iframe
        $('iframe.static-page').each(function() {
            var _this = $(this),
                    setHeight = function() {
                _this.height($(window).height() - _this.offset().top - 5);
            };
            setHeight();
            $(window).resize(setHeight);
        });

        // Make all nuclides select change in same time and save value in cookie
        var nuclides_selects = $('select.nuclides');
        nuclides_selects.each(function(){
            var _this = $(this);
            var nuclides_cookie = $.cookie(_this.data('cookie') || 'nuclide');
            if (nuclides_cookie !== undefined && nuclides_cookie) {
                _this.val(nuclides_cookie);
                if(_this.find('option:selected').length === 0){
                    _this.find('option:first').prop('selected', true).attr('selected', true);
                }
            }
        });
        nuclides_change = function(el) {
            var _this = $(el);
            _this.change(function() {
                nuclides_selects.not(_this).each(function() {
                    var _select = $(this).val(_this.val());
                    if (_select.hasClass('nuclides-table')) {
                        loadingTable = function() {
                            _select.change();
                        };
                    } else if (_select.hasClass('nuclides-grid')) {
                        loadingGraph = function() {
                            _select.change();
                        };
                    }
                });
                $.cookie(_this.data('cookie') || 'nuclide', _this.val(), {
                    path: '/'
                });
            });
        };
        nuclides_selects.each(function() {
            nuclides_change(this);
        });

        // Load box-with-tabs
        $('div.box-with-tabs').each(function() {
            var _this = $(this),
                    headers = _this.find('.htab'),
                    contents = _this.find('.ctab');
            if (headers.length === contents.length) {
                headers.each(function(i) {
                    var header = $(this),
                            content = $(contents.get(i));
                    header.click(function() {
                        contents.removeClass('active');
                        content.addClass('active');
                        headers.removeClass('active');
                        header.addClass('active');
                    });
                });
            } else if (console) {
                console.error('Quantity of headers and contents of Box-with-tabs should be the same!');
            }
        });
    });

    $.externalScript = function(url, options) {
        // allow user to set any option except for dataType, cache, and url
        options = $.extend(options || {}, {
            dataType: "script",
            cache: true,
            url: url
        });
        // Use $.ajax() since it is more flexible than $.getScript
        // Return the jqXHR object so we can chain callbacks
        return jQuery.ajax(options);
    };
})(jQuery);
