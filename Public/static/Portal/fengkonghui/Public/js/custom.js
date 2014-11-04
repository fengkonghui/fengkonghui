/**
 * 自定义js文件
 * 
 */
$(function(){
	//vs信贷
	$('.xindai_vs_div').hover(function(){
		$(this).find('.xindai_txdw3').show();
	},function(){
		$('.xindai_txdw3').hide();
	});
	//规则弹出层
	$('.gz_tanchuceng').click(function(){
		$('.gz').show();
	});
	$('.gz_img').click(function(){
		$('.gz').hide();
	});
	/***
	 * 风控专题投票
	 * **/
	var toupiao='';
	$('.spec_click').click(function(){
		var num = $('.num').val(),
			box = $(this).find("input:checkbox"),
			sfruit = $('input[name="weekIds[]"]:checked').length;
		if($(this).find('.spec_rig_img').is(":hidden")){
			if(sfruit <= 2){
				$(this).find('.spec_rig_img').show();
				box.attr("checked",'true');
			}else{
				alert('您已经选择了三项');
			}	
		}else{
			$(this).find('.spec_rig_img').hide();
			box.removeAttr("checked");
		}
	});

	/**
	 * 用户自定义标签弹出层
	 * **/
	$('.zidingyi').click(function(){
		$('.zd_biaoqian').show();
	});
	//取消标签定义
	$('.bq_qx').click(function(){
		$('.zd_biaoqian').hide();
	});
	//添加标签
	$('.wangyou_add').click(function(){
		$('.add_biaoqian').show();
	});
	$('#bq_qx').click(function(){
		$('.add_biaoqian').hide();
	});
	
	// 浮层中标签的添加事件处理
	$('.xz_add').click(function(){
		$(this).toggleClass('on');
	});
	
	$('.xz_sub').click(function(){
		var html = '';
		$('.add_biaoqian .xz_add.on').each(function(){
			txt = $(this).text();
			tid = $(this).data('tid');
			html = html + "<div class='biaoqian'><span>"+txt+"</span><input type='hidden' name='tag[]' value='"+tid+"'/><img src='/static/Portal/fengkonghui/Public/img/cuo.png' /></div>";
			$(this).removeClass('on');
			$('.biaoqian_xianshi').html(html);
		});
		/**
		 * 绑定取消数据
		 * **/
		$('.biaoqian_xianshi .biaoqian').click(function(){
			t = $(this).find('input').val();
			$(this).remove();
		});
		
		$('.add_biaoqian').hide();
	});

	$('.zd_sub').click(function(){
		//获取自定义的标签
		var tags = $('.zd_biaoqian1 textarea').val().split(',');
		console.log(tags);
		var html = '';
		for(var i in tags){
			if(tags[i])
				html += "<div class='biaoqian zidingyibiaoqian'><span>"+tags[i]+"</span><input type='hidden' name='user_tag[]' value='"+tags[i]+"'/></div>";
		}
		$('.zidingyi_biaoqian').val(tags);
		
		$('.zidingyi_xianshi').html(html);
		$('.zd_biaoqian').hide();
	});
	
	/***
	 * 评论控制不能为空
	 * ***/
	$('.zf_pinglun').click(function(){
		var $cont = $(this).parent().siblings('textarea').val();
		if($cont){
			return true;
		}else{
			alert('请填入数据');
			return false;
		}
	});
	$('.ff_pinglun').click(function(){
		var $cont = $(this).parent().siblings('textarea').val();
		if($cont){
			return true;
		}else{
			alert('请填入数据');
			return false;
		}
	});
});