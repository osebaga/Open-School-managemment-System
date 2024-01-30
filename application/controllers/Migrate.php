<?php  if ( ! defined('BASEPATH')) exit("No direct script access allowed");

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 6/11/17
 * Time: 3:15 PM
 */


class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }


        function index(){
            $this->db->query("ALTER TABLE `nationality`  ADD `Country` VARCHAR(255) NULL  AFTER `Name`");
            $this->db->query("ALTER TABLE `application_experience`  ADD `applicant_id` BIGINT NOT NULL  AFTER `id`,  ADD   INDEX  (`applicant_id`)");
            $this->db->query("ALTER TABLE `application`  ADD `birth_place` TEXT NULL  AFTER `physical`,  ADD `residence_country` INT NULL DEFAULT '0'  AFTER `birth_place`,  ADD `marital_status` INT NULL DEFAULT '1'  AFTER `residence_country`");
            $this->db->query("CREATE TABLE `maritalstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
   PRIMARY KEY (`id`)
)");

            $this->db->query("INSERT INTO `maritalstatus` (`id`, `name`) VALUES
(1, 'Single'),
(2, 'Married'),
(3, 'Divorced'),
(4, 'Widowed'),
(5, 'Separated'),
(6, 'Others')");
            echo 'Database updated';
        }

}