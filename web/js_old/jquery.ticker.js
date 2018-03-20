(function($){
    $.fn.ticker = function(args){
        return $(this).each(function(){
            if (this._ticker){
                this._ticker.call(args)
            }else{
                this._ticker = new ticker(this, args); 
            }
        });
    };
    
    var ticker = function(el, options){
        if(typeof options != 'object'){
            options = {};
        }
        
        var _this = this,
        _el = $(el),
        handler = null,
        initialeHandler = null,
        elements = [],
        options = $.extend({
            autostart: true,
            debug: false,
            direction: 'horizontal',            // horizonal | vertical
            elementClassName: 'ticker-element',
            handlerClassName: 'ticker-handler',
            loop: true,
            onmouseover: 'pause',
            onmouseout: 'resume',
            pxpersec: 100, 
            splitting: 'block',                 // block | element
            startfrom: 'right'                  // left | right | top | bottom
        }, options || {}),
        direction = -1,
        duration = 1000,
        parentWidth = 0;
        
        initialize();
        
        function initialize(){
            var ul = _el.find('ul');
            if(ul){
                    // Build structure
                handler = $('<div class="' + options.handlerClassName + '-' + options.direction + '"></div>');
                ul.replaceWith($('<div class="' + options.handlerClassName + '"></div>').append(handler));
                if(options.splitting === 'element'){
                    ul.find('li').each(function(){
                        elements.push($('<div class="' + options.elementClassName + '"></div>').append($('<ul></ul>').append(this))); 
                    });
                }else{
                    elements.push($('<div class="' + options.elementClassName + '"></div>').append(ul));
                }
                $.each(elements, function(i,e){
                    handler.append(e);
                });
                
                    // Set variables
                if(options.direction === 'vertical'){
                    debug('Not yet implemented');
                    direction = options.startfrom == 'bottom' ? 1 : -1;
                }else{
                    parentWidth = handler.parent().outerWidth(true);
                    duration = parentWidth / options.pxpersec * 2000;
                    direction = options.startfrom == 'left' ? 1 : -1;
                }
                
                    // Initialize event
                if(options.onmouseover){
                    handler.mouseover(function(){
                        _this.call(options.onmouseover);
                    });
                }
                if(options.onmouseout){
                    handler.mouseout(function(){
                        _this.call(options.onmouseout);
                    });
                }
                
                reset();
                if(options.autostart){
                    start();
                }
            }else{
                debug('Bad HTML structure!');
            }
        };
        
        function start(currentDuration){
            if(options.direction === 'vertical'){
            // TODO: to be implemented
            }else{
                currentDuration = currentDuration ? currentDuration : duration;
                handler.animate({
                    'left': direction * parentWidth
                }, currentDuration, 'linear', function(){
                    if(options.loop){
                        reset();
                        start();
                    }
                });
            }
        };
        
        function resume(){
            if(options.direction === 'vertical'){
            // TODO: to be implemented
            }else{
                start((parentWidth + handler.position().left) * duration / parentWidth / 2);
            }
        }
        
        function pause(){
            handler.stop();
        };
        
        function reset(){
            if(options.direction === 'vertical'){
            // TODO: to be implemented
            }else{
                handler.css({
                    'left': direction * -1 * parentWidth
                });
            }
        };
        
        function debug(msg){
            if(options.debug){
                try{
                    console.debug('Ticker: ' + msg);
                }catch(Exception){
                    _el.after('<p style="color: red;">Ticker: ' + msg + '</p>');
                }
            }
        }
        
        this.call = function(func){
            if(typeof func == 'string') {
                if(func === 'start'){
                    start();
                }else if(func === 'pause'){
                    pause();
                }else if(func === 'resume'){
                    resume();
                }else{
                    debug('Function not found!');
                }
            }else{
                debug("Invalid argument's type!");
            }
        
        }
    };
})(jQuery)