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
    	var xhttp = new XMLHttpRequest();
		xhttp.open("GET", "https://mewemarket.com/apps/blog_site/form.php", false);
		xhttp.send();
		var category = "<?php echo $category?>";

		document.getElementById('Forms').innerHTML = xhttp.response;
		document.getElementById('category_id').setAttribute('value',category);

    }
    function mousedown() {
        var actionbox = "<?php echo $_SERVER['REQUEST_URI'] ;?>";
        document.getElementById("addComments").setAttribute("action", actionbox) ;
	}

    function mouseup() {
        var name = document.getElementById("name").value;
        var title = document.getElementById("title").value;
        var message = document.getElementById("comments").value;

        if(name !== '' || title !== '' || message !== ''){
            document.getElementById("addComments").submit();
        }else{
            alert('Please fill all the fields');
        }
    }

</script>
</body>
</html>
