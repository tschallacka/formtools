+function ($) { "use strict";
    var Base = $.oc.foundation.base,
        BaseProto = Base.prototype

    var Application = function (element, options) {
        this.$el = $(element)
        this.options = options || {}

        $.oc.foundation.controlUtils.markDisposable(element)
        Base.call(this)
        this.init()
    }

    Application.prototype = Object.create(BaseProto)
    Application.prototype.constructor = Application

    Application.prototype.init = function() {
    	
        this.$el.spectrum({
		    allowEmpty:true,
		    color: this.$el.val(),
		    showInput: true,
		    containerClassName: "full-spectrum",
		    showInitial: true,
		    showPalette: true,
		    showSelectionPalette: true,
		    showAlpha: true,
		    maxPaletteSize: 10,
		    preferredFormat: "rgb",
		    localStorageKey: 'spectrum.'+this.$el.attr('name'),
		    /*move: function (color) {
		        //updateBorders(color);
		    },
		    show: function () {
		
		    },
		    beforeShow: function () {
		
		    },
		    hide: function (color) {
		        //updateBorders(color);
		    },*/
		
		    palette: [
		        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", /*"rgb(153, 153, 153)","rgb(183, 183, 183)",*/
		        "rgb(204, 204, 204)", "rgb(217, 217, 217)", /*"rgb(239, 239, 239)", "rgb(243, 243, 243)",*/ "rgb(255, 255, 255)"],
		        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
		        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
		        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
		        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
		        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
		        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
		        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
		        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
		        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
		        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
		        /*"rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
		        "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",*/
		        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
		        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
		    ]
		});
        this.$el.one('dispose-control', this.proxy(this.dispose))
    }

    Application.prototype.dispose = function() {
        this.$el.spectrum('destroy');
        this.$el.off('dispose-control', this.proxy(this.dispose))
        this.$el.removeData('oc.TschColorPickerApplication')

        this.$el = null

        // In some cases options could contain callbacks, 
        // so it's better to clean them up too.
        this.options = null

        BaseProto.dispose.call(this)
    }

    Application.DEFAULTS = {
        someParam: null
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.TschColorPickerApplication

    $.fn.TschColorPickerApplication = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), items, result

        items = this.each(function () {
            var $this   = $(this)
            var data    = $this.data('oc.TschColorPickerApplication')
            var options = $.extend({}, Application.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.TschColorPickerApplication', (data = new Application(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : items
    }

    $.fn.TschColorPickerApplication.Constructor = Application

    $.fn.TschColorPickerApplication.noConflict = function () {
        $.fn.TschColorPickerApplication = old
        return this
    }

    // Add this only if required
    $(document).render(function (){
        $('[data-tsch-color-picker-tool]').TschColorPickerApplication()
    })

}(window.jQuery);
