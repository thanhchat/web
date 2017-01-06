<?php
/**
 * Created by PhpStorm.
 * User: ThanhChat
 * Date: 04/01/2015
 * Time: 11:33 AM 41
 */
//include_once("../configs/application.php");
//include_once("../connections/class.db.php");
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
			$sql = "SELECT * FROM $this->tbName WHERE PARENTS = $parentid and LEVEL=$level order by ORDERING ASC";
		else
			$sql = "SELECT * FROM $this->tbName WHERE PARENTS = $parentid order by ORDERING ASC";
        $query = $this->query($sql);
        $rs=$this->result();
        foreach($rs as $k=>$v){
            $trees[] = array("MENU_ID" => $v['MENU_ID'], "NAME" => $space.$v['NAME'], "PARENTS" => $v['PARENTS'], "LEVEL" => $v['LEVEL'], "ORDERING" => ($v['ORDERING']!=null)?$v['ORDERING']:"", "ENABLED" => $v['ENABLED'], "URL" => ($v['URL']!=null)?$v['URL']:"","IMAGE" => ($v['IMAGE']!=null)?$v['IMAGE']:"","CONTROLLER" => ($v['CONTROLLER']!=null)?$v['CONTROLLER']:"");
            $trees = $this->Menu($v['MENU_ID'],$level, $space.$char,$char, $trees);
        }
        return $trees;
    }
    public function getListCategory(){
        $sql="SELECT * FROM $this->tbName ORDER BY ORDERING ASC";
        return $this->getData($sql);
    }

    public function getCategoryById($id){
        $sql="SELECT * FROM $this->tbName WHERE $this->primary=$id";
        return $this->getData($sql);
    }
    public function editAction($idCat,$catName,$url,$ordering,$active,$parent,$level,$controller){
        $sql="UPDATE menu_items SET NAME='".$catName."',URL='".$url."',ORDERING=$ordering,ENABLED=$active,PARENTS=$parent,LEVEL=$level,CONTROLLER='".$controller."' WHERE MENU_ID=$idCat";
        $this->query($sql);
        return $this->execute();
    }
    public function addImage($image,$id){
        $sql="UPDATE menu_items SET IMAGE='".$image."' WHERE MENU_ID=$id";
        $this->query($sql);
        return $this->execute();
    }
	public function updateActive($idCat){
        $sql="UPDATE menu_items SET ENABLED=1-ENABLED WHERE MENU_ID=$idCat";
        $this->query($sql);
        return $this->execute();
    }
    public function addAction($catName,$url,$ordering,$active,$parent,$level,$controller){
        $sql="INSERT INTO menu_items(NAME,URL,ORDERING,ENABLED,PARENTS,LEVEL,CONTROLLER) VALUES ('".$catName."','".$url."',$ordering,$active,$parent,$level,'".$controller."')";
        $this->query($sql);
        return $this->execute();
    }
    public function deleteAction($id){
        $sql1="DELETE FROM menu_items WHERE PARENTS=$id";
        $this->query($sql1);
        $this->execute();
        $sql="DELETE FROM menu_items WHERE MENU_ID=$id";
        $this->query($sql);
        return $this->execute();
    }
}