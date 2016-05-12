/**
 * application common scripts
 *
 */
"use strict";
var core = {};
// for dfp
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];

/**
 * add required script
 *
 * @return $.Deferred().promise();
 */
core.requiredCalled = [];
core.required = function(string){
	var defer = $.Deferred();
	var path = '/assets/js/';
	var script = path + string;
	if(string.indexOf('http') === 0){
		script = string;
	}
	if($.inArray(script, core.requiredCalled) >= 0){
		defer.resolve();
	} else {
		$.getScript(script).fail(function(){
			// TODO: notify error to user
			defer.reject();
		}).done(function(){
			defer.resolve();
			core.requiredCalled.push(script);
		});
	}
	return defer.promise();
};

/**
 * adjust growl default
 *
 */
core.adjustGrowl = function(){
	core.required('jquery.blockUI.min.js').done(function(){
		$.extend($.blockUI.defaults.growlCSS, {
			// TODO: adjust width, height, centerlize automatically
			width: '500px',
			height: 'auto',
			marginRight: '-250px',
			top: '35%',
			right: '50%',
			opacity: 0.8,
			fontSize: '1rem'
		});
	});
};

/**
 * text countup animation
 *
 * @param jqueryObject $target
 * @param integer from
 * @param integer to
 * @param integer duration millisec
 * @param integer delay millisec
 * @param function callback
 */
core.countUp = function($target, from , to, duration, delay, callback){
	$target.text(from);
	setTimeout(function repeat(){
		if(from <= to) {
			$target.text(from);
			from++;
			setTimeout(repeat, duration);
		} else if(typeof callback === 'function') {
			callback();
		}
	}, duration + delay);
	return true;
}

/**
 * check max length
 * can use in textarea, input text and so on
 *
 * @param jqueryObject $inputAreaObj
 * @param jqueryObject $maxLengthCntAreaObj
 * @param jqueryObject $submitAreaObj
 */
core.checkMaxLength = function($inputAreaObj, $maxLengthCntAreaObj, $submitAreaObj){
	$inputAreaObj.bind('keypress keydown keyup', function(){
		var maxlen = parseInt($maxLengthCntAreaObj.attr('maxlength'));
		var curlen = $(this).val().length;
		$maxLengthCntAreaObj.text(maxlen - curlen);
		if(maxlen < curlen) {
			$submitAreaObj.attr('disabled', 'disabled');
		} else {
			$submitAreaObj.attr('disabled', null);
		}
	});
}

/**
 * getUrlVars for me
 *
 * @referrence
 *  http://apr20.net/web/jquery/2215/
 */
core.getUrlVars = function(url){
	if(typeof url === 'undefined') {
		url = window.location;
	} else {
		var tmp = document.createElement('a');
		tmp.href = url;
		url = tmp;
	}
	var vars = [], hash, arrName, keyName;
	if(url.search.length < 2) {
		return vars;
	}
	var hashes = url.search.slice(url.search.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		arrName = hash[0].replace(/\[.*\]$/gi, '');
		keyName = hash[0].replace(/^[^\[]+/gi, '').replace(/[\[\]]/gi, '');
		vars.push(hash[0]);
		if(hash[0].indexOf('[') > 0 && hash[0].indexOf(']') > 0){
			if (typeof vars[arrName] === 'undefined') {
				vars[arrName] = [];
			}
			vars[arrName].push(hash[1]);
			if(keyName.length > 0) {
				vars[arrName][keyName] = hash[1];
			}
		} else {
			vars[hash[0]] = hash[1];
		}
	}
	return vars;
}

/**
 * smartphone check
 *
 */
core.isSP = function() {
	var ua = navigator.userAgent;
	return (
		ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 ||
		ua.indexOf('iPad') > 0 || ua.indexOf('iPod') > 0
	);
}

/**
 * page bottom auto method loader
 *
 * @param function method
 */
core.autoBottomLoad = function(method) {
	// TODO: args check
	$(window).scroll(function(){
		var total = $(document).height();
		var position = $(window).scrollTop() + $(window).height();
		if(position >= total - 100)
		{
			return method();
		}
	});
}

/**
 * vertical-align: middle
 *
 * @param jqueryObject $object
 */
core.verticalAlignMiddle = function($object){
	var $tables = $("<span><span><span></span></span></span>");
	$tables.css({
		display: "table",
		height: $object.height()+'px'
	});
	$tables.find('span').css({
		display: "table-row"
	});
	$tables.find('span > span').css({
		display: "table-cell",
		verticalAlign: "middle"
	});
	$object.wrapInner($tables[0]);
	$(window).resize(function(){
		$object.children().height($object.height()+'px');
	});
}

/**
 * dfp tag insert
 *
 */
core.dfp = {
	runup: function() {
		var gads = document.createElement('script');
		gads.async = true;
		gads.type = 'text/javascript';
		var useSSL = 'https:' == document.location.protocol;
		gads.src = (useSSL ? 'https:' : 'http:') +
		'//www.googletagservices.com/tag/js/gpt.js';
		var node = document.getElementsByTagName('script')[0];
		node.parentNode.insertBefore(gads, node);
	},
	display: function(addUnitPath, size, opt_div) {
		if($('#'+opt_div).size() > 0) {
			googletag.cmd.push(function() {
				googletag.defineSlot(addUnitPath, size, opt_div).addService(googletag.pubads());
				googletag.pubads().enableSingleRequest();
				googletag.enableServices();
				googletag.display(opt_div);
			});
		}
	}
}

/**
 * send task queues
 */
core.sendQueue = function(method, args, dup_type)
{
	$.ajax({
		async: true,
		url: '/queue',
		type: 'POST',
		dataType: 'json',
		data: {
			method: method,
			args: args,
			type: dup_type
		}
	}).fail(function(request){
		console.error(request);
	});
}
