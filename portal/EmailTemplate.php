<?php
	include_once("../configs/application.php");
	include_once("../connections/class.db.php");
	class EmailTemplate extends database{
		private $id;
		private $name;
		private $subject;
		private $content;
		private $variables;
		private $status;

		/**
		 * @return mixed
		 */
		public function getId()
		{
			return $this->id;
		}

		/**
		 * @param mixed $id
		 */
		public function setId($id)
		{
			$this->id = $id;
		}

		/**
		 * @return mixed
		 */
		public function getName()
		{
			return $this->name;
		}

		/**
		 * @param mixed $name
		 */
		public function setName($name)
		{
			$this->name = $name;
		}

		/**
		 * @return mixed
		 */
		public function getSubject()
		{
			return $this->subject;
		}

		/**
		 * @param mixed $subject
		 */
		public function setSubject($subject)
		{
			$this->subject = $subject;
		}

		/**
		 * @return mixed
		 */
		public function getContent()
		{
			return $this->content;
		}

		/**
		 * @param mixed $content
		 */
		public function setContent($content)
		{
			$this->content = $content;
		}

		/**
		 * @return mixed
		 */
		public function getVariables()
		{
			return $this->variables;
		}

		/**
		 * @param mixed $variables
		 */
		public function setVariables($variables)
		{
			$this->variables = $variables;
		}

		/**
		 * @return mixed
		 */
		public function getStatus()
		{
			return $this->status;
		}

		/**
		 * @param mixed $status
		 */
		public function setStatus($status)
		{
			$this->status = $status;
		}
		public function getTemplate($name,$url){
			return file_get_contents($url.$name);
		}
		public function tempalteSendArray($message,$variables){
			$searchArray=array_keys($variables);
			$replaceArray=array_values($variables);
			return str_replace($searchArray,$replaceArray,$message);
		}

		public function findEMailTempalte($name){//check template exist
			$sql="SELECT * FROM email_template WHERE NAME='$name' AND STATUS='Y'";
			$template= $this->getData($sql);
			$empty=array();
			if($template!=null){
				$mailTemplate=new EmailTemplate();
				$mailTemplate->id=$template[0]['ID'];
				$mailTemplate->name=$template[0]['NAME'];
				$mailTemplate->subject=$template[0]['SUBJECT'];
				$mailTemplate->content=($template[0]['DESCRIPTION']);
				$mailTemplate->variables=$template[0]['VARIABLES'];
				$mailTemplate->status=$template[0]['STATUS'];
				return $mailTemplate;
			}else{
				return $empty;
			}
		}
		public function getContentFinal($templateName,$variables,$emailTemplate){
			$dbTemplate=$this->findEMailTempalte($templateName);
			$content=$dbTemplate->getContent();
			$final_mess=$this->tempalteSendArray($content,$variables);
			$message_final = str_replace("{{CONTENT}}", $final_mess, $emailTemplate);
			return $message_final;
		}
	}
?>