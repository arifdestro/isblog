<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!user_logged_in()) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-warning alert-dismissible fade show" role="alert">
                        Sesi anda telah habis, silahkan login kembali.
                        </div>');
            return redirect('auth');
        }

        cekakses();

        $this->load->model('M_user', 'm_user');
    }

    public function index()
    {
        $x['judul'] = 'Data User | KD-ADMIN';
        $id_user = $this->session->userdata('id_usr');
        // $role = $this->session->userdata('role');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();
        // if ($role == 'Admin') {
        $x['_user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND user.id_role = 2")->result();
        // } else {
        //     $x['_user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND akses.akses != '{$role}'")->result();
        // }
        $this->load->view('template_adm/v_header', $x);
        $this->load->view('template_adm/v_navbar', $x);
        $this->load->view('template_adm/v_sidebar', $x);
        $this->load->view('admin/user', $x);
        $this->load->view('template_adm/v_footer');
    }

    //tambah akun
    public function tambah_akun()
    {
        $x['judul'] = 'Data User | KD-ADMIN';
        $id_user = $this->session->userdata('id_usr');
        $role = $this->session->userdata('role');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();
        if ($role == 'Super Admin') {
            $x['_user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role")->result();
        } else {
            $x['_user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND akses.akses != '{$role}'")->result();
        }

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
            'required' => 'kolom ini harus diisi'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
            'required' => 'kolom ini harus diisi'
        ]);
        $this->form_validation->set_rules('pass_akun', 'Pass_akun', 'trim|required', [
            'required' => 'kolom ini harus diisi'
        ]);

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('pesan', '
            <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Data gagal ditambahkan, cek isian Anda kembali.
            </div>
            ');
            $this->load->view('template_adm/v_header', $x);
            $this->load->view('template_adm/v_navbar', $x);
            $this->load->view('template_adm/v_sidebar', $x);
            $this->load->view('admin/user', $x);
            $this->load->view('template_adm/v_footer');
        } else {
            $nama = htmlspecialchars($this->input->post('nama'));
            $email = htmlspecialchars($this->input->post('email'));
            $password = htmlspecialchars($this->input->post('pass_akun'));
            $hak = htmlspecialchars($this->input->post('jenis'));

            /** Periksa apa ada data di tabel */
            $tabel = $this->db->get('user')->num_rows();

            /** Ambil id terakhir */
            $getID = $this->db->query("SELECT * FROM `user` ORDER BY id_user DESC LIMIT 1")->row_array();

            if ($tabel > 0) :
                $id = autonumber($getID['id_user'], 3, 4);
            else :
                $id = 'USR0001';
            endif;

            $array = [
                'id_user' => $id,
                'nama_user' => $nama,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'id_role' => $hak,
                'status' => '0',
                'foto_user' => 'default.jpg'
            ];

            $this->db->insert('user', $array);

            $this->session->set_flashdata('pesan', '
                <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil ditambahkan.
                                </div>
                                ');
            redirect('admin/user');
        }
    }

    public function ubah_akun()
    {
        $x['judul'] = 'Data User | KD-ADMIN';
        $id_user = $this->session->userdata('id_usr');
        $role = $this->session->userdata('role');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();
        if ($role == 'Super Admin') {
            $x['_user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role")->result();
        } else {
            $x['_user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND akses.akses != '{$role}'")->result();
        }

        $id_user = htmlspecialchars($this->input->post('id_user'));
        $nama_user = htmlspecialchars($this->input->post('nama'));
        $email = htmlspecialchars($this->input->post('email'));
        $password = htmlspecialchars($this->input->post('password'));
        $status = htmlspecialchars($this->input->post('status'));

        $this->form_validation->set_rules('nama', 'Nama User', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('password', 'Paassword', 'trim');

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('pesan', '
            <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Info!</strong> Anda gagal mengubah data, cek isian Anda kembali.
            </div>
            ');
            $this->load->view('template_adm/v_header', $x);
            $this->load->view('template_adm/v_navbar', $x);
            $this->load->view('template_adm/v_sidebar', $x);
            $this->load->view('admin/user', $x);
            $this->load->view('template_adm/v_footer');
        } else {
            $data = [
                'nama_user' => $nama_user,
                'email'         => $email,
                'password'         => password_hash($password, PASSWORD_DEFAULT),
                'status'         => $status
            ];
            $this->db->where('id_user', $id_user);
            $this->db->update('user', $data);

            $this->session->set_flashdata('pesan', '
            <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil dirubah.
            </div>');
            redirect('admin/user');
        }
    }

    public function hapus($id_user)
    {
        if ($id_user != null) {
            $this->db->where('id_user', $id_user);
            $this->db->delete('user');
            $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil dihapus.
                        </div>
                        ');
            redirect('admin/user');
        } else {
            $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data gagal dihapus.
                        </div>
                        ');
            redirect('admin/user');
        }
    }
}
