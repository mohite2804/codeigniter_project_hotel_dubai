
ALTER TABLE `user_master` ADD `full_name` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `email`;

ALTER TABLE `user_master`
CHANGE `mobile_no` `mobile_no` varchar(20) COLLATE 'latin1_swedish_ci' NULL AFTER `full_name`;


ALTER TABLE `user_master`
CHANGE `company_name` `company_name` varchar(255) COLLATE 'latin1_swedish_ci' NULL DEFAULT '' AFTER `password`,
CHANGE `company_domain` `company_domain` varchar(255) COLLATE 'latin1_swedish_ci' NULL DEFAULT '' AFTER `company_name`,
CHANGE `salutation` `salutation` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `company_domain`,
CHANGE `first_name` `first_name` varchar(50) COLLATE 'latin1_swedish_ci' NULL AFTER `salutation`,
CHANGE `last_name` `last_name` varchar(50) COLLATE 'latin1_swedish_ci' NULL AFTER `middle_name`,
CHANGE `dob` `dob` date NULL AFTER `last_name`,
CHANGE `gender` `gender` varchar(10) COLLATE 'latin1_swedish_ci' NULL AFTER `dob`,
CHANGE `pan_card_no` `pan_card_no` varchar(20) COLLATE 'latin1_swedish_ci' NOT NULL DEFAULT '0' AFTER `gender`,
CHANGE `aadhar_card_no` `aadhar_card_no` varchar(12) COLLATE 'latin1_swedish_ci' NOT NULL DEFAULT '0' AFTER `pan_card_no`,
CHANGE `gstin` `gstin` varchar(15) COLLATE 'latin1_swedish_ci' NOT NULL DEFAULT '0' AFTER `aadhar_card_no`,
CHANGE `marital_status` `marital_status` int(11) NULL AFTER `gstin`,
CHANGE `address_2` `address_2` varchar(255) COLLATE 'latin1_swedish_ci' NOT NULL DEFAULT '0' AFTER `address_1`,
CHANGE `address_3` `address_3` varchar(255) COLLATE 'latin1_swedish_ci' NOT NULL DEFAULT '0' AFTER `address_2`,
CHANGE `language_id` `language_id` int(11) unsigned NOT NULL DEFAULT '0' AFTER `pincode_id`;




INSERT INTO user_master (business_partner_id,misp_id,user_type_id,email,password,full_name,city_id,language_id,pincode_id,state_id)
SELECT 1,misp_id,5,email,password,name_misp,1,1,1,1 FROM misp_master ;




DROP TRIGGER IF EXISTS insertMispIntoUser;
DELIMITER $$
CREATE TRIGGER insertMispIntoUser AFTER INSERT
ON misp_master FOR EACH ROW
BEGIN
	INSERT INTO user_master (business_partner_id,misp_id,user_type_id,email,password,full_name,city_id,language_id,pincode_id,state_id)
	SELECT 1,NEW.misp_id,5,NEW.email,NEW.password,NEW.name_misp,1,1,1,1 FROM misp_master WHERE misp_id = NEW.misp_id;
END $$ 
DELIMITER;


DROP TRIGGER IF EXISTS updateMispIntoUser;
DELIMITER $$
CREATE TRIGGER updateMispIntoUser AFTER UPDATE
ON misp_master FOR EACH ROW
BEGIN
	UPDATE user_master 
	SET email = NEW.email, password = NEW.password,  full_name = NEW.name_misp
	WHERE misp_id = NEW.misp_id;
END $$    	
DELIMITER;


DROP PROCEDURE `sp_user_login`;

