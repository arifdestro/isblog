<?php
class M_user extends CI_Model
{
    public function getAll($table)
    {
        return $this->db->get($table);
    }

    public function edit($where, $table)
    {
        return $this->db->get_where($table, $where);
    }

    public function update_($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    function getHahsDetails($hash)
    {
        $query = $this->db->query("SELECT * FROM user WHERE hash_key='{$hash}'");
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function updateNewPassword($data, $hash)
    {
        $this->db->where('hash_key', $hash);
        $this->db->update('user', $data);
    }

    function validateEmail($email)
    {
        $query = $this->db->query("SELECT * FROM user WHERE email='{$email}'");
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function insert_batch($data, $tb)
    {
        $this->db->insert_batch($tb, $data);
        return $this->db->affected_rows();
    }

    function ubhpsw($pswhash, $id_user)
    {
        $this->db->set('password', $pswhash);
        $this->db->set('ubah_password', date('Y-m-d'));
        $this->db->where('id_user', $id_user);
        $this->db->update('user');
        return $this->db;
    }

    function updatePasswordhash($data, $email)
    {
        $this->db->where('email', $email);
        $this->db->update('user', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_komentar', $id);
        $this->db->update('komentar', $data);

        return (bool) ($this->db->affected_rows() > 0);
    }

    public function list($id_post)
    {
        $this->db->select('*');
        $this->db->from('post');
        $this->db->join('kategori', 'kategori.id_kategori = post.id_kategori');
        $this->db->limit(3);
        $this->db->where('post.status_post', 1);
        $this->db->where_not_in('post.id_post', $id_post);
        $this->db->order_by('id_post', 'DESC');

        return $this->db->get()->result();
    }

    public function get_post_by_slug($slug)
    {
        $this->db->from('post');
        $this->db->join('kategori', 'post.id_kategori = kategori.id_kategori');
        $this->db->where(['post.permalink' => $slug]);

        return $this->db->get();
    }

    public function get_post_list($offset, $limit)
    {
        $this->db->select('*');
        $this->db->from('post');
        // $this->db->join('user', 'post.id_user=user.id_user', 'left');
        $this->db->join('kategori', 'post.id_kategori=kategori.id_kategori', 'left');
        $this->db->where('status_post', '1');
        $this->db->order_by('id_post', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_post()
    {
        return $this->db->query("SELECT * FROM post, kategori WHERE post.id_kategori = kategori.id_kategori AND status_post = '1'");
    }

    public function search($query)
    {
        return $this->db->query("SELECT * FROM post, kategori WHERE post.id_kategori = kategori.id_kategori AND judul_post LIKE '%{$query}%' ORDER BY id_post DESC");
    }

    public function terbit(int $id, int $status)
    {
        $data = [
            'status' => $status,
        ];

        return $this->update($id, $data);
    }

    public function delete_comment($id)
    {
        $this->db->where('id_komentar', $id);
        $this->db->delete('komentar');

        return (bool) ($this->db->affected_rows() > -1);
    }

    public function getComments(int $status, $limit, $offset)
    {
        $this->db->select('*');
        $this->db->from('post');
        $this->db->join('detail_komentar', 'post.id_post=detail_komentar.id_post', 'left');
        $this->db->join('komentar', 'detail_komentar.id_komentar=komentar.id_komentar', 'left');
        $this->db->where('status', $status);
        $this->db->order_by('komentar.id_komentar', 'DESC');

        if (!is_null($limit) && !is_null($offset)) {
            $this->db->limit($limit, $offset);
        }

        // $query = $this->db->get();
        return $this->db->get();
    }

    public function get_post_by_id($id)
    {
        $this->db->from('post');
        $this->db->join('kategori', 'post.id_kategori = kategori.id_kategori');
        $this->db->where(['id_post' => $id]);

        return $this->db->get();
    }

    public function get_all_post(?int $status = null)
    {
        $this->db->select('p.id_post, p.id_kategori, p.judul_post, p.gambar_post, p.permalink, p.tanggal_post, p.status_post, p.pengunjung_post, p.id_user, u.nama_user, k.nama_kategori');

        $this->db->from('post p');
        $this->db->join('user u', 'p.id_user=u.id_user');
        $this->db->join('kategori k', 'p.id_kategori=k.id_kategori');
        if ($status !== null) {
            $this->db->where('p.status_post', $status);
        }
        $this->db->order_by('p.id_post DESC');

        return $this->db->get();
    }

    public function get_comment()
    {
        return $this->db->query('SELECT * FROM komentar, detail_komentar, post 
        WHERE komentar.id_komentar = detail_komentar.id_komentar
        AND post.id_post = detail_komentar.id_post
        ');
    }

    public function get_all_comment(int $offset, int $limit)
    {
        $this->db->limit($limit);
        $this->db->offset($offset);

        return $this->db->get('komentar');
    }

    // get full tree comments based on news id
    public function tree_all($post_id)
    {
        $result = $this->db->query("SELECT * FROM komentar, post, detail_komentar WHERE komentar.id_komentar = detail_komentar.id_komentar AND post.id_post = detail_komentar.id_post AND detail_komentar.id_post={$post_id} AND komentar.status= 1");

        if ($result->num_rows() === 0) {
            return null;
        }

        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }

    // to get child comments by entry id and parent id and news id
    public function tree_by_parent($post_id, $parent_id)
    {
        $get = $this->db->query("SELECT * FROM komentar, post, detail_komentar WHERE komentar.id_komentar = detail_komentar.id_komentar AND post.id_post = detail_komentar.id_post AND detail_komentar.id_post={$post_id} AND komentar.komentar_parent={$parent_id} AND komentar.status= 1");

        if ($get->num_rows() > 0) {
            return $get->result_array();
        }

        return [];
    }

    public function counter(?int $status = null)
    {
        if ($status !== null) {
            $this->db->where('status', $status);
        }

        return $this->db->get('komentar');
    }

    public function counter_msg(?int $status = null)
    {
        if ($status !== null) {
            $this->db->where('read_msg', $status);
        }

        return $this->db->get('pesan');
    }

    public function read($id_pesan, $set)
    {
        $this->db->set($set);
        $this->db->where('id_pesan', $id_pesan);
        $this->db->update('pesan');
    }

    public function count_views($kode)
    {
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $cek_ip  = $this->db->query("SELECT * FROM post_pengunjung WHERE ip_pengunjung='{$user_ip}' AND id_post='{$kode}' AND DATE(tanggal)=CURDATE()");
        if ($cek_ip->num_rows() <= 0) {
            $this->db->trans_start();
            $this->db->query("INSERT INTO post_pengunjung (ip_pengunjung,id_post) VALUES('{$user_ip}','{$kode}')");
            $this->db->query("UPDATE post SET pengunjung_post=pengunjung_post+1 where id_post='{$kode}'");
            $this->db->trans_complete();

            return (bool) ($this->db->trans_status() === true);
        }
    }

    public function count_visitor()
    {
        $user_ip = '';
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $user_ip = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $user_ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $user_ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $user_ip = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $user_ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Other';
        }
        $cek_ip = $this->db->query("SELECT * FROM pengunjung WHERE ip_pengguna='{$user_ip}' AND DATE(tanggal)=CURDATE()");
        if ($cek_ip->num_rows() <= 0) {
            $hsl = $this->db->query("INSERT INTO pengunjung (ip_pengguna,media_browser) VALUES('{$user_ip}','{$agent}')");

            return $hsl;
        }
    }

    public function visitor_statistics()
    {
        $query = $this->db->query("SELECT DATE_FORMAT(tanggal,'%d') AS tgl,COUNT(ip_pengguna) AS jumlah FROM pengunjung WHERE MONTH(tanggal)=MONTH(CURDATE()) GROUP BY DATE(tanggal)");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $result[] = $data;
            }

            return $result;
        }
    }

    public function count_all_visitors()
    {
        return $this->db->count_all('pengunjung');
    }

    public function count_all_page_views()
    {
        return $this->db->count_all('post_pengunjung');
    }

    public function count_all_posts()
    {
        return $this->db->count_all('post');
    }

    public function count_all_comments()
    {
        return $this->db->count_all('komentar');
    }

    public function top_five_articles()
    {
        return $this->db->query('SELECT * FROM post ORDER BY pengunjung_post DESC LIMIT 5');
    }

    public function count_visitor_this_month()
    {
        return $this->db->query('SELECT COUNT(*) tot_visitor FROM pengunjung WHERE MONTH(tanggal)=MONTH(CURDATE())');
    }

    public function count_chrome_visitors()
    {
        return $this->db->query("SELECT COUNT(*) chrome_visitor FROM pengunjung WHERE media_browser='Chrome' AND MONTH(tanggal)=MONTH(CURDATE())");
    }

    public function count_firefox_visitors()
    {
        return $this->db->query("SELECT COUNT(*) firefox_visitor FROM pengunjung WHERE (media_browser='Firefox' OR media_browser='Mozilla') AND MONTH(tanggal)=MONTH(CURDATE())");
    }

    public function count_explorer_visitors()
    {
        return $this->db->query("SELECT COUNT(*) explorer_visitor FROM pengunjung WHERE media_browser='Internet Explorer' AND MONTH(tanggal)=MONTH(CURDATE())");
    }

    public function count_safari_visitors()
    {
        return $this->db->query("SELECT COUNT(*) safari_visitor FROM pengunjung WHERE media_browser='Safari' AND MONTH(tanggal)=MONTH(CURDATE())");
    }

    public function count_opera_visitors()
    {
        return $this->db->query("SELECT COUNT(*) opera_visitor FROM pengunjung WHERE media_browser='Opera' AND MONTH(tanggal)=MONTH(CURDATE())");
    }

    public function count_robot_visitors()
    {
        return $this->db->query("SELECT COUNT(*) robot_visitor FROM pengunjung WHERE (media_browser='YandexBot' OR media_browser='Googlebot' OR media_browser='Yahoo') AND MONTH(tanggal)=MONTH(CURDATE())");
    }

    public function count_other_visitors()
    {
        return $this->db->query("SELECT COUNT(*) other_visitor FROM pengunjung WHERE
			(NOT media_browser='YandexBot' AND NOT media_browser='Googlebot' AND NOT media_browser='Yahoo'
			AND NOT media_browser='Chrome' AND NOT media_browser='Firefox' AND NOT media_browser='Mozilla'
			AND NOT media_browser='Internet Explorer' AND NOT media_browser='Safari' AND NOT media_browser='Opera')
			AND MONTH(tanggal)=MONTH(CURDATE())");
    }
}
