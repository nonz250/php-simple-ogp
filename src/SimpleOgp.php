<?php
declare(strict_types=1);

namespace SimpleOgp;

use DOMDocument;
use DOMXPath;
use RuntimeException;

class SimpleOgp implements SimpleOgpInterface
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private string $html;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var string
     */
    private string $imagePath;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return SimpleOgp
     */
    public function getHtml(): self
    {
        if (!($html = file_get_contents($this->url))) {
            throw new RuntimeException('Failed to retrieve website content.');
        }
        $this->html = $html;

        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($dom);
        $image = $xpath->query('//meta[@property="og:image"]/@content');
        $this->imagePath = (string)$image[0]->value ?? '';
        $title = $xpath->query('//meta[@property="og:title"]/@content');
        $this->title = (string)$title[0]->value ?? '';
        $description = $xpath->query('//meta[@property="og:description"]/@content');
        $this->description = (string)$description[0]->value ?? $title . 'を見る';
        if (mb_strlen($this->description) > 100) {
            $this->description = mb_substr($this->description, 0, 100) . '...';
        }
        return $this;
    }

    /**
     * @return string
     */
    public function html(): string
    {
        return $this->html;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function imagePath(): string
    {
        return $this->imagePath;
    }
}
