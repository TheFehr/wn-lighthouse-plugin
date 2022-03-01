<?php namespace TheFehr\Lighthouse\Models;

use Config;
use Model;
use Input;
use TheFehr\Lighthouse\Rules\ValidSchema;
use Validator;
use Log;
use TheFehr\Lighthouse\Classes\SchemaBuilder;

/**
 * Model
 */
class Schema extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'thefehr_lighthouse_schemes';

    /**
     * @var array Validation rules
     */
    public $rules = [];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    protected function beforeValidate()
    {
        $model = $this;

        // if ($model->published) {
        //     Log::info("Validating schema");
        //     Validator::extend('schemaValid', function ($attribute, $value) use ($model) {
        //         return (new ValidSchema())->validate($attribute, $value, [$model->id]);
        //     });
        //     $this->rules['schema'] = 'schemaValid';
        // }
    }
}
