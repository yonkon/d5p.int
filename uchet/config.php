<?php

class UCONFIG 
{
	public static $printout;
	public static $debug;
	public static $baseDir;
	public static $coreDir;
	public static $viewsDir;
	public static $modelsDir;
	public static $tmplDir;
	public static $configDir;
	public static $tmpDir;
	public static $tmpDirG;
	public static $includeDir;
	public static $phpDir;
	public static $viewMode;
	public static $spamDefenceMode;
	public static $siteEncoding;
	public static $jsPath;
	public static $cssPath;
	public static $imgPath;
	public static $includePath;
	public static $siteName;
	public static $style;
	public static $url;
	public static $password;
	public static $ownderIDU;
	public static $remoteCurlServer;
	public static $logDir;
	public static $purposeSwitch;
	public static $hideHeader;
	public static $onlinePay;
	public static $paymentMethod;
	public static $paysysRegions;
	public static $emailToAvtor;
	public static $smarty;
	public static $syncPeriod;
	public static $cookiePath;
	public static $uchetPath;
	public static $fullSiteName;
	public static $maxCountLogs;
	public static $db;
	
	public static function init()
	{
		/*
		*
		* This options must be setted while application installing
		*
		*/
		self::$printout = false;// Printout immediately or delay and write into a variable
		self::$siteEncoding = 'UTF8';
		self::$siteName = 'diplom5plus.ru'; // Url
		self::$password = 'klwejrnvwerndsfehlpoqzx'; // Password, that takes from sverka1.ru
		self::$ownderIDU = 71040; // Id owner user, that takes from sverka1.ru
		
		self::$purposeSwitch = true;// To track purpose in url ordercreated

		self::$fullSiteName = 'http://'.self::$siteName; // Full url of site

		/*
		* URL options
		*/
		self::$url['userblock'] = '/';
		self::$url['order'] = '/order/';
		self::$url['ordercreated'] = '/cabinet/page/ordercreated/';
		self::$url['registeravtor'] = '/cabinet/page/registeravtor/';
		self::$url['sregisteravtor'] = '/cabinet/page/sregisteravtor/';
		self::$url['news'] = '/cabinet/page/news/';
		self::$url['orderlist'] = '/cabinet/page/orderlist/';
		self::$url['orderinfo'] = '/cabinet/page/orderinfo/';
		self::$url['owninfo'] = '/cabinet/page/owninfo/';
		self::$url['logout'] = '/cabinet/page/logout/';
		self::$url['download'] = '/cabinet/page/download/';
		self::$url['onlinepayment'] = '/cabinet/page/onlinepayment/';
		self::$url['recover'] = '/cabinet/page/recover/';
		
		/*
		* Directories options
		*/
		self::$baseDir = dirname(__FILE__).'/';
		self::$coreDir = self::$baseDir.'core/';
		self::$configDir = self::$coreDir.'configs/';
		self::$viewsDir = self::$coreDir.'views/';
		self::$modelsDir = self::$coreDir.'models/';
		self::$tmplDir = self::$baseDir.'tmpl/';
		self::$tmpDirG = self::$baseDir.'tmp/';
		self::$tmpDir = self::$tmpDirG.'type-here/'; //Temp directory
		self::$logDir = self::$tmpDir.'log/';
		self::$includeDir = self::$coreDir.'include/';
		self::$phpDir = self::$baseDir.'php/';
		
		self::$uchetPath = '//'.self::$siteName.'/uchet/';
		self::$jsPath = self::$uchetPath.'html/js/';
		self::$cssPath = self::$uchetPath.'html/css/';
		self::$imgPath = self::$uchetPath.'html/img/';
		self::$includePath = self::$uchetPath.'core/include/';
		
		self::$cookiePath = '/'; // If site in the root directory - then '/'

		/*
		* Options to view mode: smarty or php
		*/
		self::$viewMode['order'] = 'smarty';
		self::$viewMode['ordercreated'] = 'smarty';
		self::$viewMode['registeravtor'] = 'smarty';
		self::$viewMode['sregisteravtor'] = 'smarty';
		self::$viewMode['userblock'] = 'smarty';
		self::$viewMode['orderlist'] = 'smarty';
		self::$viewMode['orderinfo'] = 'smarty';
		self::$viewMode['owninfo'] = 'smarty';
		self::$viewMode['news'] = 'smarty';
		self::$viewMode['download'] = 'smarty';
		self::$viewMode['onlinepayment'] = 'smarty';
		self::$viewMode['recover'] = 'smarty';
		self::$viewMode['main'] = 'smarty';
		
		self::$smarty['caching'] = false; 
		self::$smarty['cache_lifetime'] = 120;
		
		self::$hideHeader = false; // To hide header in templates
		self::$spamDefenceMode = 'securimage'; //possibility: 'securimage'
		
		/*
		* Other options
		*/
		self::$debug = false;
		if(($_SERVER['REMOTE_ADDR'] == '123') || ($_SERVER['REMOTE_ADDR'] == '456')) {
			self::$debug = true;
		}
		
		self::$syncPeriod = 1*24*3600;
		
		self::$maxCountLogs = 500;
		
		self::$remoteCurlServer = 'http://sverka1.ru/server.uchet.php';
		
		self::$db = Array(
			'server' => 'localhost',
			'user' => '',
			'dbName' => '',
			'pass' => '',
			'charset' => 'utf8', // варианты: 'utf8', 'cp1251'...
		);
		
		self::$style = Array(
			'input_width' => array(
				'standart' => ' width: 300px; ' ,
				'double' => ' width: 515px; height: 30px;' ,
				'less_standart' => ' width: 240px; '
			) ,
			'text_align1' => ' text-align: right; padding-right: 5px; width: 210px;' , 
			'text_red' => ' color: red; font-weight: bold; ' ,
			'wrapper_form' => ' width: 525px; ' ,
			'container' => ' padding:5px; ' ,
			'formtext' => ' display:block; width:200px; float:left; text-align:left; ' ,
			'formbox' => ' width:300px; float:right; ' ,
			'td_right' => ' padding: 2px 0; ' ,
			'border_normal' => 'border-style:solid; border-width:1px; border-color:#959595; ' ,
			'alert_info' => 'background-image: url(\''.self::$imgPath.'/ico_alert.gif\'); background-repeat: no-repeat; background-position: 25px 50%; height: 22px; padding: 13px 0 13px 75px;'
		);
		
		self::$onlinePay = false;
		self::$paymentMethod = Array(
			'easypayby' => Array(
                'switch' => false, //possibility: true, false
                'fullname' => 'EasyPay.By',
                'login' => '', 
                'pass' => '',
                'web_key' => '', 
                'server' => 'https://ssl.easypay.by/weborder/', // to test
                //'server'=>'https://ssl.easypay.by/xml/easypay.wsdl' // to production
                'expires' => 4,
                'debug' => 0,
                'url' => Array(
                    'fail' => self::$fullSiteName.self::$url['onlinepayment'].'&paysys=easypayby&resultpayment=fail',
                    'success' => self::$fullSiteName.self::$url['onlinepayment'].'&paysys=easypayby&resultpayment=success',
                )
                
            ),
			'interkassa' => Array(
				'switch' => false, //possibility: true, false
				'fullname' => 'Interkassa',
				'server' => 'http://www.interkassa.com/lib/payment.php',
				'ik_shop_id' => '',
				'url' => Array(
					'fail' => self::$fullSiteName.self::$url['onlinepayment'].'&paysys=interkassa&resultpayment=fail',
					'success' => self::$fullSiteName.self::$url['onlinepayment'].'&paysys=interkassa&resultpayment=success',
				),
			),
			'privat24' => Array(
				'switch' => false, //possibility: true, false
				'fullname' => 'Приват24',
				'mid' => '',
				'server' => 'https://api.privatbank.ua/p24api/ishop',
				'url' => Array(
					'client' => self::$fullSiteName.self::$url['onlinepayment'].'&paysys=privat24&resultpayment=receive',
					'server' => 'http://sverka1.ru/server.privat24.php',
				),

			),
            'qiwi' => Array(
                'switch' => false, //possibility: true, false
                'fullname' => 'QIWI',
                'qiwi_shop_id' => '', 
                'server' => 'https://w.qiwi.ru/setInetBill_utf.do',
            ),
			'robokassa' => Array(
                'switch' => false, //possibility: true, false
                'fullname' => 'ROBOKASSA',
                'merchantLogin' => '',
				'password1' => '',
				'password2' => '',
                'server' => 'https://auth.robokassa.ru/Merchant/Index.aspx',
			),
			'cash1' => Array(
				'switch' => false,
				'fullname' => 'Наличными',
				'info' => 'Оплатить можно в офисе',
			),
			'bank1' => Array(
				'switch' => false,
				'fullname' => 'Банковский платеж',
				'info' => 'Оплата возможна банковским переводом.',
				'file' => 'http://filepath.ru',
			),
		);
		
		self::$paysysRegions = Array(
			Array(
				'name' => 'all',
				'text' => 'Доступные Вам способы оплаты',
				'payments' => Array(
					'robokassa', 'qiwi', 'interkassa', 'cash1', 'bank1'),
			),
		);
	}
	
}

UCONFIG::init();