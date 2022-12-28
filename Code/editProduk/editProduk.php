<?php 
session_start();
require '../functions.php';

// Cek apakah current user sudah ada
if(isset($_SESSION["currentUserId"])){
    // Jika masuk memlalui login,
    $currentUserData = detailUser($_SESSION["currentUserId"]);
    $currentUsername = $currentUserData["username"];

    // Jika dia bukan admin, langsung lempar
    if($currentUsername != 'admin'){
        header("Location: ../editStok/editStok.php");
    }
} else{
    // Jika masuk melalui url, lempar ke home
    header("Location: ../editStok/editStok.php");
}

// Cek apakah produk yang dipilih sudah ada
if(isset($_GET["id"])){
    $itemId = $_GET["id"];
    $item = query("SELECT * FROM item WHERE itemId = $itemId")[0];
    $itemCategory = query("SELECT c.categoryName FROM category c JOIN item i ON i.categoryId = c.categoryId WHERE i.itemId=$itemId")[0]['categoryName'];
    $categories = query("SELECT * FROM category");
} else{
    // Kalau belum ada produk yang dipilih
    redirectTo('../home/home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../header/header.css">
    <link rel="stylesheet" href="editProduk.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
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
        <div class="gambarProduk" style="background-image:url(../image/Produk/<?=$item['itemImage']?>) ;"></div>
            <div class="bawahProduk">
                <div class="deskripsiKiri">
                    <div class="namaProduk">
                        <p>EDIT PRODUK</p>
                    </div>
                    <form action="../edit.php" method="post" id="buttonSave">
                    <input type="hidden" name="id" value="<?=$itemId?>">
                    <div class="deskripsiProduk">
                        <div class="edit">
                                <div class="nama">
                                    <p class="judulEdit">Nama Produk:</p>
                                        <input type="text" name="nama" class="isiEdit" value="<?=$item["itemName"]?>">
                                </div>
                                <div class="qtyPerPcs">
                                    <p class="judulEdit">Qty (Pcs):</p>
                                        <input type="text" name="qtyPerPcs" class="isiEdit" value="<?=$item["qtyPerItem"]?>">
                                </div>
                                <div class="harga">
                                    <p class="judulEdit">Harga:</p>
                                        <input type="text" name="harga" class="isiEdit" value="<?=$item["buyPrice"]?>">
                                </div>
                                <div class="stok">
                                    <p class="judulEdit">Stok:</p>
                                        <input type="text" name="stok" class="isiEdit" value="<?=$item["itemStock"]?>">
                                </div>
                                <div class="kategoriProduk">
                                    <p class="judulEdit">Kategori:</p>
                                        <select name="kategori" class="optionKategori">
                                            <option value="">Pilih Kategori</option>
                                            <?php foreach($categories as $category): ?>
                                                <!-- Kalau category nya sesuai dengan category barang, maka otomatis selected -->
                                                <?php if($category['categoryName'] == $itemCategory):?>
                                                    <option value="<?=$category["categoryId"]?>" selected><?=$category["categoryName"]?></option>
                                                <?php else: ?>
                                                    <option value="<?=$category["categoryId"]?>"><?=$category["categoryName"]?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                        </div>
                        <div class="tulisanDeskripsi">Deskripsi:</div>
                        <div class="isiDeskripsi">
                                <textarea name="deskripsi" id="isiEdit2" class="isiEdit2" cols="100" rows="200">
<?=$item["itemDescription"]?>
                                </textarea>
                            
                        </div>
                    </div>
                    </form>
                </div>
                <div class="kotakSampah">
                    <a href="../delete.php?id=<?=$itemId?>" onclick="confirm('yakin?')">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27.1399 34H8.85988C8.47507 33.9909 8.09583 33.9061 7.74381 33.7504C7.39179 33.5947 7.07391 33.3711 6.80831 33.0925C6.54271 32.8139 6.33461 32.4857 6.1959 32.1267C6.05718 31.7676 5.99058 31.3848 5.99988 31V11.23H7.99988V31C7.99033 31.1222 8.00504 31.2451 8.04315 31.3616C8.08126 31.4781 8.14202 31.5859 8.22194 31.6788C8.30186 31.7717 8.39937 31.848 8.50885 31.9031C8.61833 31.9582 8.73763 31.9911 8.85988 32H27.1399C27.2621 31.9911 27.3814 31.9582 27.4909 31.9031C27.6004 31.848 27.6979 31.7717 27.7778 31.6788C27.8577 31.5859 27.9185 31.4781 27.9566 31.3616C27.9947 31.2451 28.0094 31.1222 27.9999 31V11.23H29.9999V31C30.0092 31.3848 29.9426 31.7676 29.8039 32.1267C29.6651 32.4857 29.457 32.8139 29.1915 33.0925C28.9259 33.3711 28.608 33.5947 28.2559 33.7504C27.9039 33.9061 27.5247 33.9909 27.1399 34Z" fill="white"/>
                        <path d="M30.78 9H5C4.73478 9 4.48043 8.89464 4.29289 8.70711C4.10536 8.51957 4 8.26522 4 8C4 7.73478 4.10536 7.48043 4.29289 7.29289C4.48043 7.10536 4.73478 7 5 7H30.78C31.0452 7 31.2996 7.10536 31.4871 7.29289C31.6746 7.48043 31.78 7.73478 31.78 8C31.78 8.26522 31.6746 8.51957 31.4871 8.70711C31.2996 8.89464 31.0452 9 30.78 9Z" fill="white"/>
                        <path d="M21 13H23V28H21V13Z" fill="white"/>
                        <path d="M13 13H15V28H13V13Z" fill="white"/>
                        <path d="M23 5.86H21.1V4H14.9V5.86H13V4C12.9994 3.48645 13.1963 2.99233 13.55 2.62C13.9037 2.24767 14.3871 2.02568 14.9 2H21.1C21.6129 2.02568 22.0963 2.24767 22.45 2.62C22.8037 2.99233 23.0006 3.48645 23 4V5.86Z" fill="white"/>
                    </svg>
                    </a>
                </div>
                <div class="deskripsiKanan">
                        <div class="tulisanKeranjang">SIMPAN</div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="bagAtas">
            <div class="cariKami">
                <p>Cari Kami:</p>
                <div class="logoCariKami">
                    <div class="fb">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="22" cy="22" r="22" fill="#BDC0AC"/>
                            <path d="M19.696 23.2481C19.624 23.2481 18.04 23.2481 17.32 23.2481C16.936 23.2481 16.816 23.1041 16.816 22.7441C16.816 21.7841 16.816 20.8001 16.816 19.8401C16.816 19.4561 16.96 19.3361 17.32 19.3361H19.696C19.696 19.2641 19.696 17.8721 19.696 17.2241C19.696 16.2641 19.864 15.3521 20.344 14.5121C20.848 13.6481 21.568 13.0721 22.48 12.7361C23.08 12.5201 23.68 12.4241 24.328 12.4241H26.68C27.016 12.4241 27.16 12.5681 27.16 12.9041V15.6401C27.16 15.9761 27.016 16.1201 26.68 16.1201C26.032 16.1201 25.384 16.1201 24.736 16.1441C24.088 16.1441 23.752 16.4561 23.752 17.1281C23.728 17.8481 23.752 18.5441 23.752 19.2881H26.536C26.92 19.2881 27.064 19.4321 27.064 19.8161V22.7201C27.064 23.1041 26.944 23.2241 26.536 23.2241C25.672 23.2241 23.824 23.2241 23.752 23.2241V31.0481C23.752 31.4561 23.632 31.6001 23.2 31.6001C22.192 31.6001 21.208 31.6001 20.2 31.6001C19.84 31.6001 19.696 31.4561 19.696 31.0961C19.696 28.5761 19.696 23.3201 19.696 23.2481V23.2481Z" fill="white"/>
                        </svg>                                                      
                    </div>
                    <div class="ig">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="22" cy="22" r="22" fill="#BDC0AC"/>
                            <g clip-path="url(#clip0_159_115)">
                            <path d="M33.9975 17.0685C33.9412 15.791 33.7346 14.9128 33.4387 14.1518C33.1334 13.344 32.6637 12.6208 32.0484 12.0196C31.4472 11.409 30.7192 10.9346 29.9208 10.6341C29.1554 10.3381 28.2817 10.1315 27.0042 10.0752C25.7172 10.0141 25.3087 10 22.0445 10C18.7803 10 18.3717 10.0141 17.0895 10.0705C15.812 10.1268 14.9338 10.3335 14.173 10.6293C13.365 10.9346 12.6418 11.4042 12.0406 12.0196C11.43 12.6208 10.9557 13.3488 10.655 14.1472C10.3591 14.9128 10.1525 15.7863 10.0962 17.0637C10.0351 18.3507 10.021 18.7593 10.021 22.0235C10.021 25.2877 10.0351 25.6962 10.0914 26.9785C10.1478 28.2559 10.3545 29.1342 10.6505 29.8952C10.9557 30.703 11.43 31.4262 12.0406 32.0274C12.6418 32.638 13.3698 33.1124 14.1682 33.4129C14.9338 33.7088 15.8073 33.9154 17.0849 33.9717C18.3669 34.0283 18.7757 34.0422 22.0399 34.0422C25.3041 34.0422 25.7127 34.0283 26.9949 33.9717C28.2723 33.9154 29.1506 33.7088 29.9114 33.4129C31.5272 32.7882 32.8046 31.5108 33.4293 29.8952C33.7251 29.1296 33.9318 28.2559 33.9882 26.9785C34.0445 25.6962 34.0586 25.2877 34.0586 22.0235C34.0586 18.7593 34.0538 18.3507 33.9975 17.0685ZM31.8325 26.8845C31.7807 28.0587 31.5835 28.6928 31.4191 29.1155C31.0151 30.1629 30.1839 30.9941 29.1365 31.3981C28.7138 31.5625 28.0751 31.7597 26.9055 31.8113C25.6374 31.8678 25.2571 31.8817 22.0492 31.8817C18.8414 31.8817 18.4563 31.8678 17.1928 31.8113C16.0186 31.7597 15.3846 31.5625 14.9619 31.3981C14.4406 31.2055 13.9662 30.9002 13.5811 30.501C13.1819 30.1111 12.8766 29.6415 12.684 29.1202C12.5196 28.6975 12.3224 28.0587 12.2708 26.8893C12.2143 25.6212 12.2004 25.2407 12.2004 22.0328C12.2004 18.825 12.2143 18.4399 12.2708 17.1766C12.3224 16.0024 12.5196 15.3683 12.684 14.9456C12.8766 14.4242 13.1819 13.95 13.5859 13.5647C13.9756 13.1655 14.4452 12.8602 14.9666 12.6677C15.3893 12.5034 16.0282 12.3061 17.1975 12.2544C18.4657 12.1981 18.8462 12.184 22.0538 12.184C25.2665 12.184 25.6468 12.1981 26.9103 12.2544C28.0845 12.3061 28.7185 12.5034 29.1412 12.6677C29.6624 12.8602 30.1369 13.1655 30.522 13.5647C30.9212 13.9546 31.2265 14.4242 31.4191 14.9456C31.5835 15.3683 31.7807 16.007 31.8325 17.1766C31.8888 18.4447 31.9029 18.825 31.9029 22.0328C31.9029 25.2407 31.8888 25.6164 31.8325 26.8845Z" fill="white"/>
                            <path d="M22.0443 15.8474C18.6346 15.8474 15.8682 18.6137 15.8682 22.0235C15.8682 25.4334 18.6346 28.1997 22.0443 28.1997C25.4541 28.1997 28.2204 25.4334 28.2204 22.0235C28.2204 18.6137 25.4541 15.8474 22.0443 15.8474ZM22.0443 26.0298C19.8323 26.0298 18.038 24.2357 18.038 22.0235C18.038 19.8113 19.8323 18.0172 22.0443 18.0172C24.2565 18.0172 26.0506 19.8113 26.0506 22.0235C26.0506 24.2357 24.2565 26.0298 22.0443 26.0298Z" fill="white"/>
                            <path d="M29.9068 15.6032C29.9068 16.3995 29.2612 17.0451 28.4648 17.0451C27.6686 17.0451 27.0229 16.3995 27.0229 15.6032C27.0229 14.8068 27.6686 14.1614 28.4648 14.1614C29.2612 14.1614 29.9068 14.8068 29.9068 15.6032Z" fill="white"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_159_115">
                            <rect width="24" height="24.0423" fill="white" transform="translate(10 10)"/>
                            </clipPath>
                            </defs>
                        </svg>                            
                    </div>
                    <div class="tw">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="22" cy="22" r="22" fill="#BDC0AC"/>
                            <g clip-path="url(#clip0_159_122)">
                            <path d="M34 14.5585C33.1075 14.95 32.1565 15.2095 31.165 15.3355C32.185 14.7265 32.9635 13.7695 33.3295 12.616C32.3785 13.183 31.3285 13.5835 30.2095 13.807C29.3065 12.8455 28.0195 12.25 26.6155 12.25C23.8915 12.25 21.6985 14.461 21.6985 17.1715C21.6985 17.5615 21.7315 17.9365 21.8125 18.2935C17.722 18.094 14.1025 16.1335 11.671 13.147C11.2465 13.8835 10.9975 14.7265 10.9975 15.634C10.9975 17.338 11.875 18.8485 13.183 19.723C12.3925 19.708 11.617 19.4785 10.96 19.117C10.96 19.132 10.96 19.1515 10.96 19.171C10.96 21.562 12.6655 23.548 14.902 24.0055C14.5015 24.115 14.065 24.1675 13.612 24.1675C13.297 24.1675 12.979 24.1495 12.6805 24.0835C13.318 26.032 15.127 27.4645 17.278 27.511C15.604 28.8205 13.4785 29.6095 11.1775 29.6095C10.774 29.6095 10.387 29.5915 10 29.542C12.1795 30.9475 14.7625 31.75 17.548 31.75C26.602 31.75 31.552 24.25 31.552 17.749C31.552 17.5315 31.5445 17.3215 31.534 17.113C32.5105 16.42 33.331 15.5545 34 14.5585Z" fill="white"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_159_122">
                            <rect width="24" height="24" fill="white" transform="translate(10 10)"/>
                            </clipPath>
                            </defs>
                        </svg>                            
                    </div>
                </div>
            </div>
            <div class="berlangganan">
                <p>Berlangganan dengan kami</p>
                <!-- <label for="alamatEmail">Berlangganan dengan kami</label> -->
                <form action="" method="post">
                    <div class="email">
                        <!-- buat input email -->
                        <div class="kotakEmail">
                            <input type="text" name="alamatEmail" id="alamatEmail" placeholder="Alamat Email" class="styleInput">
                        </div>
                        <!-- button buat berlangganan -->
                        <div class="wrapBerlangganan">
                            <input type="submit" value="Berlangganan" onclick="return confirm('Yakin?');" class="btnBerlangganan">
                        </div>
                    </div>
                </form>
                <div class="penutupan">
                    <p>* Kami akan mengirimkan langganan mingguan kepada Anda.</p>
                </div>
            </div>
        </div>
        <div class="garis"></div>
        <div class="copyright">
            <p>Hak Cipta @ JualanYuk! 2022</p>
        </div>
    </div>
    <script src="editProduk.js"></script>
</body>
</html>