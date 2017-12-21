<?php
/**
 *统计代码
 */
class Analytics{

  public function get($name = 'baidu'){
      if(IS_DEBUG){
        return '';
      }else{
        return $this->$name();
      }
      
  }
	
  public function __call($fname,$args){
    return '';
  }
  /**百度统计代码**/
  public function baidu(){
    $curdomain =  EBH::app()->getUri()->curdomain;
    $ebh = <<<EOT
    <div style="display:none">
    <script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?97ff601394bc14795cc836a8a41f7d7d";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
      </script>
    </div>
EOT;

    $ebanhui = <<<EOT
    <div style="display:none">
      <script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?92f930c567dfe34c08ce46827d9e9ccd";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
      </script>
    </div>
EOT;
    if($curdomain=='ebanhui.com'){
      echo $ebanhui;
    }else{
      echo $ebh;
    }
  }
}
