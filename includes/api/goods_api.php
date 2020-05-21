<?php
/**
 * 商品操作接口
 * @author 捕风阁 www.osuu.net
 * @program  BF发卡网 https://github.com/osuuu/BF_SHOP
 * @time 2020.4.13
 */
include("../api.inc.php");
$username=daddslashes($_POST['username']);
$password=daddslashes($_POST['password']);
$all=$_POST['all'];//获取全部
$add=$_POST['add'];//添加
$type_id=$_POST['type_id'];
$price=$_POST['price'];
$minbuy=$_POST['minbuy'];
$maxbuy=$_POST['maxbuy'];
$weight=$_POST['weight'];
$state=$_POST['state'];
$sales=$_POST['sales'];
$img=$_POST['img'];
$info=$_POST['info'];
$sm1=$_POST['sm1'];
$sm2=$_POST['sm2'];
$sm3=$_POST['sm3'];
$id=$_POST['id'];//详细查询
$del=$_POST['del'];//删除
$edit=$_POST['edit'];//编辑
$name=$_POST['name'];
$type=$_POST['type'];//分类查询

$data = file_get_contents(curPageURL().'/includes/api/login_api.php?username='.$username.'&password='.$password);
$data = json_decode($data,true);

if($data['status'] == 200){
	if($all){//查询全部
		$res = $dbh->prepare("select * from bf_goods");
		$res->execute();
		$row = $res->fetchAll(PDO::FETCH_ASSOC);
		$result = array("status" => 200, "message" => "获取成功", "data" => $row);
	}else if($id){//详细查询
		$res = $dbh->prepare("select * from bf_goods where id = $id");
		$res->execute();
		$row = $res->fetch(PDO::FETCH_ASSOC);
		$result = array("status" => 200, "message" => "获取成功", "data" => $row);
	}else if($type){//分类查询
		$res = $dbh->prepare("select * from bf_goods where type_id = $type");
		$res->execute();
		$row = $res->fetchAll(PDO::FETCH_ASSOC);
		$result = array("status" => 200, "message" => "获取成功", "data" => $row);
	}else if($add){//添加
		$sql="insert into bf_goods (name,weight,info,type_id,price,minbuy,maxbuy,state,sales,img,time,sm1,sm2,sm3) values (:name,:weight,:info,:type_id,:price,:minbuy,:maxbuy,:state,:sales,:img,:time,:sm1,:sm2,:sm3)";
		$res = $dbh->prepare($sql);
		$res->bindValue(":name",$add);
		$res->bindValue(":weight",$weight);
		$res->bindValue(":info",$info);
		$res->bindValue(":type_id",$type_id);
		$res->bindValue(":price",$price);
		$res->bindValue(":minbuy",$minbuy);
		$res->bindValue(":maxbuy",$maxbuy);
		$res->bindValue(":state",$state);
		$res->bindValue(":sales",$sales);
		$res->bindValue(":img",$img);
		$res->bindValue(":time",time());
		$res->bindValue(":sm1",$sm1);
		$res->bindValue(":sm2",$sm2);
		$res->bindValue(":sm3",$sm3);
		$res->execute();
		$row = $res->rowCount();
		if($row == 1){
			$result = array("status" => 200, "message" => "添加成功", "data" => null);
		}else{
			$result = array("status" => 100, "message" => "添加失败", "data" => null);
		}
	}else if($del){//删除商品
		$res = $dbh->prepare("delete from bf_goods where id=$del");
		$res->execute();
		$row = $res->rowCount();
		if($row == 1){
			$result = array("status" => 200, "message" => "删除成功", "data" => null);
		}else{
			$result = array("status" => 100, "message" => "删除失败", "data" => null); 
		}
	}else if($edit){//编辑
		$sql="update bf_goods set name=:name,weight=:weight,state=:state,type_id=:type_id,price=:price,minbuy=:minbuy,maxbuy=:maxbuy,sales=:sales,img=:img,info=:info where id = :id";
		$res = $dbh->prepare($sql);
		$res->bindValue(":id",$edit);
		$res->bindValue(":name",$name);
		$res->bindValue(":weight",$weight);
		$res->bindValue(":state",$state);
		$res->bindValue(":type_id",$type_id);
		$res->bindValue(":price",$price);
		$res->bindValue(":minbuy",$minbuy);
		$res->bindValue(":maxbuy",$maxbuy);
		$res->bindValue(":sales",$sales);
		$res->bindValue(":img",$img);
		$res->bindValue(":info",$info);
		$res->execute();
		$row = $res->rowCount();
		if($row == 1){
			$result = array("status" => 200, "message" => "修改成功", "data" => null);
		}else{
			$result = array("status" => 100, "message" => "修改失败", "data" => null);
		}
	}
	
}else{
	$result = array("status" => -1, "message" => "验证失败", "data" => null);
}


echo(json_encode($result));   


        
?>