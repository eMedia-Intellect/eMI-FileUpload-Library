<?php
/*
Copyright © 2016, 2018 eMedia Intellect.

This file is part of eMI FileUpload Library.

eMI FileUpload Library is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

eMI FileUpload Library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with eMI FileUpload Library. If not, see <http://www.gnu.org/licenses/>.
*/

if (basename($_SERVER['SCRIPT_FILENAME']) === 'list-moving-failures.php')
{
	exit('This file can not be directly executed but only included.');
}

if (!empty($Upload->GetFiles()))
{
	$Output .= $Indentation . "<table>\n";
	$Output .= $Indentation . "	<caption>List of move failures</caption>\n";

	$Output .= $Indentation . "	<thead>\n";

	$Output .= $Indentation . "		<tr>\n";
	$Output .= $Indentation . "			<th>Name</th>\n";
	$Output .= $Indentation . "			<th>TemporaryName</th>\n";
	$Output .= $Indentation . "			<th>Type</th>\n";
	$Output .= $Indentation . "			<th>Size</th>\n";
	$Output .= $Indentation . "		</tr>\n";

	$Output .= $Indentation . "	</thead>\n";

	$Output .= $Indentation . "	<tbody>\n";

	foreach ($Upload->GetFiles() as $file)
	{
		$Output .= $Indentation . "		<tr>\n";

		$Output .= $Indentation . '			<td>' . $file->GetName() . "</td>\n";
		$Output .= $Indentation . '			<td>' . $file->GetTemporaryName() . "</td>\n";
		$Output .= $Indentation . '			<td>' . $file->GetMediaType() . "</td>\n";
		$Output .= $Indentation . '			<td>' . $file->GetSize() . "</td>\n";

		$Output .= $Indentation . "		</tr>\n";
	}

	$Output .= $Indentation . "	</tbody>\n";

	$Output .= $Indentation . "</table>\n";
}
?>