+function ($) { "use strict";

    /**
     * Set here your default application name.
     * Any capital letter will be replaced by lowercase and a - will be inserted 
     * in between.
     * ApplicationForBearTraps turns into application-for-bear-traps and 
     * this script will tag elements with the attributes <div data-application-for-bear-traps>
     *
     * The formatted name will be stored in the variable  `appID` 
     * the jQuery selector will be stored in the variable `appDataHandler`
     */
    var appName = 'CheckboxListFilter';

    /**
     * Set your current version  here. If you are developing and this script gets served by ajax
     * this will make sure the "old" version doesn't dual load on render and inactivates.
     * Please use integers here. not 1.0.1 because it uses a current less than appVersion comparisan function.
     * Also don't use zero. the script won't run then.
     */
    var appVersion = 1;
    
   /**
    * Needs to be here, do not edit. 
    * Some default calculations to make your life easier.
    */
    var appID = appName.replace(/[^a-z]+/gi, '').replace(/(.)([A-Z])/g, "$1-$2").toLowerCase();var appDataHandler = '[data-'+appID+']'; var oc = 'oc.'+appName; var Base = $.oc.foundation.base, BaseProto = Base.prototype; var Application = function (element, options) { this.$el = $(element); this.options = options || {}; this.appID = appID; this.appName = appName; this.oc = oc; $.oc.foundation.controlUtils.markDisposable(element); Base.call(this); this.sysInit(); }; Application.prototype = Object.create(BaseProto); Application.prototype.constructor = Application;var res = window.hasOwnProperty(appName+"_version") ? window[appName+"_version"] : 0;if(res == undefined || res < appVersion ) {window[appName+"_version"] = appVersion;}
    
    /**
     * ================================================================================================================
     *            ****                       edit below this line                             ****
     * ================================================================================================================
     */
    
    /**
     * Bind jQuery event handlers here. 
     * @var type is the event type('on') or ('off') for binding and unbinding events
     * this.$el[type]('click',this.proxy(this.something));
     * 
     * this.bind('click',this.$el,this.something);
     * this.bind('click',this.$el,'.some-subclass',this.somethingelse);
     */
    Application.prototype.handlers = function(type) {
        this.bind('input', this.$searchInput, this.onTimeFilter);
        this.bind('click',this.$el,'[data-filtered-checkboxlist-hide-checked]', this.hideChecked);
        this.bind('click',this.$el,'[data-filtered-checkboxlist-hide-unchecked]', this.hideEmpty);
        this.bind('click',this.$el,'[data-filtered-checkboxlist-show-all]', this.showAll);
        this.bind('change', this.$el, 'input[type="checkbox"]', this.countChecked);
        
    };
    /**
     * This code is called when the application is initialised. Initialise variables here.
     * This is called BEFORE the event handlers are bound.
     * For automatically cleaning variables you can define variables with
     * this.alloc('foobar',42)
     * will be the same as this.foobar = 42;
     * only difference is that the alloc'ed variable will be cleand up automatically on destroy
     * whislt the foobar needs a this.foobar=null in the destroy function.
     */
    Application.prototype.init = function() {
        /**
         * example;
         */
        this.alloc('$searchInput', this.$el.find('[data-filter-text]'));
        this.alloc('timeout', 0);
        this.alloc('$checked', this.$el.find('[data-filtered-checkboxlist-hide-checked] .checkedcount'));
        this.alloc('$empty', this.$el.find('[data-filtered-checkboxlist-hide-unchecked] .emptycount'));
        this.countChecked();
    }
    /**
     * This code is called when the application is being destroyed/cleaned up.
     * Deinitialise/null your variables here.
     * This is called AFTER the event handlers are unbound.
     * and BEFORE the variables that were set in alloc() are unbound.
     */
    Application.prototype.destroy = function() {
        
    }
    
    Application.prototype.countChecked = function() 
    {
        var checked = this.$el.find('.filter-element input[type="checkbox"]:checked').length;
        
        this.$checked.text(checked);
        this.$empty.text(this.$el.find('.filter-element input[type="checkbox"]').length - checked);
    }
    
    Application.prototype.hideChecked = function() 
    {
        this.onFilter();
        this.$el.find('.filter-element.filtered-show').each(function(index, element) {
            var $element = $(element);
            var $input = $element.find('input[type="checkbox"]');
            if($input.prop('checked')) {
                $element.hide();
            }
            else {
                $element.show(); 
            }
        });
    }
    
    Application.prototype.hideEmpty = function() {
        this.onFilter();
        this.$el.find('.filter-element.filtered-show').each(function(index, element) {
            var $element = $(element);
            var $input = $element.find('input[type="checkbox"]');
            if($input.prop('checked')) {
                $element.show();
            }
            else {
                $element.hide();
            }
        });
    }
    
    Application.prototype.showAll = function() {
        this.onFilter();
    }
    
    Application.prototype.onTimeFilter = function() 
    {
        window.clearTimeout(this.timeout);
        this.timeout = window.setTimeout(this.proxy(this.onFilter), 300);
    }
    
    Application.prototype.onFilter = function() 
    {
        var rawSearch = this.$searchInput.val();
        
        var pattern = rawSearch.replace('*','.*');
        var reg = new RegExp(pattern,'i');
        var emptyFilter = rawSearch.length === 0;
        this.$el.find('.filter-element').each(function(index, element) {
            var $element = $(element);
            if(emptyFilter) {
                $element.show();
                $element.addClass('filtered-show');
            }
            else {
                if($element.find('label').text().match(reg)) {
                    $element.show();
                    $element.addClass('filtered-show');
                }
                else {
                    $element.hide();
                    $element.addClass('filtered-hidden');
                    $element.removeClass('filtered-show');
                }
            }
        });
    }
    
    
    
    
    
    
    
     

    
    
    
    /**
     * ================================================================================================
     *            ****  XXXXXXXXXXXXX  Do not edit below this line  XXXXXXXXXXXXX  ****
     * ================================================================================================
     */
    
    /**
     * Register method to register your variables so they will automatically be cleaned up.
     */
    Application.prototype.alloc = function(name,value) 
    {
        this.alloclist.push(name);
        this[name] = value;
    }
    
    /**
     * clean method that cleans up all variables set by alloc.
     * called when event is destroyed after destroy() and handlers('off');
     */
    Application.prototype.free = function() 
    {
        for(var c=0; c < this.alloclist.length; c++) 
        {
            var name = this.alloclist[c];
            this[name] = null;
        }
        this.alloclist = null;
    }
    
    /**
     * Quick method for binding and unbinding event handlers.
     * this.bind('click',this.$el,this.something);
     * this.bind('click',this.$el,'[data-foobar]',this.somethingelse);
     */
    Application.prototype.bind = function(event, $el,  callback_or_subselector, callback) {
        if(typeof callback_or_subselector === 'string') 
        {
            $el[this.event_binding_type](event,callback_or_subselector,this.proxy(callback));
        }
        else {
            $el[this.event_binding_type](event,this.proxy(callback_or_subselector));
        }
    }
    
    
    Application.prototype.sysDestroy = function() 
    {
        this.event_binding_type='off';
        this.handlers(this.event_binding_type);
        this.destroy();
        this.free();
        this.$el.off('dispose-control', this.proxy(this.dispose))
        this.$el.removeData(this.oc);
        this.requesthandle = null;
        this.$el = null

        // In some cases options could contain callbacks, 
        // so it's better to clean them up too.
        this.options = null

        BaseProto.dispose.call(this)
    };
    
    Application.prototype.getHandle = function(name) 
    {
        if(this.handle) {
            return this.handle + name;
        }
        this.handle = this.$el.data('apphandler');
        return this.getHandle(name);
    }
    
    Application.prototype.request = function(requestname,data) 
    {
        return this.$el.request(this.getHandle(requestname),data);
    }
    
    Application.prototype.sysInit = function() 
    {
        this.$el.one('dispose-control', this.proxy(this.sysDestroy));
        this.event_binding_type='on';
        this.alloclist = [];
        this.init();
        this.handlers(this.event_binding_type);
        
    }
    
    Application.DEFAULTS = {
        appName: appName,
        appID: appID,
        appDataHandler: appDataHandler
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn[appName]

    $.fn[appName] = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), items, result
        
        items = this.each(function (index, elem) {
            var $this   = $(elem);
            var data    = $this.data(oc);
            var options = $.extend({}, Application.DEFAULTS, $this.data(), typeof option == 'object' && option);
            
            if (!data) {
                $this.data(oc, (data = new Application(this, options)));
            }
            if (typeof option == 'string') {
                result = data[option].apply(data, args);
                
            }
            
            if (typeof result != 'undefined') {
                return false;
            }
            ;
        });

        return result ? result : items
    };

    $.fn[appName].Constructor = Application;

    $.fn[appName].noConflict = function () {
        $.fn[appName] = old
        return this
    };

    // Add this only if required
    $(document).render(function (){
        if(window[appName+"_version"] == appVersion) {
            var $elems = $(appDataHandler);
            $elems[appName]();
        }
        
    });

}(window.jQuery);
