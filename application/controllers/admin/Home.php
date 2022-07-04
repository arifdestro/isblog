<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
    }

    public function index()
    {
        $x['judul'] = 'Beranda | KD-ADMIN';
        $id_user = $this->session->userdata('id_usr');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();
        $akses = $x['user']['id_role'];
        $x['tag'] = $this->db->query("SELECT COUNT(DISTINCT nama_tag) AS tag FROM tag")->row_array();
        $x['komentar'] = $this->db->query("SELECT * FROM komentar")->num_rows();
        $x['kategori'] = $this->db->query("SELECT * FROM kategori")->num_rows();
        $x['post'] = $this->db->query("SELECT * FROM post WHERE status_post = 1")->num_rows();
        $x['users'] = $this->db->query("SELECT * FROM user WHERE user.id_role != '{$akses}'")->result_array();
        $this->load->view('template_adm/v_header', $x);
        $this->load->view('template_adm/v_navbar', $x);
        $this->load->view('template_adm/v_sidebar', $x);
        $this->load->view('admin/home', $x);
        $this->load->view('template_adm/v_footer');
    }
}
