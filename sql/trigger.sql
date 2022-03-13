


DROP TRIGGER IF EXISTS updateRoomStatus;
DELIMITER $$
CREATE TRIGGER updateRoomStatus AFTER INSERT
ON payment_details FOR EACH ROW
BEGIN
     DECLARE v_order_start_date TEXT;
 
  IF (NEW.order_status  = 'Success' AND DATE(NEW.start_date_time) = CURDATE()) THEN  

  	UPDATE rooms 	SET is_free = 0 WHERE id = NEW.room_id;

    UPDATE rooms
    INNER JOIN orders ON orders.id = rooms.room_id
    INNER JOIN payment_details ON payment_details.order_id = orders.id
   
    SET rooms.is_free = 0
    WHERE rooms.id = NEW.room_id



  END IF;
END $$    	
DELIMITER;

