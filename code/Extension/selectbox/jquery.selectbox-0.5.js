/*
 * jQuery selectbox plugin
 *
 * Copyright (c) 2007 Sadri Sahraoui (brainfault.com)
 * Licensed under the GPL license and MIT:
 *   http://www.opensource.org/licenses/GPL-license.php
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * The code is inspired from Autocomplete plugin (http://www.dyve.net/jquery/?autocomplete)
 *
 * Revision: $Id$
 * Version: 0.5
 * 
 * Changelog :
 *  Version 0.5 
 *  - separate css style for current selected element and hover element which solve the highlight issue 
 *  Version 0.4
 *  - Fix width when the select is in a hidden div   @Pawel Maziarz
 *  - Add a unique id for generated li to avoid conflict with other selects and empty values @Pawel Maziarz
 */
jQuery.fn.extend({
	selectbox: function(options) {
		return this.each(function() {
			new jQuery.SelectBox(this, options);
		});
    }
});

jQuery.fn.extend({
    selectbox2: function(options) {
		return this.each(function() {
			new jQuery.SelectBox2(this, options);
		});
	}
});

jQuery.fn.extend({
    selectbox3: function (options) {
        return this.each(function () {
            new jQuery.SelectBox3(this, options);
        });
    }
});

jQuery.fn.extend({
    selectbox4: function (options) {
        return this.each(function () {
            new jQuery.SelectBox4(this, options);
        });
    }
});

jQuery.fn.extend({
    selectbox5: function (options) {
        return this.each(function () {
            new jQuery.SelectBox5(this, options);
        });
    }
});

jQuery.fn.extend({
    selectbox6: function (options) {
        return this.each(function () {
            new jQuery.SelectBox6(this, options);
        });
    }
});

jQuery.fn.extend({
    selectbox7: function (options) {
        return this.each(function () {
            new jQuery.SelectBox7(this, options);
        });
    }
});

jQuery.fn.extend({
    selectbox8: function (options) {
        return this.each(function () {
            new jQuery.SelectBox8(this, options);
        });
    }
});

jQuery.fn.extend({
    selectbox9: function (options) {
        return this.each(function () {
            new jQuery.SelectBox9(this, options);
        });
    }
});


/* pawel maziarz: work around for ie logging */
if (!window.console) {
	var console = {
		log: function(msg) { 
	 }
	}
}
/* */



/************************ DropDownList 1 (light grey) ****************************************************************/
jQuery.SelectBox = function(selectobj, options) {
	
	var opt = options || {};
	opt.inputClass = opt.inputClass || "selectbox";
	opt.containerClass = opt.containerClass || "selectbox-wrapper";
	opt.hoverClass = opt.hoverClass || "current";
	opt.currentClass = opt.selectedClass || "selected"
	opt.debug = opt.debug || false;
	
	var elm_id = selectobj.id;
	var active = -1;
	var inFocus = false;
	var hasfocus = 0;
	//jquery object for select element
	var $select = $(selectobj);
	// jquery container object
	var $container = setupContainer(opt);
	//jquery input object 
	var $input = setupInput(opt);
	// hide select and append newly created elements
	$select.hide().before($input).before($container);


	init();

	$container.blur(function () {
	    $container.hide();
	});
	
	$input
	.click(function(){
        //if (!inFocus) {
		  $container.toggle();
		//}
	})
//	.focus(function(){
//	   if ($container.not(':visible')) {
//	       inFocus = true;
//	       $container.show();
//	   }
//	})
	.keydown(function(event) {	   
		switch(event.keyCode) {
			case 38: // up
				event.preventDefault();
				moveSelect(-1);
				break;
			case 40: // down
				event.preventDefault();
				moveSelect(1);
				break;
			//case 9:  // tab 
			case 13: // return
				event.preventDefault(); // seems not working in mac !
				$('li.'+opt.hoverClass).trigger('click');
				break;
			case 27: //escape
			  hideMe();
			  break;
		}
	})
	.blur(function() {
		if ($container.is(':visible') && hasfocus > 0 ) {
			if(opt.debug) console.log('container visible and has focus')
		} else {
			// hideMe();	
		}
	});


	function hideMe() { 
		hasfocus = 0;
		$container.hide();

		$('#frmCapProjects').submit();

	}
	
	function init() {
		$container.append(getSelectOptions($input.attr('id'))).hide();
		var width = $input.css('width');
		$container.width(width);
    }
	
	function setupContainer(options) {
		var container = document.createElement("div");
		$container = $(container);
		$container.attr('id', elm_id+'_container');
		$container.addClass(options.containerClass);
		
		return $container;
	}
	
	function setupInput(options) {
		var input = document.createElement("input");
		var $input = $(input);
		$input.attr("id", elm_id+"_input");
		$input.attr("type", "text");
		$input.addClass(options.inputClass);
		$input.attr("autocomplete", "off");
		$input.attr("readonly", "readonly");
		$input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie
		
		return $input;	
	}
	
	function moveSelect(step) {
		var lis = $("li", $container);
		if (!lis) return;

		active += step;

		if (active < 0) {
			active = 0;
		} else if (active >= lis.size()) {
			active = lis.size() - 1;
		}

		lis.removeClass(opt.hoverClass);

		$(lis[active]).addClass(opt.hoverClass);
	}
	
	function setCurrent() {	
		var li = $("li."+opt.currentClass, $container).get(0);
		var ar = (''+li.id).split('_');
		var el = ar[ar.length-1];
		$select.val(el);
		$input.val($(li).html());
		return true;
	}
	
	// select value
	function getCurrentSelected() {
		return $select.val();
	}
	
	// input value
	function getCurrentValue() {
		return $input.val();
	}
	
	function getSelectOptions(parentid) {
		var select_options = new Array();
		var ul = document.createElement('ul');
		$select.children('option').each(function() {
			var li = document.createElement('li');
			li.setAttribute('id', parentid + '_' + $(this).val());
			li.innerHTML = $(this).html();
			if ($(this).is(':selected')) {
				$input.val($(this).html());
				$(li).addClass(opt.currentClass);
			}
			ul.appendChild(li);
			$(li)
			.mouseover(function(event) {
				hasfocus = 1;
				if (opt.debug) console.log('over on : '+this.id);
				jQuery(event.target, $container).addClass(opt.hoverClass);
			})
			.mouseout(function(event) {
				hasfocus = -1;
				if (opt.debug) console.log('out on : '+this.id);
				jQuery(event.target, $container).removeClass(opt.hoverClass);
			})
			.click(function(event) {
			  var fl = $('li.'+opt.hoverClass, $container).get(0);
				if (opt.debug) console.log('click on :'+this.id);
				$('li.'+opt.currentClass).removeClass(opt.currentClass); 
				$(this).addClass(opt.currentClass);
				setCurrent();
				hideMe();
			});
		});
		return ul;
	}
	
};



