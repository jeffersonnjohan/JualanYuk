<?php 
session_start();

require '../functions.php';
$categories = query("SELECT * FROM category");

// Cek apakah current user sudah ada
if(isset($_SESSION["currentUserId"])){
    // Jika masuk memlalui login,
    $currentUserData = detailUser($_SESSION["currentUserId"]);
    $currentUsername = $currentUserData["username"];
} else{
    // Jika masuk melalui url
    $currentUsername = "YOUR NAME";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stok</title>
    <link rel="stylesheet" href="../header/header.css">
    <link rel="stylesheet" href="../editProduk/editProduk.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="addStok.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="addStok.js"></script>
</head>
<body>
    <!-- header -->
    <div class="container">
        <!-- logo -->
        <a href="../home/home.php">
            <div class="logo" style="background-image: url(../image/logo.svg) ;"></div>
        </a>

        <!-- akun -->
        <div class="namaAkun"><?= $currentUsername ?></div>

        <!-- kotak logo -->
        <div class="kotakLogo">
            <div class="keranjang">
                <a href="../keranjang/keranjang.php?id=<?=$_SESSION["currentUserId"]?>">
                <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 2.53125C0 2.30747 0.0888949 2.09286 0.247129 1.93463C0.405362 1.77639 0.619974 1.6875 0.84375 1.6875H3.375C3.56321 1.68755 3.746 1.75053 3.8943 1.86642C4.0426 1.9823 4.14789 2.14445 4.19344 2.32706L4.87688 5.0625H24.4688C24.5926 5.06261 24.715 5.09001 24.8271 5.14274C24.9392 5.19547 25.0383 5.27225 25.1174 5.36761C25.1965 5.46297 25.2536 5.57457 25.2847 5.6945C25.3158 5.81442 25.3201 5.93972 25.2973 6.0615L22.7661 19.5615C22.7299 19.7549 22.6273 19.9295 22.476 20.0552C22.3247 20.1809 22.1342 20.2498 21.9375 20.25H6.75C6.55329 20.2498 6.36283 20.1809 6.21154 20.0552C6.06024 19.9295 5.95763 19.7549 5.92144 19.5615L3.39188 6.08681L2.71688 3.375H0.84375C0.619974 3.375 0.405362 3.28611 0.247129 3.12787C0.0888949 2.96964 0 2.75503 0 2.53125ZM5.23462 6.75L7.45031 18.5625H21.2372L23.4529 6.75H5.23462ZM8.4375 20.25C7.54239 20.25 6.68395 20.6056 6.05101 21.2385C5.41808 21.8715 5.0625 22.7299 5.0625 23.625C5.0625 24.5201 5.41808 25.3785 6.05101 26.0115C6.68395 26.6444 7.54239 27 8.4375 27C9.33261 27 10.1911 26.6444 10.824 26.0115C11.4569 25.3785 11.8125 24.5201 11.8125 23.625C11.8125 22.7299 11.4569 21.8715 10.824 21.2385C10.1911 20.6056 9.33261 20.25 8.4375 20.25ZM20.25 20.25C19.3549 20.25 18.4965 20.6056 17.8635 21.2385C17.2306 21.8715 16.875 22.7299 16.875 23.625C16.875 24.5201 17.2306 25.3785 17.8635 26.0115C18.4965 26.6444 19.3549 27 20.25 27C21.1451 27 22.0035 26.6444 22.6365 26.0115C23.2694 25.3785 23.625 24.5201 23.625 23.625C23.625 22.7299 23.2694 21.8715 22.6365 21.2385C22.0035 20.6056 21.1451 20.25 20.25 20.25ZM8.4375 21.9375C8.88505 21.9375 9.31427 22.1153 9.63074 22.4318C9.94721 22.7482 10.125 23.1774 10.125 23.625C10.125 24.0726 9.94721 24.5018 9.63074 24.8182C9.31427 25.1347 8.88505 25.3125 8.4375 25.3125C7.98995 25.3125 7.56073 25.1347 7.24426 24.8182C6.92779 24.5018 6.75 24.0726 6.75 23.625C6.75 23.1774 6.92779 22.7482 7.24426 22.4318C7.56073 22.1153 7.98995 21.9375 8.4375 21.9375ZM20.25 21.9375C20.6976 21.9375 21.1268 22.1153 21.4432 22.4318C21.7597 22.7482 21.9375 23.1774 21.9375 23.625C21.9375 24.0726 21.7597 24.5018 21.4432 24.8182C21.1268 25.1347 20.6976 25.3125 20.25 25.3125C19.8024 25.3125 19.3732 25.1347 19.0568 24.8182C18.7403 24.5018 18.5625 24.0726 18.5625 23.625C18.5625 23.1774 18.7403 22.7482 19.0568 22.4318C19.3732 22.1153 19.8024 21.9375 20.25 21.9375Z" fill="white"/>
                </svg>
                </a>               
            </div>
            <div class="logOut">
                <a href="../logout.php">
                    <svg width="20" height="24" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.66667 23.3333H11.6667C12.1086 23.3329 12.5322 23.1572 12.8447 22.8447C13.1572 22.5322 13.3329 22.1086 13.3333 21.6667V19.1667H11.6667V21.6667H1.66667V1.66667H11.6667V4.16667H13.3333V1.66667C13.3329 1.22477 13.1572 0.801108 12.8447 0.488643C12.5322 0.176178 12.1086 0.000441231 11.6667 0H1.66667C1.22477 0.000441231 0.801108 0.176178 0.488643 0.488643C0.176178 0.801108 0.000441231 1.22477 0 1.66667V21.6667C0.000441231 22.1086 0.176178 22.5322 0.488643 22.8447C0.801108 23.1572 1.22477 23.3329 1.66667 23.3333Z" fill="white"/>
                        <path d="M13.8217 15.4884L16.81 12.5001H5V10.8334H16.81L13.8217 7.84508L15 6.66675L20 11.6667L15 16.6667L13.8217 15.4884Z" fill="white"/>
                    </svg>                                     
                </a>                             
            </div>
        </div>
    </div>

    <!-- body -->
    <div class="main">
        <form action="../insertItem.php" method="post" enctype="multipart/form-data" id="form">
        <div class="gambarProduk" style="background-image:url(../image/plus.png) ;">
                <input type="file" name="gambar" id="addPhoto" class="addPhoto" onchange="readURL(this);">
        </div>
            <div class="bawahProduk">
                <div class="deskripsiKiri">
                    <div class="namaProduk">
                        <p>TAMBAH PRODUK</p>
                    </div>
                    <div class="deskripsiProduk">
                        <div class="edit">
                            <div class="nama">
                                <p class="judulEdit">Nama Produk:</p>
                                <input type="text" autocomplete="off" name="nama" class="isiEdit">
                            </div>
                            <div class="qtyPerPcs">
                                <p class="judulEdit">Qty (Pcs):</p>
                                <input type="text" autocomplete="off" name="qtyPerPcs" class="isiEdit">
                            </div>
                            <div class="harga">
                                <p class="judulEdit">Harga:</p>
                                <input type="text" autocomplete="off" name="harga" class="isiEdit">
                            </div>
                            <div class="stok">
                                <p class="judulEdit">Stok:</p>
                                <input type="text" autocomplete="off" name="stok" class="isiEdit">
                            </div>
                            <div class="kategoriProduk">
                                <p class="judulEdit">Kategori:</p>
                                    <select name="kategori" class="optionKategori">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach($categories as $category): ?>
                                            <option value="<?=$category['categoryId']?>"><?=$category['categoryName']?></option>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                        <div class="tulisanDeskripsi">
                            Deskripsi Barang:
                        </div>
                        <div class="isiDeskripsi">
                                <textarea name="deskripsi" id="isiEdit2" class="isiEdit2" cols="100" rows="200"></textarea>
                        </div>
                    </div>
                </div>
                <div class="deskripsiKanan">
                    <div class="tulisanKeranjang" id="buttonSimpan">SIMPAN</div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!-- footer -->
    <?php include '../footer/footer.php' ?>

    <script src="../addStok/addStok.js"></script>
</body>
</html>