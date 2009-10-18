<?php
//header('Content-Type: text/plain;charset');
class Mail {
private $to = array();
private $bcc = array();
private $from;
private $subject;
private $bodyparts;
private $attachments;
private $direction='out';
private $rmid;

public function __construct($to=null,$from=null,$subject=null,$body=null,$mime=null) {
  $this->add_to($to);
  $this->set_from($from);
  $this->set_subject($subject);
  if($body!=null)
    $this->add_bodypart($body,$mime);
}

/**
 * L&auml;gger till en mottagare. 
 * @param string $to mail-adress
 * @param string $name namn
 */
public function add_to($to,$name=null) {
  if($to!=null) {
    if($name)
	$this->to[] = "\"$name\" <$to>";
    else 
	$this->to[] = $to;
  }
}

/** 
 * L&auml;gger till en bcc-mottagare. 
 * @param string $to mail-adress
 * @param string $name anv&auml;ndarnamn
 */
public function add_bcc($bcc,$name=null) {
  if($bcc!=null) {
    if($name)
	$this->bcc[] = "\"$name\" <$bcc>";
    else 
	$this->bcc[] = $bcc;
  }
}

/**
 * Anger vilket h&aring;ll brevet &auml;r p&aring; v&auml;g och anv&auml;nds f&ouml;r att veta hur man ska spara i group_ticket. 
 * @param string $dir riktning ('in'/'out')
 */
public function set_direction($dir) {
  $this->direction=$dir;
} 

/**
 * Anger avs&auml;ndare. 
 * @param $from
 * @param string $name anv&auml;ndarnamn
 */
public function set_from($from,$name=null) {
  if($name)
    $this->from = "\"$name\" <$from>";
  else 
    $this->from = $from;
}

/**
 * S&auml;tter &auml;mne.
 * @param string $subject &auml;mne
 */
public function set_subject($subject) {
  $this->subject = $subject;
}

/**
 * L&auml;gger till en del till meddelandet. N&auml;r det finns flera s&aring;
 * skickas de som bifogade filer. Anger man inte mime(type) s&aring; antas det att
 * den &auml;r text/plain
 * @param $body
 * @param string $mime mime-typ
 */
public function add_bodypart($body,$mime=null) {
  if(!$mime)
    $mime='text/plain';
  $this->bodyparts[$mime] = array('content'=>$body,'mime'=>$mime);
  if($mime == 'text/wiki') {
    $this->add_bodypart(WikiFormat::wiki2text($body),'text/plain');
    $this->add_bodypart(WikiFormat::wiki2html($body),'text/html');
  }
}

/**
 * Bifogar en fil.
 * @param string $filename filnamn
 * @param string $name det bilagan ska d&ouml;pas till. Om denna parameter saknas anv&auml;nds filnamnet som namn
 * @param string $mime mime-typ. Om denna parameter saknas s&aring; g&ouml;rs ett f&ouml;rs&ouml;k att best&auml;mma mime-typ utifr&aring;n filens inneh&aring;ll
 */
public function add_attachment($filename,$name=null,$mime=null) {
  $handle       = fopen($filename, 'rb');
  $f_contents   = @fread($handle, filesize($filename));
  $content   = @base64_encode($f_contents);
  if(!$mime) {
    if(ini_get('mime_magic.debug')){
		$mime = @mime_content_type($filename);   
    }
  }
  if(!$name)
    $name = basename($filename);

  $this->add_parsed_attachment($content,$name,$mime);
}

public function add_parsed_attachment($content,$name,$mime) {

  $this->attachments[] = array('content'=>$content,'name'=>$name,'mime'=>$mime);
}

/**
 * Sparar mailet i group_message 
 */
public function save() {
  if($this->bodyparts['text/wiki'])
    $body = $this->bodyparts['text/wiki']['content'];
  elseif($this->bodyparts['text/html'])
    $body = WikiFormat::html2wiki($this->bodyparts['text/html']['content']);
  else
    $body = $this->bodyparts['text/plain']['content'];
  
  $db = DB::mysql();
  if(preg_match('/ticket\:\ (\d+)/i',$this->subject,$matches)) {
    $ticket = $matches[1];
    $tickets = $db->query("select tid from group_ticket where tid='{$ticket}'");
    if(!$tickets->num_rows)
	$ticket = null;
  }
  if(!$ticket) {
    if($this->direction=='out') {
	preg_match('/(\w+)\@/i',$this->from,$matches);
	$groups = $db->query("select gid from `group` where name='{$matches[1]}'");
	if($groups && $group = $groups->fetch_assoc())
	  $gid = $group['gid'];
    }    
    else {
	for($x=0;$x<sizeof($this->to);$x++) {
	  preg_match('/(\w+)\@/i',$this->to[$x],$matches);
	  $groups = $db->query("select gid from `group` where name='{$matches[1]}'");
	  if($groups && $group = $groups->fetch_assoc()) {
	    $gid = $group['gid'];
	    break;
	  }
	}
    }
    if(!$gid) 
	$gid = 1;
    $subject = $db->real_escape_string($this->subject);
    $from = $db->real_escape_string($this->from);
    $db->query("insert into group_ticket (gid,topic,from_email,from_uid) values ('{$gid}','{$subject}','{$from}',null)");
    $ticket = $db->insert_id;
  }
  $message = $db->real_escape_string($body);
  $from = $db->real_escape_string($this->from);
  $db->query("insert into group_ticket_message (tid,message,`from`) values ('{$ticket}','{$message}','{$from}')");
  $mid = $db->insert_id;
  for($x=0;$x<sizeof($this->attachments);$x++) {
    $att = $this->attachments[$x];
    $content = $db->real_escape_string($att['content']);
    $mime = $db->real_escape_string($att['mime']);
    $filename = $db->real_escape_string($att['name']);

    $db->query("insert into group_ticket_attachment (mid,content,mime,filename) values ($mid,'{$content}','{$mime}','{$filename}')");
  }
}

/**
 * Skickar mailet. 
 * @param $replyto 
 */
public function send($replyto=null) {
  $to = implode(',',$this->to);
  $subject = $this->subject;
  $headers = "From: ".$this->from."\n";
  if($replyto!=null)
    $headers.= "In-Reply-to: {$replyto}\n";
  if(!$this->bodyparts['text/html']) {
    $headers .= "Content-Type: {$this->bodyparts['text/plain']['mime']}; charset=utf-8\n";
    $message .= $this->bodyparts['text/plain']['content'];
  } else {
    $mime_boundary = "--eldsjal.org--".md5(time());
    $mix_boundary = "--eldsjal.org--".md5(microtime());
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$mime_boundary\"\n";
    unset($message);
    $message  = "This is a multi-part message in MIME format.\n\n";
    $message .= "--$mime_boundary\n";
    $message .= "Content-Type: multipart/alternative; boundary=\"$mix_boundary\"\n\n";
    foreach($this->bodyparts as $mime => $part) {
	$message .= "--$mix_boundary\n";
	$message .= "Content-Type: {$part['mime']}; charset=UTF-8\n";
	$message .= "Content-Transfer-Encoding: 8bit\n";
	$message .= "\n";
	$message .= $part['content']."\n";
    }
    $message  .= "--$mix_boundary--\n\n";
    if(sizeof($this->attachments)) {
	for($x = 0;$x<sizeof($this->attachments);$x++) {
	  $part = $this->attachments[$x];
	  if(!$part['mime']) {
	    $part['mime'] = 'application/octet-stream';
	  }
	  $message .= "--$mime_boundary\n";
	  $message .= "Content-Type: {$part['mime']}; name=\"{$part['name']}\"\n";
	  $message .= "Content-Transfer-Encoding: base64\n";
	  $message .= "Content-Disposition: attachment; filename=\"{$part['name']}\"\n";
	  $message .= "\n";
	  $message .= chunk_split($part['content'])."\n";
	}
	$message  .= "--$mime_boundary--\n\n";
    }
  }
  $mail_sent = mail( $to, $subject, $message, $headers );
  if(!$mail_sent && preg_match('/([\w]+)\@/i',$this->from,$matches)) {
    $db= DB::mysql();
    $groups = $db->query("select gid from `group` where name='{$matches[1]}'");
    $group = $groups->fetch_assoc();

    $subject = $db->real_escape_string($subject);
    $message = $db->real_escape_string($message);
    $headers = $db->real_escape_string($headers);
    $content = base64_encode($headers."\n".$messsage);
    if($group['gid']) {
	$db->query("insert into mail_raw (`group`,raw) values ('{$group['gid']}','{$content}')");
	$this->rmid = $db->insert_id;
    }
    echo $db->error;
    return true;
  }    
  return false;
}

public static function parse($raw,$rmid=null) {
  $mailparts = self::mailparts($raw);
  $from  = $mailparts[0]['head']['from'];
  $to  = $mailparts[0]['head']['to'];
  $subject  = $mailparts[0]['head']['subject'];
  $body = self::make_body($mailparts);
  $mail = new Mail($to,$from,$subject,$body,'text/wiki');
  $attachments = self::make_attachments($mailparts);
  for($x=0;$x<sizeof($attachments);$x++) {
    $att = $attachments[$x];
    $mail->add_parsed_attachment($att['body'],$att['filename'],$att['content-type']);
  }
  return $mail;
}

private static function mailparts($body, $bound=null) {
  $bound = trim($bound);
  if($bound) {
    $mailparts = split('--'.$bound,$body);
  }
  else {
    $mailparts[] = $body;
  }
  for($x=0;$x<sizeof($mailparts);$x++) {
    unset($head);
    list($headers,$bp) = split("\n\n",trim($mailparts[$x]),2);
    $headers = "\n".$headers;
    $headers = preg_split("/\n([a-z,-]*?)\:\ /i",$headers,-1,PREG_SPLIT_DELIM_CAPTURE);
    for($y=1;$y<sizeof($headers);$y+=2) {
	$head[strtolower($headers[$y])] = trim(imap_utf8($headers[$y+1]));
	$headh[strtolower($headers[$y])] = htmlentities(trim(imap_utf8($headers[$y+1])),ENT_QUOTES,'utf-8');
    }
    list($mime,$param) = preg_split('/;\s*/',$head['content-type'],2);
    if(strstr($mime,'multipart/')) {
	list($tmp,$boundary) = preg_split('/=/',str_replace('"','',$param),2);
	$br[] = array('head'=>$head,
		      'content-type'=>$mime,
		      'body'=>self::mailparts($bp,$boundary));
    } else if(trim($bp)) {
	if(trim($head['content-transfer-encoding'])=='quoted-printable') {
	  $bp = quoted_printable_decode($bp);
	} elseif(trim($head['content-transfer-encoding'])=='8bit' || trim($head['content-transfer-encoding'])=='7bit') {
	  $bp = imap_utf8($bp);
	} elseif(trim($head['content-transfer-encoding'])=='base64') {
	  $bp = base64_decode($bp);
	}
	list($param,$value) = split('=',$param,2);
	if($param=='charset')
	  $bp = Util::make_utf8($bp,$value);
	if($mime=='text/html') {
	  $bp = trim(strip_tags(WikiFormat::html2wiki($bp)));
	}
	else if($mime == 'text/plain')
	  $bp = trim($bp);
	else if($mime =='message/rfc822') {
	  $bp = self::mailparts($bp,'1');
	}
	list($disposition,$param) = preg_split('/\;\s*/',$head['content-disposition']);
	list($param,$value) = split('=',str_replace('"','',$param),2);
	if($disposition=='attachment' || !(strstr($mime,'text/') || strstr($mime,'message/'))) {
	  $disposition = 'attachment';
	  $bp = chunk_split(base64_encode($bp));
	}

	$br[] = array('head'=>$head,
		      'content-type'=>$mime,
		      'disposition'=>$disposition,
		      'body'=>$bp,
		      $param=>$value);
    }
  }
  return $br;
}

private static function make_body($mail,$disposition=null) { 
  for($x=0;$x<sizeof($mail);$x++) {
    if($mail[$x]['content-type']=='message/rfc822')
	$body .="\n\n[b]{$mail[$x]['body'][0]['head']['from']} skrev:[/b]\n";
    if(is_array($mail[$x]['body'])) {
	if($mail[$x]['content-type']=='multipart/alternative') {
	  for($y=0;$y<sizeof($mail[$x]['body']);$y++) {
	    if($mail[$x]['body'][$y]['content-type']=='text/plain')
	      $text = $mail[$x]['body'][$y]['body'];
	    if($mail[$x]['body'][$y]['content-type']=='text/html')
	      $html = WikiFormat::html2wiki($mail[$x]['body'][$y]['body']);
	  }
	  $body .= $html?$html:$text;
	} else {
	  $body .= self::make_body($mail[$x]['body'],$mail[$x]['disposition']);
	}
    } else {
	if($mail[$x]['disposition']=='inline' || $mail[$x]['disposition']=='')
	  $body .= $mail[$x]['body'];
    }
  }
  if($disposition=='inline' && $body)
    return "[quote]{$body}[/quote]";
  else
    return $body;
}

private static function make_attachments($mail, &$list = null) {
  if(!is_array($list)) {
    $list = array();
    $mail = $mail[0];
  }
  if(is_array($mail['body'])) {
    for($x=0;$x<sizeof($mail['body']);$x++) {
	if(is_array($mail['body'][$x]['body'])) {
	  self::make_attachments($mail['body'][$x],$list);
	} elseif($mail['body'][$x]['disposition']=='attachment') {
	  $list[] = $mail['body'][$x];
	}
    }
  }
  return sizeof($list)?$list:null;
}
}
?>