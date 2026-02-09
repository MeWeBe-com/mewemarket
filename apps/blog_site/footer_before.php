<footer>

	<div class="container">
		<div class="left-footer"> </div>
		<div class="mid-footer top-footer">
			<div class="footer-container pt-20 pb-20">
			<?php echo $general['footer_text'];?>
		</div>
		</div>
	</div>

	</footer>

	<script>
		function heart(id) {
		  var xhttp = new XMLHttpRequest();
		  xhttp.open("GET", "/likes.php?article_id="+id+"", false);
		  xhttp.send();

		  document.getElementById('like_'+id).innerHTML = '&#x2764; ' + xhttp.response;
		}


		  function Append(){
    	var text = "<form method='post' class='comments' id='addComments'>";
        var text1 = '<input type="hidden" value="<?php echo $category; ?>" name="category_id" /><input type="text" value="" name="name" placeholder="Your Name" required="" /><input type="email" value="" name="email" placeholder="Your Email (for validation)" required="" /><input type="text" value="" name="title" placeholder="Title" required="" /><textarea maxlength="500" name="comments" required="" placeholder="Your Comment / QA (will be moderated)"></textarea>';
        var submit = "<input type='submit' id='submit' onmouseup='mouseUp()' name='submit' value='Submit' />";
        var end = "</form>";
	        document.getElementById("Forms").innerHTML += text;
	        document.getElementById("addComments").innerHTML += text1;
	        document.getElementById("addComments").innerHTML += submit;
	        document.getElementById("Forms").innerHTML += end;

         	
    }

    function mouseUp() {
	   	var actionbox = "<?php echo $_SERVER['REQUEST_URI'] ;?>";
		document.getElementById("addComments").setAttribute("action", actionbox) ;

	}

	</script>

</body>
</html>