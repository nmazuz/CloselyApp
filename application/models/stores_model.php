<?php

class stores_model extends ci_Model {
	
	function getAll() {
		$q = $this->db->get('stores');
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
			    $data[] = $row;
			}
		return $data;
		}
	}
	
	function getStoreInfo($id) {
		$this->db->where('store_id', $id); 
		$q = $this->db->get('stores');
		return $q->result();	
	}
	
	function getRate($storeid,$rate,$user) {
		$data = array(
			'rate_id' => $storeid ,
			'rating' => $rate ,
			'user_id' =>  $user		
		);
		$this->db->insert('rating', $data); 
		return $this->db->_error_number();	
	}
	
	
	function ratedStore($storeid,$userId) {
		if ($userId){
			$this->db->where('rate_id', $storeid);
			$this->db->where('user_id', $userId);
			$q = $this->db->get('rating');
			log_message('debug',print_r($q->result(),true));
			if ($res = $q->result()){
				return array('user'=>$userId , 'rating'=>$res[0]->rating , 'exist'=>true);
			}
			return array('user'=>$userId , 'rating'=>null , 'exist'=>false);
		}
	  return array('user'=>null , 'rating'=>null , 'exist'=>false);	
	}
	
	function checkForBuyer($storeid,$userId) {
		if ($userId){
			$this->db->where('store_id', $storeid);
			$this->db->where('user_id', $userId);
			$q = $this->db->get('shopping');
			if ($res = $q->result()){
				return array('buy'=>true , 'message'=>'בתור לקוח שביצע רכישה בחנות , תוכל לדרג את החנות');
			}
			return array('buy'=>false , 'message'=>'דירוג החנות אפשרי רק ללקוחות שביצעו רכישה בחנות');
		}
	  return array('buy'=>false , 'message'=>'דירוג החנות אפשרי אך ורק למשתמשים רשומים');	
	}
	
	
	
	function getStoreRating($storeid) {
			$totalRating = 0;
			$this->db->where('rate_id', $storeid);
			$q = $this->db->get('rating');
			if ($res = $q->result()){
				foreach ($res as $rate){
					$totalRating += $rate->rating;
				}
				return $totalRating/sizeof($res);
			}
			return $totalRating;
	}
	
	function getRaterNum($id) {
		$this->db->where('rate_id', $id);
		$q = $this->db->get('rating');
		return $q->num_rows();
	}
	
	
	function getStoreUrlKey($id) {
		$this->db->select('url_key'); 
		$this->db->where('store_id', $id); 
		$q = $this->db->get('stores');
		$res = $q->result();
		return $res[0]->url_key;	
	}
	
	function getStoreImage($id) {
		$this->db->select('store_logo'); 
		$this->db->where('store_id', $id); 
		$q = $this->db->get('stores');
		$res = $q->result();
		return $res[0]->store_logo;	
	}
	
	function getBranches($id) {
		$this->db->where('store_id', $id); 
		$q = $this->db->get('branches');
		return $q->result();	
	}
	
	function getShopStoreLocation($shopStores) {
		if ($shopStores){
			$this->db->where_in('branch_id',$shopStores);
			$q = $this->db->get('branches');
		return $q->result();	
		} else{
			return null;
		}
	}
	
	function getStoreId($urlName) {
	    $urlName = urldecode($urlName);
		$this->db->select('store_id'); 
		$this->db->where('url_key',$urlName); 
		$q = $this->db->get('stores');
		$res = $q->result();
		return $res[0]->store_id;
	}

	function getlocation($id) {
		$this->db->select('location'); 
		$this->db->where('store_id', $id); 
		$q = $this->db->get('stores');
		$res = $q->result();
		 $locationArr = explode(',' , $res[0]->location);
		return $locationArr;	
	}

	function getLastCustomers($id) {
		$this->db->where('store_id', $id); 
		$this->db->select('user_id'); 
		$this->db->order_by("create_time", "desc");
		$q = $this->db->get('shopping',18);
		$customerArr = array();
		foreach ($q->result() as $user ){
			$customerArr[] = $user->user_id;	
		}
		$allShops = array_unique($customerArr);
		$uniqeCustomers = array_slice($allShops, 0, 18);
		return $uniqeCustomers;	
	}

	function getLastRecommands($id) {
		$this->db->where('store_id', $id); 
		$this->db->order_by("create_time", "desc");
		$q = $this->db->get('recommands',3);
		return $q->result();	
	}	
	
	function getRecommands($id) {
		$this->db->where('store_id', $id); 
		$this->db->order_by("create_time", "desc");
		$q = $this->db->get('recommands');
		return $q->result();	
	}
	
	function recommandsCnt($id) {
		$this->db->where('store_id', $id); 
		$q = $this->db->get('recommands');
		return $q->num_rows();	
	}
	
	function shopsCnt($id) {
		$this->db->where('store_id', $id); 
		$q = $this->db->get('shopping');
		return $q->num_rows();	
	}	

	function couponsCnt($id) {
		$this->db->where('store_id', $id); 
		$q = $this->db->get('coupons');
		return $q->num_rows();	
	}	
	
	function getRecords($tab , $storeId ,$view , $freinds){
		if (!empty($freinds) && $view == 2) {
			$this->db->where_in('user_id',$freinds);				
		}
		$this->db->where('store_id', $storeId); 
		$this->db->order_by("create_time", "desc");
		$q = $this->db->get($tab,9);
		return $q->result();
	}
	
	function getWebsiteCategories($id) {
		$this->db->select('category_id'); 
/* 		$this->db->where('store_id', $id);  */
		$q = $this->db->get('categories');
		return $q->result();
	}
	
	function getStoreProducts($id) {
		$this->db->select('product_name'); 
 		$this->db->where('store_id', $id);
		$q = $this->db->get('products');
		return $q->result();
	}


	
	function getStoreCategories($id) {
		$this->db->select('category_id'); 
		$this->db->where('store_id', $id); 
		$q = $this->db->get('stores_custom_categories');
		return $q->result();
	}
	
	
	
}