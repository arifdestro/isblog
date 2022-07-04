<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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
        $x['judul'] = 'Profile';
        $id_user = $this->session->userdata('id_usr');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();
        $this->load->view('template_adm/v_header', $x);
        $this->load->view('template_adm/v_navbar', $x);
        $this->load->view('template_adm/v_sidebar', $x);
        $this->load->view('admin/profile', $x);
        $this->load->view('template_adm/v_footer');
    }

    public function image()
    {
        $id_user = $this->session->userdata('id_usr');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();

        /** Proses Edit Gambar */
        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/dist/img/user/';
            $config['overwrite']     = true;
            $config['encrypt_name']  = true;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $old_image = $x['user']['foto_user'];
                if ($old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/dist/img/user/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->where('id_user', $x['user']['id_user']);
                $this->db->set('foto_user', $new_image);
                $this->db->update('user');
                $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Ubah Gambar berhasil.
                </div>');
                redirect('admin/profile');
            } else {
                $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Ubah Gambar gagal, pastikan Ukuran dan Format gambar sesuai.
                </div>');
                redirect('admin/profile');
            }
        }
    }

    public function edit()
    {
        $id_user = $this->session->userdata('id_usr');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();

        $data['judul'] = "Profile";

        if ($this->input->post('nama_akun') == null && $this->input->post('username') == null && $this->input->post('email') == null && $this->input->post('nomor_hp') == null) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Jika akan merubah data, pastikan untuk mengisi salah satu inputan minimal.
                    </div>');
            redirect('admin/profile');
        } else {
            if ($this->input->post('nama_akun') == null || $this->input->post('nama_akun') == '') {
                $nama = $x['user']['nama_user'];
                $nama_fix = $nama;
            } else {
                $nama = htmlspecialchars($this->input->post('nama_akun'));
                $check_nama = $this->db->get_where('user', ['nama_user' => $nama]);
                if ($check_nama->num_rows() > 0) {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Nama Akun telah terpakai.
                            </div>');
                    redirect('admin/profile');
                } else {
                    $nama_fix = $nama;
                }
            }
            if ($this->input->post('email') == null || $this->input->post('email') == '') {
                $email = $x['user']['email'];
                $email_fix = $email;
            } else {
                $email = htmlspecialchars($this->input->post('email'));
                $check_email = $this->db->get_where('user', ['email' => $email]);
                if ($check_email->num_rows() > 0) {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Email Akun telah terpakai.
                            </div>');
                    redirect('admin/profile');
                } else {
                    $email_fix = $email;
                }
            }

            $edit = [
                'nama_user' => $nama_fix,
                'email' => $email_fix,
                'ubah' => date('Y-m-d')
            ];

            $this->db->set($edit);
            $this->db->where('id_user', $id_user);
            $this->db->update('user');
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Edit Informasi Akun berhasil.
                    </div>');
            redirect('admin/profile');
        }
    }

    public function ubah_pas()
    {
        $x['judul'] = 'Profile';
        $id_user = $this->session->userdata('id_usr');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();

        $request = [
            'alert1' => 'success',
            'alert2' => 'warning',
            'alert3' => 'danger',
            'text1' => 'Informasi Akun berhasil di Update',
            'text2' => 'Update gagak dilakukan, pastikan inputan benar',
            'text3' => 'Email belum ter-aktivasi, silahkan aktivasi terlebih dahulu',
            'text4' => 'Password berhasil diperbarui',
            'text5' => 'Password Lama anda kurang tepat',
            'text6' => 'Password Baru tidak boleh sama dengan Password Lama',
            'text7' => 'Password Baru dan Verifikasi Password Baru harus sama'
        ];

        $this->form_validation->set_rules('pas_lama', 'Lma', 'trim|required|min_length[8]', [
            'required' => 'kolom ini harus diisi',
            'min_length' => 'Password minimal berjumlah 8 karakter'
        ]);

        $this->form_validation->set_rules('pas_baru', 'bru', 'trim|required|min_length[8]', [
            'required' => 'kolom ini harus diisi',
            'min_length' => 'Password minimal berjumlah 8 karakter',
            'matches' => ''
        ]);

        $this->form_validation->set_rules('pas_baru2', 'bru1', 'trim|required|min_length[8]', [
            'required' => 'kolom ini harus diisi',
            'min_length' => 'Password minimal berjumlah 8 karakter',
            'matches' => 'konfirmasi password tidak sesuai'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('template_adm/v_header', $x);
            $this->load->view('template_adm/v_navbar', $x);
            $this->load->view('template_adm/v_sidebar', $x);
            $this->load->view('admin/profile', $x);
            $this->load->view('template_adm/v_footer');
        } else {
            $pswlma = $this->input->post(htmlspecialchars('pas_lama'));
            $pswbru1 = $this->input->post(htmlspecialchars('pas_baru'));
            $pswbru2 = $this->input->post(htmlspecialchars('pas_baru2'));

            if (!password_verify($pswlma, $x['user']['password'])) {
                $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert3'] . ' alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text5'] . '.
                </div>');
                redirect('admin/profile');
            } else {
                if ($pswlma == $pswbru1) {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert2'] . ' alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text6'] . '.
                </div>');
                    redirect('admin/profile');
                } elseif ($pswbru1 != $pswbru2) {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert2'] . ' alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text7'] . '.
                </div>');
                    redirect('admin/profile');
                } else {
                    $pswhash = password_hash($pswbru1, PASSWORD_DEFAULT);
                    $this->m_user->ubhpsw($pswhash, $id_user);
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert1'] . ' alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text4'] . '.
                </div>');
                    redirect('admin/profile');
                }
            }
        }
    }
}
