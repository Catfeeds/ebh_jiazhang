<?php
class ChartLib{
	public function chart($dataarr,$charttype='Column3D',$chartid='chartid',$width=700,$height=350,$showvalues=1,$defaultmaxvalue='0'){
		if($charttype == 'MSColumn3D'){
			$datastr = '<graph caption="'.$dataarr['caption'].'" 	 showvalues="0"  formatNumberScale="0" yAxisMaxValue="10" 		decimalPrecision="0" 			 baseFont="宋体" baseFontSize="13" >';
			// $datastr.= '<categories>';
			// var_dump($dataarr);
			// $categorystr = '';
			// $datasetstr = '';
			// foreach($dataarr['datas'] as $key=>$value){
				// $categorystr.='<category name="'.$key.'" />';
				// $datasetstr.=
			// }
			$datastr.= '<categories>';
			$datastr.= '<category name="提问数" />';
			$datastr.= '<category name="回答数" />';
			$datastr.= '</categories>';
			$datastr.= '<dataset seriesName="我的"  showValues="0" color="AFD8F8" >';
			$datastr.= '<set value="'.$dataarr['datas']['myaskcount'].'"/>';
			$datastr.= '<set value="'.$dataarr['datas']['myanswercount'].'"/>';
			
			$datastr.= '</dataset>';
			
			$datastr.= '<dataset seriesName="同班同学的(平均)"  showValues="0" color="F6BD0F">';
			$datastr.= '<set value="'.$dataarr['datas']['classaskcount'].'"/>';
			$datastr.= '<set value="'.$dataarr['datas']['classanswercount'].'"/>';
			$datastr.= '</dataset>';
			
			$datastr.= '<dataset seriesName="全校同学的(平均)"  showValues="0" color="C9198D">';
			$datastr.= '<set value="'.$dataarr['datas']['allaskcount'].'"/>';
			$datastr.= '<set value="'.$dataarr['datas']['allanswercount'].'"/>';
			$datastr.= '</dataset>';
			
			$datastr.= '</graph>';
		}else{
			$max = max(array_values($dataarr['datas']));
			$ymaxvalue = '';
			if(empty($defaultmaxvalue))
				$ymaxvalue = floor($max/10+1)*10;
			else{
				// $pos = strlen($max);
				// $ofs = pow(10,$pos-2)*5;
				// $ymaxvalue = round($max+$ofs,-$pos+1)+pow(10,$pos-1);
				$ymaxvalue = round($max*1.5,-strlen($max)+1);
			}
			$datastr = '<graph showNames="1" rotateName="0" yAxisMaxValue="'.$ymaxvalue.'" baseFont="宋体" baseFontSize="13" 	caption="'.$dataarr['caption'].'" xAxisName="'.(empty($dataarr['xAxis'])?'':$dataarr['xAxis']).'" yAxisName="'.(empty($dataarr['yAxis'])?'':$dataarr['yAxis']).'" showValues="'.$showvalues.'" decimalPrecision="0" formatNumberScale="0" rotateYAxisName="0">';
			
			foreach($dataarr['datas'] as $key=>$value){
				
				$datastr.= '<set name="'.$key.'" value="'.$value.'" color="'.$this->randomColor().'" />';
				//'.($max==$value?'isSliced="1"':'').'
			}
			$datastr.= '</graph>';
		}
		
		$str = '<table width="98%" border="0" cellspacing="0" cellpadding="3" align="center">';
		$str.= '<tr><td valign="top" class="text" align="center"> <div id="div'.$chartid.'" align="center">图表. </div>';
		$str.= '<script type="text/javascript">
				var '.$chartid.' = new FusionCharts("http://static.ebanhui.com/ebh/js/AnalysisCharts/Charts/FCF_'.$charttype.'.swf", "'.$chartid.'", "'.$width.'", "'.$height.'");
				'.$chartid.'.setDataXML(\'';
		$str.= $datastr;
		$str.= '\')
				'.$chartid.'.render("div'.$chartid.'");';
		$str.= '</script> </td> </tr></table>';
		
		echo $str;
	}
	private function randomColor(){
		$s = '';
		for($i=0;$i<6;$i++){
			$s.= dechex(rand(0,15));
		}
		return $s;
	}
}
?>