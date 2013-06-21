use ExtUtils::Installed;
my ($inst) = ExtUtils::Installed->new();
my (@modules) = $inst->modules();
print "Content-type: text/html", "\n\n";
print <<END_of_Multiline_Text;
	<html>\n<head><link href="styles.css" type="text/css" rel="stylesheet"></head>\n<body>

<table align="center"><tr><td>
<b>If you see this page, Active Perl page works properly.</b>
</td></tr><tr><td>
<h3 align="center">Installed modules</h3>
<div class="listContentArea">
<table class="listContentLayout" collspan="0" cellspan="0" border="0" width="100%">
<tr class="listHeaders"><th>Name</th><th>Value</th></tr>
END_of_Multiline_Text

for (my $i=0; $i<scalar(@modules); $i++) {
   my $version = $inst->version($modules[$i]) || "???";
   my $class = ($i % 2) ? "alt" : "normal";
   print "<tr class=$class><td valign=top>$modules[$i]</td>\n";
   print "<td valign=top align=right class=alt>$version</td></tr>\n";
}

print "</table></div></td></tr></table></body></html>";
