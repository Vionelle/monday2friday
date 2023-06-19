<?php

namespace App\Controllers;

class Product extends BaseController
{
    private $url = "https://api.rajaongkir.com/starter/";
    private $apiKey = "f68e6902743b3ca4b1a82c6868d6eeb6";

    public function __construct(){
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('barang');
        $this->builderTransaksi = $this->db->table('transaksi');
    }

    public function index(){
        $barang = new \App\Models\BarangModel();
        $model = $barang->findAll();

        if($size = $this->request->getGet('size')){
            $model = $barang->where('size',$size)->findAll();
            if(empty($model)){
                session()->setFlashdata('kosong','Barang dengan size '.$size.' sedang kosong');
                return redirect()->to(site_url('shop'));
            }
        }

        $dataBarang = [
            'barang' => $barang->paginate(10),
            'pager' => $barang->pager,
        ];
        
        return view('product/index',[
            'model' => $model,
            'data' => $dataBarang,
            'cart' => $cart = \Config\Services::cart()
        ]);
    }

    //** CHECKING */
    public function cek(){
        $cart = \Config\Services::cart();
        $response = $cart->contents();
        $data = json_encode($response, JSON_PRETTY_PRINT);

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    
    }

    public function tambah(){
        $cart = \Config\Services::cart();

        $cart->insert(array(
            'id' => $this->request->getPost('id'),
            'qty' => 1,
            'price' => $this->request->getPost('price'),
            'name' => $this->request->getPost('name'),
            'options' => array(
                'size' => $this->request->getPost('size'),
                'gambar' => $this->request->getPost('gambar'),
            )
        ));

        // $cart->destroy();

        session()->setFlashdata('success','Barang berhasil ditambahkan ke keranjang');
        return redirect()->to(site_url('shop'));

    }

    public function delete(){
        $id = $this->request->uri->getSegment(3);

        $cart = \Config\Services::cart();
        $cart->remove($id);
        return redirect()->to(base_url('shop/keranjang'));
    }

    public function viewCart(){
        $barang = new \App\Models\BarangModel();
        $model = $barang->findAll();

        return view('product/cart',[
            'model' => $model,
            'cart' => $cart = \Config\Services::cart()
        ]);
    }

    public function clearCart(){
        $cart = \Config\Services::cart();
        $cart->destroy();
    }

    public function checkout(){
        $cart = \Config\Services::cart();

        $provinsi = $this->rajaongkir('province');
        
        /** CEK JUMLAH ISI KERANJANG */
        // $len = count($cart->contents());
        // dd($len);

        if($this->request->getPost()){
            $data = $this->request->getPost();
            // dd($data);
            $this->validation->run($data,'checkout');
            $errors = $this->validation->getErrors();
            $keranjang = $cart->contents();

            foreach($keranjang as $items){
                if(!$errors){
                    // dd($items['name']);
                    $this->builderTransaksi->selectMax("id_transaksi");
                    $id_tangkap = $this->builderTransaksi->countAll();
                    $id_tangkap++;
                    $id_transaksi = "TRK" . $id_tangkap;
                    // dd($id_transaksi);

                    $transaksiModel = new \App\Models\TransaksiModel();
                    $transaksi = new \App\Entities\Transaksi();
                    $jumlah_pembelian = $items['qty'];
                    // dd($items['qty']);
                    $total = $this->request->getPost('total_harga');
                    // dd($total);
                    // $alamat = $this->request->getPost('alamat');
                    
                    $barangModel = new \App\Models\BarangModel();
                    $id_barang = $items['id'];
                    // dd($items['id']);
                    $barang = $barangModel->find($id_barang);
                    
                    $entBarang = new \App\Entities\Barang();
                    $entBarang->id_barang = $id_barang;
                    $entBarang->stok = $barang->stok-$jumlah_pembelian;
                    $barangModel->save($entBarang);

                    $transaksi->fill($data);
                    $transaksi->total_harga = $items['price'];
                    $transaksi->id_barang = $id_barang;
                    $transaksi->jumlah = $jumlah_pembelian;
                    $transaksi->id_transaksi = $id_transaksi;
                    $transaksi->status = "BELUM BAYAR";
                    // $transaksi->alamat = $alamat;
                    // $transaksi->created_by = $this->session->get('id');
                    $transaksi->created_date = date("Y-m-d H:i:s");
                    
                    // dd($transaksi);
                    $transaksiModel->save($transaksi);
                }
                else{
                    session()->setFlashdata('errors', 'Form tidak boleh kosong');
                    return redirect()->to(site_url('shop/checkout'));
                }              
            }
            // $cart->destroy();
            return view('transaksi/bayar_checkout',[
                'validation' => \Config\Services::validation(),
                'total' => $total,
                'cart' => $cart,
            ]);
        }

        $model = $cart->contents();

        return view('product/checkout',[
            'cart' => $cart,
            'provinsi' => json_decode($provinsi)->rajaongkir->results,
            'model' => $model,
        ]);
    }

