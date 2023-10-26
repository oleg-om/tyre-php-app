<?php
class SenderComponent extends Component {
	public function initialize(Controller $controller) {
	}
	public function sendEmail($to, $key, $variables = array()) {
		$to = trim($to);
		if ($this->_emailValid($to)) {
			$this->Template = ClassRegistry::init('Template');
			if ($template = $this->Template->get($key)) {
				App::uses('CakeEmail', 'Network/Email');
				$host = env('HTTP_HOST');
				$cake_email = new CakeEmail('default');
				$cake_email->to($to);
				$from = 'noreply@' . $host;
				if (isset($variables['send_from'])) {
					$from = h($variables['send_from']);
					unset($variables['send_from']);
				}
				if (isset($variables['attachments'])) {
					$cake_email->attachments($variables['attachments']);
					unset($variables['attachments']);
				}
				$cake_email->from($from);
				$cake_email->replyTo('info@' . $host);
				$cake_email->returnPath('info@' . $host);
				$cake_email->emailFormat('html');
				$body = $template['Template']['body'];
				$subject = $template['Template']['subject'];
				foreach ($variables as $key => $value) {
					$body = str_replace('{' . $key . '}', $value, $body);
					$subject = str_replace('{' . $key . '}', $value, $subject);
				}
				$cake_email->subject($subject);
				$cake_email->send($body);
			}
		}
	}
	public function sendNewsletterEmail($to, $subject, $body, $variables = array()) {
		$to = trim($to);
		if ($this->_emailValid($to)) {
			App::uses('CakeEmail', 'Network/Email');
			$host = env('HTTP_HOST');
			$cake_email = new CakeEmail('default');
			$cake_email->to($to);
			$from = 'noreply@' . $host;
			if (isset($variables['send_from'])) {
				$from = h($variables['send_from']);
				unset($variables['send_from']);
			}
			if (isset($variables['attachments'])) {
				$cake_email->attachments($variables['attachments']);
				unset($variables['attachments']);
			}
			$cake_email->from($from);
			$cake_email->replyTo('info@' . $host);
			$cake_email->returnPath('info@' . $host);
			$cake_email->emailFormat('html');
			$body = $body;
			$subject = $subject;
			foreach ($variables as $key => $value) {
				$body = str_replace('{' . $key . '}', $value, $body);
				$subject = str_replace('{' . $key . '}', $value, $subject);
			}
			$cake_email->subject($subject);
			$cake_email->send($body);
		}
	}
	private function _emailValid($email) {
		$regex = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/i';
		return preg_match($regex, $email);
	}
}