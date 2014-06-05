<?php
class Mailer  {
	
	public $data = array();
	public $errors = array();
	public $errorFeedback = "The following errors occured:<br>";
	
	public function __construct() {
		
	}	
	/**
	* @author rlais
	* @desc   loads mail template 
	* @param  templateName (url)
	* @return html string
	*/
	private function loadTemplateByTemplateName($templateName, $data) {
		$file = ROOT_DIR . $templateName;
		if (!file_exists($file)) {
			die("RD: ". ROOT_DIR ."<br><br>you got a problem with your template configs!!");
		}		
		include $file;
		
		$output = ob_get_contents();

		ob_end_clean();
		
		return $output;	
	}
	/**
	* @author rlais
	* @desc   loads template model
	* @param  templateModelName (url)
	* @return simpleXML
	*/
	private function loadTemplateModelByTemplateName($templateModelName) {
		$file = ROOT_DIR . $templateModelName;
		if (!file_exists($file)) {
			die("RD: ". $file ."<br><br>you got a problem with your templateModel configs!!");
		}
		return simplexml_load_file($file);
	}
	/**
	 * @author bschoene
	 * @desc   checks if entry is empty
	 * @param  entry
	 * @return true if entry isn't empty
	 */
	public function checkNotEmpty($entry) {
		if(empty($entry)) {
			return false;
		} else {
			return true;
		}
	}
	/**
	* @author rlais
	* @desc   validates user input with xml model
	* @param  templateModelName, templateName, data
	* @return true if valid
	*/
	private function validateData($templateModelName, $templateName, $data) {
		$modeldata = $this->loadTemplateModelByTemplateName($templateModelName);
		// check if model and $data match 
		foreach ($modeldata as $model) {
			foreach ($model as $field) {
				$userdata = false;
				// receive data 
				$userdata = $data[''.$field->getName().''];
				
				if ($field->mandatory == 1 && !($userdata)) {
					$this->errorFeedback .= $field->getName()." is mandatory but not set!<br />";
				}
				
				if (!$this->checkNotEmpty($userdata)) {
					array_push($this->errors, $field->getName()." is not a valid string. It must not be empty.<br />");
					$this->errorFeedback .= $field->getName()." is not a valid string. It must not be empty.<br />";
				} else {
					array_push($this->data, array($field->getName(), $userdata, $field->type));
				}	
			}
		}
		if(empty($this->errors))
			return true;
		else
			return false;
	}
	/**
	* @author rlais
	* @desc   binds data to text model
	* @param  templateName, data
	* @return data-filled text
	*/
	private function bindDataToText($templateName, $data) {
		$text = $this->loadTemplateByTemplateName($templateName, $data);
		return $text;
	}
	/**
	* @author rlais
	* @desc   sends mail
	* @param  templateModelName, templateName, data
	* @return data-filled text
	*/
	public function send($templateModelName, $templateName, $data) {
				
		if($this->validateData($templateModelName, $templateName, $data)) {
			
			require_once(ROOT_DIR .'/email/postmark.php'); // TODO delete postmark
			
			
			$text = $this->bindDataToText($templateName, $data);
		
			$dataArray = $data;
			$to = $data['recipient_email'];
			$subject = ucfirst($data['type_of_email']);
			$message = $text;
			$anhang = $data['attachments'];
			
			
			$absender = $data['sender_name'];
			$absender_mail = $data['sender_email'];
			$reply = $data['reply_to'];
		/*	TODO replace postmark with this	
			$mime_boundary = "-----=" . md5(uniqid(mt_rand(), 1));
			
			$header  ="From:".$absender."<".$absender_mail.">\n";
			$header .= "Reply-To: ".$reply."\n";
			
			$header.= "MIME-Version: 1.0\r\n";
			$header.= "Content-Type: multipart/mixed;" . "\r\n";
			$header.= " boundary=\"".$mime_boundary."\"\r\n";
			
			$content = "This is a multi-part message in MIME format.\r\n\r\n";
			$content.= "--".$mime_boundary."\r\n";
			$content.= "Content-Type: text/html; charset=\"utf-8\"\r\n";
			$content.= "Content-Transfer-Encoding: 8bit\r\n\r\n";
			$content.= $message;
				
		
			// if there are no attachments
			if(!(empty($anhang) OR $anhang == 'null')) {
				$attachments = explode(",", $data['attachments']);			
				
				$content .= "\n";	
				
				foreach($attachments as $file) {
					$filename = split('/', $file);
					$numSplits = count($filename) -1;
					$filename = $filename[$numSplits];
					$data = chunk_split(base64_encode(implode("",file($file))));
					$content.= "--".$mime_boundary."\r\n";
					$content.= "Content-Disposition: attachment;\r\n";
					$content.= "\tfilename=\"".$filename."\";\r\n";
					$content.= "Content-Length: .".filesize($file).";\r\n";
					$content.= "Content-Type: ".filetype($file)."; name=\"".$filename."\"\r\n";
					$content.= "Content-Transfer-Encoding: base64\r\n\r\n";
					$content.= $data."\r\n";
				}
			$content .= "--".$mime_boundary."--";		
			}
		*/
		// TODO delete postmark	
			require_once(ROOT_DIR .'/email/class.html2text.inc');
			$h2t = new html2text($message);
			$messageText = $h2t->get_text();
			
			$postmark = new Postmark("hash",'sender',$reply);
						
			$postmarksend = $postmark->to($to);
			$postmark->subject($subject);
			$postmark->plain_message($messageText);
					
			$postmark->html_message($message);
			
			if($postmark->send()) {
				// id date sender sender_mail recipient recipient_mail type attachments content
				$query = "INSERT INTO mail_history (date, sender, sender_mail, recipient, recipient_mail, type, attachments, mail_content) VALUES (NOW(''), '". $dataArray['sender_name'] ."', '". $dataArray['sender_email'] ."', '". $dataArray['firstname'] ." ". $dataArray['surname'] ."', '". $dataArray['recipient_email'] ."', '". $dataArray['type_of_email'] ."', '". $dataArray['attachments'] ."', '". $message ."')";
				$ins_hist = mysql_query($query);
				return true;
			}
			else
				return false;
		// TODO delete postmark END	
			
	/*	TODO replace postmark with this	
			if(mail($to, $subject, $content, $header)) {
				
				// id date sender sender_mail recipient recipient_mail type attachments content
				$query = "INSERT INTO mail_history (date, sender, sender_mail, recipient, recipient_mail, type, attachments, mail_content) VALUES (NOW(''), '". $dataArray['sender_name'] ."', '". $dataArray['sender_email'] ."', '". $dataArray['firstname'] ." ". $dataArray['surname'] ."', '". $dataArray['recipient_email'] ."', '". $dataArray['type_of_email'] ."', '". $dataArray['attachments'] ."', '". $message ."')";
				$ins_hist = mysql_query($query);
				return true;
			}
			else
				return false;
	*/
		}
		else {
			echo "<br><br>". $this->errorFeedback;
		}
	}
}