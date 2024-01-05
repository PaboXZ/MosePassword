function closePasswordWindow()
		{
			document.getElementById('show-password-container').style.cssText='display: none';
		}
		function openPasswordWindow(siteName)
		{
			document.getElementById("show-box-name").innerHTML = siteName + ":";
			
			var divSiteName = document.getElementById('hidden-password-for-' + siteName).innerHTML;
			document.getElementById("show-box-password").innerHTML = divSiteName;
			
			document.getElementById('show-password-container').style.cssText='display: block';
		}
		function copyFromShowBox()
		{
			 navigator.clipboard.writeText(document.getElementById("show-box-password").innerHTML);
			 alert("Copied password!");
		}
		function copyFromSiteTile(siteName)
		{
			navigator.clipboard.writeText(document.getElementById("hidden-password-for-" + siteName).innerHTML);
			alert("Copied Password!");
		}