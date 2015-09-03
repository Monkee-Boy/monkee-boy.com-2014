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
        'url' => '',
        'link_title' => ''
      ),
      'chart' => array(),
      'service_plans' => array(),
      'service_plan' => array()
    )
    */

    $content = array(
      'websitemaintenance' => array(
        'about' => '<p class="intro">Many websites become less effective shortly following their launch date due to lackluster maintenance efforts.</p><p>Why does this happen? Well, it\'s pretty simple. The web changes rapidly and without proper maintenance a young website can struggle to keep up. Not to mention the fact that hackers deliberately seek out older, poorly maintained websites to attack because they\'re more likely to have vulnerabilities in the code that were left untended due to subpar maintenance.</p><p>Fortunately, our maintenance team works tirelessly to ensure that every website we manage experiences as few missteps as possible.</p><p>We monitor your site 24/7, complete any security updates or CMS upgrades, perform monthly health checks, and make any changes you send us through our easy-to-use ticketing system.</p><p>Monkee-Boy offers two levels of website maintenance -- one for clients that just need regular checkups and updates and another for those who also need to maintain their SEO.</p>',
        'benefits_title' => 'Our Maintenance Team Can Help…',
        'benefits' => '<li>Quickly locate, replicate, and fix bugs so that your website always operates at a high level.</li><li>Perform regular CMS and security updates.</li><li>Protect your website from hacking.</li>',
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become <a href="/the-work/client-list/">our partner</a>. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'chart' => array(
          'title' => 'Compare Monthly Maintenance Plans',
          'intro' => 'Monkee-Boy offers two maintenance plans. Our Basic option includes everything you need to keep your website healthy month after month. The Plus maintenance plan adds SEO to the mix -- for businesses that rely more on search.',
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
              'cta_url' => '/contact/request-a-quote/?service=website-maintenance&option=basic',
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
              'description' => 'Monthly Maintenance Plus SEO to keep your website healthier.',
              'price' => '780',
              'icon' => 'maintenance',
              'cta' => 'Sign Up',
              'cta_url' => '/contact/request-a-quote/?service=website-maintenance&option=plus',
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
        'cta' => array(),
        'service_plans' => array(),
        'service_plan' => array(),
        'service_features' => array()
      ),

      'contentstrategy' => array(
        'about' => '<p class="intro">Have you ever looked at your website or any other part of your web presence and thought: I know we can do a better job...but how do we start?</p><p>Part art and part science, content strategy answers this question by assessing the current state of your content (aka everything your audience can read, see, or experience online -- from product descriptions to thank you messages).</p><p>Using a comprehensive audit, we measure what you currently say and show to people on the web against the needs of your business, the needs of your audiences, and <a href="/how-we-help/analytics/">analytics data</a>.</p><p>These findings then become the foundation of a measurable blueprint for your web presence that empowers you and your team to leverage content to achieve your business goals, as well as a framework that ensures you always deliver the right message at the right time to your customers -- whether that\'s on your website, in your email communications, or through social media.</p>',
        'benefits_title' => 'Content Strategy Leads The Way Towards...',
        'benefits' => '<li>Increased engagement with your brand on the web.</li><li>Higher return-on-investment from your digital properties and marketing campaigns.</li><li>Improved inter-department collaboration at larger organizations.</li>',
        'cta' => array(
          'content' => 'Ready to Start Working Together?',
          'button' => 'Request a Quote',
          'service' => 'content-strategy'
        ),
        'service_features' => array(
          'title' => 'Content Strategy Includes:',
          'features' => '<li>Audience Research</li><li>Messaging Hierarchy</li><li>Persona Development</li><li>Customer Lifecycle</li><li>Content Audit</li><li>Information Architecture</li><li>Content Page Templates</li><li>Workflow &amp; Style Guidelines</li><li>Measurement Plan</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become <a href="/the-work/client-list/">our partner</a>. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(),
        'chart' => array(),
        'service_plans' => array(),
        'service_plan' => array()
      ),

      'webdesignanddevelopment' => array(
        'about' => '<p class="intro">Think about your website...</p><p>Where do you need visitors to go? What do you need them to do? Do you want them to purchase a product? Share an article? Sign up for an account? Invite their friends? Make a donation?</p><p>Your organization\'s success on the web depends on website visitors reaching these goals.</p><p>Well, it just so happens that our strategy, design, and development team builds great looking, interactive websites that guide visitors toward well-defined goals as they journey through a positive and memorable experience with your brand.</p><p>All of our websites feature:</p><ul><li>Responsive, user-centered designs.</li><li>Custom content management systems (CMS) or WordPress back-ends.</li><li>Content strategy.</li></ul><p>To put it simply, we\'re a no tricks, no gimmicks shop. Just straight up, classy user experience that helps your organization solve the web.</p>',
        'benefits_title' => 'A New Website Will Help You…',
        'benefits' => '<li>Attract more new visitors and make a stronger first impression.</li><li>Guide more visitors toward goals integral to your organization’s success.</li><li>Empower your brand to succeed in an increasingly competitive marketplace.</li>',
        'cta' => array(
          'content' => 'Ready to Start Working Together?',
          'button' => 'Request a Quote',
          'service' => 'web-design-development'
        ),
        'service_features' => array(
          'title' => 'Web Design and Development Includes:',
          'features' => '<li>Audience Research</li><li>Competitor Analysis</li><li>Messaging Hierarchy</li><li>Persona Development</li><li>Content Strategy</li><li>Responsive Website Design</li><li>User Interface Design (UI)</li><li>User Experience Design (UX)</li><li>Wireframes</li><li>Front-End Web Development</li><li>Back-End Web Development</li><li>WordPress Development</li><li>Custom Content Management Systems (CMS)</li><li>Copywriting</li><li>Mobile App Design</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become <a href="/the-work/client-list/">our partner</a>. We\'ll work on your project as a team. We may even eat lunch together.</p>',
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
          'url' => '/the-work/bullock-texas-state-history-museum/',
          'link_text' => 'View Full Project'
        ),
        'chart' => array(),
        'service_plans' => array(),
        'service_plan' => array()
      ),

      'seo' => array(
        'about' => '<p class="intro">We won\'t lie to you: we\'re not the type of company that guarantees a #1 ranking in Google.</p><p>We believe in SEO that improves your ranking and brings higher quality traffic to your site, and we\'d urge you to be skeptical of anyone that says they can do otherwise.</p><p>Our SEO efforts focus on creating a long-term stream of traffic that you can count on well into the future, not tricking Google for a temporary boost.</p><p>Our projects typically involve:</p><ul><li>Research into your business, target audiences, and competitors.</li><li>Identifying technical issues that negatively impact rankings and creating a plan to fix them.</li><li>Strategically optimizing content to attract more qualified visitors to your website.</li></ul><p>Google sets a high standard, but we have the SEO analysts and content experts on our marketing team who understand how to meet them, as well as a variety of service options to meet your needs.</p>',
        'benefits_title' => 'Real SEO Helps You...',
        'benefits' => '<li>Optimize your website to provide more relevant information for searchers, thus improving your ranking in search results.</li><li>Direct higher quality traffic to your site that’s more likely to result in new leads and conversions.</li><li>Identify high-value, high-ROI opportunities to outrank competitors with better content.</li>',
        'cta' => array(),
        'service_features' => array(
          'title' => 'SEO Includes',
          'features' => '<li>Technical Audit</li><li>Competitor Analysis</li><li>SEO Strategy</li><li>Local Search</li><li>Inbound Link Building</li><li>Broken Link Optimization</li><li>SEO Gap Analysis</li><li>Conversion Optimization</li><li>Title Tags</li><li>Meta Descriptions</li><li>Copywriting</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become <a href="/the-work/client-list/">our partner</a>. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(
          'title' => 'DoubleDave\'s Pizzaworks',
          'challenge' => '<li>Make it easier for hungry pizza lovers to find a local DoubleDave’s franchise and place an order online.</li><li>Improve the visibility of franchises in local search results. </li>',
          'solutions' => '<li>Mobile-friendly landing pages for each franchise with proper markup for local search performance.</li><li>Submitted new pages to listing websites to acquire quality inbound links.</li>',
          'results' => array(
            'result' => '637%',
            'description' => '<p>ROI based on an increase in ordering events from 2013 to 2014 and the average price of an order.</p>'
          ),
          'url' => '',
          'link_text' => ''
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
      ),

      'payperclick' => array(
        'about' => '<p class="intro">Anyone can set up a few PPC advertisements in Google Adwords and call it PPC management, but at Monkee-Boy we use extensive customer, market, and keyword research to create campaign strategies that meet your unique goals -- whether those focus on increasing visits, improving conversions, or maximizing your ad budget.</p><p>Then we keep those campaigns under our magnifying glass and make ongoing adjustments to ensure that you get the most out of your PPC advertising.</p><p>PPC is easy when all you try to do is pile on the clicks. Monkee-Boy focuses on finding the right clicks. High-quality leads that cost less to acquire.</p>',
        'benefits_title' => 'Smart PPC Advertising Can Help You…',
        'benefits' => '<li>Generate new leads.</li><li>Lower you cost per new lead.</li><li>Identify new keyword opportunities for your advertising campaigns.</li>',
        'cta' => array(),
        'service_features' => array(
          'title' => 'PPC Advertising Includes:',
          'features' => '<li>PPC Management</li><li>Display Ads</li><li>Google Adwords Management</li><li>PPC Audit</li><li>Retargeting/Remarketing Campaigns</li><li>Bid Optimization</li><li>Conversion Optimization</li><li>Ongoing Reporting</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become <a href="/the-work/client-list/">our partner</a>. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(),
        'chart' => array(),
        'service_plans' => array(
          array(
            'title' => 'PPC Foundation',
            'icon' => 'ppc',
            'content' => '<p>Monthly PPC strategy and management for a Google Adwords campaign. 200 keyword limit. Conversion tracking. Bid optimization.</p><p>Great For: <strong>Small Businesses</strong>, <strong>Startups</strong></p>',
            'button' => 'Learn More',
            'url' => '/how-we-help/pay-per-click/ppc-foundation/'
          ),
          array(
            'title' => 'PPC Advanced',
            'icon' => 'ppc',
            'content' => '<p>PPC strategy and management for Adwords/Bing/Yahoo campaigns with retargeting, display ads, phone call tracking, and standard campaign landing pages.</p><p>Great For: <strong>Small to Mid-Size Businesses</strong>, <strong>Startups</strong>, <strong>Large Companies</strong></p>',
            'button' => 'Learn More',
            'url' => '/how-we-help/pay-per-click/ppc-advanced/'
          )
        ),
        'service_plan' => array(
          'title' => 'PPC Complete',
          'icon' => 'ppc',
          'content' => '<p>PPC strategy and management for multiple campaigns on all networks with unique ad group landing pages, CRM and email marketing integration, and ongoing conversion optimization.</p><p>Great For: <strong>Small to Mid-Size Businesses</strong>, <strong>Startups</strong>, <strong>Large Companies</strong></p>',
          'button' => 'Learn More',
          'url' => '/how-we-help/pay-per-click/ppc-complete/'
        )
      ),

      'socialmedia' => array(
        'about' => '<p class="intro">The best social media marketers aren\'t the ones that get the most likes; they\'re the ones that clearly connect their activity on social media to well-defined business objectives.</p><p>That\'s because a good social media strategy draws a line -- often multiple lines -- between what you post on social media and an action you ultimately want your fans to take.</p><p>Are you selling products? Services? Asking for donations? Promoting a membership program? Your social media strategy and execution must provide a path that subtly encourages fans toward these actions.</p><p>Monkee-Boy\'s digital marketing team has the expertise to create and manage this path. We\'ll treat your social media initiatives as part of an overall marketing strategy, not as silos, resulting in a more targeted plan for how and when to leverage social media.</p>',
        'benefits_title' => 'Good Social Media Marketing Will Help You…',
        'benefits' => '<li>Drive more traffic to your website from social media.</li><li>Convert casual fans to loyal customers.</li><li>Encourage a community of fans to advertise for you by sharing content with their friends and family members.</li>',
        'cta' => array(),
        'service_features' => array(
          'title' => 'Social Media Marketing Includes:',
          'features' => '<li>Social Media Management</li><li>Social Content Audit</li><li>Profile Optimization</li><li>Content Creation</li><li>Facebook Advertising</li><li>Blog Writing</li><li>Ongoing Reporting</li><li>Ongoing Monitoring</li><li>Editorial Calendar</li><li>Copywriting</li><li>Infographics</li><li>Custom Images</li><li>Contests & Sweepstakes</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become <a href="/the-work/client-list/">our partner</a>. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(),
        'chart' => array(),
        'service_plans' => array(
          array(
            'title' => 'Social Media Foundation',
            'icon' => 'socialmedia',
            'content' => '<p>A two-week engagement covering everything you need to get started on social media.</p><p>Great For: <strong>Small Businesses</strong></p>',
            'button' => 'Learn More',
            'url' => '/how-we-help/social-media/social-media-foundation/'
          ),
          array(
            'title' => 'Social Media Consulting',
            'icon' => 'socialmedia',
            'content' => '<p>A full strategy for businesses and organizations ready to build strong communities on social media.</p><p>Great For: <strong>Small to Mid-Size Businesses</strong>, <strong>Startups</strong>, <strong>Large Companies</strong></p>',
            'button' => 'Learn More',
            'url' => '/how-we-help/social-media/social-media-consulting/'
          )
        ),
        'service_plan' => array(
          'title' => 'Social Media Complete',
          'icon' => 'socialmedia',
          'content' => '<p>Full strategy plus social media management and ongoing optimization -- our most comprehensive service.</p><p>Great For: <strong>Small to Mid-Size Businesses</strong>, <strong>Startups</strong>, <strong>Large Companies</strong></p>',
          'button' => 'Learn More',
          'url' => '/how-we-help/social-media/social-media-complete/'
        )
      ),

      'contentmarketing' => array(
        'about' => '<p class="intro">Have you ever wondered why some of your competitors seem to get more attention on the web? Their articles and posts crowd your Facebook news feed. Pages linked to their website routinely show up in search results. They\'re more popular on Twitter.</p><p>This is the result of good content strategy.</p><p>These businesses and organizations have successfully identified content that resonates with their target audiences. They\'ve figured out how to consistently create that content, where and how to deliver it, and what to encourage their fans to do after that first point of contact to turn casual interest into into leads and customers.</p><p>Getting to this point is no simple task. To figure out what to say on the web, you must first take a close look at who you are and who you want to reach.</p><p>Monkee-Boy can lead you through this process.</p>',
        'benefits_title' => 'Great Content Marketing Will Help You…',
        'benefits' => '<li>Improve brand recognition and visibility on the web.</li><li>Increase the quality and quantity of leads your organization receives.</li><li>Boost loyalty amongst existing fans and turn them into ambassadors for your brand.</li>',
        'cta' => array(
          'content' => 'Ready To Start Working Together?',
          'button' => 'Request a Quote',
          'service' => 'content-marketing'
        ),
        'service_features' => array(
          'title' => 'Content Marketing Includes:',
          'features' => '<li>Content Audit</li><li>Competitive Analysis</li><li>Gap Analysis</li><li>Audience Personas</li><li>Brand Story</li><li>Messaging Hierarchy</li><li>Email Marketing</li><li>Copywriting</li><li>Infographics</li><li>Video</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become <a href="/the-work/client-list/">our partner</a>. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(),
        'chart' => array(),
        'service_plans' => array(),
        'service_plan' => array()
      ),

      'analytics' => array(
        'about' => '<p class="intro">At Monkee-Boy, we believe that knowledge drives good decision making. We like to dig into numbers, test ideas, and analyze data before we make big changes to a website.</p><p>If you\'re the same way, then hopefully you already have a robust analytics plan in place to measure the behavior of visitors to your website.</p><p>If not, we can help by creating a custom measurement framework that tracks how well your website accomplishes key business objectives. The wide range of insightful data we can gather will not only empower you and your team to make strategically sound decisions about your website, but also serve as a data-driven guide for your overall business strategy on the web.</p><p>Every second a visitor spends on your website, every button clicked, every form submitted or shopping cart abandoned tells a story about the effectiveness of your site and points to an opportunity for improvement.</p><p>Properly understanding these stories can mean the difference between first place and second in a competitive market.</p>',
        'benefits_title' => 'Smart Website Analytics Can Help You…',
        'benefits' => '<li>Identify new, data-driven business opportunities to pursue on the web.</li><li>Measure the effectiveness of your marketing campaigns.</li><li>Increase conversion rates through optimization.</li>',
        'cta' => array(
          'content' => 'Ready To Start Working Together?',
          'button' => 'Request a Quote',
          'service' => 'content-analytics'
        ),
        'service_features' => array(
          'title' => 'Analytics Includes',
          'features' => '<li>Google Webmaster Tools</li><li>Custom Ongoing Reporting</li><li>Landing Page Development</li><li>Custom Rules and Filters</li><li>Custom Segmentation</li><li>Ecommerce Tracking</li><li>AdWords Conversion Tracking</li>',
        ),
        'being_a_client' => '<p>We don\'t really like the word client. It implies a relationship where you, the client, don\'t get to participate. That\'s not how Monkee-Boy works. This won\'t be one of those sit-back-and-enjoy-the-ride experiences. A typical Monkee-Boy project is full of epiphanies, exclamations, and visions as we collaboratively explore how you can solve the web.</p><p>In short, when you decide to work with Monkee-Boy you become <a href="/the-work/client-list/">our partner</a>. We\'ll work on your project as a team. We may even eat lunch together.</p>',
        'clients' => array(),
        'our_team' => '<p>Monkee-Boy hires thinkers and problem solvers who also happen to be excellent designers, developers, marketers and strategists. Like zombies, we pick people for their brains.</p><p>The reason is simple. We just think our clients deserve the best: a team of ridiculously smart, web-savvy people ready to solve your problems.</p>',
        'case_study' => array(),
        'chart' => array(),
        'service_plans' => array(),
        'service_plan' => array()
      )
    );

    return $content[$tag];
  }

  public function getPlanContent($tag) {
    $tag = str_replace('-', "", $tag);

    /*
    'tag' => array(
      'subnav' => '',
      'features' => array(
        'title' => '',
        'content' => ''
      ),
      'team' => array(
        'content' => '',
        'members' => ''
      ),
      'price' => '',
      'cta' => array(
        'title' => '',
        'content' => '',
        'button' => '',
        'url' => ''
      ),
      'production_schedule' => array(
        'title' => '',
        'content' => ''
      ),
      'other_plans' => array(
        'title' => '',
        'description' => '',
        'plans' => array(
          'title' => '',
          'description' => '',
          'link' => ''
        )
      )
    )
    */

    $content = array(
      'seofoundation' => array(
        'subnav' => 'seo',
        'features' => array(
          'title' => 'SEO Foundation Features',
          'content' => '<li>Technical Audit</li><li>Keyword List</li><li>Top SEO Priorities</li><li>Reporting Set Up</li><li>Available Support</li><li>1-Hour Consultation</li><li>Custom Schedule</li><li>Reminder Notificaitons</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do SEO, we know that search projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes an:</p>',
          'members' => '<li>SEO Analyst</li><li>Digital Marketing Coordinator</li><li>Content Strategist</li><li>Web Developer</li><li>UI/UX Designer</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this plan sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=seo&option=seo-foundation'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for SEO Foundation.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other SEO options:</p>',
          'plans' => array(
            array(
              'title' => 'SEO Consulting',
              'description' => 'For the business that needs SEO strategy, but has an in-house developer to make changes on the website.',
              'link' => '/how-we-help/seo/seo-consulting/'
            ),
            array(
              'title' => 'SEO Complete',
              'description' => 'Monkee-Boy can be your SEO team in shining armor. We develop a full strategy for your website and manage the project.',
              'link' => '/how-we-help/seo/seo-complete/'
            )
          )
        )
      ),

      'seoconsulting' => array(
        'subnav' => 'seo',
        'features' => array(
          'title' => 'SEO Consulting Features',
          'content' => '<li>Technical SEO Audit</li><li>Keyword Research</li><li>Competitive Analysis</li><li>SEO Content Audit</li><li>Gap Analysis</li><li>Copywriting</li><li>Title Tags</li><li>Meta Descriptions</li><li>Ongoing Reporting</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do SEO, we know that search projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes an:</p>',
          'members' => '<li>SEO Analyst</li><li>Digital Marketing Coordinator</li><li>Content Strategist</li><li>Web Developer</li><li>UI/UX Designer</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=seo&option=seo-consulting'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for SEO Full Strategy.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other SEO options:</p>',
          'plans' => array(
            array(
              'title' => 'SEO Foundation',
              'description' => 'Got a limited SEO budget and don\'t know where to start? Our SEO Foundation service is fast and affordable.',
              'link' => '/how-we-help/seo/seo-foundation/'
            ),
            array(
              'title' => 'SEO Complete',
              'description' => 'Monkee-Boy can be your SEO team in shining armor. We develop a full strategy for your website and manage the project.',
              'link' => '/how-we-help/seo/seo-complete/'
            )
          )
        )
      ),

      'seocomplete' => array(
        'subnav' => 'seo',
        'features' => array(
          'title' => 'SEO Complete Features',
          'content' => '<li>Link Building</li><li>Technical Optimization</li><li>Local Search</li><li>Blogging</li><li>Copywriting</li><li>Content Creation</li><li>Content Promotion</li><li>Social Media Enhancements</li><li>Title Tags</li><li>Meta Descriptions</li><li>Technical Audit</li><li>SEO Content Audit</li><li>Gap Analysis</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do SEO, we know that search projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes an:</p>',
          'members' => '<li>SEO Analyst</li><li>Digital Marketing Coordinator</li><li>Content Strategist</li><li>Web Developer</li><li>UI/UX Designer</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=seo&option=seo-complete'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for SEO Complete.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other SEO options:</p>',
          'plans' => array(
            array(
              'title' => 'SEO Foundation',
              'description' => 'Got a limited SEO budget and don\'t know where to start? Our SEO Foundation service is fast and affordable.',
              'link' => '/how-we-help/seo/seo-foundation/'
            ),
            array(
              'title' => 'SEO Consulting',
              'description' => 'For the business that needs SEO strategy, but has an in-house developer to make changes on the website.',
              'link' => '/how-we-help/seo/seo-consulting/'
            )
          )
        )
      ),

      'ppcfoundation' => array(
        'subnav' => 'ppc',
        'features' => array(
          'title' => 'PPC Foundation Features',
          'content' => '<li>Audience Research</li><li>Budget Recommendations</li><li>Campaign Setup</li><li>200 Keywords</li><li>Ad Copywriting</li><li>Copy A/B Tests</li><li>Ad Group Creation</li><li>Bidding Plan</li><li>Measurement Plan</li><li>Conversion Tracking</li><li>Analytics Setup</li><li>Monthly Reporting</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do PPC, we know that pay-per-click advertising projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes an:</p>',
          'members' => '<li>SEO Analyst</li><li>Digital Marketing Coordinator</li><li>Content Strategist</li><li>Copywriter</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=ppc&option=ppc-foundation'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for PPC Foundation.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other PPC options:</p>',
          'plans' => array(
            array(
              'title' => 'PPC Advanced',
              'description' => 'PPC strategy and management for Adwords/Bing/Yahoo campaigns with retargeting, display ads, phone call tracking, and standard campaign landing pages.',
              'link' => '/how-we-help/pay-per-click/ppc-advanced/'
            ),
            array(
              'title' => 'PPC Complete',
              'description' => 'PPC strategy and management for multiple campaigns on all networks with unique ad group landing pages, CRM and email marketing integration, and ongoing conversion optimization.',
              'link' => '/how-we-help/pay-per-click/ppc-complete/'
            )
          )
        )
      ),

      'ppcadvanced' => array(
        'subnav' => 'ppc',
        'features' => array(
          'title' => 'PPC Advanced Features',
          'content' => '<li>Audience Research</li><li>Adwords, Yahoo and Bing</li><li>Budget Recommendations</li><li>Campaign Setup</li><li>Ad Copywriting</li><li>Display Ad Design</li><li>Copy A/B Tests</li><li>Ad Group Creation</li><li>Bidding Plan</li><li>Measurement Plan</li><li>Conversion Tracking</li><li>Call Tracking</li><li>Ad Extensions</li><li>Retargeting</li><li>Analytics Setup</li><li>Monthly Reporting</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do PPC, we know that pay-per-click advertising projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes an:</p>',
          'members' => '<li>SEO Analyst</li><li>Digital Marketing Coordinator</li><li>Content Strategist</li><li>Copywriter</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=ppc&option=ppc-advanced'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for PPC Advanced.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other PPC options:</p>',
          'plans' => array(
            array(
              'title' => 'PPC Foundation',
              'description' => 'Monthly PPC strategy and management for a Google Adwords campaign. 200 keyword limit. Conversion tracking. Bid optimization.',
              'link' => '/how-we-help/pay-per-click/ppc-foundation/'
            ),
            array(
              'title' => 'PPC Complete',
              'description' => 'PPC strategy and management for multiple campaigns on all networks with unique ad group landing pages, CRM and email marketing integration, and ongoing conversion optimization.',
              'link' => '/how-we-help/pay-per-click/ppc-complete/'
            )
          )
        )
      ),

      'ppccomplete' => array(
        'subnav' => 'ppc',
        'features' => array(
          'title' => 'PPC Complete Features',
          'content' => '<li>Audience Research</li><li>Adwords, Yahoo and Bing</li><li>Budget Recommendations</li><li>Campaign Setup</li><li>Ad Copywriting</li><li>Display Ad Design</li><li>Copy A/B Tests</li><li>Landing Page A/B Tests</li><li>Advanced Ecommerce Ads</li><li>Ad Group Creation</li><li>Bidding Plan</li><li>Measurement Plan</li><li>Conversion Tracking</li><li>Call Tracking</li><li>Ad Extensions</li><li>Retargeting</li><li>Analytics Setup</li><li>CRM integration</li><li>Email Marketing Integration</li><li>Monthly Reporting</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do PPC, we know that pay-per-click advertising projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes an:</p>',
          'members' => '<li>SEO Analyst</li><li>Digital Marketing Coordinator</li><li>Content Strategist</li><li>Web Developer</li><li>UI/UX Designer</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=ppc&option=ppc-complete'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for PPC Complete.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other PPC options:</p>',
          'plans' => array(
            array(
              'title' => 'PPC Foundation',
              'description' => 'Monthly PPC strategy and management for a Google Adwords campaign. 200 keyword limit. Conversion tracking. Bid optimization.',
              'link' => '/how-we-help/pay-per-click/ppc-foundation/'
            ),
            array(
              'title' => 'PPC Advanced',
              'description' => 'PPC strategy and management for Adwords/Bing/Yahoo campaigns with retargeting, display ads, phone call tracking, and standard campaign landing pages.',
              'link' => '/how-we-help/pay-per-click/ppc-advanced/'
            )
          )
        )
      ),

      'socialmediafoundation' => array(
        'subnav' => 'socialmedia',
        'features' => array(
          'title' => 'Social Media Foundation Features',
          'content' => '<li>One-Hour Kickoff</li><li>Channel Strategy</li><li>Profile Optimization</li><li>Image Templates</li><li>Influencer Lists</li><li>Voice, Tone &amp; Curation Guide</li><li>Advertisement Plan</li><li>Measurement Plan</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do social media, we know that social projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes a:</p>',
          'members' => '<li>Programs Director</li><li>Content Strategist</li><li>Digital Marketing Coordinator</li><li>SEO Analyst</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=social-media&option=social-media-foundation'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for Social Media Foundation.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other Social Media options:</p>',
          'plans' => array(
            array(
              'title' => 'Social Media Consulting',
              'description' => 'A full strategy for businesses and organizations ready to build strong communities on social media.',
              'link' => '/how-we-help/social-media/social-media-consulting/'
            ),
            array(
              'title' => 'Social Media Complete',
              'description' => 'Full strategy plus social media management and ongoing optimization -- our most comprehensive service.',
              'link' => '/how-we-help/social-media/social-media-complete/'
            )
          )
        )
      ),

      'socialmediaconsulting' => array(
        'subnav' => 'socialmedia',
        'features' => array(
          'title' => 'Social Media Consulting Features',
          'content' => '<li>Consultation Schedule</li><li>Social Channel Analysis</li><li>Profile/Content Audit</li><li>Brand Messaging Audit</li><li>Profile Optimization</li><li>Competitive Analysis</li><li>Voice &amp; Tone Guide</li><li>Advertisement Plan</li><li>Measurement Plan</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do social media, we know that social projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes a:</p>',
          'members' => '<li>Programs Director</li><li>Content Strategist</li><li>Digital Marketing Coordinator</li><li>SEO Analyst</li><li>Web Developer</li><li>UI/UX Designer</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=social-media&option=social-media-consulting'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for Social Media Consulting.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other Social Media options:</p>',
          'plans' => array(
            array(
              'title' => 'Social Media Foundation',
              'description' => 'A two-week engagement covering everything you need to get started on social media.',
              'link' => '/how-we-help/social-media/social-media-foundation/'
            ),
            array(
              'title' => 'Social Media Complete',
              'description' => 'Full strategy plus social media management and ongoing optimization -- our most comprehensive service.',
              'link' => '/how-we-help/social-media/social-media-complete/'
            )
          )
        )
      ),

      'socialmediacomplete' => array(
        'subnav' => 'socialmedia',
        'features' => array(
          'title' => 'Social Media Complete Features',
          'content' => '<li>Kickoff</li><li>Social Content Audit</li><li>Brand Audit</li><li>Competitive Analysis</li><li>Channel Analysis</li><li>Editorial Calendar</li><li>Content Creation</li><li>Contests</li><li>Blogging</li><li>Facebook Advertising</li><li>Management &amp; Monitoring</li><li>Ongoing Reporting</li>'
        ),
        'team' => array(
          'content' => '<p>Monkee-Boy is a full service digital agency. When you work with our team, you get a troop of experts in SEO, social media, PPC, design, development, content, and analytics who love to collaborate. Unlike firms that just do social media, we know that social projects sometimes require a little insight from other departments. At Monkee-Boy, that insight is just a desk away. Your team includes a:</p>',
          'members' => '<li>SEO Analyst</li><li>Programs Director</li><li>Digital Marketing Coordinator</li><li>Content Strategist</li><li>Web Developer</li><li>UI/UX Designer</li>'
        ),
        'price' => '',
        'cta' => array(
          'title' => 'Get In Touch',
          'content' => '<p>Does this sound right to you? Contact us to get started right way. We can\'t wait to get to know your business.</p>',
          'button' => 'Contact Us',
          'url' => '/contact/request-a-quote/?service=social-media&option=social-media-complete'
        ),
        'production_schedule' => array(
          'title' => 'Timeline Delay',
          'content' => '' // <p>Due to high demand, it is currently taking us about one week to respond to requests for Social Media Complete.</p>
        ),
        'other_plans' => array(
          'title' => 'Need <span>Something Different</span>?',
          'description' => '<p>That\'s okay -- check out our other Social Media options:</p>',
          'plans' => array(
            array(
              'title' => 'Social Media Foundation',
              'description' => 'A two-week engagement covering everything you need to get started on social media.',
              'link' => '/how-we-help/social-media/social-media-foundation/'
            ),
            array(
              'title' => 'Social Media Consulting',
              'description' => 'A full strategy for businesses and organizations ready to build strong communities on social media.',
              'link' => '/how-we-help/social-media/social-media-consulting/'
            )
          )
        )
      )
    );

    return $content[$tag];
  }
}
