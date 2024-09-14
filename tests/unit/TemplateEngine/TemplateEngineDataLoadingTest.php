<?php

namespace tests;

use Jasmin\TemplateEngine\TemplateEngine\TemplateEngine;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TemplateEngine::class)]
final class TemplateEngineDataLoadingTest extends TestCase
{
    public function testTECanLoadGlobalData(): void
    {
        $templater = new TemplateEngine(dirname(__DIR__, 2) . '/templates', dirname(__DIR__, 2) . '/cache');

        $templater->addGlobalVar('user', 'example@test.com');

        $render = $templater->render('index-data');

        $this->assertEquals('example@test.com', $render);
    }
}
