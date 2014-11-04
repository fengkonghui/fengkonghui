<?php

/**
 * 打印输出数据到文件
 * @param type $data 需要打印的数据
 * @param type $replace 是否要替换打印
 * @param string $pathname 打印输出文件位置
 * @author Anyon Zou <cxphp@qq.com>
 */
function p($data, $replace = false, $pathname = NULL) {
	is_null ( $pathname ) && $pathname = RUNTIME_PATH . date ( 'Ymd' ) . '_print.txt';
	$model = $replace ? FILE_APPEND : FILE_USE_INCLUDE_PATH;
	if (is_array ( $data )) {
		file_put_contents ( $pathname, print_r ( $data, TRUE ), $model );
	} else {
		file_put_contents ( $pathname, $data, $model );
	}
}

/**
 * 处理插件钩子
 *
 * @param string $hook
 *        	钩子名称
 * @param mixed $params
 *        	传入参数
 * @return void
 * @author Anyon Zou <cxphp@qq.com>
 */
function hook($hook, $params = array()) {
	\Think\Hook::listen ( $hook, $params );
}

/**
 * 简单对称加密算法之加密
 *
 * @param String $string
 *        	需要加密的字串
 * @param String $skey
 *        	加密EKY
 * @return String 加密后的字符串
 * @author Anyon Zou <cxphp@qq.com>
 */
function encode($string = '', $skey = 'ThinkCMF') {
	$skey = str_split ( base64_encode ( $skey ) );
	$strArr = str_split ( base64_encode ( $string ) );
	$strCount = count ( $strArr );
	foreach ( $skey as $key => $value ) {
		$key < $strCount && $strArr [$key] .= $value;
	}
	return str_replace ( '=', 'ThinkCMF', join ( '', $strArr ) );
}

/**
 * 简单对称加密算法之解密
 *
 * @param String $string
 *        	需要解密的字串
 * @param String $skey
 *        	解密KEY
 * @return String 解密后的字符串
 * @author Anyon Zou <cxphp@qq.com>
 */
function decode($string = '', $skey = 'ThinkCMF') {
	$skey = str_split ( base64_encode ( $skey ) );
	$strArr = str_split ( str_replace ( 'ThinkCMF', '=', $string ), 2 );
	$strCount = count ( $strArr );
	foreach ( $skey as $key => $value ) {
		if ($key < $strCount && $strArr [$key] [1] === $value) {
			$strArr [$key] = $strArr [$key] [0];
		} else {
			break;
		}
	}
	return base64_decode ( join ( '', $strArr ) );
}

/**
 * 检测用户是否登录
 *
 * @return boolean false-未登录, Array-登录
 * @author Anyon Zou <cxphp@qq.com>
 */
function is_login() {
	$user = session ( 'user' );
	return empty ( $user ) ? false : $user;
}

/**
 * 快速时间格式生成
 *
 * @param type $time
 *        	时间载
 * @param type $format
 *        	时间格式
 * @return type 格式化后的时间
 */
function toDate($time = null, $format = 'Y-m-d H:i:s') {
	is_null ( $time ) && $time = time ();
	return date ( $format, $time );
}

/**
 * 检测验证码
 *
 * @param integer $id
 *        	验证码ID
 * @return boolean 检测结果
 * @author Anyon Zou <cxphp@qq.com>
 */
function check_verify($code, $id = 1) {
	$verify = new \Think\Verify ();
	return $verify->check ( $code, $id );
}

/**
 * 清空缓存
 */
function clear_cache() {
	$dirs = array ();
	$noneed_clear = array (
			".",
			".." 
	);
	$rootdirs = array_diff ( scandir ( RUNTIME_PATH ), $noneed_clear );
	foreach ( $rootdirs as $dir ) {
		if ($dir != "." && $dir != "..") {
			$dir = RUNTIME_PATH . $dir;
			if (is_dir ( $dir )) {
				array_push ( $dirs, $dir );
				$tmprootdirs = scandir ( $dir );
				foreach ( $tmprootdirs as $tdir ) {
					if ($tdir != "." && $tdir != "..") {
						$tdir = $dir . '/' . $tdir;
						if (is_dir ( $tdir )) {
							array_push ( $dirs, $tdir );
						}
					}
				}
			}
		}
	}
	$dirtool = new Common\Lib\Util\Dir ();
	foreach ( $dirs as $dir ) {
		$dirtool->del ( $dir );
	}
}

