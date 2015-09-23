/*!
 * jQuery JavaScript plugin magicScroller v1.0
 * http://jquery.com/
 *
 * Copyright 2010, Jos� Edmundo Mart�nez Retama
 * GPL License
 * Date: Mon May 24 08:11:13 2010 -0500
 */
 ( function($) {
	//defins the function name
	//recive an object with atributes
    $.fn.magicScroller = function(params){

        //the default opctions
        $.fn.magicScroller.opc_default = {
                    displaytype:"one",
                    elementsByRow:3,
                    topSeparator:5,
                    leftSeparator:3,
                    delayTime:500,
                    animationTime:1000,
                    rowsDisplayed:2
        };

        // check if params are sent, else defaults is asigned
        opc = $.extend( $.fn.magicScroller.opc_default, params );
	//the final propieties are appended
	$.fn.magicScroller.needed = {
		displaytype: opc.displaytype, //how the elements will display
		positions:{}, // Contains the positions of all elements
		elements:opc.elements, //contains the elemts to scroll
		mask:opc.mask,//mascara de los elementos
		elementsPerRow:new Array(), //assigned elements per row
		elementsByRow: opc.elementsByRow, //number displayed elements by row
		topSeparator:opc.topSeparator, //number of pixels of top element separator
		leftSeparator:opc.leftSeparator, //number of pixels of left element separator
		totalRows: 0, //the total of rows created
		delayTime:opc.delayTime, //interval time of next element
		animationTime:opc.animationTime, //diring animation time
		rowsDisplayed:opc.rowsDisplayed, //how rows will display on each next action
		blockElements: new Array(), //the elements in blocks
		numberOfBlocks:0, //blocks generated ( this depends of rows displayed and elements per row )
		actualyDisplayed:0, //block actulally displayed
		stepScroll:0,  //the step of scroll
                prev:opc.prevbtn, // prev button
                next:opc.nextbtn //next button
	};


        $.fn.magicScroller.initializeAll = function(){
		//elements of actual row
		row = new Array();
		//elements of actual block
		block = new Array();
		//files counter
		counter = 0;
		//initiallize the elements block
		$.fn.magicScroller.needed.blockElements = new Array();
		//for each elements
		$.fn.magicScroller.needed.elements.each( function(i){
			//the element is in absolute position
			this.style.position = "absolute";
			//top style to the element
			this.style.top = $.fn.magicScroller.needed.positions.top[i] + 'px';
			//drop the margins
			this.style.margin = "0px";
			//asign the leftstyle to element ( initialize in negative value )
			this.style.left = '-' + $.fn.magicScroller.needed.positions.width[i] + 'px';
			//the opacity of the element is 0 for display in fadeIn efect
			this.style.opacity = '0';
			//get the mod for to know if is a new row
			mod = i % $.fn.magicScroller.needed.elementsByRow;
			if( mod == 0 ){
				//re initialize the row
				row = new Array();
				//increase the files counter for to know what row to manipulate
				counter++;
			}
			//add the element index to the row
			row.push( i );
			//verify if the rows counter is greater than rowsDisplayed, if true the elements block is completed
			if( counter > $.fn.magicScroller.needed.rowsDisplayed ){
				//add the block to the block elements
				$.fn.magicScroller.needed.blockElements.push( block );
				//reinitialize the block
				block = new Array();
				//the counter is 1
				counter = 1;
			}
			//the index of element is added to block
			block.push( i );
			//if is the last element per row or if is the last element
			if( mod == $.fn.magicScroller.needed.elementsByRow - 1 || i == $.fn.magicScroller.needed.elements.size() -1 )
			$.fn.magicScroller.needed.elementsPerRow.push(row); //se agrega la fila completa a el array
			//only if is the last element
			if( i == $.fn.magicScroller.needed.elements.size() -1 )
			$.fn.magicScroller.needed.blockElements.push(block);//se agrega block a blockelements
		});
		//
		//get the number of blocks
		$.fn.magicScroller.needed.numberOfBlocks = $.fn.magicScroller.needed.blockElements.length;
		//the actually block displayed
		$.fn.magicScroller.needed.actualyDisplayed = 0;
                display();
	};




        // returns the jQuery object list
        return this.each( function(){
                        //set the styles to mask
			$.fn.magicScroller.needed.mask.css({
                            position:"absolute",
                            'overflow-y':"hidden"

                        });
                        //get positions
			setPositions();
                        //initialize
			$.fn.magicScroller.initializeAll();
			$.fn.magicScroller.needed.prev.click( function(e){
				e.preventDefault();
				prevRow();
			});
			$.fn.magicScroller.needed.next.click( function(e){
				e.preventDefault();
				nextRow();
			});
        });


        //define the positions of elements
	function setPositions(){
		/**
		* left positions of all elements
		* @var Array
		*/
		var left = new Array();
		/**
		* top positions of all elements
		* @var Array
		*/
		var top = new Array();
		/**
		* width of all elements
		* @var Array
		*/
		var clientWidth = new Array();
		/**
		* height of all elemets
		* @var Array
		*/
		var clientHeight = new Array();
		/**
		* total of elements
		* @var int
		*/
		totalEl = $.fn.magicScroller.needed.elements.size();

		/**
		* top of next elements, starts 0
		* @var int
		*/
		ftop = 0;
		/**
		* left of next elements, starts 0
		* @var Array
		*/
		fleft = 0;
		//for each element
		$.fn.magicScroller.needed.elements.each( function(i){
			//add this width element to array
			clientWidth.push(this.clientWidth);
			//add this height element to array
			clientHeight.push(this.clientHeight);
			// if mod is 0, will add new row
			if( i % $.fn.magicScroller.needed.elementsByRow == 0 ){
				//the first element of row will be the leftSeparator only
				fleft = $.fn.magicScroller.needed.leftSeparator;
				//the top will increase, except if it�s the first row instead will be the top  separatyor only
				ftop += (i==0) ? $.fn.magicScroller.needed.topSeparator:this.clientHeight + $.fn.magicScroller.needed.topSeparator;
				$.fn.magicScroller.needed.totalRows++;
			}
			else //for each added element the left will increase
				fleft += $.fn.magicScroller.needed.leftSeparator + this.clientWidth;
			top.push(ftop); //this top element is added to array
			left.push(fleft); //this left element is added to array
		});
		//to positions object will add the propieties top, left, clientWith y clientHeight, width the elemets values
		$.fn.magicScroller.needed.positions.top = top;
		$.fn.magicScroller.needed.positions.left = left;
		$.fn.magicScroller.needed.positions.width = clientWidth;
		$.fn.magicScroller.needed.positions.height = clientHeight;
		//the step scroll is asigned
		$.fn.magicScroller.needed.stepScroll = $.fn.magicScroller.needed.positions.height[0] + $.fn.magicScroller.needed.topSeparator;
	}

	//show the elements by one
	function displayElementsByOne(){
		time = $.fn.magicScroller.needed.delayTime;
		$($.fn.magicScroller.needed.blockElements[ $.fn.magicScroller.needed.actualyDisplayed ]).each( function(i){
				index = parseInt(this);
				animationTime = $.fn.magicScroller.needed.animationTime;
				delayTime = $.fn.magicScroller.needed.delayTime;
				eval("setTimeout(\"$($.fn.magicScroller.needed.elements[" + index + "]).animate({left: $.fn.magicScroller.needed.positions.left[" + index + "] + 'px',opacity:'.6'}," + animationTime + ").delay(200).animate({opacity:1},'medium')\"," + ( time+=delayTime ) + ")");
		});
	}
	//show the elements by row
	function displayElementsByRow(){
		time = 0;
		animationTime = $.fn.magicScroller.needed.animationTime;
		delayTime = $.fn.magicScroller.needed.delayTime;
		elementsByRow = $.fn.magicScroller.needed.elementsByRow;
		$($.fn.magicScroller.needed.blockElements[ $.fn.magicScroller.needed.actualyDisplayed ]).each( function(i){
				index = parseInt(this);
				eval("setTimeout(\"$($.fn.magicScroller.needed.elements[" + index + "]).animate({left: $.fn.magicScroller.needed.positions.left[" + index + "] + 'px',opacity:'.6'}," + animationTime + ").delay(200).animate({opacity:1},'medium')\"," + ( ( i%elementsByRow==0 ) ? time+=delayTime:time ) + ")");
		});
	}
	//display elements by column
	function displayElementsByColumn(){

		animationTime = $.fn.magicScroller.needed.animationTime;
		delayTime = $.fn.magicScroller.needed.delayTime;
		elementsByRow = $.fn.magicScroller.needed.elementsByRow;
		time = new Array();
		timeA = 0;
		counter = -1;
		for(i = 0;i < elementsByRow;i++ )
			time.push( timeA+=delayTime );
		$($.fn.magicScroller.needed.blockElements[ $.fn.magicScroller.needed.actualyDisplayed ]).each( function(i){
				index = parseInt(this);
				mod = i % elementsByRow;
				counter = ( mod == 0) ? counter+1:counter;
				eval("setTimeout(\"$($.fn.magicScroller.needed.elements[" + index + "]).animate({left: $.fn.magicScroller.needed.positions.left[" + index + "] + 'px',opacity:'.6'}," + (animationTime + (counter * 200)) + ").delay(200).animate({opacity:1},'medium')\"," + ( time[mod] ) + ")");
		});
	}

	//display the prev row
	function prevRow(){
		$.fn.magicScroller.needed.actualyDisplayed--;
		if( $.fn.magicScroller.needed.actualyDisplayed >= 0 ){
			addtop =  ( $.fn.magicScroller.needed.actualyDisplayed == $.fn.magicScroller.needed.numberOfBlocks - 1 ) ? Math.ceil($.fn.magicScroller.needed.blockElements[ $.fn.magicScroller.needed.numberOfBlocks - 1 ].length / $.fn.magicScroller.needed.elementsPerRow) * $.fn.magicScroller.needed.stepScroll : $.fn.magicScroller.needed.rowsDisplayed * $.fn.magicScroller.needed.stepScroll;

			$.fn.magicScroller.needed.elements.animate({top:'+=' + addtop + 'px'});
		}
		else
			$.fn.magicScroller.needed.actualyDisplayed = 0;
	}
	//display the next row
	function nextRow(){
		if( $.fn.magicScroller.needed.actualyDisplayed < $.fn.magicScroller.needed.numberOfBlocks-1 ){
			addtop =  ( $.fn.magicScroller.needed.actualyDisplayed == $.fn.magicScroller.needed.numberOfBlocks - 1 ) ? Math.ceil($.fn.magicScroller.needed.blockElements[ $.fn.magicScroller.needed.numberOfBlocks - 1 ].length / $.fn.magicScroller.needed.elementsPerRow) * $.fn.magicScroller.needed.stepScroll : $.fn.magicScroller.needed.rowsDisplayed * $.fn.magicScroller.needed.stepScroll;
			$.fn.magicScroller.needed.elements.animate({top:'-=' + addtop + 'px'});
			$.fn.magicScroller.needed.actualyDisplayed++;
			display();
		}
		else
			$.fn.magicScroller.needed.actualyDisplayed = $.fn.magicScroller.needed.numberOfBlocks -1;
	}

	function display(){
		switch($.fn.magicScroller.needed.displaytype){
			case 'one':
				displayElementsByOne();
				break;
			case 'row':
				displayElementsByRow();
				break;
			case 'column':
				displayElementsByColumn();
				break;
		}
	}

    };
	
})(jQuery);
