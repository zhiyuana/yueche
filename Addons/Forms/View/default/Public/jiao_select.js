(function($) {
    $.select = function(target, data, itemSelectFunction) {
    	//alert(itemSelectFunction)
		var defaulOption = {
			suggestMaxHeight: '200px',//弹出框最大高度
			itemColor : '#000000',//默认字体颜色
			itemBackgroundColor:'#fff',//默认背景颜色
			itemOverColor : '#red',//选中字体颜色
			itemOverBackgroundColor : '#eee',//选中背景颜色
			itemPadding : 6 ,//item间距
			fontSize : 14 ,//默认字体大小
			itemBorder:1,
			itemStyle:"solid",
			alwaysShowALL : true //点击input是否展示所有可选项
			};
        var maxFontNumber = 0;//最大字数
        var currentItem;
        var suggestContainerId = target + "-suggest";
        var suggestContainerWidth = $('#' + target).innerWidth()+4;
        var suggestContainerLeft = $('#' + target).offset().left;
        var suggestContainerTop = $('#' + target).offset().top + $('#' + target).outerHeight();

        var showClickTextFunction = function() {
        	$("#date1").val(this.id);
//      	var id=$("#date1").val();
        	//alert(id)
        	//$("#date2").val(this.id);
//      	alert($("#date2").val())
            $('#' + target).val(this.innerText);
            //$("#jia_xiao").val(this.innerText);          
            currentItem = null;
            $('#' + suggestContainerId).hide();
		   
            
        }
        /*调取ajax结束*/
        var suggestContainer;
        if ($('#' + suggestContainerId)[0]) {
            suggestContainer = $('#' + suggestContainerId);
            suggestContainer.empty();
        } else {
            suggestContainer = $('<div></div>'); //创建一个子<div>
        }

        suggestContainer.attr('id', suggestContainerId);
        suggestContainer.attr('tabindex', '0');
        suggestContainer.hide();
        var _initItems = function(items) {
            suggestContainer.empty();
            for (var i = 0; i < items.length; i++) {
            		if(items[i].jname.length > maxFontNumber){
            			maxFontNumber = items[i].jname.length;
            			}
                var suggestItem = $('<div></div>'); //创建一个子<div>
                //alert(items[i].id)
                suggestItem.attr('id', items[i].id);
                var id=items[i].id;  
                suggestItem.append(items[i].jname);
                suggestItem.css({
                	'padding':defaulOption.itemPadding + 'px',
                    'white-space':'nowrap',
                    'cursor': 'pointer',
                    'border-bottom-width':defaulOption.itemBorder +'px',
                    'border-bottom-style':defaulOption.itemStyle,
                    'border-bottom-color':defaulOption.itemOverBackgroundColor,
                    'background-color': defaulOption.itemBackgroundColor,
                    'color': defaulOption.itemColor
                });
                suggestItem.bind("mouseover",
                function() {
                    $(this).css({
                        'background-color': defaulOption.itemOverBackgroundColor,
                        'color': defaulOption.itemOverColor
                    });
                    currentItem = $(this);
                });
                suggestItem.bind("mouseout",
                function() {
                    $(this).css({
                        'background-color': defaulOption.itemBackgroundColor,
                        'color': defaulOption.itemColor
                    });
                    currentItem = null;
                });
                suggestItem.bind("click", showClickTextFunction);
                suggestItem.bind("click", itemSelectFunction);
                suggestItem.appendTo(suggestContainer);
                suggestContainer.appendTo(document.body);
            }
           
        }

        var inputChange = function() {
            var inputValue = $('#' + target).val();
            inputValue = inputValue.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
            var matcher = new RegExp(inputValue, "i");
            return $.grep(data,
            function(value) {
                return matcher.test(value.jname);
            });
        }

        $('#' + target).bind("input",
        function() {
            _initItems(inputChange());
        });
        $('#' + target).bind("blur",
        function() {
        		if(!$('#' + suggestContainerId).is(":focus")){
        			$('#' + suggestContainerId).hide();
        			if (currentItem) {
                currentItem.trigger("click");
            	}
            	currentItem = null;
        			return;
        			}                       
        });
        
        $('#' + target).bind("click",
        function() {
            if (defaulOption.alwaysShowALL) {
                _initItems(data);
            } else {
                _initItems(inputChange());
            }
            $('#' + suggestContainerId).removeAttr("style");
            var tempWidth = defaulOption.fontSize*maxFontNumber + 2 * defaulOption.itemPadding + 30;
            var containerWidth = Math.max(tempWidth, suggestContainerWidth);
            $('#' + suggestContainerId).css({
                'border': '1px solid #ccc',
                'max-height': '200px',
                'top': suggestContainerTop,
                'left': suggestContainerLeft,
                'width': containerWidth,
                'position': 'absolute',
                'font-size': defaulOption.fontSize+'px',
                'font-family':'Arial',
                'z-index': 99999,
                'background-color': '#FFFFFF',
                'overflow-y': 'auto',
                'overflow-x': 'hidden',
                'white-space':'nowrap'

            });
            $('#' + suggestContainerId).show();
        });
        _initItems(data);

        $('#' + suggestContainerId).bind("blur",
        function() {
            $('#' + suggestContainerId).hide();
        });

    }
})(jQuery);