/**
 * 生成参数列表,以数组形式返回
 */
function sp_param_lable($tag = '') {
	$param = array ();
	$array = explode ( ';', $tag );
	foreach ( $array as $v ) {
		list ( $key, $val ) = explode ( ':', trim ( $v ) );
		$param [trim ( $key )] = trim ( $val );
	}
	return $param;
}

/**
 */
function get_site_options() {
	$options_obj = new Admin\Model\OptionsModel ();
	$option = $options_obj->where ( "option_name='site_options'" )->find ();
	if ($option) {
		$home_configs = ( array ) json_decode ( $option ['option_value'] );
		return $home_configs;
	} else {
		return array ();
	}
}

/**
 * 全局获取验证码图片 生成的是个HTML的img标签
 * length=4&size=20&width=238&height=50
 * length:字符长度
 * size:字体大小
 * width:生成图片宽度
 * heigh:生成图片高度
 *
 * @param type $imgparam
 *        	图片的属性设置
 * @param type $imgattrs
 *        	IMG标签
 * @return type
 */
function show_verify_img($imgparam = 'length=4&size=15&width=238&height=50', $imgattrs = 'style="cursor: pointer;" title="点击获取"') {
	$src = U ( 'Api/Index/show_verify', $imgparam );
	return $img = <<<hello
<img onclick='this.src+="?"'  src="$src" $imgattrs/>
hello;
}

/**
 * 10
 * 返回指定id的菜单
 * 同上一类方法，jquery treeview 风格，可伸缩样式
 *
 * @param $myid 表示获得这个ID下的所有子级        	
 * @param $effected_id 需要生成treeview目录数的id        	
 * @param $str 末级样式        	
 * @param $str2 目录级别样式        	
 * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制        	
 * @param $ul_class 内部ul样式
 *        	默认空 可增加其他样式如'sub-menu'
 * @param $li_class 内部li样式
 *        	默认空 可增加其他样式如'menu-item'
 * @param $style 目录样式
 *        	默认 filetree 可增加其他样式如'filetree treeview-famfamfam'
 * @param $dropdown 有子元素时li的class
 *        	$id="main";
 *        	$effected_id="mainmenu";
 *        	$filetpl="<a href='\$href'><span class='file'>\$label</span></a>";
 *        	$foldertpl="<span class='folder'>\$label</span>";
 *        	$ul_class="" ;
 *        	$li_class="" ;
 *        	$style="filetree";
 *        	$showlevel=6;
 *        	sp_get_menu($id,$effected_id,$filetpl,$foldertpl,$ul_class,$li_class,$style,$showlevel);
 *        	such as
 *        	<ul id="example" class="filetree ">
 *        	<li class="hasChildren" id='1'>
 *        	<span class='folder'>test</span>
 *        	<ul>
 *        	<li class="hasChildren" id='4'>
 *        	<span class='folder'>caidan2</span>
 *        	<ul>
 *        	<li class="hasChildren" id='5'>
 *        	<span class='folder'>sss</span>
 *        	<ul>
 *        	<li id='3'><span class='folder'>test2</span></li>
 *        	</ul>
 *        	</li>
 *        	</ul>
 *        	</li>
 *        	</ul>
 *        	</li>
 *        	<li class="hasChildren" id='6'><span class='file'>ss</span></li>
 *        	</ul>
 */
function sp_get_menu($id = "main", $effected_id = "mainmenu", $filetpl = "<span class='file'>\$label</span>", $foldertpl = "<span class='folder'>\$label</span>", $ul_class = "", $li_class = "", $style = "filetree", $showlevel = 6, $dropdown = 'hasChild') {
	$site_nav = F ( "site_nav_" . $id );
	if (empty ( $site_nav )) {
		$nav_obj = new \Admin\Model\NavModel ();
		if ($id == "main") {
			$navcat_obj = new \Admin\Model\NavCatModel ();
			$main = $navcat_obj->where ( "active=1" )->find ();
			$id = $main ['navcid'];
		}
		$navs = $nav_obj->where ( "cid=$id" )->order ( array (
				"listorder" => "ASC" 
		) )->select ();
		foreach ( $navs as $key => $nav ) {
			$href = $nav ['href'];
			$hrefold = $href;
			$href = unserialize ( stripslashes ( $nav ['href'] ) );
			if (empty ( $href )) {
				if ($hrefold == "home") {
					$href = __ROOT__ . "/";
				} else {
					$href = $hrefold;
				}
			} else {
				$default_app = strtolower ( C ( "DEFAULT_GROUP" ) );
				$href = U ( $href ['action'], $href ['param'] );
				$g = C ( "VAR_GROUP" );
				$href = preg_replace ( "/\/$default_app\//", "/", $href );
				$href = preg_replace ( "/$g=$default_app&/", "", $href );
			}
			$nav ['href'] = $href;
			$navs [$key] = $nav;
		}
		F ( "site_nav", $navs );
	}
	
	$tree = new \Common\Lib\Util\Tree ();
	$tree->init ( $navs );
	return $tree->get_treeview_menu ( 0, $effected_id, $filetpl, $foldertpl, $showlevel, $ul_class, $li_class, $style, 1, FALSE, $dropdown );
}

