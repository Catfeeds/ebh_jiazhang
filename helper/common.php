<?php
if(!function_exists('dd')){
    /**
     * @describe:调试输出
     * @Author:tzq
     * @Date:2018/01/02
     * @param array $data 要输出的数据
     * @param bool $isExit 是否退出进程
     */
    function dd($data,$isExit=false){

        if(is_string($data)){
            echo $data;
        }else{
            $str =  '<div><pre class="">';
            $str .= print_r($data,true);
            $str .='</div>';
            echo $str;
        }

        if($isExit)exit;
    }
}
/*
 * 通用方法
 */

function log_message($msg, $level = 'error', $php_error = false) {
    Ebh::app()->getLog()->log($msg, $level, $php_error);
}

/**
 * 返回系统调试信息
 * @param type 是否直接输出信息
 * @return string 返回调试信息字符串
 */
function debug_info($echo = TRUE) {
	if(!IS_DEBUG)
		return FALSE;
    $cost_time = microtime(TRUE) - EBH_BEGIN_TIME;
    $cost_memory = memory_get_usage(TRUE);
    $cost_memoryinfo = '';
    if ($cost_memory > 1048576) {
        $cost_memoryinfo = round($cost_memory / 1048576, 2) . ' Mbytes';
    } else if ($cost_memory > 1024) {
        $cost_memoryinfo = round($cost_memory / 1024, 2) . ' Kbytes';
    } else {
        $cost_memoryinfo = $cost_memory . ' bytes';
    }
    $query_nums = EBH::app()->getDb()->query_nums;
    $info = 'Processed in ' . $cost_time . ' second(s), ' . $query_nums . ' queries ,Memory Allocate is ' . $cost_memoryinfo;
    if ($echo)
        echo $info;
    else {
        return $info;
    }
}

function geturl($name, $echo = FALSE) {
    if (strpos($name, 'http://') !== FALSE || strpos($name, '.html') !== FALSE) {
        $url = $name;
    } else
        $url = '/' . $name . '.html';
    if ($echo)
        echo $url;
    return $url;
}

/**
 * 切割中文字符串， 中文占2个字节，字母占一个字节
 * @param $string 要切割的字符串
 * @param $start 起始位置
 * @param $length 切割长度
 */
function ssubstrch($string, $start = 0, $length = -1) {
    $p = 0;
    $co = 0;
    $c = '';
    $retstr = '';
    $startlen = 0;
    $len = strlen($string);
    $charset = Ebh::app()->output['charset'];
    for ($i = 0; $i < $len; $i ++) {
        if ($length <= 0) {
            break;
        }
        $c = ord($string {$i});
        if ($charset == 'UTF-8') {
            if ($c > 252) {
                $p = 5;
            } elseif ($c > 248) {
                $p = 4;
            } elseif ($c > 240) {
                $p = 3;
            } elseif ($c > 224) {
                $p = 2;
            } elseif ($c > 192) {
                $p = 1;
            } else {
                $p = 0;
            }
        } else {
            if ($c > 127) {
                $p = 1;
            } else {
                $p = 0;
            }
        }
        if ($startlen >= $start) {
            for ($j = 0; $j < $p + 1; $j ++) {
                $retstr .= $string [$i + $j];
            }
            $length -= ($p == 0 ? 1 : 2);
        }
        $i += $p;
        $startlen++;
    }
    return $retstr;
}

/**
 * 按照给定长度截取字符串
 * @param string $str源字符串
 * @param int $length 需要截取的长度
 * @param string $pre，字符串附加的字符，默认为...
 * @return string 返回截取后的字符串
 */
function shortstr($str, $length = 20, $pre = '...') {
    $resultstr = ssubstrch($str, 0, $length);
    return strlen($resultstr) == strlen($str) ? $resultstr : $resultstr . $pre;
}

