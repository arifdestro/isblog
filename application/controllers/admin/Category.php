<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Category extends CI_Controller
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

        $this->load->model('M_user', 'm_user');
    }

    public function index()
    {
        $id_user = $this->session->userdata('id_usr');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();

        $x['judul'] = 'Kategori | KD-ADMIN';

        /** Ambil data kategori */
        $x['kategori'] = $this->m_user->getAll('kategori')->result();
        $this->load->view('template_adm/v_header', $x);
        $this->load->view('template_adm/v_navbar', $x);
        $this->load->view('template_adm/v_sidebar', $x);
        $this->load->view('admin/category', $x);
        $this->load->view('template_adm/v_footer');
    }

    //tambah kategori di kategori
    public function tambah_kategori()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required');

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('pesan', '
                <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf!</strong> Anda gagal menambahkan, data cek isian Anda kembali.
                </div>
                ');
            $id_user = $this->session->userdata('id_usr');
            $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();
            $x['judul'] = 'Kategori | KD-ADMIN';
            $x['kategori'] = $this->m_user->getAll('kategori')->result();
            $this->load->view('template_adm/v_header', $x);
            $this->load->view('template_adm/v_navbar', $x);
            $this->load->view('template_adm/v_sidebar', $x);
            $this->load->view('admin/category', $x);
            $this->load->view('template_adm/v_footer');
        } else {
            $nama_kategori = htmlspecialchars($this->input->post('nama_kategori'));
            $link = htmlspecialchars($this->input->post('link'));

            $array = [
                'nama_kategori' => $nama_kategori,
                'permalink_kt' => $link
            ];

            $this->db->insert('kategori', $array);

            $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Selamat!</strong> Anda berhasil menambah data.
                        </div>
                        ');
            redirect('admin/category');
        }
    }

    //hapus kategori
    public function hapus($id_kategori)
    {
        if ($id_kategori != null) {
            $this->db->where('id_kategori', $id_kategori);
            $this->db->delete('kategori');
            $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil dihapus.
                        </div>
                        ');
            redirect('admin/category');
        } else {
            $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data gagal dihapus.
                        </div>
                        ');
            redirect('admin/category');
        }
    }

    //update kategori
    public function update_kategori()
    {
        $id_kategori = htmlspecialchars($this->input->post('id_kategori'));
        $nama_kategori = htmlspecialchars($this->input->post('nama_kategori1'));
        $link = htmlspecialchars($this->input->post('link'));

        $this->form_validation->set_rules('nama_kategori1', 'Nama Kategori', 'trim|required');

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('pesan', '
            <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Maaf!</strong> Anda gagal mengubah data, cek isian Anda kembali.
            </div>
            ');
            $id_user = $this->session->userdata('id_usr');
            $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();
            $x['judul'] = 'Kategori | KD-ADMIN';
            $x['kategori'] = $this->m_user->getAll('kategori')->result();
            $this->load->view('template_adm/v_header', $x);
            $this->load->view('template_adm/v_navbar', $x);
            $this->load->view('template_adm/v_sidebar', $x);
            $this->load->view('admin/category', $x);
            $this->load->view('template_adm/v_footer');
        } else {
            $data = [
                'nama_kategori' => $nama_kategori,
                'permalink_kt' => $link
            ];
            $this->db->set($data);
            $this->db->where('id_kategori', $id_kategori);
            $this->db->update('kategori');
            // $this->m_kategori->update_kategori($where, $data, 'kategori');
            $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Selamat!</strong> Anda berhasil mengubah data.
                        </div>
                        ');
            redirect('admin/category');
        }
    }
}
