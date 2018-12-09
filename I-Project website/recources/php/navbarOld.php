<?php

?>

<div class="navbarBox">
  <ul class="nav" style="float: left;">
    <li class="nav-item">

      <a class="nav-link" href="home.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="veilingen.php">Veilingen</a>
    </li>
  </ul>
  <ul class="nav justify-content-end" style="float: right;">
    <li class="nav-item">
      <a class="nav-link" href="changelog.php">Changelog</a>
    </li>
    <li class="nav-item dropdown">
<!--      <a class="nav-link" href="login.php">-->

          <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php  if (isset($_SESSION['username'])){
                  echo $_SESSION['username'];?>
                  </a>
          <div class="dropdown-menu dropdowntekst"  aria-labelledby="dropdown01">
            <a class="dropdown-item dropdowntekst" href="#">Mijn gegevens</a>
            <a class="dropdown-item dropdowntekst" href="mijnveilingen.php">Mijn veilingen</a>
            <a class="dropdown-item dropdowntekst" href="aanvraagVerkoper.php">Word verkoper</a>
            <a class="dropdown-item dropdowntekst" href="adminpage.php">Admin pagina</a>
            <a class="dropdown-item dropdowntekst" href="logout.php">Uitloggen</a>

          </div>
      </li><?php
}else {
    echo '<a href= "login.php">Aanmelden</a>';
            }
?> </a>
    </li>
  </ul>
</div>
<div class="navbarSpace"></div>