/*
 * 作用：写入新消息 参数：$from	发送者id $to		消息接受者id $content 消息内容 $targetid 相应数据表中的id的值 $mestype可选值：topic_comment(话题评论)、topic_answer(话题回复)、topic_collect(话题收藏)、topic_love(喜欢)
 */
function insertMes($from, $to, $content, $targetid, $mestype) {
	$data = array (
			'mes_from' => $from,
			'mes_to' => $to,
			'mes_content' => $content,
			'post_time' => time (),
			'target_id' => $targetid,
			'mes_type' => $mestype,
			'mes_status' => '2'  // 未读
		);
	return M ( 'Message' )->add ( $data );
}

/*
 * 作用：查看用户消息 参数：$uid	查询用户id $status		消息接受者id $mestype可选值：topic_comment(话题评论)、topic_answer(话题回复)、topic_collect(话题收藏)、topic_love(喜欢) 注意：查询时仅限于members,message,topic三张表，因此只能查询三张表中的信息
 */
function getMes($uid, $type, $status = 2) {
	$DbPre = C ( 'DB_PREFIX' );
	$sql = 'select a.*,b.user_login_name,b.ID,c.topic_id,c.topic_cid,c.title
    		from ' . $DbPre . 'message a left join ' . $DbPre . 'members b
    		on a.mes_from=b.ID left join ' . $DbPre . 'topic c on a.target_id=c.topic_id
    		where a.mes_status=' . $status . ' and mes_type=\'' . $type . '\' and a.mes_to=' . $uid . ' order by a.post_time desc';
	return $topic_comment = M ()->query ( $sql );
}

// 获取站内消息数量
function getMesNum() {
	if (! isset ( $_SESSION ["MEMBER_id"] ))
		return;
	return M ( 'Message' )->where ( 'mes_status=2 and mes_to=' . $_SESSION ["MEMBER_id"] )->count ();
}

// 面包屑导航
function sp_bread_nav($nav_id) {
	$navTable = M ( 'Nav' );
	$path = $navTable->where ( "id=$nav_id" )->getField ( 'path' );
	if (! $path) {
		return array ();
	}
	$path = str_replace ( '-', ',', $path );
	return $navTable->where ( "id in ({$path})" )->order ( 'id' )->select ();
}
function getMemberNameById($id) {
	return M ( 'members' )->where ( 'ID = %d', $id )->getField ( 'user_login_name' );
}

// 查询是否上传图片
function getZF($id) {
	$where ['rev_zhengfang'] = 1;
	$where ['rev_review_hteme'] = $id;
	return M ( 'review_record' )->where ( $where )->getField ( 'image' );
}
function getFF($id) {
	$where ['rev_zhengfang'] = 0;
	$where ['rev_review_hteme'] = $id;
	return M ( 'review_record' )->where ( $where )->getField ( 'image' );
}

// 获取用户名字
function getName($id) {
	return M ( 'members' )->where ( 'ID=' . $id )->getField ( 'user_login_name' );
}

/**
 * 获取用户组名称
 *
 * @param [String] $group
 *        	组ID
 * @return [String] 组名称
 */
function groupname($group) {
	$result = M ( 'Members_group' )->where ( "id=%d AND gid>0", array (
			$group 
	) )->find ();
	$name ['group'] = M ( 'Members_group' )->where ( "id=%d", array (
			$result ['gid'] 
	) )->getField ( 'name' );
	return $name ['group'] . '(' . $result ['name'] . ')';
}

/**
 * 获取区域
 *
 * @param string $id
 *        	区域id
 * @return mixed
 *
 */
