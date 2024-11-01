<?php
/*
Plugin Name: WPis - Wordpress á Íslensku
Plugin URI: http://www.axelrafn.org/
Description: Þetta er lítil viðbót sem tryggir að þú sért með nýjustu útgáfuna af íslenskri þýðingu fyrir Wordpress. Sem stendur virkar hún bara á Linux/Unix þjónum með cURL uppsett.
Version: 1.0.5
Author: Axel Rafn
Author URI: http://www.axelrafn.org/
*/

add_action('admin_menu', 'wpis_display_menu');

// er þetta dev útgáfa ?
$dev=0; // 0=nei; 1=já

// nokkur stillingar atriði fyrst.
$wpis['url']='http://www.axelrafn.org'; // hvar er síðan til að athuga með viðbótina og þýðinguna ?
$wpis['path']=$_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/wpis'; // hvar er þessi viðbót staðsett ?
$wpis['mopath']=$_SERVER['DOCUMENT_ROOT'].'/wp-includes/languages'; // hvar eru mo skjölin geymd fyrir Wordpress
$wpis['tmp']=sys_get_temp_dir(); // hvaða bráðabirgðar skráarmöppu er verið að nota
$wpis['selfv']='1.0.5'; // hvaða útgáfa er þetta ?
$wpis['v']=wpis_check_current();
$wpis['news']=wpis_check_news();
if($dev>0){
	$wpis['dev']='/dev';
}else{
	$wpis['dev']='';
}

function wpis_css(){
	echo "
	<style type='text/css'>
	#wpiscol li{
		margin-left: 15px;
		font-style: italic;
	}
	#wpiscol ul,ol{
		margin-bottom: 15px;
	}
	.wpbutton {
		width: 150px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		float: left;
		border: 1px #999 solid;
		padding: 7px;
		text-align: center;
		margin-right: 10px;	
	}
	.button a:href{
		text-decoration:none;
	}
	.button a:link{
		text-decoration:none;
	}

	.button a:visited{
		text-decoration:none;
	}
	.button a:active{
		text-decoration:none;
	}
	#wpiscol{
		width: 450px;
		margin-right: 25px;
		float: left;
	}
	.wpisgreen{
		color: #60AB10;
		font-weight: bold;
	}
	.wpisred{
		color: #D6010E;
		font-weight: bold;
	}
	.wpishr{
		margin: 0;
		border: 0;
		border-bottom: 1px dashed #fff;
		border-top:1px dashed #999;
		width: 200px;
		margin-bottom: 45px;
	}
	.wpish3{
		margin:0;
		font-size: 1.2em;
		font-weight: bold;
	}
	.wpish4{
		font-size: 0.75em;
		font-style: italic;
		margin:0;
		border-bottom: 1px solid #999;
	}
	.info, .success, .warning, .error, .validation {
		border: 1px solid;
		margin: 10px 0px;
		padding:15px 10px 15px 50px;
		background-repeat: no-repeat;
		background-position: 10px center;
	}
	.info {
		color: #00529B;
		background-color: #BDE5F8;
		background-image: url('info.png');
	}
	.success {
		color: #4F8A10;
		background-color: #DFF2BF;
		background-image:url('success.png');
	}
	.warning {
		color: #9F6000;
		background-color: #FEEFB3;
		background-image: url('warning.png');
	}
	.error {
		color: #D8000C;
		background-color: #FFBABA;
		background-image: url('error.png');
	}
	.boombox{
		display:none;
	}
	</style>
	";
}
add_action('admin_head', 'wpis_css');

function wpis_check_current(){
	global $wpis;
	$skrain = $wpis['path'].'/curr-version.txt';
	$handle=fopen($skrain, 'r');
	$gildi=fread($handle, filesize($skrain));
	fclose($handle);
	$gildi=substr($gildi, 0, -4);
	return $gildi;
}

function wpis_check_news(){
	global $wpis;
	$skrain = $wpis['path'].'/news.txt';
	$handle=fopen($skrain, 'r');
	$gildi=fread($handle, filesize($skrain));
	fclose($handle);
	$gildi=substr($gildi, 0, -4);
	return $gildi;
}

function wpis_check_latest(){
	global $wpis;
	$url=$wpis['url'].'/wpis/version.txt';
	$ch = curl_init($url);
	$skra=$wpis['tmp'].'/wpis-version.txt';
	$fp = fopen($skra, 'w');

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	
	if(!rename($wpis['tmp'].'/wpis-version.txt', $wpis['path'].'/new-version.txt')){
		$gildi='Villa. Gat ekki afritað!';
	}else{
		$skrain=$wpis['path'] . '/new-version.txt';
		$gildi=file_get_contents($skrain);
		$gildi=substr($gildi, 0, -4);
	}
	
	return $gildi;
}

function wpis_check_latest_news(){
	global $wpis;
	$url=$wpis['url'].'/wpis'.$wpis['dev'].'/news.txt';
	$ch = curl_init($url);
	$skra=$wpis['tmp'].'/news.txt';
	$fp = fopen($skra, 'w');

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	
	if(!rename($wpis['tmp'].'/news.txt', $wpis['path'].'/news.txt')){
		$gildi='Villa. Gat ekki afritað!';
	}else{
		$skrain=$wpis['path'] . '/news.txt';
		$gildi=file_get_contents($skrain);
		$gildi=substr($gildi, 0, -4);
	}
	
	return $gildi;
}

