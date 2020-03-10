<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!$this->ion_auth->logged_in()===TRUE && !$this->ion_auth->is_admin() )
        {
            redirect('/');
        }

        $this->check_path = APPPATH.'views/gorizont/admin/';
        $this->template_path = 'gorizont/admin/';
        $this->load->model('My_Model','MM');
        $this->load->helper('file');
    }

    public function index()
    {
        if ( empty( $this->input->post('page') ) )
        {
            $page = 1;
        }else{
            $page = $this->input->post('page');
        }
        $items_per_page = 10;
        $max_page = $this->MM->get_tables_pages( 'portfolio', $items_per_page );
        if ( ($page <=0) || ($page > $max_page) ) {
            $page = 1;
        }

        $current = $page * $items_per_page - $items_per_page;

        $portfolio = $this->MM->get_data_array( '*', 'portfolio', NULL, $items_per_page, strval($current) );
            // print_r($event->header_ru);
        if (  $portfolio != FALSE )
        {
            $this->data['status'] = 1;
            $this->data['portfolios'] = $portfolio;
        }

        if ( $this->input->is_ajax_request() )
        {
            $this->render(NULL, 'json');     
        }

        if ( !$this->input->is_ajax_request() )
        {
            if ( ! file_exists($this->check_path.'portfolio.php'))
            {
                // Whoops, we don't have a page for that!
                show_404();
            }

            $this->render($this->template_path.'portfolio.php', 'admin');                 
        }
    }

    public function portfolio($id)
    {
        $portfolio = $this->MM->get_data_row( '*', 'portfolio', 'id = '.$id );
        // print_r($portfolio->header_ru);
        if (  $portfolio != FALSE )
        {
            $this->data['status'] = 1;
            $this->data['portfolio'] = $portfolio;
        }else{
            show_404();
        }

        $this->render(NULL, 'json');     
       
    }

    public function portfolio_add()
    {
        if ( $this->input->is_ajax_request() && $this->input->post() ) {
            $this->form_validation->set_rules('header', 'Название кейса', 'trim|required|max_length[50]|htmlspecialchars');
            $this->form_validation->set_rules('description', 'Описание кейса', 'trim|required|htmlspecialchars');
            $this->form_validation->set_rules('img', 'Изображение', 'callback_validate_pic|trim|required');

            if ($this->form_validation->run() === TRUE)
            {
                $data = array( 
                    'header' => $this->input->post('header'),
                    'description' => $this->input->post('description')
                );
                
                $portfolio_add = $this->MM->insert_data( 'portfolio', $data, TRUE );
                // if ( pathinfo( $this->input->post('img_desctop') )['extension'] === pathinfo( $this->input->post('img_mobile') )['extension']  )
                // {
                // }else{
                //     $this->data['status'] = 0;
                //     $this->data['message'] = 'Разширения картинок должны совпадать';
                // }                
                if ( $portfolio_add != FALSE )
                {
                    $new_name = time();
                    $portfolio_img_upload = $this->image_upload( 'img', './assets/img/cases/'.$portfolio_add.'/', $new_name );
                    $portfolio_background_upload = $this->image_upload( 'img', './assets/img/cases/'.$portfolio_add.'/background/', $new_name );
                    if ( ( $portfolio_img_upload['status'] === TRUE ) && ( $portfolio_background_upload['status'] === TRUE ) )
                    {
                        $update_portfolio_img = $this->MM->update_data('id ='.$portfolio_add, array( 'img' => $portfolio_img_upload['new_image'] ), 'portfolio' );

                        if ( $update_portfolio_img === TRUE ) {
                            $this->data['status'] = 1;
                            $this->data['id'] = $portfolio_add;
                            $this->data['header'] = $this->input->post( 'header' );
                            $this->data['description'] = $this->input->post( 'description' );
                            $this->data['img'] = base_url( '/assets/img/cases/'.$portfolio_add.'/'.$portfolio_img_upload['new_image'] );
                            
                            $this->data['message'] = 'Кейс добавлен';
                        }else{
                            $this->data['status'] = 0;
                            $this->data['message'] = 'Ошибка при загрузке имени изображения в базу данных';
                        }
                        
                    }else{
                        $this->data['status'] = 0;
                        $this->MM->delete_data( 'id ='.$portfolio_add, 'portfolio' );
                        $this->data['message'] = $portfolio_img_upload['message'];
                    }
                }else{
                    $this->data['status'] = 0;
                    $this->data['message'] = 'Ошибка при внесении кейса в базу данных';
                }
            }else{
                $this->data['status'] = 0;
                $this->data['message'] = validation_errors();
            }
        }

        $this->data['post_post_debug'] = $this->input->post();

        $this->render(NULL, 'json');
    }

    public function portfolio_edit($id)
    {
        if ( $this->input->is_ajax_request() && $this->input->post() ) {
            $this->form_validation->set_rules('header', 'Название кейса', 'trim|required|max_length[50]|htmlspecialchars');
            $this->form_validation->set_rules('description', 'Описание кейса', 'trim|required|htmlspecialchars');
            if ( !empty($this->input->post('img') ) ) {
                $this->form_validation->set_rules('img', 'Изображение', 'callback_validate_pic|trim|required');
                $this->form_validation->set_rules('old_img', 'Старое изображение', 'trim|required');
            }

            if ($this->form_validation->run() === TRUE)
            {
                $data = array( 
                    'header' => $this->input->post('header'),
                    'description' => $this->input->post('description'),
                );

                if ( !empty($this->input->post('img') ) )
                {
                    $garbage_collect = unlink( './assets/img/cases/'.$id.'/'.$this->input->post('old_img') );
                    
                    if (  $garbage_collect === TRUE ) {
                        $new_name = time();
                        $portfolio_img_upload = $this->image_upload('img', './assets/img/cases/'.$id.'/', $new_name);

                        if (  $portfolio_img_upload['status'] === TRUE ) {
                            
                            $new_image = $data['img'] = $portfolio_img_upload['new_image'];                            
                        }else{
                            $this->data['status'] = 0;
                            $this->data['message'] = $portfolio_img_upload['message'];
                        }
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Garbage Collector failed';
                    }
                }else{
                    $new_image = $this->input->post('old_img');
                }

                if ( !empty($this->input->post('img') ) ) {
                    if ($portfolio_img_upload['status'] === TRUE) {
                        $update_portfolio = $this->MM->update_data('id ='.$id, $data, 'portfolio' );
                        if ( $update_portfolio === TRUE ) {
                            $this->data['id'] = $id;
                            $this->data['header'] = $this->input->post( 'header' );
                            $this->data['description'] = $this->input->post( 'description' );
                            $this->data['img'] = base_url( '/assets/img/cases/'.$id.'/'.$new_image );
                            
                            $this->data['status'] = 1;
                            $this->data['message'] = 'Кейс обновлен';
                        }else{
                            $this->data['status'] = 0;
                            $this->data['message'] = 'Ошибка при обновлении кейса';
                        }
                    }
                }else{
                    $update_portfolio = $this->MM->update_data('id ='.$id, $data, 'portfolio' );
                    if ( $update_portfolio === TRUE ) {
                        $this->data['id'] = $id;
                        $this->data['header'] = $this->input->post( 'header' );
                        $this->data['description'] = $this->input->post( 'description' );
                        $this->data['img'] = base_url( '/assets/img/cases/'.$id.'/'.$new_image );
                        
                        $this->data['status'] = 1;
                        $this->data['message'] = 'Кейс обновлен';
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Ошибка при обновлении кейса';
                    }
                }

            }else{
                $this->data['status'] = 0;
                $this->data['message'] = validation_errors();
            }
        }

        $this->render(NULL, 'json');
    }

    public function portfolio_delete($id)
    {   
        if ( $this->input->is_ajax_request() ) {

            if ( ( $this->directory_delete( './assets/img/cases/'.$id ) === TRUE ) && ( $this->MM->delete_data( 'id ='.$id, 'portfolio' ) ) ) {
                $this->data['status'] = 1;
                $this->data['message'] = 'Кейс удален';
            }else{
                $this->data['status'] = 0;
                $this->data['message'] = 'Кейс не удален';
            }
                
        }           

        $this->render(NULL, 'json');
    }

    public function validate_pic($str)
    {
        if ( !empty($str) ) {          
            switch ( pathinfo( $str )['extension'] ) {
                case "png":
                case "jpg":
                case "gif":
                case "svg":

                    if ( $_FILES['img']['size'] >= 3670016 ) {
                        $this->form_validation->set_message('validate_pic', 'Изображение превышает допустимый размер');
                        return FALSE;
                    }else{
                        return TRUE;
                    }
                    break;

                default:
                    $this->form_validation->set_message('validate_pic', 'Неверный формат файла в поле {field}');
                    return FALSE;
                    break;
            }
        }else{
            $this->form_validation->set_message('validate_pic', 'Поле {field} не должно быть пустым');
            return FALSE;
        }
    }
}