/************************ DropDownList 2 (white) *****************************************************************/
jQuery.SelectBox2 = function(selectobj, options) {
	
	var opt = options || {};
	opt.inputClass = opt.inputClass || "selectbox2";
	opt.containerClass = opt.containerClass || "selectbox-wrapper2";
	opt.hoverClass = opt.hoverClass || "current2";
	opt.currentClass = opt.selectedClass || "selected2"
	opt.debug = opt.debug || false;
	
	var elm_id = selectobj.id;
	var active = -1;
	var inFocus = false;
	var hasfocus = 0;
	//jquery object for select element
	var $select = $(selectobj);
	// jquery container object
	var $container = setupContainer(opt);
	//jquery input object 
	var $input = setupInput(opt);
	// hide select and append newly created elements
	$select.hide().before($input).before($container);
	
	
	init();
	
	$input
	.click(function(){
    if (!inFocus) {
		  $container.toggle();
		}
	})
	.focus(function(){
	   if ($container.not(':visible')) {
	       inFocus = true;
	       $container.show();
	   }
	})
	.keydown(function(event) {	   
		switch(event.keyCode) {
			case 38: // up
				event.preventDefault();
				moveSelect(-1);
				break;
			case 40: // down
				event.preventDefault();
				moveSelect(1);
				break;
			//case 9:  // tab 
			case 13: // return
				event.preventDefault(); // seems not working in mac !
				$('li.'+opt.hoverClass).trigger('click');
				break;
			case 27: //escape
			  hideMe();
			  break;
		}
	})
	.blur(function() {
		if ($container.is(':visible') && hasfocus > 0 ) {
			if(opt.debug) console.log('container visible and has focus')
		} else {
			hideMe();	
		}
	});


	function hideMe() { 
		hasfocus = 0;
		$container.hide(); 
	}
	
	function init() {
		$container.append(getSelectOptions($input.attr('id'))).hide();
		var width = $input.css('width');
		$container.width(width);
    }
	
	function setupContainer(options) {
		var container = document.createElement("div");
		$container = $(container);
		$container.attr('id', elm_id+'_container');
		$container.addClass(options.containerClass);
		
		return $container;
	}
	
	function setupInput(options) {
		var input = document.createElement("input");
		var $input = $(input);
		$input.attr("id", elm_id+"_input");
		$input.attr("type", "text");
		$input.addClass(options.inputClass);
		$input.attr("autocomplete", "off");
		$input.attr("readonly", "readonly");
		$input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie
		
		return $input;	
	}
	
	function moveSelect(step) {
		var lis = $("li", $container);
		if (!lis) return;

		active += step;

		if (active < 0) {
			active = 0;
		} else if (active >= lis.size()) {
			active = lis.size() - 1;
		}

		lis.removeClass(opt.hoverClass);

		$(lis[active]).addClass(opt.hoverClass);
	}
	
	function setCurrent() {	
		var li = $("li."+opt.currentClass, $container).get(0);
		var ar = (''+li.id).split('_');
		var el = ar[ar.length-1];
		$select.val(el);
		$input.val($(li).html());
		return true;
	}
	
	// select value
	function getCurrentSelected() {
		return $select.val();
	}
	
	// input value
	function getCurrentValue() {
		return $input.val();
	}
	
	function getSelectOptions(parentid) {
		var select_options = new Array();
		var ul = document.createElement('ul');
		$select.children('option').each(function() {
			var li = document.createElement('li');
			li.setAttribute('id', parentid + '_' + $(this).val());
			li.innerHTML = $(this).html();
			if ($(this).is(':selected')) {
				$input.val($(this).html());
				$(li).addClass(opt.currentClass);
			}
			ul.appendChild(li);
			$(li)
			.mouseover(function(event) {
				hasfocus = 1;
				if (opt.debug) console.log('over on : '+this.id);
				jQuery(event.target, $container).addClass(opt.hoverClass);
			})
			.mouseout(function(event) {
				hasfocus = -1;
				if (opt.debug) console.log('out on : '+this.id);
				jQuery(event.target, $container).removeClass(opt.hoverClass);
			})
			.click(function(event) {
			  var fl = $('li.'+opt.hoverClass, $container).get(0);
				if (opt.debug) console.log('click on :'+this.id);
				$('li.'+opt.currentClass).removeClass(opt.currentClass); 
				$(this).addClass(opt.currentClass);
				setCurrent();
				hideMe();
			});
		});
		return ul;
	}
	
};





