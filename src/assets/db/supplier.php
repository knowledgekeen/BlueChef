<?php
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

	//hotel.php?action=userHotel

include 'conn.php';

$action = $_GET['action'];

if($action == "supplierList"){
	$rows= array();
	$sql = "SELECT id,name,contact_address,contact_person,contact_number,deleted_by FROM supplier_register";
	$result = $conn->query($sql);
	while($row = $result->fetch_array())
	{
		$rows[] = $row;
	}

	$tmp = array();
	$data = array();
	$i = 0;
	if(count($rows)>0){
		foreach($rows as $row)
		{
			$tmp[$i]['id'] = $row['id'];
			$tmp[$i]['name'] = $row['name'];
			$tmp[$i]['cont_no'] = $row['contact_number'];
			$tmp[$i]['address'] = $row['contact_address'];
			$tmp[$i]['contact_person'] = $row['contact_person'];
			$tmp[$i]['contact_number'] = $row['contact_number'];
			$tmp[$i]['deleted_by'] = $row['deleted_by'];
			$i++;
		}
		$data["status"] = 200;
		$data["data"] = $tmp;
		header(' ', true, 200);
	}
	else{
		$data["status"] = 204;
		header(' ', true, 204);
	}

	echo json_encode($data);
}

 
if($action=='addSupplier'){
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$data = json_decode(file_get_contents("php://input"));
		$data1=array();

		$sname = $data->sname;
		$sadd = $data->sadd;
		$scontp = $data->scontp;
		$scontno = $data->scontno;
		$userid = $data->userid;


		$addSupplier="INSERT INTO supplier_register(name,contact_address,contact_person,contact_number,created_by,modified_by)VALUES('$sname','$sadd','$scontp','$scontno','$userid','$userid')";

		$result=$conn->query($addSupplier);

	}
	if($result){
		$data1["status"] = 200;
		header(' ', true, 200);
	}
	else{
		$data1["status"] = 204;
		header(' ', true, 204);
	}
	echo json_encode($data1);
}

if($action=='toggleSupplier'){
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$data = json_decode(file_get_contents("php://input"));
		$data1=array();

		$sid = $data->sid;
		$action = $data->action;
		$userid = $data->userid;
		

		 if($action === 'activate'){
		 
		 	$toggleHotel="Update supplier_register set modified_by='$userid' , modified_on=CURDATE(), deleted_by=null,deleted_on=null where id= $sid";
		}
		 if($action === 'deactivate'){
		 
			$toggleHotel="Update supplier_register set modified_by='$userid' , modified_on=CURDATE(),  deleted_by='$userid' ,deleted_on= CURDATE() where  id= $sid";
			 
		}	

		 $result=$conn->query($toggleHotel);
		 
	}
	if($result){
		$data1["status"] = 200;
		header(' ', true, 200);
	}
	else{
		$data1["status"] = 204;
		header(' ', true, 204);
	}
	echo json_encode($data1);
}


?>