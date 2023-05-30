

<div>
    <p>Your are loggedin  Successfully!!!</p>
    <h3>Please Wait We are redirecting you back </h3>
</div>

<script>
 localStorage.setItem("User",<?php echo json_encode($loginUser) ?>);

 var delayInMilliseconds = 1000; //1 second

setTimeout(function() {
  //your code to be executed after 1 second
  window.location.replace("http://qwiktest.test/dashboard");
}, delayInMilliseconds);
</script>

