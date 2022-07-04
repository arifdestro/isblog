<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!user_logged_in()) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Sesi anda telah habis, silahkan login kembali.
                        </div>');
            return redirect('auth');
        }

        cekakses();

        $this->load->model('M_user', 'm_user');
    }

    public function index()
    {
        $data['judul'] = 'Pengaturan | KD-ADMIN';
        $id_user = $this->session->userdata('id_usr');
        $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();

        $data['data'] = $this->m_user->getAll('pengaturan', 1)->row_array();

        $this->load->view('template_adm/v_header', $data);
        $this->load->view('template_adm/v_navbar', $data);
        $this->load->view('template_adm/v_sidebar', $data);
        $this->load->view('admin/setting', $data);
        $this->load->view('template_adm/v_footer');
    }

    public function update()
    {
        $data['judul'] = 'Pengaturan | KD-ADMIN';
        $id_user = $this->session->userdata('id_usr');
        $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();
        $id_pengaturan = $this->input->post('id_edit', true);
        $mail          = $this->input->post('mail', true);
        $password      = $this->input->post('password', true);
        $secret       = $this->input->post('secret', true);
        $site      = $this->input->post('site', true);

        $val = [
            'recaptcha_site' => $site,
            'recaptcha_secret' => $secret,
            'smtp_mail' => $mail,
            'smtp_password' => $password,
        ];

        $this->db->where('id_pengaturan', $id_pengaturan);
        $this->db->update('pengaturan', $val);

        $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Info!</strong> Anda berhasil mengubah data.
                            <button type="button" class="close py-auto" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        ');
        redirect('admin/setting');
    }
}
