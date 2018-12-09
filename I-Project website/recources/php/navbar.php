<?php

?>

  <nav class="navbar navbar-expand-lg navbar-dark navbarBox">
    <a class="navbar-brand" href="home.php"><strong>EenmaalAndermaal</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="veilingen.php">Veilingen</a>
        </li>
        <li>
          <a class="nav-link" href="changelog.php">Changelog</a>
        </li>
      </ul>
      <ul class="navbar-nav navbarItemRight">
        <li>

        <div class="dropdown">
          <?php if(isset($_SESSION['username'])){?>

            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?=$_SESSION['username']?>
            </a>
              <?php }else{?>
            <a class="nav-link" href="login.php">Aanmelden / Inloggen</a>
              <?php } ?>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" style="color: black !important;" href="mijngegevens.php?id=<?=$_SESSION['username']?>">Mijn gegevens</a>
              <?php if(isVerkoper($_SESSION['username']) == true){?>
              <a class="dropdown-item" style="color: black !important;" href="mijnveilingen.php">Mijn veilingen</a>
              <?php } ?>
              <?php if(isBeheerder($_SESSION['username']) == true){?>
              <a class="dropdown-item" style="color: black !important;" href="adminpage.php">Beheersomgeving</a>
              <?php } ?>
              <div class="dropdown-divider"></div>
                <a class="dropdown-item" style="color: black !important;" href="logout.php">Uitlogen</a>
              </div>
          </div>
        </li>

        </ul>


  </div>
</nav>

<div class="navbarSpace"></div>