function area($id = '') {
	$area = M ( 'Area' );
	if ($id) {
		$map ['ID'] = array (
				'eq',
				$id 
		);
		$result = $area->where ( $map )->getField ( 'area_title' );
	} else {
		$odr = 'initial asc';
		$result = $area->order ( $odr )->select ();
	}
	return $result;
}

/**
 * 获取类别
 *
 * @param string $id
 *        	类别id
 * @return mixed
 *
 */
function category($id = '') {
	$category = M ( 'Members_category' );
	if ($id) {
		$map ['id'] = array (
				'eq',
				$id 
		);
		$result = $category->where ( $map )->getField ( 'name' );
	} else {
		$result = $category->select ();
	}
	return $result;
}

/**
 *
 * @param string $id        	
 * @return mixed
 */
function postLevel($id = '') {
	$category = M ( 'Members_post_level' );
	if ($id) {
		$map ['id'] = array (
				'eq',
				$id 
		);
		$result = $category->where ( $map )->getField ( 'name' );
	} else {
		$result = $category->select ();
	}
	return $result;
}

/**
 * 根据tagid获取预设id
 *
 * @param unknown $id        	
 * @return string
 */
function getTagById($id) {
	$tag = M ( 'biaoqian' );
	$map ['ID'] = $id;
	$row = $tag->where ( $map )->find ();
	$result = ($row ['parent_bq'] ? ($row ['parent_bq'] . '/') : '') . $row ['bq'];
	return $result;
}
function getCMember() {
	$M = M ( 'Members' );
	$id = $_SESSION ["MEMBER_id"];
	return $M->find ( $id );
}
function getMemberField($field = '', $id = '') {
	if (! $id) {
		$result = getCMember ();
	} else {
		$M = M ( 'Members' );
		$result = $M->find ( $id );
	}
	return $field ? $result [$field] : $result;
}
function getGroupName($groupId = '') {
	if (! $groupId)
		return;
	$result = M ( 'Members_group' )->where ( "id=%d", array (
			$groupId 
	) )->getField ( 'name' );
	return $result;
}
function lefttime($ts) {
	$t = strtotime ( $ts ) - time ();
	if ($t > 0) {
		$d = floor ( $t / 24 / 60 / 60 );
		$h = floor ( ($t - $d * 24 * 60 * 60) / 60 / 60 );
		$f = floor ( ($t - $d * 24 * 60 * 60 - $h * 60 * 60) / 60 );
		$s = floor ( $t - $d * 24 * 60 * 60 - $h * 60 * 60 - $f * 60 );
		if ($d)
			return sprintf ( '%d天 %02d:%02d:%02d', $d, $h, $f, $s );
		else
			return sprintf ( '%02d:%02d:%02d', $h, $f, $s );
	} else {
		return '';
	}
}

/**
 * 根据周期获取时间
 *
 * @param string $year
 *        	年
 * @param string $week
 *        	周期
 * @param string $day
 *        	周几
 * @return string
 */
function week($year = '2014', $week = '1', $day = '1') {
	$last_year = strtotime ( ($year - 1) . '-12-31' );
	$last_date_lase_year_in_week = date ( 'N', $last_year );
	$days = ($week - 1) * 7 + $day - $last_date_lase_year_in_week;
	$the_day = strtotime ( "+$days days", $last_year );
	return $the_day;
}

/**
 * 用户头像
 *
 * @param integer $uid
 *        	用户ID
 * @return
 *
 */
function avatars($uid) {
	$filename = './static/upload/face/' . $uid . '.jpg';
	if (file_exists ( $filename ))
		$avatars = 'http://' . $_SERVER ['HTTP_HOST'] . '/static/upload/face/' . $uid . '.jpg';
	else
		$avatars = 'http://' . $_SERVER ['HTTP_HOST'] . '/static/Portal/fengkonghui/Public/img/default.jpg';
	return $avatars;
}

/**
 * 字符串截取
 *
 * @param $string 要截取的字符串        	
 * @param $length 要截取的字符数        	
 * @param $dot 替换截掉部分的结尾字符串        	
 * @return 返回截取后的字符串
 */
