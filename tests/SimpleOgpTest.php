<?php
declare(strict_types=1);

namespace Tests;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use SimpleOgp\SimpleOgp;
use PHPUnit\Framework\TestCase;
use SimpleOgp\SimpleOgpInterface;

class SimpleOgpTest extends TestCase
{
    /**
     * @var string
     */
    private string $nonLabo = 'https://labo.nozomi.bike';

    /**
     * @return SimpleOgpInterface
     */
    public function test__construct(): SimpleOgpInterface
    {
        $simpleOgp = new SimpleOgp($this->nonLabo);
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
    public function testHtml(SimpleOgpInterface $simpleOgp): void
    {
        $this->assertNotSame('', $simpleOgp->html());
    }

    /**
     * @depends testGetHtml
     * @param SimpleOgpInterface $simpleOgp
     */
    public function testTitle(SimpleOgpInterface $simpleOgp): void
    {
        $this->assertNotSame('', $simpleOgp->title());
    }

    /**
     * @depends testGetHtml
     * @param SimpleOgpInterface $simpleOgp
     */
    public function testDescription(SimpleOgpInterface $simpleOgp): void
    {
        $this->assertNotSame('', $simpleOgp->description());
    }

    /**
     * @depends testGetHtml
     * @param SimpleOgpInterface $simpleOgp
     */
    public function testImagePath(SimpleOgpInterface $simpleOgp): void
    {
        $this->assertNotSame('', $simpleOgp->imagePath());
    }

    /**
     * @depends testGetHtml
     * @param SimpleOgpInterface $simpleOgp
     */
    public function testUrl(SimpleOgpInterface $simpleOgp): void
    {
        $this->assertSame($this->nonLabo, $simpleOgp->url());
    }

    /**
     * @return void
     */
    public function testEmptyUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new SimpleOgp('');
    }

    /**
     * @return void
     */
    public function testNoContent(): void
    {
        $exampleUrl = 'https://example.com';
        $example = new SimpleOgp($exampleUrl);
        $example->getHtml();
        $this->assertNotSame('', $example->html());
        $this->assertSame($exampleUrl, $example->url());
        $this->assertSame('', $example->description());
        $this->assertSame('', $example->title());
        $this->assertSame('', $example->imagePath());
    }
}
