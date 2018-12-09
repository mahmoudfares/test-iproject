<script>
var teller = 0;
var x = [];
    x[teller] = setInterval(function() {
    for(i = 0;i<countDownDate.length;i++) {
      teller = i;
    var now = new Date().getTime();
    var distance = countDownDate[i] - now;
    console.log(i);
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // document.getElementById("demo"+i).innerHTML = "Nog: "+ days + "d " + hours + "h "
    // + minutes + "m " + seconds + "s ";
    if(days < 0){
      days = 0;
    }
    if(hours < 0){
      hours = 0;
    }
    if(minutes < 0){
      minutes = 0;
    }
    if(seconds < 0){
      seconds = 0;
    }

    document.getElementById("cd_Days"+i).innerHTML = ""+days;
    document.getElementById("cd_Hours"+i).innerHTML = ""+hours;
    document.getElementById("cd_Minutes"+i).innerHTML = ""+minutes;
    document.getElementById("cd_Seconds"+i).innerHTML = ""+seconds;
    if (distance < 0) {
      clearInterval(x[i]);

    }
   }
  },1000);



</script>
