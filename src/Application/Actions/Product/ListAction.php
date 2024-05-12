<?php
declare(strict_types=1);

namespace App\Application\Actions\Product;

use App\Application\Actions\Product\AutoGen\ProductAction;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

#[FastRoute('GET')]
class ListAction extends ProductAction
{	
    protected function action(): Response
    {	
		if (!empty($this->args)) {
			throw new DomainRecordNotFoundException('Request is invalid.');
		}

		$data = $this->repository->findAll();
        $this->logger->info("Product list was viewed.");
		
		//if (!isAPI) {
			return $this->render('home.twig', ['data' => $data]);
		//}
		
        return $this->respondWithData($data);
    }
}
