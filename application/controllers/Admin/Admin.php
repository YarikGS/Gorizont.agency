<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!$this->ion_auth->logged_in()===TRUE && !$this->ion_auth->is_admin() )
        {
            redirect('/');
        }

        $this->check_path = APPPATH.'views/gorizont/admin/';
        $this->template_path = 'gorizont/admin/';
        // $this->lang->load('user', $this->session->userdata('lang') );
        $this->user_data = $this->ion_auth->user()->row();
        $this->load->model('My_Model','MM');
        $this->load->helper('file');
    }

    public function index()
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
        if ( $captions != FALSE ) {
            $this->data['captions'] = $captions;
        }

        $this->render($this->template_path.'index.php', 'admin');
    }

    public function element_add( $type )
    {
        if ( ($type < 1) || ( $type > 3 ) ) {
            $this->output->set_status_header('400');
        }

        if ( $this->input->is_ajax_request() && $this->input->post() ) {

            if ( $type == 1 ) {
                $this->form_validation->set_rules('header', 'Заголовок колонки', 'trim|required|max_length[50]|htmlspecialchars');
            }elseif ( $type == 2 ) {
                $this->form_validation->set_rules('header', 'Название услуги', 'trim|required|max_length[50]|htmlspecialchars');
                $this->form_validation->set_rules('section_id', 'id колонки', 'trim|required|integer');
            }elseif ( $type == 3 ) {
                $this->form_validation->set_rules('img_desctop', 'Изображение для компьютера', 'callback_validate_pic|trim|required');
                $this->form_validation->set_rules('img_mobile', 'Изображение для телефона', 'callback_validate_pic|trim|required');
            }else{

            }

            if ($this->form_validation->run() === TRUE)
            {
                // $this->data['status'] = 1;
                //         $this->data['debug_elements'] = $element_position;
                if ( $type == 1 || $type == 2 ) {

                    $data = array(
                        'value' => $this->input->post('header')
                    );

                    if ($type == 2 ) {
                        $data['parental_id'] = $this->input->post('section_id');
                    }

                    $element_add = $this->MM->insert_data( 'main_sections', $data, TRUE );

                    if ( $element_add != FALSE )
                    {
                        if ($type == 1 ) {
                            $this->data['target_block'] = 'services_container';
                        }else{
                            $this->data['target_block'] = 'service_'.$this->input->post('section_id');
                        }
                        $this->data['status'] = 1;
                        $this->data['message'] = 'Элемент добавлен';
                        $this->data['response'] = $this->get_response_object( $type, 'create', 
                                array(
                                    'id' => $element_add,
                                    'text' => $this->input->post('header'),
                                )
                            );
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Ошибка при создании элемента';
                    }
                }elseif ( $type == 3 ) {
                    $name = time();
                    $this->data['img_ext_mobile'] = pathinfo( $this->input->post('img_mobile') )['extension'];
                    $this->data['img_ext_desctop'] = pathinfo( $this->input->post('img_desctop') )['extension'];
                    $this->data['mime_here'] = get_filenames( $this->input->post('img_desctop') );
                    if ( ( pathinfo( $this->input->post('img_mobile') )['extension'] ) == ( pathinfo( $this->input->post('img_desctop') )['extension'] ) ) {
                        $img_upload_desctop = $this->image_upload( 'img_desctop', './assets/img/BigSlider/desctop/', $name );
                        $img_upload_mobile = $this->image_upload( 'img_mobile', './assets/img/BigSlider/mobile/', $name );
                        $this->fixSliderDiff();
                        if (  ($img_upload_desctop['status'] === TRUE) && ($img_upload_mobile['status'] === TRUE) )
                        {
                            if ( $this->input->post('active') != 'active' ) {
                                $active = '';
                            }else{
                                $active = 'active';
                            }
                            $this->data['status'] = $this->data['slider'] = 1;
                            $this->data['target_block'] = 'big_slider_container';
                            $this->data['message'] = 'Элемент добавлен';
                            $this->data['response'] = $this->get_response_object( $type, 'create', 
                                array(
                                    'img' => $img_upload_desctop['new_image'],
                                    'img_path' => base_url( '/assets/img/BigSlider/desctop/'.$img_upload_desctop['new_image'] ),
                                    'active' => $active,
                                    'type' => $type
                                )
                            );                              
                        }else{
                            $this->data['status'] = 0;
                            if ( !empty( $img_upload_desctop['message'] ) ){
                                $desctop_error = $img_upload_desctop['message'];
                            }else{
                                $desctop_error = '';
                            }
                            if ( !empty( $img_upload_mobile['message'] ) ){
                                $mobile_error = $img_upload_mobile['message'];
                            }else{
                                $mobile_error = '';
                            }
                            $this->data['message'] = $desctop_error.' '.$mobile_error;
                        }
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Изображения должны иметь одинаковые расширения';
                    }
                }
            }else{
                $this->data['status'] = 0;
                $this->data['message'] = validation_errors();
            }
        }

        $this->data['post_post_debug'] = $this->input->post();

        $this->render(NULL, 'json');
    }

    public function element_edit($id, $type)
    {
        if ( ($type < 1) || ( $type > 9 ) ) {
            $this->output->set_status_header('400');
        }

        if ( $this->input->is_ajax_request() && $this->input->post() ) {
            //1-section column, 2-section column item, 3 pdf link, 4- main title, 5-main text, 6 - contacts 7,8,9 - statistic
            if ( ($type == 1) || ( $type == 2 ) ) {
                $this->form_validation->set_rules('caption', 'Текст', 'trim|required|max_length[50]|htmlspecialchars');
            }elseif ( ($type > 2) && ($type <=6) ) {
                $this->form_validation->set_rules('caption', 'Значение', 'htmlspecialchars');
                
            }else if ( $type > 6 ){
                $this->form_validation->set_rules('caption', 'Значение', 'trim|integer|greater_than_equal_to[0]|less_than_equal_to[99999]');
                $this->form_validation->set_rules('comments', 'Описание параметра', 'trim');
            }

            if ($this->form_validation->run() === TRUE)
            {
                
                if ( ($type == 1) || ($type == 2) ) {
                    $table = 'main_sections';

                    if ($type == 1) {
                        $this->data['target_block'] = 'service_caption_'.$id;
                    }else{
                        $this->data['target_block'] = 'service_item_caption_'.$id;
                    }
                }elseif ( $type > 2 ) {
                    $table = 'main_captions';
                }
                $data = array(
                    'value' => $this->input->post('caption')
                );
                $comments = '';
                if ( $type > 6 ) {
                    $data['comments'] = $this->input->post('comments');
                    $comments = ' : '.$this->input->post('comments');
                }
                $update_data = $this->MM->update_data('id ='.$id, $data, $table );

                    if ( $update_data != FALSE )
                    {
                        $this->data['status'] = 1;
                        $this->data['message'] = 'Элемент обновлен';
                        $this->data['response'] = $this->input->post('caption').$comments;
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Ошибка при обновлении';
                    }
            }else{
                $this->data['status'] = 0;
                $this->data['message'] = validation_errors();
            }
            $this->data['post_post_debug'] = $this->input->post();

            $this->render(NULL, 'json');
        }
    }

    public function element_delete( $id, $type )
    {   
        if ( ($type < 1) || ( $type > 3 ) ) {
            $this->output->set_status_header('400');
        }

        if ( $this->input->is_ajax_request() ) {
            if ( ($type == 1) || ($type == 2) ) {

                if ($type == 1) {
                    $where = 'id = '.$id.' OR parental_id = '.$id;
                    $element = 'service_'.$id;
                }else{
                    $where = 'id = '.$id;
                    $element = 'service_item_'.$id;
                }
                $delete_data = $this->MM->delete_data( $where, 'main_sections' );

                if ( $delete_data != FALSE )
                {
                    $this->data['status'] = 1;
                    $this->data['message'] = 'Элемент удален';
                    $this->data['element'] = $element;
                }else{
                    $this->data['status'] = 0;
                    $this->data['message'] = 'Ошибка при удалении';
                }
            }elseif ( $type == 3 ) {
                $name=$this->input->post('slide_name');
                if ( unlink('./assets/img/BigSlider/desctop/'.$name) && unlink('./assets/img/BigSlider/mobile/'.$name) )// delete file
                {
                  $this->data['status'] = 1;
                    $this->data['message'] = 'Элемент удален';
                    // $this->data['element'] = 'element_'.$id;
                }else{
                  $this->data['status'] = 0;
                    $this->data['message'] = 'Элемент не удален';
                }
            }
            $this->data['post_post_debug'] = $this->input->post();
                
        }           

        $this->render(NULL, 'json');
    }

    public function element_modal( $id, $type )
    {
        //1-section column, 2-section column item, 3 pdf link, 4- main title, 5-main text, 6 - contacts 7,8,9 - statistic
        if ( ($type < 1) || ( $type > 9 ) ) {
            $this->output->set_status_header('400');
        }


        if ( ($type == 1) || ($type == 2) ) {
            $get_data = $this->MM->get_data_row( 'value', 'main_sections', 'id = '.$id );

            if ($get_data != FALSE) {
                $this->data['status'] = 1;
                $this->data['message'] = 'Форма';
                $this->data['response'] = $this->get_response_object( $type, 'edit', 
                        array(
                            'id' => $id,
                            'text' => $get_data->value,
                        )
                    );
            }else{
                $this->data['status'] = 0;
                $this->data['message'] = 'Ошибка при при получении данных';
            }
        }elseif ( $type > 2 ) {
           $get_data = $this->MM->get_data_row( 'value, comments', 'main_captions', 'id = '.$id );

            if ($get_data != FALSE) {

                $data = array(
                    'id' => $id,
                    'text' => $get_data->value
                );

                if ( $type > 6 ){
                    $data['text2'] = $get_data->comments;
                }

                $this->data['status'] = 1;
                $this->data['message'] = 'Форма';
                $this->data['response'] = $this->get_response_object( $type, 'edit', $data );
            }else{
                $this->data['status'] = 0;
                $this->data['message'] = 'Ошибка при при получении данных';
            }
        }

        $this->data['post_post_debug'] = $this->input->post();

        $this->render(NULL, 'json');
    }

    public function get_response_object($type, $mode, $data)
    {
        if ( $mode == 'create' ) {
            
            switch ( $type ) {
                case 1:
                    $response =
                        '<div class="card mx-1" style="width: 18rem;" id="service_'.$data['id'].'">'.
                            '<div class="card-header">'.
                                '<span id="service_caption_'.$data['id'].'">'.$data['text'].'</span>'.
                                '<a role="button" data-toggle="tooltip" data-placement="auto" title="Добавить услугу" onclick="elementsModalHandler( \'add\', '.$data['id'].', \'Услугу\', 2)" class="mx-2 btn btn-success"><i class="fa fa-plus text-white"></i></a>'.
                                '<a role="button" onclick="elementsModalHandler( \'edit\', '.$data['id'].', \''.$data['text'].'\', 1 )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'.
                                '<a role="button" onclick="elementsModalHandler( \'delete\', '.$data['id'].', \''.$data['text'].'\', 1 )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'.
                            '</div>'.
                            '<ul class="list-group list-group-flush">'.
                            '</ul>'.
                        '</div>';
                break;
                case 2:
                    $response =
                        '<li class="list-group-item" id="service_item_'.$data['id'].'">'.
                          '<span id="service_item_caption_'.$data['id'].'">'.$data['text'].'</span>'.
                          ' <a role="button" onclick="elementsModalHandler( \'edit\', '.$data['id'].', \''.$data['text'].'\', 2 )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'.
                          ' <a role="button" onclick="elementsModalHandler( \'delete\', '.$data['id'].', \''.$data['text'].'\', 2 )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'.
                        '</li>';
                break;

                case 3:
                    $response =
                        '<div class="carousel-item '.$data['active'].'">'.
                          '<img src="'.$data['img_path'].'" class="d-block w-100" alt="slide '.$data['img'].'">'.
                        '</div>';
                break;
                
                default:
                    $response = FALSE;
                    break;
            }
            return $response;
        }else{
            switch ( $type ) {
                case 1:
                case 2:
                    if ($type == '1') {
                        $header = 'Текст колонки';
                        $button = 'Редактировать колонку';
                    }
                    if ($type == '2') {
                        $header = 'Текст услуги';
                        $button = 'Редактировать услуги';
                    }
                    $response =
                        '<div class="form-group">'.
                            '<label for="inputName">'.$header.'</label>'.
                            '<input type="text" name="caption" class="form-control" id="inputName" value="'.htmlspecialchars($data['text']).'" placeholder="'.$header.'">'.
                        '</div>'.
                        '<div class="form-group">'.
                            '<a role="button" class="btn btn-info text-white" onclick="editelement('.$data['id'].', '.$type.')">'.$button.'</a>'.
                        '</div>';
                break;
                case 3:
                case 4:
                case 5:
                case 6:
                    if ($type == '3') {
                        $header = 'Cсылка на PDF';
                        $button = 'Редактировать ссылку';
                    }
                    if ($type == '4') {
                        $header = 'Заголовок на главной';
                        $button = 'Редактировать заголовок';
                    }

                    if ($type == '5') {
                        $header = 'Текст на главной';
                        $button = 'Редактировать текст';
                    }
                    if ($type == '6') {
                        $header = 'Контакты';
                        $button = 'Редактировать контакты';
                    }
                    $response = 
                        '<div class="form-group">'.
                            '<label for="inputName">'.$header.'</label>'.
                            '<textarea class="form-control" id="inputName" rows="3" name="caption" style="white-space: pre-wrap!important;">'.htmlspecialchars($data['text']).'</textarea>'.
                        '</div>'.
                        '<div class="form-group">'.
                            '<a role="button" class="btn btn-info text-white" onclick="editelement('.$data['id'].', '.$type.')">'.$button.'</a>'.
                        '</div>';
                break;

                case 7:
                case 8:
                case 9:
                    if ($type == '7') {
                        $header = 'Имя параметра Статистики 1';
                        $header2 = 'Значение параметра статистики 1';
                        $button = 'Редактировать Статистику 1';
                    }
                    if ($type == '8') {
                        $header = 'Имя параметра Статистики 2';
                        $header2 = 'Значение параметра статистики 2';
                        $button = 'Редактировать Статистику 2';
                    }

                    if ($type == '9') {
                        $header = 'Имя параметра Статистики 3';
                        $header2 = 'Значение параметра статистики 3';
                        $button = 'Редактировать Статистику 3';
                    }
                    $response =
                        '<div class="form-group">'.
                            '<label for="inputName">'.$header.'</label>'.
                            '<input type="text" name="comments" class="form-control" id="inputName" value="'.$data['text2'].'" placeholder="'.$header.'">'.
                        '</div>'.
                        '<div class="form-group">'.
                            '<label>'.$header2.'(0-999)</label>'.
                            '<input type="number" name="caption" min="10" max="999" class="form-control" value="'.$data['text'].'" placeholder="'.$header2.'">'.
                        '</div>'.
                        '<div class="form-group">'.
                            '<a role="button" class="btn btn-info text-white" onclick="editelement('.$data['id'].', '.$type.')">'.$button.'</a>'.
                        '</div>';
                break;
                
                default:
                    $response = FALSE;
                break;
            }
            return $response;
        }

        
    }

    public function validate_pic($str)
    {
        if ( !empty($str) ) {          
            switch ( pathinfo( $str )['extension'] ) {
                case "png":
                case "jpg":
                case "gif":
                case "svg":

                    // if ( $_FILES['img']['size'] >= 3670016 ) {
                    //     $this->form_validation->set_message('validate_pic', 'Изображение превышает допустимый размер');
                    //     return FALSE;
                    // }else{
                        return TRUE;
                    // }
                    // break;

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

    function fixSliderDiff()
    {
        $mobile_list = get_filenames( dirname(APPPATH).'/assets/img/BigSlider/mobile' );
        $desctop_list = get_filenames( dirname(APPPATH).'/assets/img/BigSlider/desctop' );

        $mob_diff = array_diff($mobile_list, $desctop_list);

        $desc_diff = array_diff($desctop_list, $mobile_list);

        if ( !empty($mob_diff) ) {
            foreach ($mob_diff as $item) {
                unlink('./assets/img/BigSlider/mobile/'.$item);
            }
        }

        if ( !empty($desc_diff) ) {
            foreach ($desc_diff as $item) {
                unlink('./assets/img/BigSlider/desctop/'.$item);
            }
        }
    }
}