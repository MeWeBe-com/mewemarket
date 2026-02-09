
<?php


function convert_smart_quotes($string) {
    $search = array(chr(0xe2) . chr(0x80) . chr(0x98),
                    chr(0xe2) . chr(0x80) . chr(0x99),
                    chr(0xe2) . chr(0x80) . chr(0x9c),
                    chr(0xe2) . chr(0x80) . chr(0x9d),
                    chr(0xe2) . chr(0x80) . chr(0x93),
                    chr(0xe2) . chr(0x80) . chr(0x94),
                    chr(226) . chr(128) . chr(153),
                    'â€™','â€œ','â€<9d>','â€"','Â  ');

     $replace = array("'","'",'"','"',' - ',' - ',"'","'",'"','"',' - ',' ');

     $str = str_replace($search, $replace, $string);
    
    return remove_accent($str);
}


function get_keyword($referer)
{
    $search_phrase = '';
    $engines = array('dmoz'     => 'q=',
                     'aol'      => 'q=',
                     'ask'      => 'q=',
                     'google'   => 'q=',
                     'bing'     => 'q=',
                     'hotbot'   => 'q=',
                     'teoma'    => 'q=',
                     'yahoo'    => 'p=',
                     'altavista'=> 'p=',
                     'lycos'    => 'query=',
                     'kanoodle' => 'query='
                     );
 
    foreach($engines as $engine => $query_param) {
        // Check if the referer is a search engine from our list.
        // Also check if the query parameter is valid.
        if (strpos($referer, $engine.".") !==  false && 
            strpos($referer, $query_param) !==  false) {
 
            // Grab the keyword from the referer url
            $referer .= "&";
            $pattern = "/[?&]{$query_param}(.*?)&/si";
            preg_match($pattern, $referer, $matches);
            $search_phrase = urldecode($matches[1]);
            return array($engine, $search_phrase);
        }   
    }
    return;
}



function get_data($q,$pg = 1){
	    $sql = "SELECT d.*,k.name as keyword FROM se_data d
		LEFT JOIN se_keywords k
		ON k.`id` = d.`keyword_id`
		WHERE k.`url` = '".slug($q)."'
		
limit 100
		";
	return mysqlFetchRows($sql);
}
 
function related_search_term($input){
	  $url = 'http://suggestqueries.google.com/complete/search?output=toolbar&hl=en&q='.urlencode($input);
	$data = file_get_contents($url);
	$rows = xml2ary($data);
	$relates_terms = $rows['toplevel']['_c']['CompleteSuggestion'];
	foreach($relates_terms as $relates_term){
		$return_rows[] =  $relates_term['_c']['suggestion']['_a']['data'];
	}
	$return_rows[0] = "";
	$return_rows = array_filter($return_rows);
	return $return_rows;
	
	
}
function convert_to_object($rows){
	$i = 0;
	foreach($rows as $row){
		foreach($row as $key=>$val){
			$r[$i]->$key = $val;
		}
		$i++;
	}
	return $r;
}
    function removeCommonWords($input){
     
    // EEEEEEK Stop words
    $commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');
     
    return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
    }
	
	
	
function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}
function get_latest_keywords($limit = 10){
 $sql = "SELECT * FROM se_keywords k order by id desc limit ".$limit;
 return mysqlFetchRows($sql);
}

function get_random_keywords($limit = 10){
 $sql = "SELECT * FROM se_keywords k order by rand() limit ".$limit;
 return mysqlFetchRows($sql);
}

function get_category_name(){
 $sql = "SELECT * FROM  se_category ";
 return mysqlFetchRows($sql);
}
function get_campaign_url($limit = 10){
 $sql = "SELECT * FROM `se_campaign_url` k  limit ".$limit;
 return mysqlFetchRows($sql);
}
function get_last_term(){
 $sql = "SELECT * FROM se_keywords k order by rand() limit 1";
 return mysqlFetchRow($sql);
}
function get_keyword_by_slug($slug){
 $sql = "SELECT * FROM se_keywords where url = '$slug' limit 1";
 $row = mysqlFetchRow($sql);
 return $row['id'];
}
function extract_unit($string, $start, $end)
{
$pos = stripos($string, $start);
$str = substr($string, $pos);
$str_two = substr($str, strlen($start));
$second_pos = stripos($str_two, $end);
$str_three = substr($str_two, 0, $second_pos);
$unit = trim($str_three); // remove whitespaces
return $unit;
}
function slug($text, $trailing = '') {
 		$text = preg_replace('/\%/',' percent',$text); 
		$text = preg_replace('/\@/',' at ',$text); 
		$text = preg_replace('/\&/',' and ',$text); 
		$text = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $text);
		$text = strtolower(trim($text, '-'));
		$text = preg_replace("/[\/_|+ -]+/", '-', $text);
		
	
		// trim and lowercase
		$text = strtolower(trim($text, '-'));
		
		if ( strpos($text, '-') === false && $trailing ) {
		    $text = $text . "-" . $trailing;
		}
		
		return $text;
	}
	
	
