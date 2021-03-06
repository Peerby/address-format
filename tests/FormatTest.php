<?php

use Adamlc\AddressFormat\Format;

class FormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Setup procedure which runs before each test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->container = new Format;
    }

    /**
     * Test setting a locale
     *
     * @return void
     */
    public function testSettingLocale()
    {
        $this->assertTrue(
            $this->container->setLocale('GB')
        );
    }

    /**
     * Test setting an invalid locale
     *
     * @expectedException Adamlc\AddressFormat\Exceptions\LocaleNotSupportedException
     * @return void
     */
    public function testSettingInvalidLocale()
    {
		$this->container->setLocale('FOO');
    }

    /**
     * Test setting an invalid locale
     *
     * @expectedException Adamlc\AddressFormat\Exceptions\LocaleParseErrorException
     * @return void
     */
    public function testLocaleWithInvalidMetaData()
    {
		$this->container->setLocale('Test');
    }

    /**
     * Test setting a valid attribute
     *
     * @return void
     */
    public function testSetAttributeWithValidAttribute()
    {
		$this->assertEquals(
			$this->container->setAttribute('ADMIN_AREA', 'Foo Land'),
			'Foo Land'
		);
    }

    /**
     * Test setting an invalid attribute
     *
     * @expectedException Adamlc\AddressFormat\Exceptions\AttributeInvalidException
     * @return void
     */
    public function testSetAttributeWithInvalidAttribute()
    {
		$this->container->setAttribute('PLACE_OF_FOO', 'Foo Land');
    }

    /**
     * Test getting a valid attribute
     *
     * @return void
     */
    public function testGetAttributeWithValidAttribute()
    {
    	$this->container->setAttribute('ADMIN_AREA', 'Foo Land');

		$this->assertEquals(
			$this->container->getAttribute('ADMIN_AREA'),
			'Foo Land'
		);
    }

    /**
     * Test getting an invalid attribute
     *
     * @expectedException Adamlc\AddressFormat\Exceptions\AttributeInvalidException
     * @return void
     */
    public function testGetAttributeWithInvalidAttribute()
    {
		$this->container->getAttribute('PLACE_OF_FOO');
    }

    /**
     * Check the format of a GB address is expected
     *
     * @return void
     */
    public function testGbAddressFormat()
    {
    	//Clear any previously set attributes
    	$this->container->clearAttributes();

    	//Set Locale and attributes
		$this->container->setLocale('GB');

		$this->container->setAttribute('ADMIN_AREA', 'London');
		$this->container->setAttribute('LOCALITY', 'Greenwich');
		$this->container->setAttribute('RECIPIENT', 'Joe Bloggs');
		$this->container->setAttribute('ORGANIZATION', 'Novotel London');
		$this->container->setAttribute('POSTAL_CODE', 'SE10 8JA');
		$this->container->setAttribute('STREET_ADDRESS', '173-185 Greenwich High Road');
		$this->container->setAttribute('COUNTRY', 'United Kingdom');

		$this->assertEquals(
			$this->container->formatAddress(),
			"Joe Bloggs\nNovotel London\n173-185 Greenwich High Road\nGreenwich\nLondon\nSE10 8JA"
		);
    }

    /**
     * Check the format of a DE address is expected
     *
     * @return void
     */
    public function testDeAddressFormat()
    {
    	//Clear any previously set attributes
    	$this->container->clearAttributes();

    	//Set Locale and attributes
		$this->container->setLocale('DE');

		$this->container->setAttribute('LOCALITY', 'Oyenhausen');
		$this->container->setAttribute('RECIPIENT', 'Eberhard Wellhausen');
		$this->container->setAttribute('ORGANIZATION', 'Wittekindshof');
		$this->container->setAttribute('POSTAL_CODE', '32547');
		$this->container->setAttribute('STREET_ADDRESS', 'Schulstrasse 4');

		$this->assertEquals(
			$this->container->formatAddress(),
			"Eberhard Wellhausen\nWittekindshof\nSchulstrasse 4\n32547 Oyenhausen"
		);
    }
}