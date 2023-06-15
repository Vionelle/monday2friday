<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Entities\Barang;
use CodeIgniter\Config\Config;

class Dashboard extends BaseController
{
    public function __construct(){
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->barangModel = new \App\Models\BarangModel();
        $this->barang = new \App\Entities\Barang();
        $this->db      = \Config\Database::connect();
        $this->builderBarang = $this->db->table('barang');
        $this->builder = $this->db->table('user');
        $this->transaksiModel = new \App\Models\TransaksiModel();
        $this->email = \Config\Services::email();
    }

    public function viewCreate(){

        $data1['judul'] = "Tambah Barang";
        echo view('admin/template_header',$data1);
        echo view('admin/tambah_barang',$data1);
        echo view('admin/template_footer',$data1);

    }

    public function create(){
        // dd('submit');
        $this->builderBarang->selectMax("id");
        $id_tangkap = $this->builderBarang->countAll();
        $id_tangkap++;
        $id_barang = "BRG" . $id_tangkap;
        // dd($id_barang);

        if($this->request->getPost()){
            //Jika ada data yang di post
            $data = $this->request->getPost();
            $gambar = $this->request->getFile('gambar');
            $this->validation->run($data,'barang');
            $errors = $this->validation->getErrors();
            // dd($errors);

            if($errors){
                dd('gagal');
                session()->setFlashdata('errors', $errors);
                return redirect()->to('admin/v_tambahbarang');                
            }

            if(!$errors){
                // dd('berhasil');
                $this->barang->fill($data);
                $this->barang->id = $id_barang;
                $this->barang->gambar = $gambar;
                // $this->barang->created_by = $this->session->get('id');
                $this->barang->created_date = date("Y-m-d H:i:s");
                // dd($this->barangModel->save($this->barang).value);
                $this->barangModel->save($this->barang);

                // $id = $this->barangModel->insertID();

                $segments = ['admin','listbarang'];

                return redirect()->to(site_url($segments));
            }
        }     
    }
    
    public function home(){
        // dd($this->session->get('username'));
        // if ($this->session->get('role') != 0) {
        //     return redirect()->to('admin/login');
        // }
        // $data=[];
        // $data['judul'] = "Dashboard";

        $this->builder->select('user.id as userid, username, role, email, kontak');
        $query = $this->builder->get();

        //CHART
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');
        $queryYear = $builder->select("COUNT(id_transaksi) as transaksi, YEAR(created_date) as year");
        $queryYear = $builder->groupBy("YEAR(created_date)");
        $queryYear = $builder->orderBy("YEAR(created_date)", "ASC")->get();
        $record = $queryYear->getResult();
        $years = [];
        foreach ($record as $row) {
            $years[] = array(
                'year'   => $row->year,
                'id_transaksi'   => $row->transaksi,
            );
        }

        $queryMonth = $builder->select("COUNT(id_transaksi) as count, MONTHNAME(created_date) as month");
        $queryMonth = $builder->where("YEAR(created_date)=YEAR(NOW()) AND MONTH(created_date) GROUP BY MONTHNAME(created_date) ORDER BY STR_TO_DATE(CONCAT( month), '%M')")->get();
        $recordMonth = $queryMonth->getResult();
        $months = [];
        foreach ($recordMonth as $row) {
            $months[] = array(
                'month'   => $row->month,
                'id_transaksi'   => $row->count,
            );
        }

        $transaksiModel = new \App\Models\TransaksiModel();

        $pie_snack = $transaksiModel->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->countAllResults();
        $pie_rajutan = $transaksiModel->join('barang', 'barang.id_barang=transaksi.id_barang')
            ->countAllResults();

        $data = [
            'judul' => "Dashboard",
            'users' => $query->getResult(),
            'years' => $years,
            'months' => $months,
            'pie_snack' => $pie_snack,
            'pie_rajutan' => $pie_rajutan
        ];

        echo view('admin/template_header',$data);
        echo view('admin/dashboard_admin',$data);
        echo view('admin/template_footer',$data);

        //return redirect()->to(site_url('home/index'));
    }

    public function list(){
        $data=[];
        $data['judul'] = "List Barang";
        // $search = $this->request->getVar('search');

        $b = $this->barangModel->findAll();

        $dataBarang = [
            'barang' => $this->barangModel->paginate(10),
            'pager' => $this->barangModel->pager,
        ];

        // if($search){
        //     $query = $this->barangModel->search($search);
        //     $jumlah = "Pencarian dengan nama <B>$search</B> ditemukan ".$query->affectedRows()." Data";
        // } else {
        //     $query = $this->barangModel;
        //     $jumlah = "";
        // }
    
        echo view('admin/template_header',$data);
        echo view('admin/list_barang',[
            'data' => $dataBarang,
            'b' => $b,
            // 'jumlah' => $jumlah
        ]);
        echo view('admin/template_footer',$data); 

        // return view('admin/list_barang',['b' => $b]);
    }

    // public function search(){
    //     $data =[];
    //     $data['judul'] = "Hasil Pencarian";

    //     $search = $this->request->getGet('search');
    //     $dataS = $this->barangModel->where('nama', $search)->findAll();
        
    //     echo view('admin/template_header',$data);
    //     echo view('admin/hasil_pencarianB', [
    //         'dataS' => $dataS,
    //     ]);
    //     echo view('admin/template_footer',$data); 
    // }

    public function view(){
        $id = $this->request->uri->getSegment(3);

        // echo $id;

        $data=[];
        $data['judul'] = "View Barang";   

        $barang = $this->barangModel->find($id);
        // $barang = $this->barang;

        // if($barang){
        //     return view('admin/view_barang.php',['barang' => $barang]); 
        // }

        // session()->setFlashdata('success',['Item berhasil ditambahkan ke database']);

        echo view('admin/template_header',$data);
        echo view('admin/view_barang.php',['barang' => $barang]);
        echo view('admin/template_footer',$data); 
             
    }

    public function update(){
        $id = $this->request->uri->getSegment(3);

        $data1=[];
        $data1['judul'] = "Update Barang";

        $barang = $this->barangModel->find($id);

        if($this->request->getPost()){
            $data = $this->request->getPost();
            $this->validation->run($data,'barangupdate');
            $errors = $this->validation->getErrors();

            if(!$errors){
                $this->barang->id = $id;
                $this->barang->fill($data);

                if($this->request->getFile('gambar')->isValid()){
                    $this->barang->gambar = $this->request->getFile('gambar');
                }
                // $this->barang->updated_by = $this->session->get('id');
                $this->barang->updated_date = date("Y-m-d H:i:s");

                $this->barangModel->save($this->barang);

                $segments = ['admin','viewbarang', $id];

                return redirect()->to(site_url($segments));
            }
        }
        echo view('admin/template_header',$data1);
        echo view('admin/update_barang.php',['barang' => $barang]);
        echo view('admin/template_footer',$data1); 
    }

    public function delete(){
        $id = $this->request->uri->getSegment(3);

        $delete = $this->barangModel->delete($id);

        return redirect()->to(site_url('admin/listbarang'));
    }
}
?>