<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Post extends CI_Controller
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

        $page = $this->input->get('page');

        if ($page === '' || !isset($page)) {
            $page = 'publish';
        }

        // jika $page tidak sesuai, maka tampilkan error
        if (!in_array($page, ['publish', 'draft'], true)) {
            return redirect('notfound');
        }

        switch ($page) {
            case 'publish':
                $post_status = 1;
                break;

            case 'draft':
                $post_status = 0;
                break;

            default:
                $post_status = null;
                break;
        }

        $x['post']     = $this->m_user->get_all_post($post_status)->result();
        $x['komentar'] = $this->m_user->get_comment()->num_rows();
        $x['judul']    = 'Posting | KD-ADMIN';
        $x['tab']      = $page;

        $this->load->view('template_adm/v_header', $x);
        $this->load->view('template_adm/v_navbar', $x);
        $this->load->view('template_adm/v_sidebar', $x);
        $this->load->view('admin/post', $x);
        $this->load->view('template_adm/v_footer');
    }

    public function tambah()
    {
        $id_user = $this->session->userdata('id_usr');
        $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();

        $data['judul'] = 'Tambah Posting | KD-ADMIN';
        $this->load->view('template_adm/v_header', $data);
        $this->load->view('template_adm/v_navbar', $data);
        $this->load->view('template_adm/v_sidebar', $data);
        $this->load->view('admin/post_create', $data);
        $this->load->view('template_adm/v_footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('judul', 'Judul Post', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi Post', 'trim');
        $this->form_validation->set_rules('konten', 'Isi Konten', 'trim|required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('pesan', '
            <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Anda gagal menambahkan data, cek isian Anda.
                </div>');

            $id_user = $this->session->userdata('id_usr');
            $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();

            $data['judul'] = 'Tambah Posting | KD-ADMIN';
            $this->load->view('template_adm/v_header', $data);
            $this->load->view('template_adm/v_navbar', $data);
            $this->load->view('template_adm/v_sidebar', $data);
            $this->load->view('admin/post_create', $data);
            $this->load->view('template_adm/v_footer');
        } else {
            $title       = strip_tags(htmlspecialchars($this->input->post('judul', true), ENT_QUOTES));
            $contents    = $this->input->post('konten', true);
            $description = $this->input->post('deskripsi');
            $category    = $this->input->post('kategori', true);
            $slug        = url_title($title, '-', true);
            $status      = $this->input->post('status', true);

            // cek duplikat slug
            $query = $this->db->get_where('post', ['permalink' => $slug]);
            if ($query->num_rows() > 0) {
                $slug = url_title($slug . ' ' . uniqid(), '-', true);
            }

            $upload_image = $_FILES['foto']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = '5000';
                $config['upload_path']  = './assets/img/post/';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('foto')) {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Maaf Gambar gagal diupload.
                    </div>');
                    $form_session = [
                        'form_title'   => $title,
                        'form_description'   => $description,
                        'form_content' => strip_tags($contents),
                    ];
                    $this->session->set_userdata($form_session);
                    redirect('admin/post/tambah');
                } else {
                    $img = $this->upload->data();
                    //Compress Image
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/img/post/' . $img['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['quality'] = '70%';
                    $config['width'] = 500;
                    $config['height'] = 320;
                    $config['new_image'] = './assets/img/post/' . $img['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $this->_create_thumbs($img['file_name']);

                    $upload_image = $img['file_name'];
                }
            } else {
                $upload_image = '';
            }

            //INSERT TO Komentar
            date_default_timezone_set('Asia/Jakarta');

            if (is_array($_POST['tag_id'])) {
                $xtags[] = $_POST['tag_id'];
                foreach ($xtags as $tag) {
                    $tags = @implode(",", $tag);
                }
            } else if (is_array($_POST['tag_id'] == '')) {
                $xtags = $_POST['tag_id'];
                $tags = @implode(",", $xtags);
            }

            $array = [
                'judul_post' => $title,
                'deskripsi_post' => $description,
                'konten_post' => $contents,
                'id_kategori' => $category,
                'gambar_post' => $upload_image,
                'tags' => $tags,
                'tanggal_post' => date('Y-m-d'),
                'permalink' => $slug,
                'status_post' => $status,
                'id_user' => $this->session->userdata('id_usr')
            ];

            $this->db->insert('post', $array);

            $this->session->unset_userdata(['form_title', 'form_description', 'form_content']);

            $this->session->set_flashdata('pesan', '
                <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil Anda tambahkan.
                </div>');

            redirect('admin/post');
        }
    }

    public function get_edit($post_id)
    {
        $id_user = $this->session->userdata('id_usr');
        $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();
        // $post_id       = $this->uri->segment(4);
        $data['category'] = $this->db->get('kategori')->result_array();
        $data['data']     = $this->db->query("SELECT * FROM post, kategori WHERE kategori.id_kategori = post.id_kategori AND post.id_post='{$post_id}'")->row_array();

        $data['judul'] = 'Edit Posting | KD-ADMIN';

        $this->load->view('template_adm/v_header', $data);
        $this->load->view('template_adm/v_navbar', $data);
        $this->load->view('template_adm/v_sidebar', $data);
        $this->load->view('admin/post_edit', $data);
        $this->load->view('template_adm/v_footer');
    }

    public function edit()
    {
        $this->form_validation->set_rules('judul2', 'Judul Post', 'trim|required');
        $this->form_validation->set_rules('deskripsi2', 'Deskripsi Post', 'trim');
        $this->form_validation->set_rules('konten2', 'Isi Konten', 'trim|required');
        $this->form_validation->set_rules('kategori2', 'Kategori', 'trim|required');
        $this->form_validation->set_rules('status2', 'Status', 'trim|required');
        $post_id2     = $this->input->post('id_edit', true);

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('pesan', '
            <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Anda gagal menambahkan data, cek isian Anda.
            </div>');

            $id_user = $this->session->userdata('id_usr');
            $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();

            $data['category'] = $this->db->get('kategori')->result_array();
            $data['data']     = $this->db->query("SELECT * FROM post, kategori WHERE kategori.id_kategori = post.id_kategori AND post.id_post='{$post_id2}'")->row_array();

            $data['judul'] = 'Edit Posting | KD-ADMIN';
            $this->load->view('template_adm/v_header', $data);
            $this->load->view('template_adm/v_navbar', $data);
            $this->load->view('template_adm/v_sidebar', $data);
            $this->load->view('admin/post_edit', $data);
            $this->load->view('template_adm/v_footer');
        } else {
            $title2       = strip_tags(htmlspecialchars($this->input->post('judul2', true), ENT_QUOTES));
            $contents2    = $this->input->post('konten2', true);
            $description2 = $this->input->post('deskripsi2');
            $category2    = $this->input->post('kategori2', true);
            $slug         = url_title($title2, '-', true);
            $status2      = $this->input->post('status2', true);

            // cek duplikat slug
            $query = $this->db->get_where('post', ['permalink' => $slug]);
            if ($query->num_rows() > 0) {
                $slug = url_title($slug . ' ' . uniqid(), '-', true);
            }

            $upload_image = $_FILES['foto2']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = '5000';
                $config['upload_path']  = './assets/img/post/';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('foto2')) {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Maaf Gambar gagal diupload.
                    </div>');
                    $form_session = [
                        'form_title'   => $title2,
                        'form_description'   => $description2,
                        'form_content' => strip_tags($contents2),
                    ];
                    $this->session->set_userdata($form_session);
                    redirect('admin/post/get-edit/' . $post_id2);
                } else {
                    $img = $this->upload->data();
                    //Compress Image
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/img/post/' . $img['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['quality'] = '70%';
                    $config['width'] = 700;
                    $config['height'] = 350;
                    $config['new_image'] = './assets/img/post/' . $img['file_name'];
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $image = $this->db->get_where('post', ['id_post' => $post_id2])->row_array();
                    $old_image = $image['gambar_post'];

                    unlink(FCPATH . 'assets/img/post/' . $old_image);
                    unlink(FCPATH . 'assets/img/thumb/' . $old_image);

                    $this->_create_thumbs($img['file_name']);

                    $upload_image = $img['file_name'];
                }
            } else {
                $image = $this->db->get_where('post', ['id_post' => $post_id2])->row_array();
                $upload_image = $image['gambar_post'];
            }

            date_default_timezone_set('Asia/Jakarta');

            if (is_array($_POST['tag_id_edit'])) {
                $xtags[] = $_POST['tag_id_edit'];
                foreach ($xtags as $tag) {
                    $tags_edit = @implode(",", $tag);
                }
            } else if (is_array($_POST['tag_id_edit'] == '')) {
                $xtags = $_POST['tag_id_edit'];
                $tags_edit = @implode(",", $xtags);
            }

            $array2 = [
                'judul_post' => $title2,
                'deskripsi_post' => $description2,
                'konten_post' => $contents2,
                'id_kategori' => $category2,
                'gambar_post' => $upload_image,
                'tags' => $tags_edit,
                'terakhir_update_post' => date('Y-m-d'),
                'permalink' => $slug,
                'status_post' => $status2,
            ];

            $this->db->set($array2);
            $this->db->where('id_post', $post_id2);
            $this->db->update('post');

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('pesan', '
                    <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil dirubah.
                    </div>');

                redirect('admin/post');
            } else {
                $this->session->set_flashdata('pesan', '
                    <div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Data gagal dirubah.
                    </div>');

                redirect('admin/post');
            }
        }
    }

    public function delete_foto($id_post)
    {
        if (isset($id_post)) {
            $image = $this->db->get_where('post', ['id_post' => $id_post])->row_array();

            $old_image = $image['gambar_post'];

            unlink(FCPATH . 'assets/img/post/' . $old_image);
            unlink(FCPATH . 'assets/img/thumb/' . $old_image);

            $this->db->set('gambar_post', '');
            $this->db->where('id_post', $id_post);
            $this->db->update('post');

            $this->session->set_flashdata('pesan', '
                    <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Foto berhasil dihapus.
                    </div>');
        }

        redirect('admin/post/get_edit/' . $id_post);
    }

    public function delete($post_id)
    {
        $get = $this->db->get_where('post', ['id_post' => $post_id])->row();

        // hapus foto
        if ($get->gambar_post !== '') {
            unlink(FCPATH . 'assets/img/post/' . $get->gambar_post);
            unlink(FCPATH . 'assets/img/thumb/' . $get->gambar_post);
        }

        $this->db->where('id_post', $post_id);
        $this->db->delete('post');

        $this->session->set_flashdata('pesan', '
                <div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Data berhasil dihapus.
                </div>');
        redirect('admin/post');
    }

    function _create_thumbs($file_name)
    {
        // Image resizing config
        $config = array(
            array(
                'image_library' => 'GD2',
                'source_image'  => './assets/img/post/' . $file_name,
                'maintain_ratio' => FALSE,
                'width'         => 392,
                'height'        => 200,
                'new_image'     => './assets/img/thumb/' . $file_name
            )
        );

        $this->load->library('image_lib', $config[0]);
        foreach ($config as $item) {
            $this->image_lib->initialize($item);
            if (!$this->image_lib->resize()) {
                return false;
            }
            $this->image_lib->clear();
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