/************************ DropDownList 3 (dark grey) - long *****************************************************************/
jQuery.SelectBox3 = function (selectobj, options) {

    var opt = options || {};
    opt.inputClass = opt.inputClass || "selectbox3";
    opt.containerClass = opt.containerClass || "selectbox-wrapper3";
    opt.hoverClass = opt.hoverClass || "current3";
    opt.currentClass = opt.selectedClass || "selected3"
    opt.debug = opt.debug || false;

    var elm_id = selectobj.id;
    var active = -1;
    var inFocus = false;
    var hasfocus = 0;
    //jquery object for select element
    var $select = $(selectobj);
    // jquery container object
    var $container = setupContainer(opt);
    //jquery input object 
    var $input = setupInput(opt);
    // hide select and append newly created elements
    $select.hide().before($input).before($container);


    init();

    $container.blur(function () {
        $container.hide();
    });

    $input
	.click(function () {
	    // if (!inFocus) {
	        $container.toggle();
	    // }
	})
//	.focus(function () {
//	    if ($container.not(':visible')) {
//	        inFocus = true;
//	        $container.show();
//	    }
//	})
	.keydown(function (event) {
	    switch (event.keyCode) {
	        case 38: // up
	            event.preventDefault();
	            moveSelect(-1);
	            break;
	        case 40: // down
	            event.preventDefault();
	            moveSelect(1);
	            break;
	        //case 9:  // tab  
	        case 13: // return
	            event.preventDefault(); // seems not working in mac !
	            $('li.' + opt.hoverClass).trigger('click');
	            break;
	        case 27: //escape
	            hideMe();
	            break;
	    }
	})
	.blur(function () {
	    if ($container.is(':visible') && hasfocus > 0) {
	        if (opt.debug) console.log('container visible and has focus')
	    } else {
	        // hideMe();
	    }
	});


    function hideMe() {
        hasfocus = 0;
        $container.hide();
    }

    function init() {
        $container.append(getSelectOptions($input.attr('id'))).hide();
        var width = $input.css('width');
        $container.width(width);
    }

    function setupContainer(options) {
        var container = document.createElement("div");
        $container = $(container);
        $container.attr('id', elm_id + '_container');
        $container.addClass(options.containerClass);

        return $container;
    }

    function setupInput(options) {
        var input = document.createElement("input");
        var $input = $(input);
        $input.attr("id", elm_id + "_input");
        $input.attr("type", "text");
        $input.addClass(options.inputClass);
        $input.attr("autocomplete", "off");
        $input.attr("readonly", "readonly");
        $input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie

        return $input;
    }

    function moveSelect(step) {
        var lis = $("li", $container);
        if (!lis) return;

        active += step;

        if (active < 0) {
            active = 0;
        } else if (active >= lis.size()) {
            active = lis.size() - 1;
        }

        lis.removeClass(opt.hoverClass);

        $(lis[active]).addClass(opt.hoverClass);
    }

    function setCurrent() {
        var li = $("li." + opt.currentClass, $container).get(0);
        var ar = ('' + li.id).split('_');
        var el = ar[ar.length - 1];
        $select.val(el);
        $input.val($(li).html());
        return true;
    }

    // select value
    function getCurrentSelected() {
        return $select.val();
    }

    // input value
    function getCurrentValue() {
        return $input.val();
    }

    function getSelectOptions(parentid) {
        var select_options = new Array();
        var ul = document.createElement('ul');
        $select.children('option').each(function () {
            var li = document.createElement('li');
            li.setAttribute('id', parentid + '_' + $(this).val());
            li.innerHTML = $(this).html();
            if ($(this).is(':selected')) {
                $input.val($(this).html());
                $(li).addClass(opt.currentClass);
            }
            ul.appendChild(li);
            $(li)
			.mouseover(function (event) {
			    hasfocus = 1;
			    if (opt.debug) console.log('over on : ' + this.id);
			    jQuery(event.target, $container).addClass(opt.hoverClass);
			})
			.mouseout(function (event) {
			    hasfocus = -1;
			    if (opt.debug) console.log('out on : ' + this.id);
			    jQuery(event.target, $container).removeClass(opt.hoverClass);
			})
			.click(function (event) {
			    var fl = $('li.' + opt.hoverClass, $container).get(0);
			    if (opt.debug) console.log('click on :' + this.id);
			    $('li.' + opt.currentClass).removeClass(opt.currentClass);
			    $(this).addClass(opt.currentClass);
			    setCurrent();
			    hideMe();
			});
        });
        return ul;
    }

};









