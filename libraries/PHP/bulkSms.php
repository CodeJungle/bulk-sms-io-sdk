<?php
/**
 * A PHP library that you can use to quickly start working with our system.
 * Documentation is in the link below:
 * https://bulk-sms.io/api-documentation
 *
 * Release date: 26.04.2018
 * Version: 1.0.0
 */
class bulkSms
{

	static $baseUrl = "https://bulk-sms.io";
	function __construct($token)
	{
		$this->token = $token;
	}

	/**
	 *
	 * CONTACTS API
	 *
	 */
	function getContacts($page = 1)
	{
		return $this->makeRequest('/api/contacts', 'GET', ['page' => $page]);
	}

	function getContact($id)
	{
		return $this->makeRequest('/api/contacts/view/', 'GET', ['id' => $id]);
	}

	/**
	 *
	 * DEVICES API
	 *
	 */
	function getDevices($page = 1)
	{
		return $this->makeRequest('/api/devices', 'GET', ['page' => $page]);
	}

	function getDevice($id)
	{
		return $this->makeRequest('/api/devices/view/', 'GET', ['id' => $id]);
	}

	/**
	 *
	 * MESSAGES API
	 *
	 */
	function getMessages($page = 1, $options = [])
	{
        $query = array_merge(['page' => $page], $options);
		return $this->makeRequest('/api/messages', 'GET', $query);
	}

	function getMessage($id)
	{
		return $this->makeRequest('/api/messages/view/', 'GET', ['id' => $id]);
	}

	function sendMessageToNumber($to, $message, $device, $options = [])
	{
		$query = array_merge(['number' => $to, 'message' => $message, 'device' => $device], $options);
		return $this->makeRequest('/api/messages/send', 'POST', $query);
	}

	function sendMessageToManyNumbers($to, $message, $device, $options = [])
	{
		$query = array_merge(['number' => $to, 'message' => $message, 'device' => $device], $options);
		return $this->makeRequest('/api/messages/send', 'POST', $query);
	}

	function sendMessageToContact($to, $message, $device, $options = [])
	{
		$query = array_merge(['contact' => $to, 'message' => $message, 'device' => $device], $options);
		return $this->makeRequest('/api/messages/send', 'POST', $query);
	}

	function sendMessageToManyContacts($to, $message, $device, $options = [])
	{
		$query = array_merge(['contact' => $to, 'message' => $message, 'device' => $device], $options);
		return $this->makeRequest('/api/messages/send', 'POST', $query);
	}

	/**
	 * Send data to the server.
	 */
	private
	function makeRequest($url, $method, $data)
	{
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json'
		);
		$data['token'] = $this->token;
		$url = bulkSms::$baseUrl . $url;
		$json_data = json_encode($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		$return['response'] = json_decode($result, true);
		$return['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $return;
	}
}

?>