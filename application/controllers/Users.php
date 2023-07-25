<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		$ceks = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']   	 = $this->Mcrud->get_users_by_un($ceks);
			$data['users']  	 = $this->Mcrud->get_users();
			$data['judul_web'] = "Beranda | Aplikasi Surat Menyurat";

			$this->load->view('users/header', $data);
			$this->load->view('users/beranda', $data);
			$this->load->view('users/footer');

		}
	}

	public function profile()
	{
		$ceks = $this->session->userdata('surat_menyurat@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);
			$data['level_users']  = $this->Mcrud->get_level_users();
			$data['judul_web'] 		= "Profile | Aplikasi Surat Menyurat";

					$this->load->view('users/header', $data);
					$this->load->view('users/profile', $data);
					$this->load->view('users/footer');

					if (isset($_POST['btnupdate'])) {
						$nama_lengkap	 	= htmlentities(strip_tags($this->input->post('nama_lengkap')));
						$email	 				= htmlentities(strip_tags($this->input->post('email')));
						$alamat	 				= htmlentities(strip_tags($this->input->post('alamat')));
						$telp	 					= htmlentities(strip_tags($this->input->post('telp')));
						$pengalaman	 	  = htmlentities(strip_tags($this->input->post('pengalaman')));

									$data = array(
										'nama_lengkap'	=> $nama_lengkap,
										'email'					=> $email,
										'alamat'				=> $alamat,
										'telp'					=> $telp,
										'pengalaman'	  => $pengalaman
									);
									$this->Mcrud->update_user(array('username' => $ceks), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Profile berhasil disimpan.
										</div>'
									);
									redirect('users/profile');
					}


					if (isset($_POST['btnupdate2'])) {
						$password 	= htmlentities(strip_tags($this->input->post('password')));
						$password2 	= htmlentities(strip_tags($this->input->post('password2')));

						if ($password != $password2) {
								$this->session->set_flashdata('msg2',
									'
									<div class="alert alert-warning alert-dismissible" role="alert">
										 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
										 </button>
										 <strong>Gagal!</strong> Katasandi tidak cocok.
									</div>'
								);
						}else{
									$data = array(
										'password'	=> md5($password)
									);
									$this->Mcrud->update_user(array('username' => $ceks), $data);

									$this->session->set_flashdata('msg2',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Katasandi berhasil disimpan.
										</div>'
									);
						}
									redirect('users/profile');
					}


		}
	}

	public function pengguna($aksi='', $id='')
	{
		$ceks = $this->session->userdata('surat_menyurat@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);

			if ($data['user']->row()->level == 'kepalasekolah') {
					redirect('404_content');
			}

			$this->db->order_by('id_user', 'DESC');
			$data['level_users']  = $this->Mcrud->get_level_users();

				if ($aksi == 't') {
					$p = "pengguna_tambah";

					$data['judul_web'] 	  = "Tambah Pengguna | Aplikasi Surat Menyurat";
				}elseif ($aksi == 'd') {
					$p = "pengguna_detail";

					$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
					$data['judul_web'] 	  = "Detail Pengguna | Aplikasi Surat Menyurat";
				}elseif ($aksi == 'e') {
					$p = "pengguna_edit";

					$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
					$data['judul_web'] 	  = "Edit Pengguna | Aplikasi Surat Menyurat";
				}elseif ($aksi == 'h') {

					$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
					$data['judul_web'] 	  = "Hapus Pengguna | Aplikasi Surat Menyurat";

					if ($ceks == $data['query']->username) {
						$this->session->set_flashdata('msg',
							'
							<div class="alert alert-warning alert-dismissible" role="alert">
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
								 </button>
								 <strong>Gagal!</strong> Maaf, Anda tidak bisa menghapus Nama Pengguna "'.$ceks.'" ini.
							</div>'
						);
					}else{
						$this->Mcrud->delete_user_by_id($id);
						$this->session->set_flashdata('msg',
							'
							<div class="alert alert-success alert-dismissible" role="alert">
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
								 </button>
								 <strong>Sukses!</strong> Pengguna berhasil dihapus.
							</div>'
						);
					}
					redirect('users/pengguna');
				}else{
					$p = "pengguna";

					$data['judul_web'] 	  = "Pengguna | Aplikasi Surat Menyurat";
				}

					$this->load->view('users/header', $data);
					$this->load->view("users/pengaturan/$p", $data);
					$this->load->view('users/footer');

					date_default_timezone_set('Asia/Jakarta');
					$tgl = date('d-m-Y H:i:s');

					if (isset($_POST['btnsimpan'])) {
						$username   	 	= htmlentities(strip_tags($this->input->post('username')));
						$password	 		  = htmlentities(strip_tags($this->input->post('password')));
						$password2	 		= htmlentities(strip_tags($this->input->post('password2')));
						$level	 				= htmlentities(strip_tags($this->input->post('level')));

						$cek_user = $this->db->get_where("tbl_user", "username = '$username'")->num_rows();
						if ($cek_user != 0) {
								$this->session->set_flashdata('msg',
									'
									<div class="alert alert-warning alert-dismissible" role="alert">
										 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
										 </button>
										 <strong>Gagal!</strong> Nama Pengguna "'.$username.'" Sudah ada.
									</div>'
								);
						}else{
								if ($password != $password2) {
										$this->session->set_flashdata('msg',
											'
											<div class="alert alert-warning alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Gagal!</strong> Katasandi tidak cocok.
											</div>'
										);
								}else{
										$data = array(
											'username'	 	 => $username,
											'nama_lengkap' => $username,
											'password'	 	 => md5($password),
											'email' 			 => '-',
											'alamat' 			 => '-',
											'telp' 				 => '-',
											'pengalaman' 	 => '-',
											'status' 			 => 'aktif',
											'level'			 	 => $level,
											'tgl_daftar' 	 => $tgl
										);
										$this->Mcrud->save_user($data);

										$this->session->set_flashdata('msg',
											'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> Pengguna berhasil ditambahkan.
											</div>'
										);
								}
						}

									redirect('users/pengguna/t');
					}

					if (isset($_POST['btnupdate'])) {
						$nama_lengkap	 	= htmlentities(strip_tags($this->input->post('nama_lengkap')));
						$email	 				= htmlentities(strip_tags($this->input->post('email')));
						$alamat	 				= htmlentities(strip_tags($this->input->post('alamat')));
						$telp	 					= htmlentities(strip_tags($this->input->post('telp')));
						$pengalaman	 	  = htmlentities(strip_tags($this->input->post('pengalaman')));
						$level	 				= htmlentities(strip_tags($this->input->post('level')));

									$data = array(
										'nama_lengkap' => $nama_lengkap,
										'email'				 => $email,
										'alamat'			 => $alamat,
										'telp'				 => $telp,
										'pengalaman'	  => $pengalaman,
										'status' 			 => 'aktif',
										'level'			 	 => $level,
										'tgl_daftar' 	 => $tgl
									);
									$this->Mcrud->update_user(array('id_user' => $id), $data);

									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Pengguna berhasil diupdate.
										</div>'
									);
									redirect('users/pengguna');
					}

		}
	}
