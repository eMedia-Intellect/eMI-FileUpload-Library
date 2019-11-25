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

require_once '../Library/inclusion.php';

$Output = '';
$Indentation = "\t\t";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formSubmission']))
{
	$Output .= $Indentation . "<h2>Before removal/moving</h2>\n";

	$Upload = new Emi\FileUpload\Upload($_FILES['formFiles']);

	require_once 'overview-upload.php';

	if ($Upload->GetHasUploaded())
	{
		$Output .= $Indentation . "<br/>\n";

		require_once 'overview-php-errors.php';

		$Output .= $Indentation . "<br/>\n";

		require_once 'overview-files.php';

		$Output .= $Indentation . "<br/>\n";

		require 'list-files.php';

		if (isset($_POST['formRemove']))
		{
			$Output .= $Indentation . "<h2>After removal</h2>\n";

			$Upload->RemoveEmptyFiles();

			require 'list-files.php';
		}

		if (isset($_POST['formMove']))
		{
			$Upload->Move($_POST['formDestination']);

			if (empty($Upload->GetFiles()))
			{
				$Output .= $Indentation . "<h2>After moving</h2>\n";

				require_once 'list-moving-failures.php';
			}
		}
	}
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-GB">
	<head>
		<link href="favicon.ico" media="all" rel="icon" type="image/x-icon"/>
		<link href="common.css" media="all" rel="stylesheet" type="text/css"/>
		<meta charset="UTF-8"/>
		<title>Testing</title>
	</head>
	<body>
		<h1>Testing</h1>
		<form accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" method="post">
			<label for="FormFiles">Files:</label>
			<br/>
			<br/>
			<input id="FormFiles" multiple="multiple" name="formFiles[]" type="file"/>
			<br/>
			<br/>
			<label>Actions:</label>
			<br/>
			<br/>
			<input id="FormRemove" name="formRemove" type="checkbox"/><label for="FormRemove">Remove empty files</label>
			<input id="FormMove" name="formMove" type="checkbox"/><label for="FormMove">Move files</label>
			<br/>
			<br/>
			<label for="FormDestination">Destination:</label>
			<br/>
			<br/>
			<input id="FormDestination" name="formDestination" type="text" value="/var/tmp/php/Uploads"/>
			<br/>
			<br/>
			<input name="formSubmission" type="submit" value="Submit"/>
		</form>
<?php echo $Output; ?>
	</body>
</html>