<?php

namespace Recruitment\MailTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Recruitment\MailTask\Service\Validator;

class ValidatorTest extends TestCase
{

    /**
     * @dataProvider dataProviderValidatorTesting
     */
    public function testValidatorReturnsCorrectData($postData, $validatorRules, $expectedResult)
    {
        $validator = new Validator($validatorRules, $postData);

        if ($expectedResult[0] === 'error') {
            $this->assertTrue($validator->hasErrors());
            $this->assertEquals($expectedResult[1], $validator->getErrors());
        } else {
            $this->assertEquals($expectedResult[1], $validator->getData());
        }

    }

    public function dataProviderValidatorTesting(): array
    {
        return [
            "empty" => [
                ['text'=> ''],
                [['text', 'emailType']],
                ['error', ['text'=> 'Cannot be empty']]
            ],
            "wrong email" => [
                ['text'=> 'jan@test'],
                [['text', 'emailType']],
                ['error', ['text'=> 'Not a valid Email']]
            ],
            "correct email" => [
                ['text'=> 'jan@test.com'],
                [['text', 'emailType']],
                ['success', ['text'=> 'jan@test.com']]
            ],
            "strip tags" => [
                ['text'=> '<span>test</span>'],
                [['text', 'plainEmailBodyType']],
                ['success', ['text'=> 'test']]
            ],
            "add Slashes" => [
                ['text'=> "Brian O'Conner"],
                [['text', 'plainTextType']],
                ['success', ['text'=> 'Brian O\\\'Conner']]
            ],
        ];
    }

}
