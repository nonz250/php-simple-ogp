<?php
declare(strict_types=1);

namespace Tests;

use ReflectionClass;
use ReflectionException;
use SimpleOgp\SimpleOgp;
use PHPUnit\Framework\TestCase;
use SimpleOgp\SimpleOgpInterface;

class SimpleOgpTest extends TestCase
{
    /**
     * @return SimpleOgpInterface
     */
    public function test__construct(): SimpleOgpInterface
    {
        $nonLabo = 'https://labo.nozomi.bike';
        $simpleOgp = new SimpleOgp($nonLabo);
        $this->assertInstanceOf(SimpleOgpInterface::class, $simpleOgp);
        return $simpleOgp;
    }

    /**
     * @depends test__construct
     * @param SimpleOgpInterface $simpleOgp
     * @throws ReflectionException
     * @return SimpleOgpInterface
     */
    public function testGetHtml(SimpleOgpInterface $simpleOgp): SimpleOgpInterface
    {
        $simpleOgp->getHtml();
        $reflectionClass = new ReflectionClass($simpleOgp);
        $property = $reflectionClass->getProperty('html');
        $property->setAccessible(true);
        $html = $property->getValue($simpleOgp);
        $this->assertStringContainsString('<!DOCTYPE html>', $html);
        return $simpleOgp;
    }

    /**
     * @depends testGetHtml
     * @param SimpleOgpInterface $simpleOgp
     */
    public function testHtml(SimpleOgpInterface $simpleOgp)
    {
        $this->assertTrue(mb_strlen($simpleOgp->html()) > 0);
    }

    /**
     * @depends testGetHtml
     * @param SimpleOgpInterface $simpleOgp
     */
    public function testTitle(SimpleOgpInterface $simpleOgp)
    {
        $this->assertTrue(mb_strlen($simpleOgp->title()) > 0);
    }

    /**
     * @depends testGetHtml
     * @param SimpleOgpInterface $simpleOgp
     */
    public function testDescription(SimpleOgpInterface $simpleOgp)
    {
        $this->assertTrue(mb_strlen($simpleOgp->description()) > 0);
    }

    /**
     * @depends testGetHtml
     * @param SimpleOgpInterface $simpleOgp
     */
    public function testImagePath(SimpleOgpInterface $simpleOgp)
    {
        $this->assertTrue(mb_strlen($simpleOgp->imagePath()) > 0);
    }
}
