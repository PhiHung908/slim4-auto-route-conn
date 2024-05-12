<?php
declare(strict_types=1);

namespace App\Application\Actions\#TPL_PRODUCT#;


use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

#[FastRoute('GET', '{id}')]
class RowAction extends AutoGen\#TPL_PRODUCT#Action
{
    protected function action(): Response
    {
		if (empty($this->args) || count($this->args)>1) {
			throw new DomainRecordNotFoundException('Request is invalid.');
		}
	
        $rId = (int) $this->resolveArg('id');		
        $row = $this->repository->findById($rId);
        $this->logger->info("#TPL_PRODUCT# of row id `{$rId}` was viewed.");


		//if (!isAPI) {
//			return $this->render('home.twig', ['data' => $row]);
		//}
		
        return $this->respondWithData($row);
    }
}
