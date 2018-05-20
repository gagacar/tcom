<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>  
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"> 
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
<script src="/tcom/js/jquery.form.min.js"></script> 

<script>
	/* Fja za resetovanje polja - Pocetak */
	function resetFields()
	{
		
		$("#title").val("");
		$("#author").val("");
		$("#released").val("");
		$("#image").val("");
		$("#bar").width('0%');
		$("#message").html("");
		$("#percent").html("0%");
		
	}
	/* Resetovanje polja - Kraj */
	
	/* Fja za ispisivanje knjiga - Pocetak */
	function showBooks(x, a, y, s)
	{
		
		var dataString = 'show_books=' + x + '&authors=' + a + '&years=' + y + '&search=' + s;
			
		$.ajax({
		   type: "POST",
		   url: "/tcom/ajax/ajax.php",
		   data: dataString,
		   cache: false,
		
		   beforeSend: function()
		   {
		 
		   }, 
		   success: function(response)
		   {			 
		      $("#sadrzaj").html(response);			
		   }
		   
		 });
		
		return false;
		
	} 
	/* Fja za ispisivanje knjiga - Kraj */
	
	/* Fja za ispisivanje autora - Pocetak */
	function showAuthors(x)
	{
		
		var dataString = 'show_authors=' + x;
			
		$.ajax({
		   type: "POST",
		   url: "/tcom/ajax/ajax.php",
		   data: dataString,
		   cache: false,
		
		   beforeSend: function()
		   {
		 
		   }, 
		   success: function(response)
		   {			 
		      $("#authors").html(response);			
		   }
		   
		 });
		
		return false;		
		
	} 
	/* Fja za ispisivanje autora - Kraj */
	
	/* Fja za ispisivanje godine - Pocetak */
	function showYears(x)
	{
		
		var dataString = 'show_years=' + x;
			
		$.ajax({
		   type: "POST",
		   url: "/tcom/ajax/ajax.php",
		   data: dataString,
		   cache: false,
		
		   beforeSend: function()
		   {
		 
		   }, 
		   success: function(response)
		   {			 
		      $("#years").html(response);		
		   }
		   
		 });
		
		return false;
		
	} 
	/* Fja za ispisivanje godine - Kraj */
	
	/* Fja za osvezavanje elemenata - Pocetak */
	function refreshElements($x)
	{
		
		var a = '';
		var y = '';
		var s = '';
		
		if($x == 1)
		{
			a = $("#authors").val(); 
			y = $("#years").val();
			s = $("#search").val();
		}
		
		if($x == 0)
		{
			$("#search").val("");
		}
		
		if((a == null) || (a == 'null')) a = '';
		
		showAuthors(a);
		showYears(y);
		showBooks(1, a, y, s);
		
	}
	/* Fja za osvezavanje elemenata - Kraj */
	
	/* Ispisivanje liste knjiga - Pocetak */
	$(function() { 
		$(document).ready(function(){
			
			refreshElements(1);
			
		});
	});
	/* Ispisivanje liste knjiga - Kraj */
	
	/* Pretraga knjiga - Pocetak */
	$(function() { 
	  $(document).on("click","#find", function () {
	  
	 		 refreshElements(1);
			 
	  });
 	});	
	/* Pretraga knjiga - Kraj */
	
	/* Resetovanje forme - Pocetak */
	$(function() { 
	  $(document).on("click","#reset", function () {
	  
	 		 refreshElements(0);
			 
	  });
 	});
	/* Resetovanje forme - Kraj */
	
	/* Izmena knjige - Pocetak */
	$(function() { 
	  $(document).on("click",".dugme_promeni", function () {
	  		
			var x = $(this).attr('id');  
			var y = x.split("_");
			var id = y[1];
			
			$('#book-form').dialog('option', 'title', 'Edit book');
				
				/* Dugme za cuvanje */
				$('.ui-dialog-buttonpane').
                    find('button:contains("Save")').button({
                    icons: {
                        primary: 'icon_save'
                    }
                });
				/* Dugme za povratak */
				$('.ui-dialog-buttonpane').
                    find('button:contains("Back")').button({
                    icons: {
                        primary: 'back_icon'
                    }
                });
				 
			$( "#book-form" ).dialog( "open" ); 
			
			$("#id").val(id);
			
			 $.getJSON("/tcom/json/json.php?id_book=" + id,
					function(data)
					{
						$.each(data, function(i, item){
							 
								$("#"+item.field).val(item.value);
							 
						});
					
					
				});
			
	  });
 	});
	/* Izmena forme - Kraj */
	
	/* Brisanje knjige - Pocetak */
	$(function() { 
	  $(document).on("click",".dugme_obrisi", function () {
	  
	 		var x = $(this).attr('id');  
			var y = x.split("_");
			var id = y[1];
			
			if(!confirm('Are your shure to delete this book?'))
				{
					ev.preventDefault();
					return false;
				} 
				else
				{
				
					var dataString = 'delete_book=' + id;
			
					$.ajax({
					   type: "POST",
					   url: "/tcom/ajax/ajax.php",
					   data: dataString,
					   cache: false,
					
					   beforeSend: function()
					   {
					 
					   }, 
					   success: function(response)
					   {			 
						   if(response.trim() == "true") {
						  		alert("Book is deleted!");
								refreshElements(1);		
						   }	
						   else
						   {
						   	    alert("Book is not deleted!");
						   }
					   }
					   
					 });
					
					return false;
				}
			 
	  });
 	});
	/* Brisanje knjige - Kraj */
	
    /* Nova knjiga - Pocetak */
	$(function() { 
	  $(document).on("click","#new", function () {
				
			$('#id').val("");
			
			$('#book-form').dialog('option', 'title', 'New book');
			
			/* Dugme za cuvanje */
			$('.ui-dialog-buttonpane').
				find('button:contains("Save")').button({
				icons: {
					primary: 'icon_save'
				}
			});
			/* Dugme za povratak */
			$('.ui-dialog-buttonpane').
				find('button:contains("Back")').button({
				icons: {
					primary: 'back_icon'
				}
			});
				 
			$( "#book-form" ).dialog( "open" ); 
			 
	    });
 	});
	/* Nova knjiga - Kraj */
	
	
	/* Forma za dodavanje/izmenu - Pocetak */
	$(function() {  
	 $( "#book-form" ).dialog({
      autoOpen: false,
      height: <?php echo FORM_H; ?>,
      width: <?php echo FORM_W; ?>,
      modal: true,
      buttons: {
         "Back": function() {	
	         $( this ).dialog( "close" );
			 resetFields();
			 
	    }, 
		"Save": function() {		 
		    var bValid   = true;
			var title    = $('#title').val();
			var author   = $('#author').val();
			var released = $('#released').val();
			var image    = $('#image').val();
			var id       = $('#id').val();
         
			if( title == "" )  
			{
			  alert("Title is required field!");
			  document.getElementById("title").focus();
			  bValid = false;
			  $('#title').addClass('selektovano_polje');
			  return false;
			}
			
			if( author == "" )  
			{
			  alert("Author is required field!");
			  document.getElementById("author").focus();
			  bValid = false;
			  $('#author').addClass('selektovano_polje');
			  return false;
			}
			
			if( released == "" )  
			{
			  alert("Released is required field!");
			  document.getElementById("released").focus();
			  bValid = false;
			  $('#released').addClass('selektovano_polje');
			  return false;
			}
			
			if(( image== "" ) && (!( id > 0 ))) 
			{
			  alert("Image is required field!");
			  document.getElementById("image").focus();
			  bValid = false;
			  $('#image').addClass('selektovano_polje');
			  return false;
			}
			
            if ( bValid ) {
		    var formData = new FormData($("#book-form-f")[0]);
			 
		  
		    $.ajax({
                    
                    url: "/tcom/ajax/ajax.php",
                    type: 'POST',
					data: formData,
					async: false,
					beforeSend: function() 
					{
						$("#progress").show();
						$("#bar").width('0%');
						$("#message").html("");
						$("#percent").html("0%");
					},
					
					uploadProgress: function(event, position, total, percentComplete) 
					{
						$("#bar").width(percentComplete+'%');
						$("#percent").html(percentComplete+'%');
					},
					
                    success: function (response) {
					   
					   if(response.trim() == "true") {
						   $("#bar").width('100%');
						   $("#percent").html('100%');
						   
						   if(id > 0) alert("Book is edit!");
						   else alert("Book is added!");
						   
						   $("#book-form").dialog( "close" );						   
						   resetFields();
						   refreshElements();
					   }
					   else
					   {
						   alert(response);
					   }
					   
                    },
					complete: function(response) 
					{
					   
					},
					error: function()
					{
						if(id > 0) alert("Error! Book is not edit!");
						else alert("Error! Book is not added!");
					},
					cache: false,
					contentType: false,
					processData: false
					
                });
			   
				return false;
          }
		  
		 $( this ).dialog( "close" );
		 } 
      },
	  
      close: function() {
        resetFields();
      }
    });

 	}); 
	/* Forma za dodavanje/izmenu - Kraj */
 
    /* Polje za prikaz ucitavanja - Pocetak */
    $(function() {  
	function showProgress(evt) {
    if (evt.lengthComputable) {
			var percentComplete = (evt.loaded / evt.total) * 100;
			$('#progresss').progressbar("option", "value", percentComplete );
			}  
		}
	});  	 
	/* Polje za prikaz ucitavanja - Kraj */ 
	
</script>