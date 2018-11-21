<?php

class User {
	
	protected $_name;
	protected $_email;
	protected $_type;
	
	/**
	 * Some comment
	 * Construct
	 */
	public function __construct(string $name, string $email)
	{
		$this->_name  = $name;
		$this->_email = $email;
	}
	
	public function __toString()
	{
		return $this->_type . ' ' . $this->_name . ' ' . $this->_email;
	}
	
	public function add()
	{
		$userStorage = fopen('users', 'a');
		fwrite($userStorage, $this->_type . ' ' . $this->_name . ' ' . $this->_email . "\r\n");
		fclose($userStorage);
	}
	
	public function setName(string $name)
	{
		$this->_name  = $name;
		
		return $this;
	}
	
	public function setEmail(string $email)
	{
		$this->_email = $email;
		
		return $this;
	}
	
}


class Customer extends User {
	
	protected $_type = 'Customer';	
	
	public function __toString()
	{
		return '<b>' . $this->_type . '</b>' . ' ' . $this->_name . ' ' . $this->_email;
	}
	
}

class Guest extends User {
	
	protected $_type = 'Guest';
	
	public function __toString()
	{
		return '<i style="color:red;">' . $this->_type . '</i>' . ' ' . $this->_name . ' ' . $this->_email;
	}
	
}

class Supplier extends User {
	
	protected $_type = 'Supplier';
	
	public function __toString()
	{
		return '<i style="color:brown;">' . $this->_type . '</i>' . ' ' . $this->_name . ' ' . $this->_email;
	}
	
}

class BlackFriday extends User {
	
	protected $_type = 'BlackFriday';
	
	public function __toString()
	{
		return '<b style="color:red;">' . $this->_type . '</i>' . ' ' . $this->_name . ' ' . $this->_email;
	}
	
}

class Factory {
	
	public static function getUserObject(string $type, string $name, string $email)
	{
		return new $type($name, $email);
	}
	
}

class Users {
		
	private $_users;
	
	public function __construct()
	{
		$fileData = [];
		
		$userStorage = fopen('users', 'a+');
		while ($row = fgets($userStorage)) {
			$fileData[] = explode(' ', $row);
		}
		
		foreach ($fileData as $data) {
			$this->_users[] = Factory::getUserObject($data[0], $data[1], $data[2]);
		}
		
		fclose($userStorage);
	}
	
	public function show()
	{
		$view = '<table>';
		foreach ($this->_users as $user) {
			$view .= '<tr><td>' . $user . '</td></tr>';
		}
		$view .= '</table>';
		
		echo $view;
	}
	
}


$userObject = Factory::getUserObject('Customer', 'Vasya', 'boby@yandex.ru');
$userObject->setName('Egor')
	->add();

$userObject = Factory::getUserObject('Guest', 'Petya', 'petya@yandex.ru');
$userObject->add();

$userObject = Factory::getUserObject('Customer', 'Vasya', 'boby@yandex.ru');
$userObject->setName('Egor')
	->add();

$userObject = Factory::getUserObject('Guest', 'Petya', 'petya@yandex.ru');
$userObject->add();

$userObject = Factory::getUserObject('Supplier', 'Petya', 'petya@yandex.ru');
$userObject->add();

$userObject = Factory::getUserObject('Guest', 'Petya', 'petya@yandex.ru');
$userObject->add();

$userObject = Factory::getUserObject('BlackFriday', 'Petya', 'petya@yandex.ru');
$userObject->add();

(new Users())->show();
