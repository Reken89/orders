<?php

namespace App\Models;

use App\Models\ConnectDB;
use PDO;

class OrderModel extends ConnectDB
{
    /**
     * Выполняем запись в таблицу orders
     * Возвращаем id последней записи
     *
     * @param int $event_id, string $event_date, int $equal_price, string $created
     * @return int
     */
    public function AddOrder(int $event_id, string $event_date, int $equal_price, string $created): int
    {   
        $sql = "INSERT INTO orders (event_id, event_date, equal_price, created) VALUES "
                . "(:event_id, :event_date, :equal_price, :created)";               
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":event_id", $event_id, PDO::PARAM_STR);
        $stmt->bindValue(":event_date", $event_date, PDO::PARAM_STR);
        $stmt->bindValue(":equal_price", $equal_price, PDO::PARAM_STR);
        $stmt->bindValue(":created", $created, PDO::PARAM_STR);
        $stmt->execute();   
        return $this->db->lastInsertId(); 
    }  
    
    /**
     * Обновляем сумму equal_price 
     * Прибавляем стоимость билета
     *
     * @param int $order_id, int $price
     * @return bool
     */
    public function UpdatePrice(int $order_id, int $price): bool
    {   
        $sql = "UPDATE orders SET equal_price = `equal_price` + :price WHERE id = $order_id";               
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        $stmt->execute();   
        return $stmt->rowCount() > 0 ? true : false;  
    }  
    
    /**
     * Удаляем заказ
     *
     * @param int $id
     * @return bool
     */
    public function DeleteOrder(int $id): bool
    {   
        $sql = "DELETE FROM orders WHERE id = $id";               
        $stmt = $this->db->prepare($sql);
        $stmt->execute();   
        return true;
    } 

}