function authcode($string, $operation, $key = '', $expiry = 0) {
    $authkey = Ebh::app()->security['authkey'];
    $ckey_length = 4; // 随机密钥长度 取值 0-32;
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥

    $key = md5($key ? $key : $authkey);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

/**
 * 根据原始图片文件,获取缩略图路径
 * 例子：getthumb('http://www.ebanhui.com/images_avater/2014/01/23/1390475735.jpg','120_120');则返回 http://www.ebanhui.com/images_avater/2014/01/23/1390475735_120_120.jp
 * @param string $imageurl	原始图片的路径
 * @param string $size	获取的规格大小  用"_"分隔开
 * @param string $defaulturl Description
 */
function getthumb($imageurl, $size, $defaulturl = '') {
	if(empty($imageurl))
		return $defaulturl;
    $ipos = strrpos($imageurl, '.');
    if ($ipos === FALSE)
        return $imageurl;
    $newimagepath = substr($imageurl, 0, $ipos) . '_' . $size . substr($imageurl, $ipos);
    return $newimagepath;
}

//生成随机字符串或数字
function random($length, $numeric = 0) {
    PHP_VERSION < '4.2.0' ? mt_srand((double) microtime() * 1000000) : mt_srand();
    $seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $seed[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 解析querystring字符串作为查询参数数组返回
 * @return array
 */
function parsequery() {
    $queryarray = array();
    $uri = Ebh::app()->getUri();
    $queryarray['pagesize'] = 20;
    $queryarray['page'] = $uri->page;
    $queryarray['sortmode'] = $uri->sortmode;
    $queryarray['viewmode'] = $uri->viewmode;
    $queryarray['q'] = Ebh::app()->getInput()->get('q');
    return $queryarray;
}

/**
 * 获取分页html代码
 * @param int $listcount总记录数
 * @param int $pagesize分页大小
 * @return string
 */
function show_page($listcount, $pagesize = 20) {
    $pagecount = @ceil($listcount / $pagesize);
    $uri = Ebh::app()->getUri();
    $curpage = $uri->page;
    $prefixlink = '/' . $uri->codepath;
    if (!empty($uri->itemid))
        $prefixlink .= '/' . $uri->itemid;
    $prefixlink .= '-';
    $suffixlink = '-' . $uri->sortmode . '-' . $uri->viewmode;
    if (!empty($uri->attribarr))
        $suffixlink .= '-' . implode('-', $uri->attribarr);
    $suffixlink .= '.html';
    $query_string = $uri->uri_query_string();
    if (!empty($query_string))
        $suffixlink .= '?' . $query_string;
    if ($curpage > $pagecount) {
        $curpage = $pagecount;
    }
    if ($curpage < 1) {
        $curpage = 1;
    }
    //这里写前台的分页
    $centernum = 10; //中间分页显示链接的个数
    $multipage = '<div class="pages"><div class="listPage">';
    if ($pagecount <= 1) {
        $back = '';
        $next = '';
        $center = '';
     //   $gopage = '';
    } else {
        $back = '';
        $next = '';
        $center = '';
   //     $gopage = '<input id="gopage" maxpage="' . $pagecount . '" onblur="if($(this).val()>' . $pagecount . '){$(this).val(' .
              //  $pagecount . ')}" type="text" size="3" value="" onfocus="this.select();"  onkeyup="this.value=this.value.replace(/\D/g,\'\')" //onafterpaste="this.value=this.value.replace(/\D/g,\'\')"><a id="page_go" href="###"  onclick="window.location.href=\'' .
              //  $prefixlink . '\'+$(this).prev(\'#gopage\').val()+\'' . $suffixlink . '\'">跳转</a>';
        if ($curpage == 1) {
            for ($i = 1; $i <= $centernum; $i++) {
                if ($i > $pagecount) {
                    break;
                }
                if ($i != $curpage) {
                    $center .= '<a href="' . $prefixlink . ($i) . $suffixlink . '">' . $i . '</a>';
                } else {
                    $center .= '<a class="none">' . $i . '</a>';
                }
            }
            $next .= '<a href="' . $prefixlink . ($curpage + 1) . $suffixlink . '" id="next">下一页&gt;&gt;</a>';
        } elseif ($curpage == $pagecount) {
            $back .= '<a href="' . $prefixlink . ($curpage - 1) . $suffixlink . '" id="next">&lt;&lt;上一页</a>';
            for ($i = $pagecount - $centernum + 1; $i <= $pagecount; $i++) {
                if ($i < 1) {
                    $i = 1;
                }
                if ($i != $curpage) {
                    $center .= '<a href="' . $prefixlink . $i . $suffixlink . '">' . $i . '</a>';
                } else {
                    $center .= '<a class="none">' . $i . '</a>';
                }
            }
        } else {
            $back .= '<a href="' . $prefixlink . ($curpage - 1) . $suffixlink . '" id="next">&lt;&lt;上一页</a>';
            $left = $curpage - floor($centernum / 2);
            $right = $curpage + floor($centernum / 2);
            if ($left < 1) {
                $left = 1;
                $right = $centernum < $pagecount ? $centernum : $pagecount;
            }
            if ($right > $pagecount) {
                $left = $centernum < $pagecount ? ($pagecount - $centernum + 1) : 1;
                $right = $pagecount;
            }
            for ($i = $left; $i <= $right; $i++) {
                if ($i != $curpage) {
                    $center .= '<a href="' . $prefixlink . $i . $suffixlink . '">' . $i . '</a>';
                } else {
                    $center .= '<a class="none">' . $i . '</a>';
                }
            }
            $next .= '<a href="' . $prefixlink . ($curpage + 1) . $suffixlink . '" id="next">下一页&gt;&gt;</a>';
        }
    }
    $multipage .= $back . $center . $next . '</div></div>';
//    $multipage .= '<script type="text/javascript">' . "\n"
//            . '$(function(){' . "\n"
//			. '$("#gopage").keypress(function(e){' . "\n"
//            . 'if (e.which == 13){' . "\n"
//            . '$(this).next("#page_go").click()' . "\n"
//            . 'cancelBubble(this,e);' . "\n"
//            . '}' . "\n"
//            . '})' . "\n"
//            . '})</script>';
    return $multipage;

}

/**
 * 输出二进制文件
 * @param string $type 输出的文件类型项，此值必须与upconfig对应的项相同
 * @param string $filepath文件保存的相对路径，通过upconfig的savepath可找到绝对路径
 * @param string $filename文件输出的显示名称
 */
function getfile($type = 'course', $filepath, $filename) {
    $_UP = Ebh::app()->getConfig()->load('upconfig');
    $realpath = $_UP[$type]['savepath'] . $filepath;
    $showpath = $_UP[$type]['showpath'];
    if (!file_exists($realpath)) {
        log_message('文件不存在'.$realpath);
    } else {
        $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
        if ($type != 'course' && $type != 'note') {
            $fname = $filename;
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
                $fname = urlencode($fname);
            } else {
                $fname = str_replace(' ', '', $fname);
            }
        } else {
            $fname = time() . '.ebhp';
        }
        if ($ext == 'swf') {
            header("Content-Type: application/x-shockwave-flash");
        } else {
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $fname);
        }
        $webtype = Ebh::app()->web['type'];$webtype=1;
        if(empty($webtype))
            $webtype = 'nginx';
        if ($webtype == 'nginx') {
            header("X-Accel-Redirect: " . $showpath . $filepath);
        } else {
            header('X-Sendfile:' . $realpath);
        }
        exit();
    }
}
/**
 * 删除文件
 * @param string $type 删除的文件类型项，此值必须与upconfig对应的项相同
 * @param string $filepath文件相对路径，与upconfig的savepath组合起来即为实际路径
 */
function delfile($type = 'course', $filepath) {
    $_UP = Ebh::app()->getConfig()->load('upconfig');
    $realpath = $_UP[$type]['savepath'] . $filepath;
    if (file_exists($realpath)) {
        @unlink($realpath);
    }
}

//编码转换
function myiconv($str) {
    global $_SC;
    if(EBH::app()->output['charset']!='utf-8'){
        if(is_array($str)){
            foreach($str as $key=>$value){
                $str[$key] = myiconv($value);
            }
        }else{
            $encode = mb_detect_encoding($str, array('UTF-8','EUC-CN'));
            if ($_SC['db']['dbtype']=='mssql' && $encode != 'EUC-CN') {
                $str = iconv('UTF-8', 'GBK', $str);
            }
        }
    }
    return $str;
}

//safeHtml函数的辅助函数
function _filter(&$v,$k,$special){
    if(in_array($k,$special)){
        return ;
    }
    $v=h(remove_xss($v));
}
/**
     * 将特殊字符转成 HTML 格式。
     ** 
     * @param string $value - 字符串或者数组
     * @param array $value - 数组,用来排除过滤的字段键值 
     * @return array
     */
function safeHtml($msg = null,$special=array()){
    if(is_null($msg)){
        return '';
    }else{
        if(is_array($msg)){
            array_walk_recursive($msg,'_filter',$special);
            return $msg;
        }else{
            return _filter($msg);
        }
         
    }
}
//传入分类列表，处理出树形结构函数
function getTree($arr = array(),$upid=0,$index=0){
    $tree = array();
    foreach ($arr as $value) {

          if($value['upid']==$upid){
               $value['name'] = str_repeat('┣━', $index).$value['name'];
               $tree[] = $value;
               $tree = array_merge($tree,getTree($arr,$value['catid'],$index+1));
          }
    }
     return $tree;
}

//传入position值返回position名
function getPosition($position){
    $positionArr = array('未指定','页头栏目','页脚栏目','顶部栏目','云平台栏目','答疑分类');
    if(intval($position)>5){
        return '警告:外来侵入!';
    }
    return $positionArr[intval($position)];
}

//表单字段验证
function checkFormColumn($receive,$rules){
    if(!is_array($receive)||!is_array($rules)){
        return false;
    }else{
        if((count($receive,1)==count($rules))&&(!array_diff_key($receive,$rules))){
            return true;
        }else{
            return false;
        }
    }
}
function remove_xss($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   // $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=@avascript:alert('XSS')>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

      // @ @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // @ @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return $val;
}
//获取安全html
function h($text, $tags = null) {
    $text   =   trim($text);
    //完全过滤注释
    $text   =   preg_replace('/<!--?.*-->/','',$text);
    //完全过滤动态代码
    $text   =   preg_replace('/<\?|\?'.'>/','',$text);
    //完全过滤js
    $text   =   preg_replace('/<script?.*\/script>/','',$text);

    $text   =   str_replace('[','&#091;',$text);
    $text   =   str_replace(']','&#093;',$text);
    $text   =   str_replace('|','&#124;',$text);
    //过滤换行符
    $text   =   preg_replace('/\r?\n/','',$text);
    //br
    $text   =   preg_replace('/<br(\s*\/)?'.'>/i','[br]',$text);
    $text   =   preg_replace('/<p(\s*\/)?'.'>/i','[p]',$text);
    $text   =   preg_replace('/(\[br\]\s*){10,}/i','[br]',$text);
	$text   =   str_replace('font','{f{o{n{t{',$text);
	$text   =   str_replace('decoration','{d{e{c{o{r{a{t{i{o{n{',$text);
	$text   =   str_replace('<strong>','{s{t{r{o{n{g{',$text);
	$text   =   str_replace('</strong>','}s{t{r{o{n{g{',$text);
	

    //过滤危险的属性，如：过滤on事件lang js
    while(preg_match('/(<[^><]+)( lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i',$text,$mat)){
        $text=str_replace($mat[0],$mat[1],$text);
    }
    while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
        $text=str_replace($mat[0],$mat[1].$mat[3],$text);
    }
    if(empty($tags)) {
        $tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a';
    }
    //允许的HTML标签
    $text   =   preg_replace('/<('.$tags.')( [^><\[\]]*)?>/i','[\1\2]',$text);
    $text = preg_replace('/<\/('.$tags.')>/Ui','[/\1]',$text);
    //过滤多余html
    $text   =   preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml|pre)[^><]*>/i','',$text);
    //过滤合法的html标签
    while(preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i',$text,$mat)){
        $text=str_replace($mat[0],str_replace('>',']',str_replace('<','[',$mat[0])),$text);
    }
    //转换引号
    while(preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i',$text,$mat)){
        $text=str_replace($mat[0],$mat[1].'|'.$mat[3].'|'.$mat[4],$text);
    }
    //过滤错误的单个引号
    while(preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i',$text,$mat)){
        $text=str_replace($mat[0],str_replace($mat[1],'',$mat[0]),$text);
    }
    //转换其它所有不合法的 < >
    $text   =   str_replace('<','&lt;',$text);
    $text   =   str_replace('>','&gt;',$text);
    $text   =   str_replace('"','&quot;',$text);
     //反转换
    $text   =   str_replace('[','<',$text);
    $text   =   str_replace(']','>',$text);
    $text   =   str_replace('|','"',$text);
    //过滤多余空格
    $text   =   str_replace('  ',' ',$text);
	$text   =   str_replace('{f{o{n{t{','font',$text);
	$text   =   str_replace('{s{t{r{o{n{g{','<strong>',$text);
	$text   =   str_replace('}s{t{r{o{n{g{','</strong>',$text);
	$text   =   str_replace('{d{e{c{o{r{a{t{i{o{n{','decoration',$text);
    return $text;
}

