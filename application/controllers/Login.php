<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Login extends MY_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    }

    /**
     * Log the user in
     */
    public function login()
    {
        if($this->ion_auth->logged_in()===TRUE)
        {
            return redirect('/admin');
        }

        if ( $this->input->is_ajax_request() == TRUE  && $this->input->post() )
        {   
            // validate form input
            $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required|trim');
            $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required|trim');

            if ($this->form_validation->run() === TRUE)
            {
                // check for "remember me"
                $remember = (bool)$this->input->post('remember');

                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
                {
                    //if the login is successful
                    $this->data['status'] = 1;
                    $this->data['new_location'] = base_url( 'admin' );
                }else{
                    // if the login was un-successful
                    $this->data['status'] = 0;
                    $this->data['message'] = $this->ion_auth->errors();                
                }
            }else{
                $this->data['status'] = 0;
                $this->data['message'] = validation_errors();
            }

            $this->render(NULL, 'json');
        }else{
            $this->render('gorizont/admin/login.php', 'singlepage');
        }
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        if ( $this->ion_auth->logout() ) {
            $this->data['status'] = 1;
            $this->data['new_location'] = base_url();
        }else{
            $this->data['message'] = "logout";
            $this->data['status'] = 0;
        }
        
        $this->render(NULL, 'json');
    }


    /**
     * Create a new user
     */
    public function create_user()
    {
        if( $this->ion_auth->logged_in()===TRUE && $this->input->post() )
        {
            return $this->output->set_status_header('400');
        }

        if ( $this->input->is_ajax_request() == TRUE )
        {            
            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;

            // validate form input


            if ($identity_column !== 'email')
            {
                $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|htmlspecialchars|is_unique[users.email]');
            }else{
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|htmlspecialchars|required|valid_email|is_unique[' . $tables['users'] . '.email]');
            }

            // $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
            // $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
            $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required|htmlspecialchars');
            // $this->form_validation->set_rules($this->input->ip_address();,'Ip','is_unique[users.ip_address]');
            

            if ($this->form_validation->run() === TRUE)
            {
                $email = strtolower($this->input->post('email'));
                $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
                $password = $this->input->post('password');
                $username = $this->input->post('username');

                $additional_data = [
                    // 'first_name' => $this->input->post('first_name'),
                    // 'last_name' => $this->input->post('last_name'),
                    // 'company' => $this->input->post('company'),
                    // 'phone' => $this->input->post('phone'),
                ];

                $group = array(1=>'1'); // Sets user to admin.

                if ($this->ion_auth->register($identity, $password, $email, $username, $additional_data ) ) {
                    $this->data['status'] = 1;
                    $this->data['message'] = $this->ion_auth->messages();
                    // $this->data['debug'] = $this->ion_auth->register($identity, $password, $email, $username, $additional_data);
                }else{
                    $this->data['status'] = 0;
                    // $this->data['message'] += 'error';
                    $this->data['message'] = $this->ion_auth->errors();
                }
            }else{
                // display the create user form
                // set the flash data error message if there is one
                $this->data['status'] = 0;
                $this->data['message'] = validation_errors();
            }
            $this->render(NULL, 'json');
        }else{
            $this->render('gorizont/admin/register.php', 'singlepage');
        }
    }
}
