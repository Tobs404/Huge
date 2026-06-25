<?php

/**
 * The note controller: Just an example of simple create, read, update and delete (CRUD) actions.
 */
class ShopController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

    public function index()
    {
        $result = ShopModel::getItems();
        $this->View->render('Shop/index', [
                'items' => $result
            ]);
    }

    public function toBasket($id){
        ShopModel::toBasket($id);
        Session::add('feedback_positive', 'Item added to cart!');
        header("Location: " . Config::get('URL') . "shop");
        exit();
    }
}
