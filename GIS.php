<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
     *  Common geographic functions, in CodeIgniter.
     *  @package MY_Haversine
     *  @subpackage Models
     *  @version 0.0.1
     *  @author Douglas Grubba
     *  @access public
     *  @copyright 2012 Douglas Grubba
     *  @link http://about.me/douggdev
	*/
    class GIS extends CI_Model {

        /**
         * name of the table
         *
         * @access  public
         * @var     string
         */
        public $table_name;

        /**
         * name latitude field
         *
         * @access  public
         * @var     string
         */
        public $lat_field;

        /**
         * name longitude field
         *
         * @access  public
         * @var     string
         */
        public $lng_field;

        public function __construct()
        {
            parent::__construct();

            //set the default lat name
            $this->lat_field = 'lat';

            //set the default lng name
            $this->lat_field = 'lng';

            //set the default table name
            $this->table_name = 'points';
        }

        /*
         *  find the n closest locations using the haversine formula
         *  @param float $lat latitude of the point of interest
         *  @param float $lng longitude of the point of interest
         *  @return array
         */
        public function haversine_closest($lat, $lng, $max_distance = 25, $max_locations = 10, $units = 'miles', $fields = false)
        {
            /*
             *  Allow for changing of units of measurement
             */
            switch ($units) {
                case 'miles':
                    //radius of the great circle in miles
                    $gr_circle_radius = 3959;
                break;
                case 'kilometers':
                    //radius of the great circle in kilometers
                    $gr_circle_radius = 6371;
                break;
            }

            /*
             *  Support the selection of certain fields
             */
            if( ! $fields ) {
                $this->db->select('*');
            }
            else {
                foreach($fields as $field) {
                    $this->db->select($field);
                }
            }

            /*
             *  Generate the select field for disctance
             */
            $disctance_select = sprintf(
                    "( %d * acos( cos( radians( %s ) ) " .
                            " * cos( radians( %s ) ) " .
                            " * cos( radians( %s ) - radians( %s ) ) " .
                            " + sin( radians( %s ) ) * sin( radians( %s ) ) " .
                        ") " . 
                    ") " . 
                    "AS distance",
                    $gr_circle_radius,
                    $this->lat_field,
                    $this->lng_field,
                    $lat,
                    $lng,
                    $lat,
                    $this->lat_field
                );

            /*
             *  Add distance field
             */
            $this->db->select($disctance_select, false);

            /*
             *  Make sure the results are within the search criteria
             */
            $this->db->having('distance <', $max_distance, false);

            /*
             *  Limit the number of results that the search will return
             */
            $this->db->limit($max_locations);

            /*
             *  Return the results by the closest locations first
             */
            $this->db->order_by('distance', 'ASC');
            
            /*
             *  Define the table that we are querying
             */
            $this->db->from($this->table_name);

            $query = $this->db->get();

            return $query->result();
        }

    }