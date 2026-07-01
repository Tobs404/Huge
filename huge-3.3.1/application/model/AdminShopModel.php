<?php

/**
 * Handles all data manipulation of the admin part
 */
class AdminShopModel
{
     public static function UploadImage()
    {
        $path = dirname(__DIR__, 2) . "/public/shopImages/";

        if (!isset($_FILES['datei'])) {
            Session::add('feedback_negative', 'Keine Datei übermittelt.');
            return false;
        }

        if ($_FILES['datei']['error'] !== UPLOAD_ERR_OK) {
            Session::add('feedback_negative', 'Upload fehlgeschlagen.');
            return false;
        }

        if ($_FILES['datei']['size'] > 5 * 1024 * 1024) {
            Session::add('feedback_negative', 'Datei zu groß.');
            return false;
        }

        $mime = mime_content_type($_FILES['datei']['tmp_name']);

        $allowed = [
            'image/jpeg',
            'image/png'
        ];

        if (!in_array($mime, $allowed)) {
            Session::add('feedback_negative', 'Dateityp nicht erlaubt.');
            return false;
        }

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $filename = basename($_FILES['datei']['name']);

        $target = $path . $filename;

        if (move_uploaded_file($_FILES['datei']['tmp_name'], $target)) {

            $name = $_POST["name"];
            $description = $_POST["description"];
            $price = $_POST["price"];

            self::SaveToDatabase($filename,$name,$description,$price);

            Session::add(
                'feedback_positive',
                'Datei erfolgreich hochgeladen.'
            );

            return true;
        }

        Session::add(
            'feedback_negative',
            'Datei konnte nicht gespeichert werden.'
        );

        return false;
    }

    private static function SaveToDatabase($filename, $name, $description, $price)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL createItem(:i_name, :i_price, :i_sale, :i_description, :i_imageName)";
        $query = $database->prepare($sql);
        
        $query->execute(array(
            ':i_name' => $name,
            ':i_price' => $price,
            ':i_sale' => 0,
            ':i_description' => $description,
            ':i_imageName' => $filename
        ));
    }

    public static function deleteItemFromDatabase($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        
        $sql = "CALL getImageName(:i_id)";
        $query = $database->prepare($sql);
        
        $query->execute(array(
            ':i_id' => $id
        ));

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $filename = $result['imageName'] ?? null;

        $path = dirname(__DIR__, 2) . "/public/shopImages/";
        $filename = $path . $filename;

        unlink($filename);

        $sql = "CALL deleteItem(:i_id)";
        $query = $database->prepare($sql);
        
        $query->execute(array(
            ':i_id' => $id
        ));
    }

    public static function getOrders(){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "CALL getOrders()";
        $query = $database->prepare($sql);

        $query->execute();

        $orders = $query->fetchAll();
        return $orders;
    }

    public static function UpdateOrderStatus($id, $status){
        $database = DatabaseFactory::getFactory()->getConnection();

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $sql = "CALL updateOrderStatus(:i_id, :i_status)";
        $query = $database->prepare($sql);

        $query->execute(array(
            ':i_id' => $id,
            ':i_status' => $status
        ));
    }
}
