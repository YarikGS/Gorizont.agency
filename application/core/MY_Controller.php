<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

  protected $data = array();

  function __construct()
  {
    parent::__construct();

    $this->load->helper( array('cookie', 'language','url', 'form', 'html','date') );
    $this->load->library( array('session','form_validation') );
    $this->load->database();
    $this->load->library('ion_auth');
    // $this->language = $this->config->config['language']; 
    if ( !$this->session->has_userdata('lang') )
    {
      $this->session->set_userdata('lang', $this->config->config['language']);
    }
    if ( !$this->session->has_userdata('lang_prefix') )
    {
      $this->session->set_userdata('lang_prefix', $this->config->config['languages'][ $this->config->config['language'] ]);
    }
    $this->data['lang'] = $this->session->userdata('lang');
    $this->data['lang_prefix'] = $this->session->userdata('lang_prefix');
    // $this->lang->load('auth', 'russian');
    $this->user_data = $this->ion_auth->user()->row();
    if ( isset($this->user_data) && $this->ion_auth->is_admin() ) {
      $this->data['admin_name'] = $this->user_data->username;
    }
  }

  protected function render($the_view = NULL, $template = NULL)
  {
    if($template == 'json' || $this->input->is_ajax_request())
    {
      header('Content-Type: application/json');
      echo json_encode($this->data);
    }elseif(is_null($template)){
      $this->load->view('templates/header', $this->data);
      $this->load->view($the_view, $this->data);
      $this->load->view('templates/footer', $this->data);
    }elseif($template == 'singlepage'){
      $this->load->view($the_view, $this->data);
    }else{
      $this->load->view('templates/header_'.$template, $this->data);
      $this->load->view($the_view,$this->data);
      $this->load->view('templates/footer_'.$template, $this->data);
    }
  }

  public function language_change($lang)
  {
    
    if ( !isset( $this->config->config['languages'][ $lang ] ) ) {
      $lang = 'english';
    }    
      
    $short_lang = $this->config->config['languages'][ $lang ];

    $this->session->set_userdata('lang', $lang);
    $this->config->set_item('language', $lang);
    $this->session->set_userdata('lang_prefix', $short_lang);
    // if ($ajax == FALSE) {
    //   redirect( base_url( $short_lang.$this->uri->segment(2) ) );
    // }else{
    //   if ($url == FALSE) {
    //     return prep_url( base_url( $short_lang ) );
    //   }else{
    //     return prep_url( base_url( $short_lang.$url ) );
    //   }
    // }
    // $this->config->config['language'] =$language;
  }

  public function get_tables_pages()
  {
    if ( $this->input->is_ajax_request() && $this->input->get('table') )
    {
        if ( $this->input->get('limit') != NULL ) {
          $items_per_page = 15;
        }
        $pages = ceil($this->db->count_all( $table)  / $items_per_page);
            //get amount of pages for table if page contains items_per_page elements
        // print_r($service->header_ru);
        if (  $pages != FALSE )
        {
            $this->data['status'] = 1;
            $this->data['pages'] = $pages;
        }else{
            $this->data['status'] = 0;
        }
        
        $this->render(NULL, 'json');     
    }       
  }

  function image_upload( $origin_file, $destination, $filename = NULL )
  {
    if ( $filename == NULL ) {
      $filename = $origin_file;
    }

    if ( !is_dir( './assets/img/temp' ) )
    {
      if (!mkdir( './assets/img/temp', 0777, TRUE) )
      {
        return array('status' => FALSE, 'message' => 'Ошибка при создании папки для временных файлов');
      }
    }

    if ( !is_dir( $destination ) )
    {
      if (!mkdir( $destination, 0777, TRUE) )
      {
        return array('status' => FALSE, 'message' => 'Ошибка при создании папки '.$destination );
      }
    }
    // $config['upload_path']   = "./assets/img/temp";
    $config['upload_path']   = $destination;
    $config['file_name']   = $filename;
    $config['allowed_types'] = 'gif|jpg|png|svg';
    // $config['encrypt_name']  = TRUE;
    // $config['max_size']        = 2048;
    $config['max_size']        = 2048;
    if ($origin_file == 'img_mobile') {
      $config['max_width'] = '212';
      $config['max_height'] = '212';
    }else{
      $config['max_width'] = '1920';
      $config['max_height'] = '1080';
    }
     
    $this->load->library('upload',$config);
    
    $this->upload->initialize($config, TRUE);
    if( $this->upload->do_upload( $origin_file ) )
    {
      $data = $this->upload->data();

      //Resize and Compress Image
      // $config2['image_library']  ='gd2';
      // $config2['source_image']   ='./assets/img/temp/'.$data['file_name'];
      // $config2['create_thumb']   = FALSE;
      // $config2['maintain_ratio'] = FALSE;
      
      // $config['width']          = 800;
      // $config['height']         = 600;
      // $config2['new_image']      = $destination.$filename.$data['file_ext'];
      $new_image_name = $filename.$data['file_ext'];
      
      // $this->load->library('image_lib', $config2);

      // $this->image_lib->resize();

      // if( is_file( $config2['source_image'] ) )
      // {
      //   unlink($config2['source_image']); // delete file
      // }
      // if (!file_exists( $config2['new_image'] )) {
      //   return array('status' => FALSE, 'message' => 'Изображение '.$config2['new_image'].' не добавлено. '.$this->upload->display_errors() );
      // }
      // if ( !file_exists( $config2['source_image'] ) ) {
      //   return array('status' => TRUE, 'new_image' => $new_image_name);
      // }else{
      //   return array('status' => FALSE, 'message' => 'Изображение добавлено, но остались временные файлы');
      // }
      if ( file_exists( $config['upload_path'].$new_image_name ) ) {
        return array('status' => TRUE, 'new_image' => $new_image_name);
      }else{
        return array('status' => FALSE, 'message' => 'Изображение не добавлено');
      }

    }else{
      return array('status' => FALSE, 'message' => $this->upload->display_errors() );
    }  
  }

  function files_delete( $destination )
  {
    $this->load->helper('file');
    if (delete_files( $destination, TRUE))// delete file
    {
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function file_delete( $destination )
  {
    $this->load->helper('file');
    if (unlink( $destination ))// delete file
    {
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function directory_create( $destination )
  {
    if (mkdir( $destination, 0777, TRUE) )
      {
        return array('status' => TRUE );
      }else{
        return array('status' => FALSE, 'message' => 'Ошибка при создании папки '.$destination );
      }
  }

  function directory_delete( $destination )
  {
    $this->load->helper('file');
    if ( delete_files( $destination, TRUE) && rmdir($destination) )// delete files and directory
    {
      return TRUE;
    }else{
      return FALSE;
    }
  }
    
}