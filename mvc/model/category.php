<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 04/01/2015
 * Time: 11:33 AM 41
 */
//include_once("configs/application.php");
//include_once("connections/class.db.php");
class category extends database {
    private $tbName = "menu_items";
    private $primary = "MENU_ID";
	
    public function Menu($parentid = 0, $level,$space,$char, $trees = array())
    {
        if(!$trees)
        {
            $trees = array();
        }
		if($level!=-1)
			$sql = "SELECT * FROM $this->tbName WHERE PARENTS = $parentid and LEVEL=$level and ENABLED=1 order by ORDERING ASC";
		else
			$sql = "SELECT * FROM $this->tbName WHERE PARENTS = $parentid order by ORDERING ASC";
        $query = $this->query($sql);
        $rs=$this->result();
        foreach($rs as $k=>$v){
            $trees[] = array("MENU_ID" => $v['MENU_ID'], "NAME" => $space.$v['NAME'], "PARENTS" => $v['PARENTS'], "LEVEL" => $v['LEVEL'], "ORDERING" => ($v['ORDERING']!=null)?$v['ORDERING']:"", "ENABLED" => $v['ENABLED'], "URL" => ($v['URL']!=null)?$v['URL']:"","IMAGE" => ($v['IMAGE']!=null)?$v['IMAGE']:"");
            $trees = $this->Menu($v['MENU_ID'],$level, $space.$char,$char, $trees);
        }
        return $trees;
    }
	public function getAllListCategory($id,$trees = array())
    {
        if(!$trees)
        {
            $trees = array();
        }
		$sql = "SELECT * FROM $this->tbName WHERE PARENTS = $id  AND ENABLED=1 order by ORDERING ASC";
        $query = $this->query($sql);
        $rs=$this->result();
        foreach($rs as $k=>$v){
            $trees[] = array("MENU_ID" => $v['MENU_ID'], "NAME" =>$v['NAME'], "PARENTS" => $v['PARENTS'], "LEVEL" => $v['LEVEL'], "ORDERING" => ($v['ORDERING']!=null)?$v['ORDERING']:"", "ENABLED" => $v['ENABLED'], "URL" => ($v['URL']!=null)?$v['URL']:"","IMAGE" => ($v['IMAGE']!=null)?$v['IMAGE']:"");
            $trees = $this->getAllListCategory($v['MENU_ID'],$trees);
        }
        return $trees;
    }
    public function getListCategory(){
        $sql="SELECT * FROM $this->tbName where ENABLED=1 and PARENTS=0 ORDER BY ORDERING ASC";
        return $this->getData($sql);
    }
	public function getListCategoryByLevel($idParent,$level){
        $sql="SELECT * FROM $this->tbName where PARENTS = $idParent and LEVEL=$level and ENABLED=1 ORDER BY ORDERING ASC";
        return $this->getData($sql);
    }
	public function filterCategory(){
        $sql="SELECT * FROM $this->tbName where ENABLED=1 ORDER BY ORDERING ASC";
        return $this->getData($sql);
    }
    public function getCategoryById($id){
        $sql="SELECT * FROM $this->tbName WHERE $this->primary=$id";
        return $this->getData($sql);
    }
	public function listMenuItems($uri_cur, $array, $index, $cssActive)
    {
        $i = 0;
        if (isset($uri_cur[1 - $index])&&$uri_cur[1 - $index]!="") {
			//var_dump($array);
            foreach ($array as $key => $value) {
                $str = explode("/", $value["URL"]);
                if (isset($str[2 - $index])&&$str[2 - $index]!='') {
                    if ($str[2 - $index] == $uri_cur[1 - $index]) {
                        $array[$key]["STATUS"] = $cssActive;
                        $i = 1;
                        break;
                    } else {
                        $array[$key] = $value;
                    }
                } else {
                    $array[$key] = $value;
                }
            }
        }
        if ($i == 1) {
            foreach ($array as $key => $value) {
                if ($value["URL"] == "/") {
                    $array[$key]["STATUS"] = "";
                    $i = 0;
                    break;
                }
            }
        }
        return $array;
    }
	function getListMenuById($id)
    {
        $sql = "select * from menu_items where PARENTS=$id and ENABLED=1 order by ORDERING ASC";
        return $this->getData($sql);
    }
	function contains($haystack,$needle)
	{
		return strpos($haystack, $needle) !== false;
	}
	function checkUrl($url,$array){
		if($url!=''){
			foreach ($array as $key => $value) {
				 if ($this->contains($value["URL"],"/".$url))
					return true;
			}
		}
		return false;
	}
	function getcategory($id,$array,$url){
		$str='';
		 $array1=$this->getSubcategory($id,$array);
		 $str.= '<ul>';
		  foreach ($array1 as $key => $value) {
			  $array2 = $this->getSubcategory($value['MENU_ID'],$array);
			  if(count($array2)==0){
				//echo $value['URL'];
				$arr=explode('/',$value['URL']);
				//var_dump($arr);
				if("/".$arr[count($arr)-1]=="/".$url)
					$str.= '<li class="active"><a href="'.$value['URL'].'" >'.$value['NAME'].'</a></li>';
				else
					$str.= '<li><a href="'.$value['URL'].'" >'.$value['NAME'].'</a></li>';
			  }else{
				  if($this->checkUrl($url,$array2))
						$str.='<li class="has-sub open"><a href="#">'.$value['NAME'].'</a>';
				  else
						$str.='<li class="has-sub"><a href="#">'.$value['NAME'].'</a>';
				  $str.=$this->getcategory($value['MENU_ID'],$array,$url);
				  $str.= '</li>';
				  
			  }
		  }
		   $str.= '</ul>';
		return $str;
	}
	
	function getSubcategory($parent,$array){
		$arrayMenuitem=array();
		foreach ($array as $key => $value) {
			if($parent==$value['PARENTS'])
				array_push($arrayMenuitem,$value);
		}
		return $arrayMenuitem;
    }
	function getSubParent($parent,$array){
		$arrayMenuitem=array();
		foreach ($array as $key => $value) {
			if($value['MENU_ID']==$parent)
				array_push($arrayMenuitem,$value);
		}
		return $arrayMenuitem;
    }
	function getParentMenu($parent, $array,$arrp)// tim vi tri tu no tro len cac thu muc truoc no den thu muc cha
    {
        if ($parent == 0){
            return $arrp;// dung lai khi no gap id goc la id cha ( khong con ai la cha cua no)
			}
        $array1=$this->getSubParent($parent,$array);
		$arrp[] = array('URL' => $array1[0]['URL']);
		$arrp = $this->getParentMenu($array1[0]['PARENTS'], $array,$arrp);// thuc hien de qui
        return $arrp;
    }
	function getUrlCategoryProduct($array_url){
		$str='<a href="/">Trang chủ</a>';
		if(LINKS1!='')
			$str.='<a href="/'.LINKS1.'">'.LINKS1.'</a>';
		if(LINKS1!=''&&LINKS2!='')
			$str.='<a href="/'.LINKS1.'/'.LINKS2.'">'.LINKS2.'</a>';
		if(LINKS1!=''&&LINKS2!=''&&LINKS3!='')
			$str.='<a href="/'.LINKS1.'/'.LINKS2.'/'.LINKS3.'">'.LINKS3.'</a>';
		if(LINKS1!=''&&LINKS2!=''&&LINKS3!=''&&LINKS4!='')
			$str.='<a href="/'.LINKS1.'/'.LINKS2.'/'.LINKS3.'/'.LINKS4.'">'.LINKS4.'</a>';
		return $str;
	}
}