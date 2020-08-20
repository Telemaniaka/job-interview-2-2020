<?php

namespace Recruitment\MailTask\Tests\Service;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Recruitment\MailTask\Service\StaticFileConfig;

class StaticFileConfigTest extends TestCase
{

    private $file_system;

    public function setUp()
    {
        $directory = [
            'config.php' => '<?php
                return [
                    \'category\' => [
                        \'sub-category1\' => [
                            \'array1\' => [
                                \'key1\' => 1,
                                \'key2\' => 2,
                            ],
                            \'array2\' => [
                                \'key1\' => 3,
                                \'key2\' => 4,
                                \'key3\' => 5,
                            ]
                        ],
                        \'sub-category2\' => [
                            \'array1\' => [
                                \'key1\' => 6,
                                \'key2\' => 7,
                            ],
                            \'array2\' => [
                                \'key3\' => 8,
                                \'key4\' => 9,
                            ]
                
                        ]
                    ]
                ];',
        ];
        // setup and cache the virtual file system
        $this->file_system = vfsStream::setup('root', 444, $directory);
    }

    public function testThrowExceptionOnNonExistingFile()
    {
        $this->expectExceptionMessage('Config File Not Found');
        new StaticFileConfig('NonExistingFile.php');
    }

    public function testConfigGetsInitialised()
    {
        $config = new StaticFileConfig($this->file_system->url() . '/config.php');
        $this->assertNotNull($config);
    }

    /**
     * @dataProvider dataProviderConfigArrayTesting
     */
    public function testConfigReturnsCorrectValueArray($configKey, $expectedValue)
    {
        $config = new StaticFileConfig($this->file_system->url() . '/config.php');

        $this->assertEquals($expectedValue, $config->getArray($configKey));
    }

    /**
     * @dataProvider dataProviderConfigSingleValueTesting
     */
    public function testConfigReturnsCorrectValueString($configKey, $expectedValue)
    {
        $config = new StaticFileConfig($this->file_system->url() . '/config.php');

        $this->assertEquals($expectedValue, $config->getSingleValue($configKey));
    }

    public function testThrowExceptionOnGettingArrayWithSingleValueMethod()
    {
        $config = new StaticFileConfig($this->file_system->url() . '/config.php');

        $configKey = 'category.sub-category2.array1';
        $this->expectExceptionMessage('Config Variable '.$configKey.' is array');
        $config->getSingleValue($configKey);

    }


    public function dataProviderConfigArrayTesting(): array
    {
        return [
            'return operation commission rates' => ['category.sub-category1.array1', ['key1' => 1, 'key2' => 2]],
            'return null on missing key' => ['category.sub-category3.array1', []],
        ];
    }

    public function dataProviderConfigSingleValueTesting(): array
    {
        return [
            'return exact value'   => ['category.sub-category1.array1.key2', '2'],
            'return null on missing key' => ['category.sub-category3.array1.key1', ''],
        ];
    }

}