function createToken(){
    if(!isset($_SESSION)){
        session_start();
    }
    $token = uniqid(mt_rand(0,1000000));
    $_SESSION['token'] = $token;
    return $token;
}
function checkToken($token=null){
    if(!isset($_SESSION)){
        session_start();
    }
    if(is_null($token))return false;
    if(isset($_SESSION['token'])&&$_SESSION['token']==$token){
        unset($_SESSION['token']);
        return true;
    }else{
        return false;
    }
}
/*
 *生成hash值,防止参数篡改
 *@param String $bt
 *@return String
 */
function formhash($bt){
    return substr(md5($bt.'_'),5,6);
}
//过滤掉所有html标签
function filterhtml($string) {
	$string = preg_replace('/<.*?>/','\\1',$string);
	return $string;
}
//64位编码
function base64str($str,$t=false){
	if(is_array($str)){
		foreach($str as $key=>$val ){
			$str[$key]=base64str($val,$t);
		}
	}else{
		if($t){//编码
			$str=base64_encode($str);
		}else{//解码
			$str=base64_decode($str);
		}
	}
	return $str;
}
//获取IP
function getip()
{
	if(!empty($_SERVER["HTTP_CLIENT_IP"]))
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	else if(!empty($_SERVER["REMOTE_ADDR"]))
		$cip = $_SERVER["REMOTE_ADDR"];
	else
		$cip = "127.0.0.1";
	return $cip;
}
/**
* 根据字节数获取文件可读性较好的大小
* @param int $bsize 字节数
*/
function getSize($bsize){
	$size = "0字节";
	if (!empty($bsize))
	{
		$gsize = $bsize / (1024 * 1024 * 1024);
		$msize = $bsize / (1024 * 1024);
		$ksize = $bsize / 1024;
		if ($gsize > 1)
		{
			$size = round($gsize,2) . "G";
		}
		else if($msize > 1)
		{
			$size = round($msize,2) . "M";
		}
		else if($ksize > 1)
		{

			$size = round($ksize,0) . "K";
		}
		else
		{
			$size = $bsize . "字节";
		}
	}
	return $size;
}
/**
*显示404页面
*/
function show_404() {
	$view = 'common/error404';
	$viewpath = VIEW_PATH.$view.'.php';
    include $viewpath;
}
/*
*表情图片
*/
function getEmotionarr(){
	$emotionarr = array('微笑','大笑','飞吻','疑问','悲泣','大哭','痛哭','学习雷锋','成交','鼓掌','握手','红唇','玫瑰','爱心','礼物');
	return $emotionarr;
}

