<?php
declare(strict_types=1);

namespace App\Application\Actions\User;


use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

#[FastRoute('GET')]
class IndexAction extends AutoGen\UserAction
{
	protected function Action(): Response
    {
		//if (!isAPI) {
//			return $this->render('home.twig', []);
		//}
		$this->response->getBody()->write('For Default User IndexAction');
		return $this->response;
	}
}
