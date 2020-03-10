<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Case_handler extends MY_Controller {

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

    public function index($id)
    {
        $portfolio = $this->MM->get_data_row( 'id, header', 'portfolio', 'id = '.$id );
        // print_r($portfolio->header_ru);
        if ( $portfolio != FALSE )
        {
            $case = $this->MM->get_data_array( '*', 'cases', 'portfolio_id = '.$id, NULL, NULL, 'position ASC');
            $this->data['status'] = 1;
            $this->data['portfolio'] = $portfolio;
            $this->data['elements'] = $case;
        }else{
            show_404();
        }
            
        if ( !$this->input->is_ajax_request() )
        {
            if ( ! file_exists($this->check_path.'case.php'))
            {
                // Whoops, we don't have a page for that!
                show_404();
            }

            $this->render($this->template_path.'case.php', 'admin');                 
        }else{
            $this->render(NULL, 'json'); 
        }
    }

    public function element_add( $type, $portfolio_id )
    {
        if ( ($type < 1) || ( $type > 5 ) ) {
            $this->output->set_status_header('400');
        }

        if ( $this->input->is_ajax_request() && $this->input->post() ) {

            if ( $type == 1 ) {
                $this->form_validation->set_rules('header', 'Текст заголовка', 'trim|required|max_length[100]|htmlspecialchars');
            }elseif ( $type == 2 ) {
                $this->form_validation->set_rules('text', 'Текст', 'trim|required|htmlspecialchars');
            }elseif ( $type == 3 ) {
                $this->form_validation->set_rules('img', 'Изображение', 'callback_validate_pic|trim|required');
            }elseif ( $type == 4 ){
                $this->form_validation->set_rules('slider', 'Hidden slider input', 'trim|required');
            }elseif ( $type == 5 ) {
                $this->form_validation->set_rules('img', 'Изображение', 'callback_validate_pic|trim|required');
                $this->form_validation->set_rules('slider_position', 'slider id', 'trim|required|integer');
                $this->form_validation->set_rules('slider_id', 'slider id', 'trim|required|integer');
            }else{

            }

            if ($this->form_validation->run() === TRUE)
            {
                $last_element = $this->MM->get_data_row( 'position', 'cases', 'portfolio_id = '.$portfolio_id, 'position DESC', 1 );

                if ( $last_element != FALSE ) {
                    $element_position = ++$last_element->position;
                }else{
                    $element_position = 1;
                }
                // $this->data['status'] = 1;
                //         $this->data['debug_elements'] = $element_position;
                if ( $type == 1 || $type == 2 ) {

                    if ($type ==1 ) {
                        $name = 'header';
                    }else{
                        $name = 'text';
                    }
                    $data = array(
                        'name' => $name,
                        'value' => $this->input->post($name),
                        'position' => $element_position,
                        'portfolio_id' => $portfolio_id
                    );

                    $element_add = $this->MM->insert_data( 'cases', $data, TRUE );

                    if ( $element_add != FALSE )
                    {
                        $this->data['status'] = 1;
                        $this->data['message'] = 'Элемент добавлен';
                        $this->data['response'] = $this->get_response_object( $type, 'create', 
                                array(
                                    'id' => $element_add,
                                    'text' => substr($this->input->post($name), 0, 15).'...',
                                )
                            );
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Ошибка при создании элемента';
                    }
                }elseif ( $type == 3 ) {
                    
                    $data = array(
                        'name' => 'image',
                        'position' => $element_position,
                        'portfolio_id' => $portfolio_id
                    );

                    $element_add = $this->MM->insert_data( 'cases', $data, TRUE );

                    if ( $element_add != FALSE )
                    {
                        $new_name = time();

                        $img_upload = $this->image_upload( 'img', './assets/img/cases/'.$portfolio_id.'/'.$element_position.'/', $new_name );
                        if (  $img_upload['status'] === TRUE )
                        {
                            
                            $this->data['status'] = 1;
                            $this->data['message'] = 'Элемент добавлен';
                            $this->data['response'] = $this->get_response_object( $type, 'create', 
                                array(
                                    'id' => $element_add,
                                    'img' => $img_upload['new_image'],
                                    'position' => $element_position,
                                    'img_path' => base_url( '/assets/img/cases/'.$portfolio_id.'/'.$element_position.'/'.$img_upload['new_image'] ),
                                )
                            );                              
                        }else{
                            $this->data['status'] = 0;
                            $this->data['message'] = $img_upload['message'];
                        }
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Ошибка при создании элемента';
                    }
                }elseif ( $type == 4 ){
                    $data = array(
                        'name' => 'slider',
                        'position' => $element_position,
                        'portfolio_id' => $portfolio_id
                    );

                    $element_add = $this->MM->insert_data( 'cases', $data, TRUE );

                    if ( $element_add != FALSE )
                    {
                        $directory_create = $this->directory_create( './assets/img/cases/'.$portfolio_id.'/'.$element_position.'/' );
                        if (  $directory_create['status'] === TRUE )
                        {
                            $this->data['status'] = 1;
                            $this->data['message'] = 'Элемент добавлен';
                            $this->data['response'] = $this->get_response_object( $type, 'create', 
                                array(
                                    'id' => $element_add,
                                    'position' => $element_position,
                                )
                            );                              
                        }else{
                            $this->data['status'] = 0;
                            $this->data['message'] = $img_upload['message'];
                        }
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Ошибка при создании элемента';
                    }
                }else{
                    $img_upload = $this->image_upload( 'img', './assets/img/cases/'.$portfolio_id.'/'.$this->input->post('slider_position').'/', time() );
                    if (  $img_upload['status'] === TRUE )
                    {
                        
                        $this->data['status'] = $this->data['slider'] = 1;
                        $this->data['slider_id'] = $this->input->post('slider_id');
                        $this->data['message'] = 'Элемент добавлен';
                        $this->data['response'] = $this->get_response_object( $type, 'create', 
                            array(
                                'img' => $img_upload['new_image'],
                                'img_path' => base_url( '/assets/img/cases/'.$portfolio_id.'/'.$this->input->post('slider_position').'/'.$img_upload['new_image'] ),
                                'type' => $type
                            )
                        );                              
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = $img_upload['message'];
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
        if ( ($type < 1) || ( $type > 4 ) ) {
            $this->output->set_status_header('400');
        }

        if ( $this->input->is_ajax_request() && $this->input->post() ) {

            if ( $type == 1 ) {
                $this->form_validation->set_rules('header', 'Текст заголовка', 'trim|required|max_length[100]|htmlspecialchars');
            }elseif ( $type == 2 ) {
                $this->form_validation->set_rules('text', 'Текст', 'trim|required|htmlspecialchars');
            }elseif ( ($type == 3 ) || ( $type == 4)  ) {
                $this->form_validation->set_rules('img', 'Изображение', 'callback_validate_pic|trim|required');
            }

            if ($this->form_validation->run() === TRUE)
            {
                
                if ( ($type == 1) || ($type == 2) ) {

                    if ( $type == 1 ) {
                        $value = $this->input->post('header');
                    }else{
                        $value = $this->input->post('text');
                    }

                    $data = array(
                        'value' => $value
                    );

                    $update_data = $this->MM->update_data('id ='.$id, $data, 'cases' );

                    if ( $update_data != FALSE )
                    {
                        $this->data['status'] = 1;
                        $this->data['message'] = 'Элемент обновлен';
                        $this->data['response'] = substr($value, 0, 15);
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = 'Ошибка при обновлении';
                    }
                }elseif ( ($type == 3) || ($type == 4) ) {
                    $new_name = time();
                    if ( $type == 3 ) {
                        $portfolio = $this->MM->get_data_row( 'portfolio_id, position', 'cases', 'id = '.$id );
                        $portfolio_id = $portfolio->portfolio_id;
                        $position = $portfolio->position;
                        
                    }else{
                        $portfolio_id = $id;
                        $this->data['target'] = $position = 'background';
                    }

                    $garbage_collect = $this->files_delete( './assets/img/cases/'.$portfolio_id.'/'.$position.'/' );
                    $img_upload = $this->image_upload( 'img', './assets/img/cases/'.$portfolio_id.'/'.$position.'/', $new_name );
                    if (  $img_upload['status'] === TRUE )
                    {
                        $this->data['status'] = 1;
                        $this->data['message'] = 'Элемент добавлен';
                        $this->data['response'] = '<img src="'.base_url( '/assets/img/cases/'.$portfolio_id.'/'.$position.'/'.$img_upload['new_image'] ).'" class="img-fluid">';               
                    }else{
                        $this->data['status'] = 0;
                        $this->data['message'] = $img_upload['message'];
                    }       
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
        if ( ($type < 1) || ( $type > 5 ) ) {
            $this->output->set_status_header('400');
        }

        if ( $this->input->is_ajax_request() ) {
            if ( ($type == 1) || ($type == 2) ) {

                $delete_data = $this->MM->delete_data( 'id ='.$id, 'cases' );

                if ( $delete_data != FALSE )
                {
                    $this->data['status'] = 1;
                    $this->data['message'] = 'Элемент удален';
                    $this->data['element'] = 'element_'.$id;
                }else{
                    $this->data['status'] = 0;
                    $this->data['message'] = 'Ошибка при удалении';
                }
            }elseif ( ($type == 3) || ($type == 4) ) {
                $portfolio = $this->MM->get_data_row( 'portfolio_id, position', 'cases', 'id = '.$id );
                if ( ( $this->directory_delete( './assets/img/cases/'.$portfolio->portfolio_id.'/'.$portfolio->position.'/' ) === TRUE ) && ( $this->MM->delete_data( 'id ='.$id, 'cases' ) ) ) {
                    $this->data['status'] = 1;
                    $this->data['message'] = 'Элемент удален';
                    $this->data['element'] = 'element_'.$id;
                }else{
                    $this->data['status'] = 0;
                    $this->data['message'] = 'Элемент не удален';
                }  
            }elseif ( $type == 5 ) {
                if (unlink( $this->input->post('slide_name')))// delete file
                {
                  $this->data['status'] = 1;
                    $this->data['message'] = 'Элемент удален';
                    $this->data['element'] = 'element_'.$id;
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
        if ( ($type < 1) || ( $type > 3 ) ) {
            $this->output->set_status_header('400');
        }


        if ( ($type == 1) || ($type == 2) ) {
            $get_data = $this->MM->get_data_row( 'value', 'cases', 'id = '.$id );

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
        }elseif ( $type == 3 ) {
           $this->data['status'] = 1;
                $this->data['message'] = 'Форма';
                $this->data['response'] = $this->get_response_object( $type, 'edit', 
                        array(
                            'id' => $id
                        )
                    );
        }

        $this->data['post_post_debug'] = $this->input->post();

        $this->render(NULL, 'json');
    }

    public function get_response_object($type, $mode, $data)
    {
        if ( $mode == 'create' ) {
            
            switch ( $type ) {
                case 1:
                case 2:
                    if ($type == '1') {
                        $color = 'info';
                    }
                    if ($type == '2') {
                        $color = 'primary';
                    }
                    $response =
                        '<div class="col-12 mt-1">'.
                            '<div id="element_'.$data['id'].'" class="card mx-auto border-left-'.$color.' shadow mb-2">'.
                                '<div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">'.
                                    '<h6 id="element_body_'.$data['id'].'" class="m-0 font-weight-bold text-primary mx-auto">'.
                                        $data['text'].
                                    '</h6>'.
                                    ' <a role="button" onclick="elementsModalHandler( \'edit\', '.$data['id'].', \' '.$data['text'].'\', '.$type.' )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'.
                                    ' <a role="button" onclick="elementsModalHandler( \'delete\', '.$data['id'].', \' '.$data['text'].'\', '.$type.' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'.
                                '</div>'.
                            '</div>'.
                        '</div>';
                break;
                case 3:
                    $response = 
                        '<div class="col-12 mt-1">'.
                            '<div id="element_'.$data['id'].'" class="card mx-auto border-left-warning shadow mb-2">'.
                                '<div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">'.
                                    '<span id="element_body_'.$data['id'].'" class="m-0 mx-auto">'.
                                        '<img src="'.$data['img_path'].'" class="img-fluid">'.
                                    '</span>'.
                                    ' <a role="button" onclick="elementsModalHandler( \'edit\', '.$data['id'].', \''.$data['img'].'\', '.$type.' )" class="mx-2 btn btn-info"><i class="fas fa-pencil-alt text-white"></i></a>'.
                                    ' <a role="button" onclick="elementsModalHandler( \'delete\', '.$data['id'].', \' '.$data['img'].' \', '.$type.' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'.
                                '</div>'.
                            '</div>'.
                        '</div>';
                break;

                case 4:
                $slide = $type + 1;
                    $response = 
                        '<div class="col-12 mt-1">'.
                            '<div id="element_'.$data['id'].'" class="card mx-auto border-left-danger shadow mb-2">'.
                                '<div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">'.
                                    ' <a role="button" data-toggle="tooltip" data-placement="auto" title="Добавить слайд" onclick="elementsModalHandler( \'add_slider_item\', '.$data['id'].', \'Слайдер\', '.$data['position'].')" class="mx-2 btn btn-success"><i class="fa fa-plus text-white"></i></a>'.
                                    ' <a role="button" data-toggle="tooltip" data-placement="auto" title="Удалить текущий слайд" onclick="elementsModalHandler( \'delete\', '.$data['id'].', \'Слайд\', '.$slide.' )" class="btn btn-warning"><i class="fa fa-trash-alt text-white"></i></a>'.
                                    ' <a role="button" data-toggle="tooltip" data-placement="auto" title="Удалить слайдер" onclick="elementsModalHandler( \'delete\', '.$data['id'].', \'Слайдер\', '.$type.' )" class="btn btn-danger"><i class="fa fa-trash-alt text-white"></i></a>'.
                                '</div>'.
                                '<div class="card-body py-1 d-flex flex-row align-items-center justify-content-between">'.
                                    '<div id="carousel_'.$data['id'].'" class="carousel slide" data-ride="carousel">'.
                                        '<div class="carousel-inner" id="carousel_container_'.$data['id'].'">'.
                                        '</div>'.
                                        '<a class="carousel-control-prev" href="#carousel_'.$data['id'].'" role="button" data-slide="prev">'.
                                            '<span class="carousel-control-prev-icon" aria-hidden="true"></span>'.
                                            '<span class="sr-only">Previous</span>'.
                                        '</a>'.
                                        '<a class="carousel-control-next" href="#carousel_'.$data['id'].'" role="button" data-slide="next">'.
                                            '<span class="carousel-control-next-icon" aria-hidden="true"></span>'.
                                            '<span class="sr-only">Next</span>'.
                                        '</a>'.
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>';
                                
                break;

                case 5:
                    $response =
                        '<div class="carousel-item active">'.
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
                        $header = 'Текст заголовка';
                        $button = 'Редактировать заголовок';
                        $input = '<input type="text" name="header" class="form-control" id="inputName" value="'.$data['text'].'" placeholder="Текст заголовка">';
                    }
                    if ($type == '2') {
                        $header = 'Текст';
                        $button = 'Редактировать текст';
                        $input = '<textarea class="form-control" id="inputName" rows="3" name="text">'.$data['text'].'</textarea>';
                    }
                    $response =
                        '<div class="form-group">'.
                            '<label for="inputName">'.$header.'</label>'.
                            $input.
                        '</div>'.
                        '<div class="form-group">'.
                            '<a role="button" class="btn btn-info text-white" onclick="editelement('.$data['id'].', '.$type.')">'.$button.'</a>'.
                        '</div>';
                break;
                case 3:
                    $response = 
                        '<div class="form-group">'.
                            '<label for="inputLogo">Изображение(разрешенные форматы: jpeg, gif, png; 1920х1080, до 2мб )</label>'.
                            '<input type="file" name="img" id="inputLogo" class="form-control">'.
                        '</div>'.
                        '<div class="form-group">'.
                            '<a role="button" class="btn btn-info text-white" onclick="editelement('.$data['id'].', '.$type.')">Изменить изображение</a>'.
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