<?php
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

	//hotel.php?action=userHotel

include 'conn.php';

$action = $_GET['action'];

if($action == "userHotel"){
	$usrId = $_GET["usrId"];
	$rows= array();
	$sql = "SELECT u.user_name,h.id,h.address,h.contact_person,h.contact_number,h.name,h.deleted_by FROM `user_register` u, `hotel_register` h WHERE u.id = h.user_id and h.user_id=$usrId";
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
			$tmp[$i]['user_name'] = $row['user_name'];
			$tmp[$i]['address'] = $row['address'];
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

if($action == "allHotels"){
	$rows= array();
	$sql = "SELECT u.user_name,h.id,h.address,h.contact_person,h.contact_number,h.name,h.deleted_by FROM `user_register` u, `hotel_register` h WHERE u.id = h.user_id";
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
			$tmp[$i]['address'] = $row['address'];
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

//get user
if($action == "usersList"){

	$sql = "select * from user_register";
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
			$tmp[$i]['fname'] = $row['first_name'];
			$tmp[$i]['lname'] = $row['last_name'];
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
if($action=='addHotel'){
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$data = json_decode(file_get_contents("php://input"));
		$data1=array();

		$hname = $data->hname;
		$hadd = $data->hadd;
		$hcont = $data->hcont;
		$hcontid = $data->hcontid;
		$hno = $data->hno;
		$userid = $data->userid;


		$addHotel="INSERT INTO hotel_register(name,address,contact_person,contact_number,user_id,created_by,modified_by)VALUES('$hname','$hadd','$hcont','$hno','$hcontid','$userid','$userid')";

		$result=$conn->query($addHotel);

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

if($action=='toggleHotel'){
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$data = json_decode(file_get_contents("php://input"));
		$data1=array();

		$hid = $data->hid;
		$action = $data->action;
		$userid = $data->userid;
		

		 if($action === 'activate'){
		 
		 	$toggleHotel="Update hotel_register set  modified_by='$userid' , modified_on=CURDATE(),  deleted_by=null,deleted_on=null where id= $hid";
		}
		 if($action === 'deactivate'){
		 
			$toggleHotel="Update hotel_register set  modified_by='$userid' , modified_on=CURDATE(),  deleted_by='$userid' ,deleted_on= CURDATE() where  id= $hid";
			 
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