<?php
declare(strict_types=1);

namespace App\Application\Actions\#TPL_PRODUCT#;


use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\DomainException\DomainRecordNotFoundException;

#[FastRoute('GET')]
class IndexAction extends AutoGen\#TPL_PRODUCT#Action
{
	protected function Action(): Response
    {
		//if (!isAPI) {
//			return $this->render('home.twig', []);
		//}
		
		$this->response->getBody()->write('<br><h3>Welcome... Default page for <span style="color:red">#TPL_PRODUCT#</span>-Model</h3>');
		$this->response->getBody()->write('<br><br>Đây là nội dung của file IndexAction.php trong thư mục <b>' . __DIR__ . '</b><br><br>');
		$this->response->getBody()->write('Hãy vào đó để chỉnh sửa và bổ sung các sự kiện theo nhu cầu của bạn.');
		
		return $this->response;
	}
}
