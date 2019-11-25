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

require_once '../../../Library/inclusion.php';

$Output = '';
$Indentation = "\t\t";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formSubmission']))
{
	$Output .= $Indentation . "<hr/>\n";

	$Upload = new Emi\FileUpload\Upload($_FILES['formFiles']);

	if ($Upload->GetHasUploaded())
	{
		if ($Upload->GetFiles() !== null)
		{
			foreach ($Upload->GetFiles() as $file)
			{
				$Output .= $Indentation . '<p>' . $file->GetTemporaryName() . "</p>\n";
			}
		}
		else
		{
			$Output .= $Indentation . "<p>One or more files were unsuccessfully uploaded!</p>\n";
		}
	}
	else
	{
		$Output .= $Indentation . "<p>No attempt was made to upload files!</p>\n";
	}
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-GB">
	<head>
		<link href="../../favicon.ico" media="all" rel="icon" type="image/x-icon"/>
		<meta charset="UTF-8"/>
		<title>Examples – eMI PHP FileUpload Library</title>
	</head>
	<body>
		<h1>Examples</h1>
		<form accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" method="post">
			<input multiple="multiple" name="formFiles[]" type="file"/>
			<br/>
			<br/>
			<input name="formSubmission" type="submit" value="Submit"/>
		</form>
<?php echo $Output; ?>
	</body>
</html>