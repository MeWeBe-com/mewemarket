<?php $data = file_get_contents("https://lims.visiopath.com/hospital/ViewReportPDF/$id/doc");?>
	
	
	
	<script src="http://tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script src="http://evidenceprime.github.io/html-docx-js/test/vendor/FileSaver.js"></script> 
<script src="http://evidenceprime.github.io/html-docx-js/build/html-docx.js"></script>
  <textarea id="content" cols="60" rows="10" style="display:none">
	<?php   echo str_replace("https://lims.visiopath.com/","../../",$data)?>
   
  </textarea>
  <div class="page-orientation">
    <label><input type="radio" name="orientation" checked="checked" value="landscape" style="display:none"></label>
  </div>
  <button id="convert" style="display:none">Convert</button>
  <div id="download-area"></div>

  <script>
    tinymce.init({
      selector: '#content',
	  paste_data_images: true,
      plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen fullpage",
        "insertdatetime media table contextmenu paste"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | " +
        "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | " +
        "link image"
    });
    document.getElementById('convert').addEventListener('click', function(e) {
    //  e.preventDefault();
    //convertImagesToBase64()
	//stop;
      // for demo purposes only we are using below workaround with getDoc() and manual
      // HTML string preparation instead of simple calling the .getContent(). Becasue
      // .getContent() returns HTML string of the original document and not a modified
      // one whereas getDoc() returns realtime document - exactly what we need.
      var contentDocument = tinymce.get('content').getDoc();
      var content = '<!DOCTYPE html>' + contentDocument.documentElement.outerHTML;
      var orientation = document.querySelector('.page-orientation input:checked').value;
      var converted = htmlDocx.asBlob(content, {orientation: orientation});

      if(saveAs(converted, 'WordReport.docx')){
	  //	setTimeout(function(){ window.close(); }, 1000);
	  }

      /*var link = document.createElement('a');
      link.href = URL.createObjectURL(converted);
      link.download = 'document.docx';
      link.appendChild(
        document.createTextNode('Click here if your download has not started automatically'));
      var downloadArea = document.getElementById('download-area');
      downloadArea.innerHTML = '';
     // downloadArea.appendChild(link);
	 */
    });

    function convertImagesToBase64 () {
      contentDocument = tinymce.get('content').getDoc();
      var regularImages = contentDocument.querySelectorAll("img");
      var canvas = document.createElement('canvas');
      var ctx = canvas.getContext('2d');
      [].forEach.call(regularImages, function (imgElement) {
        // preparing canvas for drawing
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        canvas.width = imgElement.width;
        canvas.height = imgElement.height;

        ctx.drawImage(imgElement, 0, 0);
        // by default toDataURL() produces png image, but you can also export to jpeg
        // checkout function's documentation for more details
        var dataURL = canvas.toDataURL();
        imgElement.setAttribute('src', dataURL);
      })
      canvas.remove();
    }
	
	setTimeout(function(){ document.getElementById("convert").click(); }, 1000);
	//
	
	
	
  </script>