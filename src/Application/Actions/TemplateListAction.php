<?php
declare(strict_types=1);

namespace App\Application\Actions\#TPL_PRODUCT#;

use App\Application\Actions\#TPL_PRODUCT#\AutoGen\#TPL_PRODUCT#Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

#[FastRoute('GET')]
class ListAction extends #TPL_PRODUCT#Action
{	
    protected function action(): Response
    {	
		if (!empty($this->args)) {
			throw new DomainRecordNotFoundException('Request is invalid.');
		}

		$data = $this->repository->findAll();
        $this->logger->info("#TPL_PRODUCT# list was viewed.");
		
		//if (!isAPI) {
			return $this->render('home.twig', ['data' => $data]);
		//}
		
        return $this->respondWithData($data);
    }
}
