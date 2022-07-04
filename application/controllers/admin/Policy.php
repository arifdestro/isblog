<?php

class Policy extends CI_Controller
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
        $id_user = $this->session->userdata('id_usr');
        $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();

        $data['judul'] = 'Data Policy | KD-ADMIN';
        $data['data'] = $this->m_user->getAll('kebijakan')->result_array();
        $this->load->view("template_adm/v_header", $data);
        $this->load->view("template_adm/v_navbar", $data);
        $this->load->view("template_adm/v_sidebar", $data);
        $this->load->view("admin/policy", $data);
        $this->load->view("template_adm/v_footer");
    }

    function insert()
    {
        $this->form_validation->set_rules('nama_kb', 'Nama', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');
        $this->form_validation->set_rules('isi', 'Isi', 'required');

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        if ($this->form_validation->run() == false) {
            redirect('admin/policy');
        } else {
            $name = htmlspecialchars($this->input->post('nama_kb', TRUE), ENT_QUOTES);
            $link = htmlspecialchars(trim($this->input->post('link', TRUE)), ENT_QUOTES);
            $isi = $this->input->post('isi');
            $upload = $_FILES['image']['name'];
            if ($upload) {
                $config['upload_path'] = './assets/dist/img/kebijakan/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|svg';
                $config['max_size'] = 2000;
                $config['max_width'] = 1500;
                $config['max_height'] = 1500;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $image = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Ubah Gambar gagal, pastikan Ukuran dan Format gambar sesuai.
                </div>');
                    redirect('admin/policy');
                }
            } else {
                $image = 'no-image.png';
            }

            $val = [
                'nama_kb' => $name,
                'permalink_kb' => $link,
                'isi_kb' => $isi,
                'gambar_kb' => $image
            ];

            $this->db->insert('kebijakan', $val);

            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil ditambahkan.
                </div>');
            redirect('admin/policy');
        }
    }

    function update()
    {
        $this->form_validation->set_rules('nama_kb', 'Nama', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');
        $this->form_validation->set_rules('isi', 'Isi', 'required');

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        $id = $this->input->post('id_edit');

        if ($this->form_validation->run() == false) {
            redirect('admin/policy');
        } else {
            $upload = $_FILES['image']['name'];
            if ($upload) {
                $config['upload_path'] = './assets/dist/img/kebijakan/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2000;
                $config['max_width'] = 1500;
                $config['max_height'] = 1500;
                $config['overwrite']     = true;
                $config['encrypt_name']  = true;

                $this->upload->initialize($config);

                $get = $this->db->get_where('kebijakan', ['id_kb' => $id])->row_array();

                if ($this->upload->do_upload('image')) {
                    $old_image = $get['gambar_kb'];
                    if ($old_image != 'no-image.png') {
                        unlink(FCPATH . 'assets/dist/img/kebijakan/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('gambar_kb', $new_image);
                } else {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Ubah Gambar gagal, pastikan Ukuran dan Format gambar sesuai.
                </div>');
                    redirect('admin/policy');
                }
            }
            $name = htmlspecialchars($this->input->post('nama_kb'));
            $link = htmlspecialchars($this->input->post('link'));
            $isi = $this->input->post('isi');
            $val = [
                'nama_kb' => $name,
                'permalink_kb' => $link,
                'isi_kb' => $isi
            ];

            $this->db->set($val);
            $this->db->where('id_kb', $id);
            $this->db->update('kebijakan');
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil ditambahkan.
                </div>');
            redirect('admin/policy');
        }
    }

    function delete($id)
    {
        if ($id != null) {
            $this->db->where('id_kb', $id);
            $this->db->delete('kebijakan');

            $get = $this->db->get_where('kebijakan', ['id_kb' => $id])->row_array();
            $old_image = $get['gambar_kb'];

            unlink(FCPATH . 'assets/dist/img/kebijakan/' . $old_image);

            $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil dihapus.
                        </div>
                        ');
            redirect('admin/policy');
        } else {
            $this->session->set_flashdata('pesan', '
                        <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data gagal dihapus.
                        </div>
                        ');
            redirect('admin/policy');
        }
    }

    //Upload image summernote
    function upload_image()
    {
        if (isset($_FILES["image"]["name"])) {
            $config['upload_path'] = './assets/img/gambar/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image')) {
                $this->upload->display_errors();
                return FALSE;
            } else {
                $data = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/img/gambar/' . $data['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '60%';
                $config['width'] = 800;
                $config['height'] = 800;
                $config['new_image'] = './assets/img/gambar/' . $data['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                echo base_url() . 'assets/img/gambar/' . $data['file_name'];
            }
        }
    }

    //Delete image summernote
    function delete_image()
    {
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        if (unlink($file_name)) {
            echo 'File Delete Successfully';
        }
    }
}
