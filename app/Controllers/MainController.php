<?php
namespace Controllers;
use Model\Product;

class MainController
{
//    private Product $productModel;
//    public function __construct()
//    {
//        $this->productModel = new Product();
//    }
public function main()
{
    session_start();
    if(isset($_SESSION['user_id'])){
        if (isset($_SESSION['user_id'])) {

            $products = Product::getAll();
            require_once './Views/main.phtml';
        }

        http_response_code(403);
    } else {
        header('Location: /login');
    }

}
}