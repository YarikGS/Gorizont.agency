<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $messages;
    protected $errors;
    protected $error_start_delimiter;
    protected $error_end_delimiter;
    protected $message_start_delimiter;
    protected $message_end_delimiter;

    public function __construct()
    {
        $this->load->database();
        $this->messages    = array();
        $this->errors      = array();
        $this->message_start_delimiter = '<div class="alert alert-success">';
        $this->message_end_delimiter   = '</div>';
        $this->error_start_delimiter   = '<div class="alert alert-danger">';
        $this->error_end_delimiter     = '</div>';
    }

    //get amount of pages for table if page contains items_per_page elements
    public function get_tables_pages($table, $items_per_page = NULL )
    {
        if ( $items_per_page == NULL ) {
            $items_per_page = 15;
        }

        return ceil($this->db->count_all($table)  / $items_per_page);
    }

    public function get_data_array($info, $from, $where = NULL, $items_per_page = NULL, $current_page = NULL, $order = NULL )
    {
        $this->db
            ->select($info)
            ->from($from);

        if ( $where != NULL ) {
            $this->db->where($where);
        }

        if ( $items_per_page != NULL ) {
            $this->db->limit( $items_per_page );
        }

        if ( $items_per_page && $current_page != NULL ) {
            $this->db->limit($items_per_page, $current_page );
        }

        if ( $order != NULL ) {
            $this->db->order_by( $order );
        }

        $query = $this->db->get();
        if ( $query->num_rows() == 0 ) {
            return FALSE;
        }
        
        return $query->result_array();        
    }

    public function get_data_row($info, $from, $where, $order = NULL, $limit = NULL )
    {
        $this->db
            ->select($info)
            ->from($from)
            ->where($where);

        if ( $order != NULL ) {
            $this->db->order_by( $order );
        }

        if ( $limit != NULL ) {
            $this->db->limit( $limit );
        }        

        $query = $this->db->get();

        if ( $query->num_rows() == 0 ) {
            return FALSE;
        }else{
            return $query->row();
        }
    }

    // public function insert()
    // {
        // if ( $category != null ) {
        //     $this->db->like('keywords_'.$lang, $category, 'both');
        // }else{
        //     $this->db->limit($this->items_per_page, strval($current));
        // }
    // }

    public function insert_data($where, $data, $get_id = NULL )
    {
        if ( $this->db->insert( $where, $data ) )
        {
            if ( $get_id === TRUE ) {
                return $this->db->insert_id();
            }else{
                return TRUE;
            }
        }else{
            return FALSE;
        }
    }

    public function update_data($where, $data, $table)
    {
        if ( $this->db->update( $table, $data, $where ) ) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function delete_data( $where, $table )
    {
        $this->db->where( $where );
        if ( $this->db->delete( $table ) )
        {
            return TRUE;
        }else{
            return FALSE;
        }       
    }
}