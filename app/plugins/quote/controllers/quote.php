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
    $this->tplDisplay("thank_you.php");
  }
  function submit_form() {
    $aErrors = array();

    $first_name = trim($_POST['firstname']);
    if(empty($first_name)) {
      $aErrors[] = "Missing first name.";
    }

    $last_name = trim($_POST['lastname']);
    if(empty($last_name)) {
      $aErrors[] = "Missing last name.";
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
        "first_name" => $first_name
        ,"last_name" => $last_name
        ,"email" => $email
        ,"phone" => $phone
        ,"organization" => $_POST['org']
        ,"website" => $_POST['website']
        ,"brief" => $_POST['project-desc']
        ,"attachments" => json_encode($attachments)
        ,"deadline" => ($_POST['deadline'] === '1')?date('Y-m-d', strtotime($_POST['deadline_date'])):null
        ,"budget" => $_POST['budget']
        ,"status" => 1
        ,"ip" => $_SERVER['REMOTE_ADDR']
        ,"created_datetime" => date('Y-m-d H:i:s')
        ,"updated_datetime" => date('Y-m-d H:i:s')
      )
    );

    $_SESSION["quote_form"] = null;
    $this->forward($this->model->ty_content['url']);
  }
  function upload() {
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