function get_keyterms_latest($limit){
	 $sql = "SELECT * from  se_keyterms where status = 1 order by rand() limit $limit";
	return mysqlFetchRows($sql);
}
function update_status_keyterms($id,$value,$domains){
	$update = "update se_keyterms set status = 0 where id =".$id;
	mysqlUpdate($update);
	
	
	$i = 0;
	foreach($domains as $domain){ 
		echo $_POST['q'] = trim($value['keyword'])." ";
		$i++;
		get_data_from_google_multi(trim($value['keyword']),$domain,$i);
		echo "<br />";
	}
}
function update_status_keyterms_single_domain($id,$value,$domains,$searchengine){
	$update = "update se_keyterms set status = 0 where keyword ='".$value['keyword']."'";
	mysqlUpdate($update);
	$i = 0;
//	foreach($domains as $domain){
		echo $_POST['q'] = trim($value['keyword'])." ";
		$i++;
		get_data_from_google_multi(trim($value['keyword']),$domains,$i,$searchengine);
		echo "<br />";
//	}
}
function update_status_keyterms_single_domain_multi($id,$value,$domains,$searchengine){
 	$update = "update se_keyterms set status = 0 where keyword ='".$value['keyword']."'";
	mysqlUpdate($update);
	$i = 0;
//	foreach($domains as $domain){
		echo $_POST['q'] = trim($value['keyword'])." ";
		$i++;
		get_data_from_google_multi(trim($value['keyword']),$domains,$i,$searchengine);
		echo "asd";
		echo "<br />";
//	}
}
function get_data_from_google_multi($q,$domains,$increment,$searchengine){
		
	
	for($kk = 0; $kk<3; $kk++){
			print_r($domains);
	$increment = 0;
	if($kk == 1){
		$search_engine = 'bing';
	}elseif($kk == 2){
		$search_engine = 'yahoo';
	}else{
			$search_engine = 'google';
	}
		foreach($domains as $domain){
			$increment++;
				echo "<br />";
				echo $url = $domain.'/serp.php?engine='.$search_engine.'&page='.$increment.'&phrase='.urlencode($q).'&format=JSON';
				echo "<br />";
				$referrer = 'http://www.yahoo.com';
				$agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
		
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
				curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		
				curl_setopt($ch, CURLOPT_REFERER, $referer);
		
				curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		
				$data = curl_exec($ch);
		
				$rows = json_decode($data);
				add_all_new_data($rows,2);
		}
	}
}
function get_data_from_google($q,$pg = 1){
	global $base;
	if(empty($pg)){ 
		$pg = 1;
	}
	$url = $base.'lib/bin/serp.php?engine=yahoo&page='.$pg.'&phrase='.urlencode($q).'&format=JSON';
    $referrer = 'http://www.yahoo.com';
    $agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    $data = curl_exec($ch);
	
	$rows = json_decode($data);
	
	add_all_new_data($rows,$pg);
	
}
function create_bold_over_keyword($desc,$keyword){
	$key_arr = explode(" ",$keyword);
	foreach($key_arr as $key){
		$desc = str_replace($key,"<strong>".$key."</strong>",strtolower($desc));
	}
	return $desc;
	
}

function remove_accent($str)
{
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
  return str_replace($a, $b, $str);
} 


 
 
function add_all_new_data($rows,$pg){
	$keyword_id = get_keyword_by_slug(slug($_POST['q']));
	if(empty($keyword_id)){
		$insert = "insert into se_keywords (name,url,event_date) values('".mysql_escape_string($_POST['q'])."','".slug($_POST['q'])."',NOW())";
		$keyword_id = mysqlInsert($insert);
	}	
	
	foreach($rows as $val){
				if (strpos($val->url, 'RU=') !== false){
					$domains = explode("RU=",$val->url);
					$domainsv1 = explode("/RK=0",$domains[1]);	
					$url = $domainsv1[0];						
					$domain['host'] = $domainsv1[0];
				}else{
					$url = $val->url;
					$domain['host'] = $url;
				}
		$insert_details = "insert into se_data (title,description,url,keyword_id,pg) values('". mysql_escape_string($val->title)."','".mysql_escape_string($val->description)."','".mysql_escape_string($domain['host'])."','".$keyword_id."','1')";
		mysqlInsert($insert_details);
	}
}

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}




?>