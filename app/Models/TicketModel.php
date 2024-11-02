<?php

namespace App\Models;

use App\Models\ConnectDB;
use PDO;

class TicketModel extends ConnectDB
{
    /**
     * Выполняем запись в таблицу tickets
     *
     * @param int $eorder_id, string $type, int $price, int $barcode
     * @return bool
     */
    public function AddTicket(int $order_id, string $type, int $price, int $barcode)
    {   
        $sql = "INSERT INTO tickets (order_id, type, price, barcode) VALUES "
                . "(:order_id, :type, :price, :barcode)";               
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":order_id", $order_id, PDO::PARAM_STR);
        $stmt->bindValue(":type", $type, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        $stmt->bindValue(":barcode", $barcode, PDO::PARAM_STR);
        $stmt->execute();   
        return $stmt->rowCount() > 0 ? true : false;  
    }  
    
    /**
     * Выполняем поиск билета по barcode
     *
     * @param int $barcode
     * @return bool
     */
    public function SelectTicket(int $barcode)
    {   
        $sql = "SELECT * FROM tickets WHERE barcode = :barcode";             
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":barcode", $barcode, PDO::PARAM_STR);
        $stmt->execute();      
        return $stmt->rowCount() > 0 ? true : false;  
    }  
    
    /**
     * Выполняем поиск билета по order_id
     *
     * @param int $order_id
     * @return bool
     */
    public function FindTicket(int $order_id)
    {   
        $sql = "SELECT * FROM tickets WHERE order_id = $order_id";             
        $stmt = $this->db->prepare($sql);
        $stmt->execute();      
        return $stmt->rowCount() > 0 ? true : false;  
    }  

}
