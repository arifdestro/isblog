<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->model('M_user', 'm_user');
    }

    /** Menampilkan Form Login */
    public function index()
    {

        if (user_logged_in()) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Anda telah login.
                        </div>');
            return redirect('admin/home');
        }

        $this->form_validation->set_rules('input', 'Input', 'trim|required', [
            'required' => 'Kolom ini harus di isi'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Kolom ini harus di isi',
        ]);

        if ($this->form_validation->run() == false) {
            $data['get'] = $this->db->get('pengaturan')->row_array();
            $data['judul'] = 'Login Akun | KD-ADMIN';
            $this->load->view("template/header", $data);
            $this->load->view("auth/login", $data);
            $this->load->view("template/footer");
        } else {
            $this->login();
        }
    }

    private function login()
    {
        $input = htmlspecialchars(($this->input->post('input')));
        $password = htmlspecialchars(($this->input->post('password')));
        $user = $this->db->query("SELECT * FROM user, akses WHERE user.id_role = akses.id_role AND nama_user = '{$input}' OR email = '{$input}'")->row_array();

        $request = [
            'alert1' => 'success',
            'alert2' => 'warning',
            'alert3' => 'danger',
            'alert4' => 'dark',
            'text0' => 'Validasi Captcha belum dimasukkan',
            'text1' => 'Validasi Captcha gagal',
            'text2' => 'Email atau Sandi yang anda masukkan kurang tepat',
            'text3' => 'Email belum ter-aktivasi, silahkan aktivasi terlebih dahulu',
            'text4' => 'Email belum di registrasi atau belum terdaftar',
            'text5' => 'Anda berhasil masuk sebagai',
            'text6' => 'Akun anda telah diblokir. Untuk mengaktifkan kembali, silahkan hubungi Admin'
        ];

        $get = $this->db->get('pengaturan')->row_array();

        // Menerima inputan post berupa checklist
        $captcha_response = trim($this->input->post('g-recaptcha-response'));

        // Mengecek apakah terdapat inputan atau tidak, jika tidak maka tampil notif
        if ($captcha_response != '') {
            // Screet-key recaptcha
            $keySecret = $get['recaptcha_secret'];

            // Membuat variabel sebagai penampung data Key, untuk dicocokan dengan data dari recaptcha google
            $check = array(
                'secret'        =>    $keySecret,
                'response'        =>    $this->input->post('g-recaptcha-response')
            );

            // Membuat HTTP Request untuk cek data validasi recaptcha
            $startProcess = curl_init();

            curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

            curl_setopt($startProcess, CURLOPT_POST, true);

            curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

            curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

            // Eksekusi data
            $receiveData = curl_exec($startProcess);

            // Merubah format penulisan
            $finalResponse = json_decode($receiveData, true);

            if ($finalResponse['success']) {
                if ($user) {
                    if ($user['status'] == 1) {
                        if (password_verify($password, $user['password'])) {
                            $data = [
                                'id_usr' => $user['id_user'],
                                'email' => $user['email'],
                                'name' => $user['nama_user'],
                                'role' => $user['akses'],
                                'loggedIn' => true
                            ];
                            $this->session->set_userdata($data);

                            $this->session->set_flashdata(
                                'pesan',
                                '<div id="pesan" class="alert alert-' . $request['alert1'] . '" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text5'] . ' ' . $user['akses'] . '.
                        </div>'
                            );
                            redirect('admin/home');
                        } else {
                            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert2'] . '" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text2'] . '.
                    </div>');
                            redirect('auth');
                        }
                    } else if ($user['status'] == 2) {
                        $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert4'] . '" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text6'] . '.
                </div>');
                        redirect('auth');
                    } else {
                        $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert2'] . '" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text3'] . '.
                </div>');
                        $data['judul'] = 'Aktifkan Akun | KD-ADMIN';
                        $this->load->view("template/header", $data);
                        $this->load->view("auth/send", $data);
                        $this->load->view("template/footer");
                    }
                } else {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert3'] . '" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text4'] . '.
            </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert2'] . '" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text1'] . '.
                    </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request['alert2'] . '" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request['text0'] . '.
                </div>');
            redirect('auth');
        }
    }

    /**Fungsi Log out */
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('id_usr');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('cnama');
        $this->session->unset_userdata('cemail');
        // $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        $request1 = [
            'alert1' => 'success',
            'text1' => 'Anda telah berhasil keluar (<i>logout</i>)'
        ];

        $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-' . $request1['alert1'] . ' alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-info-circle"></i> Info!</strong> ' . $request1['text1'] . '.
        </div>');
        redirect('auth');
    }

    public function forgot()
    {
        if (user_logged_in()) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Anda telah memiliki akses login, tidak dapat mengganti lewat email.
                        </div>');
            redirect('admin/home');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
                'required' => 'Kolom ini harus diisi',
                'valid_email' => 'Email tidak valid'
            ]);
            if ($this->form_validation->run() == true) {
                $email  = $this->input->post('email');
                $validateEmail = $this->m_user->validateEmail($email);
                if ($validateEmail != false) {
                    $row = $validateEmail;
                    $user_id = $row->id_user;
                    $name = $row->nama_user;

                    $string = time() . $user_id . $email;
                    $hash_string = hash('sha256', $string);
                    $currentDate = date('Y-m-d H:i');
                    $hash_expiry = date('Y-m-d H:i', strtotime($currentDate . ' + 1 days'));

                    $data = array(
                        'hash_key' => $hash_string,
                        'hash_expire' => $hash_expiry,
                    );

                    $resetLink = base_url() . 'reset?hash=' . $hash_string;
                    // $message = '<p>Reset sandi anda disini:</p>' . $resetLink;
                    $subject = "Password Reset link";
                    // $jenis = "Ubah Password";
                    $sentStatus = $this->_sendEmail($email, $subject, $resetLink, $name);
                    if ($sentStatus == true) {
                        $this->m_user->updatePasswordhash($data, $email);
                        $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Berhasil mengirimkan link reset sandi, cek email anda.
                        </div>');
                        redirect('forgot');
                    } else {
                        $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle"></i> Info!</strong> Email tidak dapat terkirim (<i>error</i>).
                        </div>');
                        redirect('forgot');
                    }
                } else {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Email tidak ada dalam database (<i>error</i>).
                    </div>');
                    redirect('forgot');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Cek kembali Inputan anda, pastikan sesuai dengan form.
                </div>');
                $data['judul'] = 'Lupa Sandi | KD-ADMIN';
                $this->load->view("template/header", $data);
                $this->load->view("auth/forgot", $data);
                $this->load->view("template/footer");
            }
        } else {
            $data['judul'] = 'Lupa Sandi | KD-ADMIN';
            $this->load->view("template/header", $data);
            $this->load->view("auth/forgot", $data);
            $this->load->view("template/footer");
        }
    }

    public function reset()
    {
        $hash = $this->input->get('hash');

        $user = $this->db->get_where('user', [
            'hash_key' => $hash
        ])->row_array();

        if ($user) {

            $key = $this->db->get_where('user', [
                'hash_expire' => $user['hash_expire']
            ])->row_array();
            $user_id = $key['id_user'];
            $email = $key['email'];
            $currentDate = date('Y-m-d H:i');
            $cek = $key['hash_expire'];
            if ($key) {
                if ($currentDate < $cek) {
                    $this->session->set_userdata('id_usr', $user_id);
                    $this->session->set_userdata('reset_email', $email);
                    $this->recover();
                    $this->db->set('hash_key', null);
                    $this->db->set('hash_expire', null);
                    $this->db->where('hash_key', $hash);
                    $this->db->update('user');
                } else {
                    $this->db->set('hash_key', null);
                    $this->db->set('hash_expire', null);
                    $this->db->where('hash_key', $hash);
                    $this->db->update('user');

                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Token telah kadaluarsa.
                        </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Token anda salah.
                        </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Email anda salah, atau anda belum mengirimkan request ke email.
                        </div>');
            redirect('auth');
        }
    }

    public function recover()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        if (user_logged_in()) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Anda telah memiliki akses login, tidak dapat mengganti lewat email.
                        </div>');
            redirect('admin/beranda');
        }

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[newpassword]', [
            'required' => 'Kolom ini harus diisi',
            'min_length' => 'Password minimal berjumlah 8 karakter',
            'matches' => ''
        ]);

        $this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|min_length[8]|matches[password]', [
            'required' => 'Kolom ini harus diisi',
            'min_length' => 'Password minimal berjumlah 8 karakter',
            'matches' => 'Konfirmasi password salah'
        ]);

        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Reset Sandi | KD-ADMIN';
            $this->load->view("template/header", $data);
            $this->load->view("auth/recover", $data);
            $this->load->view("template/footer");
        } else {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');
            $this->db->set('ubah_tanggal', date('Y-m-d'));
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->unset_userdata('id_usr');

            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Berhasil reset sandi, cek dengan login untuk mencoba.
                        </div>');
            redirect('auth');
        }
    }

    public function send()
    {
        if (user_logged_in()) {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Anda telah memiliki akses login, tidak dapat mengganti lewat email.
                        </div>');
            redirect('admin/beranda');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
            'required' => 'Kolom ini harus diisi',
            'min_length' => 'Password minimal berjumlah 8 karakter',
            'valid_mail' => 'Masukkan email dengan format yang benar'
        ]);

        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Aktifkan Akun | KD-ADMIN';
            $this->load->view("template/header", $data);
            $this->load->view("auth/send", $data);
            $this->load->view("template/footer");
        } else {
            $email = $this->input->post('email');
            $cek = $this->db->get_where('user', ['email' => $email])->row_array();
            $user_id = $cek['id_user'];
            $name = $cek['nama_user'];
            if ($cek != null) {
                $this->session->set_userdata('id_usr', $user_id);
                $string = time() . $user_id . $email;
                $hash_string = hash('sha256', $string);
                $currentDate = date('Y-m-d H:i');
                $hash_expiry = date('Y-m-d H:i', strtotime($currentDate . ' + 1 days'));

                $data = array(
                    'hash_key' => $hash_string,
                    'hash_expire' => $hash_expiry,
                );

                $resetLink = base_url() . 'active?hash=' . $hash_string;
                // $message = '<p>Aktivasi akun anda disini:</p>' . $resetLink;
                $subject = "Aktivasi akun link";
                // $jenis = "Aktivasi Akun";
                $sentStatus = $this->_sendEmail($email, $subject, $resetLink, $name);

                if ($sentStatus == true) {
                    $this->m_user->updatePasswordhash($data, $email);
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Berhasil mengirimkan link aktivasi akun, cek email anda.
                    </div>');
                    redirect('send');
                } else {
                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Email tidak dapat terkirim (<i>error</i>).
                    </div>');
                    redirect('send');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Email tidak terdapat dalam database (<i>error</i>).
                </div>');
                redirect('send');
            }
        }
    }

    public function active()
    {
        $hash = $this->input->get('hash');

        $user = $this->db->get_where('user', [
            'hash_key' => $hash
        ])->row_array();

        if ($user) {

            $key = $this->db->get_where('user', [
                'hash_expire' => $user['hash_expire']
            ])->row_array();
            $email = $key['email'];
            $currentDate = date('Y-m-d H:i');
            $cek = $key['hash_expire'];
            if ($key) {
                if ($currentDate < $cek) {
                    $this->db->set('hash_key', null);
                    $this->db->set('hash_expire', null);
                    $this->db->set('status', '1');
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $data['judul'] = 'Berhasil Aktivasi | KD-ADMIN';
                    $this->load->view("template/header", $data);
                    $this->load->view("auth/activate", $data);
                    $this->load->view("template/footer");
                } else {
                    $this->db->set('hash_key', null);
                    $this->db->set('hash_expire', null);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-info-circle"></i> Info!</strong> Token telah kadaluarsa.
                        </div>');
                    redirect('send');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle"></i> Info!</strong> Token anda salah.
                        </div>');
                redirect('send');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-info-circle"></i> Info!</strong> Email anda salah, atau anda belum mengirimkan request ke email.
                        </div>');
            redirect('send');
        }
    }

    /**Konfigurasi kirim email */
    private function _sendEmail($email, $subject, $message, $name)
    {
        ini_set("SMTP", "ssl://smtp.gmail.com");
        ini_set("smtp_port", "465");

        $get = $this->db->get('pengaturan')->row_array();

        $config = [
            'protocol'      => 'smtp',
            'smtp_host'     => 'ssl://smtp.gmail.com',
            'smtp_user'     => $get['smtp_mail'],
            'smtp_pass'     => $get['smtp_password'],
            'smtp_port'     => 465,
            // 'smtp_crypto'   => 'tls',
            'mailtype'      => 'html',
            'charset'       => 'iso-8859-1',
            'newline'       => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->from('destro.comm4624@gmail.com', 'KD Helper');
        $this->email->to($email);

        $this->email->subject($subject);

        $this->email->message($this->mail($subject, $message, $name, $email));
        $this->email->set_mailtype('html');

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    private function mail($judul, $link, $name, $email)
    {
        $html =
            '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#ffffff">
            <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
            <tbody>
                <tr>
                    <td>
                        <table align="center" width="750px" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="width:750px!important">
                        <tbody>
                            <tr>
                                <td>
                                    <table width="690" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" align="center">
                                                <table width="630" align="center" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="3" height="60"></td></tr><tr><td width="25"></td>
                                                        <td align="center">
                                                            <h1 style="font-family:HelveticaNeue-Light,arial,sans-serif;font-size:48px;color:#404040;line-height:48px;font-weight:bold;margin:0;padding:0">' . $judul . '</h1>
                                                        </td>
                                                        <td width="25"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" height="40"></td></tr><tr><td colspan="5" align="center">
                                                            <p style="color:#404040;font-size:16px;line-height:24px;font-weight:lighter;padding:0;margin:0">Hello ' . $name . ', Untuk ' . $judul . ' anda dengan email ' . $email . ' silahkan klik tombol di bawah. Atau bisa dengan klik link dibawah tombol.</p><br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td colspan="4">
                                                        <div style="width:100%;text-align:center;margin:30px 0">
                                                            <table align="center" cellpadding="0" cellspacing="0" style="font-family:HelveticaNeue-Light,Arial,sans-serif;margin:0 auto;padding:0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" style="margin:0;text-align:center"><a href="' . $link . '" style="font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#0096d3;padding:14px 40px;display:block;letter-spacing:1.2px" target="_blank">' . $judul . '!</a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" style="margin:0;text-align:center;font-size:21px;line-height:22px;padding:14px 40px">Atau</td>
                                                                </tr>
                                                                <tr>
                                                                <td align="center" style="margin:0;text-align:center"><a href="' . $link . '" style="font-size:15px;line-height:22px;text-decoration:none" target="_blank">' . $link . '</td>
                                                                </tr>
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr><td colspan="3" height="30"></td></tr>
                                            </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <table align="center" width="750px" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="width:750px!important">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="630" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                    <tbody>
                                                        <tr><td colspan="2" height="30"></td></tr>
                                                        <tr>
                                                            <td width="400" style="text-align:center" valign="top">
                                                                <div style="color:#a3a3a3;font-size:12px;line-height:12px;padding:0;margin:0">&copy; ' . date('Y') . ' KD-ADMIN. All rights reserved.</div>
                                                                <div style="line-height:5px;padding:0;margin:0">&nbsp;</div>
                                                                <div style="color:#a3a3a3;font-size:12px;line-height:12px;padding:0;margin:0">Version Test</div>
                                                            </td>
                                                        </tr>
                                                        <tr><td colspan="2" height="5"></td></tr>
                                                    </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>';

        return $html;
    }
}
