<?php

class MobileRedirect extends DataObject {
	
	private static $default_sort = "Active DESC";
	
	private static $db = array(
		'Active'				=> 'Boolean',
		'MainSiteSource'  		=> 'enum("Page,URL","Page")',
		'MainSiteURL'  			=> 'Varchar(255)',
		'MobileSiteSource'  	=> 'enum("Page,URL","Page")',
		'MobileSiteURL'  		=> 'Varchar(255)',
	);
	
	private static $defaults = array(
		'Active'  	=> 1
	);
	
	private static $has_one = array(
		'MainSiteSiteTree'  	=> 'SiteTree',
		'MobileSiteSiteTree' 	=> 'SiteTree'	
	);
	
	private static $summary_fields = array(
		'Active'			=> 'Active',
		'MainSiteLink'  	=> 'Main Site Page',
		'MobileSiteLink' 	=> 'Mobile Site Page'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('MainSiteSiteTreeID');
		$fields->removeByName('MobileSiteSiteTreeID');
		
		$fields->addFieldToTab('Root.Main', CheckboxField::create('Active', 'Active'));
		
		$fields->addFieldToTab('Root.Main', OptionsetField::create('MainSiteSource', 'Main Site Source' ,$this->dbObject('MainSiteSource')->enumValues()));
		$fields->addFieldToTab('Root.Main', DisplayLogicWrapper::create(array(TreeDropdownField::create('MainSiteSiteTreeID', 'Main Site Page', 'SiteTree')))
			->displayIf("MainSiteSource")->isEqualTo("Page")->end());
		$fields->addFieldToTab('Root.Main', TextField::create('MainSiteURL', 'Main Site URL')->setDescription('Please use relative links i.e "/locations/sydney-wollongong/"')
			->displayIf("MainSiteSource")->isEqualTo("URL")->end());
		
		$fields->addFieldToTab('Root.Main', LiteralField::create('Mobilenote', '<p style="margin-left: 185px;">redirects to...<p>') );
		
		$fields->addFieldToTab('Root.Main', OptionsetField::create('MobileSiteSource', 'Mobile Site Source' ,$this->dbObject('MobileSiteSource')->enumValues()));
		$fields->addFieldToTab('Root.Main', DisplayLogicWrapper::create(array(MobileTreeDropdownField::create('MobileSiteSiteTreeID', 'Mobile Site Page', 'SiteTree')))
			->displayIf("MobileSiteSource")->isEqualTo("Page")->end());
		$fields->addFieldToTab('Root.Main', TextField::create('MobileSiteURL', 'Mobile Site URL')->setDescription('Please use relative links i.e "/prices/sydney-wollongong/"')
				->displayIf("MobileSiteSource")->isEqualTo("URL")->end());
		
		return $fields;
	}
	
	public function MainSiteLink(){
		if($this->MainSiteSource == 'Page'){
			$page = $this->MainSiteSiteTree();
			return $page ? $page->Link() : "";
		}else{
			return $this->MainSiteURL;
		}
	}
	
	public function MobileSiteLink(){
		if($this->MobileSiteSource == 'Page'){
			$page = $this->MobileSiteSiteTree();
			return $page ? $page->Link() : "";
		}else{
			return $this->MobileSiteURL;
		}
	}
	
	
}