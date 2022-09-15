<?php

//URL DESIGN :
//localhost/api-native/api.php?function=getUser
require_once "koneksi.php";

//pemanggilan function tertentu
if(function_exists($_GET['function'])){
    $_GET['function']();
}

//Get Data Users
//URL DESIGN Get Users;
//localhost/api-native/api.php?function=getUsers
function getUsers(){

    // Permintaan ke  server
    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object($query)){
        $users[] = $data;
    }

    // Menghasilkan response server
    $respon = array(
        'status'    => 1,
        'message'   => 'Success get users',
        'users'     => $users
    );

    header('Content-Type: application/json');
    print json_encode($respon);
}

//Insert Data User
//URL DESIGN Update Data User:
//localhost/api-native/api.php?function=updateUsers&id={id}
function addUser(){
    //echo "ini function addUser";
    global $koneksi;

    $parameter = array(
        'nama'   => '',
        'alamat' => ''
    );

    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){

        $nama   = $_POST ['nama'];
        $alamat = $_POST ['alamat'];

        $result = mysqli_query($koneksi, "INSERT INTO users VALUES('', '$nama', '$alamat')");

        if($result){
            $respon = array(
                'status'  => 1,
                'message' => 'Insert data success'
            );
        }else{
            $respon = array(
                'status'  => 0,
                'message' => 'Insert data failed'
            );
        }

    }else{
        $respon = array(
            'status'  => 0,
            'message' => 'Parameter salah'
        );
    }

    //Menampolkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);

}

function message($status, $msg){

    $respon = array(
            'status'    => $status,
            'message'   => $msg
    );

    // Menampilkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);
}

//Update Data User
//URL DESIGN Update Data User:
//localhost/api-native/api.php?function=updateUsers&id={id}
function updateUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $parameter = array(
        'nama'   => "",
        'alamat' => ""
    );

    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){

        $nama   = $_POST['nama'];
        $alamat = $_POST['alamat'];

        $result = mysqli_query($koneksi, "UPDATE users SET nama='$nama', alamat='$alamat' WHERE id='$id'");

        if($result){
            return message(1, "Update data $nama success");
        }else{
            return message(0, "Update data failed");
        }

    }else{
        return message(0, "Parameter Salah");
    }

}

//Delete Data User
//URL DESIGN Update Data User:
//localhost/api-native/api.php?function=deleteUser&id={id}
function deleteUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    if($result){
        return message(1, "DELETE data success");
    }else{
        return message(0, "DELETE data failed");
    }

}

//Delete Data User per id
//URL DESIGN Update Data User:
//localhost/api-native/api.php?function=detailUserId&id={id}
function detailUserId(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }
    
    $result = $koneksi->query("SELECT * FROM users WHERE id='$id'");

    while($data = mysqli_fetch_object($result)){
        $detailUser[] = $data;
    }
    if($detailUser){
        $respon = array(
            'status'    =>1,
            'message'   => "Berhasil mendapatkan data detail user",
            'user'      => $detailUser
        );
    }else{
        return message(0, "Data tidak ditemukan");
    }

    //Menampilkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);
}
?>