public function tambahsm() {

			/*upload file MATERI*/
					$config_file['upload_path']          = FCPATH.'/uploads/suratmasuk';
					$config_file['allowed_types']        = '*';

                    $this->load->library('upload',$config_file);
					$this->upload->initialize($config_file);

                    if (!$this->upload->do_upload('fileupload1'))
                    {
						echo $this->upload->display_errors();
                    }
                    else
                    {
                        $upload_data 		= $this->upload->data();

						$no_surat   	 	= htmlentities(strip_tags($this->input->post('no_surat')));
						$asal_surat  		= htmlentities(strip_tags($this->input->post('asal_surat')));
						$perihal   	 		= htmlentities(strip_tags($this->input->post('perihal')));
						$klasifikasi   	 	= htmlentities(strip_tags($this->input->post('klasifikasi')));
						$tgl_surat   	 	= htmlentities(strip_tags($this->input->post('tgl_surat')));
						$keterangan   	 	= htmlentities(strip_tags($this->input->post('keterangan')));

							$data2 = array(
										'no_surat'			 => $no_surat,
										'asal_surat'			 => $asal_surat,
										'perihal'			 => $perihal,
										'klasifikasi'			 => $klasifikasi,
										'tgl_surat'			 => $this->input->post('tgl_surat'),
										'file_surat'			=> $upload_data['file_name'],
										'keterangan'				 => $keterangan
									);

									$save = $this->db->insert('tbl_sm', $data2);
									redirect('users/get_sm');
                    }
}

