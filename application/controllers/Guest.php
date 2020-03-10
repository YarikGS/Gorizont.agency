<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Guest extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('My_Model','MM');
        $this->check_path = APPPATH.'views/gorizont/guest/';
        $this->template_path = 'gorizont/guest/';
        $this->load->helper('file');
    }

    public function get_tables_pages()
    {
       return $this->MM->get_tables_pages( $this->input->get('table') );
    }

    public function index()
    {
        if ( ! file_exists($this->check_path.'index.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        if ( !$this->input->is_ajax_request())
        {
            $sections = $this->MM->get_data_array( 'id, value', 'main_sections', 'parental_id = 0' );

            if ( $sections != FALSE ) {
                foreach ($sections as $key => $value) {
                    $section_items = $this->MM->get_data_array( 'id, value', 'main_sections', 'parental_id = '.$value['id'] );
                    $sections[$key]['section_items'] = $section_items;
                }
                $this->data['sections'] = $sections;
            }

            $captions = $this->MM->get_data_array( '*', 'main_captions');
            if ( $captions === FALSE ) {
                show_404();
            }
            //3 pdf link, 4- main title, 5-main text, 6 - contacts
            if (!empty($captions[0]['value'])) {
                $this->data['pdf_link'] = $captions[0]['value']; 
            }else{
                $this->data['pdf_link'] = '#';
            }

            if (!empty($captions[1]['value'])) {
                $this->data['title'] = $captions[1]['value']; 
            }

            if (!empty($captions[2]['value'])) {
                $this->data['text'] = $captions[2]['value']; 
            }

            if (!empty($captions[3]['value'])) {
                $this->data['contacts'] = $captions[3]['value']; 
            }

            if (!empty($captions[4]['value'])) {
                $this->data['statistic_value_1'] = $captions[4]['value']; 
            }else{
                $this->data['statistic_value_1'] = 0;
            }

            if (!empty($captions[4]['comments'])) {
                $this->data['statistic_caption_1'] = $captions[4]['comments']; 
            }

            if (!empty($captions[5]['value'])) {
                $this->data['statistic_value_2'] = $captions[5]['value']; 
            }else{
                $this->data['statistic_value_2'] = 0;
            }

            if (!empty($captions[5]['comments'])) {
                $this->data['statistic_caption_2'] = $captions[5]['comments']; 
            }

            if (!empty($captions[6]['value'])) {
                $this->data['statistic_value_3'] = $captions[6]['value']; 
            }else{
                $this->data['statistic_value_3'] = 0;
            }

            if (!empty($captions[6]['comments'])) {
                $this->data['statistic_caption_3'] = $captions[6]['comments']; 
            }

            $portfolio = $this->MM->get_data_array( '*', 'portfolio');
            if (  $portfolio != FALSE )
            {
                $this->data['portfolios'] = $portfolio;
            }

            $this->render($this->template_path.'index.php', 'singlepage');
        }
    }

    public function portfolio()
    {
        if ( ! file_exists($this->check_path.'portfolio.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $portfolio = $this->MM->get_data_array( '*', 'portfolio');
        if (  $portfolio != FALSE )
        {
            $this->data['portfolios'] = $portfolio;
        }

        $this->render($this->template_path.'portfolio.php', 'singlepage');
    }

    public function case($id)
    {
        $portfolio = $this->MM->get_data_row( 'id, header', 'portfolio', 'id = '.$id );
        // print_r($portfolio->header_ru);
        if ( $portfolio != FALSE )
        {
            // select * from foo where id = (select min(id) from foo where id > 4)
            $next_query =$this->db->select('min(id) as id')->where('id > '.$id)->get('portfolio')->row()->id;
            if (!empty($next_query)) {
                $this->data['next_case']= $next_query;
            }

            $prev_query = $this->db->select('max(id) as id')->where('id < '.$id)->get('portfolio');
            if (!empty($prev_query)) {
                $this->data['prev_case']= $prev_query;
            }
            
            $case = $this->MM->get_data_array( '*', 'cases', 'portfolio_id = '.$id, NULL, NULL, 'position ASC');
            $this->data['status'] = 1;
            $this->data['portfolio'] = $portfolio;
            $this->data['elements'] = $case;
        }else{
            show_404();
        }

        if ( ! file_exists($this->check_path.'info.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $portfolio = $this->MM->get_data_array( '*', 'portfolio');
        if (  $portfolio != FALSE )
        {
            $this->data['portfolios'] = $portfolio;
        }

        $this->render($this->template_path.'info.php', 'singlepage');
    } 
}