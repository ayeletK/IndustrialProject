<script>
	public function show()
	{
	var p = document.getElementById('pwd');
	p.setAttribute('type','text');  
	}

	public function hide()
	{
	   var p = document.getElementById('pwd');
	p.setAttribute('type','password');   
	}

	public function showHide()
	{
		var pwShown = 0;
		alt("hello");
	document.getElementById("eye").addEventListener("click", function() {
		if (pwShown == 0) 
		{
			pwShown = 1; 
			show();
		} 
		else {
			pwShow = 0;
			hide();
		}
				}, false);

	}
</script>