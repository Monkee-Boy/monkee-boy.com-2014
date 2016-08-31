<?php
class quote extends appController {
  function __construct() {
    // Load model when creating appController
    parent::__construct("quote");

    $this->tplAssign('aContent', $this->model->content);
    $this->tplAssign('aTYContent', $this->model->ty_content);
  }

  function index() {
    if(empty($_SESSION["quote_form"])) {
      $form_data = array();
    } else {
      $form_data = $_SESSION["quote_form"];
    }

    $this->tplAssign('form_data', $form_data);
    $this->tplAssign('aContent', $this->model->content);
    $this->tplDisplay("request_quote.php");
  }

  function thank_you() {
    $this->tplAssign('aContent', $this->model->ty_content);
    $this->tplDisplay("thank_you.php");
  }

  function submit_form() {
    $aErrors = array();

    $name = trim($_POST['name']);
    if(empty($name)) {
      $aErrors[] = "Missing name.";
    }

    $email = trim($_POST['email']);
    if(empty($email)) {
      $aErrors[] = "Missing email address.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $aErrors[] = "Email address is not valid.";
    }

    $phone = trim($_POST['phone']);
    if(empty($phone)) {
      $aErrors[] = "Missing phone number.";
    }

    $org = trim($_POST['org']);
    if(empty($org)) {
      $aErrors[] = "Missing organization.";
    }

    $website = trim($_POST['website']);
    if(empty($website)) {
      $aErrors[] = "Missing website.";
    }

    $additional_info = trim($_POST['additional_info']);
    if(empty($additional_info)) {
      $aErrors[] = "Missing what kind of help you are looking for.";
    }

    $budget = trim($_POST['budget']);
    if(empty($budget)) {
      $aErrors[] = "Missing budget.";
    }

    if(!empty($aErrors)) {
      $_SESSION["quote_form"] = $_POST;
      $this->forward($this->model->content['url']);
      die;
    }

    $attachments = array();
    if(!empty($_POST['attachments_name'])) {
      foreach($_POST['attachments_name'] as $i=>$name) {
        $attachments[$name] = $_POST['attachments_realname'][$i];
      }
    }

    $sID = $this->dbInsert(
      "work_with_us",
      array(
        "name" => $name
        ,"email" => $email
        ,"phone" => $phone
        ,"organization" => $_POST['org']
        ,"website" => $_POST['website']
        ,"budget" => $_POST['budget']
        ,"attachments" => json_encode($attachments)
        ,"additional_info" => $_POST['additional-info']
        ,"status" => 1
        ,"ip" => $_SERVER['REMOTE_ADDR']
        ,"created_datetime" => date('Y-m-d H:i:s')
        ,"updated_datetime" => date('Y-m-d H:i:s')
      )
    );

    $sTo = "quotes@monkee-boy.com";
    $sFrom = "noreply@monkee-boy.com";
    $sSubject = "Request a Quote: ".$_POST['org'];

    $sBody = "Name: ".htmlentities($name)."\n";
    $sBody .= "Email: ".htmlentities($email)."\n";
    $sBody .= "Phone: ".htmlentities($phone)."\n";
    $sBody .= "Organization: ".htmlentities($_POST['org'])."\n";
    $sBody .= "Website: ".htmlentities($_POST['website'])."\n";
    if(!empty($_POST['additional-info'])) {
      $sBody .= "\nAdditional Info: \n";
      $sBody .= htmlentities($_POST['additional-info'])."\n\n";
    }
    if(!empty($attachments)) {
      $sBody .= "Attachments: \n";
      foreach($attachments as $name=>$attachment) {
        $sBody .= "- https://www.monkee-boy.com/uploads/quote/".$attachment." (".$name.")\n";
      }
    }
    $sBody .= "Budget: ".htmlentities($_POST['budget'])."\n";

    $sHeaders = "From: ".$sFrom."\r\n"
      ."Reply-To: ".$email;

    mail($sTo, $sSubject, $sBody, $sHeaders);

    require_once($this->settings->root.'helpers/Podio/PodioAPI.php');

    Podio::setup($this->getSetting('podio_client_id'), $this->getSetting('podio_client_token'));

    try {
      Podio::authenticate_with_app($this->getSetting('podio_app_id'), $this->getSetting('podio_app_token'));

      $contact = PodioContact::create('3372170', $attributes = array(
        'name' => htmlentities($name),
        'organization' => (!empty($_POST['org']))?$_POST['org']:'Not provided.',
        'phone' => array(htmlentities($phone)),
        'mail' => array(htmlentities($email)),
        'url' => array((!empty($_POST['website']))?$_POST['website']:'')
      ));

      $file_ids = array();
      if(!empty($attachments)) {
        foreach($attachments as $name=>$attachment) {
          $file = PodioFile::upload($this->_settings->rootPublic.'uploads/quote/'.$attachment, $attachment);
          $file_ids[] = $file->id;
        }
      }

      $item = PodioItem::create(
        $this->getSetting('podio_app_id'),
        array(
          'fields' => array(
            'what-is-the-main-service-that-you-need' => (!empty($_POST['main-service']))?$_POST['main-service']:'Not provided.',
            'which-web-maintenance-package-is-right-for-you-2' => (!empty($_POST['main-serviceoption']))?$_POST['main-serviceoption']:'Not provided.',
            'do-you-have-a-request-for-proposal-rfp-2' => (!empty($_POST['project-desc']))?$_POST['project-desc']:'Not provided.',
            'have-a-project-deadline-2' => (!empty($_POST['deadline_date']))?$_POST['deadline_date']:'Not provided.',
            'desired-project-date-2' => (!empty($_POST['deadline_date']))?$_POST['deadline_date']:'Not provided.',
            'have-a-project-budget-2' => (!empty($_POST['budget']))?$_POST['budget']:'Not provided.',
            'notes' => (!empty($_POST['additional-services']))?$_POST['additional-services']:'Not provided.',
            'anything-else-we-should-know' => (!empty($_POST['additional-info']))?$_POST['additional-info']:'Not provided.',
            'contacts-at-company' => $contact
          )
        )
      );

      if(!empty($file_ids)) {
        PodioItem::update($item->id, array('file_ids' => $file_ids));
      }
    }
    catch (PodioError $e) {
      // Something went wrong. Examine $e->body['error_description'] for a description of the error.
      //echo '<pre>'; print_r($e); echo '</pre>'; die();
    }

    $_SESSION["quote_form"] = null;
    $this->forward($this->model->ty_content['url']);
  }
  function upload() {
    $accepted_extensions = array('pdf', 'doc', 'docx');

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    @set_time_limit(5 * 60);

    $targetDir = $this->_settings->rootPublic."uploads/quote/";
    $cleanupTargetDir = true; // Remove old files
    $maxFileAge = 5 * 3600; // Temp file age in seconds


    // Create target dir
    if (!file_exists($targetDir)) {
      @mkdir($targetDir);
    }

    // Get a file name
    if (isset($_REQUEST["name"])) {
      $fileName = $_REQUEST["name"];
      $extension = pathinfo($fileName)['extension'];
    } elseif (!empty($_FILES)) {
      $fileName = $_FILES["file"]["name"];
      $extension = pathinfo($fileName)['extension'];
    } else {
      $extension = 'na';
    }

    if(!in_array($extension, $accepted_extensions)) {
      die('{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "File type not accepted."}, "id" : "id"}');
    }

    $fileName = uniqid('', true).'.'.$extension;

    $filePath = $targetDir.$fileName;

    // Chunking might be enabled
    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


    // Remove old temp files
    if ($cleanupTargetDir) {
      if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
      }

      while (($file = readdir($dir)) !== false) {
        $tmpfilePath = $targetDir.$file;

        // If temp file is current file proceed to the next
        if ($tmpfilePath == "{$filePath}.part") {
          continue;
        }

        // Remove temp file if it is older than the max age and is not the current file
        if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
          @unlink($tmpfilePath);
        }
      }
      closedir($dir);
    }


    // Open temp file
    if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
      die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    }

    if (!empty($_FILES)) {
      if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
      }

      // Read binary input stream and append it to temp file
      if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
      }
    } else {
      if (!$in = @fopen("php://input", "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
      }
    }

    while ($buff = fread($in, 4096)) {
      fwrite($out, $buff);
    }

    @fclose($out);
    @fclose($in);

    // Check if file has been uploaded
    if (!$chunks || $chunk == $chunks - 1) {
      // Strip the temp .part suffix off
      rename("{$filePath}.part", $filePath);
    }

    // Return Success JSON-RPC response
    die('{"jsonrpc" : "2.0", "result" : {"server_filename": "'.$fileName.'"}, "id" : "id"}');

  }
}
