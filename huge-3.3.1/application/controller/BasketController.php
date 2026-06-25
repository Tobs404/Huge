<?php

/**
 * The note controller: Just an example of simple create, read, update and delete (CRUD) actions.
 */
class BasketController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */

    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

    public function index(){
        $result = shopModel::getBasketItems();
        $this->View->render('Shop/basket', [
                'items' => $result
            ]);
    }

    public function loadCheckout(){
        $result = shopModel::getBasketItems();
        $total = shopModel::calculateTotal($result);
        $this->View->render('Shop/checkout', [
                'items' => $result,
                'total' => $total,
            ]);
    }

    public function removeFromBasket($id){
        shopModel::removeFromBasket($id);
        Session::add('feedback_positive', 'Item removed from cart.');
        header("Location: " . Config::get('URL') . "basket");
        exit();
    }

    public function submitOrder(){
        $items = shopModel::getBasketItems();
        $total = shopModel::calculateTotal($items);
        shopModel::submitOrder($items, $total);
        Session::add('feedback_positive', 'Order submitted successfully!');
        header("Location: " . Config::get('URL') . "basket");
        exit();
    }
}
