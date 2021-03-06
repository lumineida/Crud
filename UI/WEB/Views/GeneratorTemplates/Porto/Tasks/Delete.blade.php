<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $repoClass = $gen->entityName().'Repository' }};
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $gen->taskClass('Delete') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->taskClass('Delete') }} extends Task
{
	public function run(int $id) {
        ${{ $camelEntity = camel_case($gen->entityName()) }} = app({{ $repoClass }}::class)->delete($id);
        return ${{ $camelEntity }};
	}
}