function check_curl(){
	if(in_array('curl', get_loaded_extensions())){
		return true;
	}else{
		return false;
	}
}

function wpis_display_menu() {
	global $wpis;
	$titill="WPis ".$wpis['selfv'];
	add_options_page($titill, 'WPis', 'manage_options', 'wpis', 'wpis_options');
}

function wpis_check($gildi){
	global $wpis;
	switch($gildi){
		default:
			$return=false;
			break;
		case "curl":
			if(in_array('curl', get_loaded_extensions())){
				$return=true;
			}else{
				$return=false;
			}
			break;
		
		case "v":
			$return=wpis_check_current();
			break;
		
	}
}

function wpis_fetch_newer(){
	global $wpis;
	if(wpis_check_current()==wpis_check_latest()){
		$out='Þú ert með nýjastu þýðinguna!';	
	}else{
		if(!file_exists($wpis['mopath'])){
			mkdir($wpis['mopath'], 0755);
		}

		$url= $wpis['url'].'/wpis/latest';
		$ch = curl_init($url);
		$skra=$wpis['tmp'].'/wpis-is_IS.mo';
		$fp = fopen($skra, 'w');

		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);

		if(!rename($wpis['tmp'].'/wpis-is_IS.mo', $wpis['mopath'].'/is_IS.mo')){
			$out='Villa. Gat ekki afritað .mo á vefsvæði!';
		}else{
			if(!rename($wpis['path'].'/new-version.txt', $wpis['path'].'/curr-version.txt')){
				$out='Villa. Gat ekki afritað útg. á vefsvæði!';
			}else{
				$out ='Uppfærslu þýðingar lokið!'; 
			}
		}
	}
	return $out;
}
function wpis_greenred() {
	global $wpis;
	global $dev;
	if(wpis_check_current()!=wpis_check_latest()){
		echo '<span class="wpisred">'.wpis_check_latest().'</span>';
	}else{
		echo '<span class="wpisgreen">'.wpis_check_latest().'</span>';
	}
}
function wpis_options() {
	global $wpis;
	global $dev;
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>
<div class="wrap">  
	<?php
	if(isset($_GET['update'])){
		switch($_GET['update']){
			case 'news':
				wpis_check_latest_news();
				break;
				
			case 'trans':
				wpis_fetch_newer();
				break;
		}
	}
	if(check_curl()==false){
		echo '<div class="error">Villa!<br />Þú ert því miður er cURL ekki uppsett á þennan vefþjón og því getur þú ekki notað þessa viðbót sem stendur.</div>';
	}
	?>
	<div id="wpiscol">
	<h2>WPis - WordPress á íslensku</h2>
    <h3>Kynning</h3>
    <p>Þakka þér fyrir að nota WPis viðbótina.<br />
    Þessi viðbót var forrituð af <a href="http://www.axelrafn.org" target="_blank" title="Heimasíða höfundar">Axel Rafn</a> sem viðbót fyrir íslenska þýðingahópin sem hann stofnaði og viðheldur.</p>
    <p>Þýðingarhópurinn saman stendur af fjórum aðilum:<br />
    <br />
    &raquo; Axel Rafn<br />
    &raquo; Helgi Hrafn<br />
    &raquo; Kristín Ásta<br />
    &raquo; Victor Jónsson<br />
    </p>
    
    <h3>Tilgangur</h3>
    <p>Tilgangur þessarar viðbótar er að einfalda notkun og virkni þeirrar þýðingar sem við erum að vinna að.<br />
    Með því að vera með þessa viðbót inni getur þú uppfært þýðinguna þegar ný kemur, með því að smella á einn hnapp hér að neðan.</p>

    <h3>Möguleikar</h3>
    <p>Hér eru í boði tveir valmöguleikar sem stendur, vinsamlegast smelltu á viðeigandi hnapp.</p>
    <p>Af gefnu tilefni er bent á að viðbótin athugar ekki sjálfkrafa með nýjar fréttir. Þetta er gert til að minnka álagið og hleðslutíma síðunnar. Það er fátt jafn pirrandi og að bakendi einhvers vefkerfis sé svo hægur að það er vart hægt að nota hann.</p>
    <p><br />
	<a href="?page=wpis&update=news" class="button wpbutton">uppfæra fréttir</a>
    <a href="?page=wpis&update=trans" class="button wpbutton">uppfæra þýðingu</a>
    <div style="clear:both;"></div>
    </p>
    <h3>Upplýsingar</h3>
    <p>Þú ert að nota <?php if($dev>0){ echo "<em><strong>þróunarútgáfu</strong></em>"; }else{ echo "útgáfu";} ?> <?=$wpis['selfv']?> af <em>WPis</em>.<br />
    Nýjasta útgáfa þýðingar: <?php echo wpis_greenred(); ?></p>
    <p>
    <?php
    	if(wpis_check_current()!=wpis_check_latest()){
    		echo 'Mælt er með að þú uppfærir þýðinguna þína með að smella á hnappinn hér að ofan.';
    	}
    ?>
    </p>
    </div>
    <div id="wpiscol">
    <h2>Fréttir</h2>
    <?=wpis_check_news()?>
	</div>
</div>  
<?php
}
?>
