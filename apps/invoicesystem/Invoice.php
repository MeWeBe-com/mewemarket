<?php
ob_start();

class Invoice{
	private $host  = 'localhost';
    private $user  = 'saasthemes_invoicegenerator';
    private $password   = "1000Dollar";
    private $database  = "saasthemes_invoicegenerator";
	private $invoiceUserTable = 'invoice_user';	
    private $invoiceOrderTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($email, $password){
		$sqlQuery = "
			SELECT id, company_name,email, first_name, last_name, address, mobile ,logo
			FROM ".$this->invoiceUserTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	
	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}		
	public function saveInvoice($POST) {		
		$sqlInsert = "
			INSERT INTO ".$this->invoiceOrderTable."(user_id, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, note) 
			VALUES ('".$POST['userId']."', '".$POST['companyName']."', '".$POST['address']."', '".$POST['subTotal']."', '".$POST['taxAmount']."', '".$POST['taxRate']."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['amountDue']."', '".$POST['notes']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
			VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
	}	
	public function updateInvoice($POST) {
		if($POST['invoiceId']) {	
			$sqlInsert = "
				UPDATE ".$this->invoiceOrderTable." 
				SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."' 
				WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['invoiceId']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
		}		
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
				VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);			
		}       	
	}	
	public function getInvoiceList(){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."'";
		return  $this->getData($sqlQuery);
	}	
	public function getInvoice($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND order_id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	
	public function getInvoiceItems($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);	
	}
	public function deleteInvoiceItems($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}
	public function deleteInvoice($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoiceId);	
		return 1;
	}

    public function getUser(){
        $sqlQuery = "
			SELECT * FROM ".$this->invoiceUserTable." 
			WHERE id = '".$_SESSION['userid']."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row;

    }

    public function updateUser($POST,$FILE) {
        if($POST['company_name']) {

            if(!empty($FILE['logo']['name'])){

                $file_name   = $FILE['logo']['name'];
                $file_tmp 	 = $FILE['logo']['tmp_name'];

                if(!empty($file_name)){
                    move_uploaded_file($file_tmp,"images/logo/".$file_name);
                }

                $POST['logo']  = $file_name;
            }

             if(!empty($FILE['logo']['name'])) {

				 $sqlInsert = "
				UPDATE " . $this->invoiceUserTable . " 
				SET company_name = '" . $POST['company_name'] . "', first_name = '" . $POST['first_name'] . "', 
				last_name = '" . $POST['last_name'] . "', mobile = '" . $POST['mobile'] . "', address = '" . $POST['address'] . "'
			, logo = '" . $POST['logo'] . "', color = '" . $POST['color'] . "'
				WHERE id = '" . $_SESSION['userid'] . "' ";

			 }else{

				 $sqlInsert = "
				UPDATE " . $this->invoiceUserTable . " 
				SET company_name = '" . $POST['company_name'] . "', first_name = '" . $POST['first_name'] . "', 
				last_name = '" . $POST['last_name'] . "', mobile = '" . $POST['mobile'] . "', address = '" . $POST['address'] . "'
				, color = '" . $POST['color'] . "'WHERE id = '" . $_SESSION['userid'] . "' ";

			 }

            $_SESSION['company_name'] = $POST['first_name'];
            $_SESSION['user'] = $POST['first_name'];
            $_SESSION['email'] = $POST['email'];
            $_SESSION['address'] = $POST['address'];
            $_SESSION['mobile'] = $POST['mobile'];

			if(empty($POST['color'])){
				$_SESSION['color'] = '#ad132f';
			}else{
				$_SESSION['color'] = $POST['color'];
			}

            if(!empty($FILE['logo']['name'])){
            	$_SESSION['logo'] = $POST['logo'];
			}

            mysqli_query($this->dbConnect, $sqlInsert);
        }
    }

     public function register_user($input_data)
	 {

		 $sqlInsert = "
			INSERT INTO invoice_user (company_name, email,password,first_name,last_name,mobile,address,logo)
			VALUES ('" . $input_data->company_name . "', '" . $input_data->email . "', '" . $input_data->password . "',
			'" . $input_data->first_name . "', '" . $input_data->last_name . "', '" . $input_data->phone . "', '', '')";
		 mysqli_query($this->dbConnect, $sqlInsert);
		 $lastInsertId = mysqli_insert_id($this->dbConnect);

		 return $lastInsertId;
	 }

}
?>