//Surat Masuk
public function sm()
{

										 $ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);
										 $data['judul_web'] 	  = "Surat Masuk | Aplikasi Surat Menyurat";
										 $this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/sm_tambah");
					$this->load->view('users/footer');
}


public function editsm($id)
{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');

		$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);
		$data['judul_web'] 	  = "Edit Surat Masuk | Aplikasi Surat Menyurat";
		$data['query'] = $this->db->get_where("tbl_sm", ['id_sm' => $id])->result();

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/sm_edit");
					$this->load->view('users/footer');
}

public function editsmm() {

	$idsm = $this->input->post('id_sm');
			/*upload file MATERI*/
					$config_file['upload_path']          = FCPATH.'/uploads/suratmasuk';
					$config_file['allowed_types']        = '*';

                    $this->load->library('upload',$config_file);
					$this->upload->initialize($config_file);

                    if ($this->upload->do_upload('fileupload1'))
                    {
						
                        $upload_data = $this->upload->data();
						$data3 = array(
										'file_surat'			=> $upload_data['file_name']
									);
									$this->db->set($data3);
									$this->db->where('id_sm', $idsm);
							$save3 =$this->db->update('tbl_sm');
					
                    }
					$no_surat   	 	= htmlentities(strip_tags($this->input->post('no_surat')));
					$asal_surat  = htmlentities(strip_tags($this->input->post('asal_surat')));
					$perihal   	 	= htmlentities(strip_tags($this->input->post('perihal')));
					$klasifikasi   	 	= htmlentities(strip_tags($this->input->post('klasifikasi')));
					$tgl_surat   	 	= htmlentities(strip_tags($this->input->post('tgl_surat')));
					$keterangan   	 	= htmlentities(strip_tags($this->input->post('keterangan')));

							$data2 = array(
										'no_surat'			 => $no_surat,
										'asal_surat'			 => $asal_surat,
										'perihal'			 => $perihal,
										'klasifikasi'			 => $klasifikasi,
										'tgl_surat'			 => $this->input->post('tgl_surat'),
										'file_surat'			=> $upload_data['file_name'],
										'keterangan'				 => $keterangan	
									);

									$this->db->set($data2);
									$this->db->where('id_sm', $idsm);
							$save =$this->db->update('tbl_sm');
							redirect('users/get_sm');
}


public function get_sm()
{
	$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);
										 $data['judul_web'] 	  = "Surat Masuk | Aplikasi Surat Menyurat";
										 $this->db->order_by('tbl_sm.id_sm', 'DESC');
			$data['sm'] 		  = $this->db->get("tbl_sm");
			$data['level_users']  = $this->Mcrud->get_level_users();
										 $this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/sm");
					$this->load->view('users/footer');
}

public function deletesm($id) {
	$this->db->delete('tbl_sm', ["id_sm" => $id]);
	redirect('users/get_sm');
}

