<?php
declare(strict_types=1);

namespace SimpleOgp;

interface SimpleOgpInterface
{
    /**
     * @return SimpleOgpInterface
     */
    public function getHtml(): self;

    /**
     * @return string
     */
    public function html(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
     */
    public function description(): string;

    /**
     * @return string
     */
    public function imagePath(): string;

    /**
     * @return string
     */
    public function url(): string;
}
