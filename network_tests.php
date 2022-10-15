<?php /* A simple PHP script to help test applications that access web pages. 
         It provides a reliable way to simulate normal page load,
	 500 and 404 errors, redirects, PDF download, and a browser-killing 
	 huge text response.
      */

$q = $_GET['q'];
switch ($q) {
	case '':
		$show_usage = true;
		break;
	case 'ok':
		echo "ok";
		break;
	case '500':
		header("HTTP/1.1 500 Internal Server Error");
		echo 'Internal Server Error';
		break;
	case (preg_match("/wait(\d+)/i", $q, $matches) > 0):
		$t = $matches[1];
		sleep($t);                   
		echo "$t second delay";
		break;
	case 'redirect':
		header('Location: http://www.google.com/');
		break;
	case 'redirect_fail':
		header('Location: http://255.255.255.255/');
		break;
	case '404':
		header("HTTP/1.0 404 Not Found");
		echo '404 Error';
		break;  
	case 'pdf':
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="downloaded.pdf"');
		$content = file_get_contents("http://www.copyright.gov/legislation/dmca.pdf");
		echo $content;
		break;
	case 'superlong':
		$i=1;
		while ($i < 100000){
			echo "<span>test</span> ";
		}
	default:
		echo "? unknown mode.";
		$show_usage = true;
}

?>
<? if ($show_usage){ ?>
<h1>Usage:</h1>
<?= $_SERVER['PHP_SELF'] ?>?q=X, where X can be:
<dl>
	<dt>ok</dt>
	<dd>Status code 200, "ok"</dd>
	<dt>500</dt>
	<dd>Status code 500, Server Error</dd>
	<dt>404</dt>
	<dd>Status code 404, Page not found</dd>
	<dt>redirect</dt>
	<dd>Redirect browser to http://google.com</dd>
	<dt>redirect_fail</dt>
	<dd>Redirect browser to bad network address</dd>
	<dt>wait1, wait2, ... wait 1000 ...</dt>
	<dd>Wait for N seconds before responding</dd>
	<dt>pdf</dt>
	<dd>Downloads a PDF file to browser</dd>
	<dt>superlong</dt>
	<dd>Displays an incredibly long page of text (crashes firefox)</dd>
</dl>
<a href="http://gist.github.com/gists/473681">http://gist.github.com/gists/473681</a>

<? } ?>
