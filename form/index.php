<div id="book-form" title="New/Edit Book">
	<div id="book-form-s">		
		<form id="book-form-f" method="post"> 
			<input type="hidden" name="id" id="id" />
			<div class="forma_prostor">Title:<br /><input type="text" name="title" id="title" class="polje sirina_velika" /></div>
			<div class="forma_prostor">Author:<br /><input type="text" name="author" id="author" class="polje sirina_velika" /></div>
			<div class="forma_prostor">Released:<br /><input type="text" name="released" id="released" class="polje sirina_srednja" /></div>
			<div class="forma_prostor">Image:<br /><input name="image" type="file" id="image" class="polje sirina_velika" maxlength="255" /></div>
		</form>
		<div id="progress" class="align-center">
			<div id="bar"></div>
			<div id="percent">0%</div >
		</div>
		<div id="message"></div>
	</div>
</div>
