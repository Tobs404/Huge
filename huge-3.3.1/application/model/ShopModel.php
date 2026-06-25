<?php

class ShopModel
{
    private static function getSessionBasket()
    {
        $basket = Session::get('basket');
        if (!is_array($basket)) {
            $basket = [];
            Session::set('basket', $basket);
        }
        return $basket;
    }

    private static function setSessionBasket($basket)
    {
        Session::set('basket', array_values($basket));
    }

    public static function getItems(){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL getShopItems";
        $query = $database->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        return $result;
    }

    public static function toBasket($id){
        $basket = self::getSessionBasket();
        $basket[] = $id;
        self::setSessionBasket($basket);
        return $basket;
    }

    public static function calculateTotal($items){

        if($items == []){
            return 0;
        }

        $total = 5;

        foreach($items as $item){
            $total = $total + $item->price;
        }

        return $total;
    }

    public static function removeFromBasket($id)
    {
        $basket = self::getSessionBasket();
        foreach ($basket as $key => $basketID) {
            if ($id == $basketID) {
                unset($basket[$key]);
            }
        }
        self::setSessionBasket($basket);
    }

    public static function getBasketItems(){
        $database = DatabaseFactory::getFactory()->getConnection();
        $fetchBasket = [];
        $basket = self::getSessionBasket();
        foreach ($basket as $id) {
            $sql = "CALL getBasketItem(:id)";
            $query = $database->prepare($sql);
            $query->execute([':id' => $id]);

            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result) {
                $fetchBasket[] = $result;
            }
        }

        return $fetchBasket;
    }

    public static function submitOrder($items, $total){
        $database = DatabaseFactory::getFactory()->getConnection();

        $userID = Session::get('user_id');

        $sql = "INSERT INTO openorders (customer, orderStatus, price)
            VALUES (:userID, :orderStatus, :price)";

        $query = $database->prepare($sql);

        $query->execute([
            ":userID" => $userID,
            ":orderStatus" => "Pending",
            ":price" => $total
        ]);

        $orderID = $database->lastInsertId();

        foreach ($items as $item) {
            $sql="CALL addOrderItem(:orderID, :itemID)";
            $query=$database->prepare($sql);
            $query->execute([
                ":orderID"=>$orderID,
                ":itemID"=>$item->id
            ]);
        }

        self::setSessionBasket([]);
    }
}