// Surat Keluar
public function tambahsk() {

			/*upload file MATERI*/
					$config_file['upload_path']          = FCPATH.'/uploads/suratkeluar';
					$config_file['allowed_types']        = '*';

                    $this->load->library('upload',$config_file);
					$this->upload->initialize($config_file);

                    if (!$this->upload->do_upload('fileupload1'))
                    {
						echo $this->upload->display_errors();
                    }
                    else
                    {
                        $upload_data = $this->upload->data();

						$no_surat   	 	= htmlentities(strip_tags($this->input->post('no_surat')));
						$tujuan_surat  		= htmlentities(strip_tags($this->input->post('tujuan_surat')));
						$perihal   	 		= htmlentities(strip_tags($this->input->post('perihal')));
						$klasifikasi   	 	= htmlentities(strip_tags($this->input->post('klasifikasi')));
						$tgl_surat   	 	= htmlentities(strip_tags($this->input->post('tgl_surat')));
						$keterangan   	 	= htmlentities(strip_tags($this->input->post('keterangan')));

							$data2 = array(
										'no_surat'			 => $no_surat,
										'tujuan_surat'			 => $tujuan_surat,
										'perihal'			 => $perihal,
										'klasifikasi'			 => $klasifikasi,
										'tgl_surat'			 => $this->input->post('tgl_surat'),
										'file_surat'			=> $upload_data['file_name'],
										'keterangan'				 => $keterangan
									);

									$save = $this->db->insert('tbl_sk', $data2);
									redirect('users/get_sk');
                    }
}
public function sk()
{

										 $ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);
										 $data['judul_web'] 	  = "Surat  | Aplikasi Surat Menyurat";
										 $this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/sk_tambah");
					$this->load->view('users/footer');
}


public function editsk($id)
{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');

		$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);
		$data['judul_web'] 	  = "Edit Surat Masuk | Aplikasi Surat Menyurat";
		$data['query'] = $this->db->get_where("tbl_sk", ['id_sk' => $id])->result();

					$this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/sk_edit");
					$this->load->view('users/footer');
}

public function editskk() {

	$idsk = $this->input->post('id_sk');
			/*upload file MATERI*/
					$config_file['upload_path']          = FCPATH.'/uploads/suratkeluar';
					$config_file['allowed_types']        = '*';

                    $this->load->library('upload',$config_file);
					$this->upload->initialize($config_file);

                    if ($this->upload->do_upload('fileupload1'))
                    {
						
                        $upload_data = $this->upload->data();
						$data3 = array(
										'file_surat'			=> $upload_data['file_name']
									);
									$this->db->set($data3);
									$this->db->where('id_sk', $idsk);
							$save3 =$this->db->update('tbl_sk');
					
                    }
					$no_surat  = htmlentities(strip_tags($this->input->post('no_surat')));
					$tujuan_surat  = htmlentities(strip_tags($this->input->post('tujuan_surat')));
					$perihal   	 	= htmlentities(strip_tags($this->input->post('perihal')));
					$klasifikasi   	 	= htmlentities(strip_tags($this->input->post('klasifikasi')));
					$tgl_surat   	 	= htmlentities(strip_tags($this->input->post('tgl_surat')));
					$keterangan   	 	= htmlentities(strip_tags($this->input->post('keterangan')));

							$data2 = array(
										'no_surat'			 => $no_surat,
										'tujuan_surat'			 => $tujuan_surat,
										'perihal'			 => $perihal,
										'klasifikasi'			 => $klasifikasi,
										'tgl_surat'			 => $this->input->post('tgl_surat'),
										'file_surat'			=> $upload_data['file_name'],
										'keterangan'				 => $keterangan
									);

									$this->db->set($data2);
									$this->db->where('id_sk', $idsk);
							$save =$this->db->update('tbl_sk');
							redirect('users/get_sk');
}


public function get_sk()
{
	$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		$id_user = $this->session->userdata('id_user@Proyek-2017');
		$data['user']  			  = $this->Mcrud->get_users_by_un($ceks);
										 $data['judul_web'] 	  = "Surat Masuk | Aplikasi Surat Menyurat";
										 $this->db->order_by('tbl_sk.id_sk', 'DESC');
			$data['sk'] 		  = $this->db->get("tbl_sk");
										 $this->load->view('users/header', $data);
					$this->load->view("users/pemrosesan/sk");
					$this->load->view('users/footer');
}