/*
*评论表情图片转换
*/
function parseEmotion($reviews){
	$emotionarr = getEmotionarr();
	$matstr = '/\[emo(\S{1,2})\]/is';
	$emotioncount = count($emotionarr);
	$subject = '';
	foreach($reviews as $k=>$review){
		$subject = $review['subject'];
		preg_match_all($matstr,$subject,$mat);
		foreach($mat[0] as $l=>$m){
			$imgnumber = intval($mat[1][$l]);
			if($imgnumber<$emotioncount)
			$reviews[$k]['subject']=str_replace($m,'<img title="'.$emotionarr[$imgnumber].'" src="http://static.ebanhui.com/ebh/tpl/default/images/'.$imgnumber.'.gif">',$reviews[$k]['subject']);
			
		}
	}
	return $reviews;
}

/*
将秒数转化为天/小时/分/秒
*/
function secondToStr($time){

	$str = '';
	$timearr = array(86400 => '天', 3600 => '小时', 60 => '分', 1 => '秒');
	foreach ($timearr as $key => $value) {
		if ($time >= $key)
			$str .= floor($time/$key) . $value;
		$time %= $key;
	}
	return $str;
}


//获取header头信息,兼容nginx
if (!function_exists('getallheaders'))   
{  
    function getallheaders()   
    {  
       foreach ($_SERVER as $name => $value)   
       {  
           if (substr($name, 0, 5) == 'HTTP_')   
           {  
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;  
           }  
       }  
       return $headers;  
    } 
}

