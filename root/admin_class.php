<?php
session_start();
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}
	
	function login(){
    extract($_POST);
    $hashed_password = md5($password); // Hash the provided password
    $qry = $this->db->query("SELECT * FROM users WHERE username = '".$username."' AND password = '".$hashed_password."' AND validate_user='1' ");
    if($qry->num_rows > 0){
        foreach ($qry->fetch_array() as $key => $value) {
            if($key != 'password' && !is_numeric($key)) // Fix typo 'passwors' to 'password'
                $_SESSION['login_'.$key] = $value;
        }
        if($_SESSION['login_type'] == 1)
            return 1; // Admin user
        else
            return 2; // Regular user (staff/student)
    }else{
        return 3; // Login failed
    }
}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", user_card_no = '$username' ";
		$data .= ", user_email = '$email' ";
		$data .= ", user_phone_no = '$contact' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	
	function save_password(){
		extract($_POST);
		$data = " password = '".md5($password)."' ";
		$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		if($save)
			return 1;
	}
	
		function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	
	function update_user_verify(){
		extract($_POST);
		$data = " validate_user = '$verify' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " faculty_name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data." where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	function save_category(){
		extract($_POST);
		$data = " `name` = '$name' ";
		$data .= ", `desc` = '$desc' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", `cover_img` = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO item_categories set ".$data);
		}else{
			$save = $this->db->query("UPDATE item_categories set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM item_categories where id = ".$id);
		if($delete)
			return 1;
	}
	function cancel_book(){
		extract($_POST);
		$data = " status = 3 ";
		$save = $this->db->query("UPDATE checked set ".$data." , date_updated = NOW() where id=".$id);
		if($save)
			return 1;
	}
	function cancel_book_admin(){
		extract($_POST);
		$data = "status = 3"; // Set status to 3 for checked
		$data1 = "status = 0"; // Set status to 0 for items
		$save = $this->db->query("UPDATE checked INNER JOIN items ON checked.item_id = items.id SET checked.".$data.", items.".$data1." , checked.date_updated = NOW() WHERE checked.id = ".$id);
		if($save)
			return 1;
	}
	function save_item(){
		extract($_POST);
		$data = " item = '$item' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", status = '$status' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO items set ".$data);
		}else{
			$save = $this->db->query("UPDATE items set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_item(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM items where id = ".$id);
		if($delete)
			return 1;
	}

	function save_check_in(){
		extract($_POST);
		$data = " item_id = '$rid' ";
		if(!empty($cid)){
		$data .= ", booked_cid = '$cid' ";
		}else{ }
		if(!empty($booker_type)){
		$data .= ", booked_type = '$booker_type' ";
		}else{ }	
		$data .= ", name = '$name' ";
		$data .= ", user_type = '$type' ";
		$data .= ", std_stff_num = '$std_stff_num' ";
		$data .= ", email_user = '$email' ";
		$data .= ", contact_no = '$contact' ";
		$data .= ", status = 1 ";

		$data .= ", date_in = '".$date_in.' '.$date_in_time."' ";
		$out= date("Y-m-d H:i",strtotime($date_in.' '.$date_in_time.' +'.$days.' days'));
		$data .= ", date_out = '$out' ";

		
		if(empty($id)){
		$i = 1;
		while($i== 1){
			$ref  = sprintf("%'.04d\n",mt_rand(1,9999999999));
			if($this->db->query("SELECT * FROM checked where ref_no ='$ref'")->num_rows <= 0)
				$i=0;
		}

		$data .= ", ref_no = '$ref' ";
		
			$save = $this->db->query("INSERT INTO checked set ".$data);
			$id=$this->db->insert_id;
		}else{
			
		$i = 1;
		while($i== 1){
			$ref  = sprintf("%'.04d\n",mt_rand(1,9999999999));
			if($this->db->query("SELECT * FROM checked where ref_no ='$ref'")->num_rows <= 0)
				$i=0;
		}

		$data_without_ref = str_replace(", ref_no = '$ref'", "", $data);
			
			$save = $this->db->query("UPDATE checked set ".$data_without_ref." where id=".$id);
		}
		if($save){

			$this->db->query("UPDATE items set status = 1 where id=".$rid);
					return $id;
		}
	}
	function save_checkout(){
		extract($_POST);
			$save = $this->db->query("UPDATE checked set status = 2, date_updated = NOW() where id=".$id);
			if($save){

				$this->db->query("UPDATE items set status = 0 where id=".$rid);
						return 1;
			}

	}
	
	//function save_book(){
		//extract($_POST);
		//$data = " `booked_cid` = '$cid' ";
		//$data .= ", `name` = '$name' ";
		//$data .= ", `contact_no` = '$contact' ";
		//$data .= ", `status` = 0 ";

		//$data .= ", `date_in` = '".$date_in.' '.$date_in_time."' ";
		//$out= date("Y-m-d H:i",strtotime($date_in.' '.$date_in_time.' +'.$days.' days'));
		//$data .= ", `date_out` = '$out' ";
		//$i = 1;
		//while($i== 1){
			//$ref  = sprintf("%'.04d\n",mt_rand(1,9999999999));
			//if($this->db->query("SELECT * FROM checked where ref_no ='$ref'")->num_rows <= 0)
				//$i=0;
		//}
		//$data .= ", `ref_no` = '$ref' ";

			//$save = $this->db->query("INSERT INTO checked set ".$data);
			//$id=$this->db->insert_id;
		
		//if($save){
					//return $id;
		//}
	//}
	
		function save_book(){
		extract($_POST);

		$data = " `booked_cid` = '$cid' ";
		$data .= ", `booked_type` = '$booker_type' ";				
		$data .= ", `name` = '$name' ";
		$data .= ", `user_type` = '$type' ";
		$data .= ", `std_stff_num` = '$std_stff_num' ";
		$data .= ", `email_user` = '$email' ";
		$data .= ", `contact_no` = '$contact' ";
		$data .= ", `status` = 0 ";
		$data .= ", `date_in` = '$date_in $date_in_time'";
		
		$out = date("Y-m-d H:i:s", strtotime($date_in . ' ' . $date_in_time . ' +' . $days . ' days'));
		$data .= ", `date_out` = '$out' ";
		
		$i = 1;
		while($i== 1){
			$ref  = sprintf("%'.04d\n",mt_rand(1,9999999999));
			if($this->db->query("SELECT * FROM checked where ref_no ='$ref'")->num_rows <= 0)
				$i=0;
		}
		$data .= ", `ref_no` = '$ref' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO checked set ".$data);
		}else{
		}
		if($save){
			return 1;
		}
	}

}