/************************ DropDownList 4 (dark grey) - short *****************************************************************/
jQuery.SelectBox4 = function (selectobj, options) {

    var opt = options || {};
    opt.inputClass = opt.inputClass || "selectbox4";
    opt.containerClass = opt.containerClass || "selectbox-wrapper4";
    opt.hoverClass = opt.hoverClass || "current4";
    opt.currentClass = opt.selectedClass || "selected4"
    opt.debug = opt.debug || false;

    var elm_id = selectobj.id;
    var active = -1;
    var inFocus = false;
    var hasfocus = 0;
    //jquery object for select element
    var $select = $(selectobj);
    // jquery container object
    var $container = setupContainer(opt);
    //jquery input object 
    var $input = setupInput(opt);
    // hide select and append newly created elements
    $select.hide().before($input).before($container);


    init();

    $container.blur(function () {
        $container.hide();
    });

    $input
	.click(function () {
	    // if (!inFocus) {
	        $container.toggle();
	   //  }
	})
//	.focus(function () {
//	    if ($container.not(':visible')) {
//	        inFocus = true;
//	        $container.show();
//	    }
//	})
	.keydown(function (event) {
	    switch (event.keyCode) {
	        case 38: // up
	            event.preventDefault();
	            moveSelect(-1);
	            break;
	        case 40: // down
	            event.preventDefault();
	            moveSelect(1);
	            break;
	        //case 9:  // tab   
	        case 13: // return
	            event.preventDefault(); // seems not working in mac !
	            $('li.' + opt.hoverClass).trigger('click');
	            break;
	        case 27: //escape
	            hideMe();
	            break;
	    }
	})
	.blur(function () {
	    if ($container.is(':visible') && hasfocus > 0) {
	        if (opt.debug) console.log('container visible and has focus')
	    } else {
	        // hideMe();
	    }
	});


    function hideMe() {
        hasfocus = 0;
        $container.hide();
    }

    function init() {
        $container.append(getSelectOptions($input.attr('id'))).hide();
        var width = $input.css('width');
        $container.width(width);
    }

    function setupContainer(options) {
        var container = document.createElement("div");
        $container = $(container);
        $container.attr('id', elm_id + '_container');
        $container.addClass(options.containerClass);

        return $container;
    }

    function setupInput(options) {
        var input = document.createElement("input");
        var $input = $(input);
        $input.attr("id", elm_id + "_input");
        $input.attr("type", "text");
        $input.addClass(options.inputClass);
        $input.attr("autocomplete", "off");
        $input.attr("readonly", "readonly");
        $input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie

        return $input;
    }

    function moveSelect(step) {
        var lis = $("li", $container);
        if (!lis) return;

        active += step;

        if (active < 0) {
            active = 0;
        } else if (active >= lis.size()) {
            active = lis.size() - 1;
        }

        lis.removeClass(opt.hoverClass);

        $(lis[active]).addClass(opt.hoverClass);
    }

    function setCurrent() {
        var li = $("li." + opt.currentClass, $container).get(0);
        var ar = ('' + li.id).split('_');
        var el = ar[ar.length - 1];
        $select.val(el);
        $input.val($(li).html());
        return true;
    }

    // select value
    function getCurrentSelected() {
        return $select.val();
    }

    // input value
    function getCurrentValue() {
        return $input.val();
    }

    function getSelectOptions(parentid) {
        var select_options = new Array();
        var ul = document.createElement('ul');
        $select.children('option').each(function () {
            var li = document.createElement('li');
            li.setAttribute('id', parentid + '_' + $(this).val());
            li.innerHTML = $(this).html();
            if ($(this).is(':selected')) {
                $input.val($(this).html());
                $(li).addClass(opt.currentClass);
            }
            ul.appendChild(li);
            $(li)
			.mouseover(function (event) {
			    hasfocus = 1;
			    if (opt.debug) console.log('over on : ' + this.id);
			    jQuery(event.target, $container).addClass(opt.hoverClass);
			})
			.mouseout(function (event) {
			    hasfocus = -1;
			    if (opt.debug) console.log('out on : ' + this.id);
			    jQuery(event.target, $container).removeClass(opt.hoverClass);
			})
			.click(function (event) {
			    var fl = $('li.' + opt.hoverClass, $container).get(0);
			    if (opt.debug) console.log('click on :' + this.id);
			    $('li.' + opt.currentClass).removeClass(opt.currentClass);
			    $(this).addClass(opt.currentClass);
			    setCurrent();
			    hideMe();
			});
        });
        return ul;
    }

};










/************************ DropDownList 5 (light grey) - for Staff page *****************************************************************/