    public function buy(){
        $id = $this->request->uri->getSegment(3);
        // dd($id);

        $modelBarang = new \App\Models\BarangModel();
        $model = $modelBarang->find($id);

        // if($model->stok == 0){
        //     // dd($model->stok);
        //     session()->setFlashdata('kosong','Barang sedang kosong');
        //     return redirect()->to(site_url('shop'));
        // }

        // $modelKomentar = new \App\Models\KomentarModel();
        // $komentar = $modelKomentar->where('id_barang',$id)->findAll();

        $provinsi = $this->rajaongkir('province');

        if($this->request->getPost()){
            $data = $this->request->getPost();
            $this->validation->run($data,'transaksi');
            $errors = $this->validation->getErrors();
            // dd($errors);
            
            if(!$errors){
                $this->builderTransaksi->selectMax("id_transaksi");
                $id_tangkap = $this->builderTransaksi->countAll();
                $id_tangkap++;
                $id_transaksi = "TRK" . $id_tangkap;
                // dd($id_transaksi);
                
                $transaksiModel = new \App\Models\TransaksiModel();
                $transaksi = new \App\Entities\Transaksi();
                $jumlah_pembelian = $this->request->getPost('jumlah');
                // $alamat = $this->request->getPost('alamat');
                
                $barangModel = new \App\Models\BarangModel();
                $id_barang = $this->request->getPost('id_barang');
                $barang = $barangModel->find($id_barang);
                
                $entBarang = new \App\Entities\Barang();
                $entBarang->id_barang = $id_barang;
                $entBarang->stok = $barang->stok-$jumlah_pembelian;
                $barangModel->save($entBarang);

                $transaksi->fill($data);
                $transaksi->id_transaksi = $id_transaksi;
                $transaksi->status = "BELUM BAYAR";
                // $transaksi->alamat = $alamat;
                // $transaksi->created_by = $this->session->get('id');
                $transaksi->created_date = date("Y-m-d H:i:s");
                
                // dd($transaksi);
                $transaksiModel->save($transaksi);

                // $id = $transaksiModel->insertID();

                $segment = ['shop','transaksi',$id_transaksi];

                return redirect()->to(site_url($segment));
            }
            else{
                $id_barang = $this->request->getPost('id_barang');
                session()->setFlashdata('errors', 'Form tidak boleh kosong');
                $segment = ['shop','beli',$id_barang];
                // dd($id_barang);
                return redirect()->to(site_url($segment));
            }
        }

        return view('product/buy',[
            'model' => $model,
            // 'komentar' => $komentar,
            'provinsi' => json_decode($provinsi)->rajaongkir->results,
            'cart' => $cart = \Config\Services::cart()
        ]);
    }

    public function transaksi(){
        $id_transaksi = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->find($id_transaksi);
        
        return view('transaksi/view',[
            'transaksi' => $transaksi,
            'cart' => $cart = \Config\Services::cart(),            
        ]);
    }

    public function getCity(){
        if($this->request->isAJAX()){
            $id_province = $this->request->getGet('id_province');
            $data = $this->rajaongkir('city', $id_province);

            return $this->response->setJSON($data);
        }
    }

    public function getCost(){
        if($this->request->isAJAX()){
            $origin = $this->request->getGet('origin');
            $destination = $this->request->getGet('destination');
            $weight = $this->request->getGet('weight');
            $courier = $this->request->getGet('courier');
            $data = $this->rajaongkircost($origin, $destination, $weight, $courier);
            
            return $this->response->setJSON($data);
        }
    }
    
    private function rajaongkircost($origin, $destination, $weight, $courier){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=".$origin."&destination=".$destination
                                    ."&weight=".$weight."&courier=".$courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: ".$this->apiKey,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     echo $response;
        // }

        return $response;

    }

    private function rajaongkir($method, $id_province=null){
        $endpoint = $this->url.$method;
        $curl = curl_init();

        if($id_province!=null){
            $endpoint = $endpoint."?province=".$id_province;
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: ".$this->apiKey
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;

    }
}
?>