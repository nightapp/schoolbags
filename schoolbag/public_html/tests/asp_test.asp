<%@ EnableSessionState=False LANGUAGE=VBScript %>

<html>
<head>
	<link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>

<table><tr><td>
<b>If you see this page, ASP page works properly.</b>

</td></tr><tr><td>

<h3 align="center">Environment variables</h3>
<div class="listContentArea">
<table class="listContentLayout" collspan="0" cellspan="0" border="0" width="100%">
<tr class="listHeaders"><th>Name</th><th>Value</th></tr>
<%
	cnt = 0
	For Each var in Request.ServerVariables
		cnt = cnt + 1
		If cnt mod 2 = 0 Then class_name = "evenrow" Else class_name = "oddrow"
		Response.Write "<tr class='" & class_name & "'><td>" & var & "</td><td>" & Request.ServerVariables(var) & "</td></tr>"
	Next
%>
</table>
</div>

</td></tr></table>

</body>
</html>