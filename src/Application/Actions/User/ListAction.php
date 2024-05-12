<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\User\AutoGen\UserAction;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

#[FastRoute('GET')]
class ListAction extends UserAction
{	
    protected function action(): Response
    {
		//if (!isAPI) {
		//	return $this->render('home.twig', []);
		//}
		
		if (!empty($this->args)) {
			throw new DomainRecordNotFoundException('Request is invalid.');
		}		
        $data = $this->repository->findAll();
        $this->logger->info("User list was viewed.");
        return $this->respondWithData($data);
    }
}
