<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('user_logged_in')) {
    function user_logged_in()
    {
        $CI = &get_instance();
        // $CI->load->library('session');
        if ($CI->session->has_userdata('loggedIn')) {
            if ($CI->session->userdata('loggedIn')) {
                return true;
            }
        }

        return false;
    }
}

function cekakses()
{
    $var_ci = get_instance();
    if ($var_ci->session->userdata('role') != 'Admin') {
        redirect('beranda/block');
        die;
    }
}

function obfuscate_email($email)
{
    $em = explode("@", $email);
    $name = implode('@', array_slice($em, 0, count($em) - 1));
    $len = floor(strlen($name) / 2);

    return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
}

function phone($hp)
{
    return substr($hp, 0, 4) . "****" . substr($hp, 8, 4);
}

function autonumber($id_terakhir, $panjang_kode, $panjang_angka)
{

    // mengambil nilai kode ex: USR0015 hasil USR
    $kode = substr($id_terakhir, 0, $panjang_kode);

    // mengambil nilai angka
    // ex: USR0015 hasilnya 0015
    $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);

    // menambahkan nilai angka dengan 1
    // kemudian memberikan string 0 agar panjang string angka menjadi 4
    // ex: angka baru = 6 maka ditambahkan strig 0 tiga kali
    // sehingga menjadi 0006
    $angka_baru = str_repeat("0", $panjang_angka - strlen($angka + 1)) . ($angka + 1);

    // menggabungkan kode dengan nilang angka baru
    $id_baru = $kode . $angka_baru;

    return $id_baru;
}

if (!function_exists('word_limiter')) {
    /**
     * Word Limiter
     *
     * Limits a string to X number of words.
     *
     * @param	string
     * @param	int
     * @param	string	the end character. Usually an ellipsis
     * @return	string
     */
    function word_limiter($str, $limit = 100, $end_char = '&#8230;')
    {
        if (trim($str) === '') {
            return $str;
        }

        preg_match('/^\s*+(?:\S++\s*+){1,' . (int) $limit . '}/', $str, $matches);

        if (strlen($str) === strlen($matches[0])) {
            $end_char = '';
        }

        return rtrim($matches[0]) . $end_char;
    }
}

if (!function_exists('countPendingComment')) {
    function countPendingComment()
    {
        $CI = &get_instance();

        $CI->load->model('M_user', 'komentar');
        $count = $CI->komentar->counter(0);

        return $count->num_rows();
    }
}

if (!function_exists('countPesan')) {
    function countPesan()
    {
        $CI = &get_instance();

        $CI->load->model('M_user', 'pesan');
        $count = $CI->pesan->counter_msg(0);

        return $count->num_rows();
    }
}
