<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>



<?php
include "../configurasi/koneksi.php";
include "../configurasi/library.php";
include "../configurasi/fungsi_indotgl.php";
include "../configurasi/fungsi_combobox.php";
include "../configurasi/class_paging.php";

$aksi_kelas="modul/mod_kelas/aksi_kelas.php";
$aksi_mapel="modul/mod_matapelajaran/aksi_matapelajaran.php";

// Bagian Home
if ($_GET['module']=='home'){
  if ($_SESSION['leveluser']=='admin'){
	?>
	  <!-- Small boxes (Stat box) -->
	
		<div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-tag"></i> Quick Links</h3>
        </div>	
	   <div class="box-body">
			<div class="row">
				<div class="callout callout-danger "  style="margin:20px 20px 20px 20px">
					<h4><?php echo "Hai $_SESSION[namalengkap]"; ?></h4>
					<p><?php echo "Selamat datang di halaman Administrator E-learning STMIK INSAN PEMBANGUNAN
						Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website"; ?>
					</p>
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
				  <div class="small-box bg-aqua">
						<div class="inner">
							<?php $siswa = mysql_num_rows(mysql_query("SELECT * FROM siswa")); ?>
							<h3><?php echo $siswa; ?></h3>
							<p>Data Mahasiwa </p>
						</div>
						<div class="icon">
							<i class="fa fa-graduation-cap"></i>
						</div>
						<a href="#" class="small-box-footer">Klik disini <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
							<?php $kelas = mysql_num_rows(mysql_query("SELECT * FROM kelas")); ?>
							<h3><?php echo $kelas; ?></h3>
							<p>Kelas</p>
						</div>
						<div class="icon">
							<i class="fa fa-group"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<?php $kriteria = mysql_num_rows(mysql_query("SELECT * FROM tbl_kriteria")); ?>
							<h3><?php echo $kriteria; ?></h3>
							<p>Kriteria</p>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="#" class="small-box-footer">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div><!-- ./col -->
				
		</div>
	 
  <?php
  echo "<p align=right>Login : $hari_ini,
  <span id='date'></span>, <span id='clock'></span></p>
  </div>
 
 ";
  
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
  echo "<p>Hai <b>$_SESSION[namalengkap]</b>,  selamat datang di halaman Dosen.<br>
          Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website.</p><br>";
		  if($_GET['message']=='success'){
			echo "<div class='success msg'>Data Tersimpan, Terimakasih Telah Melakukan Absensi Untuk Mata Kuliah ini <br>
				--Terima Kasih -- <i>IT LP3I Tasikmalaya </i>
			</div>";
			}
          echo "<p align=right>Login : $hari_ini,
                <span id='date'></span>, <span id='clock'></span></p>";
          //detail pengajar
          $detail_pengajar=mysql_query("SELECT * FROM pengajar WHERE id_pengajar='$_SESSION[idpengajar]'");
          $p=mysql_fetch_array($detail_pengajar);
          $tgl_lahir   = tgl_indo($p[tgl_lahir]);
          echo "<form><fieldset>
              <legend>Detail Profil Anda</legend>
              <dl class='inline'>
          <table id='table1' class='gtable sortable'>
          <tr><td rowspan='14'>";if ($p[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_pengajar/medium_$p[foto]'>
                    <div class='links'>
                    <a href='../foto_pengajar/medium_$p[foto]' rel='facebox'>View</a>
                    <div>
                    </li>
                    </ul>";
          }echo "</td><td>Kode Dosen</td>  <td> : $p[kodedosen]</td><tr>
          <tr><td>Nama Lengkap</td> <td> : $p[nama_lengkap]</td></tr>
          <tr><td>Username</td>     <td> : $p[username_login]</td></tr>
          <tr><td>Alamat</td>       <td> : $p[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $p[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($p[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>        <td> : $p[agama]</td></tr>
          <tr><td>No.Telp/HP</td>   <td> : $p[no_telp]</td></tr>
          <tr><td>E-mail</td>       <td> : $p[email]</td></tr>
          <tr><td>Website</td>      <td> : <a href=http://$p[website] target=_blank>$p[website]</a></td></tr>       
          <tr><td>Jabatan</td>      <td> : $p[jabatan]</td></tr>
          <tr><td>Aksi</td>         <td> : <input class='button small white' type=button value='Edit Profil' onclick=\"window.location.href='?module=admin&act=editpengajar';\"></td></tr>
          </table></dl></fieldset></form>";
		  $cekpa = mysql_fetch_array(mysql_query("SELECT id_pengajar FROM Kelas WHERE id_pengajar='$_SESSION[idpengajar]'"));
		  if(empty($cekpa)){
			  
		  }else{
         //kelas yang diampu
         echo"<form><fieldset>
              <legend>Kelas Yang anda ampu</legend>
              <dl class='inline'>";
         // <input class='button small blue' type=button value='Tambah' onclick=\"window.location.href='?module=kelas&act=tambahkelas';\">";
         
         $tampil_kelas = mysql_query("SELECT * FROM kelas WHERE id_pengajar = '$_SESSION[idpengajar]'");
         $ketemu=mysql_num_rows($tampil_kelas);
         if (!empty($ketemu)){
                echo "<br><br><table id='table1' class='gtable sortable'><thead>
                <tr><th>No</th><th>Kelas</th><th>Pembimbing Akademik</th><th>Ketua Kelas</th><th>Aksi</th></tr></thead>";

                $no=1;
                while ($r=mysql_fetch_array($tampil_kelas)){
                    echo "<tr><td>$no</td>                    
                    <td>$r[nama]</td>";

                    $pengajar = mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$_SESSION[idpengajar]'");
                    $ada_pengajar = mysql_num_rows($pengajar);
                    if(!empty($ada_pengajar)){
                    while($p=mysql_fetch_array($pengajar)){
                            echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Wali Kelas'>$p[nama_lengkap]</a></td>";
                    }
                    }else{
                            echo "<td></td>";
                    }

                    $siswa = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$r[id_siswa]'");
                    $ada_siswa = mysql_num_rows($siswa);
                    if(!empty($ada_siswa)){
                    while ($s=mysql_fetch_array($siswa)){
                            echo"<td><a href=?module=siswa&act=detailsiswa&id=$s[id_siswa] title='Detail Siswa'>$s[nama_lengkap]</td>";
                     }
                    }else{
                            echo"<td></td>";
                    }
                    echo "
					<td>
                    <input class='button small white' type=button value='Lihat Siswa' onclick=\"window.location.href='?module=siswa&act=lihatmurid&id=$r[id_kelas]';\"> 
					 <a href='?module=absensi&act=laporanpa&id=$r[id_kelas]' class='button red' >Laporan PA</a>
                    </td>
					";
                $no++;
                }
                echo "</table></dl></fieldset></form>";
                }else{
                    echo"<br><br>Tidak ada kelas yang anda ampu";
                }
		  }
   //mata pelajaran
   $tanggal = gmdate("Y-m-d ",time()+60*60*7);
   $cek_jadwaltambahan = mysql_num_rows(mysql_query("SELECT * FROM V_jadwaltambahan WHERE id_pengajar='$_SESSION[idpengajar]' and tanggalt='$tanggal'"));
   $tampil_matkul = mysql_query("SELECT * FROM V_jadwaltambahan WHERE id_pengajar='$_SESSION[idpengajar]' and tanggalt='$tanggal'");

  if($cek_jadwaltambahan != 0){
   echo "<div class='information msg'>Hari ini Anda Memiliki $cek_jadwaltambahan Jadwal Tambahan Untuk Matakuliah <font color='green'>( "; 
   ?>
   
   <?php
   while ($matkul=mysql_fetch_array($tampil_matkul)){
	   echo "$matkul[nama] ($matkul[nama_kelas]), ";
   }
   
   echo")</font><br><font color='red'>.::Abaikan Jika Anda Sudah Melakukan Absensi Jadwal Tambahan Untuk Mata Kuliah Tersebut::.</font> <br>
				<i>--Terima Kasih -- IT LP3I Tasikmalaya </i>
			</div>";
  }
   echo"<form><fieldset>
              <legend>Mata Kuliah Yang Anda Ampu</legend>
              <dl class='inline'>";
			  
   //<input type=button class='button small blue' value='Tambah' onclick=\"window.location.href='?module=matapelajaran&act=tambahmatapelajaran';\">";
   
  $tampil_pelajaran = mysql_query("SELECT * FROM mata_kuliah WHERE id_pengajar = '$_SESSION[idpengajar]'");
  $cek_mapel = mysql_num_rows($tampil_pelajaran);
  if (!empty($cek_mapel)){
    echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Hari</th><th>Jam</th><th>Nama</th><th>Kelas</th><th>Dosen</th><th>Deskripsi</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysql_fetch_array($tampil_pelajaran)){
       echo "<tr><td>$no</td> 
			 <td>$r[Hari]</td>
			 <td>$r[Jam]</td>			 
             <td>$r[nama]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek = mysql_num_rows($kelas);
             if(!empty($cek)){
             while($k=mysql_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pengajar = mysql_query("SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysql_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysql_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td>
             <td><a href='?module=absensi&id=$r[id]' title='Absensi'>Absensi</a> |
             <a href='?module=absensi&act=tambahabsensi&id=$r[id]' title='Tambahan'>Tambahan</a> | 
			 <a href='?module=absensi&act=pilihprttgl&id=$r[kodematkul]' title='Edit Absen' >Edit Absensi</a>";
      $no++;
    }
    echo "</table></dl></fieldset></form>";
  }else{
      echo"<br><br>Tidak Ada Mata Pelajaran Yang Di Ampu";
  }

		echo"
                <p>&nbsp;</p>";
 	}
        else{
             echo "<h2>Home</h2>
          <p>Hai <b>$_SESSION[namalengkap]</b>, selamat datang di E-Learning.</p>
          <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
          <p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d"));
  echo " | ";
  echo date("H:i:s");
  echo " WIB</p>";
        }
}
// Bagian Modul
elseif ($_GET['module']=='modul'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_modul/modul.php";
  }
}
// Bagian user admin
elseif ($_GET['module']=='admin'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_admin/admin.php";
  }else{
      include "modul/mod_admin/admin.php";
  }
}

// Bagian user admin
elseif ($_GET['module']=='detailpengajar'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_admin/admin.php";
  }else{
      include "modul/mod_admin/admin.php";
  }
}

// Bagian kelas
elseif ($_GET['module']=='kelas'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_kelas/kelas.php";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_kelas/kelas.php";
  }
  elseif ($_SESSION['leveluser']=='siswa'){
      include "modul/mod_kelas/kelas.php";
  }

}


// Bagian siswa
elseif ($_GET['module']=='siswa'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_siswa/siswa.php";
  }else{
      include "modul/mod_siswa/siswa.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='daftarsiswa'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_siswa/siswa.php";
  }else{
      include "modul/mod_siswa/siswa.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='detailsiswa'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_siswa/siswa.php";
  }else{
      include "modul/mod_siswa/siswa.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='detailsiswapengajar'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_siswa/siswa.php";
  }else{
      include "modul/mod_siswa/siswa.php";
  }
}

// Bagian mata pelajaran
elseif ($_GET['module']=='matapelajaran'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_matapelajaran/matapelajaran.php";
  }
  else{
      include "modul/mod_matapelajaran/matapelajaran.php";
  }
}
// Bagian mata pelajaran
elseif ($_GET['module']=='ujian'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_ujian/ujian.php";
  }
  else{
      include "modul/mod_matapelajaran/matapelajaran.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='materi'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_materi/materi.php";
  }else{
      include "modul/mod_materi/materi.php";
  }
}
// Bagian absen
elseif ($_GET['module']=='absensi'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_absen/absen.php";
  }else{
      include "modul/mod_absen/absen.php";
  }
}
// Bagian Jadwal Tambahan
elseif ($_GET['module']=='tambahan'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_tambahan/tambahan.php";
  }else{
      include "modul/mod_tambahan/tambahan.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='quiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquizesay'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquizpilganda'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquizesay'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquizpilganda'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian Templates
elseif ($_GET['module']=='templates'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_templates/templates.php";
  }
}

// Bagian Templates
elseif ($_GET['module']=='registrasi'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_registrasi/registrasi.php";
  }
}
?>
