<!DOCTYPE html>
<html lang="en">
<head>

    
</head>
<body onload="copyToClipboard('#p1')">
	<input type="hidden" value="<?php echo $_GET['share-id']; ?>"  id="p1" >
</body>
</html>   

<script>
function copyToClipboard(element) {
  document.execCommand("copy");  

  var text = document.querySelector(element).value;
  
  var output = document.getElementById("output");
  navigator.clipboard.writeText(text).then(function() {
    output.textContent = "worked";
  }, function() {
    output.textContent = "didn't work";
  });
   setTimeout(function () { window.close();}, 300);
}


</script>    