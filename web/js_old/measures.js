//**= require highstock
//**= require highstock.exporting
//= require main/object.advancedsearch

var loadingGraph = null;
var loadingTable = null;
var filterUpdated = false;
google.load("visualization", "1.1", {
    packages: ["corechart", "controls"]
});
google.setOnLoadCallback(function() {
    (function($) {
        $(document).ready(function() {
            // Datagrid
            loadingTable = function() {
                var datagrid = $('table.datagrid:first');
                if (datagrid.length > 0) {
                    var gridNuclides = $('select.nuclides-table:first');
                    gridNuclides.change(function() {
                        var nparams = {
                            'url': gridNuclides.attr('data-refresh') + '?nuclide=' + gridNuclides.val()
                        }
                        datagrid.flexOptions(nparams);
                        datagrid.flexReload();
			filterUpdated = true;
                    });
                    var nparams = {
                        'url': gridNuclides.attr('data-refresh') + '?nuclide=' + gridNuclides.val(),
                        'width': datagrid.width()
                    }
                    datagrid.flexOptions(nparams);
                    datagrid.flexReload();
                }
            };

            // Graph 
            var graph = $('#measures-graph-graph');
            var width = graph.width();
            var graphNuclides = $('select.nuclides-graph:first');
            var sDate = $('#measures-graph-dates input.start');
            var eDate = $('#measures-graph-dates input.end');
            var zooms = $('#measures-graph-zooms button');
            var range = null;
            var zoomsTable = {
                1: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setDate(nd.getDate() + (1 * m));
                    return nd;
                }, // 1d
                2: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setDate(nd.getDate() + (7 * m));
                    return nd;
                }, // 7d
                4: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setDate(nd.getDate() + (14 * m));
                    return nd;
                }, // 2s => 14d
                8: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setMonth(nd.getMonth() + (1 * m));
                    return nd;
                }, // 1m
                16: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setMonth(nd.getMonth() + (3 * m));
                    return nd;
                }, // 3m
                32: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setMonth(nd.getMonth() + (6 * m));
                    return nd;
                }, // 6m
                64: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setFullYear(nd.getFullYear() + (1 * m));
                    return nd;
                }, // 1y
                128: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setFullYear(nd.getFullYear() + (5 * m));
                    return nd;
                }, // 5y
                256: function(d, m) {
                    var nd = new Date(d.getTime());
                    nd.setFullYear(nd.getFullYear() + (10 * m));
                    return nd;
                } // 10y
            };
            var dateToString = function(d) {
                var day = d.getDate();
                var month = d.getMonth() + 1;
                return (day < 10 ? '0' + day : day) + '.' + (month < 10 ? '0' + month : month) + '.' + d.getFullYear();
            };
            var drawTooltip = function(point) {
                return '<div class="graph-tooltip">' +
                        '<div class="date">' + dateToString(new Date(point.date)) + '</div>' +
                        '<div class="data">' + (point.limited ? '&lt; ' : '') + sprintf('%.3e', point.value) + ' ' + (point.error ? '&#177; ' + sprintf('%.1e', point.error) : '') + ' ' + point.unit + '</div>' +
                        '</div>';
            };
            var googleRefresh = function(url, station, nuclide) {
                $.getJSON(url + '?nuclide=' + nuclide + '&jsoncallback=?', {}, function(data) {
                    var unit = data.length > 0 ? data[0].unit : '';
                    var gdatas = new google.visualization.DataTable();
                    gdatas.addColumn({
                        type: 'date',
                        id: 'date'
                    });
                    gdatas.addColumn({
                        type: 'number',
                        id: 'limited'
                    });
                    gdatas.addColumn({
                        type: 'number',
                        id: 'unlimited'
                    });
                    gdatas.addColumn({
                        type: 'string',
                        label: 'Tooltip',
                        id: 'tooltip',
                        role: 'tooltip',
                        p: {
                            html: true
                        }
                    });
                    gdatas.addColumn({
                        type: 'number',
                        id: 'unlimited'
                    });
                    gdatas.addColumn({
                        type: 'string',
                        label: 'Tooltip',
                        id: 'tooltip',
                        role: 'tooltip',
                        p: {
                            html: true
                        }
                    });

                    var min = 0;
                    var max = 0;
                    $.each(data, function() {
                        min = min === 0 || this.date < min ? this.date : min;
                        max = max === 0 || this.date > max ? this.date : max;
                        var tooltip = drawTooltip(this);
                        gdatas.addRow([new Date(this.date), this.value, this.limited ? this.value : null, tooltip, this.limited ? null : this.value, tooltip]);
                    });



                    var dashboard = new google.visualization.Dashboard(document.getElementById('measures-graph-dashboard'));

                    var control = new google.visualization.ControlWrapper({
                        controlType: 'ChartRangeFilter',
                        containerId: 'measures-graph-control',
                        options: {
                            filterColumnIndex: 0,
                            ui: {
                                chartType: 'LineChart',
                                chartOptions: {
                                    chartArea: {
                                        width: '90%'
                                    },
                                    hAxis: {
                                        baselineColor: 'none',
                                        format: 'MM.yyyy'
                                    },
                                    width: width
                                },
                                chartView: {
                                    columns: [0, 1]
                                },
                                minRangeSize: 86400000 // 1 day in milliseconds
                            }
                        },
                        state: {
                            range: {
                                start: new Date(min),
                                end: new Date(max)
                            }
                        }
                    });

                    var chart = new google.visualization.ChartWrapper({
                        chartType: 'ScatterChart',
                        containerId: 'measures-graph-chart',
                        options: {
                            chartArea: {
                                height: '80%',
                                width: '85%'
                            },
                            hAxis: {
                                format: 'dd.MM.yyyy',
				textStyle:{ 
					fontSize: 10,
					italic: false
				}
                            },
                            legend: {
                                position: 'none'
                            },
                            pointSize: 9,
                            series: {
                                0: {
                                    color: 'green',
                                    visibleInLegend: false
                                },
                                1: {
                                    color: 'orange',
                                    visibleInLegend: false
                                },
                                2: {
                                    color: 'green',
                                    visibleInLegend: false
                                }
                            },
                            tooltip: {
                                isHtml: true
                            },
                            vAxis: {
                                title: unit,
				titleTextStyle: {
					fontSize: 12,
					italic: false
				},
                                format: '0.00E0',
				textStyle: {
					fontSize: 10
				}
                            },
                            width: width
                        }
                    });

                    // Set events
                    google.visualization.events.addListener(chart, 'onmouseover', function(e) {
                        chart.setSelection([e]);
                    });
                    google.visualization.events.addListener(chart, 'onmouseout', function(e) {
                        chart.setSelection([{
                                'row': null,
                                'column': null
                            }]);
                    });
                    google.visualization.events.addListener(control, 'statechange', function(e) {
                        var state = control.getState();
                        if (e.startChanged) {
                            sDate.val(dateToString(state.range.start));
                        }
                        if (e.endChanged) {
                            eDate.val(dateToString(state.range.end));
                        }
                        range = state.range;
                    });

                    // Set zooms
                    var setZoom = function(zoom) {
                        if ($.type(zoomsTable[zoom]) === 'function') {
                            var state = control.getState();
                            var start = zoomsTable[zoom](state.range.end, -1);
                            var end = state.range.end;
                            if (start.getTime() < min) {
                                start = state.range.start;
                                end = zoomsTable[zoom](state.range.start, 1);
                                if (end.getTime() > max) {
                                    start = new Date(min);
                                    end = zoomsTable[zoom](start, 1);
                                    if (end.getTime() > max) {
                                        start = new Date(min);
                                        end = new Date(max);
                                    }
                                }
                            }
                            if (start.getTime() > end.getTime()) {
                                var _start = start;
                                start = end;
                                end = _start;
                            } else if (start.getTime() === end.getTime()) {
                                if (end.getTime() + 86400000 > max) {
                                    start.setDate(start.getDate() - 1);
                                } else {
                                    end.setDate(end.getDate() + 1);
                                }
                            }
                            range = {
                                start: start,
                                end: end
                            };
                            control.setState({
                                range: range
                            });
                            control.draw();
                            sDate.val(dateToString(start));
                            eDate.val(dateToString(end));
                        }
                    };
                    zooms.off('click').click(function() {
                        var _this = $(this);
                        setZoom(_this.attr('data-zoom'));
                        zooms.removeClass('current');
                        _this.addClass('current');
                    });
                    if (range !== null) {
                        control.setState({
                            range: range
                        });
                        control.draw();
                    } else {
                        zooms.filter('.current').each(function() {
                            setZoom($(this).attr('data-zoom'));
                        });
                    }

                    // Set range
                    var setRange = function() {
                        var sp = sDate.val().split('.');
                        var ep = eDate.val().split('.');
                        if (sp.length === 3 && ep.length === 3) {
                            var start = new Date(sp[2], sp[1], sp[0], 0, 0, 0, 0);
                            var end = new Date(ep[2], ep[1], ep[0], 0, 0, 0, 0);
                            if (start.getTime() < min) {
                                start = new Date(min);
                            }
                            if (end.getTime() > max) {
                                end = new Date(max);
                            }
                            if (start.getTime() > end.getTime()) {
                                var _start = start;
                                start = end;
                                end = _start;
                            } else if (start.getTime() == end.getTime()) {
                                if (end.getTime() + 86400000 > max) {
                                    start.setDate(start.getDate() - 1);
                                } else {
                                    end.setDate(end.getDate() + 1);
                                }
                            }
                            sDate.val(dateToString(start));
                            eDate.val(dateToString(end));
                            range = {
                                start: start,
                                end: end
                            };
                            control.setState({
                                range: range
                            });
                            control.draw();
                            zooms.removeClass('current');
                        }
                    };
                    sDate.off('change').change(setRange);
                    eDate.off('change').change(setRange);

                    // Build dashboard
                    dashboard.bind(control, chart);
                    dashboard.draw(gdatas);
                });
            };

            eval('var params = ' + (graphNuclides.attr('data-refresh') || '{}'));
            loadingGraph = function() {
                if (params && params.url && params.station) {
                    graphNuclides.change(function() {
                        googleRefresh(params.url, params.station, graphNuclides.val());
			filterUpdated = true;
                    });
                    googleRefresh(params.url, params.station, graphNuclides.val());
                }
            }

            // Initialize for single view
                //console.log($('#single-measure'));
            if ($('#single-measure').length > 0) {
                //console.log('test')
                setTimeout(function() {
                    if ($('select.nuclides-table').length > 0 && $.type(loadingTable) === 'function') {
                        loadingTable();
                    }
                    if ($('select.nuclides-graph').length > 0 && $.type(loadingGraph) === 'function') {
                        loadingGraph();
                    }
                //console.log('test2')               
                //console.log([$('select.nuclides-graph'), $.type(loadingTable), $('select.nuclides-table'), $.type(loadingGraph)])
                }, 100);
            }
        });

        // Set datepickers
        $('input.datepicker').datepicker({
            dateFormat: 'dd.mm.yy'
        });

        $('select.stations').change(function() {
            var url = $(this).find('option:selected').data('url') || '';
            if (url.length > 0) {
                window.location = $(this).find('option:selected').data('url');
            }
        });

        // Initialize advanced search
        new advancedSearchHandler();
    })(jQuery);
});
            
