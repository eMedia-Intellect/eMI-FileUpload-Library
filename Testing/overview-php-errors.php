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

if (basename($_SERVER['SCRIPT_FILENAME']) === 'overview-php-errors.php')
{
	exit('This file can not be directly executed but only included.');
}

$Output .= $Indentation . "<table>\n";
$Output .= $Indentation . "	<caption>Overview of PHP errors</caption>\n";

$Output .= $Indentation . "	<tr>\n";
$Output .= $Indentation . "		<th>GetFailedFiles(UPLOAD_ERR_CANT_WRITE):</th>\n";
$Output .= $Indentation . '		<td>' . count($Upload->GetFailedFiles(UPLOAD_ERR_CANT_WRITE)) . "</td>\n";
$Output .= $Indentation . "	</tr>\n";

$Output .= $Indentation . "	<tr>\n";
$Output .= $Indentation . "		<th>GetFailedFiles(UPLOAD_ERR_EXTENSION):</th>\n";
$Output .= $Indentation . '		<td>' . count($Upload->GetFailedFiles(UPLOAD_ERR_EXTENSION)) . "</td>\n";
$Output .= $Indentation . "	</tr>\n";

$Output .= $Indentation . "	<tr>\n";
$Output .= $Indentation . "		<th>GetFailedFiles(UPLOAD_ERR_FORM_SIZE):</th>\n";
$Output .= $Indentation . '		<td>' . count($Upload->GetFailedFiles(UPLOAD_ERR_FORM_SIZE)) . "</td>\n";
$Output .= $Indentation . "	</tr>\n";

$Output .= $Indentation . "	<tr>\n";
$Output .= $Indentation . "		<th>GetFailedFiles(UPLOAD_ERR_INI_SIZE):</th>\n";
$Output .= $Indentation . '		<td>' . count($Upload->GetFailedFiles(UPLOAD_ERR_INI_SIZE)) . "</td>\n";
$Output .= $Indentation . "	</tr>\n";

$Output .= $Indentation . "	<tr>\n";
$Output .= $Indentation . "		<th>GetFailedFiles(UPLOAD_ERR_PARTIAL):</th>\n";
$Output .= $Indentation . '		<td>' . count($Upload->GetFailedFiles(UPLOAD_ERR_PARTIAL)) . "</td>\n";
$Output .= $Indentation . "	</tr>\n";

$Output .= $Indentation . "	<tr>\n";
$Output .= $Indentation . "		<th>GetFailedFiles():</th>\n";
$Output .= $Indentation . '		<td>' . count($Upload->GetFailedFiles()) . "</td>\n";
$Output .= $Indentation . "	</tr>\n";

$Output .= $Indentation . "</table>\n";
?>