/**
 * 获取分页html代码
 * @param int $listcount总记录数
 * @param int $pagesize分页大小
 * @return string
 */
function ajaxpage($listcount, $pagesize = 20, $curpage = 1) {
    $pagecount = @ceil($listcount / $pagesize);
    $uri = Ebh::app()->getUri();
    $curpage = $curpage;
    $prefixlink = '/' . $uri->codepath;
    if (!empty($uri->itemid))
        $prefixlink .= '/' . $uri->itemid;
    $prefixlink .= '-';
    $suffixlink = '-' . $uri->sortmode . '-' . $uri->viewmode;
    if (!empty($uri->attribarr))
        $suffixlink .= '-' . implode('-', $uri->attribarr);
    $suffixlink .= '.html';
    $query_string = $uri->uri_query_string();
    if (!empty($query_string))
        $suffixlink .= '?' . $query_string;
    if ($curpage > $pagecount) {
        $curpage = $pagecount;
    }
    if ($curpage < 1) {
        $curpage = 1;
    }
    //这里写前台的分页
    $centernum = 10; //中间分页显示链接的个数
    $multipage = '<div class="pages"><div class="listPage">';
    if ($pagecount <= 1) {
        $back = '';
        $next = '';
        $center = '';
        //   $gopage = '';
    } else {
        $back = '';
        $next = '';
        $center = '';
        //     $gopage = '<input id="gopage" maxpage="' . $pagecount . '" onblur="if($(this).val()>' . $pagecount . '){$(this).val(' .
        //  $pagecount . ')}" type="text" size="3" value="" onfocus="this.select();"  onkeyup="this.value=this.value.replace(/\D/g,\'\')" //onafterpaste="this.value=this.value.replace(/\D/g,\'\')"><a id="page_go" href="###"  onclick="window.location.href=\'' .
        //  $prefixlink . '\'+$(this).prev(\'#gopage\').val()+\'' . $suffixlink . '\'">跳转</a>';
        if ($curpage == 1) {
            for ($i = 1; $i <= $centernum; $i++) {
                if ($i > $pagecount) {
                    break;
                }
                if ($i != $curpage) {
                    $center .= '<a data="' . $prefixlink . ($i) . $suffixlink . '">' . $i . '</a>';
                } else {
                    $center .= '<a class="none">' . $i . '</a>';
                }
            }
            $next .= '<a data="' . $prefixlink . ($curpage + 1) . $suffixlink . '" id="next">下一页&gt;&gt;</a>';
        } elseif ($curpage == $pagecount) {
            $back .= '<a data="' . $prefixlink . ($curpage - 1) . $suffixlink . '" id="next">&lt;&lt;上一页</a>';
            for ($i = $pagecount - $centernum + 1; $i <= $pagecount; $i++) {
                if ($i < 1) {
                    $i = 1;
                }
                if ($i != $curpage) {
                    $center .= '<a data="' . $prefixlink . $i . $suffixlink . '">' . $i . '</a>';
                } else {
                    $center .= '<a class="none">' . $i . '</a>';
                }
            }
        } else {
            $back .= '<a data="' . $prefixlink . ($curpage - 1) . $suffixlink . '" id="next">&lt;&lt;上一页</a>';
            $left = $curpage - floor($centernum / 2);
            $right = $curpage + floor($centernum / 2);
            if ($left < 1) {
                $left = 1;
                $right = $centernum < $pagecount ? $centernum : $pagecount;
            }
            if ($right > $pagecount) {
                $left = $centernum < $pagecount ? ($pagecount - $centernum + 1) : 1;
                $right = $pagecount;
            }
            for ($i = $left; $i <= $right; $i++) {
                if ($i != $curpage) {
                    $center .= '<a data="' . $prefixlink . $i . $suffixlink . '">' . $i . '</a>';
                } else {
                    $center .= '<a class="none">' . $i . '</a>';
                }
            }
            $next .= '<a data="' . $prefixlink . ($curpage + 1) . $suffixlink . '" id="next">下一页&gt;&gt;</a>';
        }
    }
    $multipage .= $back . $center . $next . '</div></div>';
    return $multipage;
}