jQuery.SelectBox5 = function (selectobj, options) {

    var opt = options || {};
    opt.inputClass = opt.inputClass || "selectbox5";
    opt.containerClass = opt.containerClass || "selectbox-wrapper5";
    opt.hoverClass = opt.hoverClass || "current5";
    opt.currentClass = opt.selectedClass || "selected5"
    opt.debug = opt.debug || false;

    var elm_id = selectobj.id;
    var active = -1;
    var inFocus = false;
    var hasfocus = 0;

    //jquery object for select element

    var $select = $(selectobj);
    // jquery container object

    var $container = setupContainer(opt);
    //jquery input object
    var $input = setupInput(opt);
    // hide select and append newly created elements
    $select.hide().before($input).before($container);

    init();

    $container.blur(function () {
        $container.hide();
    });

    $input
       .click(function () {
//           if (!inFocus) {
                $container.toggle();
                
//           }
       })
//           .focus(function () {
//               if ($container.not(':visible')) {
//                   inFocus = true;
//                   $container.show();
//               }
//           })
       .keydown(function (event) {
           switch (event.keyCode) {
               case 38: // up
                   event.preventDefault();
                   moveSelect(-1);
                   break;
               case 40: // down
                   event.preventDefault();
                   moveSelect(1);
                   break;
               //case 9:  // tab  
               case 13: // return
                   event.preventDefault(); // seems not working in mac !
                   $('li.' + opt.hoverClass).trigger('click');
                   break;
               case 27: //escape
                   hideMe();
                   break;
           }

       })

       .blur(function () {
           if ($container.is(':visible') && hasfocus > 0) {
               if (opt.debug) console.log('container visible and has focus')
           } else {
               // hideMe();
           }
       });


    function hideMe() {
        hasfocus = 0;
        $container.hide();
        var v;

        //        $("#view").val(v);
        //alert($("#view").val());

        $('#frmStaff').submit();

    }


    function init() {
        $container.append(getSelectOptions($input.attr('id'))).hide();
        var width = $input.css('width');
        $container.width(width);
    }


    function setupContainer(options) {
        var container = document.createElement("div");
        $container = $(container);
        $container.attr('id', elm_id + '_container');
        $container.addClass(options.containerClass);
        return $container;
    }

    function setupInput(options) {
        var input = document.createElement("input");
        var $input = $(input);
        $input.attr("id", elm_id + "_input");
        $input.attr("type", "text");
        $input.addClass(options.inputClass);
        $input.attr("autocomplete", "off");
        $input.attr("readonly", "readonly");
        $input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie
        return $input;
    }


    function moveSelect(step) {
        var lis = $("li", $container);
        if (!lis) return;
        active += step;
        if (active < 0) {
            active = 0;
        } else if (active >= lis.size()) {
            active = lis.size() - 1;
        }
        lis.removeClass(opt.hoverClass);
        $(lis[active]).addClass(opt.hoverClass);
    }

    function setCurrent() {
        var li = $("li." + opt.currentClass, $container).get(0);
        var ar = ('' + li.id).split('_');
        var el = ar[ar.length - 1];
        $select.val(el);
        $input.val($(li).html());
        return true;
    }

    // select value
    function getCurrentSelected() {
        return $select.val();
    }

    // input value
    function getCurrentValue() {
        return $input.val();
    }

    function getSelectOptions(parentid) {
        var select_options = new Array();
        var ul = document.createElement('ul');
        $select.children('option').each(function () {
            var li = document.createElement('li');
            li.setAttribute('id', parentid + '_' + $(this).val());
            li.innerHTML = $(this).html();
            if ($(this).is(':selected')) {
                $input.val($(this).html());
                $(li).addClass(opt.currentClass);
            }
            ul.appendChild(li);
            $(li)
                .mouseover(function (event) {
                    hasfocus = 1;
                    if (opt.debug) console.log('over on : ' + this.id);
                    jQuery(event.target, $container).addClass(opt.hoverClass);
                })

                .mouseout(function (event) {
                    hasfocus = -1;
                    if (opt.debug) console.log('out on : ' + this.id);
                    jQuery(event.target, $container).removeClass(opt.hoverClass);
                })

                .click(function (event) {
                    var fl = $('li.' + opt.hoverClass, $container).get(0);
                    if (opt.debug) console.log('click on :' + this.id);
                    $('li.' + opt.currentClass).removeClass(opt.currentClass);
                    $(this).addClass(opt.currentClass);
                    setCurrent();
                    //
                    hideMe();
                })

        });
        return ul;
    }
};



