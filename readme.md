## Slim4-Mod auto-route

**Tác giả:** Phi Hùng - vmkeyb908@gmail.com - (VN) 0974 471 724

---

Slim4-Mod bổ sung auto-route và connect-db - sử dụng như MVC với Twig view - tích hợp SlimAsset, nó giữ nguyên cấu trúc thư mục của slim4 gốc
nhưng đã hiệu chỉnh một số file mẫu.


Các bổ sung và hiệu chỉnh là tối thiểu dể bạn có thể sử dụng slim4 tương tự như các framework-MVC thông dụng.

>
>*Đặc biệt:* Nó sẽ nạp các route với tính chất động (dynamic) mỗi khi người dùng gõ vào một URL nào đó. Do vậy hệ thống sẽ hoạt động nhanh và ít tốn bộ nhớ vì không mất qui trình "init" chưa cần dùng đến.   
>

---

**Cài đặt:**

```markdown

composer require slim4-mod/auto-route-conn "dev-master"

```

##### Cách sử dụng:

>
>Dùng tiện ích dòng lệnh để tự động tạo cấu trúc file cần thiết cho model mới (NEW_MODEL).
>
> ```
> new-model <tên_model_mới>
> ```
>
>Sau khi chạy tiện ích xong bạn có thể gõ 'localhost/newModel' vào trình duyệt để thử ngay.
>
>Muốn tham khảo đủ tính năng, bạn cần làm 2 việc chính để sử dụng như MVC-framework:
>
>* 1- Đến thư mục src/domain/NEW_MODEL và thiết kế bổ sung ORM cho file NEW_MODEL.php
>
>* 2- Tạo bảng tương thích với NEW_MODEL.
>
> Bạn không cần phải quan tâm đến router, chỉ code các action (Đến thư mục src/application/actions/NEW_MODEL để thiết kế các action, các setup route cho từng action sẽ được đặt ngay trước class như trong mẫu) cho từng model và đặt tên như qui định ở dưới.
>

* Qui định bắt buộc:
	- Cấu trúc thư mục như slim4 gốc (xem mẫu model Product)
	- Tên các chức năng của Product phải có chữ đầu tiên là viết in hoa và nối phía sau là Action (ex: ListAction.php, RowAction.php, ...)

*Chạy thử:* Bạn có thể gõ các địa chỉ thử nghiệm như dưới.

* Liệt kê toàn bộ bảng product:
	- localhost/product/list
		
* Xem thông tin một hảng (có id=2):
	- localhost/product/row/2
		
* Xem product/index:
	- localhost/product
	
* v.v...

##### Cấu hình:

* **Chèn vào \public\index.php:**
	
	- Khai báo thêm use:
		
		> 
		> use \Invoker\CallableResolver as InvokerCallableResolver;
		> use Slim\Interfaces\CallableResolverInterface;
		>

	- Chèn kết nối database: (sau đoạn)

		>
		> // Set up repositories
		> $repositories = require __DIR__ . '/../app/repositories.php';
		> $repositories($containerBuilder);
		>

		```
		
		// Set up PDO and doctrine-entity
		$diConn = require __DIR__ . '/../app/di-conn.php';
		$diConn($containerBuilder);


		```

	- Chèn DI-Bridge (Không dùng slim-bridge vì lỗi với tham số url): (thay thế sau đoạn)

		>
		> // Instantiate the app
		> //from... AppFactory::setContainer($container);
		> //from... $app = AppFactory::create();
		>
		
		```
		
		$container->set(CallableResolverInterface::class, new InvokerCallableResolver($container)); //??
		$app = AppFactory::createFromContainer($container);
		$container->set(App::class, $app);

		```
		
* **Sửa đổi \App\Settings\route.php:**

	- Chèn auto-route: (sau đoạn)

	>
	> $app->options('/{routes:.*}', function (Request $request, Response $response) {
	>	// CORS Pre-Flight OPTIONS Request Handler
	>	return $response;
	> });
	>
	
	*Ghi chú:* Có thể rào lại toàn bộ $app->get(...) của bản gốc và chỉ dùng duy nhất 1 cấu hình route như dưới.

	```
	
	$autoController = require  '..\src\Base\AutoController.php';
	$aUri = explode('/',$_SERVER['REQUEST_URI'] . '/');
	$autoController($app, $aUri[1], $aUri[2]);
	
	
	```

>
> *Chú thich:* Các tính năng đang trong quá trình thiết kế do vậy cần sự đóng góp của mọi người. Thanks!
>

*Tác giả: Phi-Hùng - vmkeyb908@gmail.com - Readme v.1.0*