public function deletesk($id) {
	$this->db->delete('tbl_sk', ["id_sk" => $id]);
	redirect('users/get_sk');
}


	public function lap_sk()
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			    = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web']			= "Laporan Surat Keluar | Aplikasi Surat Menyurat";

					$this->load->view('users/header', $data);
					$this->load->view('users/laporan/lap_sk', $data);
					$this->load->view('users/footer');

					if (isset($_POST['data_lap'])) {
						$tgl1 	= date('Y-m-d', strtotime(htmlentities(strip_tags($this->input->post('tgl1')))));
						$tgl2 	= date('Y-m-d', strtotime(htmlentities(strip_tags($this->input->post('tgl2')))));

						redirect("users/data_sk/$tgl1/$tgl2");
					}
		}

	}

		public function data_sk($tgl1='',$tgl2='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
			if(!isset($ceks)) {
				redirect('web/login');
			}else{

						if ($tgl1 != '' AND $tgl2 != '') {
								$data['sql'] = $this->db->query("SELECT * FROM tbl_sk WHERE (tgl_surat BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sk DESC");

								$data['user']  		 = $this->Mcrud->get_users_by_un($ceks);
								$data['judul_web'] = "Data Laporan Surat Keluar | Aplikasi Surat Menyurat";
								$this->load->view('users/header', $data);
								$this->load->view('users/laporan/data_sk', $data);
								$this->load->view('users/footer', $data);

								if (isset($_POST['btncetak'])) {
									redirect("users/cetaksk/$tgl1/$tgl2");
								}

						}else{
								redirect('404_content');
						}

			}
	}
		public function cetaksk($tgl1='',$tgl2='')
	{
			$data['sql'] = $this->db->query("SELECT * FROM tbl_sk WHERE (tgl_surat BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sk DESC");
		$this->load->view('users/laporan/cetak_sk', $data);
	}




		public function lap_sm()
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
			$data['user']  			    = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web']			= "Laporan Surat Masuk | Aplikasi Surat Menyurat";

					$this->load->view('users/header', $data);
					$this->load->view('users/laporan/lap_sm', $data);
					$this->load->view('users/footer');

					if (isset($_POST['data_lap'])) {
						$tgl1 	= date('Y-m-d', strtotime(htmlentities(strip_tags($this->input->post('tgl1')))));
						$tgl2 	= date('Y-m-d', strtotime(htmlentities(strip_tags($this->input->post('tgl2')))));

						redirect("users/data_sm/$tgl1/$tgl2");
					}
		}

	}
	public function data_sm($tgl1='',$tgl2='')
	{
		$ceks 	 = $this->session->userdata('surat_menyurat@Proyek-2017');
			if(!isset($ceks)) {
				redirect('web/login');
			}else{

						if ($tgl1 != '' AND $tgl2 != '') {
								$data['sql'] = $this->db->query("SELECT * FROM tbl_sm WHERE (tgl_surat BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sm DESC");

								$data['user']  		 = $this->Mcrud->get_users_by_un($ceks);
								$data['judul_web'] = "Data Laporan Surat Masuk | Aplikasi Surat Menyurat";
								$this->load->view('users/header', $data);
								$this->load->view('users/laporan/data_sm', $data);
								$this->load->view('users/footer', $data);

								if (isset($_POST['btncetak'])) {
									redirect("users/cetaksm/$tgl1/$tgl2");
								}

						}else{
								redirect('404_content');
						}

			}
	}

	public function cetaksm($tgl1='',$tgl2='')
	{
			$data['sql'] = $this->db->query("SELECT * FROM tbl_sm WHERE (tgl_surat BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sm DESC");
		$this->load->view('users/laporan/cetak_sm', $data);
	}


}
