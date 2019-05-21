<?php

error_reporting(E_ALL);

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/gen-php/Sample/Calc/CalculatorIf.php';
require_once __DIR__.'/gen-php/Sample/Calc/CalculatorProcessor.php';
require_once __DIR__.'/gen-php/Sample/Calc/Calculator_add_args.php';
require_once __DIR__.'/gen-php/Sample/Calc/Calculator_add_result.php';

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;
use Thrift\Transport\TSocket;
use Thrift\Server\TSimpleServer;
use Thrift\Server\TServerSocket;
use Thrift\Factory\TTransportFactory;
use Thrift\Factory\TBinaryProtocolFactory;

final class AddHandler implements Sample\Calc\CalculatorIf
{
	public function add($num1, $num2)
	{
		return ($num1 + $num2);
	}
}

final class ThriftSampleServer
{
	public static function main()
	{
		$handler = new AddHandler();
		$processor = new Sample\Calc\CalculatorProcessor($handler);
		$transport = new TBufferedTransport(new TPhpStream(Thrift\Transport\TPhpStream::MODE_R | Thrift\Transport\TPhpStream::MODE_W));
		$transport = new TServerSocket('localhost', 9091);
		$transport_factory = new TTransportFactory($transport);
		$protocol_factory = new TBinaryProtocolFactory(false, false);

		$server = new TSimpleServer($processor, $transport, $transport_factory, $transport_factory, $protocol_factory, $protocol_factory);

		print "Starting the server... \n";
		$server->serve();
		print "done.\n";
	}
}

ThriftSampleServer::main();
