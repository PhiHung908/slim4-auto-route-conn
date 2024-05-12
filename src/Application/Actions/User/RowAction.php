<?php
declare(strict_types=1);

namespace App\Application\Actions\User;


use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

#[FastRoute('GET', '{id}')]
class RowAction extends AutoGen\UserAction
{
    protected function action(): Response
    {
		//if (!isAPI) {
//			return $this->render('home.twig', []);
		//}
		
		if (empty($this->args) || count($this->args)>1) {
			throw new DomainRecordNotFoundException('Request is invalid.');
		}
	
        $rId = (int) $this->resolveArg('id');
		
        $row = $this->repository->findById($rId);
		
        $this->logger->info("User of row id `{$rId}` was viewed.");

        return $this->respondWithData($row);
    }
}
