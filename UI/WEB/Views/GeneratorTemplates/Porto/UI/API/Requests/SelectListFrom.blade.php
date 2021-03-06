<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }};

use App\Ship\Parents\Requests\Request;

/**
 * Class {{ str_replace('.php', '', $gen->apiRequestFile('SelectListFrom')) }}.
 * 
 * @author [name] <[<email address>]>
 */
class {{ str_replace('.php', '', $gen->apiRequestFile('SelectListFrom')) }} extends Request
{
	/**
     * Define which Roles and/or Permissions has access to this request..
     *
     * @var  array
     */
    protected $access = [
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var  array
     */
    protected $decode = [
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var  array
     */
    protected $urlParameters = [
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @return  bool
     */
    public function authorize()
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