function nv_cutstr($string, $length, $dot = '...') {
	// 如果字符串小于要截取的长度则直接返回
	// 此处使用strlen获取字符串长度有很大的弊病，比如对字符串“新年快乐”要截取4个中文字符，
	// 那么必须知道这4个中文字符的字节数，否则返回的字符串可能会是“新年快乐...”
	if (strlen ( $string ) <= $length) {
		return $string;
	}
	// 转换原字符串中htmlspecialchars
	$pre = chr ( 1 );
	$end = chr ( 1 );
	$string = str_replace ( array (
			'&amp;',
			'&quot;',
			'&lt;',
			'&gt;' 
	), array (
			$pre . '&' . $end,
			$pre . '"' . $end,
			$pre . '<' . $end,
			$pre . '>' . $end 
	), $string );
	$strcut = ''; // 初始化返回值
	              // 如果是utf-8编码(这个判断有点不全,有可能是utf8)
	if ('utf-8' == 'utf-8') {
		// 初始连续循环指针$n,最后一个字位数$tn,截取的字符数$noc
		$n = $tn = $noc = 0;
		while ( $n < strlen ( $string ) ) {
			$t = ord ( $string [$n] );
			if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				// 如果是英语半角符号等,$n指针后移1位,$tn最后字是1位
				$tn = 1;
				$n ++;
				$noc ++;
			} elseif (194 <= $t && $t <= 223) {
				// 如果是二字节字符$n指针后移2位,$tn最后字是2位
				$tn = 2;
				$n += 2;
				$noc += 2;
			} elseif (224 <= $t && $t <= 239) {
				// 如果是三字节(可以理解为中字词),$n后移3位,$tn最后字是3位
				$tn = 3;
				$n += 3;
				$noc += 2;
			} elseif (240 <= $t && $t <= 247) {
				$tn = 4;
				$n += 4;
				$noc += 2;
			} elseif (248 <= $t && $t <= 251) {
				$tn = 5;
				$n += 5;
				$noc += 2;
			} elseif ($t == 252 || $t == 253) {
				$tn = 6;
				$n += 6;
				$noc += 2;
			} else {
				$n ++;
			}
			// 超过了要取的数就跳出连续循环
			if ($noc >= $length) {
				break;
			}
		}
		// 这个地方是把最后一个字去掉,以备加$dot
		if ($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr ( $string, 0, $n );
	} else {
		// 并非utf-8编码的全角就后移2位
		for($i = 0; $i < $length; $i ++) {
			$strcut .= ord ( $string [$i] ) > 127 ? $string [$i] . $string [++ $i] : $string [$i];
		}
	}
	// 再还原最初的htmlspecialchars
	$strcut = str_replace ( array (
			$pre . '&' . $end,
			$pre . '"' . $end,
			$pre . '<' . $end,
			$pre . '>' . $end 
	), array (
			'&amp;',
			'&quot;',
			'&lt;',
			'&gt;' 
	), $strcut );
	$pos = strrpos ( $strcut, chr ( 1 ) );
	if ($pos !== false) {
		$strcut = substr ( $strcut, 0, $pos );
	}
	return $strcut . $dot; // 最后把截取加上$dot输出
}


/*
 * HTTP GET Request
*/
function get($url, $param = null) {
    if($param != null) {
        $query = http_build_query($param);
        $url = $url . '?' . $query;
    }   
    $ch = curl_init();
    if(stripos($url, "https://") !== false){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }   

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    $content = curl_exec($ch);
    $status = curl_getinfo($ch);
    curl_close($ch);
    if(intval($status["http_code"]) == 200) {
        return $content;
    }else{
        echo $status["http_code"];
        return false;
    }   
}

/*
 * HTTP POST Request
*/
function post($url, $params) {
    $ch = curl_init();
    if(stripos($url, "https://") !== false) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $content = curl_exec($ch);
    $status = curl_getinfo($ch);
    curl_close($ch);
    if(intval($status["http_code"]) == 200) {
        return $content;
    } else {
        echo $status["http_code"];
        return false;
    }
}

function http_build_query_multi($params, $boundary) {
    if (!$params) return '';

    uksort($params, 'strcmp');

    $MPboundary = '--'.$boundary;
    $endMPboundary = $MPboundary. '--';
    $multipartbody = '';

    foreach ($params as $parameter => $value) {

        if( in_array($parameter, array('pic', 'image')) ) {
            $content = file_get_contents( $value );
            $filename = 'upload.jpg';

            $multipartbody .= $MPboundary . "\r\n";
            $multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
            $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
            $multipartbody .= $content. "\r\n";
        } else {
            $multipartbody .= $MPboundary . "\r\n";
            $multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
            $multipartbody .= $value."\r\n";
        }

    }

    $multipartbody .= $endMPboundary;
    return $multipartbody;
}


