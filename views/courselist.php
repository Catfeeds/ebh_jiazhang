<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/college/style.css?v=20151015001"/>-->
<!--<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css" />-->
<!--<link rel="stylesheet" type="text/css" href="http://static.ebanhui.com/ebh/tpl/default/css/listit.css" />-->
<!---->
<!--<link href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20150822" rel="stylesheet" type="text/css" />-->
    <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2012/css/basic.css?v=20171030141734">
    <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/default/css/E_ClassRoom.css?v=20171030141734">
    <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2016/css/covers.css?v=20171030141734">
    <link rel="stylesheet" href="http://static.ebanhui.com/ebh/tpl/2016/css/titlecs.css?v=20171030141720">
<script type="text/javascript" src="http://static.ebanhui.com/js/jquery-1.11.0.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>




</head>
<style>
    .kejian li.li1 .piaoyin {

        position: absolute !important;
        top: 9px !important;
        width: 212px;
        height: 125px;
        left: 10px;
        min-height: 125px;
    }
    /*立即开通图片*/
    .btnxlick  img{
        position: absolute;
        top:56px;
        left:142px;
        z-index: 2;
    }
    .credit{
        position: absolute;
        top:81px;
        left:100px;
        width: 120px;
        overflow: hidden;
        color:red;
        font-style:italic;
        font-weight: bold;

    }


</style>
<body  >
	<div class="lsitit" >
		<div class="clear"></div>
<!--   已开通的服务包      -->
        <?php if(!empty($spfolders)){
            $html = '';
            foreach ($spfolders as $pidArr) {

                if (!empty($pidArr['itemlist'])) {
                    $html
                          .= ' <div class="studycourse studycourse-2" style="margin-top:0px; width:1000px; border:none;">
            <div class="other_room_tit"><h2>' . $pidArr['pname'] . '</h2></div>';//服务包
                    $html .= '<ul class="" style="padding-bottom: 10px;">';
                    foreach ($pidArr['itemlist'] as $folder) {
                        $folderurl = 'HTTP://' . $_SERVER['HTTP_HOST'] . '/study/cwlist/' . $folder['folderid'] . '.html';
                        $img       = $folder['img'] ? $folder['img'] : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg';
                        //判断学分是否显示
                        if ($folder['credit'] > 0 && $folder['creditget'] > 0) {
                            $credit = '<p class="credit">' . $folder['credit'] . '分/' . $folder['creditget'] . '分</p>';
                        } else {

                            $credit = '';
                        }
                        $html
                            .= ' <li class="fl">
                    <div class=" danke2s-1s">
                        ' . $credit . '
                        <a href="' . $folderurl . '" title="' . $folder['foldername'] . '"><img src="' . $img . '" width="212" height="125" border="0"></a>
                        <div class="rateoflearnfas">
                            <a href="' . $folderurl . '" title="' . $folder['foldername'] . '" class="coursrtitle-1s">
                                <p class="rateoflearnings" style="width:' . (isset($folder['percent']) ? $folder['percent'] : 0) . '%;">
                                    <span class="rateoflearnspans">' . $folder['foldername'] . '</span>
                                </p>
                            </a>
                        </div>
                        <div class="fenset">
                            <a href="' . $folderurl . '" title="' . $folder['foldername'] . '" class="coursrtitle-1s">
                            </a>

                        </div>
                    </div>
                </li>';
                    }
                    $html .= '</ul>';
                    $html .= '</div> ';
                }
            }
            echo $html;
        }?>

<!--        未开启的服务包-->

<!--  -->


</div>
    <!--   未开通的课程     -->
    <?php
    if(!empty($splist)){
        //选择卡
        $html = '<ul class="nav nav-tabs">';
        $i = 0;
        foreach ($splist as $pack){
            //服务包有课程才显示
            if(!empty($pack['itemlist'])){

            $html .= ' <li role="presentation" pid="'.$pack['pid'].'" class="'.($i==0?'active':'').'"><a href="#">'.$pack['pname'].'</a></li>';

            }
            $i++;
        }
        $html .= '</ul>';
        echo $html;

    }

    ?>
    <div class="kejian unopen" style="margin-top:0px; width:1000px; border:none;">

        <ul class="liss" style="padding-top:10px;padding-bottom:10px">
                <?php
                //课程列表
                if (!empty($splist)) {
                    foreach ($splist as $pack) {
                        if (!empty($pack['itemlist'])) {
                            $html = '';
                            foreach ($pack['itemlist'] as $folder) {
                                $img   = $folder['img']?$folder['img']:'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_247_147.jpg';
                                $html .= '  <li class="fl li1 sort65" style="height: 150px; display: block;" pid="' . $folder['pid'] . '">
                    <div class=" danke2s-1s">
                        <div class="rateoflearnfas">
                            <a target="_blank" href="javascript:;" title="点击立即开通" class="tuslick">
                                <p class="rateoflearnings" style="width:0%;">
                                    <span class="rateoflearnspans">' . $folder['foldername'] . '</span>
                                </p>
                            </a>
                        </div>


                        <div style="clear:both;"></div>

                        <div class="showimg">
                            <a href="javascript:;" target="_blank" title="点击立即开通"><img src="' .$img . '" width="212" height="125" border="0"></a>
                        </div>

                        <div class="piaoyin" style="background:url(http://static.ebanhui.com/ebh/tpl/default/images/buy-black.png) right bottom no-repeat;">

                            <a target="_blank" href="javascript:;" title="点击立即开通" class="tuslick"></a>
                            <a class="btnxlick btn" href="javascript:;" target="_blank" title="点击立即开通" itemid="237"><img width="70" height="70" src="http://static.ebanhui.com/ebh/tpl/default/images/buy-btn.png"></a>
                        </div>
                    </div>
                </li>';
                            }

                            echo $html; //输出课程列表
                        }
                    }
                }

                ?>




        </ul>
    </div>

    <!--        未开通的课程结束-->
</body>
<script>

$(function(){
 //未开通课程，选项卡点击

    $('li[role="presentation"]').on('click',function () {
        console.log(parent.document);
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        var pid = $(this).attr('pid');

        init(pid);
       return false;
    })
});
//初始化未开通课程
    function init(pid) {
        pid = pid ||  $('li[role="presentation"]').eq(0).attr('pid');
        var  n = 0;
        $('.liss li').each(function () {
            if(this.getAttribute('pid') == pid){
                $(this).show();
                n++;
            }else{
                $(this).hide();
            }
        })
        newHeight = Math.ceil(n/4)*160;

        if(tabHeight == 0){
            //首次载入记录当前高度
            tabHeight = newHeight;
        }else{
            //计算当前应增加或减少高度
            var height = tabHeight > newHeight ? -(tabHeight-newHeight):(newHeight-tabHeight);
            height = parseInt(height);
            var ifame = $(parent.mainFrame);
            var ifHeight = ifame[0].scrollHeight;
            $(ifame[0]).css({'height':(ifHeight+height)});
            tabHeight = tabHeight+height;

        }

    }
var tabHeight = 0;
init();
    $('a[href*="HTTP"]').on('click',function () {
        window.parent.layer.load();
    })

</script>
</html>
