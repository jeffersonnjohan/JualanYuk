<?php 

session_start();
require '../functions.php';

// Cek apakah current user sudah ada
if(isset($_SESSION["currentUserId"])){
    // Jika masuk memlalui login,
    $currentUserData = detailUser($_SESSION["currentUserId"]);
    $currentUsername = $currentUserData["username"];

    // Jika dia adalah admin, langsung lempar
    if($currentUsername == 'admin'){
        header("Location: ../editStok/editStok.php");
    }
} else{
    // Jika masuk melalui url
    $currentUsername = "YOUR NAME";
    redirectTo('../home/home.php');
}

// Query seluruh keranjang yang dimiliki currentUser
$currentUserId = $currentUserData['userId'];
$trollies = query("SELECT t.userId, t.qty, i.qtyPerItem, i.itemId,i.itemName, i.buyPrice, i.itemImage FROM trolly t JOIN item i ON i.itemId=t.itemId WHERE t.userId=$currentUserId");
$i = 0;
// var_dump($trollies);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link rel="stylesheet" href="../header/header.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="../editStok/editStok.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="keranjang.css">
</head>
<body>
    <!-- header -->
    <div class="container">
        <!-- logo -->
        <a href="../home/home.php">
            <div class="logo" style="background-image: url(../image/logo.svg) ;"></div>
        </a>

        <!-- search -->
        <div class="search1" id="search1">
            <div class="svgSearch">
                <svg width="23" height="23" viewBox="0 0 27 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.2475 4.75643C13.8721 4.75473 15.4606 5.30719 16.8122 6.34393C18.1637 7.38067 19.2175 8.85511 19.8402 10.5807C20.4629 12.3063 20.6266 14.2056 20.3106 16.0382C19.9946 17.8708 19.213 19.5545 18.0648 20.8762C16.9165 22.1979 15.4532 23.0983 13.8599 23.4634C12.2667 23.8285 10.615 23.642 9.11395 22.9274C7.61287 22.2128 6.32981 21.0023 5.42708 19.449C4.52435 17.8956 4.0425 16.0693 4.0425 14.201C4.05235 11.7011 4.91973 9.30672 6.45612 7.53823C7.99252 5.76973 10.0738 4.77004 12.2475 4.75643M12.2475 2.98828C10.3191 2.98828 8.43407 3.64589 6.83069 4.87796C5.22731 6.11002 3.97763 7.8612 3.23968 9.91005C2.50172 11.9589 2.30864 14.2134 2.68485 16.3884C3.06105 18.5635 3.98965 20.5614 5.35321 22.1295C6.71677 23.6976 8.45406 24.7655 10.3454 25.1982C12.2367 25.6308 14.1971 25.4088 15.9787 24.5601C17.7602 23.7115 19.283 22.2743 20.3543 20.4304C21.4257 18.5865 21.9975 16.4186 21.9975 14.201C21.9975 11.2272 20.9703 8.37518 19.1418 6.2724C17.3133 4.16961 14.8334 2.98828 12.2475 2.98828Z" fill="#FFF9F9"/>
                    <path d="M26.25 29.1137L20.7225 22.7139L19.6575 23.93L25.185 30.3299C25.2544 30.4103 25.3369 30.4742 25.4279 30.5179C25.5188 30.5617 25.6163 30.5844 25.7148 30.5848C25.8134 30.5852 25.911 30.5633 26.0022 30.5203C26.0934 30.4773 26.1763 30.414 26.2462 30.3342C26.3161 30.2543 26.3717 30.1594 26.4098 30.0549C26.4478 29.9503 26.4675 29.8382 26.4679 29.7248C26.4682 29.6115 26.4492 29.4992 26.4118 29.3944C26.3744 29.2895 26.3194 29.1941 26.25 29.1137Z" fill="#FFF9F9"/>
                </svg>                    
            </div>
        </div>
        <div class="search2 displayNone" id="search2">
            <div class="svgSearch svgSearch2">
                <svg width="23" height="23" viewBox="0 0 27 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.2475 4.75643C13.8721 4.75473 15.4606 5.30719 16.8122 6.34393C18.1637 7.38067 19.2175 8.85511 19.8402 10.5807C20.4629 12.3063 20.6266 14.2056 20.3106 16.0382C19.9946 17.8708 19.213 19.5545 18.0648 20.8762C16.9165 22.1979 15.4532 23.0983 13.8599 23.4634C12.2667 23.8285 10.615 23.642 9.11395 22.9274C7.61287 22.2128 6.32981 21.0023 5.42708 19.449C4.52435 17.8956 4.0425 16.0693 4.0425 14.201C4.05235 11.7011 4.91973 9.30672 6.45612 7.53823C7.99252 5.76973 10.0738 4.77004 12.2475 4.75643M12.2475 2.98828C10.3191 2.98828 8.43407 3.64589 6.83069 4.87796C5.22731 6.11002 3.97763 7.8612 3.23968 9.91005C2.50172 11.9589 2.30864 14.2134 2.68485 16.3884C3.06105 18.5635 3.98965 20.5614 5.35321 22.1295C6.71677 23.6976 8.45406 24.7655 10.3454 25.1982C12.2367 25.6308 14.1971 25.4088 15.9787 24.5601C17.7602 23.7115 19.283 22.2743 20.3543 20.4304C21.4257 18.5865 21.9975 16.4186 21.9975 14.201C21.9975 11.2272 20.9703 8.37518 19.1418 6.2724C17.3133 4.16961 14.8334 2.98828 12.2475 2.98828Z" fill="#FFF9F9"/>
                    <path d="M26.25 29.1137L20.7225 22.7139L19.6575 23.93L25.185 30.3299C25.2544 30.4103 25.3369 30.4742 25.4279 30.5179C25.5188 30.5617 25.6163 30.5844 25.7148 30.5848C25.8134 30.5852 25.911 30.5633 26.0022 30.5203C26.0934 30.4773 26.1763 30.414 26.2462 30.3342C26.3161 30.2543 26.3717 30.1594 26.4098 30.0549C26.4478 29.9503 26.4675 29.8382 26.4679 29.7248C26.4682 29.6115 26.4492 29.4992 26.4118 29.3944C26.3744 29.2895 26.3194 29.1941 26.25 29.1137Z" fill="#FFF9F9"/>
                </svg>                    
            </div>
            <div class="searchText">Cari</div>
        </div>

        <!-- akun -->
        <div class="namaAkun"><?= $currentUsername ?></div>

        <!-- kotak logo -->
        <div class="kotakLogo">
            <div class="keranjang">
                <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 2.53125C0 2.30747 0.0888949 2.09286 0.247129 1.93463C0.405362 1.77639 0.619974 1.6875 0.84375 1.6875H3.375C3.56321 1.68755 3.746 1.75053 3.8943 1.86642C4.0426 1.9823 4.14789 2.14445 4.19344 2.32706L4.87688 5.0625H24.4688C24.5926 5.06261 24.715 5.09001 24.8271 5.14274C24.9392 5.19547 25.0383 5.27225 25.1174 5.36761C25.1965 5.46297 25.2536 5.57457 25.2847 5.6945C25.3158 5.81442 25.3201 5.93972 25.2973 6.0615L22.7661 19.5615C22.7299 19.7549 22.6273 19.9295 22.476 20.0552C22.3247 20.1809 22.1342 20.2498 21.9375 20.25H6.75C6.55329 20.2498 6.36283 20.1809 6.21154 20.0552C6.06024 19.9295 5.95763 19.7549 5.92144 19.5615L3.39188 6.08681L2.71688 3.375H0.84375C0.619974 3.375 0.405362 3.28611 0.247129 3.12787C0.0888949 2.96964 0 2.75503 0 2.53125ZM5.23462 6.75L7.45031 18.5625H21.2372L23.4529 6.75H5.23462ZM8.4375 20.25C7.54239 20.25 6.68395 20.6056 6.05101 21.2385C5.41808 21.8715 5.0625 22.7299 5.0625 23.625C5.0625 24.5201 5.41808 25.3785 6.05101 26.0115C6.68395 26.6444 7.54239 27 8.4375 27C9.33261 27 10.1911 26.6444 10.824 26.0115C11.4569 25.3785 11.8125 24.5201 11.8125 23.625C11.8125 22.7299 11.4569 21.8715 10.824 21.2385C10.1911 20.6056 9.33261 20.25 8.4375 20.25ZM20.25 20.25C19.3549 20.25 18.4965 20.6056 17.8635 21.2385C17.2306 21.8715 16.875 22.7299 16.875 23.625C16.875 24.5201 17.2306 25.3785 17.8635 26.0115C18.4965 26.6444 19.3549 27 20.25 27C21.1451 27 22.0035 26.6444 22.6365 26.0115C23.2694 25.3785 23.625 24.5201 23.625 23.625C23.625 22.7299 23.2694 21.8715 22.6365 21.2385C22.0035 20.6056 21.1451 20.25 20.25 20.25ZM8.4375 21.9375C8.88505 21.9375 9.31427 22.1153 9.63074 22.4318C9.94721 22.7482 10.125 23.1774 10.125 23.625C10.125 24.0726 9.94721 24.5018 9.63074 24.8182C9.31427 25.1347 8.88505 25.3125 8.4375 25.3125C7.98995 25.3125 7.56073 25.1347 7.24426 24.8182C6.92779 24.5018 6.75 24.0726 6.75 23.625C6.75 23.1774 6.92779 22.7482 7.24426 22.4318C7.56073 22.1153 7.98995 21.9375 8.4375 21.9375ZM20.25 21.9375C20.6976 21.9375 21.1268 22.1153 21.4432 22.4318C21.7597 22.7482 21.9375 23.1774 21.9375 23.625C21.9375 24.0726 21.7597 24.5018 21.4432 24.8182C21.1268 25.1347 20.6976 25.3125 20.25 25.3125C19.8024 25.3125 19.3732 25.1347 19.0568 24.8182C18.7403 24.5018 18.5625 24.0726 18.5625 23.625C18.5625 23.1774 18.7403 22.7482 19.0568 22.4318C19.3732 22.1153 19.8024 21.9375 20.25 21.9375Z" fill="white"/>
                </svg>                    
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
        <div class="kotakAtas">
            <div class="tulisanKeranjang">
                KERANJANG
            </div>
            <div class="garis"></div>
        </div>
        <div class="kotakBawah">
            <!-- <label for="myCheckBoxId" class="checkBox">
                <input type="checkbox" name="myCheckBoxName" id="myCheckBoxId" class="checkBoxInput">
                <div class="checkBoxBox"></div>
                Pilih Semua
            </label> -->
            <div class="pilihSemua">
                <div class="kotakPilih"  id="pilihSemua">
                    <svg viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" id="gambarLogoPilihSemua" class="displayNone">
                        <rect x="0.5" y="0.5" width="23.3226" height="23.3226" fill="white" stroke="white"/>
                        <path d="M20.8232 5H19.2813C19.0652 5 18.86 5.09086 18.7277 5.24633L9.63318 15.7921L5.27233 10.7343C5.20636 10.6576 5.12227 10.5956 5.02638 10.5529C4.93049 10.5103 4.82529 10.488 4.71867 10.4879H3.17682C3.02903 10.4879 2.94742 10.6434 3.03786 10.7484L9.07953 17.7547C9.36187 18.0818 9.90449 18.0818 10.189 17.7547L20.9621 5.25845C21.0526 5.15547 20.971 5 20.8232 5Z" fill="#8C8E81"/>
                    </svg>                        
                </div>
                <div class="tulisanPilih">Pilih Semua</div>
            </div>
            <div class="garis2"></div>
            <div class="kumpulanKeranjang">
                <?php foreach($trollies as $trolly): ?>
                <div class="cardKeranjang">
                    <div class="kotakPilih">
                        <svg viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="gambarlogo displayNone">
                            <rect x="0.5" y="0.5" width="23.3226" height="23.3226" fill="white" stroke="white"/>
                            <path d="M20.8232 5H19.2813C19.0652 5 18.86 5.09086 18.7277 5.24633L9.63318 15.7921L5.27233 10.7343C5.20636 10.6576 5.12227 10.5956 5.02638 10.5529C4.93049 10.5103 4.82529 10.488 4.71867 10.4879H3.17682C3.02903 10.4879 2.94742 10.6434 3.03786 10.7484L9.07953 17.7547C9.36187 18.0818 9.90449 18.0818 10.189 17.7547L20.9621 5.25845C21.0526 5.15547 20.971 5 20.8232 5Z" fill="#8C8E81"/>
                        </svg>      
                        <input type="checkbox" name="" class="checkBoxInput">
                    </div>
                    <div class="kotakFoto" style="background-image:url(../image/Produk/<?=$trolly['itemImage']?>) ;"></div>
                    <div class="kotakTulisan">
                        <p class="namaBarang"><?=$trolly['itemName']?> (<?=$trolly['qtyPerItem']?>pcs)</p>
                        <p class="harga">Rp<?=number_format($trolly['buyPrice'])?></p>
                    </div>
                    <div class="kotakJumlah">
                        <div class="kotakMin">-</div>
                        <div class="kotakAngka">
                            <form action="../updateKeranjang.php" method="get" class="qty<?php echo"$i"; $i++;?>">
                                <input type="hidden" name="itemId" value="<?=$trolly['itemId']?>">
                                <input type="text" name="qtyKeranjang" class="inputText qtyBeli" value="<?=$trolly['qty']?>">
                            </form>
                        </div>
                        <div class="kotakTambah">+</div>
                    </div>
                    <div class="tempatSampah">
                        <div class="svgTempatSampah">
                            <a href="../deleteKeranjang.php?userId=<?=$trolly['userId']?>&itemId=<?=$trolly['itemId']?>">
                                <svg width="32" height="32" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M27.1399 34H8.85988C8.47507 33.9909 8.09583 33.9061 7.74381 33.7504C7.39179 33.5947 7.07391 33.3711 6.80831 33.0925C6.54271 32.8139 6.33461 32.4857 6.1959 32.1267C6.05718 31.7676 5.99058 31.3848 5.99988 31V11.23H7.99988V31C7.99033 31.1222 8.00504 31.2451 8.04315 31.3616C8.08126 31.4781 8.14202 31.5859 8.22194 31.6788C8.30186 31.7717 8.39937 31.848 8.50885 31.9031C8.61833 31.9582 8.73763 31.9911 8.85988 32H27.1399C27.2621 31.9911 27.3814 31.9582 27.4909 31.9031C27.6004 31.848 27.6979 31.7717 27.7778 31.6788C27.8577 31.5859 27.9185 31.4781 27.9566 31.3616C27.9947 31.2451 28.0094 31.1222 27.9999 31V11.23H29.9999V31C30.0092 31.3848 29.9426 31.7676 29.8039 32.1267C29.6651 32.4857 29.457 32.8139 29.1915 33.0925C28.9259 33.3711 28.608 33.5947 28.2559 33.7504C27.9039 33.9061 27.5247 33.9909 27.1399 34Z" fill="white"/>
                                    <path d="M30.78 9H5C4.73478 9 4.48043 8.89464 4.29289 8.70711C4.10536 8.51957 4 8.26522 4 8C4 7.73478 4.10536 7.48043 4.29289 7.29289C4.48043 7.10536 4.73478 7 5 7H30.78C31.0452 7 31.2996 7.10536 31.4871 7.29289C31.6746 7.48043 31.78 7.73478 31.78 8C31.78 8.26522 31.6746 8.51957 31.4871 8.70711C31.2996 8.89464 31.0452 9 30.78 9Z" fill="white"/>
                                    <path d="M21 13H23V28H21V13Z" fill="white"/>
                                    <path d="M13 13H15V28H13V13Z" fill="white"/>
                                    <path d="M23 5.86H21.1V4H14.9V5.86H13V4C12.9994 3.48645 13.1963 2.99233 13.55 2.62C13.9037 2.24767 14.3871 2.02568 14.9 2H21.1C21.6129 2.02568 22.0963 2.24767 22.45 2.62C22.8037 2.99233 23.0006 3.48645 23 4V5.86Z" fill="white"/>
                                </svg>                            
                            </a>
                        </div>
                    </div>
                    <div class="harga totalHarga">
                        <p class="subtotal">Rp<?=number_format($trolly['buyPrice']*$trolly['qty'])?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
    <div class="bagianBawah">
        <div class="kotakDalam">
            <div class="atas">
                <div class="tulisanSub">SUBTOTAL</div>
                <div class="garis3"></div>
            </div>
            <div class="bawah">
                <div class="totalBrg">
                    <p class="tulis">Total Barang</p>
                    <p class="jumlah grandTotalQty">0 Barang</p>
                </div>
                <div class="totalHrg">
                    <p class="tulis">Total Harga</p>
                    <p class="harga grandTotal">Rp0</p>
                </div>
            </div>
            <div class="tombolCekot">
                <p class="tulisanCekot">CHECKOUT</p>
            </div>
        </div>
    </div>

    <script src="keranjang.js"></script>
</body>
</html>