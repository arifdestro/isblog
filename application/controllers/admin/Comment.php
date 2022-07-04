<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends CI_Controller
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

    public function show(string $page = 'publik')
    {
        if (!in_array($page, ['publik', 'pending'], true)) {
            redirect('forbidden');
            // return false;
        }

        $id_user = $this->session->userdata('id_usr');
        $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '{$id_user}'")->row_array();

        $limit  = 20;
        $offset = $this->input->get('per_page');

        if (!isset($offset)) {
            $offset = 0;
        }

        $status = 1;
        if ($page === 'pending') {
            $status = 0;
        }

        $config['base_url']             = base_url('admin/comment/' . $page);
        $config['total_rows']           = $this->m_user->getComments($status, null, null)->num_rows();
        $config['per_page']             = $limit;
        $config['enable_query_strings'] = true;
        $config['page_query_string']    = true;
        $config['reuse_query_string']   = true;

        $this->pagination->initialize($config);

        $data['paginasi'] = $this->pagination->create_links();

        $data['judul']    = 'Komentar | KD-ADMIN';
        $data['current']  = $page;
        $data['komentar'] = $this->m_user->getComments($status, $limit, $offset);

        $this->load->view('template_adm/v_header', $data);
        $this->load->view('template_adm/v_navbar', $data);
        $this->load->view('template_adm/v_sidebar');
        $this->load->view('admin/comment', $data);
        $this->load->view('template_adm/v_footer');
    }

    public function edit()
    {
        $this->form_validation->set_rules('id', 'ID', 'required|integer');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_rules('isi', 'Isi Komentar', 'required');

        $this->form_validation->set_message('required', 'Mohon maaf, {field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-center"><span class="badge badge-danger text-white mt-2 px-4">', '</span></div>');

        $redirect = $this->input->post('redirect');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger"><strong><i class="fas fa-info-circle"></i> Info!</strong> Galat: <br/>' . validation_errors() . '</div>');
        } else {
            $id   = $this->input->post('id');
            $data = [
                'nama'  => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'pesan' => $this->input->post('isi'),
            ];
            $this->m_user->update($id, $data);

            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success"><strong><i class="fas fa-info-circle"></i> Info!</strong> Komentar sudah diperbarui.</div>');
        }

        redirect($redirect !== null ? $redirect : 'comment');
    }

    public function delete(int $id)
    {
        $del = $this->m_user->delete_comment($id);

        if ($del) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success"><strong><i class="fas fa-info-circle"></i> Info!</strong> Komentar sudah dihapus.</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger"><strong><i class="fas fa-info-circle"></i> Info!</strong> Komentar gagal dihapus.</div>');
        }
        redirect($this->agent->referrer());
    }

    public function terbit(int $id, int $status)
    {
        $changed = $this->m_user->terbit($id, $status);

        if ($changed && $status == 0) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success"><strong><i class="fas fa-info-circle"></i> Info!</strong> Komentar berhasil disembunyikan.</div>');
        } elseif ($changed && $status == 1) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success"><strong><i class="fas fa-info-circle"></i> Info!</strong> Komentar berhasil diterbitkan.</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger"><strong><i class="fas fa-info-circle"></i> Info!</strong> Komentar gagal diterbitkan.</div>');
        }
        redirect($this->agent->referrer());
    }
}
