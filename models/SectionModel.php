<?php
/**
 * 课程章节信息model类
 */
class SectionModel extends CModel{
    public function insert($param = array()) {
        $sid = $this->db->insert('ebh_sections',$param);
        return $sid;
    }
    public function getsections($param = array()) {
        $sql = 'select s.sid,s.sname from ebh_sections s ';
        $wherearr = array();
        if(!empty($param['folderid'])) 
            $wherearr[] = 's.folderid='.$param['folderid'];
        if(!empty($param['crid']))
            $wherearr[] = 's.crid='.$param['crid'];
        if(!empty($wherearr))
            $sql .= ' WHERE '.implode (' AND ', $wherearr);
        else
            return FALSE;
        $sql .=' order by s.displayorder asc';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 获取课程下章节的最大排序号
     * @param type $folderid课程编号
     * @return int 最大排序号
     */
    public function getmaxorder($folderid) {
        $sql = 'select max(s.displayorder) maxorder from ebh_sections s where s.folderid='.$folderid;
        $item = $this->db->query($sql)->row_array();
        $maxorder = 1;
        if(!empty($item))
            $maxorder = $item['maxorder'];
        return $maxorder;
    }
    public function update($param = array(),$wherearr = array()) {
        if(empty($param) || empty($wherearr) || empty($wherearr['sid']))
            return FALSE;
        return $this->db->update('ebh_sections',$param,$wherearr);
    }
    public function del($wherearr = array()) {
        if(empty($wherearr) || empty($wherearr['sid']))
            return FALSE;
        return $this->db->delete('ebh_sections',$wherearr);
    }
    public function moveup($sid) {
        $sql = 'select s.folderid,s.displayorder from ebh_sections s where s.sid='.$sid;
        $section = $this->db->query($sql)->row_array();
        if(empty($section))
            return FALSE;
        $folderid = $section['folderid'];
        $qsql = 'select s.sid,s.displayorder from ebh_sections s where s.folderid='.$folderid.' and s.displayorder < '.$section['displayorder'].' order by displayorder desc limit 1';
        $upsection = $this->db->query($qsql)->row_array();
        if(empty($upsection))
            return FALSE;
        $this->db->update('ebh_sections',array('displayorder'=>$upsection['displayorder']),array('sid'=>$sid));
        $this->db->update('ebh_sections',array('displayorder'=>$section['displayorder']),array('sid'=>$upsection['sid']));
        return TRUE;
    }
    public function movedown($sid) {
        $sql = 'select s.folderid,s.displayorder from ebh_sections s where s.sid='.$sid;
        $section = $this->db->query($sql)->row_array();
        if(empty($section))
            return FALSE;
        $folderid = $section['folderid'];
        $qsql = 'select s.sid,s.displayorder from ebh_sections s where s.folderid='.$folderid.' and s.displayorder > '.$section['displayorder'].' order by displayorder asc limit 1';
        $upsection = $this->db->query($qsql)->row_array();
        if(empty($upsection))
            return FALSE;
        $this->db->update('ebh_sections',array('displayorder'=>$upsection['displayorder']),array('sid'=>$sid));
        $this->db->update('ebh_sections',array('displayorder'=>$section['displayorder']),array('sid'=>$upsection['sid']));
        return TRUE;
    }
    /**
     * 章节排序号互换
     * @param int $sid1
     * @param int $sid2
     */
    public function move($sid1,$sid2) {
        
    }
}