/************************ DropDownList 6 (light grey) - for Publication page, by year *****************************************************************/
jQuery.SelectBox6 = function (selectobj, options) {

    var opt = options || {};
    opt.inputClass = opt.inputClass || "selectbox6";
    opt.containerClass = opt.containerClass || "selectbox-wrapper6";
    opt.hoverClass = opt.hoverClass || "current6";
    opt.currentClass = opt.selectedClass || "selected6"
    opt.debug = opt.debug || false;

    var elm_id = selectobj.id;
    var active = -1;
    var inFocus = false;
    var hasfocus = 0;
    //jquery object for select element
    var $select = $(selectobj);
    // jquery container object
    var $container = setupContainer(opt);
    //jquery input object 
    var $input = setupInput(opt);
    // hide select and append newly created elements
    $select.hide().before($input).before($container);


    init();

    $container.blur(function () {
        $container.hide();
    });

    $input
	.click(function () {
	    //if (!inFocus) {
	        $container.toggle();
	    //}
	})
//	.focus(function () {
//	    if ($container.not(':visible')) {
//	        inFocus = true;
//	        $container.show();
//	    }
//	})
	.keydown(function (event) {
	    switch (event.keyCode) {
	        case 38: // up
	            event.preventDefault();
	            moveSelect(-1);
	            break;
	        case 40: // down
	            event.preventDefault();
	            moveSelect(1);
	            break;
	        //case 9:  // tab      
	        case 13: // return
	            event.preventDefault(); // seems not working in mac !
	            $('li.' + opt.hoverClass).trigger('click');
	            break;
	        case 27: //escape
	            hideMe();
	            break;
	    }
	})
	.blur(function () {
	    if ($container.is(':visible') && hasfocus > 0) {
	        if (opt.debug) console.log('container visible and has focus')
	    } else {
	        // hideMe();
	    }
	});


    function hideMe() {
        hasfocus = 0;
        $container.hide();
        $('#frmPublication').submit();
    }

    function init() {
        $container.append(getSelectOptions($input.attr('id'))).hide();
        var width = $input.css('width');
        $container.width(width);
    }

    function setupContainer(options) {
        var container = document.createElement("div");
        $container = $(container);
        $container.attr('id', elm_id + '_container');
        $container.addClass(options.containerClass);

        return $container;
    }

    function setupInput(options) {
        var input = document.createElement("input");
        var $input = $(input);
        $input.attr("id", elm_id + "_input");
        $input.attr("type", "text");
        $input.addClass(options.inputClass);
        $input.attr("autocomplete", "off");
        $input.attr("readonly", "readonly");
        $input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie

        return $input;
    }

    function moveSelect(step) {
        var lis = $("li", $container);
        if (!lis) return;

        active += step;

        if (active < 0) {
            active = 0;
        } else if (active >= lis.size()) {
            active = lis.size() - 1;
        }

        lis.removeClass(opt.hoverClass);

        $(lis[active]).addClass(opt.hoverClass);
    }

    function setCurrent() {
        var li = $("li." + opt.currentClass, $container).get(0);
        var ar = ('' + li.id).split('_');
        var el = ar[ar.length - 1];
        $select.val(el);
        $input.val($(li).html());
        return true;
    }

    // select value
    function getCurrentSelected() {
        return $select.val();
    }

    // input value
    function getCurrentValue() {
        return $input.val();
    }

    function getSelectOptions(parentid) {
        var select_options = new Array();
        var ul = document.createElement('ul');
        $select.children('option').each(function () {
            var li = document.createElement('li');
            li.setAttribute('id', parentid + '_' + $(this).val());
            li.innerHTML = $(this).html();
            if ($(this).is(':selected')) {
                $input.val($(this).html());
                $(li).addClass(opt.currentClass);
            }
            ul.appendChild(li);
            $(li)
			.mouseover(function (event) {
			    hasfocus = 1;
			    if (opt.debug) console.log('over on : ' + this.id);
			    jQuery(event.target, $container).addClass(opt.hoverClass);
			})
			.mouseout(function (event) {
			    hasfocus = -1;
			    if (opt.debug) console.log('out on : ' + this.id);
			    jQuery(event.target, $container).removeClass(opt.hoverClass);
			})
			.click(function (event) {
			    var fl = $('li.' + opt.hoverClass, $container).get(0);
			    if (opt.debug) console.log('click on :' + this.id);
			    $('li.' + opt.currentClass).removeClass(opt.currentClass);
			    $(this).addClass(opt.currentClass);
			    setCurrent();
			    hideMe();
			});
        });
        return ul;
    }

};






/************************ DropDownList 7 (light grey) - for Publication page, by month *****************************************************************/
jQuery.SelectBox7 = function (selectobj, options) {

    var opt = options || {};
    opt.inputClass = opt.inputClass || "selectbox7";
    opt.containerClass = opt.containerClass || "selectbox-wrapper7";
    opt.hoverClass = opt.hoverClass || "current7";
    opt.currentClass = opt.selectedClass || "selected7"
    opt.debug = opt.debug || false;

    var elm_id = selectobj.id;
    var active = -1;
    var inFocus = false;
    var hasfocus = 0;
    //jquery object for select element
    var $select = $(selectobj);
    // jquery container object
    var $container = setupContainer(opt);
    //jquery input object 
    var $input = setupInput(opt);
    // hide select and append newly created elements
    $select.hide().before($input).before($container);


    init();

    $input
	.click(function () {
	    if (!inFocus) {
	        $container.toggle();
	    }
	})
	.focus(function () {
	    if ($container.not(':visible')) {
	        inFocus = true;
	        $container.show();
	    }
	})
	.keydown(function (event) {
	    switch (event.keyCode) {
	        case 38: // up
	            event.preventDefault();
	            moveSelect(-1);
	            break;
	        case 40: // down
	            event.preventDefault();
	            moveSelect(1);
	            break;
	        //case 9:  // tab       
	        case 13: // return
	            event.preventDefault(); // seems not working in mac !
	            $('li.' + opt.hoverClass).trigger('click');
	            break;
	        case 27: //escape
	            hideMe();
	            break;
	    }
	})
	.blur(function () {
	    if ($container.is(':visible') && hasfocus > 0) {
	        if (opt.debug) console.log('container visible and has focus')
	    } else {
	        hideMe();
	    }
	});


    function hideMe() {
        hasfocus = 0;
        $container.hide();
    }

    function init() {
        $container.append(getSelectOptions($input.attr('id'))).hide();
        var width = $input.css('width');
        $container.width(width);
    }

    function setupContainer(options) {
        var container = document.createElement("div");
        $container = $(container);
        $container.attr('id', elm_id + '_container');
        $container.addClass(options.containerClass);

        return $container;
    }

    function setupInput(options) {
        var input = document.createElement("input");
        var $input = $(input);
        $input.attr("id", elm_id + "_input");
        $input.attr("type", "text");
        $input.addClass(options.inputClass);
        $input.attr("autocomplete", "off");
        $input.attr("readonly", "readonly");
        $input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie

        return $input;
    }

    function moveSelect(step) {
        var lis = $("li", $container);
        if (!lis) return;

        active += step;

        if (active < 0) {
            active = 0;
        } else if (active >= lis.size()) {
            active = lis.size() - 1;
        }

        lis.removeClass(opt.hoverClass);

        $(lis[active]).addClass(opt.hoverClass);
    }

    function setCurrent() {
        var li = $("li." + opt.currentClass, $container).get(0);
        var ar = ('' + li.id).split('_');
        var el = ar[ar.length - 1];
        $select.val(el);
        $input.val($(li).html());
        return true;
    }

    // select value
    function getCurrentSelected() {
        return $select.val();
    }

    // input value
    function getCurrentValue() {
        return $input.val();
    }

    function getSelectOptions(parentid) {
        var select_options = new Array();
        var ul = document.createElement('ul');
        $select.children('option').each(function () {
            var li = document.createElement('li');
            li.setAttribute('id', parentid + '_' + $(this).val());
            li.innerHTML = $(this).html();
            if ($(this).is(':selected')) {
                $input.val($(this).html());
                $(li).addClass(opt.currentClass);
            }
            ul.appendChild(li);
            $(li)
			.mouseover(function (event) {
			    hasfocus = 1;
			    if (opt.debug) console.log('over on : ' + this.id);
			    jQuery(event.target, $container).addClass(opt.hoverClass);
			})
			.mouseout(function (event) {
			    hasfocus = -1;
			    if (opt.debug) console.log('out on : ' + this.id);
			    jQuery(event.target, $container).removeClass(opt.hoverClass);
			})
			.click(function (event) {
			    var fl = $('li.' + opt.hoverClass, $container).get(0);
			    if (opt.debug) console.log('click on :' + this.id);
			    $('li.' + opt.currentClass).removeClass(opt.currentClass);
			    $(this).addClass(opt.currentClass);
			    setCurrent();
			    hideMe();
			});
        });
        return ul;
    }

};

