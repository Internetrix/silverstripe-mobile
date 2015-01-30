<?php
class MobileRedirectsAdmin extends ModelAdmin {
	
	private static $menu_icon = 'mobile/images/icons/redirect.jpg';
	
	private static $title       = 'Redirects';
	private static $menu_title  = 'Redirects';
	private static $url_segment = 'redirects';
	private static $page_length = 100;

	private static $managed_models  = array('MobileRedirect');
	private static $model_importers = array();

}