<?php
class content_model extends appModel {
  function __construct() {
    parent::__construct();

    include(dirname(__file__)."/config.php");

    foreach($aPluginInfo["config"] as $sKey => $sValue) {
      $this->$sKey = $sValue;
    }
  }

  /**
  * Get pages from the database.
  * @param  boolean $sAll      When true returns all posts no matter conditions.
  * @return array              Return array of posts.
  */
  function getPages($sAll = false) {
    $aWhere = array();
    $sJoin = '';

    // Filter only posts that are active unless told otherwise.
    if($sAll == false) {
      $aWhere[] = "`active` = 1";
    }

    // Combine the above filters for sql.
    if(!empty($aWhere)) {
      $sWhere = " WHERE ".implode(" AND ", $aWhere);
    }

    $aPages = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}content`"
      .$sJoin
      .$sWhere
      ." GROUP BY `id`"
      ." ORDER BY `title` ASC"
      , "all"
    );

    // Clean up each page information and get additional info if needed.
    foreach($aPages as &$aPage) {
      $this->_getPageInfo($aPage);
    }

    return $aPages;
  }

  function getPage($sId, $sTag = null) {
    if(!empty($sTag)) {
      $sWhere = " WHERE `tag` = ".$this->dbQuote($sTag, "text");
    } else {
      $sWhere = " WHERE `id` = ".$this->dbQuote($sId, "integer");
    }

    $aPage = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}content`"
      .$sWhere
      ,"row"
    );

    $this->_getPageInfo($aPage);

    return $aPage;
  }

  function getPageTag($sId) {
    $sTag = $this->dbQuery(
      "SELECT `tag` FROM `{dbPrefix}content`"
      ." WHERE `id` = ".$this->dbQuote($sId, "integer")
      ,"row"
    );

    return $sTag;
  }

  /**
  * Clean up page info and get any other data to be returned.
  * @param  array &$aPage An array of a single page.
  */
  private function _getPageInfo(&$aPage) {
    if(!empty($aPage)) {
      $aPage["title"] = htmlspecialchars(stripslashes($aPage["title"]));
      $aPage["content"] = stripslashes($aPage["content"]);
      $aPage["subtitle"] = htmlentities(stripslashes($aPage["subtitle"]));
      $aPage["tags"] = htmlspecialchars(stripslashes($aPage["tags"]));

      $aPage['url'] = $this->_buildUrl($aPage['tag'], $aPage['parentid']);
    }
  }

  private function _buildUrl($sTag, $sParentId = null, $sUrl = null) {
    if(!empty($sParentId)) {
      $aParentPage = $this->dbQuery(
        "SELECT `tag`, `parentid` FROM `{dbPrefix}content`"
        ." WHERE `id` = ".$this->dbQuote($sParentId, "integer")
        ,"row"
      );

      $sUrl = '/'.$sTag.$sUrl;

      return $this->_buildUrl($aParentPage['tag'], $aParentPage['parentid'], $sUrl);
    }
    else {
      $sUrl = '/'.$sTag.$sUrl.'/';

      return $sUrl;
    }
  }

  public function getTemplates() {
    $all_headers = array(
      "Name" =>  "Name",
      "Description" => "Description",
      "Version" => "Version",
      "Restricted" => "Restricted",
      "Author" => "Author"
    );

    $aData = array();
    $template_dir = $this->settings->root."plugins/content/views/templates/";
    $template_files = scandir($template_dir);
    foreach($template_files as $file) {
      if ($file === "." or $file === "..") continue;

      $fp = fopen($this->settings->root."plugins/content/views/templates/".$file, "r");
      $file_data = fread($fp, 8192);
      fclose($fp);

      foreach($all_headers as $field => $regex) {
        preg_match("/^[ \t\/*#@]*".preg_quote($regex, "/").":(.*)$/mi", $file_data, ${$field});

        if(!empty(${$field}))
        ${$field} = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', ${$field}[1]));
        else
        ${$field} = '';
      }

      $aTemplateInfo = compact(array_keys($all_headers));
      $aTemplateInfo["file"] = $file;

      if($aTemplateInfo["Restricted"] === "false" || $sRestricted) {
        $aData[] = $aTemplateInfo;
      }
    }

    return $aData;
  }

  public function getServiceContent($tag) {
    $tag = str_replace('-', "", $tag);

    $content = array(
      'websitemaintenance' => array(
        'about' => '<p class="intro">Many websites become less effective shortly following their launch date due to lackluster maintenance efforts.</p><p>Why does this happen? Well, it\'s pretty simple. The web changes rapidly and without proper maintenance a young website can struggle to keep up. Not to mention the fact that hackers deliberately seek out older, poorly maintained websites to attack because they\'re more likely to have vulnerabilities in the code that were left untended due to subpar maintenance.</p><p>Fortunately, our maintenance team works tirelessly to ensure that every website we manage experiences as few missteps as possible.</p><p>We monitor your site 24/7, complete any security updates or CMS upgrades, perform monthly health checks, and make any changes you send us through our easy-to-use ticketing system.</p><p>Monkee-Boy offers two levels of website maintenance -- one for clients that just need regular checkups and updates and another for those who also need to maintain their SEO.</p>',
        'benefits_title' => 'Our Maintenance Team Can...',
        'benefits' => '<li>Quickly locate, replicate, and fix bugs.</li><li>Perform regular CMS and security upgrades.</li><li>Protect your website from hacking.</li>',
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become our partner. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'chart' => array(
          'title' => 'Compare Monthly Maintenance Plans',
          'intro' => 'Monkee-Boy offers two maintenance plans. Our basic option includes everything you need to keep your website healthy month after month. The plus maintenance plan adds SEO to the mix -- for businesses that rely more on search.',
          'plan_breakdown' => array(
            'broken_link_checks' => array('name' => 'Broken Link Checks', 'type' => 'boolean'),
            'quality_assurance' => array('name' => 'Quality Assurance', 'type' => 'boolean'),
            'form_testing' => array('name' => 'Form Testing', 'type' => 'boolean'),
            'security_updates' => array('name' => 'Security Updates', 'type' => 'boolean'),
            'uptime_monitoring' => array('name' => 'Uptime Monitoring', 'type' => 'boolean'),
            'regular_backups' => array('name' => 'Regular Back-Ups', 'type' => 'boolean'),
            'analytics_installation' => array('name' => 'Analytics Installation', 'type' => 'boolean'),
            'technical_site_updates' => array('name' => 'Technical Site Updates', 'type' => 'string'),
            'site_speed_analysis' => array('name' => 'Site Speed Analysis', 'type' => 'boolean'),
            'seo_content_checks' => array('name' => 'SEO Content Checks', 'type' => 'boolean'),
            'seo_plugin_maintenance' => array('name' => 'SEO Plugin Maintenance', 'type' => 'boolean'),
            'seo_issues_report' => array('name' => 'SEO Issues Report', 'type' => 'boolean'),
            'seo_competition_report' => array('name' => 'SEO Competition Report', 'type' => 'boolean'),
            'seo_ranking_report' => array('name' => 'SEO Ranking Report', 'type' => 'boolean')
          ),
          'plans' => array(
            array(
              'title' => 'Basic',
              'description' => 'Monthly maintenance to keep your website healthy.',
              'price' => 'XXX',
              'icon' => 'maintenance',
              'cta' => 'Sign Up',
              'cta_url' => '#',
              'features' => array(
                'broken_link_checks' => 1,
                'quality_assurance' => 1,
                'form_testing' => 1,
                'security_updates' => 1,
                'uptime_monitoring' => 1,
                'regular_backups' => 1,
                'analytics_installation' => 1,
                'technical_site_updates' => '2 hours',
                'site_speed_analysis' => 0,
                'seo_content_checks' => 0,
                'seo_plugin_maintenance' => 0,
                'seo_issues_report' => 0,
                'seo_competition_report' => 0,
                'seo_ranking_report' => 0
              )
            ),
            array(
              'title' => 'Plus',
              'description' => 'Monthly maintenance plus SEO to keep your website healthy.',
              'price' => 'XXX',
              'icon' => 'maintenance',
              'cta' => 'Sign Up',
              'cta_url' => '#',
              'features' => array(
                'broken_link_checks' => 1,
                'quality_assurance' => 1,
                'form_testing' => 1,
                'security_updates' => 1,
                'uptime_monitoring' => 1,
                'regular_backups' => 1,
                'analytics_installation' => 1,
                'technical_site_updates' => '5 hours',
                'site_speed_analysis' => 1,
                'seo_content_checks' => 1,
                'seo_plugin_maintenance' => 1,
                'seo_issues_report' => 1,
                'seo_competition_report' => 1,
                'seo_ranking_report' => 1
              )
            )
          )
        ),
        'case_study' => null
      )
    );

    return $content[$tag];
  }
}
