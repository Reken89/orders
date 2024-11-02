<?php

namespace App\Models;

use App\Models\FakeApi;

use App\Models\TicketModel;
use App\Models\OrderModel;

class AddTicket
{   
    /**
     * Обращение к FakeAPI (book)
     * Обращение к FakeAPI (approve)
     * Запись в таблицу tickets
     *
     * @param int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity, int $ticket_kid_price, int $ticket_kid_quantity, int $ticket_benefit_price, int $ticket_benefit_quantity, int $ticket_group_price, int $ticket_group_quantity, int $order_id, string $type
     * @return
     */
    public function AddTicket(int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity, int $ticket_kid_price, int $ticket_kid_quantity, int $ticket_benefit_price, int $ticket_benefit_quantity, int $ticket_group_price, int $ticket_group_quantity, int $order_id, string $type)
    {   
        //Определяем тип и стоимость билета
        if($type == "adult"){
            $tickets = $ticket_adult_quantity;
            $price = $ticket_adult_price;
        }
        if($type == "kid"){
            $tickets = $ticket_kid_quantity;
            $price = $ticket_kid_price;
        }
        if($type == "benefit"){
            $tickets = $ticket_benefit_quantity;
            $price = $ticket_benefit_price;
        }
        if($type == "group"){
            $tickets = $ticket_group_quantity;
            $price = $ticket_group_price;
        }
        
        $result = [];
        
        //Выпоняем проверку barcode для каждого билета
        for ($a = 1; $a <= $tickets; $a++) {
            //Обращение к FakeAPI (book)
            //Количество попыток 50
            //Если количество попыток превышает 50, завершаем попытки (API неисправен)
            for ($i= 1; $i < 50; $i++) {
                $barcode = mt_rand(11111111, 99999999);
                $ticket = new TicketModel();
                
                //Проверка на дубликат barcode в таблице tickets
                if($ticket->SelectTicket($barcode) !== true){
                    $info = new FakeApi();
                    $json = $info->BookingOrder($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $ticket_benefit_price, $ticket_benefit_quantity, $ticket_group_price, $ticket_group_quantity, $barcode);
                    $array = json_decode($json);
                    if(key($array) == "message"){
                        //Обращение к FakeAPI (book) пройдена успешно
                        //Обращение к FakeAPI (approve)
                        $examin = $info->ApproveOrder($barcode);
                        $examin = json_decode($examin);
                        if(key($examin) == "message"){
                            //Обращение к FakeAPI (approve) пройдена успешно
                            //Выполняем запись в таблицу tickets
                            //Прибавим сумму билета к заказу
                            $ticket->AddTicket($order_id, $type, $price, $barcode);
                            $order = new OrderModel();
                            $order->UpdatePrice($order_id, $price);
                            
                            //Собираем информацию о результате выполнения
                            $result[$barcode] = $examin;
                        }else{
                            $result[$barcode] = $examin;
                        }                  
                        break;
                    }                   
                }
            }                
        }       
        return $result;
    }  

}
