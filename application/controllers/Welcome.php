<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('cart');
		$this->load->model('Product');
		
	}



	public function index()
	{
		// if ($this->input->post('keyword') != null){
		// 	search();
		// }
		// $products = $this->Product->get_all_products();
		// $info['products'] = $products;
		$headerinfo['title'] = "KMK Tees";
		$headerinfo['description'] = "Get excellent tees from us!";
		$this->load->view('header-store', $headerinfo);

		$this->load->view('store_ajax_message');
		$this->load->view('footer-store');
	}
	public function products_to_category($category)
	{
		$this->session->set_flashdata('category_flash',$category);  
		redirect("/");
	}
	public function products_to_search($searchterm)
	{
		$this->session->set_flashdata('search_flash',$searchterm);  
		redirect("/");
	}

	public function category($category)
	{
		$products = $this->Product->get_products_by_category($category);
		$info['products'] = $products;

		$info['category'] = $category;
		$headerinfo['title'] = "KMK Tees";
		$headerinfo['description'] = "Get excellent tees from us!";
		$this->load->view('header-store', $headerinfo);
		$this->load->view('store_message', $info);
		$this->load->view('footer-store');
	}

	public function categories_html($category) 
	{
		// $category = $this->input->get('category');
		// echo $category;
		// die();
		$data["products"] = $this->Product->get_products_by_category($category);
		// var_dump($data);
		// die();
		$this->load->view("partials/store_items", $data);
	}

	public function get_all_products_html() {
		$data["products"] = $this->Product->get_all_products();
		// $rowcount = count($data["products"]);
		// $this->load->library('pagination');
		// $config = array();
		// $config['base_url'] = base_url("Product/get_all_products");
		// $config['total_rows'] = $rowcount;
		// $config['per_page'] = 8; 
		// $this->pagination->initialize($config); 

		$this->load->view("partials/store_items", $data);
		// echo $config['base_url'];
		// die();
		// echo $this->pagination->create_links();

	}






	public function search_html() 
	{
		$searchterm = $this->input->post('keyword');
		// echo $searchterm;
		// die();
		$data["products"] = $this->Product->get_products_by_search_ajax($searchterm);
		// $data["searchingfor"] = $searchterm;
		$this->load->view("partials/store_items", $data);
	}




    // OLD SEARCH FUNCTION
  	public function search()
  	{
  		$searchterm = $this->input->post('keyword');
  		// echo $searchterm;
  		// die();
  		$products = $this->Product->get_products_by_search_ajax($searchterm);
  		$this->session->set_flashdata('search_flash', $searchterm);
  		$info['products'] = $products;
  		$info['searchterm'] = $searchterm;
  		$headerinfo['title'] = $searchterm." Search | KMK Tees";
  		$headerinfo['description'] = "Get excellent tees from us!";
  		$this->load->view('header-store', $headerinfo);
  		$this->load->view('store_ajax_message', $info);
  		$this->load->view('footer-store');
  	}


  	// END SEARCH FUNCTION

	public function product($id)
	{

		$thisproduct = $this->Product->get_one_product($id);
		$suggestprods = $this->Product->get_recommended_products($id);
		$productinfo['thisid'] = $id;
		$productinfo['thisproduct'] = $thisproduct;
		$productinfo['suggestprods'] = $suggestprods;
		$headerinfo['title'] = $thisproduct['name']." | KMK Tees";
		$headerinfo['description'] = $thisproduct['name'].", only from KTK Tees!";
		$this->load->view('header-store', $headerinfo);
		$this->load->view('product_message', $productinfo);
		$this->load->view('footer-store');
	}
		public function signin_register()
	{
		
		$headerinfo['title'] = "Sign In | KMK Tees";
		$headerinfo['description'] = "Sign in or register or more excellent tees!";
		$this->load->view('header-store', $headerinfo);
		$this->load->view('signin_register_message');
		$this->load->view('footer-store');
	}

	public function about_us()
	{
		
		$headerinfo['carttotal'] = $this->cart->total();
		$headerinfo['title'] = "KMK Tees";
		$headerinfo['description'] = "Get excellent tees from us!";
		$this->load->view('header-store', $headerinfo);
		$this->load->view('about_us');
		$this->load->view('footer-store');
	}

	public function user_orders()
	{	
		$this->load->model('Order');
		$userid = $this->session->userdata('user_id');
		$orders = $this->Order->get_orders_from_user2($userid);
		// var_dump($orders);
		// die();
		$info['orders'] = $orders;
		$headerinfo['title'] = "Order History | KMK Tees";
		$headerinfo['description'] = "Order History from KMK Tees";
		$this->load->view('header-store', $headerinfo);
		$this->load->view('user_orders_message', $info);
		$this->load->view('footer-store');

	}

	public function cssoptions()
	{
		$option = $this->input->post('cssoption');
		if ($option == "gameboy") {
		$this->session->set_userdata('cssoption','stylesheet');
		// var_dump($this->session->userdata('cssoption')); die();
		redirect("/");
		}
		elseif ($option == "nes") {
			$this->session->set_userdata('cssoption','nofollow');
			redirect("/");
		}
	}
}
