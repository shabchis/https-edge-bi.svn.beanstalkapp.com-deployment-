<%@ Page Language="C#" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Edge Web Tools</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript">
        function showNested()
        {            
            var thresh = document.getElementById('changeNameSons');
            if(thresh.style.display == 'none')
            {
                thresh.style.display = '';
            }
            else
            {
                thresh.style.display = 'none';
            }
            //return false;
        }
  </script>
</head>
<body>
	<h3>Custom Tools</h3>

	<ul>
		<li><a href="EasyForexMDX.aspx">Easy Forex Weekly Report</a></li>
		
	</ul>

</body>
</html>
