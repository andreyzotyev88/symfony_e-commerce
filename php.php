<?php
class A {
	public static $me = "A";
	public static function who()
	{
		return self::$me;
	}
}

class B extends A{

	public static $me = "B";
}
echo B::who();
