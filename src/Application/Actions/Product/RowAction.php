<?php
declare(strict_types=1);

namespace App\Application\Actions\Product;


use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

#[FastRoute('GET', '{id}')]
class RowAction extends AutoGen\ProductAction
{
    protected function action(): Response
    {
		if (empty($this->args) || count($this->args)>1) {
			throw new DomainRecordNotFoundException('Request is invalid.');
		}
	
        $rId = (int) $this->resolveArg('id');		
        $row = $this->repository->findById($rId);
        $this->logger->info("Product of row id `{$rId}` was viewed.");


		//if (!isAPI) {
//			return $this->render('home.twig', ['data' => $row]);
		//}
		
        return $this->respondWithData($row);
    }
}
