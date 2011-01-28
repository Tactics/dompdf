<?php 
$files = glob("test/*.{html,htm,php}", GLOB_BRACE);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>dompdf debugger</title>
  <script type="text/javascript" src="jquery-1.4.2.js"></script>
	
	<script type="text/javascript">
		function updateAddress(){
			var addressbar = $('#addressbar'),
			    preview = $('#preview'),
          preview_html = $('#preview_html'),
          address = addressbar.val();

      // HTML file
      preview_html.attr("src", "about:blank");
      preview_html.attr("src", "test/"+address+"?"+(new Date).getTime());

			// PDF file
      preview.attr("src", "about:blank");

      setTimeout(function(){
        address = "../dompdf.php?base_path=www/test/&options[Attachment]=0&input_file="+address+"#toolbar=0&view=FitH&statusbar=0&messages=0&navpanes=0";
  			preview.attr('src', address);
      }, 0.1);
		}
		
		function log(str){
			var console = $("#console");
			str = str || "(nothing)";
			console.html(console.html() + str + "<hr />");
			console.scrollTop(console[0].scrollHeight);
		}
    
    function resizePage(){
      var page = $("#page");
      var height = $(window).height() - page.offset().top - 40;
      $("iframe, #console").height(height);
    }

    $(function(){
      resizePage();
      $(window).resize(resizePage);
		
      $('#preview').load(function(){
			  if (this.src == "about:blank") return;
				
				$.ajax({
				  url: '../lib/fonts/log.htm',
				  success: log
				});
      });

      $('#addressbar').val($("#examples").val());
		});
	</script>
	
	<style type="text/css">
		html, body {
			margin: 0;
			padding: 0;
		}
		
		td {
      padding: 0;
		}
		
		#page {
			width: 100%;
			border: none;
      border-spacing: 0;
      border-collapse: collapse;
		}
    
    iframe {
      width: 100%;
    }
		
		#output td {
			border: 1px solid #999;
		}
    
    #console-container {
      vertical-align: top;
    }
		
		#console {
      background: #eee; 
			overflow: scroll; 
      padding: 4px;
		}
		
		#console pre {
			margin: 2px 0;
		}
    
    #console, #console pre {
      font-size: 11px; 
      font-family: Courier, "Courier new", monospace;
      white-space: pre-wrap;
    }
	</style>
</head>

<body>

<table id="page">
  <tr>
    <td colspan="3">
      <button onclick="$('#console').html('')" style="float: right;">Reset</button>
			<select onchange="$('#addressbar').val($(this).val()); updateAddress()" id="examples">
				<?php foreach($files as $file) { ?>
				  <option value="<?php echo basename($file); ?>"><?php echo basename($file); ?></option>
			  <?php } ?>
		  </select>
      <input id="addressbar" type="text" size="100" value="" />
			<button onclick="updateAddress()">Go</button>
    </td>
  </tr>
	<tr id="output">
    <td style="width: 40%;">
      <iframe id="preview_html" name="preview_html" src="about:blank" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </td>
    <td style="width: 40%;">
      <iframe id="preview" name="preview" src="about:blank" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </td>
    <td style="min-width: 400px; width: 20%;" id="console-container">
		  <div id="console"></div>
		</td>
	</tr>
</table>