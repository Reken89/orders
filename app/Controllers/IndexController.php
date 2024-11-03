<?php

namespace App\Controllers;

use App\Models\AddTicket;
use App\Models\OrderModel;
use App\Models\TicketModel;

class IndexController
{   
     /**
     * Запись заказа в БД
     *
     * @param int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity, int $ticket_kid_price, int $ticket_kid_quantity, int $ticket_benefit_price, int $ticket_benefit_quantity, int $ticket_group_price, int $ticket_group_quantity
     * @return array
     */
    public function RecordInfo(int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity, int $ticket_kid_price, int $ticket_kid_quantity, int $ticket_benefit_price, int $ticket_benefit_quantity, int $ticket_group_price, int $ticket_group_quantity)
    {
        $tickets = new AddTicket();
        $order = new OrderModel();
              
        //Проверяем полученную информацию
        //При наличии билета из любой категории
        //Выполняем запись заказа в таблицу orders
        if($ticket_adult_quantity > 0 || $ticket_kid_quantity > 0 || $ticket_benefit_quantity > 0 || $ticket_group_quantity > 0){
            //Так как, некоторые билеты, могут быть отклонены после проверки по API
            //Изначально запишем общую сумму билетов равную 0
            $equal_price = 0;
            $created = date("Y-m-d H:i:s"); 
            $order_id = $order->AddOrder($event_id, $event_date, $equal_price, $created);           
        }
        
        //Запись взрослого билета в таблицу tickets
        if($ticket_adult_quantity > 0){
            $result_adult = $tickets->AddTicket($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $ticket_benefit_price, $ticket_benefit_quantity, $ticket_group_price, $ticket_group_quantity, $order_id, "adult");  
        }else{
            $result_adult = null;
        }
        
        //Запись детского билета в таблицу tickets
        if($ticket_kid_quantity > 0){
            $result_kid = $tickets->AddTicket($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $ticket_benefit_price, $ticket_benefit_quantity, $ticket_group_price, $ticket_group_quantity, $order_id, "kid"); 
        }else{
            $result_kid = null;
        }
        
        //Запись льготного билета в таблицу tickets
        if($ticket_benefit_quantity > 0){
            $result_benefit = $tickets->AddTicket($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $ticket_benefit_price, $ticket_benefit_quantity, $ticket_group_price, $ticket_group_quantity, $order_id, "benefit");    
        }else{
            $result_benefit = null;
        }
        
        //Запись группового билета в таблицу tickets
        if($ticket_group_quantity > 0){
            $result_group = $tickets->AddTicket($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $ticket_benefit_price, $ticket_benefit_quantity, $ticket_group_price, $ticket_group_quantity, $order_id, "group");   
        }else{
            $result_group = null;
        }
        
        //Если все билеты не прошли проверку по API
        //Удаляем заказ из таблицы orders
        $tick = new TicketModel;
        if($tick->FindTicket($order_id) == false){
            //Удаляем заказ из таблицы orders
            $order->DeleteOrder($order_id);
            
            //Собираем информацию о результате выполнения
            $result = [
                'status' => false,
                'info'   => null,
            ];
        }else{
            //Если хотябы один билет прошел проверку по API
            //Собираем информацию о результате выполнения
            $result = [
                'status' => true,
                'info' => [
                    'adult'   => $result_adult,
                    'kid'     => $result_kid,
                    'benefit' => $result_benefit,
                    'group'   => $result_group,
                ]
            ];
        }
       
        return $result;
    }

}