/**
 * 时间戳转成易于理解的格式
 * @param  int $timestamp 时间
 * @return string  返回格式：刚刚、几分钟前、几个小时前、昨天、前天、几天前，超过一个月的显示完整时间。
 */
function timetostr($timestamp,$format = 'Y-m-d H:i'){
    $today_time = strtotime('today');
    $timediff_today = $today_time - $timestamp;//timestamp和今天0点时间差
    $timediff_now = SYSTIME - $timestamp;//timestamp和当前时间差

    if ($timediff_now < 0)
    {
        return;
    }

    if ($timediff_today <= 0)
    {
        if ($timediff_now < 60)
        {
            return '刚刚';
        }
        elseif ($timediff_now >= 60 && $timediff_now < 3600)
        {
            return floor($timediff_now/60) . '分钟前';
        }
        elseif ($timediff_now >= 3600 && $timediff_now < 86400)
        {
            return floor($timediff_now/3600) . '小时前';
        }
    }
    else
    {
        if ($timediff_today < 86400)
        {
            return '昨天';
        }
        elseif ($timediff_today >= 86400 && $timediff_today < 172800)
        {
            return '前天';
        }
        elseif ($timediff_today >= 172800 && $timediff_today < 2592000)
        {
            return ceil($timediff_today/86400) . '天前';
        }
        else
        {
            return date($format, $timestamp);
        }
    }
}

