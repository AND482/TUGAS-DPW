<?php
echo $action = $_REQUEST['action'];

parse_str($_REQUEST['dataku'], $hasil);  
echo "Name: ".$hasil['namalengkap']."<br/>";
echo "Nick Name: ".$hasil['namapanggilan']."<br/>";
echo "Username: ".$hasil['username']."<br/>";

//$hasil = $_REQUEST;

/* SQL: select, update, delete */

if($action == 'create')
	$syntaxsql = "insert into pendaftaran values (null,'$hasil[namalengkap]','$hasil[namapanggilan]', '$hasil[stanbuk]', '$hasil[username]', 
	'$hasil[email]', '$hasil[jurusan]', '$hasil[state]', '$hasil[prodi]', '$hasil[gender]', '$hasil[phonenumber]', '$hasil[address]', '$hasil[alasan]',now())";
elseif($action == 'update')
	$syntaxsql = "update tabel_pendaftaran set Nama_Lengkap = '$hasil[namalengkap]', Nama_Panggilan = '$hasil[namapanggilan]', NIM = '$hasil[stanbuk]', 
	Username = '$hasil[username]', Email ='$hasil[email]', Jurusan = '$hasil[jurusan]', Jenjang_Pendidikan = '$hasil[state]', Program_Studi = '$hasil[prodi]', 
	Jenis_Kelamin = '$hasil[gender]', Nomor_Telpon = '$hasil[phonenumber]', Alamat = '$hasil[address]', Alasan_Daftar'$hasil[alasan]'";
elseif($action == 'delete')
	$syntaxsql = "delete from pendaftaran where username = '$hasil[username]'";
elseif($action == 'read')
	$syntaxsql = "select * from pendaftaran";
	
//eksekusi syntaxsql 
$conn = new mysqli("localhost","root","04AGUSTUS2000","FORMPENDAFTARAN"); //dbhost, dbuser, dbpass, dbname
if ($conn->connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}else{
  echo "Database connected. ";
}
//create, update, delete query($syntaxsql) -> true false
if ($conn->query($syntaxsql) === TRUE) {
	echo "Query $action with syntax $syntaxsql suceeded !";
}
elseif ($conn->query($syntaxsql) === FALSE){
	echo "Error: $syntaxsql" .$conn->error;
}
//khusus read query($syntaxsql) -> semua associated array
else{
	$result = $conn->query($syntaxsql); //bukan true false tapi data array asossiasi
	if($result->num_rows > 0){
		echo "<table id='tresult' class='table table-striped table-bordered'>";
		echo "<thead><th>Nama_Lengkap</th><th>Nama_Panggilan</th><th>NIM</th><th>Username</th><th>Email</th><th>Jurusan</th><th>Jenjang_Pendidikan</th> 
		<th>program_Studi</th><th>Jenis_Kelamin</th><th>Nomor_Telpon</th><th>Alamat</th><th>Alasan_Daftar</th></thead>";
		echo "<tbody>";
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>".$row['Nama_Lengkap']."</td><td>". $row['Nama_Panggilan']."</td><td>". $row['NIM']."</td><td>". $row['Username']."</td>
			<td>". $row['Email']."</td><td>". $row['Jurusan']."</td><td>". $row['Jenjang_Pendidikan']."</td><td>". $row['Program_Studi']."</td>
			<td>". $row['Jenis_Kelamin']."</td><td>". $row['Nomor_Telpon']."</td><td>". $row['Alamat']."</td><td>". $row['Alasan_Daftar']."</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
}
$conn->close();

?>