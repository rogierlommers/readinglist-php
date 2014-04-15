<?php
include("config.inc.php");

$con = mysqli_connect ( $mysqlHost, $mysqlUser, $mysqlPassword, $mysqlDatabase );

if (mysqli_connect_errno ()) {
  die ( "Failed to connect to MySQL: " . mysqli_connect_error () );
}

if (! $con->set_charset ( "utf8" )) {
  printf ( "Error loading character set utf8: %s\n", $con->error );
  die ();
}

class Items {
  public $title;
  public $url;

  function __construct($title, $url) {
    $this->title = $title;
    $this->url = $url;
  }
}

function generateXML() {
  global $con;
  global $mysqlTable;
  global $linkToSelf;

  // create simplexml object
  $xml = new SimpleXMLElement('<rss version="2.0"></rss>');

  // add channel information
  $xml->addChild('channel');
  $xml->channel->addChild('title', 'Reading list');
  $xml->channel->addChild('link', $linkToSelf);
  $xml->channel->addChild('description', 'Contains saved urls');
  $xml->channel->addChild('pubDate', date(DATE_RSS));

  // Get items from database
  $result = mysqli_query ( $con, "SELECT id, timestamp, title, url FROM ". $mysqlTable ." ORDER BY id DESC limit 0,50" );

  while ( $row = mysqli_fetch_array ( $result ) ) {
    // create a element
    $inlineDescription = "Link: &lt;a href=\"" . $linkToSelf . "index.php?redirect=" . $row ['id'] . "\"&gt;" . htmlspecialchars ( $row ['url'] ) . "&lt;/a&gt;<br/>";
    $item = $xml->channel->addChild('item');
    $item->addChild('title', $row['title']);
    $item->addChild('description', $inlineDescription);
    $item->addChild('link', $linkToSelf . "/index.php?redirect=" . $row ['id']);
    $item->addChild('pubDate', date(DATE_RSS, strtotime($row['timestamp'])));
    }

  header ("Content-Type:text/xml");
  echo $xml->asXML();

}

function redirect($id) {
  global $con;
  $query = "SELECT url FROM readinglist where id = " . $_GET ['redirect'];
  $result = mysqli_query ( $con, $query );

  if ($result) {
    $row = $result->fetch_assoc ();
    header ( "location:" . $row ['url'] );
  } else {
    echo ("Error fetching row");
  }
  
}

function getHostFromUrl($url) {
  $parse = parse_url($url);
  return $parse['host'];
}

function getTitleFromUrl($url) {
  $tags = get_meta_tags($url);
  if(isset($tags['title'])) {
    return $tags['title'];
  } else {
    return substr($url, 0, 50);
  }
}

function addUrl($url) {
  global $con;
  $query = "INSERT INTO readinglist (title, url, host) VALUES ('".htmlspecialchars(str_replace("'",'',getTitleFromUrl($url)))."', '".$url."','".getHostFromUrl($url)."')";

  if (mysqli_query($con, $query)) {
    ?>
    <html>
      <head>
          <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
          <title>Url added</title>
      </head>
      <body>
          <p style="font-family: verdana">Successfully inserted
          <?php echo mysqli_affected_rows($con); ?>
          row</p>
          <p>Name: <?php echo(htmlspecialchars(str_replace("'",'',$_GET['title']))); ?></p>
      </body>
  </html>
  <?php
  }
  else {
    die("Error occurred: " . mysqli_error($con));
  }

}

// MAIN STARTS HERE ------------------------------------------------------------------------------
if (isSet ( $_GET ['url'] )) {
  // Add new url
  addUrl($_GET ['url']);
} elseif (isSet ( $_GET ['redirect'] )) {
  // redirect to url
  redirect ( $_GET ['redirect'] );
} else {
  // generate XML
  generateXML ();
}

// Close connection to Mysql
mysqli_close ( $con );
?>
