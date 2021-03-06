<?php

namespace TheFehr\Lighthouse\Rules;

use Artisan;
use Log;
use Illuminate\Contracts\Validation\Rule;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use October\Rain\Exception\ValidationException;
use Config;
use TheFehr\Lighthouse\Classes\SchemaBuilder;

use GraphQL\Type\Schema;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher as EventsDispatcher;
use Nuwave\Lighthouse\Events\ValidateSchema;
use Nuwave\Lighthouse\Schema\AST\ASTCache;
use Nuwave\Lighthouse\Schema\DirectiveLocator;
use Nuwave\Lighthouse\Schema\Factories\DirectiveFactory;
use Nuwave\Lighthouse\Schema\FallbackTypeNodeConverter;
use Nuwave\Lighthouse\Schema\TypeRegistry;

class ValidSchema implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws ValidationException
     */
    public function passes($attribute, $value)
    {
        Artisan::call('lighthouse:validate-schema');
        return true;
    }

    /**
     * Validation callback method.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $params
     * @return bool
     * @throws ValidationException
     */
    public function validate($attribute, $value, $params)
    {
        $valid = false;
        $validFilePath = Config::get('thefehr.lighthouse::schema.register');
        $validFileBackupPath = $validFilePath . ".valid";

        $changeSchemaId = $params[0];
        try {
            SchemaBuilder::validationBuild($changeSchemaId, $value);
            $valid = $this->passes($attribute, $value);
        } catch (DefinitionException $definitionException) {
            throw new ValidationException(
                [
                $attribute => "The defined schema is not valid:\n" . $definitionException->getMessage()
                ]
            );
        }

        return $valid;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The defined schema is not valid";
    }
}
