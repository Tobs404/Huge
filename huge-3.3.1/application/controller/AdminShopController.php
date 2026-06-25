<?php

class AdminShopController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAdminAuthentication();
    }

    public function index()
    {
        $this->View->render('adminshop/index', array(
                'items' => shopModel::getItems())
        );
    }

    public function removeItem($id){
        AdminShopModel::deleteItemFromDatabase($id);
        Session::add('feedback_positive', 'Item removed from shop.');
        header("Location: " . Config::get('URL') . "adminshop");
        exit();
    }

   public function additem()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AdminShopModel::UploadImage();
        }

        $this->View->render('adminshop/addItem');
    }
}