/************************ DropDownList 8 (light grey) - for Capabilities page *****************************************************************/
jQuery.SelectBox8 = function (selectobj, options) {

    var opt = options || {};
    opt.inputClass = opt.inputClass || "selectbox8";
    opt.containerClass = opt.containerClass || "selectbox-wrapper8";
    opt.hoverClass = opt.hoverClass || "current8";
    opt.currentClass = opt.selectedClass || "selected8"
    opt.debug = opt.debug || false;

    var elm_id = selectobj.id;
    var active = -1;
    var inFocus = false;
    var hasfocus = 0;
    //jquery object for select element
    var $select = $(selectobj);
    // jquery container object
    var $container = setupContainer(opt);
    //jquery input object 
    var $input = setupInput(opt);
    // hide select and append newly created elements
    $select.hide().before($input).before($container);


    init();

    $input
	.click(function () {
	    if (!inFocus) {
	        $container.toggle();
	    }
	})
	.focus(function () {
	    if ($container.not(':visible')) {
	        inFocus = true;
	        $container.show();
	    }
	})
	.keydown(function (event) {
	    switch (event.keyCode) {
	        case 38: // up
	            event.preventDefault();
	            moveSelect(-1);
	            break;
	        case 40: // down
	            event.preventDefault();
	            moveSelect(1);
	            break;
	        //case 9:  // tab         
	        case 13: // return
	            event.preventDefault(); // seems not working in mac !
	            $('li.' + opt.hoverClass).trigger('click');
	            break;
	        case 27: //escape
	            hideMe();
	            break;
	    }
	})
	.blur(function () {
	    if ($container.is(':visible') && hasfocus > 0) {
	        if (opt.debug) console.log('container visible and has focus')
	    } else {
	        hideMe();
	    }
	});


    function hideMe() {
        hasfocus = 0;
        $container.hide();
    }

    function init() {
        $container.append(getSelectOptions($input.attr('id'))).hide();
        var width = $input.css('width');
        $container.width(width);
    }

    function setupContainer(options) {
        var container = document.createElement("div");
        $container = $(container);
        $container.attr('id', elm_id + '_container');
        $container.addClass(options.containerClass);

        return $container;
    }

    function setupInput(options) {
        var input = document.createElement("input");
        var $input = $(input);
        $input.attr("id", elm_id + "_input");
        $input.attr("type", "text");
        $input.addClass(options.inputClass);
        $input.attr("autocomplete", "off");
        $input.attr("readonly", "readonly");
        $input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie

        return $input;
    }

    function moveSelect(step) {
        var lis = $("li", $container);
        if (!lis) return;

        active += step;

        if (active < 0) {
            active = 0;
        } else if (active >= lis.size()) {
            active = lis.size() - 1;
        }

        lis.removeClass(opt.hoverClass);

        $(lis[active]).addClass(opt.hoverClass);
    }

    function setCurrent() {
        var li = $("li." + opt.currentClass, $container).get(0);
        var ar = ('' + li.id).split('_');
        var el = ar[ar.length - 1];
        $select.val(el);
        $input.val($(li).html());
        return true;
    }

    // select value
    function getCurrentSelected() {
        return $select.val();
    }

    // input value
    function getCurrentValue() {
        return $input.val();
    }

    function getSelectOptions(parentid) {
        var select_options = new Array();
        var ul = document.createElement('ul');
        $select.children('option').each(function () {
            var li = document.createElement('li');
            li.setAttribute('id', parentid + '_' + $(this).val());
            li.innerHTML = $(this).html();
            if ($(this).is(':selected')) {
                $input.val($(this).html());
                $(li).addClass(opt.currentClass);
            }
            ul.appendChild(li);
            $(li)
			.mouseover(function (event) {
			    hasfocus = 1;
			    if (opt.debug) console.log('over on : ' + this.id);
			    jQuery(event.target, $container).addClass(opt.hoverClass);
			})
			.mouseout(function (event) {
			    hasfocus = -1;
			    if (opt.debug) console.log('out on : ' + this.id);
			    jQuery(event.target, $container).removeClass(opt.hoverClass);
			})
			.click(function (event) {
			    var fl = $('li.' + opt.hoverClass, $container).get(0);
			    if (opt.debug) console.log('click on :' + this.id);
			    $('li.' + opt.currentClass).removeClass(opt.currentClass);
			    $(this).addClass(opt.currentClass);
			    setCurrent();
			    hideMe();
			});
        });
        return ul;
    }

};

