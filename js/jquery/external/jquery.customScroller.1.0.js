/* Copyright (c) 2009 Domenico Gigante (http://scripts.reloadlab.net)
 * Thanks to: http://fromvega.com/scripts for drag effect.
 * Thanks for the community that is helping the improvement
 * of this little piece of code.
 *
 * Version: 1.0.0
 * Date: 15th Oct, 2009
 * 
 * Requires: jQuery 1.3.2+, jquery.mousewheel.js 3.0.2+, jquery.wresize.js 1.1+
 */

(function ($) {
	// collection of object elements
	var _that = {};
	var _divs = {};
	var _settings;
	
	// some vars to use in resize window event
	var _topDiv = 0;
	var _leftDiv = 0;
	var _resizeTimer = null;
	
	// set on focus
	var _isOnFocus;
	
	// set selectable
	var _isSelectable;
	var _selectDirection;
	
	// scroll interval
	var _intervalid;
	
	// Main Plugin (Scroller Set)
	$.fn.customScroller = function (options) {
		
		// some private vars
		var _containerHTML;
		var _vscrollerHTML;
		var _oscrollerHTML;
		var _vscroll = {};
		var _oscroll = {};
		var _curDate;
		
		_settings = $.extend({
			width: null,
			height: null,
			speed: 4
		}, options);
		
		if (this.length > 0) {
			
			this.each(function (index, domElement) {
				
				// ID UNIQUE
				var _uniqueID = (_curDate === new Date().getTime())? "ID_" + ((new Date().getTime()) + 1000): "ID_" + (new Date().getTime());
				
				// OBJECT DIVS ARRAY
				_divs[_uniqueID] = {};
				
				// if no id is defined assign a unique one
				if (undefined === this.id || !this.id.length) this.id = "customScroller_" + (new Date().getTime());

				// this referrer
				if (!_that[this.id]) _that[this.id] = this;
				this._uniqueID = _uniqueID;
				
				// onclick set focus on element
				$(this).bind('mousedown', function (e) {
					e.stopPropagation();
					_isOnFocus = _uniqueID;
				});
					
				// get div height and width
				if (!_settings.width) {
					if ($(this).css('width') !== 'auto') {
						_divs[_uniqueID].width = ($(this).css('width').indexOf('%') > 0)?'100%':parseInt($(this).css('width'), 10) + 'px';
					} else {
						// problem if no width is set
						return false;
					}
				} else {
					_divs[_uniqueID].width = ((_settings.width + '').indexOf('%') > 0 || (_settings.width + '').indexOf('px') > 0)?_settings.width:parseInt(_settings.width, 10) + 'px';
					$(this).css('width', _divs[_uniqueID].width);
				}
				if (!_settings.height) {
					if ($(this).css('height') !== 'auto') {
						_divs[_uniqueID].height = ($(this).css('height').indexOf('%') > 0)?'100%':parseInt($(this).css('height'), 10) + 'px';
					} else {
						// problem if no height is set
						return false;
					}
				} else {
					_divs[_uniqueID].height = ((_settings.height + '').indexOf('%') > 0 || (_settings.height + '').indexOf('px') > 0)?_settings.height:parseInt(_settings.height, 10) + 'px';
					$(this).css('height', _divs[_uniqueID].height);
				}
				
				// set this overflow hidden, position relative
				$(this).css("overflow", "hidden");
				$(this).css("position", "relative");
				
				// set speed scroll (px/20 millisecondi)
				_divs[_uniqueID].speed = (!$(this).attr('speed'))?_settings.speed:parseInt($(this).attr('speed'), 10);
				if (isNaN(_divs[_uniqueID].speed)) _divs[_uniqueID].speed = _settings.speed;
				
				_vscroll[_uniqueID] = false;
				_oscroll[_uniqueID] = false;

				// HTML container template
				_containerHTML = '<div class="customScrollerContainer" id="customScrollerContainer_' + _uniqueID + '" style="position: relative; width: ' + _divs[_uniqueID].width + '; height: ' + _divs[_uniqueID].height + '; overflow: hidden; padding: 0px; margin: 0px;">';
				_containerHTML += '<div class="customScrollerContent" id="customScrollerContent_' + _uniqueID + '" style="position: absolute; left: ' + _leftDiv + 'px; top: ' + _topDiv + 'px; padding: 0px; margin: 0px; border: 0px;">';
				_containerHTML += $(this).html();
				_containerHTML += '</div></div>';
				$(this).html(_containerHTML);
				
				// HTML vertical scroller template
				_vscrollerHTML = '<div id="divVScrollerBar_' + _uniqueID + '" class="divVScrollerBar" style="float: right; height: ' + _divs[_uniqueID].height + '; padding: 0px; overflow: hidden;">';
				_vscrollerHTML += '<span id="divVScrollerBar_up_' + _uniqueID + '" class="divVScrollerBarUp" style="display: block; width: 100%; overflow: hidden;"><span></span></span>';
				_vscrollerHTML += '<span id="divVScrollerBar_trace_' + _uniqueID + '" class="divVScrollerBarTrace" style="display: block; position: relative; overflow: hidden; width: 100%; padding: 0px; margin: 0px;">';
				_vscrollerHTML += '<span id="divVScrollerBar_cursor_' + _uniqueID + '" class="divVScrollerBarCursor" style="display: block; width: 100%; padding: 0px; margin: 0px; position: absolute; top: 0px; left: 0px;"><span></span></span>';
				_vscrollerHTML += '</span>';
				_vscrollerHTML += '<span id="divVScrollerBar_down_' + _uniqueID + '" class="divVScrollerBarDown" style="display: block; width: 100%; overflow: hidden;"><span></span></span>';
				_vscrollerHTML += '</div>';
				
				// HTML orizontal scroller template
				_oscrollerHTML = '<div id="divOScrollerBar_' + _uniqueID + '" class="divOScrollerBar" style="float: left; width: ' + _divs[_uniqueID].width + '; padding: 0px; overflow: hidden;">';
				_oscrollerHTML += '<span id="divOScrollerBar_left_' + _uniqueID + '" class="divOScrollerBarLeft" style="display: block; height: 100%; overflow: hidden; float: left; margin: 0px;"><span></span></span>';
				_oscrollerHTML += '<span id="divOScrollerBar_trace_' + _uniqueID + '" class="divOScrollerBarTrace" style="display: block; position: relative; overflow: hidden; height: 100%; float: left; padding: 0px; margin: 0px;">';
				_oscrollerHTML += '<span id="divOScrollerBar_cursor_' + _uniqueID + '" class="divOScrollerBarCursor" style="display: block; height: 100%; padding: 0px; margin: 0px; position: absolute; top: 0px; left: 0px;"><span></span></span>';
				_oscrollerHTML += '</span>';
				_oscrollerHTML += '<span id="divOScrollerBar_right_' + _uniqueID + '" class="divOScrollerBarRight" style="display: block; height: 100%; overflow: hidden; float: left; margin: 0px;"><span></span></span>';
				_oscrollerHTML += '<div style="clear: both;"></div></div>';
				
				// container and content referrer
				_divs[_uniqueID].objContainer = $("#customScrollerContainer_" + _uniqueID);
				_divs[_uniqueID].objContent = $("#customScrollerContent_" + _uniqueID);
				
				// get container and content height
				_divs[_uniqueID].containerHeight = _divs[_uniqueID].objContainer.height();
				_divs[_uniqueID].contentHeight = _divs[_uniqueID].objContent.outerHeight(true);
				_divs[_uniqueID].containerOffset = _divs[_uniqueID].objContainer.offset();
				
				// if content height > container height, then...
				if (parseInt(_divs[_uniqueID].containerHeight, 10) > 0 && _divs[_uniqueID].contentHeight > _divs[_uniqueID].containerHeight) {
					
					// set vertical scroller exist
					_vscroll[_uniqueID] = true;
					
					// set float container
					_divs[_uniqueID].objContainer.css('float', 'left');
					
					// prepend vertical scroller
					$(this).prepend(_vscrollerHTML);
					
					// vertical scroller objects referrer
					_divs[_uniqueID].objVScroller = $("#divVScrollerBar_" + _uniqueID);
					_divs[_uniqueID].objUp = $("#divVScrollerBar_up_" + _uniqueID);
					_divs[_uniqueID].objDown = $("#divVScrollerBar_down_" + _uniqueID);
					_divs[_uniqueID].objVTrace = $("#divVScrollerBar_trace_" + _uniqueID);
					_divs[_uniqueID].objVCursor = $("#divVScrollerBar_cursor_" + _uniqueID);
					
					/* SET VERTICAL SCROLL */
					// set scroller height
					_divs[_uniqueID].objVScroller.css('height', _divs[_uniqueID].containerHeight + 'px');
					
					// set trace height
					_divs[_uniqueID].objVTrace.css('height', (_divs[_uniqueID].containerHeight - _divs[_uniqueID].objUp.outerHeight(true) - _divs[_uniqueID].objDown.outerHeight(true)) + 'px');
					
					// get trace height
					_divs[_uniqueID].traceHeight = parseInt(_divs[_uniqueID].objVTrace.css('height'), 10);
					
					// get cursor height
					_divs[_uniqueID].cursorHeight = Math.ceil((_divs[_uniqueID].traceHeight * _divs[_uniqueID].containerHeight) / _divs[_uniqueID].contentHeight);
					
					// difference between trace height and cursor height
					_divs[_uniqueID].traceVVoid = _divs[_uniqueID].traceHeight - _divs[_uniqueID].cursorHeight;
					
					// actual trace position top
					_divs[_uniqueID].posVTrace = _divs[_uniqueID].objVTrace.offset().top;
					
					// set cursor height
					_divs[_uniqueID].objVCursor.css('height', _divs[_uniqueID].cursorHeight + 'px');
					
					// set cursor top position
					var cursorY = (0 - parseInt(_topDiv, 10)) * _divs[_uniqueID].traceVVoid / (_divs[_uniqueID].contentHeight - _divs[_uniqueID].containerHeight);
					_divs[_uniqueID].objVCursor.css('top', cursorY + 'px'); // imposta scrol cursore
					
					// set container width
					_divs[_uniqueID].objContainer.css('width', (_divs[_uniqueID].objContainer.width() - _divs[_uniqueID].objVScroller.outerWidth(true) - 1) + 'px');
					
					// get container and content height
					_divs[_uniqueID].containerHeight = _divs[_uniqueID].objContainer.height();
					_divs[_uniqueID].contentHeight = _divs[_uniqueID].objContent.outerHeight();
					/* END */
					
					// set cursor draggable
					$(_divs[_uniqueID].objVCursor).dragCursor({maxBottom: _divs[_uniqueID].traceVVoid});
					
					// Events
					_divs[_uniqueID].objContainer.bind('mousedown', function (e) {
						_isSelectable = _uniqueID;
						_selectDirection = null;
					});
					
					_divs[_uniqueID].objContainer.bind('mousemove', function (e) {
	
						if (!_isSelectable) return;
						
						var containerOffset = _divs[_isSelectable].containerOffset;
						var containerHeight = _divs[_isSelectable].containerHeight;
						var containerWidth = _divs[_isSelectable].containerWidth;
						
						_stopMove();
						
						if (_vscroll[_isSelectable] === true && e.pageY > containerOffset.top && e.pageY < containerOffset.top + 10) {
							_selectDirection = 'up';
							_startMoveUp(_divs[_isSelectable], 1);
						}
						else if (_oscroll[_isSelectable] === true && e.pageX > containerOffset.left && e.pageX < containerOffset.left + 10) {
							_selectDirection = 'left';
							_startMoveLeft(_divs[_isSelectable], 1);
						}
						else if (_vscroll[_isSelectable] === true && e.pageY > (containerOffset.top + containerHeight - 10) && e.pageY < (containerOffset.top + containerHeight)) {
							_selectDirection = 'down';
							_startMoveDown(_divs[_isSelectable], -1);
						}
						else if (_oscroll[_isSelectable] === true && e.pageX > (containerOffset.left + containerWidth - 10) && e.pageX < (containerOffset.left + containerWidth)) {
							_selectDirection = 'right';
							_startMoveRight(_divs[_isSelectable], -1);
						}
					});

					_divs[_uniqueID].objContainer.bind('mouseup', function (e) {
						_isSelectable = null;
						_stopMove();
						_selectDirection = null;
					});
					
					_divs[_uniqueID].objContainer.bind('mousewheel', function (e, delta) {
						(delta > 0)?_moveUp(_divs[_uniqueID], delta):_moveDown(_divs[_uniqueID], delta);
						return false;
					});
					
					_divs[_uniqueID].objVTrace.bind("mousedown", function (e) {
						var spanY = (e.pageY - _divs[_uniqueID].posVTrace);
						if (spanY > (_divs[_uniqueID].cursorHeight + parseInt(_divs[_uniqueID].objVCursor.css('top'), 10))) {
							_moveDown(_divs[_uniqueID], -3);
						} else if (spanY < parseInt(_divs[_uniqueID].objVCursor.css('top'), 10)) {
							_moveUp(_divs[_uniqueID], 3);
						}
						return false;
					});
					
					_divs[_uniqueID].objUp.bind("mouseover", function (e) {
						$('span', this).addClass('hover');
						_startMoveUp(_divs[_uniqueID]);
						return false;
					});
					
					_divs[_uniqueID].objDown.bind("mouseover", function (e) {
						$('span', this).addClass('hover');
						_startMoveDown(_divs[_uniqueID]);
						return false;
					});
					
					_divs[_uniqueID].objUp.bind("mouseout", function (e) {
						$('span', this).removeClass('hover');
						_stopMove();
						return false;
					});
					
					_divs[_uniqueID].objDown.bind("mouseout", function (e) {
						$('span', this).removeClass('hover');
						_stopMove();
						return false;
					});
					
					_divs[_uniqueID].objVCursor.bind("mouseover", function (e) {
						$('span', this).addClass('hover');
						return false;
					});

					_divs[_uniqueID].objVCursor.bind("mouseout", function (e) {
						$('span', this).removeClass('hover');
						return false;
					});

					$(_divs[_uniqueID].objVCursor).ondrag(function (e, element) { 
						var cursorY = parseInt(_divs[_uniqueID].objVCursor.css('top'), 10);
						var contentY = 0 - (cursorY * (_divs[_uniqueID].contentHeight - _divs[_uniqueID].containerHeight) / _divs[_uniqueID].traceVVoid);
						_divs[_uniqueID].objContent.css('top', contentY + "px");
						return false;
					});
				}
				
				// get container and content width
				_divs[_uniqueID].containerWidth = _divs[_uniqueID].objContainer.width();
				_divs[_uniqueID].contentWidth = _divs[_uniqueID].objContent.outerWidth();
	
				// if content width > container width, then...
				if (parseInt(_divs[_uniqueID].containerWidth, 10) > 0 && _divs[_uniqueID].contentWidth > _divs[_uniqueID].containerWidth) {

					// set orizzontal scroller exist
					_oscroll[_uniqueID] = true;

					// append orizzontal scroller
					$(this).append(_oscrollerHTML);
					
					// orizzontal scroller objects referrer
					_divs[_uniqueID].objOScroller = $("#divOScrollerBar_" + _uniqueID);
					_divs[_uniqueID].objLeft = $("#divOScrollerBar_left_" + _uniqueID);
					_divs[_uniqueID].objRight = $("#divOScrollerBar_right_" + _uniqueID);
					_divs[_uniqueID].objOTrace = $("#divOScrollerBar_trace_" + _uniqueID);
					_divs[_uniqueID].objOCursor = $("#divOScrollerBar_cursor_" + _uniqueID);
					
					/* SET ORIZZONTAL SCROLL */
					// set scroller width
					_divs[_uniqueID].objOScroller.css('width', _divs[_uniqueID].containerWidth + 'px');
					
					// set trace width
					_divs[_uniqueID].objOTrace.css('width', (_divs[_uniqueID].containerWidth - _divs[_uniqueID].objLeft.outerWidth(true) - _divs[_uniqueID].objRight.outerWidth(true)) + 'px');
					
					// get trace width
					_divs[_uniqueID].traceWidth = parseInt(_divs[_uniqueID].objOTrace.css('width'), 10);
					
					// get cursor width
					_divs[_uniqueID].cursorWidth = Math.ceil((_divs[_uniqueID].traceWidth * _divs[_uniqueID].containerWidth) / _divs[_uniqueID].contentWidth);
					
					// difference between trace width and cursor width
					_divs[_uniqueID].traceOVoid = _divs[_uniqueID].traceWidth - _divs[_uniqueID].cursorWidth;
					
					// actual trace position left
					_divs[_uniqueID].posOTrace = _divs[_uniqueID].objOTrace.offset().left;
					
					// set cursor width
					_divs[_uniqueID].objOCursor.css('width', _divs[_uniqueID].cursorWidth + 'px');
					
					// set cursor left position
					var cursorX = (0 - parseInt(_leftDiv, 10)) * _divs[_uniqueID].traceOVoid / (_divs[_uniqueID].contentWidth - _divs[_uniqueID].containerWidth);
					_divs[_uniqueID].objOCursor.css('left', cursorX + 'px');
	
					// set container height
					_divs[_uniqueID].objContainer.css('height', (_divs[_uniqueID].objContainer.height() - _divs[_uniqueID].objOScroller.outerHeight(true)) + 'px');
					
					// get container and content width
					_divs[_uniqueID].containerWidth = _divs[_uniqueID].objContainer.width();
					_divs[_uniqueID].contentWidth = _divs[_uniqueID].objContent.outerWidth();
					/* END */
					
					// if vertical scroller exist, then...
					if (_vscroll[_uniqueID] === true) {
						// set scroller height
						_divs[_uniqueID].objVScroller.css('height', _divs[_uniqueID].containerHeight + 'px');
						
						// set trace height
						_divs[_uniqueID].objVTrace.css('height', (_divs[_uniqueID].containerHeight - _divs[_uniqueID].objUp.outerHeight(true) - _divs[_uniqueID].objDown.outerHeight(true)) + 'px');
						
						// get trace height
						_divs[_uniqueID].traceHeight = parseInt(_divs[_uniqueID].objVTrace.css('height'), 10);
						
						// get cursor height
						_divs[_uniqueID].cursorHeight = Math.ceil((_divs[_uniqueID].traceHeight * _divs[_uniqueID].containerHeight) / _divs[_uniqueID].contentHeight);
						
						// difference between trace height and cursor height
						_divs[_uniqueID].traceVVoid = _divs[_uniqueID].traceHeight - _divs[_uniqueID].cursorHeight;
						
						// set cursor height
						_divs[_uniqueID].objVCursor.css('height', _divs[_uniqueID].cursorHeight + 'px');
						
						// set cursor top position
						var cursorY = (0 - parseInt(_topDiv, 10)) * _divs[_uniqueID].traceVVoid / (_divs[_uniqueID].contentHeight - _divs[_uniqueID].containerHeight);
						_divs[_uniqueID].objVCursor.css('top', cursorY + 'px'); // imposta scrol cursore
		
						// get container and content height
						_divs[_uniqueID].containerHeight = _divs[_uniqueID].objContainer.height();
						_divs[_uniqueID].contentHeight = _divs[_uniqueID].objContent.outerHeight();
					}
					
					// set cursor draggable
					$(_divs[_uniqueID].objOCursor).dragCursor({maxRight: _divs[_uniqueID].traceOVoid});
					
					// Events
					if (_vscroll[_uniqueID] === false) {
						_divs[_uniqueID].objContainer.bind('mousewheel', function (e, delta) {
							(delta > 0)?_moveLeft(_divs[_uniqueID], delta):_moveRight(_divs[_uniqueID], delta);
							return false;
						});
						
						_divs[_uniqueID].objContainer.bind('mousedown', function (e) {
							_isSelectable = _uniqueID;
							_selectDirection = null;
						});
						
						_divs[_uniqueID].objContainer.bind('mousemove', function (e) {
		
							if (!_isSelectable) return;
							
							var containerOffset = _divs[_isSelectable].containerOffset;
							var containerHeight = _divs[_isSelectable].containerHeight;
							var containerWidth = _divs[_isSelectable].containerWidth;
							
							_stopMove();
							
							if (_vscroll[_isSelectable] === true && e.pageY > containerOffset.top && e.pageY < containerOffset.top + 10) {
								_selectDirection = 'up';
								_startMoveUp(_divs[_isSelectable], 1);
							}
							else if (_oscroll[_isSelectable] === true && e.pageX > containerOffset.left && e.pageX < containerOffset.left + 10) {
								_selectDirection = 'left';
								_startMoveLeft(_divs[_isSelectable], 1);
							}
							else if (_vscroll[_isSelectable] === true && e.pageY > (containerOffset.top + containerHeight - 10) && e.pageY < (containerOffset.top + containerHeight)) {
								_selectDirection = 'down';
								_startMoveDown(_divs[_isSelectable], -1);
							}
							else if (_oscroll[_isSelectable] === true && e.pageX > (containerOffset.left + containerWidth - 10) && e.pageX < (containerOffset.left + containerWidth)) {
								_selectDirection = 'right';
								_startMoveRight(_divs[_isSelectable], -1);
							}
						});
	
						_divs[_uniqueID].objContainer.bind('mouseup', function (e) {
							_isSelectable = null;
							_stopMove();
							_selectDirection = null;
						});
					}
					
					_divs[_uniqueID].objOTrace.bind("mousedown", function (e) {
						var spanX = (e.pageX - _divs[_uniqueID].posOTrace);
						if (spanX > (_divs[_uniqueID].cursorWidth + parseInt(_divs[_uniqueID].objOCursor.css('left'), 10))) {
							_moveRight(_divs[_uniqueID], -3);
						} else if (spanX < parseInt(_divs[_uniqueID].objOCursor.css('left'), 10)) {
							_moveLeft(_divs[_uniqueID], 3);
						}
						return false;
					});
					
					_divs[_uniqueID].objLeft.bind("mouseover", function (e) {
						$('span', this).addClass('hover');
						_startMoveLeft(_divs[_uniqueID]);
						return false;
					});
					
					_divs[_uniqueID].objRight.bind("mouseover", function (e) {
						$('span', this).addClass('hover');
						_startMoveRight(_divs[_uniqueID]);
						return false;
					});
					
					_divs[_uniqueID].objLeft.bind("mouseout", function (e) {
						$('span', this).removeClass('hover');
						_stopMove();
						return false;
					});
					
					_divs[_uniqueID].objRight.bind("mouseout", function (e) {
						$('span', this).removeClass('hover');
						_stopMove();
						return false;
					});
					
					_divs[_uniqueID].objOCursor.bind("mouseover", function (e) {
						$('span', this).addClass('hover');
						return false;
					});

					_divs[_uniqueID].objOCursor.bind("mouseout", function (e) {
						$('span', this).removeClass('hover');
						return false;
					});

					$(_divs[_uniqueID].objOCursor).ondrag(function (e, element) { 
						var cursorX = parseInt(_divs[_uniqueID].objOCursor.css('left'), 10);
						var contentX = 0 - (cursorX * (_divs[_uniqueID].contentWidth - _divs[_uniqueID].containerWidth) / _divs[_uniqueID].traceOVoid);
						_divs[_uniqueID].objContent.css('left', contentX + "px");
						return false;
					});
				}
				
				// if no scroller, then..
				if (_vscroll[_uniqueID] === false) {
					_divs[_uniqueID].objContent.css('top', '0px');
				}
				if (_oscroll[_uniqueID] === false) {
					_divs[_uniqueID].objContent.css('left', '0px');
				}
					
				$(this).append('<div style="clear: both;"></div>');
	
			});
			
			// Add anchors support
			$('a').each(function (index, domElement) {
				var getHref = $(this).attr('href');
				if (getHref && getHref.indexOf('#') !== -1) {
					var anchors = getHref.replace(window.location.href, '');
					anchors = anchors.substring(anchors.indexOf('#'));
				}
				var targets = $(this).attr('target');
				if (anchors && _that[targets] && anchors.charAt(0) === '#') {
					$(this).bind('click', function (e) {
						if (anchors && _that[targets]._uniqueID) {
							var topAnchor = $('a[name=' + anchors.substring(1) + ']').parent().offset().top;
							var topContainer = _divs[_that[targets]._uniqueID].objContainer.offset().top;
							var topContent = parseInt(_divs[_that[targets]._uniqueID].objContent.css('top'), 10);
							
							var offScroll = topContent + (-1 * (parseInt(topAnchor - topContainer, 10))); 
							
							var maxScroll = (_divs[_that[targets]._uniqueID].contentHeight * (-1) + _divs[_that[targets]._uniqueID].containerHeight);
							
							if (offScroll < maxScroll) {
								offScroll = maxScroll;
							}
							
							_divs[_that[targets]._uniqueID].objContent.css('top', offScroll + 'px');
							
							// set cursor top position
							var cursorY = (0 - parseInt(offScroll, 10)) * _divs[_that[targets]._uniqueID].traceVVoid / (_divs[_that[targets]._uniqueID].contentHeight - _divs[_that[targets]._uniqueID].containerHeight);
							_divs[_that[targets]._uniqueID].objVCursor.css('top', cursorY + 'px'); // imposta scrol cursore
						}
	
						return false;
					});
				}
			});
		}
	};
	
	// All move function
	var _startMoveDown = function (objCopy, wheelDelta) {
		_intervalid = window.setInterval(function () { _moveDown(objCopy, wheelDelta); }, 20);
	};
		
	var _startMoveUp = function (objCopy, wheelDelta) {
		_intervalid = window.setInterval(function () { _moveUp(objCopy, wheelDelta); }, 20);
	};
		
	var _startMoveRight = function (objCopy, wheelDelta) {
		_intervalid = window.setInterval(function () { _moveRight(objCopy, wheelDelta); }, 20);
	};
		
	var _startMoveLeft = function (objCopy, wheelDelta) {
		_intervalid = window.setInterval(function () { _moveLeft(objCopy, wheelDelta); }, 20);
	};
		
	var _stopMove = function () {
		window.clearInterval(_intervalid);
	};
		
	var _moveDown = function (objCopy, wheelDelta) {
		var increment;
		if (wheelDelta) increment = -1 * parseInt(wheelDelta * 5, 10);
		else increment = 1;
		var scrolling = parseInt(objCopy.objContent.css('top'), 10);
		var maxScroll = (objCopy.contentHeight * (-1) + objCopy.containerHeight);
		if (scrolling >= maxScroll) {
			var delTop = scrolling - parseInt(objCopy.speed * increment, 10);
			if (delTop < maxScroll) delTop = maxScroll;
			objCopy.objContent.css('top', delTop + 'px');
			var addTop = parseInt((((0 - delTop) * objCopy.traceVVoid) / (objCopy.contentHeight - objCopy.containerHeight)), 10);
			objCopy.objVCursor.css('top', addTop + 'px');
		}
	};
		
	var _moveUp = function (objCopy, wheelDelta) {
		var increment;
		if (wheelDelta) increment = parseInt(wheelDelta * 5, 10);
		else increment = 1;
		var scrolling = parseInt(objCopy.objContent.css('top'), 10);
		if (scrolling <= 0) {
			var addTop = scrolling + parseInt(objCopy.speed * increment, 10);
			if (addTop > 0) addTop = 0;
			objCopy.objContent.css('top', addTop + 'px');
			var delTop = parseInt((((0 - addTop) * objCopy.traceVVoid) / (objCopy.contentHeight - objCopy.containerHeight)), 10);
			objCopy.objVCursor.css('top', delTop + 'px');
		}
	};
	
	var _moveRight = function (objCopy, wheelDelta) {
		var increment;
		if (wheelDelta) increment = -1 * parseInt(wheelDelta * 5, 10);
		else increment = 1;
		var scrolling = parseInt(objCopy.objContent.css('left'), 10);
		var maxScroll = (objCopy.contentWidth * (-1) + objCopy.containerWidth);
		if (scrolling >= maxScroll) {
			var delRight = scrolling - parseInt(objCopy.speed * increment, 10);
			if (delRight < maxScroll) delRight = maxScroll;
			objCopy.objContent.css('left', delRight + 'px');
			var addLeft = parseInt((((0 - delRight) * objCopy.traceOVoid) / (objCopy.contentWidth - objCopy.containerWidth)), 10);
			objCopy.objOCursor.css('left', addLeft + 'px');
		}
	};
		
	var _moveLeft = function (objCopy, wheelDelta) {
		var increment;
		if (wheelDelta) increment = parseInt(wheelDelta * 5, 10);
		else increment = 1;
		var scrolling = parseInt(objCopy.objContent.css('left'), 10);
		if (scrolling <= 0) {
			var addLeft = scrolling + parseInt(objCopy.speed * increment, 10);
			if (addLeft > 0) addLeft = 0;
			objCopy.objContent.css('left', addLeft + 'px');
			var delRight = parseInt((((0 - addLeft) * objCopy.traceOVoid) / (objCopy.contentWidth - objCopy.containerWidth)), 10);
			objCopy.objOCursor.css('left', delRight + 'px');
		}
	};
	
	// Drag Plugin (Cursors Draggable)
	$.fn.dragCursor = function (options) {
		// some private vars
		var _isMouseDown = false;
		var _currentElement = null;
		var _dragCallbacks = {};
		var _dropCallbacks = {};
		var _dragStatus = {};
		var _lastMouseX;
		var _lastMouseY;
		var _lastElemTop;
		var _lastElemLeft;
		
		options = $.extend({
			maxTop:0,
			maxRight:0,
			maxBottom:0,
			maxLeft:0
		}, options);
		
		// register the function to be called while an element is being dragged
		$.fn.ondrag = function (callback) {
			return this.each(function () {
				_dragCallbacks[this.id] = callback;
			});
		};
		
		// register the function to be called when an element is dropped
		$.fn.ondrop = function (callback) {
			return this.each(function () {
				_dropCallbacks[this.id] = callback;
			});
		};
	
		if (this.length > 0) {
			this.each(function (index, domElement) {
				// if no id is defined assign a unique one
				if (undefined === domElement.id || !domElement.id.length) domElement.id = "dragableCursor_"+(new Date().getTime());
				
				// set dragStatus 
				_dragStatus[domElement.id] = "on";
				
				// when an element receives a mouse press
				$(this).bind("mousedown", function (e) {
					
					// if drag status is off, break
					if ((_dragStatus[this.id] === "off"))
						return false;
					
					// set it as absolute positioned
					$(this).css("position", "absolute");
					
					// set z-index
					$(this).css("z-index", parseInt(new Date().getTime()/1000), 10);
					
					// update track variables
					_isMouseDown = true;
					_currentElement = this;
					
					// retrieve positioning properties
					var offset = $(this).offset();
					var parentOffSet = $(this).offsetParent();
					var additionalOffSet = {};
					if (parentOffSet.length > 0) {
						additionalOffSet.top = parentOffSet.offset().top;
						additionalOffSet.left = parentOffSet.offset().left;
					}
					
					// global position records
					_lastMouseX = e.pageX;
					_lastMouseY = e.pageY;
					
					_lastElemTop = offset.top - additionalOffSet.top;
					_lastElemLeft = offset.left - additionalOffSet.left;
					
					// update the position
					updatePosition(e);
					
					return false;
				});
			});
		}
		
		// updates the position of the current element being dragged
		var updatePosition = function (e) {
			var spanX = (e.pageX - _lastMouseX);
			var spanY = (e.pageY - _lastMouseY);
			
			var Y = _lastElemTop + spanY;
			var X = _lastElemLeft + spanX;
			
			if (options.maxTop !== null && Y < options.maxTop) Y = options.maxTop;
			if (options.maxLeft !== null && X < options.maxLeft) X = options.maxLeft;
			if (options.maxBottom !== null && Y > options.maxBottom) Y = options.maxBottom;
			if (options.maxRight !== null && X > options.maxRight) X = options.maxRight;
					
			$(_currentElement).css("top",  Y + 'px');
			$(_currentElement).css("left", X + 'px');
		};
		
		// when the mouse is moved while the mouse button is pressed
		$(document).bind("mousemove", function (e) {
			if (_isMouseDown === true && _dragStatus[_currentElement.id] !== 'off') {
				// update the position and call the registered function
				updatePosition(e);
				if (typeof _dragCallbacks[_currentElement.id] === 'function') {
					_dragCallbacks[_currentElement.id](e, _currentElement);
				}
				
				return false;
			}
		});
		
		// when the mouse button is released
		$(document).bind("mouseup", function (e) {
			if (_isMouseDown === true && _dragStatus[_currentElement.id] !== 'off') {
				_isMouseDown = false;
				if (typeof _dropCallbacks[_currentElement.id] === 'function') {
					_dropCallbacks[_currentElement.id](e, _currentElement);
				}
				
				return false;
			}
		});
		
	};

	// Ajax Plugin (Loading content into element and set scroller)
	$.fn.ajaxScroller = function (url, data, options) {
		options = $.extend({

		}, options);
		
		if (this.length > 0) {
			this.each(function (index, domElement) {
				$(this).html("Loading...");
				
				$(this).load(url, data, function (responseText, textStatus, XMLHttpRequest) {
					if (textStatus === "success") {
						$(this).customScroller(options);
					} else {
						alert('Error');
					}
				});
			});
		}
	};
	
	// onclick reset focus
	$(document).bind('mousedown', function (e) {
		_isOnFocus = null;
	});
	
	// move on key press
	$(document).bind("keydown keypress", function (e) {
		
		if (!_isOnFocus) return;

		switch(e.which) {
			case 38: // up
				_moveUp(_divs[_isOnFocus], 1);	
			break;
						
			case 40: // down
				_moveDown(_divs[_isOnFocus], -1);
			break;
						
			case 37: // left
				_moveLeft(_divs[_isOnFocus], 1);
			break;
						
			case 39: // right
				_moveRight(_divs[_isOnFocus], -1);
			break;
			
			case 33: // up
				_moveUp(_divs[_isOnFocus], 3);	
			break;
						
			case 34: // down
				_moveDown(_divs[_isOnFocus], -3);
			break;
						
			case 36: // left
				_moveLeft(_divs[_isOnFocus], 3);
			break;
						
			case 35: // right
				_moveRight(_divs[_isOnFocus], -3);
			break;
			
			default:
				return true;
			break;
		}
		return false;
	});
				
	// resize frame on resize window
	$(document).ready(function () { 
		$(window).wresize(function () {
			if (_resizeTimer) clearTimeout(_resizeTimer); 
			_resizeTimer = setTimeout(function () {
				$.each(_that, function (key, value) {
					if (typeof value !== 'function') {
						_topDiv = $("div.customScrollerContent", value).position().top;
						_leftDiv = $("div.customScrollerContent", value).position().left;
						var html = $("div.customScrollerContent", value).html();
						$(value).html(html);
						$(value).customScroller(_settings);
					}
				});
			}, 100); 
			return false;
		});
	});
})(jQuery);
