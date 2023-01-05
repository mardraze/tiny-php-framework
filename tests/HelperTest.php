<?php 
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{

    public function testUrl()
    {
        $this->assertEquals(url('example', ['param' => 'test']), '/example-test');
    }

    public function testUrlNotFound()
    {
        $this->expectException(\ErrorException::class);
        url('example-404');
	}
	
	public function testOdmiana()
    {
        $this->assertEquals(odmiana(1, ['przykład', 'przykłady', 'przykładów']), 'przykład');
        $this->assertEquals(odmiana(2, ['przykład', 'przykłady', 'przykładów']), 'przykłady');
        $this->assertEquals(odmiana(5, ['przykład', 'przykłady', 'przykładów']), 'przykładów');
	}

}

