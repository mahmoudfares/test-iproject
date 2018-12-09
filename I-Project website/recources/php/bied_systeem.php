<?php
 $tabel = 'Bod';
 $bodkolomen = 'bodbedrag ,bodDag, gebruiker, bodTijdstip, Voorwerp';
 $waarde = array($_POST['bod_plaatsen'], date ,$_post['gebruiker'],date(G),$_POST['Voorwerp']);
 $bodplaatsen = insert( $tabel,$bodkolomen ,'?,?,?,?,?',$waarde);
?>
<script type="text/javascript" src="recources\js\errormessage.js"></script>
<form>
<div class="form-group">
<input type="number" pattern="[0-9]" placeholder="plaats uw bod" required>
         <button type="submit" class="btn buttonGreen" name="bod_plaatsen">plaats bod</button>
       </div>
</form>