/************************ DropDownList 9 (light grey) - for Sub Capabilities page *****************************************************************/
jQuery.SelectBox9 = function (selectobj, options) {

    var opt = options || {};
    opt.inputClass = opt.inputClass || "selectbox9";
    opt.containerClass = opt.containerClass || "selectbox-wrapper9";
    opt.hoverClass = opt.hoverClass || "current9";
    opt.currentClass = opt.selectedClass || "selected9"
    opt.debug = opt.debug || false;

    var elm_id = selectobj.id;
    var active = -1;
    var inFocus = false;
    var hasfocus = 0;
    //jquery object for select element
    var $select = $(selectobj);
    // jquery container object
    var $container = setupContainer(opt);
    //jquery input object 
    var $input = setupInput(opt);
    // hide select and append newly created elements
    $select.hide().before($input).before($container);


    init();

    $input
	.click(function () {
	    if (!inFocus) {
	        $container.toggle();
	    }
	})
	.focus(function () {
	    if ($container.not(':visible')) {
	        inFocus = true;
	        $container.show();
	    }
	})
	.keydown(function (event) {
	    switch (event.keyCode) {
	        case 38: // up
	            event.preventDefault();
	            moveSelect(-1);
	            break;
	        case 40: // down
	            event.preventDefault();
	            moveSelect(1);
	            break;
	        //case 9:  // tab          
	        case 13: // return
	            event.preventDefault(); // seems not working in mac !
	            $('li.' + opt.hoverClass).trigger('click');
	            break;
	        case 27: //escape
	            hideMe();
	            break;
	    }
	})
	.blur(function () {
	    if ($container.is(':visible') && hasfocus > 0) {
	        if (opt.debug) console.log('container visible and has focus')
	    } else {
	        hideMe();
	    }
	});


    function hideMe() {
        hasfocus = 0;
        $container.hide();
    }

    function init() {
        $container.append(getSelectOptions($input.attr('id'))).hide();
        var width = $input.css('width');
        $container.width(width);
    }

    function setupContainer(options) {
        var container = document.createElement("div");
        $container = $(container);
        $container.attr('id', elm_id + '_container');
        $container.addClass(options.containerClass);

        return $container;
    }

    function setupInput(options) {
        var input = document.createElement("input");
        var $input = $(input);
        $input.attr("id", elm_id + "_input");
        $input.attr("type", "text");
        $input.addClass(options.inputClass);
        $input.attr("autocomplete", "off");
        $input.attr("readonly", "readonly");
        $input.attr("tabIndex", $select.attr("tabindex")); // "I" capital is important for ie

        return $input;
    }

    function moveSelect(step) {
        var lis = $("li", $container);
        if (!lis) return;

        active += step;

        if (active < 0) {
            active = 0;
        } else if (active >= lis.size()) {
            active = lis.size() - 1;
        }

        lis.removeClass(opt.hoverClass);

        $(lis[active]).addClass(opt.hoverClass);
    }

    function setCurrent() {
        var li = $("li." + opt.currentClass, $container).get(0);
        var ar = ('' + li.id).split('_');
        var el = ar[ar.length - 1];
        $select.val(el);
        $input.val($(li).html());
        return true;
    }

    // select value
    function getCurrentSelected() {
        return $select.val();
    }

    // input value
    function getCurrentValue() {
        return $input.val();
    }

    function getSelectOptions(parentid) {
        var select_options = new Array();
        var ul = document.createElement('ul');
        $select.children('option').each(function () {
            var li = document.createElement('li');
            li.setAttribute('id', parentid + '_' + $(this).val());
            li.innerHTML = $(this).html();
            if ($(this).is(':selected')) {
                $input.val($(this).html());
                $(li).addClass(opt.currentClass);
            }
            ul.appendChild(li);
            $(li)
			.mouseover(function (event) {
			    hasfocus = 1;
			    if (opt.debug) console.log('over on : ' + this.id);
			    jQuery(event.target, $container).addClass(opt.hoverClass);
			})
			.mouseout(function (event) {
			    hasfocus = -1;
			    if (opt.debug) console.log('out on : ' + this.id);
			    jQuery(event.target, $container).removeClass(opt.hoverClass);
			})
			.click(function (event) {
			    var fl = $('li.' + opt.hoverClass, $container).get(0);
			    if (opt.debug) console.log('click on :' + this.id);
			    $('li.' + opt.currentClass).removeClass(opt.currentClass);
			    $(this).addClass(opt.currentClass);
			    setCurrent();
			    hideMe();
			});
        });
        return ul;
    }

};