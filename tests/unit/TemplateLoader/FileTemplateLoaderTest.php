<?php

namespace tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\CoversClass;
use Jasmin\TemplateEngine\TemplateLoader\FileTemplateLoader;

#[CoversClass(FileTemplateLoader::class)]
final class FileTemplateLoaderTest extends TestCase
{
    public function testFtlThrowsExceptionWhenPathNotSpecified(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $ftl = new FileTemplateLoader("");
    }

    public function testFtlProcessesPath(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $this->assertEquals(dirname(__DIR__, 2) . '/templates', $ftl->getTemplatePath());
    }

    public function testFtlLoadsFileWithExtension(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/index.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('index.jasmin.php'));
    }

    public function testFtlLoadsFileWithoutExtension(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/index.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('index'));
    }


    public function testFtlLoadsFileWithExtensionLongPath(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/partials/simple-include.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('partials.simple-include.jasmin.php'));
    }

    public function testFtlLoadsFileWithoutExtensionLongPath(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/partials/simple-include.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('partials.simple-include'));
    }

    public function testFtlLoadsFileWithExtensionEvenLongerPath(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/partials/even-more-partials/simple-include-2.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('partials.even-more-partials.simple-include-2.jasmin.php'));
    }

    public function testFtlLoadsFileWithoutExtensionEvenLongerPath(): void
    {
        $ftl = new FileTemplateLoader(dirname(__DIR__, 2) . '/templates');
        $testTemplatePath = dirname(__DIR__, 2) . '/templates/partials/even-more-partials/simple-include-2.jasmin.php';
        $this->assertEquals($testTemplatePath, $ftl->toRealPath('partials.even-more-partials.simple-include-2'));
    }
}
