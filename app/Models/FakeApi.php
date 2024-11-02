<?php

namespace App\Models;

class FakeApi
{   
    /**
     * Бронируем заказ
     *
     * @param int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity, int $ticket_kid_price, int $ticket_kid_quantity, int $ticket_benefit_price, int $ticket_benefit_quantity, int $ticket_group_price, int $ticket_group_quantity, int $barcode
     * @return json
     */
    public function BookingOrder(int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity, int $ticket_kid_price, int $ticket_kid_quantity, int $ticket_benefit_price, int $ticket_benefit_quantity, int $ticket_group_price, int $ticket_group_quantity, int $barcode)
    {   
        $random = rand(1, 2);
        
        if($random == 1){
            $info = [
                'message' => 'order successfully booked',
            ];
        }
        if($random == 2){
            $info = [
                'error' => 'barcode already exists',
            ];
        }
        
        return json_encode($info);
    }  
    
    /**
     * Утверждаем заказ
     *
     * @param int $barcode
     * @return json
     */
    public function ApproveOrder(int $barcode)
    {   
        $random = rand(1, 2);
        
        if($random == 1){
            $info = [
                'message' => 'order successfully aproved',
            ];
        }
        if($random == 2){
            $option = rand(1, 4);
                if($option == 1){
                    $error = 'event cancelled';
                }
                if($option == 2){
                    $error = 'no tickets';
                }
                if($option == 3){
                    $error = 'no seats';
                }
                if($option == 4){
                    $error = 'fan removed';
                }
            $info = [
                'error' => $error,
            ];
        }
        
        return json_encode($info);
    }  
}