/**
 * 获取用户头像
 * @param unknown $user
 * @param string $size
 */
function getavater($user,$size='120_120'){
    $defaulturl = "http://static.ebanhui.com/ebh/tpl/default/images/";
    $face = "";
    if(!empty($user['face'])){
        $ext = substr($user['face'], strrpos($user['face'], '.'));
        $face = str_replace($ext,'_'.$size.$ext,$user['face']);
    }else{
        if(isset($user['sex'])){
            if($user['sex']==1){//女
                $face = $user['groupid'] == 5 ? $defaulturl."t_woman.jpg" : $defaulturl."m_woman.jpg";
                $face = str_replace('.jpg','_'.$size.'.jpg',$face);
            }else{//男
                $face = $user['groupid'] == 5 ? $defaulturl."t_man.jpg" : $defaulturl.'m_man.jpg';
                $face = str_replace('.jpg','_'.$size.'.jpg',$face);
            }
        }else{
            $face = $defaulturl.'m_man.jpg';
            $face = str_replace('.jpg','_'.$size.'.jpg',$face);
        }
    }
    return $face;
}

/**
 *判断当前的访问设备为 安卓pad app
 */
function isApp() {
    if (isset($_SERVER['HTTP_ISEBH']) && $_SERVER['HTTP_ISEBH'] == '1') {
        return TRUE;
    }
    return FALSE;
}

