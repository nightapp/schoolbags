<%@ Page language="c#" AutoEventWireup="false" %>

<html>
<head>
	<link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<table><tr><td>
<b>If you see this page, ASP.NET <%=Environment.Version.ToString()%> works properly.</b>

</td></tr><tr><td>

<h3 align="center">Environment variables</h3>
<div class="listContentArea">
<table class="listContentLayout" collspan="0" cellspan="0" border="0" width="100%">
<tr class="listHeaders"><th>Name</th><th>Value</th></tr>
<%
	int cnt = 0;
	string class_name;
	foreach(System.Collections.DictionaryEntry de in Environment.GetEnvironmentVariables())
	{
		++cnt;
		class_name = (cnt%2 == 0)? "evenrow" : "oddrow";
		Response.Write(String.Format("<tr class='{0}'><td>{1}</td><td>{2}</td></tr>", class_name, de.Key, de.Value));
	}
%>
</table>
</div>

</td></tr></table>
</body>
</html>