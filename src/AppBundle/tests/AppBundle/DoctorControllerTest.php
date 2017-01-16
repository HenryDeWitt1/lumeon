<?php

namespace tests\AppBundle;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DoctorControllerTest extends WebTestCase
{
    public function testBasicTest()
    {
        $client = static::createClient();
        $client->request('GET', '/doctor/1/1');


        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertContains("patient successfully assigned to doctor",$client->getResponse()->getContent());
    }
    public function testFailTest()
    {
        $client = static::createClient();
        $client->request('GET', '/doctor/1/100000');
        $this->assertTrue($client->getResponse()->isNotFound());
    }

    public function testComplex()
    {
        $client = static::createClient();
        $client->request('POST', '/doctor/1', array('name' => 'patient name','dob'=>'2012-01-01','gender'=>1));

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertContains("patient successfully assigned to doctor",$client->getResponse()->getContent());
    }

    public function testComplexFail()
    {
        $client = static::createClient();
        $client->request('POST', '/doctor/1', array('name' =>null,'dob'=>null,'gender'=>null));

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertContains("Error with patient data",$client->getResponse()->getContent());
    }
}