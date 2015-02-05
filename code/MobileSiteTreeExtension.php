<?php
/**
 * @package mobile
 */
class MobileSiteTreeExtension extends DataExtension {
	
	public static $db = array(
		'DisableMobileRedirect' => 'Boolean'
	);
	
	public function updateSettingsFields(FieldList $fields){
		$fields->insertBefore(CheckboxField::create('DisableMobileRedirect', 'Disable the mobile redirect for this page?'), 'ShowInMenus');
	}
	
	function MetaTags(&$tags) {
		$config = SiteConfig::current_site_config();

		// Ensure a canonical link is placed, for semantic correctness and SEO
		if(Controller::has_curr() && Controller::curr()->hasMethod("onMobileDomain") && Controller::curr()->onMobileDomain() && $config->MobileSiteType == 'RedirectToDomain') {
			$oldBaseURL = Director::baseURL();

			Config::inst()->update('Director', 'alternate_base_url', $config->FullSiteDomain);
			$tags .= sprintf('<link rel="canonical" href="%s" />', $this->owner->AbsoluteLink()) . "\n";
			Config::inst()->update('Director', 'alternate_base_url', $oldBaseURL);
		}
	}
	
}
