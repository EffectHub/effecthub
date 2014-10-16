<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( APPPATH.'/libraries/rss/feedcreator.class.php' );
class Rss extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('xml');
		$this->load->helper('text');
	}
	
	public function index(){
		
		$rss = new UniversalFeedCreator();
		$rss->useCached();
		$rss->title = "Effecthub.com";
		$rss->description = "daily gaming contents from effecthub!";
		$rss->link = site_url('item/MostRecent');
		$rss->syndicationURL = site_url('rss');
		
		$image = new FeedImage();
		$image->title = "Effecthub.com";
		$image->url = base_url()."images/logo-bw.jpg";
		$image->link = "http://www.effecthub.com";
		$image->description = "Feed provided by Effecthub. Click to visit.";
		$rss->image = $image;
		
		// get your items from somewhere, e.g. your database:
		$this->load->model('item_model');
		
		$resource = $this->item_model->order_item_by_feature_offset('MostRecent','all',50,0);
		foreach ($resource as $res) {
			$item = new FeedItem();
			$item->title = $res['title'];
			$item->link = site_url('item/'.$res['id']);
			$item->description = $res['desc'];
			$item->date = $res['update_date'];
			$item->source = "http://www.effecthub.com";
			$item->author = $res['author_name'];
		
			$rss->addItem($item);
		}
		
		$rss->saveFeed(base_url().'rss/feed.xml',"RSS1.0");
	}
	


}
