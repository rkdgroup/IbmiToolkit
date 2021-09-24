<?php
namespace ToolkitApiTest;

use PHPUnit\Framework\TestCase;
use ToolkitApi\httpsupp;

final class HttpSuppTest extends TestCase
{
    public function testCanSetIpc()
    {
        $ipc = 'test';

        $httpsupp = new httpsupp();
        $httpsupp->setIpc($ipc);

        $this->assertEquals($ipc, $httpsupp->getIpc());
    }
    
    public function testIsIpcSet()
    {
        $ipc = 'test';
        
        $httpsupp = new httpsupp();
        $httpsupp->setIpc($ipc);
        
        $this->assertEquals($ipc, $httpsupp->getIpc());
    }
}