DELIMITER //
CREATE PROCEDURE `sp_user_login` (IN `user_name` varchar(100), IN `PASSWORD` varchar(100), IN `login_type` varchar(100))
BEGIN
        
    DECLARE v_where TEXT;
    DECLARE v_select TEXT;

    CASE login_type
      
        WHEN 'otp' THEN                
           SET @v_where  = CONCAT(' um.mobile_no  = ', user_name, "' AND um.mobile_otp '",PASSWORD,"')");              

         WHEN 'biz' THEN                
           SET @v_where  = CONCAT(" (um.email = '", user_name, "' OR um.mobile_no  = '", user_name,"' )");

        WHEN 'web' THEN                   
          SET @v_where  = CONCAT(" (um.email = '", user_name, "' OR um.mobile_no  = '", user_name,"' ) AND um.password = '", MD5(PASSWORD),"'");
                        
    END CASE;

    SET @v_select =  CONCAT('SELECT 
                um.user_master_id,
                um.user_type_id,
                um.email, 
                um.mobile_no,
                um.salutation, 
                um.first_name,
                um.middle_name,
                um.last_name,
                um.profile_image,                               
                IF(um.user_type_id = "1", CONCAT(um.first_name," ",um.middle_name," ",um.last_name), um.full_name) AS full_name,
                um.business_partner_id, 
                bpm.name AS business_partner_name,
                bpm.partner_code,
                mm.misp_id, 
                mm.name_misp,
                mm.razor_customer_id,
                mm.status_id as misp_status_id,

                mmm.misp_id as misp_id_for_misp_login, 
                mmm.name_misp as name_misp_for_misp_login, 
                mmm.razor_customer_id as razor_customer_id_for_misp_login, 
                mmm.status_id as misp_status_id_for_misp_login, 

                
                um.pos_master_id,pm.app_fullname as pos_name,
                lm.language_id,lm.code as language_code,
                
                pm.status_id as pos_status_id,
                um.status_id as user_status_id
                FROM `user_master` AS um
                LEFT JOIN `business_partner_master` AS bpm ON um.business_partner_id= bpm.business_partner_id   
                LEFT JOIN `pos_master` AS pm ON pm.pos_id = um.pos_master_id
                LEFT JOIN `misp_master` AS mm ON mm.misp_id = pm.misp_master_id

                LEFT JOIN `misp_master` AS mmm ON mmm.misp_id = um.misp_id

                LEFT JOIN `languages_master` AS lm ON lm.language_id = um.language_id WHERE ',@v_where)  ;


  
    PREPARE stmt FROM @v_select;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
        
   END //
DELIMITER ;



INSERT INTO `status_master` (`status_type_id`, `code`, `lable`)  VALUES ('4', 'cancelled', 'Cancelled');




update tvs_dms_data set product_type_id = 2;

UPDATE tvs_dms_data
INNER JOIN vehicle_variant_master ON vehicle_variant_master.vehicle_variant_id = tvs_dms_data.VARIANT_ID
INNER JOIN vehicle_model_master ON vehicle_model_master.vehicle_model_id = tvs_dms_data.MODEL_ID
SET tvs_dms_data.PRODUCT_TYPE_ID = vehicle_model_master.product_type_id 
WHERE tvs_dms_data.PRODUCT_TYPE_ID is null or tvs_dms_data.PRODUCT_TYPE_ID = ""



select tvs_dms_data.id, ,vehicle_model_master.make_id, vehicle_model_master.product_type_id,vehicle_model_master.vehicle_model_id,vehicle_variant_master.vehicle_variant_id
from tvs_dms_data
INNER JOIN vehicle_variant_master ON vehicle_variant_master.vehicle_variant_id = tvs_dms_data.VARIANT_ID
INNER JOIN vehicle_model_master ON vehicle_model_master.vehicle_model_id = tvs_dms_data.MODEL_ID
INNER JOIN product_type_master ON product_type_master.product_type_id = vehicle_model_master.product_type_id


select tvs_dms_data.id, vehicle_model_master.make_id, vehicle_model_master.product_type_id,vehicle_model_master.vehicle_model_id,vehicle_variant_master.vehicle_variant_id
from tvs_dms_data
LEFT JOIN vehicle_variant_master ON vehicle_variant_master.vehicle_variant_id = tvs_dms_data.VARIANT_ID
LEFT JOIN vehicle_model_master ON vehicle_model_master.vehicle_model_id = tvs_dms_data.MODEL_ID
WHERE vehicle_variant_master.vehicle_variant_id is null or vehicle_variant_master.vehicle_variant_id = ""
or vehicle_model_master.vehicle_model_id is null or vehicle_model_master.vehicle_model_id = "";


ALTER TABLE `user_master` ADD `profile_image` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `status_id`;


ALTER TABLE `user_master` ADD `is_password_change` TINYINT(1) NULL DEFAULT '0' AFTER `updated_at`;

ALTER TABLE `policy_cancellation` CHANGE `updated_at` `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL; 



UPDATE `endorsement_type` SET `lable` = 'Nil' WHERE `endorsement_type_id` = '2';
UPDATE `endorsement_type` SET `lable` = 'Non Nil' WHERE `endorsement_type_id` = '3';


CREATE TABLE `proposal_razor_order` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `proposal_no` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `entity` varchar(255) NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `amount_paid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `amount_due` decimal(12,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(255) NULL,
  `receipt` varchar(255) NULL,
  `offer_id` varchar(255) NULL,
  `status` varchar(255) NULL,
  `attempts` int(3) NULL,
  `notes` text NULL,
  `created_at` datetime NOT NULL
);


ALTER TABLE `wallet_statment`
CHANGE `amount_paisa` `amount_in_paisa` float(10,2) NULL AFTER `signature_id`,
CHANGE `amount_rupee` `amount_in_rupee` float(10,2) NULL AFTER `amount_in_paisa`;




ALTER TABLE `misp_privilege_master`
ADD `tvs_user_id` int(11) NULL AFTER `misp_partner_id`,
ADD `hib_user_id` int(11) NULL AFTER `tvs_user_id`;


ALTER TABLE `ic_master`
ADD `irdai_register_no` varchar(50) COLLATE 'latin1_swedish_ci' NULL AFTER `landline`;


ALTER TABLE `ic_master`
ADD `hsn_no` varchar(100) COLLATE 'latin1_swedish_ci' NULL AFTER `address`;


DROP TABLE IF EXISTS `ic_uin_nos`;
CREATE TABLE `ic_uin_nos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ic_id` int(11) NOT NULL,
  `policy_subtype_id` int(11) NOT NULL,
  `uin_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_date` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `policy_subtype_id` (`policy_subtype_id`),
  CONSTRAINT `ic_uin_nos_ibfk_2` FOREIGN KEY (`policy_subtype_id`) REFERENCES `policy_subtype_master` (`policy_subtype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ic_uin_nos` (`id`, `ic_id`, `policy_subtype_id`, `uin_no`, `created_date`) VALUES
(1, 20, 4,  'IRDAN103RP0002V01201920',  '0000-00-00 00:00:00'),
(2, 20, 2,  'IRDAN103RP0008V01201819',  '0000-00-00 00:00:00');


ALTER TABLE `addon_ic_master`
ADD `addon_no` varchar(100) NULL AFTER `product_type_id`;

ALTER TABLE `imt_code`
ADD `imt_code_no` varchar(20) COLLATE 'utf8_unicode_ci' NULL AFTER `code`;

ALTER TABLE `ic_uin_nos`
ADD `product_code` varchar(100) NULL AFTER `policy_subtype_id`;


ALTER TABLE `addon_master`
ADD `column_name_in_table` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `name`;


ALTER TABLE `ic_uin_nos`
ADD `addon_id` int NOT NULL AFTER `policy_subtype_id`,
ADD `addon_uin_no` varchar(100) COLLATE 'utf8_unicode_ci' NULL AFTER `uin_no`;


ALTER TABLE `imt_code`
ADD `imt_code_no` varchar(20) COLLATE 'utf8_unicode_ci' NULL AFTER `code`;

ALTER TABLE `imt_code`
ADD `flag_name` varchar(200) COLLATE 'utf8_unicode_ci' NULL AFTER `code`;




ALTER TABLE `ic_office_master`
CHANGE `seller_off_group_code` `seller_off_group_code` varchar(25) COLLATE 'latin1_swedish_ci' NULL AFTER `ic_id`,
CHANGE `state_name` `state_name` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `seller_off_group_code`,
CHANGE `office_type` `office_type` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `reg_add`;


ALTER TABLE `ic_master`
ADD `customer_service_address` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `logo`,
ADD `register_and_corrporate_address` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `customer_service_address`;


ALTER TABLE `ic_uin_nos`
CHANGE `product_code` `product_code` varchar(100) COLLATE 'utf8_unicode_ci' NULL DEFAULT 'https://www.mypolicynow.com/adminer.php?file=plus.gif&version=4.3.1' AFTER `addon_id`,
ADD `product_label` varchar(254) COLLATE 'utf8_unicode_ci' NULL AFTER `product_code`;

ALTER TABLE `ic_master`
ADD `cin_no` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `register_and_corrporate_address`;


ALTER TABLE `pos_master`
ADD `internal_code` varchar(60) COLLATE 'latin1_swedish_ci' NULL AFTER `app_fullname`;


ALTER TABLE `policy_data_dictionary_master`
ADD `qr_code` varchar(50) COLLATE 'latin1_swedish_ci' NULL AFTER `policy_no`;


ALTER TABLE `ic_master`
ADD `stamp_duty_authorization_no` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `register_and_corrporate_address`,
ADD `stamp_duty_authorization_date` date NULL AFTER `stamp_duty_authorization_no`;


ALTER TABLE `ic_privileges_master`
CHANGE `payment_type_ids` `payment_type_ids` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `product_type_id`,
ADD `policy_sub_type_ids` varchar(255) COLLATE 'latin1_swedish_ci' NULL AFTER `payment_type_ids`;


ALTER TABLE `od_discount_master` 
ADD COLUMN `vehicle_id` INT NULL AFTER `business_partner_id`;

ALTER TABLE `policy_data_dictionary_master` 
ADD COLUMN `64vb_approved_date` VARCHAR(255) NULL AFTER `is_invoice_raised`; 

TRUNCATE TABLE od_discount_master;
TRUNCATE TABLE od_discount_vehicle_age;
TRUNCATE TABLE od_discount_model_mapping;
TRUNCATE TABLE od_discount_conditon_mapping;


ALTER TABLE `vahan_data` 
ADD COLUMN `mpn_previous_policy_id` INT(11) DEFAULT 0 NULL 
AFTER `mpn_policy_subtype_id`; 




UPDATE vehicle_master SET status_id = 2 where ex_showroom_price = 0;
UPDATE vehicle_master SET status_id = 1 where ex_showroom_price != 0;
UPDATE vehicle_master SET status_id = 1 where product_type_id = 5;
UPDATE vehicle_master SET status_id = 1 where product_type_id = 9;

ALTER TABLE `quote_data_dictionary_master` 
ADD COLUMN `is_bifuel` TINYINT(1) DEFAULT 0 NULL 
AFTER `pre_year_tp_policy_pdf`; 


UPDATE policy_data_dictionary_master p
JOIN policy_cancellation pc ON pc.policy_id = p.policy_id
SET policy_status_id = 3;


ALTER TABLE `level_master` ADD COLUMN `parent_id` INT NULL AFTER `level_id`; 


ALTER TABLE `product_type_master` 
ADD COLUMN `parent_id` INT NULL 
AFTER `product_type_id`; 


ALTER TABLE `vahan_data` ADD COLUMN `metadata_clean_model_variant` TEXT NULL 
AFTER `metadata_clean`; 

ALTER TABLE `vehicle_master` ADD FULLTEXT(`make`);
ALTER TABLE `vehicle_master` ADD FULLTEXT(`model`);
ALTER TABLE `vehicle_master` ADD FULLTEXT(`variant`);
ALTER TABLE `vehicle_master` ADD FULLTEXT(`model`,`variant`);
ALTER TABLE `vehicle_master` ADD FULLTEXT(`make`,`model`,`variant`);
ALTER TABLE `ic_master` ADD FULLTEXT(`code`);

ALTER TABLE `rto_master` ADD FULLTEXT(`code`,`label`);
ALTER TABLE `rto_master` ADD FULLTEXT(`code`);
ALTER TABLE `rto_master` ADD FULLTEXT(`label`);




ALTER TABLE `business_partner_master` 
ADD COLUMN `is_full_quote_form` INT DEFAULT 0 NULL 
AFTER `updated_by`;

ALTER TABLE `business_partner_master` 
ADD COLUMN `is_separate_website` TINYINT DEFAULT 0 NULL 
AFTER `is_full_quote_form`;

ALTER TABLE `product_type_master` 
ADD COLUMN `full_quote_url` VARCHAR(255) NULL AFTER `next_url`, 
ADD COLUMN `full_quote_nex_url` VARCHAR(255) NULL AFTER `full_quote_url`; 

UPDATE `product_type_master`
SET full_quote_url = 'quote-form',
full_quote_nex_url = 'quotation';



-- set status 0 for Mypolicy Now business partner
-- http://localhost:8000/api/addInBusinessPartnerWiseAddons

UPDATE business_partner_wise_addons
SET status_id = 0
WHERE business_partner_master_id IN (1,2,3,4,5,6,7,8,9,11,12,13,14,15)
AND addon_id IN (19,20,21,22,23,24,25);

-- set status 0 for Isuzu business partner
UPDATE business_partner_wise_addons
SET status_id = 0
WHERE business_partner_master_id IN (10)
AND product_type_id in (1)
AND addon_id IN (8,9,10,11,12,13,14,15,16,17,18,24,25);

UPDATE business_partner_wise_addons
SET status_id = 0
WHERE business_partner_master_id IN (10)
AND product_type_id in (4)
AND addon_id IN (3,4,5,6,8,10,11,12,13,14,15,16,17,18,19,20,21,22,23);

UPDATE business_partner_wise_addons
SET status_id = 0
WHERE business_partner_master_id IN (10)
AND product_type_id in (5)
AND addon_id IN (3,4,5,6,8,10,11,12,13,14,15,16,17,18,19,20,21,22,23);


ALTER TABLE `business_partner_master` 
ADD COLUMN `main_logo` VARCHAR(255) 
DEFAULT 'css/business_partner_theme/mpn-logo.png' NULL 
AFTER `is_separate_website`; 


ALTER TABLE `business_partner_master` 
ADD COLUMN `main_name` VARCHAR(255) 
DEFAULT 'Global-India Insurance Brokers Pvt. Ltd' NULL 
AFTER `main_logo`; 

ALTER TABLE `vehicle_master_isuzu` 
CHANGE `id` `vehicle_master_id` INT(11) 
UNSIGNED NOT NULL AUTO_INCREMENT; 

ALTER TABLE `vehicle_master_isuzu` 
ADD COLUMN `bp_id` INT(11) 
DEFAULT 0 NULL 
AFTER `isCustomCommercialNewVehicle`; 

ALTER TABLE `vehicle_master_isuzu` 
ADD COLUMN `is_bp` INT(11) 
DEFAULT 0 NULL 
AFTER `bp_id`; 

UPDATE  vehicle_master_isuzu 
SET status_id = 1;


ALTER TABLE `proposal_data_dictionary_master` 
CHANGE `proposal_start_date` `proposal_start_date` DATETIME NULL, 
CHANGE `proposal_end_date` `proposal_end_date` DATETIME NULL; 


ALTER TABLE `full_quote_data_dictionary_master` 
ADD COLUMN `nominee_gender` VARCHAR(50) NULL 
AFTER `nominee_relationship_id`; 


ALTER TABLE `quote_data_dictionary_master` 
ADD COLUMN `nominee_gender` VARCHAR(50) NULL 
AFTER `nominee_relationship_id`; 


ALTER TABLE `proposal_data_dictionary_master` 
ADD COLUMN `nominee_gender` VARCHAR(50) NULL 
AFTER `nominee_relationship_id`; 

ALTER TABLE `policy_data_dictionary_master` 
ADD COLUMN `nominee_gender` VARCHAR(50) NULL 
AFTER `nominee_relationship_id`; 

UPDATE `endorsement_type` SET `lable` = 'Nil' WHERE `endorsement_type_id` = '2'; 
UPDATE `endorsement_type` SET `lable` = 'Non Nil' WHERE `endorsement_type_id` = '3'; 


ALTER TABLE razor_wallet_transaction 
ADD COLUMN `bank_tranfer_data_json` LONGTEXT NULL 
AFTER `transfer_created_at`; 

ALTER TABLE razor_online_transaction 
ADD COLUMN `bank_tranfer_data_json` LONGTEXT NULL 
AFTER `transfer_created_at`; 

ALTER TABLE `razor_wallet_transaction` 
ADD COLUMN `is_add_amount_in_wallet_by_bank_transfer` INT DEFAULT 0 NULL 
AFTER `bank_tranfer_data_json`;

 ALTER TABLE `razor_online_transaction` 
 ADD COLUMN `is_signature_verify` INT(10) DEFAULT 0 NULL 
 AFTER `transfer_created_at`; 


 ALTER TABLE `razor_bank_transfer_transaction` 
 ADD COLUMN `error_code` VARCHAR(256) NULL AFTER `event`, 
 ADD COLUMN `error_reason` TEXT NULL AFTER `error_code`, 
 ADD COLUMN `method` VARCHAR(256) NULL AFTER `error_reason`; 


ALTER TABLE `razor_web_hook_transaction` 
ADD COLUMN `proposal_no` VARCHAR(256) NULL AFTER `method`; 


ALTER TABLE `policy_data_dictionary_master` 
ADD COLUMN `is_webhook_policy` TINYINT(1) DEFAULT 0 NULL 
AFTER `is_tppd`; 


ALTER TABLE `pos_master` ADD COLUMN `fund_account_id` VARCHAR(256) NULL AFTER `razor_customer_id`; 

ALTER TABLE `razor_web_hook_transaction` ADD COLUMN `is_call_function` TINYINT DEFAULT 0 NULL AFTER `proposal_no`;

ALTER TABLE `razor_web_hook_transaction` 
ADD COLUMN `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NULL AFTER `is_call_function`, 
ADD COLUMN `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL AFTER `created_at`; 

ALTER TABLE `razor_online_transaction` 
ADD COLUMN `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP NULL AFTER `updated_at`; 

ALTER TABLE `razor_online_transaction` ADD COLUMN `is_webhook` TINYINT DEFAULT 0 NULL AFTER `updated_at`; 
ALTER TABLE `razor_wallet_transaction` ADD COLUMN `is_webhook` TINYINT DEFAULT 0 NULL AFTER `created_at`; 


UPDATE quote_data_dictionary_master
SET is_bifuel = 1
WHERE unique_ref_no = '62161a1e27b96d2b' ;



UPDATE renew_data_dictionary_master
JOIN vehicle_master ON vehicle_master.vehicle_master_id = renew_data_dictionary_master.vehicle_id
SET renew_data_dictionary_master.ex_showroom_price = vehicle_master.ex_showroom_price 


UPDATE quote_data_dictionary_master
JOIN vehicle_master ON vehicle_master.vehicle_master_id = quote_data_dictionary_master.vehicle_id
SET quote_data_dictionary_master.ex_showroom_price = vehicle_master.ex_showroom_price 


SELECT 
policy_data_dictionary_master.proposer_type_id,
policy_data_dictionary_master.policy_id,
policy_data_dictionary_master.policy_no,
policy_data_dictionary_master.ic_id,
policy_data_dictionary_master.razorpay_order_id,
policy_data_dictionary_master.razorpay_payment_id,
razor_web_hook_transaction.method AS payment_method,
razor_web_hook_transaction.event AS check_payment_done_or_not,
proposal_data_dictionary_master.proposal_no,
proposal_data_dictionary_master.requested_data AS proposal_request_data,
proposal_data_dictionary_master.responded_data AS proposal_responded_data,
policy_data_dictionary_master.requested_data AS policy_requested_data,
policy_data_dictionary_master.responded_data AS policy_responded_data
FROM policy_data_dictionary_master 
JOIN proposal_data_dictionary_master ON proposal_data_dictionary_master.proposal_id = policy_data_dictionary_master.proposal_id
JOIN razor_web_hook_transaction ON razor_web_hook_transaction.razorpay_order_id = policy_data_dictionary_master.razorpay_order_id AND `event` = "order.paid"
WHERE proposal_data_dictionary_master.proposal_no IN ("QPM2W001000019975952")
ORDER BY policy_data_dictionary_master.policy_id DESC


SELECT  proposal_id,proposal_share_link,policy_id,policy_no FROM proposal_data_dictionary_master WHERE proposal_no = "QPM2W001000019975952"


SELECT  proposal_id,proposal_no, proposal_share_link,policy_id,policy_no FROM proposal_data_dictionary_master 
WHERE proposal_no in(
"QPM2W001000000177886",
"QPM2W001000000177916",
"QPMCAR001000000369876",
"QPMCAR001000000369884",
"QPMCAR001000000369867",
"QPMCAR001000000369885") 



DROP TRIGGER IF EXISTS updateInRenewalTableStatus;
DELIMITER $$
CREATE TRIGGER updateInRenewalTableStatus AFTER INSERT
ON policy_data_dictionary_master FOR EACH ROW
BEGIN
  UPDATE renew_data_dictionary_master 
  SET is_policy_generated = '1'
  WHERE (registration_no_part_1 != '' OR registration_no_part_1 IS NOT NULL OR registration_no_part_1 != 0  ) 
  AND (registration_no_part_2 != '' OR registration_no_part_2 IS NOT NULL OR registration_no_part_2 != 0  ) 
  AND (registration_no_part_3 != '' OR registration_no_part_3 IS NOT NULL OR registration_no_part_3 != 0  ) 
  AND (registration_no_part_4 != '' OR registration_no_part_4 IS NOT NULL OR registration_no_part_4 != 0  ) 
  AND registration_no_part_1 = NEW.registration_no_part_1 
  AND registration_no_part_2 = NEW.registration_no_part_2
  AND registration_no_part_3 = NEW.registration_no_part_3
  AND registration_no_part_4 = NEW.registration_no_part_4;
END $$      
DELIMITER;


TRUNCATE TABLE renew_data_dictionary_master;
TRUNCATE TABLE renewal_temp_master;


delete from full_quote_data_dictionary_master where registration_no_part_4 = "3380";
delete from quote_data_dictionary_master where registration_no_part_4 = "3380";
delete from proposal_data_dictionary_master where registration_no_part_4 = "3380";
delete from policy_data_dictionary_master where registration_no_part_4 = "3380";



delete from full_quote_data_dictionary_master where registration_no_part_4 in ('9890','3999','9182','6419','8085','9890','3799','9172','6319','8185');
delete from quote_data_dictionary_master where registration_no_part_4 in ('9890','3999','9182','6419','8085','9890','3799','9172','6319','8185');
delete from proposal_data_dictionary_master where registration_no_part_4 in ('9890','3999','9182','6419','8085','9890','3799','9172','6319','8185');
delete from policy_data_dictionary_master where registration_no_part_4 in ('9890','3999','9182','6419','8085','9890','3799','9172','6319','8185');


ALTER TABLE `quote_data_dictionary_master` ADD COLUMN `user_selected_idv` FLOAT(20,2) DEFAULT 0.00 NULL AFTER `is_tppd`; 



$temp_data = array(
     'is_package_addon' => $request_data->is_package_addon,
     'individual_addons' => $request_data->individual_addons,
     'selected_addon_list' => $quotation->selected_addon_list
 );

$temp_data = array('name' => json_encode($temp_data));
DB::table('temp_table')->insertGetId($temp_data);

TRUNCATE TABLE temp_table;


ALTER TABLE `full_quote_data_dictionary_master` ADD COLUMN `user_selected_idv` VARCHAR(50) NULL AFTER `is_tppd`; 
ALTER TABLE `quote_data_dictionary_master` ADD COLUMN `user_selected_idv` VARCHAR(50) NULL AFTER `is_tppd`; 
ALTER TABLE `proposal_data_dictionary_master` ADD COLUMN `user_selected_idv` VARCHAR(50) NULL AFTER `is_tppd`; 
ALTER TABLE `policy_data_dictionary_master` ADD COLUMN `user_selected_idv` VARCHAR(50) NULL AFTER `is_tppd`; 



ALTER TABLE `vehicle_master` ADD FULLTEXT(`model`);
ALTER TABLE `vehicle_master` ADD FULLTEXT(`variant`);
ALTER TABLE `vehicle_master` ADD FULLTEXT(`model`,`variant`);

ALTER TABLE `vehicle_master` ADD FULLTEXT(`make`);
ALTER TABLE `vehicle_master` ADD FULLTEXT(`make`,`model`,`variant`);
ALTER TABLE `ic_master` ADD FULLTEXT(`code`);

ALTER TABLE `rto_master` ADD FULLTEXT(`code`,`label`);
ALTER TABLE `rto_master` ADD FULLTEXT(`code`);
ALTER TABLE `rto_master` ADD FULLTEXT(`label`);

https://dev.mypolicynow.com/api/api/lara-clean


is_invoice_raised

UPDATE policy_data_dictionary_master SET is_invoice_raised = '0';