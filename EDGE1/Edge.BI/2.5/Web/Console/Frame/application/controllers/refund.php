<?php

class Refund extends Controller{
	
	function index(){
		
		$this->load->view('refund');		
	}
	function delete(){
		
		$this->load->view('delete_refund');		
		
	}
	function proccess(){
		 $data = json_decode(file_get_contents("php://input"), true) ;
		 /*
		$data=array(
			"AccountID"=>$this->input->post('accountID'),
			"Month" =>$this->input->post('date'),
			"RefundAmount" =>$this->input->post('refund'),
			"ChannelID"=>$this->input->post('channel')
		);		
		*/
	
		$data["RefundAmount"]=intval($data["RefundAmount"]);
		$result = $this->edgeapi->Request('/tools/refund', 'POST', true, array('Content-Type: application/json'), $data, true);
		
	}	
	
	function deleteprocess(){
				 $data = json_decode(file_get_contents("php://input"), true) ;
		/*
			$data=array(
			"AccountID"=>$this->input->post('accountID'),
			"Month" =>$this->input->post('date'),
			"ChannelID"=>$this->input->post('channel')
		);		
		
		*/
		$result = $this->edgeapi->Request('/tools/deleterefund', 'POST', true, array('Content-Type: application/json'), $data, true);
		
		
	}
}