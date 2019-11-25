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

namespace Emi\FileUpload;

class Upload
{
	private $hasUploaded = false;
	private $hasUploadFailure = false;

	private $files = array();

	private $failedFiles = array();

	private $failedExtensionFiles = array();
	private $failedHTMLSizeFiles = array();
	private $failedPartialFiles = array();
	private $failedPHPSizeFiles = array();
	private $failedWriteFiles = array();

	public function __construct(array $upload, bool $keepEmptyFiles = true)
	{
		for ($i = 0, $size = count($upload['name']); $i < $size; ++$i)
		{
			switch ($upload['error'][$i])
			{
				case UPLOAD_ERR_OK:
					// One or more files were successfully uploaded.

					$this->hasUploaded = true;

					$this->files[] = new File($upload['name'][$i], $upload['type'][$i], $upload['size'][$i], $upload['tmp_name'][$i]);

					break;
				case UPLOAD_ERR_INI_SIZE:
					// One or more files violated the PHP configuration size constraint.

					$this->hasUploaded = true;
					$this->hasUploadFailure = true;

					$this->failedFiles[] = $upload['name'][$i];
					$this->failedPHPSizeFiles[] = $upload['name'][$i];

					break;
				case UPLOAD_ERR_FORM_SIZE:
					// One or more files violated the HTML form size constraint.

					$this->hasUploaded = true;
					$this->hasUploadFailure = true;

					$this->failedFiles[] = $upload['name'][$i];
					$this->failedHTMLSizeFiles[] = $upload['name'][$i];

					break;
				case UPLOAD_ERR_PARTIAL:
					// One or more files were partially uploaded. Other files might have been fully uploaded.

					$this->hasUploaded = true;
					$this->hasUploadFailure = true;

					$this->failedFiles[] = $upload['name'][$i];
					$this->failedPartialFiles[] = $upload['name'][$i];

					break;
				case UPLOAD_ERR_NO_FILE:
					// No attempt was made to upload files.

					break;
				case UPLOAD_ERR_NO_TMP_DIR:
					// No temporary directory exists. This is a fatal error.

					throw new NoTemporaryDirectoryException('There is no temporary directory to which PHP can upload files.');

					break;
				case UPLOAD_ERR_CANT_WRITE:
					// One or more files couldn't be written to storage medium. Other files might have been successfully written.

					$this->hasUploaded = true;
					$this->hasUploadFailure = true;

					$this->failedFiles[] = $upload['name'][$i];
					$this->failedWriteFiles[] = $upload['name'][$i];

					break;
				case UPLOAD_ERR_EXTENSION:
					// One or more files were stopped by an extension. Other files might have been successfully uploaded.

					$this->hasUploaded = true;
					$this->hasUploadFailure = true;

					$this->failedFiles[] = $upload['name'][$i];
					$this->failedExtensionFiles[] = $upload['name'][$i];

					break;
				default:
					// One or more files resulted in an unknown error code. This is a fatal error.

					throw new UnknownErrorCodeException("The uploading of the file \"{$upload['name'][$i]}\" resulted in the error code \"{$upload['error'][$i]}\" which is unknown to eMI FileUpload Library.");
			}
		}

		if (!$keepEmptyFiles)
		{
			RemoveEmptyFiles();
		}
	}

	public function GetEmptyFiles() : array
	{
		if ($this->hasUploaded)
		{
			$emptyFiles = array();

			foreach ($this->files as $file)
			{
				if ($file->GetSize() == 0)
				{
					$emptyFiles[] = $file;
				}
			}

			return $emptyFiles;
		}
		else
		{
			throw new NoFilesUploadedException("No files have been uploaded. The method \"GetEmptyFiles\" can not be called.");
		}
	}

	public function GetFailedFiles(int $filter = null) : array
	{
		if ($this->hasUploaded)
		{
			if ($filter === null)
			{
				return $this->failedFiles;
			}
			else
			{
				switch ($filter)
				{
					case UPLOAD_ERR_INI_SIZE:
						return $this->failedPHPSizeFiles;

						break;
					case UPLOAD_ERR_FORM_SIZE:
						return $this->failedHTMLSizeFiles;

						break;
					case UPLOAD_ERR_PARTIAL:
						return $this->failedPartialFiles;

						break;
					case UPLOAD_ERR_CANT_WRITE:
						return $this->failedWriteFiles;

						break;
					case UPLOAD_ERR_EXTENSION:
						return $this->failedExtensionFiles;

						break;
					default:
						throw new InvalidErrorCodeException("The error code provided as a filter to the \"GetFailedFiles\" method is invalid.");

						break;
				}
			}
		}
		else
		{
			throw new NoFilesUploadedException("No files have been uploaded. The method \"GetFailedFiles\" can not be called.");
		}
	}

	public function GetFiles() : array
	{
		if ($this->hasUploaded)
		{
			return $this->files;
		}
		else
		{
			throw new NoFilesUploadedException("No files have been uploaded. The method \"GetFiles\" can not be called.");
		}
	}

	public function GetHasUploaded() : bool
	{
		return $this->hasUploaded;
	}

	public function GetHasUploadFailure() : bool
	{
		return $this->hasUploadFailure;
	}

	public function GetNonemptyFiles() : array
	{
		if ($this->hasUploaded)
		{
			$nonemptyFiles = array();

			foreach ($this->files as $file)
			{
				if ($file->GetSize() > 0)
				{
					$nonemptyFiles[] = $file;
				}
			}

			return $nonemptyFiles;
		}
		else
		{
			throw new NoFilesUploadedException("No files have been uploaded. The method \"GetNonemptyFiles\" can not be called.");
		}
	}

	public function Move(string $destination) : bool
	{
		if ($this->hasUploaded)
		{
			$moved = true;

			foreach ($this->files as $key => $file)
			{
				if (!$file->Move($destination))
				{
					$moved = false;
				}
				else
				{
					unset($this->files[$key]);
				}
			}

			return $moved;
		}
		else
		{
			throw new NoFilesUploadedException("No files have been uploaded. The method \"Move\" can not be called.");
		}
	}

	public function RemoveEmptyFiles() : void
	{
		if ($this->hasUploaded)
		{
			foreach ($this->files as $key => $file)
			{
				if ($file->GetSize() === 0)
				{
					unset($this->files[$key]);
				}
			}
		}
		else
		{
			throw new NoFilesUploadedException("No files have been uploaded. The method \"RemoveEmptyFiles\" can not be called.");
		}
	}
}
?>