<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message extends CI_Controller
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
        $x['judul'] = 'Pesan | KD-ADMIN';
        $id_user = $this->session->userdata('id_usr');
        $x['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();
        $x['pes'] = $this->db->query("SELECT * FROM pesan ORDER BY id_pesan DESC")->result();
        $this->load->view('template_adm/v_header', $x);
        $this->load->view('template_adm/v_navbar', $x);
        $this->load->view('template_adm/v_sidebar', $x);
        $this->load->view('admin/message', $x);
        $this->load->view('template_adm/v_footer');
    }

    public function detail($id_pesan)
    {
        $id_user = $this->session->userdata('id_usr');
        $data['user'] = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND id_user = '$id_user'")->row_array();
        $data['pesan'] = $this->db->query("SELECT * FROM pesan WHERE id_pesan={$id_pesan}")->result();
        $data['judul']    = 'Detail Data Pesan';
        $data['judul']    = 'Data Pesan';

        $set = [
            'read_msg' => 1,
        ];

        $this->m_user->read($id_pesan, $set);

        $this->load->view('template_adm/v_header', $data);
        $this->load->view('template_adm/v_navbar', $data);
        $this->load->view('template_adm/v_sidebar');
        $this->load->view('admin/v_detail_pesan', $data);
        $this->load->view('template_adm/v_footer');
    }

    public function all()
    {
        $pesan = $this->db->query("SELECT * FROM pesan WHERE read_msg='0'")->result_array();

        for ($i = 0; $i < count($pesan); $i++) {
            $where = [
                'id_pesan' => $pesan[$i]['id_pesan'],
            ];
            $data = [
                'read_msg' => '1',
            ];

            $this->db->update('pesan', $data, $where);
        }

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('pesan', '
		<div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
		<strong><i class="fas fa-info-circle"></i> Info!</strong> seluruh data pesan telah ditandai terbaca.
				</button>
				</div>
				');
            redirect('admin/message');
        } else {
            $this->session->set_flashdata('pesan', '
			<div id="pesan" class="alert alert-info alert-dismissible fade show" role="alert">
			<strong><i class="fas fa-info-circle"></i> Info!</strong> seluruh data pesan telah tertandai terbaca.
					</button>
					</div>
					');
            redirect('admin/message');
        }
    }
}
