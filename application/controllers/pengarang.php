<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengarang extends CI_Controller {

	public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->helper('download');
	$this->load->library('pagination');
	$this->load->helper('cookie');
	$this->load->model('pengarang_model');
  }
	
	public function index()
	{
		$data['title'] = 'Pengarang';
		$data['pengarang'] = $this->pengarang_model->data()->result();

		$this->load->view('templates/header', $data);
		$this->load->view('pengarang/index');
		$this->load->view('templates/footer');
	}

	public function proses_tambah()
	{
		$kode = 	$this->pengarang_model->buat_kode();
		$pengarang = $this->input->post('pengarang');
		$ket = 		$this->input->post('ket');
		
		$data=array(
			'id_pengarang'=>$kode,
			'pengarang'=> $pengarang,
			'keterangan'=>$ket
		);

		$this->pengarang_model->tambah_data($data, 'pengarang');
		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil ditambahkan!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
    	redirect('pengarang');
	}

	public function proses_ubah()
	{
		$kode = 	$this->input->post('id');
		$pengarang = $this->input->post('pengarang');
		$ket = 		$this->input->post('ket');
		
		$data=array(
			'pengarang'=> $pengarang,
			'keterangan'=>$ket
		);

		$where = array(
			'id_pengarang'=>$kode
		);

		$this->pengarang_model->ubah_data($where, $data, 'pengarang');
		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil diubah!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
    	redirect('pengarang');
	}

	public function proses_hapus($id)
	{
		$where = array('id_pengarang' => $id );
		$this->pengarang_model->hapus_data($where, 'pengarang');
		$this->session->set_flashdata('Pesan','
		<script>
		$(document).ready(function() {
			swal.fire({
				title: "Berhasil dihapus!",
				icon: "success",
				confirmButtonColor: "#4e73df",
			});
		});
		</script>
		');
		redirect('pengarang');
	}

	public function getData()
	{
		$id = $this->input->post('id');
    	$where = array('id_pengarang' => $id );
    	$data = $this->pengarang_model->detail_data($where, 'pengarang')->result();
    	echo json_encode($data);
	}
}