/**
 * 获取版本号
 */
if(function_exists('getv') === false) {
    function getv(){
        //增加一个缓存
        static $cache = array();
        if(isset($cache['version'])){
            return $cache['version'];
        }else{
            $v  = '20170427160033';//版本格式:YYYY年MM月DD日HH时MM分XX(两位随机整数)
            $vtime = strtotime(substr($v, 0,12));//手动写入版本号时间
            $filetime= getFileTime();//文件修改时间
            $nowtime = SYSTIME;//当前程序时间
            $expire = 30*24*3600;//缓存30天
            if(($vtime+$expire)<$nowtime){//过期
                //写入文件 覆盖版本号
                updateVersion($v = getNum());
            }else{//未过期
                /*
                log_message(formateDate($vtime));
                log_message(formateDate($filetime));
                */
                //文件是否修改了
                if($vtime < strtotime(date("Y-m-d H:i",$filetime))){
                    //写入文件 覆盖版本号
                    updateVersion($v = getNum());
                }
            }
            $cache['version'] = '?v='.$v;

            return $cache['version'];
        }
    }
}

/**
 * 获取文件修改时间戳
 */
if(function_exists('getNum') === false) {
    function getNum(){
        $mtime=getFileTime();
        $numStr = date("YmdHi",$mtime).rand(0, 99);
        return $numStr;
    }
}

/**
 * 获取文件最新修改时间
 */
if(function_exists('getFileTime') === false){
    function getFileTime() {
        //增加一个缓存
        static $caches = array();
        if(isset($caches['mtime'])){
            return $caches['mtime'];
        }
        $mtime=filemtime(__FILE__);
        //把结果记录到缓存中
        $caches['mtime'] = $mtime;
        return $caches['mtime'];
    }
}


/**
 * 时间格式化
 * @param unknown $time
 * @param string $formate
 */
if(function_exists('formateDate') === false){
    function formateDate($time,$format="Y-m-d H:i:s"){
        $retStr = '-/-/-';
        if(!empty($time)){
            if(is_numeric($time) && ($time>0)){//时间戳
                $retStr = date($format,$time);
            }else{
                if(strtotime($time)!=FALSE){
                    $retStr = date($format,strtotime($time));
                }
            }
        }

        return $retStr;
    }
}


/**
 * 写入版本号
 */
if(function_exists('updateVersion') === false){
    function updateVersion($version=''){
        //先把写文件注释掉 @eker-huang 2017年1月19日14:26:22
        return true;

        //读文件
        //$filestr = file_get_contents(__FILE__);
        //替换版本号
        //$filestr = preg_replace("/\\\$v\s*=\s*[\'|\"](\d+)[\'|\"]\s*;/i","\$v  = '{$version}';",$filestr);
        //log_message($version);
        //log_message($filestr);
        //file_put_contents(__FILE__, $filestr);
        //return true;
    }
}

function do_post($url, $data , $retJson = true ,$setHeader = false){
    $auth = Ebh::app()->getInput()->cookie('auth');
    $uri = Ebh::app()->getUri();
    $domain = $uri->uri_domain();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    if ($setHeader) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
    }
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    }
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIE, 'ebh_auth='.urlencode($auth).';ebh_domain='.$domain);
    $ret = curl_exec($ch);
    curl_close($ch);
    if($retJson == false){
        $ret = json_decode($ret);
    }
    return $ret;
}