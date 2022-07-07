<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Beranda extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user', 'm_user');
        $this->m_user->count_visitor();
    }

    public function index()
    {
        $jum = $this->m_user->get_post();
        $page = $this->uri->segment(3);
        if (!$page) :
            $off = 0;
        else :
            $off = $page;
        endif;
        $limit = 6;
        $offset = $off > 0 ? (($off - 1) * $limit) : $off;
        $pagination['base'] = $this->config->item('base_url');
        $config['base_url'] = $pagination['base'] . 'beranda/page/';
        $config['total_rows'] = $jum->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['first_url']        = site_url('beranda');

        $config['first_link']       = 'Pertama';
        $config['last_link']        = 'Terakhir';
        $config['next_link']        = 'Lanjut';
        $config['prev_link']        = 'Kembali';
        $config['full_tag_open']    = '<nav id="pg" aria-label="Page navigation"><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active" aria-current="page"><span class="page-link">';
        $config['cur_tag_close']    = '</span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<i class="fad fa-arrow-right"></i></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '<i class="fad fa-arrow-left"></i></span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $data['post'] = $this->m_user->get_post_list($offset, $limit);

        $this->pagination->initialize($config);
        $data['halaman'] = $this->pagination->create_links();

        $data['kategori']  = $this->db->query("SELECT nama_kategori, kategori.permalink_kt, MAX(pengunjung_post) as jumlah_post, COUNT(*) as jumlah
        FROM post, kategori WHERE post.status_post = 1 AND post.id_kategori = kategori.id_kategori
        GROUP BY nama_kategori
        HAVING COUNT(*) > 0
        LIMIT 4
        ");

        $data['judul']     = 'Beranda | Website Pendongeng Handal';
        $this->load->view('template/header', $data);
        $this->load->view('index', $data);
        $this->load->view('template/footer');
    }

    public function legal($link)
    {
        $get = $this->db->get_where('kebijakan', ['permalink_kb' => $link])->row();
        $data['judul']     = $get->nama_kb . ' | Website Pendongeng Handal';
        $data['terms']     = $get;
        $this->load->view('template/header', $data);
        $this->load->view('legal', $data);
        $this->load->view('template/footer');
    }

    public function kategori($slug)
    {
        $kat = $this->db->get_where('kategori', ['permalink_kt' => $slug])->row();
        $id_kat = $kat->id_kategori;
        $nm_kat = $kat->nama_kategori;
        $data['judul']     = "Kategori $nm_kat | Website Pendongeng Handal";
        $post = $this->db->query("SELECT * FROM post, kategori WHERE post.id_kategori = kategori.id_kategori AND post.status_post = 1 AND post.id_kategori={$id_kat} ORDER BY id_post DESC");
        if ($post->num_rows() > 0) {
            $q = $post->result();
            $data['kategori'] = $q;
            $name = $this->uri->segment(2);
            $data['hasil'] = $nm_kat;
            $data['cat']  = $this->db->query("SELECT * FROM kategori WHERE permalink_kt = '$name'")->row();
            $this->load->view('template/header', $data);
            $this->load->view('kategori', $data);
            $this->load->view('template/footer');
        } else {
            $name = $this->uri->segment(2);
            $data['cat']  = $this->db->query("SELECT * FROM kategori WHERE permalink_kt = '$name'")->row();
            $q = $post->result();
            $data['kategori'] = $q;
            $data['hasil'] = 'Tidak ditemukan';
            $this->load->view('template/header', $data);
            $this->load->view('kategori', $data);
            $this->load->view('template/footer');
        }
    }

    public function tag($slug)
    {
        $tag = $this->db->get_where('tag', ['permalink_tg' => $slug])->row();
        $id_tag = $tag->id_tag;
        $nm_tag = $tag->nama_tag;
        $data['judul']     = "Tag $nm_tag | Website Pendongeng Handal";
        $post = $this->db->query("SELECT * FROM post, kategori WHERE kategori.id_kategori = post.id_kategori AND status_post = 1 AND tags LIKE '%$id_tag%' ORDER BY id_post DESC");
        if ($post->num_rows() > 0) {
            $q = $post->result();
            $data['tag'] = $q;
            $data['hasil'] = $nm_tag;
            $data['tg']  = $this->db->query("SELECT * FROM tag WHERE permalink_tg = '$slug'")->row();
            $this->load->view('template/header', $data);
            $this->load->view('tag', $data);
            $this->load->view('template/footer');
        } else {
            $data['tg']  = $this->db->query("SELECT * FROM tag WHERE permalink_tg = '$slug'")->row();
            $q = $post->result();
            $data['tag'] = $q;
            $data['hasil'] = 'Tidak ditemukan';
            $this->load->view('template/header', $data);
            $this->load->view('tag', $data);
            $this->load->view('template/footer');
        }
    }

    public function tag_all()
    {
        $data['judul']     = "Tags | Website Pendongeng Handal";
        $this->load->view('template/header', $data);
        $this->load->view('tag_all', $data);
        $this->load->view('template/footer');
    }

    public function kategori_all()
    {
        $data['judul']     = "Kategori | Website Pendongeng Handal";
        $this->load->view('template/header', $data);
        $this->load->view('kategori_all', $data);
        $this->load->view('template/footer');
    }

    public function detail($slug)
    {
        $data['judul']     = $slug . ' | Website Pendongeng Handal';
        $post = $this->m_user->get_post_by_slug($slug);
        if ($post->num_rows() > 0) {
            $q = $post->row();

            $kode          = $q->id_post;
            $data['judul']    = $q->judul_post;
            $data['list']     = $this->m_user->list($kode);
            $data['get']    = $this->db->get('pengaturan')->row_array();
            $data['post']     = $q;
            $data['komentar'] = $this->show_tree($q->id_post);

            $data['komen'] = $this->db->query("SELECT * FROM komentar, post, detail_komentar WHERE komentar.id_komentar = detail_komentar.id_komentar AND post.id_post = detail_komentar.id_post AND detail_komentar.id_post={$kode} AND komentar.status=1")->num_rows();
            $this->m_user->count_views($kode);

            $this->load->view('template/header', $data);
            $this->load->view('detail_post', $data);
            $this->load->view('template/footer');
        } else {
            return redirect('notfound');
        }
    }

    public function search()
    {
        $query  = strip_tags(htmlspecialchars($this->input->get('cari', true), ENT_QUOTES));
        $result = $this->m_user->search($query);
        if ($result->num_rows() > 0) {
            $data['value']  = $result->result();
            $data['cari']  = $query;
            $data['hasil'] = 'Hasil Pencarian :' . ' " ' . $query . ' "';
        } else {
            $data['value']  = $result;
            $data['cari']  = $query;
            $data['hasil'] = 'Tidak ditemukan';
        }

        $data['judul'] = 'Pencarian ' . $query;
        $this->load->view('template/header', $data);
        $this->load->view('search_result', $data);
        $this->load->view('template/footer');
    }

    public function add_comment()
    {
        $url = $this->input->post('url');

        //set validation rules
        $this->form_validation->set_rules('comment_name', 'Nama', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('comment_email', 'Email', 'required|valid_email|trim|htmlspecialchars');
        $this->form_validation->set_rules('comment_body', 'Komentar', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('g-recaptcha-response', 'Recaptcha', 'required');

        // set session nama & email
        if ($this->session->userdata('LoggedIn') == true) :
            $nama = $this->session->userdata('name');
            $email = $this->session->userdata('email');
            $comment = [
                'cnama'  => $this->session->userdata('name'),
                'cemail' => $this->session->userdata('email'),
            ];
            $this->session->set_flashdata('error_msg', '');
        else :
            $nama = $this->input->post('comment_name');
            $email = $this->input->post('comment_email');
            $comment = [
                'cnama'  => $this->input->post('comment_name'),
                'cemail' => $this->input->post('comment_email'),
            ];
        endif;

        $this->session->set_userdata($comment);

        if ($this->form_validation->run() == false) {
            // if not valid load comments
            $this->session->set_flashdata('error_msg', validation_errors());
        } else {
            //if valid send comment to admin to tak approve
            // $this->m_user->add_new_comment();
            $this->db->trans_start();
            $id_post = $this->input->post('id_post');
            $parent = $this->input->post('parent_id') ?? 0;
            $pesan = $this->input->post('comment_body');

            if ($nama == $this->session->userdata('name') && $email == $this->session->userdata('email')) {
                $status = 1;
            } else {
                $status = 0;
            }

            //INSERT TO Komentar
            $data  = array(
                'nama' => $nama,
                'email' => $email,
                'pesan' => $pesan,
                'komentar_parent' => $parent,
                'status' => $status
            );
            $this->db->insert('komentar', $data);
            //GET ID Komentar
            $comment_id = $this->db->insert_id();
            $result = array();
            $result[] = array(
                'id_post'   => $id_post,
                'id_komentar'   => $comment_id
            );
            //MULTIPLE INSERT TO Detail_Komentar
            $this->db->insert_batch('detail_komentar', $result);
            $this->db->trans_complete();
            $this->session->set_flashdata('error_msg', '
            <div id="toast" class="toast position-fixed bottom-0 end-0 p-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000" style="z-index: 9999">
                <div class="toast-header">
                    <i class="fas fa-info-circle text-success"></i>
                    <strong class="me-auto">Info</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Komentar Anda akan dimoderasi.
                </div>
            </div>');
        }
        redirect($url . '#komen');
        return $this->input->post('komentar_parent');
    }

    private function show_tree($post_id)
    {
        // create array to store all comments ids
        $store_all_id = [];
        // get all parent comments ids by using news id
        $id_result = $this->m_user->tree_all($post_id);
        // loop through all comments to save parent ids $store_all_id array
        if ($id_result === null) {
            return '<div class="alert alert-info">Belum ada komentar, jadilah yang pertama.</div>';
        }

        foreach ($id_result as $comment_id) {
            $store_all_id[] = $comment_id['komentar_parent'];
        }
        // return all hierarchical tree data from in_parent by sending
        //  initiate parameters 0 is the main parent,news id, all parent ids

        return $this->in_parent(0, $post_id, $store_all_id);
    }

    public function in_parent($in_parent, $post_id, $store_all_id)
    {
        // this variable to save all concatenated html
        $html = '';
        // build hierarchy  html structure based on ul li (parent-child) nodes
        if (in_array($in_parent, $store_all_id, false)) {
            $result = $this->m_user->tree_by_parent($post_id, $in_parent);
            $html .= '<div class="thread_comments">';

            foreach ($result as $re) {
                $grav_url = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($re['email']))) . '?d=mp&s=50';

                $check = $this->db->query("SELECT * FROM post, user 
                WHERE post.id_user = user.id_user
                AND post.id_post = $post_id
                ")->row_array();

                if ($re['nama'] == $check['nama_user']) {
                    $tanda = '<span class="badge bg-danger">Pembuat</span>';
                } else {
                    $tanda = '';
                }

                $html .= '<div class="d-flex pt-3 ' . ($in_parent === 0 ? 'border-bottom' : '') . '">';
                $html .= '<img class="flex-shrink-0 me-2 rounded-circle" id="avt" style="width:50px; height:50px;" alt="" src="' . $grav_url . '" />';
                $html .= '<div class="pb-3 mb-0 lh-sm w-100">

				<div class="d-flex justify-content-between">
                <strong class="text-gray-dark">' . $re['nama'] . ' ' . $tanda . '</strong>
                <a href="#form_komentar" class="reply-comment" data-nama="' . $re['nama'] . '" id=' . $re['id_komentar'] . '><span>balas <i class="fas fa-reply"></i></span></a>
				</div>
				<span class="d-block small text-muted">' . $re['tanggal_komentar'] . '</span>
				<p class="mt-3">' . $re['pesan'] . '</p>';
                $html .= $this->in_parent($re['id_komentar'], $post_id, $store_all_id);
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        return $html;
    }

    public function pesan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
            'required' => 'Kolom ini harus di isi'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required', [
            'required' => 'Kolom ini harus di isi',
        ]);
        $this->form_validation->set_rules('isi', 'Isi', 'trim|required', [
            'required' => 'Kolom ini harus di isi',
        ]);

        $this->form_validation->set_rules('g-recaptcha-response', 'Recaptcha', 'required');

        $url = $this->input->post('url');

        if ($this->form_validation->run() === false) {
            $return = [
                'text'  => 'Mohon maaf pesan Anda gagal terkirim.',
                'class' => 'danger',
            ];

            $this->session->set_flashdata('message', '
            <div id="toast" class="toast position-fixed bottom-0 end-0 p-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000" style="z-index: 9999">
                <div class="toast-header">
                    <i class="fas fa-info-circle text-' . $return['class'] . '"></i>
                    <strong class="me-auto">Info</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ' . $return['text'] . '
                </div>
            </div>');

            redirect($url);
        } else {
            $this->db->insert('pesan', [
                'nama'    => htmlspecialchars($this->input->post('nama')),
                'email'   => htmlspecialchars($this->input->post('email')),
                'isi'     => htmlspecialchars($this->input->post('isi')),
                'tanggal' => date('Y-m-d H:i:s'),
            ]);

            $return = [
                'text'  => 'Pesan Anda telah terkirim, Terimakasih.',
                'class' => 'success',
            ];

            $this->session->set_flashdata('message', '
            <div id="toast" class="toast position-fixed bottom-0 end-0 p-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000" style="z-index: 9999">
                <div class="toast-header">
                    <i class="fas fa-info-circle text-' . $return['class'] . '"></i>
                    <strong class="me-auto">Info</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ' . $return['text'] . '
                </div>
            </div>');

            redirect($url);
        }
    }

    public function post_by_id()
    {
        $q = $this->m_user->get_post_by_id((int) $_GET['id']);

        if ($q->num_rows() > 0) {
            $r = $q->row();

            return redirect('post/detail/' . $r->permalink . '#komen');
        }

        return redirect('notfound');
    }

    public function block()
    {
        $data['judul'] = '403 Forbidden Page';
        $this->load->view('template/header', $data);
        $this->load->view('forbidden', $data);
        $this->load->view('template/footer');
    }

    public function notfound()
    {
        $data['judul'] = '404 Page Not Found';

        $this->output->set_status_header('404');
        $this->load->view('template/header', $data);
        $this->load->view('notfound', $data);
        $this->load->view('template/footer');
    }
}
