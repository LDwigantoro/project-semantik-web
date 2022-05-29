<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css" />

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css" />

  <!-- My CSS -->
  <link rel="stylesheet" href="src/style.css" />

  <title>Basket Bandung</title>
</head>

<body id="home">
  <!-- Navbar -->
  <!--PHP-->
  <?php
  require_once("sparqllib.php");
  $test = "";
  if (isset($_POST['search-klub'])) {
    $test = $_POST['search-klub'];
    $data = sparql_get(
      "http://localhost:3030/basket",
      "
      PREFIX p: <http://basket.com>
      PREFIX d: <http://basket.com/ns/data#>
      
          SELECT ?namaBasket ?tempatLatihan ?nomerTelfon ?Email ?contactPerson ?Jargon 
          WHERE
         { 
              ?s  d:namaKlub ?namaBasket ;
                  d:tempatLatihan ?tempatLatihan;
                  d:nomerTelfon ?nomerTelfon;
                  d:Email ?Email;
                  d:contactPerson ?contactPerson;
                  d:Jargon ?Jargon;
              FILTER (regex (?namaBasket,  '$test', 'i') || regex (?tempatLatihan,  '$test', 'i') || regex (?nomerTelfon,  '$test', 'i') || regex (?Email,  '$test', 'i') || regex (?contactPerson,  '$test', 'i') || regex (?Jargon,  '$test', 'i'))
            }"
    );
  } else {
    $data = sparql_get(
      "http://localhost:3030/basket",
      "
      PREFIX p: <http://basket.com>
      PREFIX d: <http://basket.com/ns/data#>
      
          SELECT ?namaBasket ?tempatLatihan ?nomerTelfon ?Email ?contactPerson ?Jargon 
          WHERE
          { 
              ?s  d:namaKlub ?namaBasket ;
                  d:tempatLatihan ?tempatLatihan;
                  d:nomerTelfon ?nomerTelfon;
                  d:Email ?Email;
                  d:contactPerson ?contactPerson;
                  d:Jargon ?Jargon;
      
          }

            "
    );
  }

  if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
  }

  ?>
  <!-- Akhir Navbar -->

  <!-- About -->
  <section id="about">
    <div class="container">


      <div class="row tentang">
        <div class="col-lg-6">
          <img src="src/img/Jabar-2.jpg" alt="tentang" class="img-fluid" />
        </div>
        <div class="col-lg">
          <h3>List Klub Basket Di <span>Bandung</span></h3>
          <p>
            Bola basket adalah olahraga bola berkelompok yang terdiri atas dua tim beranggotakan masing-masing lima orang yang saling bertanding
            mencetak poin dengan memasukkan bola ke dalam keranjang lawan. Dibuat untuk memenuhi tugas kelas semantik web, Leonardo Dwigantoro NPM 140810190038.
          </p>
        </div>
        <div class="text-center mt-5 ">
          <form action="" method="post" id="nameform">
            <div class="search-box">
              <input type="text" name="search-klub" placeholder="Cari Tim" />
              <button type="submit" class="btn btn-primary">Cari</button>
            </div>
            <i class="bi bi-search"></i>
        </div>
        </form>
      </div>

      <!-- Hasil Pencarian -->

      <div class="row text-center mb-3 mt-0 hasil">
        <div class="col">
          <h2>Cari Tim Kamu Disini!</h2>
        </div>
      </div>
      <div class="row fs-5">
        <div class="col-md-5">
          <p>
            Menampilkan Pencarian :
            <br />
          </p>
          <p>
            <span>
              <?php
              if ($test != NULL) {
                echo $test;
              } else {
                echo "Hasil Pencarian Kamu :";
              }
              ?></span>
          </p>
        </div>
      </div>

      <div class="row">

        <?php $i = 0; ?>
        <?php foreach ($data as $dat) : ?>
          <div class="col-md-4">
            <div class="box">
              <ul class="list-group list-group-flush">
                <div class="header-data"> <b>Nama Klub :</b></div>
                <div class="item-data"><?= $dat['namaBasket'] ?></div>

                <div class="header-data"> <b>Tempat Latihan :</b></div>
                <div class="item-data"><?= $dat['tempatLatihan'] ?></div>

                <div class="header-data"> <b>Nomer Telfon :</b></div>
                <div class="item-data"><?= $dat['nomerTelfon'] ?></div>

                <div class="header-data"> <b>Email :</b></div>
                <div class="item-data"><?= $dat['Email'] ?></div>

                <div class="header-data"> <b>Contact Person :</b></div>
                <div class="item-data"><?= $dat['contactPerson'] ?></div>

                <div class="header-data"> <b>Jargon :</b></div>
                <div class="item-data"><?= $dat['Jargon'] ?></div>

              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <!-- Akhir About -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>