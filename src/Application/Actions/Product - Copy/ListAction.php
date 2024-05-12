<?php
declare(strict_types=1);

namespace App\Application\Actions\Product;

use App\Application\Actions\Product\AutoGen\ProductAction;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;

#[FastRoute('GET')]
class ListAction extends ProductAction
{	
	public function __construct(LoggerInterface $logger, ContainerInterface $c) {
		parent::__construct($logger, $c);
	}

    protected function action(): Response
    {
		//if (!isAPI) {
			return $this->render('home.twig', []);
		//}
		
		if (!empty($this->args)) {
			throw new DomainRecordNotFoundException('Request is invalid.');
		}		
        $data = $this->repository->findAll();
        $this->logger->info("Product list was viewed.");
        return $this->respondWithData($data);
    }
}
