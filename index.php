<?php

// Load config...
require_once('config.php');

// Symfony's routing requires...
$sfpath = './sf/';
require_once($sfpath.'routing/sfRoute.class.php');
require_once($sfpath.'routing/sfRouting.class.php');
require_once($sfpath.'routing/sfPatternRouting.class.php');
require_once($sfpath.'event_dispatcher/sfEvent.php');
require_once($sfpath.'event_dispatcher/sfEventDispatcher.php');

// Routing config... 
$routing = new sfPatternRouting(new sfEventDispatcher());

$routing->connect('new', new sfRoute('/new', array(
  'module' => 'visual',
  'action' => 'new'
)));

$routing->connect('editversion', new sfRoute('/edit/:slug/:version', array(
  'module' => 'visual',
  'action' => 'edit',
  'slug' => ':slug',
  'version' => ':version'
)));

$routing->connect('edit', new sfRoute('/edit/:slug', array(
  'module' => 'visual',
  'action' => 'edit',
  'slug' => ':slug'
)));

$routing->connect('save', new sfRoute('/save/:slug', array(
  'module' => 'visual',
  'action' => 'save',
  'slug' => ':slug'
)));

$routing->connect('home', new sfRoute('/:module', array(
  'module' => 'visual',
  'action' => 'home'
)));

$req_uri = str_replace("/index.php", "", $_SERVER["REQUEST_URI"]);
$ret = $routing->parse($req_uri);

// Dump header...
require_once('header.php');

// Dispatching...
$dblink = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) or die("\n\nError: unable to connect to database :(\n\n");

switch($ret['action']) {
  case 'new':
    $query = "INSERT INTO experiment (json) VALUES ('')";
    if ($experiment_result = mysqli_query($dblink, $query) or die("\n\nError: unable to create experiment :(\n\n")) {
      $experiment_id = mysqli_insert_id($dblink);
      // Generate slug...
      $experiment_slug = str_replace($salt, "", crypt($secret."-".$experiment_id, $salt));
      $experiment_slug = str_replace("$", "", $experiment_slug);
      $experiment_slug = str_replace("/", "", $experiment_slug);
      $experiment_slug = str_replace(".", "", $experiment_slug);
      $experiment_slug = strtolower($experiment_slug);
      $experiment_slug = substr($experiment_slug, 0, 6);
      $experiment_desc = $experiment_id;
      $experiment_json = '{ id: "'.$experiment_slug.'", description: "", verbose: "true", parameters: { videomode: {} }, items: [] }';
      $query = "UPDATE experiment SET slug='".$experiment_slug."', json='".$experiment_json."' WHERE id=".$experiment_id;
      $experiment_result = mysqli_query($dblink, $query);
      // Redirect to the editor...
      header("Location: /edit/".$experiment_slug);
      die();
    }
    break;
  case 'edit':
    $query = "SELECT * FROM experiment WHERE slug = '".$ret['slug']."' ORDER BY version DESC LIMIT 1";
    if ($experiment_result = mysqli_query($dblink, $query)) {
      if($experiment_row = mysqli_fetch_row($experiment_result)) {
        $experiment_latest_version = $experiment_row[3];
        if (is_numeric($ret['version'])) {
          $query = "SELECT * FROM experiment WHERE slug = '".$ret['slug']."' AND version = ".$ret['version'];
          if ($experiment_result = mysqli_query($dblink, $query)) {
            if($experiment_row = mysqli_fetch_row($experiment_result)) {
              $experiment_id = $experiment_row[0];
              $experiment_slug = $experiment_row[1];
              $experiment_json = $experiment_row[2];
            }
          }
        } else {
          $experiment_id = $experiment_row[0];
          $experiment_slug = $experiment_row[1];
          $experiment_json = $experiment_row[2];
        }

        // Dump editor...
        require_once('editor.php');

        // Dump initialData...
        $trans = array("\n" => "\\n", "\r" => "\\r");
?>
<script>
var initialData = <?php echo strtr($experiment_json, $trans); ?>;
initialData.version = <?php echo $experiment_latest_version; ?>;
</script>
<?php
        // End of initialData dump.
      } else {
        // Project not found :(
        require_once('notfound.php');
      }         
    }
    break;
  case 'save':
    if (isset($_POST['json'])) {
      $json = str_replace("'", "", $_POST['json']); 
      $json = utf8_encode($json); 
      $jsonDecode = json_decode($json);
      if (json_last_error() === JSON_ERROR_NONE) {
        // Nice, it is valid JSON
        $query = "SELECT * FROM experiment WHERE slug = '".$ret['slug']."' ORDER BY version DESC LIMIT 1";
        if ($experiment_result = mysqli_query($dblink, $query)) {
          if($experiment_row = mysqli_fetch_row($experiment_result)) {
            $experiment_version = $experiment_row[3];
            $experiment_version += 1;
            $query = "INSERT INTO experiment (slug, json, version) VALUES ('".$ret['slug']."', '".$json."', ".$experiment_version.")";
            if ($experiment_result = mysqli_query($dblink, $query) or die("\n\nError: unable to save experiment :(\n\n".$query)) {
              // Saved :)
              require_once('saved.php');
              // Dump footer...
              require_once('footer.php');
            } else {
              // INSERT went wrong
              header("Location: /");
            }
          } else {
            // slug not found
            header("Location: /");
          }
        }
      } else {
        // It is not JSON
        header("Location: /");
      } 
    } else { // No POST
      // Redirect to the homepage...
      header("Location: /");
    }
    die(); // Just in case...
    break;  
  default: //case 'home':
    // Dump homepage...
    require_once('home.php');
    break;
}

mysqli_close($dblink);

// Dump footer...
require_once('footer.php');
?>
