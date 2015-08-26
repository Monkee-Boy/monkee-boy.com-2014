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

    /*
    'tag' => array(
      'about' => '',
      'benefits_title' => '',
      'benefits' => '',
      'cta' => array(
        'content' => '',
        'button' => ''
      ),
      'service_features' => array(
        'title' => '',
        'features' => '<li></li>',
      ),
      'being_a_client' => '',
      'clients' => array(
        array(
          'name' => '',
          'logo' => '',
          'since' => '',
          'url' => ''
        )
      ),
      'our_team' => '',
      'case_study' => array(
        'title' => '',
        'challenge' => '<li></li>',
        'solutions' => '<li></li>',
        'results' => array(
          'result' => '',
          'description' => ''
        ),
        'url' => ''
      ),
      'chart' => array(),
      'service_plans' => array(),
      'service_plan' => array()
    )
    */

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
          'download' => '/uploads/editor/images/mboy-wordpress-plans.pdf',
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
              'price' => '380',
              'icon' => 'maintenance',
              'cta' => 'Sign Up',
              'cta_url' => '/contact/request-a-quote/',
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
              'price' => '780',
              'icon' => 'maintenance',
              'cta' => 'Sign Up',
              'cta_url' => '/contact/request-a-quote/',
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
        'case_study' => null,
        'clients' => array(),
        'cta' => array(
          'content' => 'Ready to Start Working Together?',
          'button' => 'Request a Quote'
        ),
        'service_plans' => array(),
        'service_plan' => array(),
        'service_features' => array()
      ),

      'contentstrategy' => array(
        'about' => '<p class="intro">Have you ever looked at your website or any other part of your web presence and thought: I know we can do a better job...but how do we start?</p><p>Part art and part science, content strategy answers this question by assessing the current state of your content (aka everything your audience can read, see, or experience online -- from product descriptions to thank you messages).</p><p>Using a comprehensive audit, we measure what you currently say and show to people on the web against the needs of your business, the needs of your audiences, and analytics data. (link to analytics page)</p><p>These findings then become the foundation of a measurable blueprint for your web presence that empowers you and your team to leverage content to achieve your business goals, as well as a framework that ensures you always deliver the right message at the right time to your customers -- whether that\'s on your website, in your email communications, or through social media.</p>',
        'benefits_title' => 'Content Strategy Leads the Way Towards...',
        'benefits' => '<li>Increased engagement with your brand.</li><li>Higher ROI on digital investments.</li><li>Improved inter-department collaboration.</li>',
        'cta' => array(
          'content' => 'Ready to Start Working Together?',
          'button' => 'Request a Quote'
        ),
        'service_features' => array(
          'title' => '',
          'features' => '<li>Audience Research</li><li>Messaging Hierarchy</li><li>Persona Development</li><li>Customer Lifecycle</li><li>Content Audit</li><li>Information Architecture</li><li>Content Page Templates</li><li>Workflow &amp; Style Guidelines</li><li>Measurement Plan</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become our partner. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(),
        'chart' => array(),
        'service_plans' => array(),
        'service_plan' => array()
      ),

      'webdesignanddevelopment' => array(
        'about' => '<p class="intro">Think about your website...</p><p>Where do you need visitors to go? What do you need them to do? Do you want them to purchase a product? Share an article? Sign up for an account? Invite their friends? Make a donation?</p><p>Your organization\'s success on the web depends on website visitors reaching these goals.</p><p>Well, it just so happens that our strategy, design, and development team builds great looking, interactive websites that guide visitors toward well-defined goals as they journey through a positive and memorable experience with your brand.</p><p>All of our websites feature:</p><ul><li>Responsive, user-centered designs.</li><li>Custom content management systems (CMS) or Wordpress back-ends.</li><li>Content strategy.</li></ul><p>To put it simply, we\'re a no tricks, no gimmicks shop. Just straight up, classy user experience that helps your organization solve the web.</p>',
        'benefits_title' => 'A New Website Will...',
        'benefits' => '<li>Attract more new visitors.</li><li>Guide more visitors towards goals integral to your success.</li><li>Empower your brand in a competitive marketplace.</li>',
        'cta' => array(
          'content' => 'Ready to Start Working Together?',
          'button' => 'Request a Quote'
        ),
        'service_features' => array(
          'title' => '',
          'features' => '<li>Audience Research</li><li>Competitor Analysis</li><li>Messaging Hierarchy</li><li>Persona Development</li><li>Content Strategy</li><li>Responsive Website Design</li><li>User Interface Design (UI)</li><li>User Experience Design (UX)</li><li>Wireframes</li><li>Front-End Web Development</li><li>Back-End Web Development</li><li>Wordpress Development</li><li>Custom Content Management Systems (CMS)</li><li>Copywriting</li><li>Mobile App Design</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become our partner. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(
          'title' => 'Bullock Texas State History Museum',
          'challenge' => '<li>Translate the rich, educational opportunities available to visitors at the physical museum into interactive and engaging digital experiences on the web.</li><li>Attract visitors from every corner of the state to the website.</li>',
          'solutions' => '<li>Interactive homes for the museum\'s artifacts and exhibits that encourage sharing on social media.</li><li>A user-generated story project that invites Texans far and wide to add to The Story of Texas by submitting personal, historically-relevant stories.</li>',
          'results' => array(
            'result' => '168%',
            'description' => '<p>Increase in visits to website from outside the Austin metro area over ten months following launch.</p>'
          ),
          'url' => ''
        ),
        'chart' => array(),
        'service_plans' => array(),
        'service_plan' => array()
      ),

      'seo' => array(
        'about' => '<p class="intro">We won\'t lie to you: we\'re not the type of company that guarantees a #1 ranking in Google.</p><p>We believe in SEO that improves your ranking and brings higher quality traffic to your site, and we\'d urge you to be skeptical of anyone that says they can do otherwise.</p><p>Our SEO efforts focus on creating a long-term stream of traffic that you can count on well into the future, not tricking Google for a temporary boost.</p><p>Our projects typically involve:</p><ul><li>Research into your business, target audiences, and competitors.</li><li>Identifying technical issues that negatively impact rankings and creating a plan to fix them.</li><li>Strategically optimizing content to attract more qualified visitors to your website.</li></ul><p>Google sets a high standard, but we have the SEO analysts and content experts on our marketing team who understand how to meet them, as well as a variety of service options to meet your needs.</p>',
        'benefits_title' => 'Real SEO Helps You...',
        'benefits' => '<li>Optimize your website to provide more relevant information for searchers.</li><li>Direct higher quality traffic to your site.</li><li>Identify high-value, high ROI opportunities to outrank competitors.</li>',
        'cta' => array(),
        'service_features' => array(
          'title' => '',
          'features' => '<li>Technical Audit</li><li>Competitor Analysis</li><li>SEO Strategy</li><li>Local Search</li><li>Inbound Link Building</li><li>Broken Link Optimization</li><li>SEO Gap Analysis</li><li>Conversion Optimization</li><li>Title Tags</li><li>Meta Descriptions</li><li>Copywriting</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become our partner. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(
          'title' => 'DoubleDave\'s',
          'challenge' => '<li>Make it easier for hungry pizza lovers to find a local DoubleDave’s franchise and place an order online.</li><li>Improve the visibility of franchises in local search results. </li>',
          'solutions' => '<li>Mobile-friendly landing pages for each franchise with proper markup for local search performance.</li><li>Submitted new pages to listing websites to acquire quality inbound links.</li>',
          'results' => array(
            'result' => '637%',
            'description' => '<p>ROI based on an increase in ordering events from 2013 to 2014 and the average price of an order.</p>'
          ),
          'url' => ''
        ),
        'chart' => array(),
        'service_plans' => array(
          array(
            'title' => 'SEO Foundation',
            'icon' => 'seo',
            'content' => '<p>Got a limited SEO budget and don\'t know where to start? Our SEO Foundation service is fast and affordable.</p><p>Great For: <strong>Small to Mid-Size Businesses</strong>, <strong>Startups</strong></p>',
            'button' => 'Learn More',
            'url' => '/how-we-help/seo/seo-foundation/'
          ),
          array(
            'title' => 'SEO Consulting',
            'icon' => 'seo',
            'content' => '<p>For the business that needs SEO strategy, but has an in-house developer to make changes on the website.</p><p>Great For: <strong>Small to Mid-Size Businesses</strong>, <strong>Startups</strong>, <strong>Large Companies</strong></p>',
            'button' => 'Learn More',
            'url' => '/how-we-help/seo/seo-consulting/'
          )
        ),
        'service_plan' => array(
          'title' => 'SEO Complete',
          'icon' => 'seo',
          'content' => '<p>Monkee-Boy can be your SEO team in shining armor. We develop a full strategy for your website and manage the project.</p><p>Great For: <strong>Small to Mid-Size Businesses</strong>, <strong>Startups</strong>, <strong>Large Companies</strong></p>',
          'button' => 'Learn More',
          'url' => '/how-we-help/seo/seo-complete/'
        )
      )
    );

    return $content[$tag];
  }
}
