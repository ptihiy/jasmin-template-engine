<?php

namespace tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;

#[CoversClass(FileTemplateLoader::class)]
final class FileTemplateLoaderTest extends TestCase
{
    public function testFTLThrowsExceptionWhenPathNotSpecified(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $fileTemplateLoader = new FileTemplateLoader("");
    }

    public function testFileTemplateLoaderProcessesPath(): void
    {
        $fileTemplateLoader = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $this->assertEquals(dirname(__DIR__, 2) . '/templates', $fileTemplateLoader->getTemplatePath());
    }

    public function testFileTemplateLoaderLoadsFileWithExtension(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/index.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('index.jasmin.php'));
    }

    public function testFileTemplateLoaderLoadsFileWithoutExtension(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/index.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('index'));
    }


    public function testFileTemplateLoaderLoadsFileWithExtensionLongPath(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/partials/simple-include.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('partials.simple-include.jasmin.php'));
    }

    public function testFileTemplateLoaderLoadsFileWithoutExtensionLongPath(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/partials/simple-include.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('partials.simple-include'));
    }
}
