<?php

class Website extends CI_Controller
{
    function __construct()
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

    function index()
    {
        $data['judul'] = 'Backup Data | KD-ADMIN';
        $id_user = $this->session->userdata('id_usr');
        $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();
        // $data['data'] = $this->navbar_model->get_navbar();
        $this->load->view("template_adm/v_header", $data);
        $this->load->view("template_adm/v_navbar", $data);
        $this->load->view("template_adm/v_sidebar", $data);
        $this->load->view("admin/website", $data);
        $this->load->view("template_adm/v_footer");
    }

    public function backup_db()
    {

        $this->load->dbutil();

        $prefs = array(
            'format'      => 'zip',
            'filename'    => "kd_" . date("Y-m-d") . '.sql',
            'add_drop'    => TRUE,
            'add_insert'  => TRUE,
            'newline'     => "\n",
            'foreign_key_checks'    => FALSE,
        );

        $backup = &$this->dbutil->backup($prefs);

        $db_name = "kd_" . date("Ymd-His") . '.zip';
        $save = FCPATH . 'assets/db/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);

        $this->load->helper('download');
        force_download($db_name, $backup);
        unlink(FCPATH . 'assets/db/' . $db_name);
    }

    public function import()
    {
        // $this->m_user->droptable();

        $fupload = $_FILES['data'];
        $nama = $_FILES['data']['name'];

        if (isset($fupload)) {
            $lokasi = $fupload['tmp_name'];
            $direktori = "assets/db/restore/$nama";
            move_uploaded_file($lokasi, "$direktori");
        }

        $isi_file = file_get_contents($direktori);
        $string = rtrim($isi_file, "\n;");
        $array = explode(";", $string);

        foreach ($array as $ar) {
            $this->db->query($ar);
        }

        unlink($direktori);

        $this->session->set_flashdata('pesan', '
        <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil direstore.
        </div>');
        redirect('admin/database');
    }
}
