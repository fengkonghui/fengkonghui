<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>红途-风控汇</title>
<!-- css -->
<link rel="stylesheet" href="/static/Portal/fengkonghui/Public/css/style.css">

<!--script-->
<script src="/static/Portal/fengkonghui/Public/js/jquery-1.11.1.min.js"></script>
<script src="/static/Portal/fengkonghui/Public/js/jquery.validate.min.js"></script>
<script src="/static/Portal/fengkonghui/Public/js/custom.js"></script>
<!--[if lt IE 10]>
<script type="text/javascript" src="/pie/PIE.js"></script>
<![endif]-->
</head>
<body>
	<!-- 获取导航信息   -->
<?php if(!empty($nav)): ?><div class="header">
	<div class="header_1">
		<div class="header_img">
			<a href="<?php echo U('/');?>">
			<img src="/static/Portal/fengkonghui/Public/img/logo.png" width="124" height="53" />
			</a>
		</div>
		<div class="header_nav">
			<ul class="header_nav1">
				<?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if(($r["url"] != 'center/index') OR ($_SESSION['MEMBER_id']!= '')): ?><li><a class="<?php echo ($r["class"]); ?>" 
					href="<?php echo ($r['href'] ? U($r['href'],array('menu_id'=>$r['id'])) : '#'); ?>"
					><?php echo ($r["label"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="top-header-menu">
			<ul class="menu">
				<?php if(strlen($_SESSION['MEMBER_id']) != 0): ?><li><a href="<?php echo U('portal/center/index');?>"><?php echo (session('MEMBER_name')); ?>
						<?php if(getMesNum() != 0): ?><span
							class="fa fa-envelope" style="color: #FF4400;">
							<?php echo getMesNum();?></span><?php endif; ?>
				</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
				<li id="navright"><a href="<?php echo U('portal/member/logout');?>"><span
						class="icon-signout"></span>退出</a>&nbsp;&nbsp;</li>
				<?php else: ?>
				<li><a href="<?php echo U('Portal/Member/index');?>">登录</a>&nbsp;|&nbsp;</li>
				<li><a href="<?php echo U('Portal/Member/register');?>">注册</a>&nbsp;&nbsp;</li><?php endif; ?>
			</ul>
		</div>
	</div>
</div><?php endif; ?>
	<div class="content">
		<div class="center">
			
	<div class="life clearfix">
		<div class="life_index clearfix">
			<div class="life_ad fl" id="focus">
				<ul>
				<?php if(is_array($img)): $i = 0; $__LIST__ = $img;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i; endforeach; endif; else: echo "" ;endif; ?>
					<li>
						<a href="javascript://" target="_blank">
							<img src="<?php echo ($row["url"]); ?>" width="910" height="205" />
						</a>
					</li>
				</ul>
			</div>
			<div class="life_info bgWhite fr">
				<h2 class="hd">
					<span>最新消息</span>
					<a href="javascript://" target="_blank" class="fr" style="display:none">更多&gt;&gt;</a>
				</h2>
				<ul class="life_ul">
					<?php if(is_array($news)): foreach($news as $key=>$vo): ?><li><a href="<?php echo U('news',array('id'=>$vo['id']));?>" target="_blank"><?php echo nv_cutstr($vo['title'],38);?></a></li><?php endforeach; endif; ?>
				</ul>
			</div>
		</div>
		<div style="clear: both;"></div>
		<div class="life_ask bgWhite mp15">
			<div class="life_title">
				<h2>问答专区</h2>
			</div>
			<div class="life_nav">
				<div class="term fl">
					<a href="javascript://" data-status="hit">热门</a>|
					<a href="javascript://" data-status="new" class="chosen">最新</a>|
					<a href="javascript://" data-status="wait">等待回复</a>
				</div>
				<div class="search fr">
					<input class="keywords" type="text" name="keywords">
					<input class="submit" type="submit" value="搜索">
				</div>
				<a href="javascript://" class="release questions fr">发布问题</a>
			</div>
			<ul class="db"></ul>
			<div class="h20"></div>
		</div>
		<div style="clear: both;"></div>
		<!-- 
		<div class="life_read bgWhite mp15">
			<ul>
				<?php if(is_array($rec_yuedui)): foreach($rec_yuedui as $key=>$vo): ?><li>
					<div class="read_content1">
						<a href="<?php echo U('zhuanti/pdfTuijian',array('ty_id'=>$vo[ID]));?>">
							<img src="<?php echo ($vo['tj_img']); ?>" />
						</a>
						<?php switch($vo["class"]): case "2": ?><div class="level to1">机构</div><?php break;?> <?php case "3": if(getMemberField('group') < $vo['group']): ?><div class="level to3"><?php echo ($vo["price"]); ?>红途币</div>
						<?php else: ?>
						<div class="level to2"><?php echo getGroupName($vo['group']);?>可阅</div><?php endif; break;?> <?php default: ?>
						<div class="level">免费</div><?php endswitch;?>

						<div class="title"><?php echo nv_cutstr($vo['title'],15);?></div>
					</div>
				</li><?php endforeach; endif; ?>
			</ul>
		</div>
		 -->
		<div style="clear: both;"></div>
		<div class="life_group bgWhite mp15">
			<div class="life_title">
				<h2>小组</h2>
			</div>
			<div class="life_nav nav_tab">
				<?php if(is_array($group_class)): foreach($group_class as $key=>$vo): ?><a href="javascript://" class="<?php echo ($key==0 ? 'on' : ''); ?>" data-id="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?><i></i></a><?php endforeach; endif; ?>
			</div>
			<ul class="db"></ul>
			<div class="h20"></div>
		</div>
		<div style="clear: both;"></div>
		<div class="life_feeling bgWhite mp15">
			<div class="life_title">
				<h2>信贷感悟</h2>
			</div>
			<div class="life_nav nav_tab">
				<?php if(is_array($articles_type)): foreach($articles_type as $key=>$vo): ?><a href="javascript://" class="<?php echo ($key==0 ? 'on' : ''); ?>" data-id="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?><i></i></a><?php endforeach; endif; ?>
			</div>
			<ul class="db"></ul>
			<div class="h20"></div>
		</div>
	</div>

		</div>
	</div>
	
<!-- 
<div class="footer">
	<div class="container">
		<p class="links fl">
			<a href="" target="_blank">关于我们</a> <a href="" target="_blank">法律声明</a>
			<a href="" target="_blank">网站规则</a> <a href="" target="_blank">提出建议</a>
			<a href="" target="_blank">联系我们</a>
		</p>
		<p class="copyright fr">
			<span>Copyright © 2014 北京红途信息科技服务有限公司</span> <a href="#"><?php echo C ( 'site_icp' );?>&nbsp;</a>
		</p>
	</div>
</div> -->
	
	
<div class="alert ques" style="display: none">
	<div class="blackout"></div>
	<div class="boxy-wrapper">
		<div class="hd">
			<h2>发布问题</h2>
			<a href="javascript://" class="off">关闭</a>
		</div>
		<div class="db">
			<textarea placeholder="请输入问题的描述" name="questions"></textarea>
		</div>
		<div class="submit">
			<a href="javascript://" class="off">取消</a>
			<a href="javascript://" class="ok">发布</a>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {

	//滚动图
	var sWidth = $("#focus").width();
	var len = $("#focus ul li").length;
	var index = 0;
	var picTimer;
	
	var btn = "<div class='btn'>";
	for(var i=0; i < len; i++) {
		btn += "<span></span>";
	}
	btn += "</div>";
	$("#focus").append(btn);
	$("#focus .btnBg").css("opacity",0.5);

	$("#focus .btn span").css("opacity",0.4).mouseenter(function() {
		index = $("#focus .btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");

	$("#focus ul").css("width",sWidth * (len));

	$("#focus").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},3000);
	}).trigger("mouseleave");

	function showPics(index) {
		var nowLeft = -index*sWidth;
		$("#focus ul").stop(true,false).animate({"left":nowLeft},300);
		$("#focus .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300);
	}

	//问答遍历
	var ask = function(status,Keywords,page){
		var url = "/Portal/life/ajax.html";
		$.post(url, {type:'ask',status: status,Keywords:Keywords,page:page},function (d){
			if(d.data!=null){
				var str = '';
				var k = 0;
				for(i=0;i<d.data.length;i++){
					k++;
					var str2 = (k%2!=0) ? '<li>' : '';
					var str1 = ''+
						'<div class="ask_db">'+
							'<div class="info">'+
								'<img src="' + d.data[i].avatars + '">'+
								'<dl>'+
									'<dt><a href="/Portal/member/user/uid/'+ d.data[i].uid +'.html" target="_blank">' + d.data[i].nicename + '</a></dt>'+
									'<dd>' + d.data[i].content + '</dd>'+
								'</dl>'+
							'</div>'+
							'<div class="tools">'+
								'<span><a href="javascript://" data-id="' + d.data[i].id + '" class="launch-click">展开</a>(' + d.data[i].num + ')</span>'+
								'<span><a href="javascript://" data-id="' + d.data[i].id + '" class="reply-click">回复</a></span>'+
								'<span><a href="javascript://" data-id="' + d.data[i].id + '" class="report">举报</a></span>'+
								'<span><a href="javascript://" data-id="' + d.data[i].id + '" class="nice" user-id="'+d.data[i].uid+'">点赞</a>(<em>' + d.data[i].hit + '</em>)</span>'+
							'</div>'+
						'</div>';
					var str0 = (k%2==0) ? '</li>' : '';
					var str = str + str2 + str1 + str0;
				}
				if(d.page != null){
				var page = "<div class='page page1'>"+d.page+"</div>";
				str = str +page;}
			}else{
				var str = '';
			}
			$(".life_ask .db").html(str);
			$('.page span').css('background','#fff');
			$('.page span').css('color','#636363');
			$('.page a').hover(function(){
				$(this).css('background','#2A427E');
				$(this).css('color','#fff');
			},function(){
				if($(this).attr('href')){
					$(this).css('background','#fff');
					$(this).css('color','#636363');
				}
			});
			
			$('.page span').hover(function(){
				$(this).css('background','#2A427E');
				$(this).css('color','#fff');
			},function(){
				if($(this).attr('href')){
					$(this).css('background','#fff');
					$(this).css('color','#636363');
				}
			});
			
			$('.page a').click(function(){
				$('.page a').attr('href','2');
				$(this).removeAttr("href");
				var p = $(this).text();
				ask('','',p);
			});
			
			$('.page span').click(function(){
				$('.page a').attr('href','2');
				$(this).removeAttr("href");
				var p = $(this).text();
				ask('','',p);
			});
			
			
			common();
		}, "json");
	};
	ask('','','1');

	//问答排序
	$(".life_ask .term a").click(function(){
		var status = $(this).data('status');
		$(this).siblings('a').removeClass('chosen');
		$(this).addClass('chosen');
		ask(status,'',1);
	})
	//问答搜索
	$(".keywords").keyup(function(){
		var Keywords = $(this).val();
		ask('',Keywords,1);
	});

	//弹窗
	var pop = function(){
		var height = $(window).height(),
			width = $(window).width(),
			blackout = $(".alert .blackout"),
			wrapper = $(".alert .boxy-wrapper");
		blackout.attr('style','z-index: 1347; opacity: 0.7; width: ' + width + 'px; height: ' + height + 'px;');
		var height = wrapper.height()/2;
		var width = wrapper.width()/2;
		wrapper.attr('style','z-index: 1348; margin-left:-' + width + 'px; margin-top:-' + height + 'px');
		$(".off").click(function(){
			$("textarea[name='questions']").val('');
			$(".alert").hide();
		});
	}
	$('.questions').click(function(){
		var uid = '<?php echo ($_SESSION ["MEMBER_id"]); ?>';
		if(uid==''){
			window.location.href = "<?php echo U('/Portal/Member/index');?>";return false;
		}
		$(".alert").toggle();
		pop();
	})

	var common = function (){

		//回复
		$(".reply-click").click(function(){
			var id = $(this).data('id');
			var str = ''+
				'<form class="reply" method="post" action="<?php echo U('/Portal/life/ajax');?>">'+
					'<input type="hidden" value="' + id + '" name="id">'+
					'<input type="hidden" value="reply" name="type">'+
					'<textarea required="required" class="" name="content" aria-required="true"></textarea>'+
					'<input type="submit" value="回复" name="sub" class="submit fr">'+
				'</form>';
			var val = $(this).attr("reply-status");
			if(!val){
				$(this).attr('reply-status','false');
				$(this).parent().parent().parent('.ask_db').append(str);
			}else{
				$(this).removeAttr('reply-status');
				$(this).parent().parent().next('.reply').remove();
			}
		});

		//举报
		$(".report").click(function(){
			var id = $(this).data('id');
			$.post("/Portal/life/ajax.html", {type:'report',id: id},function (d){
				alert(d.info);
			}, "json");
		});

		//查看
		$(".launch-click").click(function(){
			var val = $(this).attr("launch-status");
			var id = $(this).data('id');
			var launch = $(this);
			if(!val){
				$.post("/Portal/life/ajax.html", {type:'launch',id: id},function (d){
					var str = '';
					if(d.data != '' || d.data != null){
						for(i=0;i<d.data.length;i++){
							var str1 = ''+
								'<div class="info reply-info">'+
									'<img src="' + d.data[i].avatars + '">'+
									'<dl>'+
										'<dt><a href="/Portal/member/user/uid/'+ d.data[i].uid +'.html" target="_blank">' + d.data[i].nicename + '</a></dt>'+
										'<dd>' + d.data[i].content + '</dd>'+
									'</dl>'+
								'</div>';
							var str = str + str1;
						}
						launch.attr('launch-status','false');
						launch.parent().parent().parent('.ask_db').append(str);
					}
				}, "json");
			}else{
				$(this).removeAttr('launch-status');
				$(this).parent().parent().next('.reply-info').remove();
			}
		});

		//点赞
		$(".nice").click(function(){
			var id = $(this).data('id');
			var uid = $(this).attr('user-id');
			var nice = $(this);
			$.post("<?php echo U('/Portal/life/ajax',array('type'=>'nice'));?>", {id: id,uid:uid},function (d){
				if(d.status=='200'){
					nice.next('em').text(d.data);
				}else{
					alert(d.info);
				}
			}, "json");
		});

		//提交问题
		$('.alert .boxy-wrapper .ok').click(function(){
			var ok = $(this);
			var uid = '<?php echo ($_SESSION ["MEMBER_id"]); ?>';
			if(uid==''){
				window.location.href = "<?php echo U('/Portal/Member/index');?>";return false;
			}
			var questions = $("textarea[name='questions']");
			if(questions.val() == ''){
				alert("问题描述不能为空!");return false;
			}
			$.ajax({
	            url: '<?php echo U('/Portal/life/questions');?>',
	            type:'POST',
	            data:{questions:questions.val()},
	            dataType:'json',beforeSend:function(){
	                $(ok).text('发布中...');
	            },success:function(d) {
	                if (d.status == '200') {
	                	alert('发布成功！');
	                	$("textarea[name='questions']").val('');
	                    location.reload();
	                } else {
	                    $(ok).text(d.info).css('background','#d20001');
	                }
	            }
	        });
		})
	}

	//小组
	var group = function(){
		var id = $(".life_group .nav_tab a.on").data('id');
		$.post("/Portal/life/ajax.html", {type:'group',id: id},function (d){
			if(d.data!=null){
				var str = '<li>';
				var k = 0;
				for(i=0;i<d.data.length;i++){
					k++;
					var tit = (d.data[i].join_group != 0) ? '退出小组' : '加入小组';
					var clas = (d.data[i].join_group != 0) ? 'submit-del' : 'submit';
					var str1 = ''+
						'<div class="group_db">'+
							'<img src="'+d.data[i].img+'">'+
							'<dl>'+
								'<dt><a href="/portal/life/group/id/' + d.data[i].id + '.html" target="_blank">' + d.data[i].name + '</a></dt>'+
								'<dd>' + d.data[i].num + '&nbsp;群员</dd>'+
								'<dd><a href="javascript://" data-id="' + d.data[i].id + '" class="' + clas + '">' + tit + '</a></dd>'+
							'</dl>'+
						'</div>';
					var str0 = (k%4==0) ? '</li><li>' : '';
					var str = str + str1 + str0;
				}
			}else{
				var str = '';
			}
			$(".life_group .db").html(str);

			//加入小组
			$(".life_group .group_db .submit").click(function(){
				var submit = $(this);
				var id = submit.data('id');
				$.post("/Portal/life/ajax.html", {type:'join_group',id: id},function (d){
					alert(d.info);submit.text('退出小组').attr('class','submit-del');location.reload();
				}, "json");
			});

			//退出小组
			$(".life_group .group_db .submit-del").click(function(){
				var submit = $(this);
				var id = submit.data('id');
				$.post("/Portal/life/ajax.html", {type:'exit_group',id: id},function (d){
					alert(d.info);submit.text('加入小组').attr('class','submit');location.reload();
				}, "json");
			});
		}, "json");
	};group();
	$(".life_group .nav_tab a").click(function(){
		$(this).siblings('a').removeClass('on');
		$(this).addClass('on');
		group();
	});

	//信贷感悟
	var feeling = function(){
		var id = $(".life_feeling .nav_tab a.on").data('id');
		$.post("/Portal/life/ajax.html", {type:'feeling',id: id},function (d){
			if(d.data!=null){
				var str = '';
				var k = 0;
				for(i=0;i<d.data.length;i++){
					k++;
					var str2 = (k%2==0) ? 'fr' : 'fl';
					var str1 = ''+
					'<li class="' + str2 + '">'+
						'<a href="/Portal/life/feeling/id/' + d.data[i].id + '.html" target="_blank">' + d.data[i].title + '</a>'+
						'<span class="fr">' + d.data[i].dateline + '</span>'+
					'</li>';
					var str = str + str1;
				}
			}else{
				var str = '';
			}
			$(".life_feeling .db").html(str);
		}, "json");
	};feeling();
	$(".life_feeling .nav_tab a").click(function(){
		$(this).siblings('a').removeClass('on');
		$(this).addClass('on');
		feeling();
	});
});
</script>

	<?php echo ($site_tongji); ?>
</body>
</html>