(function ( $ ) {
 
    $.fn.vialert = function(options) {
        
    	var settings = $.extend({
            type: "success",
            title: "Success",
            message:"",
            delay:4000,
        }, options );

        $(this).addClass('vi_alert_parent');

        var unique_id = $.fn.unique_id();

        var cur_item = '<div id="'+unique_id+'" class="item '+settings.type+'"><div class="head"><div class="heading">'+settings.title+'</div><div class="close_btn"></div></div><div class="body"><div class="Content">'+settings.message+'</div></div></div>';
        $(this).append(cur_item);

        $(this).find('.close_btn').click(function(){
        	$(this).parent().parent().hide(300);
        });

        setTimeout(function() {
		    $('#'+unique_id).hide(300);
		}, settings.delay);

        return this;
    };

    $.fn.unique_id = function(){
		  return $.fn.unique_id_item() + $.fn.unique_id_item() + '-' + $.fn.unique_id_item() + '-' + $.fn.unique_id_item() + '-' +
		    $.fn.unique_id_item() + '-' + $.fn.unique_id_item() + $.fn.unique_id_item() + $.fn.unique_id_item();
    };

    $.fn.unique_id_item = function(){
		  return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
	};

	$.fn.vi_confirm_box = function(options){

		var settings = $.extend({
			message:'Are you sure ?',
			true_btn_text:'Yes',
			false_btn_text:'No',
			true_btn:true,
			false_btn:true,
			close_btn:false,
			callback: function(result){},
		}, options);

		$(this).addClass('vi_confirm_box').addClass('active');

		var btn_text = '';
		if(settings.true_btn){
			btn_text += '<button class="yes_btn" type="button">'+settings.true_btn_text+'</button>';
		}
		if(settings.false_btn){
			btn_text += '<button class="no_btn" type="button">'+settings.false_btn_text+'</button>';
		}

		var close_btn = '';
		if(settings.close_btn){
			close_btn += '<div class="close_btn"></div>';
		}

		$(this).append('<div class="item">'+close_btn+'<div class="body">'+settings.message+'</div><div class="footer">'+btn_text+'</div></div>');

		$(this).find('.yes_btn').click(function(){
			$(this).parent().parent().parent().removeClass('.vi_confirm_box').html('').removeClass('active');
			settings.callback('yes');
		});
		$(this).find('.no_btn').click(function(){
			$(this).parent().parent().parent().removeClass('.vi_confirm_box').html('').removeClass('active');
			settings.callback('no');
		});
		$(this).find('.close_btn').click(function(){
			$(this).parent().parent().removeClass('.vi_confirm_box').html('').removeClass('active');
			settings.callback('close');
		});

		return this;

	};

}( jQuery ));