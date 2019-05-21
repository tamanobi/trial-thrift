<?php

error_reporting(E_ALL);

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/gen-php/Sample/Calc/CalculatorIf.php';
require_once __DIR__.'/gen-php/Sample/Calc/CalculatorClient.php';
require_once __DIR__.'/gen-php/Sample/Calc/Calculator_add_args.php';
require_once __DIR__.'/gen-php/Sample/Calc/Calculator_add_result.php';

use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;
use Thrift\Protocol\TBinaryProtocol;

final class Client
{
	public static function main()
	{
		$transport = new TBufferedTransport(new TSocket('localhost', 9091), 1024, 1024);;
		$protocol = new TBinaryProtocol($transport, false, false);
		$client = new \Sample\Calc\CalculatorClient($protocol);
		$transport->open();
		$sum = $client->add(1,1);
		print "1+1=$sum\n";
		$transport->close();
	}
}

Client::main();
