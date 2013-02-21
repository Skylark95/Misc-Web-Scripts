<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
.formLine {
	padding: 5px;
	margin-bottom: 5px;
}
</style>
<script type="text/javascript">

	function process() {
		var searchText = "<?php echo $_GET["searchText"]?>";
		var keyword = "<?php echo $_GET["keyword"]?>";
		var spaces = "<?php echo $_GET["spaces"]?>";
	
		if (searchText.length > 0) {
			getAnswer(searchText, keyword, spaces);
		}
	}
	
	function getAnswer(searchText, keyword, spaces) {				
		if (keyword.length == 0) {
			document.getElementById('answer').innerHTML = "Length of search text: " + searchText.length; 
		} else {
			document.getElementById('answer').innerHTML = "Occurrences of '" + keyword + "': " + countKeyword(searchText, keyword, spaces)
		}			
	}
	
	function countKeyword(searchText, keyword, spaces) {
		var count = 0;
		
		if (spaces == "on") {
			count = getSpacesCount(searchText, keyword);	
		} else {
			count = getNoSpacesCount(searchText, keyword);
		}	
		
		return count;
	}
	
	function getSpacesCount(searchText, keyword) {
		var count = 0;
		
		if (keyword == searchText) {
			count++;
		} else if (keyword.length < searchText.length) {
			count = getNoSpacesCount(searchText, " " + keyword + " ");
			
			if (searchText.substring(0, keyword.length + 1) == keyword + " ") {
				count++;
			}
			if (searchText.substring(searchText.length - keyword.length - 1) == " " + keyword) {
				count++;
			} 
		}		
		
		return count;
	}
	
	function getNoSpacesCount(searchText, keyword) {
		var count = 0;
		
		for(var i = 0; i + keyword.length <= searchText.length; i++) {
			if (searchText.substring(i, keyword.length + i) == keyword) {
				count++;
			}
		}
		
		return count;
	}	
</script>
<title>JavaScript Word Count</title>
</head>
<body style="padding-top: 10px;" onload="return process()">
	<form name="input" method="get" action="jswordcount.php">
		<div class="formLine">
			<div>Text To Search:</div>
			<textarea name="searchText" rows="10" cols="50"><?php echo $_GET["searchText"]?></textarea>
		</div>
		<div class="formLine">
			Text to Count: <input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>"/>
			<div style="font-size: .8em; font-style: italic; color: red;">Counts length of search text if left empty.</div>
		</div>
		<div class="formLine">		
		<input type="checkbox" name="spaces" <?php if($_GET["spaces"] == "on") echo 'checked="checked"' ?>/>
		Require Space Before/After words</div>
		<div class="formLine">
			<input type="submit" value="Submit"/>
			<span id="answer" style="padding-left: 10px; font-weight: bold;"></span>
		</div>		
	</form>
</body>
</html>