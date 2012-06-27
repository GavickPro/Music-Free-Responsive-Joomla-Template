/*
---
description: Masonry layout engine (converted from jQuery Masonry)

license: mooMasonry is dual-licensed under GPL and MIT, just like jQuery Masonry itself. You can use it for both personal and commercial applications.

authors:
- David DeSandro
- Olivier Refalo

requires:
- core/1.3.0:'*'

modified by GavickPro

provides: [Element.masonry]
*/

var MasonryClass = new Class({

	options : {
		singleMode : false,
		columnWidth : undefined,
		itemSelector : undefined,
		appendedContent : undefined,
		resizeable : true
	},

	element : undefined,
	colW : undefined,
	colCount : undefined,
	lastColCount : undefined,
	colY : undefined,
	lastColY: undefined,
	bound : undefined,
	masoned : undefined,
	bricks : undefined,
	posLeft : undefined,
	brickParent : undefined,
	originalColumnWidth: undefined, // used to store the original layout columns width
	tabletWidth: undefined, // used to get the tablet devices width
	mobileWidth: undefined, // used to get the mobile devices width
	disabledAnimation: true, // used to disable the animation of the blocks
	mobileMode: false, // used to detect the mobile devices - tablets/smartphones
	smartphoneMode: false, // used to detect only the smartphones
	isIPad: false, // used to detect an iPad
	prevBoxHeights: undefined, // used to detect height changes in the main block
	resized: false, // used to detect that some element was resized
	
	Implements : Options,

	initialize : function(element, options) {
		this.element = document.id(element);
		this.go(options);
	},

	go: function(options) {
		var $this = this; // handler for the anonymous functions
		this.setOptions(options);
		this.originalColumnWidth = this.options.columnWidth; // store the original layout column width
		this.tabletWidth = document.getElement('body').getProperty('data-tablet-width'); // get the tablet width
		
		// Fix for the browser not based on the Webkit
		if(
			document.getElement('html').hasClass('-moz-') ||
			document.getElement('html').hasClass('-ms-') || 
			document.getElement('html').hasClass('-o-') 
		) {
			// Problem is connected with fact that non-webkit browsers loads
			// the responsive CSS with small delay
			// it causes small problems between desktop and tablet mode
			// that's why we have to modify the media attribute for the links/style elements
			// in these browsers to load the tablet.css code earlier.
			var links = document.getElement('head').getElements('link');
			var styles = document.getElement('head').getElements('style');
			
			for(var i = 0; i < links.length; i++) {
				var href = links[i].getProperty('href');
				if(href && href.length > 10){
					href = href.substr(-10);
					if(href == 'tablet.css') {
						var media = links[i].getProperty('media');
						media = media.replace(new RegExp(this.tabletWidth+"px", "g"), ((this.tabletWidth*1)+16)+"px");
						links[i].setProperty('media', media);
					}
				}
			}
			
			for(var i = 0; i < styles.length; i++) {
				var href = styles[i].getProperty('data-href');
				if(href && href.length > 10) {
					href = href.substr(-10);
					if(href == 'tablet.css') {
						var media = styles[i].getProperty('media');
						media = media.replace(new RegExp(this.tabletWidth+"px", "g"), (this.tabletWidth*1+16)+"px");
						styles[i].setProperty('media', media);
					}
				}
			}
		}
		
		this.mobileWidth = document.getElement('body').getProperty('data-mobile-width'); // get the mobile width
		this.isIPad = navigator.userAgent.match(/iPad/i) != null; // detect an iPad

		if (this.masoned && options.appendedContent != undefined) {
			this.brickParent = options.appendedContent;
		} else {
			this.brickParent = this.element;
		}

		if (this.brickParent.getChildren().length > 0) {
			this.masonrySetup();
			this.masonryArrange();

			var resizeOn = this.options.resizeable;
				if (resizeOn) {
					if(this.bound == undefined) {
						this.bound = this.masonryResize.bind(this);
						this.attach();
					}
				}

				if (!resizeOn) {
					this.detach();
				}
		}
		
		(function() {
			$this.checkBoxes(); // start checking the blocks width
		}).delay(500);
	},

	checkBoxes: function() {
		//
		var currentHeights = [];
		
		this.bricks.each(function(brick, i){
			currentHeights[i] = brick.getSize().y;
		});
		
		var compareFlag = true;
		
		if(this.prevBoxHeights != undefined) {
			for(var i = 0; i < currentHeights.length; i++) {
				if(this.prevBoxHeights[i] != currentHeights[i]) {
					compareFlag = false;
					break;
				}
			}
		} else {
			compareFlag = false;
		}
		
		if(!compareFlag) {
			this.masonryResize();
			this.prevBoxHeights = Array.clone(currentHeights);
			this.resized = true;
		}
		
		var $checkBoxesOBJ = this;
		
		(function() {
			$checkBoxesOBJ.checkBoxes();
		}).delay(1000);
	},

	attach : function() {
		window.addEvent('resize', this.bound);
		window.addEvent('orientationchange', this.bound); // fix for iPad and iPhone
		return this;
	},

	detach : function() {
		if(this.bound != undefined ) {
			window.removeEvent('resize', this.bound);
			window.removeEvent('orientationchange', this.bound); // fix for iPad and iPhone
			this.bound = undefined;
		}
		return this;
	},

	placeBrick : function(brick, setCount, setY, setSpan) {
		var shortCol = 0;

		for (var i = 0; i < setCount; i++) {
			if (setY[i] < setY[shortCol]) {
				shortCol = i;
			}
		}

		brick.setStyles({
			top : setY[shortCol],
			left : this.colW * shortCol + this.posLeft
		});

		var size=brick.getSize().y;

		for (var i = 0; i < setSpan; i++) {
			this.colY[shortCol + i] = setY[shortCol] + size;
		}
	},

	masonrySetup : function() {
		var s = this.options.itemSelector;
		this.bricks = s == undefined ? this.brickParent.getChildren() : this.brickParent.getChildren(s);
		// check the document width
		var bodyWidth = document.getElement('body').getSize().x;
		// set the variables according the detected width
		if(bodyWidth <= this.mobileWidth) {
			this.options.columnWidth = this.element.getSize().x;
			this.mobileMode = true;
			this.smartphoneMode = true;
		} else if(bodyWidth <= this.tabletWidth || this.isIPad) {
			this.options.columnWidth = Math.floor(this.element.getSize().x * 0.5);
			this.mobileMode = true;
			this.smartphoneMode = false;
		} else {
			this.options.columnWidth = this.originalColumnWidth;
			this.mobileMode = false;
			this.smartphoneMode = false;
		}
		// 
		if (this.options.columnWidth == undefined) {
			var b = this.bricks[0];
			this.colW = b.getSize().x;
		} else {
			this.colW = this.options.columnWidth;
		}	

		var size = this.element.getSize().x;
		this.colCount = Math.floor(size / this.colW);
		this.colCount = Math.max(this.colCount, 1);
		
		if(this.colCount == 1) {
			this.colW = size;
		}
		
		return this;
	},

	masonryResize : function() {
		this.brickParent = this.element;
		this.lastColY=this.colY;
		this.lastColCount = this.colCount;

		this.masonrySetup();
		// arrange the blocks on few cases: mobile, resize or changed column amount
		if (this.mobileMode || this.resized || this.colCount != this.lastColCount) {
			this.masonryArrange();
			this.resized = false; // disable the resized mode
		}
	
		return this;
	},

	masonryArrange : function() {
		// if masonry hasn't been called before
		if (!this.masoned) {
			this.element.setStyle('position', 'relative');
		}

		if (!this.masoned || this.options.appendedContent != undefined) {
			// just the new bricks
			this.bricks.setStyle('position', 'absolute');
		}

		// get top left position of where the bricks should be
		var cursor = new Element('div').inject(this.element, 'top');

		var pos = cursor.getPosition();
		var epos = this.element.getPosition();

		var posTop = pos.y - epos.y;
		this.posLeft = pos.x - epos.x;

		cursor.dispose();

		// set up column Y array
		if (this.masoned && this.options.appendedContent != undefined) {
			// if appendedContent is set, use colY from last call
			if(this.lastColY != undefined) {
				this.colY=this.lastColY; 
			}

			/*
			* in the case that the wall is not resizeable, but the colCount has
			* changed from the previous time masonry has been called
			*/
			for (var i = this.lastColCount; i < this.colCount; i++) {
				this.colY[i] = posTop;
			}

		} else {
			this.colY = [];
			for (var i = 0; i < this.colCount; i++) {
				this.colY[i] = posTop;
			}
		}

		// layout logic
		if (this.options.singleMode) {
			for (var k = 0; k < this.bricks.length; k++) {
				var brick = this.bricks[k];
				this.placeBrick(brick, this.colCount, this.colY, 1);
			}
		} else {
			for (var k = 0; k < this.bricks.length; k++) {
				var brick = this.bricks[k];

				// how many columns does this brick span
				var size = brick.getSize().x;
				var colSpan = Math.ceil(size / this.colW);
				colSpan = Math.min(colSpan, this.colCount);
				// use single mode on the 1 column layout or in the mobile mode for all blocks excluding the main block
				if (colSpan == 1 || (this.mobileMode && k >= 1)) {
					// if brick spans only one column, just like singleMode
					this.placeBrick(brick, this.colCount, this.colY, 1);
				} else {
					// brick spans more than one column
					// how many different places could this brick fit horizontally
					var groupCount = this.colCount + 1 - colSpan;
					var groupY = [0];
					// for each group potential horizontal position
					for (var i = 0; i < groupCount; i++) {
						groupY[i] = 0;
						// for each column in that group
						for (var j = 0; j < colSpan; j++) {
							// get the maximum column height in that group
							groupY[i] = Math.max(groupY[i], this.colY[i + j]);
						}
					}        					
					this.placeBrick(brick, groupCount, groupY, colSpan);
				} // else
			}
		} // /layout logic

		// set the height of the wall to the tallest column
		var wallH = 0;
		for (var i = 0; i < this.colCount; i++) {
			wallH = Math.max(wallH, this.colY[i]);
		}

		this.element.setStyle('height', wallH - posTop);

		// let listeners know that we are done
		this.element.fireEvent('masoned', this.element);
		this.masoned = true;
		this.options.appendedContent = undefined;
		// adding animation element to avoid problems with animation on the initialization
		if(this.disabledAnimation && !document.id('masonry-animation')) {
			// on IE disable checking the data-* attr - it cause a problems
			if(!Browser.ie && document.body.get('data-blocks-animation') == 1) {
				var head = document.getElement('head');
				var style = new Element('style', { id: 'masonry-animation', type: 'text/css', text: '.box, .box_menu, .box_text { -webkit-transition: opacity 0.35s ease-in-out, top 0.5s ease-in-out, left 0.5s ease-in-out; -moz-transition: opacity 0.35s ease-in-out, top 0.5s ease-in-out, left 0.5s ease-in-out; -ms-transition: opacity 0.35s ease-in-out, top 0.5s ease-in-out, left 0.5s ease-in-out; -o-transition: opacity 0.35s ease-in-out, top 0.5s ease-in-out, left 0.5s ease-in-out; transition: opacity 0.35s ease-in-out, top 0.5s ease-in-out, left 0.5s ease-in-out; }' });
				style.inject(head, 'bottom');
			}
		}
		// set the flag for delayed style element
		this.disabledAnimation = false;

		// set all data so we can retrieve it for appended appendedContent
		// or anyone else's crazy jquery fun
		// this.element.data('masonry', props );
		return this;
	}
});

Element.implement({
	masonry : function(options) {
		new MasonryClass(this, options);
	}
});