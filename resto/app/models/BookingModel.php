<?php


class BookingModel
{

public function create($userId,$date,$service,$place)
{

    $pdo = (new Database())->getPdo();
    $query = $pdo->prepare(
        "INSERT INTO booking (user_id, dateResa,service,placesDemandees)
                    VALUES ( :user_id,:date,:service,:place)");
    $query->execute([
                    "user_id"=>$userId,
                    "date"=>$date,
                    "service"=>$service,
                    "place"=>$place,

    ]);

}

public function showByUser($userId)
{
    $pdo = (new Database())->getPdo();
    $query = $pdo->prepare("SELECT *
                                        FROM `booking` 
                                        inner join user on booking.user_id =user.id
                                        where user_id=:userId
                                        order  by dateResa
                                       ");
    $query->execute(["userId"=>$userId]);
    return  $query->fetchAll();
}

public function findByDateAndService($date,$service)
{
    $pdo = (new Database())->getPdo();
    $query = $pdo->prepare("SELECT SUM(placesDemandees) as nbr
                                        FROM booking
                                        WHERE dateResa= :date
                                        AND service= :service
                                        AND cancelled=0");
    $query->execute(["date" => $date,
                    "service"=> $service,
                    ]);
    $result= $query->fetch();

    return $result['nbr'];
}

public function updateCancelled($bookingId)
{
    $pdo = (new Database())->getPdo();
    $query = $pdo->prepare("update booking 
                                      set cancelled=1
                                      where booking_id=:bookingId");
    $query->execute(["bookingId"=>$bookingId]);
}


    

}
